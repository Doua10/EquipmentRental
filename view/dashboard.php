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
            font-family: "Segoe UI", Arial, sans-serif;
            background: #FFF9F3;
            color: #4B4654;
            min-height: 100vh;
        }

        header {
            background: #D8C7F0;
            color: #4B4654;

            padding: 20px 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            box-shadow: 0 4px 16px rgba(139, 111, 168, 0.12);
        }

        header h1 {
            margin: 0;
            font-size: 26px;
            color: #6F5C80;
        }

        .logout {
            color: #654B58;
            text-decoration: none;

            background: #F4C7D9;

            padding: 11px 17px;
            border-radius: 10px;

            font-weight: 600;

            transition: 0.2s;
        }

        .logout:hover {
            background: #ECB4CB;
            transform: translateY(-1px);
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        .welcome {
            background: #FFFCFA;

            padding: 30px;

            border-radius: 18px;

            margin-bottom: 30px;

            border: 1px solid #F0E3EC;

            box-shadow: 0 8px 25px rgba(130, 100, 140, 0.08);
        }

        .welcome h2 {
            margin-top: 0;
            margin-bottom: 12px;

            color: #8B6FA8;
            font-size: 28px;
        }

        .welcome p {
            margin: 0;
            font-size: 16px;
        }

        .role {
            font-weight: 700;
            color: #A8657E;
        }

        .cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
    align-items: stretch;
}

.card {
    background: #FFFCFA;
    padding: 28px 24px;
    border-radius: 18px;
    text-align: center;
    border: 1px solid #F0E3EC;
    box-shadow: 0 8px 25px rgba(130, 100, 140, 0.08);

    display: flex;
    flex-direction: column;
    justify-content: space-between;

    min-height: 280px;

    transition:
        transform 0.2s,
        box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(130, 100, 140, 0.12);
}

.card h3 {
    margin-top: 0;
    margin-bottom: 12px;
    color: #715982;
    font-size: 22px;
}

.card p {
    line-height: 1.5;
    color: #6F6378;
    flex-grow: 1;
}

.card a {
    display: inline-block;
    align-self: center;

    margin-top: 15px;
    padding: 11px 18px;

    background: #CDE8D5;
    color: #4E7358;

    text-decoration: none;
    border-radius: 10px;
    font-weight: 700;

    transition: 0.2s;
}

        .card a:hover {
            background: #BBDDC5;
            transform: translateY(-1px);
        }

        .card:nth-child(2) a {
            background: #D8C7F0;
            color: #665375;
        }

        .card:nth-child(2) a:hover {
            background: #CBB6E8;
        }

        .card:nth-child(3) a {
            background: #F4C7D9;
            color: #654B58;
        }

        .card:nth-child(3) a:hover {
            background: #ECB4CB;
        }

        @media (max-width: 700px) {

            header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
                padding: 18px;
            }

            .container {
                margin: 20px auto;
                padding: 14px;
            }

            .welcome {
                padding: 22px;
            }

            .welcome h2 {
                font-size: 23px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 22px;
            }

            .logout {
                width: 100%;
                text-align: center;
            }
        }
        /* Tablette */
        @media (max-width: 900px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        /* Mobile */
        @media (max-width: 600px) {
            .cards {
                grid-template-columns: 1fr;
            }
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

                <h3>📂 Catégories</h3>

                <p>
                    Gérer les catégories d'équipements.
                </p>

                <a href="index.php?action=category_list">
                    Gérer
                </a>

            </div>

            <div class="card">

                <h3>🛠️ Équipements</h3>

                <p>
                    Gérer le catalogue et le stock.
                </p>

                <a href="index.php?action=equipment_list">
                    Gérer
                </a>

            </div>

            <div class="card">

                <h3>👥 Utilisateurs</h3>

                <p>
                    Gérer les utilisateurs du système.
                </p>

                <a href="index.php?action=user_list">
                    Gérer
                </a>

            </div>

        <?php elseif ($role === 'agent_location'): ?>

            <div class="card">

                <h3>📋 Locations</h3>

                <p>
                    Gérer les demandes de location.
                </p>

                <a href="index.php?action=rental_list">
                    Gérer
                </a>

            </div>

        <?php elseif ($role === 'client'): ?>

            <div class="card">

                <h3>🧰 Catalogue</h3>

                <p>
                    Consulter les équipements disponibles.
                </p>

                <a href="index.php?action=client_catalogue">
                    Voir le catalogue
                </a>

            </div>

            <div class="card">

                <h3>📄 Mes locations</h3>

                <p>
                    Suivre vos demandes de location.
                </p>

                <a href="index.php?action=client_rental_list">
                    Voir mes locations
                </a>

            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>