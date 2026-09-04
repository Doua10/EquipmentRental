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

        require "view/pdf/contrat.php";

        $filename = "contrat_location_" . $rental["id"] . ".pdf";

        $this->pdf->generateContract(
            "CONTRAT DE LOCATION",
            $lines,
            $filename
        );
    }
}