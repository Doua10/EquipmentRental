<?php

class Category
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // READ : afficher toutes les catégories
    public function getAll()
    {
        $sql = "SELECT * FROM categories ORDER BY id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // CREATE : ajouter une catégorie
    public function add($nom, $description)
    {
        $sql = "INSERT INTO categories (nom, description)
                VALUES (:nom, :description)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nom' => $nom,
            ':description' => $description
        ]);
    }

    // READ : chercher une catégorie
    public function getById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    // UPDATE : modifier une catégorie
    public function update($id, $nom, $description)
    {
        $sql = "UPDATE categories
                SET nom = :nom,
                    description = :description
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':description' => $description
        ]);
    }

    // DELETE : supprimer une catégorie
    public function delete($id)
    {
        $sql = "DELETE FROM categories WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}