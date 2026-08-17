<?php

require_once "model/Database.php";
require_once "model/Equipment.php";

class EquipmentController
{
    private $equipment;
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();

        $this->equipment = new Equipment($this->pdo);
    }

    // Afficher tous les équipements
    public function list()
    {
        $equipments = $this->equipment->getAll();

        require "view/equipment/list.php";
    }

    // Ajouter un équipement
    public function add()
    {
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

    // Rechercher un équipement
    public function search()
    {
        $mot = $_GET["mot"] ?? "";

        $equipments = $this->equipment->search($mot);

        require "view/equipment/list.php";
    }
}