<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
    <link rel="stylesheet" href="view/backoffice.css">
</head>

<body>

<h1>Modifier un utilisateur</h1>

<?php if (isset($message)): ?>

    <p style="color:red;">
        <?= htmlspecialchars($message) ?>
    </p>

<?php endif; ?>

<form
    method="POST"
    action="index.php?action=user_edit&id=<?= $user["id"] ?>"
>

    <label>Nom :</label><br>

    <input
        type="text"
        name="nom"
        value="<?= htmlspecialchars($user["nom"]) ?>"
        required
    >

    <br><br>

    <label>Prénom :</label><br>

    <input
        type="text"
        name="prenom"
        value="<?= htmlspecialchars($user["prenom"]) ?>"
        required
    >

    <br><br>

    <label>Email :</label><br>

    <input
        type="email"
        name="email"
        value="<?= htmlspecialchars($user["email"]) ?>"
        required
    >

    <br><br>

    <label>Téléphone :</label><br>

    <input
        type="text"
        name="telephone"
        value="<?= htmlspecialchars($user["telephone"]) ?>"
        required
    >

    <br><br>

    <label>Nouveau mot de passe :</label><br>

    <input
        type="password"
        name="mot_de_passe"
        placeholder="Laisser vide pour garder l'ancien"
    >

    <br><br>

    <label>Rôle :</label><br>

    <select name="role" required>

        <option
            value="responsable_inventaire"
            <?= $user["role"] == "responsable_inventaire" ? "selected" : "" ?>
        >
            Responsable Inventaire
        </option>

        <option
            value="agent_location"
            <?= $user["role"] == "agent_location" ? "selected" : "" ?>
        >
            Agent Location
        </option>

        <option
            value="client"
            <?= $user["role"] == "client" ? "selected" : "" ?>
        >
            Client
        </option>

    </select>

    <br><br>

    <button type="submit">
        Modifier
    </button>

</form>

<br>

<a href="index.php?action=user_list">
    Retour à la liste
</a>

</body>

</html>