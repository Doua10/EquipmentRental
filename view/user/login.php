<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Connexion - Equipment Rental</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            font-family: "Segoe UI", Arial, sans-serif;

            background: #FFF9F3;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #4B4654;
        }

        .login-container {
            width: 420px;
            max-width: 90%;

            padding: 38px;

            background: #FFFCFA;

            border-radius: 18px;

            border: 1px solid #F0E3EC;

            box-shadow: 0 12px 35px rgba(130, 100, 140, 0.12);
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;

            font-size: 24px;
            font-weight: 700;

            color: #8B6FA8;
        }

        h2 {
            text-align: center;

            margin-top: 8px;
            margin-bottom: 30px;

            font-size: 28px;

            color: #715982;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;

            margin-bottom: 8px;

            font-size: 14px;
            font-weight: 600;

            color: #6F6378;
        }

        input {
            width: 100%;

            padding: 12px 14px;

            border: 1px solid #E3D5DF;

            border-radius: 10px;

            background: #FFFDFB;

            color: #4B4654;

            font-size: 15px;

            outline: none;

            transition:
                border-color 0.2s,
                box-shadow 0.2s,
                background 0.2s;
        }

        input:focus {
            border-color: #CFAFDA;

            background: white;

            box-shadow: 0 0 0 3px rgba(216, 199, 240, 0.35);
        }

        button {
            width: 100%;

            margin-top: 10px;

            padding: 13px;

            background: #D8C7F0;

            color: #5E4A6E;

            border: none;

            border-radius: 10px;

            font-size: 15px;
            font-weight: 700;

            cursor: pointer;

            transition:
                background 0.2s,
                transform 0.2s,
                box-shadow 0.2s;
        }

        button:hover {
            background: #CBB6E8;

            transform: translateY(-1px);

            box-shadow: 0 5px 14px rgba(139, 111, 168, 0.18);
        }

        .error {
            background: #FCE8ED;

            color: #9A5B6E;

            padding: 12px 15px;

            margin-bottom: 20px;

            border-radius: 10px;

            border: 1px solid #F4C7D9;

            text-align: center;

            font-size: 14px;
        }

        .subtitle {
            text-align: center;

            margin-bottom: 25px;

            color: #8A7E91;

            font-size: 14px;
        }

        @media (max-width: 500px) {

            body {
                padding: 15px;
            }

            .login-container {
                padding: 25px 20px;
            }

            h2 {
                font-size: 24px;
            }

            .logo {
                font-size: 21px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">

    <div class="logo">
        EquipmentRental
    </div>

    <h2>Connexion</h2>

    <p class="subtitle">
        Connectez-vous à votre espace de gestion
    </p>

    <?php if (isset($error)) : ?>

        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>

    <form method="POST" action="index.php?action=login">

        <div class="form-group">

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                required
                placeholder="Entrez votre email"
            >

        </div>

        <div class="form-group">

            <label for="mot_de_passe">
                Mot de passe
            </label>

            <input
                type="password"
                id="mot_de_passe"
                name="mot_de_passe"
                required
                placeholder="Entrez votre mot de passe"
            >

        </div>

        <button type="submit">
            Se connecter
        </button>

    </form>

</div>

</body>

</html>