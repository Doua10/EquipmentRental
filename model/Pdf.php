<?php

class Pdf
{
    private $objects = [];
    private $offsets = [];

    private $pageWidth = 595;
    private $pageHeight = 842;


    public function generateContract($title, $lines, $filename)
    {
        $this->objects = [];
        $this->offsets = [];

        $content = "";

        /*
         * =========================================
         * FOND DE LA PAGE
         * Crème pastel : #FFF9F3
         * =========================================
         */

        $content .= "1 0.976 0.953 rg\n";
        $content .= "0 0 {$this->pageWidth} {$this->pageHeight} re f\n";


        /*
         * =========================================
         * BANDEAU DU HAUT
         * Lavande pastel : #D8C7F0
         * =========================================
         */

        $content .= "0.847 0.780 0.941 rg\n";
        $content .= "0 755 595 87 re f\n";


        /*
         * =========================================
         * NOM APPLICATION
         * =========================================
         */

        $content .= $this->drawText(
            45,
            805,
            "EquipmentRental",
            18,
            "F2",
            [0.435, 0.361, 0.502]
        );


        /*
         * =========================================
         * TITRE DU DOCUMENT
         * =========================================
         */

        $content .= $this->drawText(
            45,
            775,
            $title,
            13,
            "F1",
            [0.435, 0.361, 0.502]
        );


        /*
         * =========================================
         * CARTE PRINCIPALE
         * =========================================
         */

        $content .= "1 0.988 0.980 rg\n";
        $content .= "35 90 525 635 re f\n";

        /*
         * Bordure très légère
         */
        $content .= "0.941 0.890 0.925 RG\n";
        $content .= "35 90 525 635 re S\n";


        /*
         * =========================================
         * CONTENU
         * =========================================
         */

        $y = 690;

        foreach ($lines as $line) {

            $line = trim((string) $line);

            /*
             * On évite d'afficher une deuxième fois
             * le titre déjà présent dans le bandeau.
             */
            if (
                strtoupper($line) === strtoupper($title) ||
                preg_match('/^[=\-]+$/', $line)
            ) {
                continue;
            }

            /*
             * Ligne vide
             */
            if ($line === "") {
                $y -= 12;
                continue;
            }


            /*
             * =====================================
             * TITRES DE SECTIONS
             * =====================================
             */

            if ($this->isSectionTitle($line)) {

                $y -= 4;

                /*
                 * Fond lavande très clair
                 */
                $content .= "0.929 0.894 0.973 rg\n";
                $content .= "55 " . ($y - 8) . " 485 28 re f\n";

                $content .= $this->drawText(
                    68,
                    $y,
                    $line,
                    11,
                    "F2",
                    [0.396, 0.325, 0.459]
                );

                $y -= 35;

                continue;
            }


            /*
             * =====================================
             * TOTAL / MONTANT IMPORTANT
             * =====================================
             */

            if ($this->isTotalLine($line)) {

                /*
                 * Fond menthe pastel
                 */
                $content .= "0.804 0.910 0.835 rg\n";
                $content .= "55 " . ($y - 9) . " 485 31 re f\n";

                $content .= $this->drawText(
                    68,
                    $y,
                    $line,
                    12,
                    "F2",
                    [0.306, 0.451, 0.345]
                );

                $y -= 40;

                continue;
            }


            /*
             * =====================================
             * SIGNATURES
             * =====================================
             */

            if (stripos($line, "Signature") !== false) {

                $content .= $this->drawText(
                    68,
                    $y,
                    $line,
                    10,
                    "F1",
                    [0.294, 0.275, 0.329]
                );

                $y -= 30;

                continue;
            }


            /*
             * =====================================
             * TEXTE NORMAL
             * =====================================
             */

            $content .= $this->drawText(
                68,
                $y,
                $line,
                10,
                "F1",
                [0.294, 0.275, 0.329]
            );

            $y -= 22;
        }


        /*
         * =========================================
         * FOOTER
         * =========================================
         */

        $content .= "0.847 0.780 0.941 rg\n";
        $content .= "0 0 595 55 re f\n";

        $content .= $this->drawText(
            45,
            22,
            "EquipmentRental - Document genere automatiquement",
            9,
            "F1",
            [0.435, 0.361, 0.502]
        );


        /*
         * =========================================
         * OBJETS PDF
         * =========================================
         */

        // Objet 1 : catalogue
        $this->objects[] =
            "<< /Type /Catalog /Pages 2 0 R >>";


        // Objet 2 : pages
        $this->objects[] =
            "<< /Type /Pages /Kids [3 0 R] /Count 1 >>";


        // Objet 3 : page
        $this->objects[] =
            "<< /Type /Page " .
            "/Parent 2 0 R " .
            "/MediaBox [0 0 {$this->pageWidth} {$this->pageHeight}] " .
            "/Resources << " .
                "/Font << " .
                    "/F1 4 0 R " .
                    "/F2 5 0 R " .
                ">> " .
            ">> " .
            "/Contents 6 0 R >>";


        // Objet 4 : Helvetica normale
        $this->objects[] =
            "<< /Type /Font " .
            "/Subtype /Type1 " .
            "/BaseFont /Helvetica " .
            "/Encoding /WinAnsiEncoding >>";


        // Objet 5 : Helvetica Bold
        $this->objects[] =
            "<< /Type /Font " .
            "/Subtype /Type1 " .
            "/BaseFont /Helvetica-Bold " .
            "/Encoding /WinAnsiEncoding >>";


        // Objet 6 : contenu
        $this->objects[] =
            "<< /Length " . strlen($content) . " >>\n" .
            "stream\n" .
            $content .
            "\nendstream";


        /*
         * =========================================
         * CONSTRUCTION DU PDF
         * =========================================
         */

        $pdf = "%PDF-1.4\n";

        foreach ($this->objects as $index => $object) {

            $this->offsets[$index + 1] = strlen($pdf);

            $pdf .= ($index + 1) . " 0 obj\n";
            $pdf .= $object . "\n";
            $pdf .= "endobj\n";
        }


        /*
         * Table XREF
         */

        $xrefPosition = strlen($pdf);

        $pdf .= "xref\n";

        $pdf .=
            "0 " .
            (count($this->objects) + 1) .
            "\n";

        $pdf .= "0000000000 65535 f \n";


        for (
            $i = 1;
            $i <= count($this->objects);
            $i++
        ) {

            $pdf .= sprintf(
                "%010d 00000 n \n",
                $this->offsets[$i]
            );
        }


        /*
         * Trailer
         */

        $pdf .= "trailer\n";

        $pdf .=
            "<< /Size " .
            (count($this->objects) + 1) .
            " /Root 1 0 R >>\n";

        $pdf .= "startxref\n";

        $pdf .= $xrefPosition . "\n";

        $pdf .= "%%EOF";


        /*
         * =========================================
         * TELECHARGEMENT
         * =========================================
         */

        header("Content-Type: application/pdf");

        header(
            "Content-Disposition: attachment; filename=\"" .
            $filename .
            "\""
        );

        header(
            "Content-Length: " .
            strlen($pdf)
        );

        echo $pdf;

        exit;
    }


    /*
     * =========================================
     * DESSINER DU TEXTE
     * =========================================
     */

    private function drawText(
        $x,
        $y,
        $text,
        $size,
        $font,
        $color
    ) {

        $text =
            $this->escapeText(
                $this->cleanText($text)
            );

        $r = $color[0];
        $g = $color[1];
        $b = $color[2];

        $result = "BT\n";

        $result .=
            "$r $g $b rg\n";

        $result .=
            "/$font $size Tf\n";

        $result .=
            "1 0 0 1 $x $y Tm\n";

        $result .=
            "(" . $text . ") Tj\n";

        $result .= "ET\n";

        return $result;
    }


    /*
     * =========================================
     * RECONNAITRE LES TITRES DE SECTION
     * =========================================
     */

    private function isSectionTitle($line)
    {
        $sections = [

            "Informations client",
            "Informations equipement",
            "Informations équipement",
            "Informations location",

            "Equipement loue",
            "Équipement loué",

            "Details de la location",
            "Détails de la location",

            "Tarification",

            "Client",
            "Location",
            "Paiement"
        ];

        return in_array(
            $line,
            $sections,
            true
        );
    }


    /*
     * =========================================
     * RECONNAITRE LES TOTAUX
     * =========================================
     */

    private function isTotalLine($line)
    {
        return
            stripos($line, "TOTAL A PAYER") !== false ||
            stripos($line, "MONTANT PAYE") !== false ||
            stripos($line, "Prix total") !== false;
    }


    /*
     * =========================================
     * CONVERSION DES ACCENTS
     * =========================================
     */

    private function cleanText($text)
    {
        $text = (string) $text;

        $converted = @iconv(
            "UTF-8",
            "Windows-1252//TRANSLIT",
            $text
        );

        if ($converted !== false) {
            return $converted;
        }

        return $text;
    }


    /*
     * =========================================
     * CARACTERES SPECIAUX PDF
     * =========================================
     */

    private function escapeText($text)
    {
        $text = str_replace(
            "\\",
            "\\\\",
            $text
        );

        $text = str_replace(
            "(",
            "\\(",
            $text
        );

        $text = str_replace(
            ")",
            "\\)",
            $text
        );

        return $text;
    }
}