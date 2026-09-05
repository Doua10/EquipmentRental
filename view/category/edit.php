<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier une catégorie</title>
    <link rel="stylesheet" href="view/backoffice.css">
</head>

<body>

<h1>Modifier une catégorie</h1>

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
        value="<?= htmlspecialchars($category['nom']) ?>"
    >

    <br><br>

    <label>Description :</label>
    <br>

    <textarea name="description"><?= htmlspecialchars($category['description']) ?></textarea>

    <br><br>

    <button type="submit">
        Modifier
    </button>

</form>

<br>

<a href="index.php?action=category_list">
    Retour à la liste
</a>

</body>

</html>