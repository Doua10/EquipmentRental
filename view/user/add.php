<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
    <link rel="stylesheet" href="view/backoffice.css">
</head>

<body>

<h1>Ajouter un utilisateur</h1>

<div class="top-actions">

    <a href="index.php?action=dashboard">
        🏠 Tableau de bord
    </a>

    <a href="index.php?action=user_list">
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
    action="index.php?action=user_add"
    id="userForm"
>

    <label>Nom :</label><br>

    <input
        type="text"
        name="nom"
        id="nom"
        required
    >

    <br><br>

    <label>Prénom :</label><br>

    <input
        type="text"
        name="prenom"
        id="prenom"
        required
    >

    <br><br>

    <label>Email :</label><br>

    <input
        type="email"
        name="email"
        id="email"
        required
    >

    <br><br>

    <label>Téléphone :</label><br>

    <input
        type="text"
        name="telephone"
        id="telephone"
        required
    >

    <br><br>

    <label>Mot de passe :</label><br>

    <input
        type="password"
        name="mot_de_passe"
        id="mot_de_passe"
        required
    >

    <br><br>

    <label>Rôle :</label><br>

    <select
        name="role"
        id="role"
        required
    >

        <option value="">
            -- Choisir un rôle --
        </option>

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

<script>

const form = document.getElementById("userForm");

form.addEventListener("submit", function (e) {

    const nom =
        document.getElementById("nom").value.trim();

    const prenom =
        document.getElementById("prenom").value.trim();

    const email =
        document.getElementById("email").value.trim();

    const telephone =
        document.getElementById("telephone").value.trim();

    const motDePasse =
        document.getElementById("mot_de_passe").value;

    const role =
        document.getElementById("role").value;

    // Nom
    if (nom === "") {
        alert("Le nom est obligatoire.");
        e.preventDefault();
        return;
    }

    if (nom.length < 2) {
        alert("Le nom doit contenir au moins 2 caractères.");
        e.preventDefault();
        return;
    }

    // Prénom
    if (prenom === "") {
        alert("Le prénom est obligatoire.");
        e.preventDefault();
        return;
    }

    if (prenom.length < 2) {
        alert("Le prénom doit contenir au moins 2 caractères.");
        e.preventDefault();
        return;
    }

    // Email
    const emailRegex =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
        alert("Veuillez saisir une adresse email valide.");
        e.preventDefault();
        return;
    }

    // Téléphone
    const telephoneRegex =
        /^[0-9]{8}$/;

    if (!telephoneRegex.test(telephone)) {
        alert(
            "Le numéro de téléphone doit contenir exactement 8 chiffres."
        );
        e.preventDefault();
        return;
    }

    // Mot de passe
    if (motDePasse.length < 6) {
        alert(
            "Le mot de passe doit contenir au moins 6 caractères."
        );
        e.preventDefault();
        return;
    }

    // Rôle
    if (role === "") {
        alert("Veuillez choisir un rôle.");
        e.preventDefault();
        return;
    }

});

</script>

</body>

</html>