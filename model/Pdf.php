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

        $content = "BT\n";
        $content .= "/F1 18 Tf\n";
        $content .= "50 790 Td\n";

        $content .= "(" . $this->escapeText($this->cleanText($title)) . ") Tj\n";
        $content .= "0 -35 Td\n";

        $content .= "/F1 11 Tf\n";

        foreach ($lines as $line) {
            $line = $this->cleanText($line);

            $content .= "(" . $this->escapeText($line) . ") Tj\n";
            $content .= "0 -20 Td\n";
        }

        $content .= "ET";

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
            "/Resources << /Font << /F1 4 0 R >> >> " .
            "/Contents 5 0 R >>";

        // Objet 4 : police
        $this->objects[] =
            "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>";

        // Objet 5 : contenu
        $this->objects[] =
            "<< /Length " . strlen($content) . " >>\n" .
            "stream\n" .
            $content .
            "\nendstream";

        $pdf = "%PDF-1.4\n";

        foreach ($this->objects as $index => $object) {

            $this->offsets[$index + 1] = strlen($pdf);

            $pdf .= ($index + 1) . " 0 obj\n";
            $pdf .= $object . "\n";
            $pdf .= "endobj\n";
        }

        $xrefPosition = strlen($pdf);

        $pdf .= "xref\n";
        $pdf .= "0 " . (count($this->objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i <= count($this->objects); $i++) {

            $pdf .= sprintf(
                "%010d 00000 n \n",
                $this->offsets[$i]
            );
        }

        $pdf .= "trailer\n";

        $pdf .= "<< /Size " .
            (count($this->objects) + 1) .
            " /Root 1 0 R >>\n";

        $pdf .= "startxref\n";
        $pdf .= $xrefPosition . "\n";
        $pdf .= "%%EOF";

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

    private function cleanText($text)
    {
        $text = (string) $text;

        /*
         * PDF Helvetica utilise WinAnsiEncoding.
         * On convertit donc UTF-8 vers Windows-1252.
         */
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