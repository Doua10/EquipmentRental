<?php

$lines = [];

$lines[] = "Contrat de location d'equipement";
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

$lines[] = "Signature du client : __________________________";
$lines[] = "";
$lines[] = "Signature de l'agent : __________________________";