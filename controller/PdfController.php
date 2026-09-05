<?php

require_once "model/Database.php";
require_once "model/rental.php";
require_once "model/Pdf.php";

class PdfController
{
    private $rental;
    private $pdf;

    public function __construct()
    {
        $database = new Database();
        $pdo = $database->getConnection();

        $this->rental = new Rental($pdo);
        $this->pdf = new Pdf();
    }

    // Un client ne peut télécharger que les documents de SES propres locations
    private function checkAccess($rental)
    {
        if ($_SESSION["role"] === "client" && $rental["user_id"] != $_SESSION["user_id"]) {
            echo "Accès refusé : ce document ne vous appartient pas.";
            exit;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Contrat de location
    |--------------------------------------------------------------------------
    */

    public function contrat()
    {
        $id = $_GET["id"] ?? null;

        if (!$id) {
            echo "Location introuvable.";
            return;
        }

        $rental = $this->rental->getById($id);

        if (!$rental) {
            echo "Location introuvable.";
            return;
        }

        $this->checkAccess($rental);

        $lines = [];

        $lines[] = "CONTRAT DE LOCATION";
        $lines[] = "----------------------------------------";
        $lines[] = "";

        $lines[] = "Informations client";
        $lines[] = "Nom : " . $rental["client_nom"];
        $lines[] = "Prenom : " . $rental["client_prenom"];
        $lines[] = "";

        $lines[] = "Informations equipement";
        $lines[] = "Equipement : " . $rental["equipment_nom"];
        $lines[] = "";

        $lines[] = "Informations location";
        $lines[] = "Date debut : " . $rental["date_debut"];
        $lines[] = "Date fin : " . $rental["date_fin"];
        $lines[] = "Duree : " . $rental["duree"] . " jour(s)";
        $lines[] = "Prix par jour : " . $rental["prix_jour"] . " DT";
        $lines[] = "Frais additionnels : " . $rental["frais_additionnels"] . " DT";
        $lines[] = "Prix total : " . $rental["prix_total"] . " DT";
        $lines[] = "Statut : " . $rental["statut"];
        $lines[] = "";

        $lines[] = "Date de creation : " . $rental["date_creation"];
        $lines[] = "";

        $lines[] = "Signature du client : _______________________";
        $lines[] = "";
        $lines[] = "Signature de l'agent : _______________________";

        $filename = "contrat_location_" . $rental["id"] . ".pdf";

        $this->pdf->generateContract(
            "CONTRAT DE LOCATION",
            $lines,
            $filename
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Facture de location
    |--------------------------------------------------------------------------
    */

    public function facture()
    {
        $id = $_GET["id"] ?? null;

        if (!$id) {
            echo "Location introuvable.";
            return;
        }

        $rental = $this->rental->getById($id);

        if (!$rental) {
            echo "Location introuvable.";
            return;
        }

        $this->checkAccess($rental);

        $lines = [];

        $lines[] = "FACTURE DE LOCATION";
        $lines[] = "========================================";
        $lines[] = "";

        $lines[] = "Informations client";
        $lines[] = "Nom : " . $rental["client_nom"];
        $lines[] = "Prenom : " . $rental["client_prenom"];
        $lines[] = "";

        $lines[] = "Equipement loue";
        $lines[] = "Equipement : " . $rental["equipment_nom"];
        $lines[] = "";

        $lines[] = "Details de la location";
        $lines[] = "Date debut : " . $rental["date_debut"];
        $lines[] = "Date fin : " . $rental["date_fin"];
        $lines[] = "Duree : " . $rental["duree"] . " jour(s)";
        $lines[] = "";

        $lines[] = "Tarification";
        $lines[] = "Prix par jour : " . $rental["prix_jour"] . " DT";
        $lines[] = "Sous-total : " .
                   ($rental["prix_jour"] * $rental["duree"]) .
                   " DT";
        $lines[] = "Frais additionnels : " .
                   $rental["frais_additionnels"] .
                   " DT";
        $lines[] = "----------------------------------------";
        $lines[] = "TOTAL A PAYER : " .
                   $rental["prix_total"] .
                   " DT";
        $lines[] = "";

        $lines[] = "Statut de la location : " . $rental["statut"];
        $lines[] = "";

        $lines[] = "Date de creation : " . $rental["date_creation"];
        $lines[] = "";

        $lines[] = "Merci pour votre confiance.";

        $filename = "facture_location_" . $rental["id"] . ".pdf";

        $this->pdf->generateContract(
            "FACTURE DE LOCATION",
            $lines,
            $filename
        );
    }
    public function recu()
{
    $id = $_GET["id"] ?? null;

    if (!$id) {
        echo "Location introuvable.";
        return;
    }

    $rental = $this->rental->getById($id);

    if (!$rental) {
        echo "Location introuvable.";
        return;
    }

    $this->checkAccess($rental);

    $lines = [];

    $lines[] = "RECU DE PAIEMENT";
    $lines[] = "========================================";
    $lines[] = "";

    $lines[] = "Client";
    $lines[] = "Nom : " . $rental["client_nom"];
    $lines[] = "Prenom : " . $rental["client_prenom"];
    $lines[] = "";

    $lines[] = "Location";
    $lines[] = "Equipement : " . $rental["equipment_nom"];
    $lines[] = "Date debut : " . $rental["date_debut"];
    $lines[] = "Date fin : " . $rental["date_fin"];
    $lines[] = "Duree : " . $rental["duree"] . " jour(s)";
    $lines[] = "";

    $lines[] = "Paiement";
    $lines[] = "Prix par jour : " . $rental["prix_jour"] . " DT";

    $sousTotal = $rental["prix_jour"] * $rental["duree"];

    $lines[] = "Sous-total : " . $sousTotal . " DT";
    $lines[] = "Frais additionnels : " .
               $rental["frais_additionnels"] .
               " DT";

    $lines[] = "----------------------------------------";

    $lines[] = "MONTANT PAYE : " .
               $rental["prix_total"] .
               " DT";

    $lines[] = "";

    $lines[] = "Statut : " . $rental["statut"];
    $lines[] = "";

    $lines[] = "Date de creation : " .
               $rental["date_creation"];

    $lines[] = "";
    $lines[] = "Merci pour votre paiement.";

    $filename = "recu_location_" . $rental["id"] . ".pdf";

    $this->pdf->generateContract(
        "RECU DE PAIEMENT",
        $lines,
        $filename
    );
}
}