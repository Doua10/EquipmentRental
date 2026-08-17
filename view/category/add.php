<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter une catégorie</title>
</head>

<body>

<h1>Ajouter une catégorie</h1>

<?php if (isset($error)): ?>

    <p style="color:red;">
        <?= htmlspecialchars($error) ?>
    </p>

<?php endif; ?>

<form method="POST">

    <label>Nom :</label>
    <br>

    <input
        type="text"
        name="nom"
        value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
    >

    <br><br>

    <label>Description :</label>
    <br>

    <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>

    <br><br>

    <button type="submit">
        Ajouter
    </button>

</form>

<br>

<a href="index.php?action=category_list">
    Retour à la liste
</a>

</body>

</html>