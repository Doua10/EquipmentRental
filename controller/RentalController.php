<?php

require_once "model/Database.php";
require_once "model/rental.php";
require_once "model/equipment.php";
require_once "model/user.php";

class RentalController
{
    private $rental;
    private $equipment;
    private $user;
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();

        $this->rental = new Rental($this->pdo);
        $this->equipment = new Equipment($this->pdo);
        $this->user = new User($this->pdo);
    }

    // Afficher toutes les locations
    public function list()
    {
        $rentals = $this->rental->getAll();

        require "view/rental/list.php";
    }

    // Ajouter une location
    public function add()
    {
        // Listes pour les menus déroulants du formulaire
        $clients = $this->user->getAll();
        $equipments = $this->equipment->getAll();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $user_id = $_POST["user_id"] ?? "";
            $equipment_id = $_POST["equipment_id"] ?? "";
            $date_debut = trim($_POST["date_debut"] ?? "");
            $date_fin = trim($_POST["date_fin"] ?? "");

            // Vérification des champs obligatoires
            if (
                empty($user_id) ||
                empty($equipment_id) ||
                empty($date_debut) ||
                empty($date_fin)
            ) {
                $message = "Veuillez remplir tous les champs.";
                require "view/rental/add.php";
                return;
            }

            // Vérification format des dates
            $debut = DateTime::createFromFormat("Y-m-d", $date_debut);
            $fin = DateTime::createFromFormat("Y-m-d", $date_fin);

            if (!$debut || !$fin) {
                $message = "Dates invalides.";
                require "view/rental/add.php";
                return;
            }

            // La date de fin doit être après (ou égale à) la date de début
            if ($fin < $debut) {
                $message = "La date de fin doit être après la date de début.";
                require "view/rental/add.php";
                return;
            }

            // Pas de location dans le passé
            $today = new DateTime("today");
            if ($debut < $today) {
                $message = "La date de début ne peut pas être dans le passé.";
                require "view/rental/add.php";
                return;
            }

            // Calcul automatique de la durée (en jours, inclusif)
            $duree = $debut->diff($fin)->days + 1;

            // On récupère l'équipement pour avoir le prix et l'état
            $equipmentData = $this->equipment->getById($equipment_id);

            if (!$equipmentData) {
                $message = "Équipement introuvable.";
                require "view/rental/add.php";
                return;
            }

            if ($equipmentData["etat"] !== "disponible") {
                $message = "Cet équipement n'est pas disponible (état actuel : " . $equipmentData["etat"] . ").";
                require "view/rental/add.php";
                return;
            }

            // Vérification de disponibilité sur les dates demandées
            if (!$this->rental->isAvailable($equipment_id, $date_debut, $date_fin)) {
                $message = "Cet équipement est déjà réservé sur cette période.";
                require "view/rental/add.php";
                return;
            }

            // Calcul automatique du prix (tarif de l'équipement, pas saisi par l'utilisateur)
            $prix_jour = $equipmentData["prix_jour"];
            $prix_total = $prix_jour * $duree;

            // La location est directement confirmée par l'agent
            $statut = "confirmee";

            $this->rental->add(
                $user_id,
                $equipment_id,
                $date_debut,
                $date_fin,
                $duree,
                $prix_jour,
                $prix_total,
                $statut
            );

            // L'équipement passe en "en_location"
            $this->equipment->updateEtat($equipment_id, "en_location");

            header("Location: index.php?action=rental_list");
            exit;
        }

        require "view/rental/add.php";
    }

    // Modifier une location (dates, statut, retour, frais additionnels)
    public function edit()
    {
        $id = $_GET["id"] ?? null;

        if (!$id) {
            echo "Location introuvable.";
            return;
        }

        $rental = $this->rental->getById($id);

        if (!$rental) {
            echo "Location introuvable.";
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $date_debut = trim($_POST["date_debut"] ?? "");
            $date_fin = trim($_POST["date_fin"] ?? "");
            $statut = $_POST["statut"] ?? "";
            $frais_additionnels = trim($_POST["frais_additionnels"] ?? "0");
            $date_retour = trim($_POST["date_retour"] ?? "");

            $statutsValides = [
                "en_attente",
                "confirmee",
                "en_cours",
                "terminee",
                "annulee"
            ];

            if (
                empty($date_debut) ||
                empty($date_fin) ||
                empty($statut) ||
                !in_array($statut, $statutsValides)
            ) {
                $message = "Veuillez remplir correctement tous les champs.";
                require "view/rental/edit.php";
                return;
            }

            $debut = DateTime::createFromFormat("Y-m-d", $date_debut);
            $fin = DateTime::createFromFormat("Y-m-d", $date_fin);

            if (!$debut || !$fin || $fin < $debut) {
                $message = "Dates invalides.";
                require "view/rental/edit.php";
                return;
            }

            if (!is_numeric($frais_additionnels) || $frais_additionnels < 0) {
                $message = "Les frais additionnels doivent être un nombre positif.";
                require "view/rental/edit.php";
                return;
            }

            // Si on change les dates, on revérifie la disponibilité
            // (en ignorant la location actuelle)
            if (
                in_array($statut, ["en_attente", "confirmee", "en_cours"]) &&
                !$this->rental->isAvailable($rental["equipment_id"], $date_debut, $date_fin, $id)
            ) {
                $message = "L'équipement est déjà réservé sur cette période.";
                require "view/rental/edit.php";
                return;
            }

            // Recalcul automatique de la durée et du prix
            $duree = $debut->diff($fin)->days + 1;
            $prix_total = ($duree * $rental["prix_jour"]) + $frais_additionnels;

            $date_retour = empty($date_retour) ? null : $date_retour;

            $this->rental->update(
                $id,
                $date_debut,
                $date_fin,
                $duree,
                $prix_total,
                $statut,
                $frais_additionnels,
                $date_retour
            );

            // Mise à jour de l'état de l'équipement selon le nouveau statut
            if ($statut === "terminee") {
                // Retour validé : l'équipement redevient disponible
                $this->equipment->updateEtat($rental["equipment_id"], "disponible");
            } elseif ($statut === "annulee") {
                // Location annulée : l'équipement se libère
                $this->equipment->updateEtat($rental["equipment_id"], "disponible");
            } else {
                $this->equipment->updateEtat($rental["equipment_id"], "en_location");
            }

            header("Location: index.php?action=rental_list");
            exit;
        }

        require "view/rental/edit.php";
    }

    // Supprimer une location
    public function delete()
    {
        $id = $_GET["id"] ?? null;

        if ($id) {
            $rental = $this->rental->getById($id);

            if ($rental && in_array($rental["statut"], ["en_attente", "confirmee", "en_cours"])) {
                // On libère l'équipement si la location supprimée était active
                $this->equipment->updateEtat($rental["equipment_id"], "disponible");
            }

            $this->rental->delete($id);
        }

        header("Location: index.php?action=rental_list");
        exit;
    }
        // Traiter le retour d'une location
    // (validation par le Responsable Inventaire + frais additionnels par l'Agent)
    public function returnEquipment()
    {
        $id = $_GET["id"] ?? null;

        if (!$id) {
            echo "Location introuvable.";
            return;
        }

        $rental = $this->rental->getById($id);

        if (!$rental) {
            echo "Location introuvable.";
            return;
        }

        // On ne peut traiter un retour que si la location est active
        if (!in_array($rental["statut"], ["confirmee", "en_cours"])) {
            echo "Cette location n'est pas en cours, impossible de traiter un retour.";
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $etat_retour = $_POST["etat_retour"] ?? "";
            $frais_additionnels = trim($_POST["frais_additionnels"] ?? "0");
            $date_retour = trim($_POST["date_retour"] ?? "");

            // États possibles au retour, contrôlés par le Responsable Inventaire
            $etatsValides = ["disponible", "maintenance", "endommage"];

            if (empty($date_retour) || !in_array($etat_retour, $etatsValides)) {
                $message = "Veuillez remplir correctement tous les champs.";
                require "view/rental/return.php";
                return;
            }

            $retour = DateTime::createFromFormat("Y-m-d", $date_retour);
            $debut = DateTime::createFromFormat("Y-m-d", $rental["date_debut"]);

            if (!$retour || $retour < $debut) {
                $message = "La date de retour n'est pas valide.";
                require "view/rental/return.php";
                return;
            }

            if (!is_numeric($frais_additionnels) || $frais_additionnels < 0) {
                $message = "Les frais additionnels doivent être un nombre positif.";
                require "view/rental/return.php";
                return;
            }

            // Recalcul du prix total (durée initiale + frais additionnels du retour)
            $prix_total = ($rental["duree"] * $rental["prix_jour"]) + $frais_additionnels;

            $this->rental->update(
                $id,
                $rental["date_debut"],
                $rental["date_fin"],
                $rental["duree"],
                $prix_total,
                "terminee",
                $frais_additionnels,
                $date_retour
            );

            // L'état final de l'équipement dépend du contrôle du Responsable Inventaire
            // (disponible si tout va bien, maintenance ou endommagé sinon)
            $this->equipment->updateEtat($rental["equipment_id"], $etat_retour);

            header("Location: index.php?action=rental_list");
            exit;
        }

        require "view/rental/return.php";
    }

    /* =========================================================
       CÔTÉ CLIENT
       Le client fait une demande, l'agent la confirme ensuite
       ========================================================= */

    // Le client demande une location pour un équipement précis
    public function clientAdd()
    {
        $equipment_id = $_GET["equipment_id"] ?? $_POST["equipment_id"] ?? null;

        if (!$equipment_id) {
            echo "Équipement introuvable.";
            return;
        }

        $equipmentData = $this->equipment->getById($equipment_id);

        if (!$equipmentData) {
            echo "Équipement introuvable.";
            return;
        }

        $user_id = $_SESSION["user_id"];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $date_debut = trim($_POST["date_debut"] ?? "");
            $date_fin = trim($_POST["date_fin"] ?? "");

            // Vérification des champs obligatoires
            if (empty($date_debut) || empty($date_fin)) {
                $message = "Veuillez remplir tous les champs.";
                require "view/rental/client_add.php";
                return;
            }

            // Vérification format des dates
            $debut = DateTime::createFromFormat("Y-m-d", $date_debut);
            $fin = DateTime::createFromFormat("Y-m-d", $date_fin);

            if (!$debut || !$fin) {
                $message = "Dates invalides.";
                require "view/rental/client_add.php";
                return;
            }

            // La date de fin doit être après (ou égale à) la date de début
            if ($fin < $debut) {
                $message = "La date de fin doit être après la date de début.";
                require "view/rental/client_add.php";
                return;
            }

            // Pas de location dans le passé
            $today = new DateTime("today");
            if ($debut < $today) {
                $message = "La date de début ne peut pas être dans le passé.";
                require "view/rental/client_add.php";
                return;
            }

            // Calcul automatique de la durée (en jours, inclusif)
            $duree = $debut->diff($fin)->days + 1;

            if ($equipmentData["etat"] !== "disponible") {
                $message = "Cet équipement n'est pas disponible (état actuel : " . $equipmentData["etat"] . ").";
                require "view/rental/client_add.php";
                return;
            }

            // Vérification de disponibilité sur les dates demandées
            if (!$this->rental->isAvailable($equipment_id, $date_debut, $date_fin)) {
                $message = "Cet équipement est déjà réservé sur cette période.";
                require "view/rental/client_add.php";
                return;
            }

            // Calcul automatique du prix (tarif de l'équipement, pas saisi par le client)
            $prix_jour = $equipmentData["prix_jour"];
            $prix_total = $prix_jour * $duree;

            // La demande du client est en attente de validation par l'agent
            $statut = "en_attente";

            $this->rental->add(
                $user_id,
                $equipment_id,
                $date_debut,
                $date_fin,
                $duree,
                $prix_jour,
                $prix_total,
                $statut
            );

            // On réserve l'équipement le temps que l'agent traite la demande
            $this->equipment->updateEtat($equipment_id, "en_location");

            header("Location: index.php?action=client_rental_list");
            exit;
        }

        require "view/rental/client_add.php";
    }

    // Le client consulte l'historique de ses propres locations
    public function clientList()
    {
        $user_id = $_SESSION["user_id"];

        $rentals = $this->rental->getByUserId($user_id);

        require "view/rental/client_list.php";
    }
}
