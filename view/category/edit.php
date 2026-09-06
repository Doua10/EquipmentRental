<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier une catégorie</title>
    <link rel="stylesheet" href="view/backoffice.css">
</head>

<body>

<h1>Modifier une catégorie</h1>

<div class="top-actions">

    <a href="index.php?action=dashboard">
        🏠 Tableau de bord
    </a>

    <a href="index.php?action=category_list">
        ← Retour à la liste
    </a>

</div>

<?php if (isset($message)): ?>
    <p style="color:red;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form
    method="POST"
    action="index.php?action=category_edit&id=<?= $category["id"] ?>"
    id="categoryForm"
>

    <label>Nom :</label><br>

    <input
        type="text"
        name="nom"
        id="nom"
        value="<?= htmlspecialchars($category["nom"]) ?>"
        required
    >

    <br><br>

    <label>Description :</label><br>

    <textarea
        name="description"
        id="description"
        rows="5"
    ><?= htmlspecialchars($category["description"]) ?></textarea>

    <br><br>

    <button type="submit">
        Modifier
    </button>

</form>

<br>

<script>
const form = document.getElementById("categoryForm");

form.addEventListener("submit", function (e) {

    const nom =
        document.getElementById("nom").value.trim();

    const description =
        document.getElementById("description").value.trim();

    if (nom === "") {
        alert("Le nom de la catégorie est obligatoire.");
        e.preventDefault();
        return;
    }

    if (nom.length < 2) {
        alert(
            "Le nom de la catégorie doit contenir au moins 2 caractères."
        );
        e.preventDefault();
        return;
    }

    if (nom.length > 100) {
        alert(
            "Le nom de la catégorie ne doit pas dépasser 100 caractères."
        );
        e.preventDefault();
        return;
    }

    if (description.length > 500) {
        alert(
            "La description ne doit pas dépasser 500 caractères."
        );
        e.preventDefault();
        return;
    }

});
</script>

</body>
</html>