<?php

class Rental
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Afficher toutes les locations (JOIN client + équipement)
    public function getAll()
    {
        $sql = "SELECT rentals.*,
                       users.nom AS client_nom,
                       users.prenom AS client_prenom,
                       equipments.nom AS equipment_nom
                FROM rentals
                INNER JOIN users ON rentals.user_id = users.id
                INNER JOIN equipments ON rentals.equipment_id = equipments.id
                ORDER BY rentals.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une location par son ID (JOIN aussi, utile pour edit)
    public function getById($id)
    {
        $sql = "SELECT rentals.*,
                       users.nom AS client_nom,
                       users.prenom AS client_prenom,
                       equipments.nom AS equipment_nom
                FROM rentals
                INNER JOIN users ON rentals.user_id = users.id
                INNER JOIN equipments ON rentals.equipment_id = equipments.id
                WHERE rentals.id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vérifier si l'équipement est disponible sur une période donnée
    // (on ignore les locations annulées ou terminées)
    // $exclude_id sert à ignorer la location elle-même quand on modifie
    public function isAvailable($equipment_id, $date_debut, $date_fin, $exclude_id = null)
    {
        $sql = "SELECT COUNT(*) AS nb
                FROM rentals
                WHERE equipment_id = ?
                  AND statut IN ('en_attente', 'confirmee', 'en_cours')
                  AND date_debut <= ?
                  AND date_fin >= ?";

        $params = [$equipment_id, $date_fin, $date_debut];

        if ($exclude_id) {
            $sql .= " AND id != ?";
            $params[] = $exclude_id;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result["nb"] == 0;
    }

    // Ajouter une location
    public function add(
        $user_id,
        $equipment_id,
        $date_debut,
        $date_fin,
        $duree,
        $prix_jour,
        $prix_total,
        $statut
    ) {
        $sql = "INSERT INTO rentals
                (user_id, equipment_id, date_debut, date_fin, duree,
                 prix_jour, prix_total, statut, frais_additionnels, date_creation)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, NOW())";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $user_id,
            $equipment_id,
            $date_debut,
            $date_fin,
            $duree,
            $prix_jour,
            $prix_total,
            $statut
        ]);
    }

    // Modifier une location (dates, statut, retour, frais additionnels)
    public function update(
        $id,
        $date_debut,
        $date_fin,
        $duree,
        $prix_total,
        $statut,
        $frais_additionnels,
        $date_retour
    ) {
        $sql = "UPDATE rentals
                SET date_debut = ?,
                    date_fin = ?,
                    duree = ?,
                    prix_total = ?,
                    statut = ?,
                    frais_additionnels = ?,
                    date_retour = ?
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $date_debut,
            $date_fin,
            $duree,
            $prix_total,
            $statut,
            $frais_additionnels,
            $date_retour,
            $id
        ]);
    }

    // Supprimer une location
    public function delete($id)
    {
        $sql = "DELETE FROM rentals WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }
}