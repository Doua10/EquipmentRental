<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
    <link rel="stylesheet" href="view/backoffice.css">
</head>

<body>

<h1>Modifier un utilisateur</h1>

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
    action="index.php?action=user_edit&id=<?= $user["id"] ?>"
    id="userForm"
>

    <label>Nom :</label><br>

    <input
        type="text"
        name="nom"
        id="nom"
        value="<?= htmlspecialchars($user["nom"]) ?>"
        required
    >

    <br><br>

    <label>Prénom :</label><br>

    <input
        type="text"
        name="prenom"
        id="prenom"
        value="<?= htmlspecialchars($user["prenom"]) ?>"
        required
    >

    <br><br>

    <label>Email :</label><br>

    <input
        type="email"
        name="email"
        id="email"
        value="<?= htmlspecialchars($user["email"]) ?>"
        required
    >

    <br><br>

    <label>Téléphone :</label><br>

    <input
        type="text"
        name="telephone"
        id="telephone"
        value="<?= htmlspecialchars($user["telephone"]) ?>"
        required
    >

    <br><br>

    <label>Nouveau mot de passe :</label><br>

    <input
        type="password"
        name="mot_de_passe"
        id="mot_de_passe"
        placeholder="Laisser vide pour garder l'ancien"
    >

    <br><br>

    <label>Rôle :</label><br>

    <select
        name="role"
        id="role"
        required
    >

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

    const emailRegex =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
        alert("Veuillez saisir une adresse email valide.");
        e.preventDefault();
        return;
    }

    const telephoneRegex =
        /^[0-9]{8}$/;

    if (!telephoneRegex.test(telephone)) {
        alert(
            "Le numéro de téléphone doit contenir exactement 8 chiffres."
        );
        e.preventDefault();
        return;
    }

    // Le mot de passe est facultatif en modification.
    // Mais s'il est rempli, il doit contenir au moins 6 caractères.
    if (
        motDePasse !== "" &&
        motDePasse.length < 6
    ) {
        alert(
            "Le nouveau mot de passe doit contenir au moins 6 caractères."
        );
        e.preventDefault();
        return;
    }

    if (role === "") {
        alert("Veuillez choisir un rôle.");
        e.preventDefault();
        return;
    }

});

</script>

</body>

</html>