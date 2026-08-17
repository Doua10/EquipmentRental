<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
</head>

<body>

<h1>Ajouter un utilisateur</h1>

<?php if (isset($message)): ?>

    <p style="color:red;">
        <?= htmlspecialchars($message) ?>
    </p>

<?php endif; ?>

<form method="POST" action="index.php?action=user_add">

    <label>Nom :</label><br>
    <input type="text" name="nom" required>

    <br><br>

    <label>Prénom :</label><br>
    <input type="text" name="prenom" required>

    <br><br>

    <label>Email :</label><br>
    <input type="email" name="email" required>

    <br><br>

    <label>Téléphone :</label><br>
    <input type="text" name="telephone" required>

    <br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="mot_de_passe" required>

    <br><br>

    <label>Rôle :</label><br>

    <select name="role" required>

        <option value="">-- Choisir un rôle --</option>

        <option value="responsable_inventaire">
            Responsable Inventaire
        </option>

        <option value="agent_location">
            Agent Location
        </option>

        <option value="client">
            Client
        </option>

    </select>

    <br><br>

    <button type="submit">
        Ajouter
    </button>

</form>

<br>

<a href="index.php?action=user_list">
    Retour à la liste
</a>

</body>

</html>