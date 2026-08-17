<?php

class Equipment
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $sql = "SELECT equipments.*, categories.nom AS categorie_nom
                FROM equipments
                INNER JOIN categories
                ON equipments.categorie_id = categories.id
                ORDER BY equipments.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add(
        $nom,
        $description,
        $prix_jour,
        $stock,
        $seuil_alerte,
        $etat,
        $categorie_id
    ) {
        $sql = "INSERT INTO equipments
                (nom, description, prix_jour, stock, seuil_alerte, etat, categorie_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $nom,
            $description,
            $prix_jour,
            $stock,
            $seuil_alerte,
            $etat,
            $categorie_id
        ]);
    }

    public function getById($id)
    {
        $sql = "SELECT equipments.*, categories.nom AS categorie_nom
                FROM equipments
                INNER JOIN categories
                ON equipments.categorie_id = categories.id
                WHERE equipments.id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(
        $id,
        $nom,
        $description,
        $prix_jour,
        $stock,
        $seuil_alerte,
        $etat,
        $categorie_id
    ) {
        $sql = "UPDATE equipments
                SET nom = ?,
                    description = ?,
                    prix_jour = ?,
                    stock = ?,
                    seuil_alerte = ?,
                    etat = ?,
                    categorie_id = ?
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $nom,
            $description,
            $prix_jour,
            $stock,
            $seuil_alerte,
            $etat,
            $categorie_id,
            $id
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM equipments WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function search($mot)
    {
        $sql = "SELECT equipments.*, categories.nom AS categorie_nom
                FROM equipments
                INNER JOIN categories
                ON equipments.categorie_id = categories.id
                WHERE equipments.nom LIKE ?
                OR equipments.description LIKE ?
                OR categories.nom LIKE ?
                ORDER BY equipments.id DESC";

        $stmt = $this->pdo->prepare($sql);

        $mot = "%" . $mot . "%";

        $stmt->execute([
            $mot,
            $mot,
            $mot
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}