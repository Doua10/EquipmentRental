<?php

require_once "model/Database.php";
require_once "model/User.php";

class UserController
{
    private $user;
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();

        $this->user = new User($this->pdo);
    }

    // Afficher tous les utilisateurs
    public function list()
    {
        $users = $this->user->getAll();

        require "view/user/list.php";
    }

    // Ajouter un utilisateur
    public function add()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nom = trim($_POST["nom"]);
            $prenom = trim($_POST["prenom"]);
            $email = trim($_POST["email"]);
            $telephone = trim($_POST["telephone"]);
            $mot_de_passe = $_POST["mot_de_passe"];
            $role = $_POST["role"];

            // Vérification des champs
            if (
                empty($nom) ||
                empty($prenom) ||
                empty($email) ||
                empty($telephone) ||
                empty($mot_de_passe) ||
                empty($role)
            ) {
                $message = "Veuillez remplir tous les champs.";
                require "view/user/add.php";
                return;
            }

            // Vérification email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = "L'adresse email n'est pas valide.";
                require "view/user/add.php";
                return;
            }

            // Vérification du rôle
            $roles = [
                "responsable_inventaire",
                "agent_location",
                "client"
            ];

            if (!in_array($role, $roles)) {
                $message = "Rôle invalide.";
                require "view/user/add.php";
                return;
            }

            // Hash du mot de passe
            $mot_de_passe = password_hash(
                $mot_de_passe,
                PASSWORD_DEFAULT
            );

            $this->user->add(
                $nom,
                $prenom,
                $email,
                $telephone,
                $mot_de_passe,
                $role
            );

            header("Location: index.php?action=user_list");
            exit;
        }

        require "view/user/add.php";
    }

    // Modifier un utilisateur
    public function edit()
    {
        $id = $_GET["id"] ?? null;

        if (!$id) {
            echo "Utilisateur introuvable.";
            return;
        }

        $user = $this->user->getById($id);

        if (!$user) {
            echo "Utilisateur introuvable.";
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nom = trim($_POST["nom"]);
            $prenom = trim($_POST["prenom"]);
            $email = trim($_POST["email"]);
            $telephone = trim($_POST["telephone"]);
            $mot_de_passe = $_POST["mot_de_passe"];
            $role = $_POST["role"];

            if (
                empty($nom) ||
                empty($prenom) ||
                empty($email) ||
                empty($telephone) ||
                empty($role)
            ) {
                $message = "Veuillez remplir tous les champs obligatoires.";
                require "view/user/edit.php";
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = "L'adresse email n'est pas valide.";
                require "view/user/edit.php";
                return;
            }

            $roles = [
                "responsable_inventaire",
                "agent_location",
                "client"
            ];

            if (!in_array($role, $roles)) {
                $message = "Rôle invalide.";
                require "view/user/edit.php";
                return;
            }

            /*
             * Si le mot de passe est vide,
             * on garde l'ancien.
             */
            if (empty($mot_de_passe)) {

                $mot_de_passe = $user["mot_de_passe"];

            } else {

                $mot_de_passe = password_hash(
                    $mot_de_passe,
                    PASSWORD_DEFAULT
                );
            }

            $this->user->update(
                $id,
                $nom,
                $prenom,
                $email,
                $telephone,
                $mot_de_passe,
                $role
            );

            header("Location: index.php?action=user_list");
            exit;
        }

        require "view/user/edit.php";
    }

    // Supprimer un utilisateur
    public function delete()
    {
        $id = $_GET["id"] ?? null;

        if ($id) {
            $this->user->delete($id);
        }

        header("Location: index.php?action=user_list");
        exit;
    }

    // Rechercher un utilisateur
    public function search()
    {
        $mot = $_GET["mot"] ?? "";

        $users = $this->user->search($mot);

        require "view/user/list.php";
    }
}