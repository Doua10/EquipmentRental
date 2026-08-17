<?php

require_once __DIR__ . '/../model/Database.php';
require_once __DIR__ . '/../model/Category.php';

class CategoryController
{
    private $category;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();

        $this->category = new Category($db);
    }

    // Afficher les catégories
    public function list()
    {
        $categories = $this->category->getAll();

        require __DIR__ . '/../view/category/list.php';
    }

    // Ajouter une catégorie
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nom = trim($_POST['nom']);
            $description = trim($_POST['description']);

            if (empty($nom)) {
                $error = "Le nom est obligatoire.";
            } else {

                $this->category->add($nom, $description);

                header('Location: index.php?action=category_list');
                exit;
            }
        }

        require __DIR__ . '/../view/category/add.php';
    }

    // Modifier une catégorie
    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID manquant.");
        }

        $category = $this->category->getById($id);

        if (!$category) {
            die("Catégorie introuvable.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nom = trim($_POST['nom']);
            $description = trim($_POST['description']);

            if (empty($nom)) {
                $error = "Le nom est obligatoire.";
            } else {

                $this->category->update(
                    $id,
                    $nom,
                    $description
                );

                header('Location: index.php?action=category_list');
                exit;
            }
        }

        require __DIR__ . '/../view/category/edit.php';
    }

    // Supprimer une catégorie
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID manquant.");
        }

        $this->category->delete($id);

        header('Location: index.php?action=category_list');
        exit;
    }
}