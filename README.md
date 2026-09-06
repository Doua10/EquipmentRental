# EquipmentRental

EquipmentRental est une application web réalisée en PHP pour gérer la location des équipements.

Le projet permet de gérer les équipements, les catégories, les utilisateurs et les locations.  
Il contient trois types d'utilisateurs : responsable inventaire, agent de location et client.

## Technologies utilisées

- PHP 8
- MySQL
- PDO
- HTML / CSS
- JavaScript
- XAMPP
- Git et GitHub

Le projet est réalisé avec une architecture MVC sans framework.

## Fonctionnalités principales

### Responsable inventaire

Le responsable peut gérer les équipements, les catégories et les utilisateurs.  
Il peut aussi consulter le stock, rechercher des équipements et gérer les retours.

### Agent de location

L'agent peut gérer les locations, vérifier la disponibilité des équipements et enregistrer les retours avec les frais additionnels.

### Client

Le client peut consulter le catalogue, demander une location et suivre ses locations.

Il peut aussi télécharger les documents PDF :
- contrat
- facture
- reçu

## Structure du projet

```text
EquipmentRental/
├── controller/
├── model/
├── view/
├── index.php
└── README.md
```

Le dossier `model` contient les classes qui communiquent avec la base de données avec PDO.

Le dossier `controller` contient le traitement des différentes actions.

Le dossier `view` contient les interfaces de l'application.

## Base de données

La base `equipment_rental` contient principalement :

- users
- categories
- equipments
- rentals

## Installation

Pour lancer le projet en local :

1. Installer XAMPP.
2. Mettre le dossier `EquipmentRental` dans `htdocs`.
3. Démarrer Apache et MySQL.
4. Créer/importer la base `equipment_rental`.
5. Ouvrir le projet depuis localhost.

## Auteur

Doua Souissi  
ESPRIT

## Lancer le projet

Après avoir démarré Apache et MySQL avec XAMPP :

http://localhost/EquipmentRental/

## Dépôt GitHub

https://github.com/Doua10/EquipmentRental