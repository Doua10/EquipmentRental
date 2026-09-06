<?php

require_once "model/Database.php";
require_once "model/Equipment.php";
require_once "model/Category.php";

class EquipmentController
{
    private $equipment;
    private $pdo;
    private $category;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();

        $this->equipment = new Equipment($this->pdo);
        $this->category = new Category($this->pdo);
    }

    // Afficher tous les équipements
    public function list()
    {
    $equipments = $this->equipment->getAll();

    // Récupérer les catégories pour le formulaire de recherche
    $categories = $this->category->getAll();

    $error = "";

    require "view/equipment/list.php";
   }
    // Ajouter un équipement
    public function add()
    {
        $categories = $this->category->getAll();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nom = trim($_POST["nom"]);
            $description = trim($_POST["description"]);
            $prix_jour = $_POST["prix_jour"];
            $stock = $_POST["stock"];
            $seuil_alerte = $_POST["seuil_alerte"];
            $etat = $_POST["etat"];
            $categorie_id = $_POST["categorie_id"];

            if (
                empty($nom) ||
                $prix_jour === "" ||
                $stock === "" ||
                $seuil_alerte === "" ||
                empty($etat) ||
                empty($categorie_id)
            ) {
                $message = "Veuillez remplir tous les champs obligatoires.";
                require "view/equipment/add.php";
                return;
            }

            if ($prix_jour <= 0) {
                $message = "Le prix doit être supérieur à 0.";
                require "view/equipment/add.php";
                return;
            }

            if ($stock < 0 || $seuil_alerte < 0) {
                $message = "Le stock et le seuil doivent être positifs.";
                require "view/equipment/add.php";
                return;
            }

            $this->equipment->add(
                $nom,
                $description,
                $prix_jour,
                $stock,
                $seuil_alerte,
                $etat,
                $categorie_id
            );

            header("Location: index.php?action=equipment_list");
            exit;
        }

        require "view/equipment/add.php";
    }

    // Modifier un équipement
    public function edit()
    {
        $id = $_GET["id"] ?? null;

        if (!$id) {
            echo "Équipement introuvable.";
            return;
        }

        $equipment = $this->equipment->getById($id);

        if (!$equipment) {
            echo "Équipement introuvable.";
            return;
        }

        $categories = $this->category->getAll();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nom = trim($_POST["nom"]);
            $description = trim($_POST["description"]);
            $prix_jour = $_POST["prix_jour"];
            $stock = $_POST["stock"];
            $seuil_alerte = $_POST["seuil_alerte"];
            $etat = $_POST["etat"];
            $categorie_id = $_POST["categorie_id"];

            if (
                empty($nom) ||
                $prix_jour === "" ||
                $stock === "" ||
                $seuil_alerte === "" ||
                empty($etat) ||
                empty($categorie_id)
            ) {
                $message = "Veuillez remplir tous les champs obligatoires.";
                require "view/equipment/edit.php";
                return;
            }

            if ($prix_jour <= 0) {
                $message = "Le prix doit être supérieur à 0.";
                require "view/equipment/edit.php";
                return;
            }

            if ($stock < 0 || $seuil_alerte < 0) {
                $message = "Le stock et le seuil doivent être positifs.";
                require "view/equipment/edit.php";
                return;
            }

            $this->equipment->update(
                $id,
                $nom,
                $description,
                $prix_jour,
                $stock,
                $seuil_alerte,
                $etat,
                $categorie_id
            );

            header("Location: index.php?action=equipment_list");
            exit;
        }

        require "view/equipment/edit.php";
    }

    // Supprimer un équipement
    public function delete()
    {
        $id = $_GET["id"] ?? null;

        if ($id) {
            $this->equipment->delete($id);
        }

        header("Location: index.php?action=equipment_list");
        exit;
    }

    // Recherche multicritères d'un équipement
    public function search()
{
    $criteres = [
        "mot" => trim($_GET["mot"] ?? ""),
        "categorie_id" => $_GET["categorie_id"] ?? "",
        "etat" => $_GET["etat"] ?? "",
        "prix_min" => $_GET["prix_min"] ?? "",
        "prix_max" => $_GET["prix_max"] ?? "",
        "stock_min" => $_GET["stock_min"] ?? "",
        "stock_max" => $_GET["stock_max"] ?? ""
    ];

    $categories = $this->category->getAll();
    $error = "";

    // Contrôles côté PHP
    if (
        $criteres["categorie_id"] !== "" &&
        !ctype_digit((string) $criteres["categorie_id"])
    ) {
        $error = "La catégorie sélectionnée est invalide.";

    } elseif (
        $criteres["etat"] !== "" &&
        !in_array($criteres["etat"], [
            "disponible",
            "en_location",
            "maintenance",
            "endommage"
        ])
    ) {
        $error = "L'état sélectionné est invalide.";

    } elseif (
        $criteres["prix_min"] !== "" &&
        (!is_numeric($criteres["prix_min"]) || $criteres["prix_min"] < 0)
    ) {
        $error = "Le prix minimum doit être un nombre positif.";

    } elseif (
        $criteres["prix_max"] !== "" &&
        (!is_numeric($criteres["prix_max"]) || $criteres["prix_max"] < 0)
    ) {
        $error = "Le prix maximum doit être un nombre positif.";

    } elseif (
        $criteres["prix_min"] !== "" &&
        $criteres["prix_max"] !== "" &&
        $criteres["prix_min"] > $criteres["prix_max"]
    ) {
        $error = "Le prix minimum ne peut pas être supérieur au prix maximum.";

    } elseif (
        $criteres["stock_min"] !== "" &&
        !ctype_digit((string) $criteres["stock_min"])
    ) {
        $error = "Le stock minimum doit être un entier positif.";

    } elseif (
        $criteres["stock_max"] !== "" &&
        !ctype_digit((string) $criteres["stock_max"])
    ) {
        $error = "Le stock maximum doit être un entier positif.";

    } elseif (
        $criteres["stock_min"] !== "" &&
        $criteres["stock_max"] !== "" &&
        $criteres["stock_min"] > $criteres["stock_max"]
    ) {
        $error = "Le stock minimum ne peut pas être supérieur au stock maximum.";
    }

    if ($error === "") {
        $equipments = $this->equipment->search($criteres);
    } else {
        $equipments = [];
    }

    require "view/equipment/list.php";
}

    // Catalogue destiné aux clients
    public function clientCatalogue()
    {
        $equipments = $this->equipment->getAvailable();

        require "view/equipment/client_catalogue.php";
    }

}