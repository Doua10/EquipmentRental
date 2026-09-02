<?php

class Equipment
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Afficher tous les équipements avec leur catégorie
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

    // Ajouter un équipement
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

    // Récupérer un équipement par son ID
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

    // Modifier un équipement
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

    // Supprimer un équipement
    public function delete($id)
    {
        $sql = "DELETE FROM equipments WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }

    // Changer uniquement l'état
    // Utilisé notamment par le module Rental
    public function updateEtat($id, $etat)
    {
        $sql = "UPDATE equipments
                SET etat = ?
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $etat,
            $id
        ]);
    }

    // Recherche multicritères avec JOIN sur la catégorie
    public function search($criteres = [])
    {
        $sql = "SELECT equipments.*, categories.nom AS categorie_nom
                FROM equipments
                INNER JOIN categories
                ON equipments.categorie_id = categories.id
                WHERE 1=1";

        $params = [];

        // Récupération sécurisée des critères
        $mot = trim($criteres['mot'] ?? '');
        $categorie_id = $criteres['categorie_id'] ?? '';
        $etat = $criteres['etat'] ?? '';
        $prix_min = $criteres['prix_min'] ?? '';
        $prix_max = $criteres['prix_max'] ?? '';
        $stock_min = $criteres['stock_min'] ?? '';
        $stock_max = $criteres['stock_max'] ?? '';

        // Recherche par mot-clé
        // Recherche dans :
        // - nom de l'équipement
        // - description
        // - nom de la catégorie
        if ($mot !== '') {

            $sql .= " AND (
                        equipments.nom LIKE :mot
                        OR equipments.description LIKE :mot
                        OR categories.nom LIKE :mot
                      )";

            $params[':mot'] = '%' . $mot . '%';
        }

        // Filtre par catégorie
        if ($categorie_id !== '') {

            $sql .= " AND equipments.categorie_id = :categorie_id";

            $params[':categorie_id'] = $categorie_id;
        }

        // Filtre par état
        if ($etat !== '') {

            $sql .= " AND equipments.etat = :etat";

            $params[':etat'] = $etat;
        }

        // Prix minimum
        if ($prix_min !== '') {

            $sql .= " AND equipments.prix_jour >= :prix_min";

            $params[':prix_min'] = $prix_min;
        }

        // Prix maximum
        if ($prix_max !== '') {

            $sql .= " AND equipments.prix_jour <= :prix_max";

            $params[':prix_max'] = $prix_max;
        }

        // Stock minimum
        if ($stock_min !== '') {

            $sql .= " AND equipments.stock >= :stock_min";

            $params[':stock_min'] = $stock_min;
        }

        // Stock maximum
        if ($stock_max !== '') {

            $sql .= " AND equipments.stock <= :stock_max";

            $params[':stock_max'] = $stock_max;
        }

        // Tri du plus récent au plus ancien
        $sql .= " ORDER BY equipments.id DESC";

        // Requête préparée PDO
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Afficher les équipements disponibles pour le client
public function getAvailable()
{
    $sql = "SELECT equipments.*, categories.nom AS categorie_nom
            FROM equipments
            INNER JOIN categories
            ON equipments.categorie_id = categories.id
            WHERE equipments.etat = 'disponible'
            AND equipments.stock > 0
            ORDER BY equipments.id DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}

