<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nom = $_SESSION['nom'] ?? '';
$prenom = $_SESSION['prenom'] ?? '';
$role = $_SESSION['role'] ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tableau de bord</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        header {
            background: #333;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        .logout {
            color: white;
            text-decoration: none;
            background: #d9534f;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        .welcome {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .welcome h2 {
            margin-top: 0;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .card h3 {
            margin-top: 0;
        }

        .card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .role {
            font-weight: bold;
        }
    </style>
</head>

<body>

<header>
    <h1>EquipmentRental</h1>

    <a class="logout" href="index.php?action=logout">
        Déconnexion
    </a>
</header>

<div class="container">

    <div class="welcome">
        <h2>
            Bienvenue <?= htmlspecialchars($prenom . ' ' . $nom) ?> 👋
        </h2>

        <p>
            Votre rôle :
            <span class="role">
                <?= htmlspecialchars($role) ?>
            </span>
        </p>
    </div>

    <div class="cards">

        <?php if ($role === 'responsable_inventaire'): ?>

            <div class="card">
                <h3>Catégories</h3>
                <p>Gérer les catégories d'équipements.</p>
                <a href="index.php?action=category_list">
                    Gérer
                </a>
            </div>

            <div class="card">
                <h3>Équipements</h3>
                <p>Gérer le catalogue et le stock.</p>
                <a href="index.php?action=equipment_list">
                    Gérer
                </a>
            </div>

            <div class="card">
                <h3>Utilisateurs</h3>
                <p>Gérer les utilisateurs du système.</p>
                <a href="index.php?action=user_list">
                    Gérer
                </a>
            </div>

        <?php elseif ($role === 'agent_location'): ?>

            <div class="card">
                <h3>Locations</h3>
                <p>Gérer les demandes de location.</p>
                <a href="index.php?action=rental_list">
                    Gérer
                </a>
            </div>

        <?php elseif ($role === 'client'): ?>

    <div class="card">
        <h3>Catalogue</h3>
        <p>Consulter les équipements disponibles.</p>

        <a href="index.php?action=client_catalogue">
            Voir le catalogue
        </a>
    </div>

    <div class="card">
        <h3>Mes locations</h3>
        <p>Suivre vos demandes de location.</p>

        <a href="index.php?action=client_rental_list">
            Voir mes locations
        </a>
    </div>

<?php endif; ?>

    </div>

</div>

</body>
</html>