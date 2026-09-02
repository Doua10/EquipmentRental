<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Afficher tous les utilisateurs
    public function getAll()
    {
        $sql = "SELECT *
                FROM users
                ORDER BY id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un utilisateur
    public function add(
        $nom,
        $prenom,
        $email,
        $telephone,
        $mot_de_passe,
        $role
    ) {
        $sql = "INSERT INTO users
                (nom, prenom, email, telephone, mot_de_passe, role)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $nom,
            $prenom,
            $email,
            $telephone,
            $mot_de_passe,
            $role
        ]);
    }

    // Récupérer un utilisateur par son ID
    public function getById($id)
    {
        $sql = "SELECT *
                FROM users
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Modifier un utilisateur
    public function update(
        $id,
        $nom,
        $prenom,
        $email,
        $telephone,
        $mot_de_passe,
        $role
    ) {
        $sql = "UPDATE users
                SET nom = ?,
                    prenom = ?,
                    email = ?,
                    telephone = ?,
                    mot_de_passe = ?,
                    role = ?
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $nom,
            $prenom,
            $email,
            $telephone,
            $mot_de_passe,
            $role,
            $id
        ]);
    }

    // Supprimer un utilisateur
    public function delete($id)
    {
        $sql = "DELETE FROM users
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }

    // Rechercher un utilisateur
    public function search($mot)
    {
        $sql = "SELECT *
                FROM users
                WHERE nom LIKE ?
                   OR prenom LIKE ?
                   OR email LIKE ?
                   OR telephone LIKE ?
                ORDER BY id DESC";

        $stmt = $this->pdo->prepare($sql);

        $mot = "%" . $mot . "%";

        $stmt->execute([
            $mot,
            $mot,
            $mot,
            $mot
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Rechercher un utilisateur par son email
    public function getByEmail($email)
    {
        $sql = "SELECT *
            FROM users
            WHERE email = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}