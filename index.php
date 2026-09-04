<?php

session_start();

require_once "controller/CategoryController.php";
require_once "controller/EquipmentController.php";
require_once "controller/UserController.php";
require_once "controller/RentalController.php";
require_once "controller/PdfController.php";


/*
|--------------------------------------------------------------------------
| Vérification de connexion
|--------------------------------------------------------------------------
*/

function requireLogin()
{
    if (!isset($_SESSION["user_id"])) {
        header("Location: index.php?action=login");
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| Vérification du rôle
|--------------------------------------------------------------------------
*/

function requireRole($roles)
{
    requireLogin();

    if (!in_array($_SESSION["role"], $roles)) {
        header("Location: index.php?action=access_denied");
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| Action demandée
|--------------------------------------------------------------------------
*/

$action = $_GET["action"] ?? "login";


switch ($action) {

    /* =========================================================
       LOGIN
       ========================================================= */

    case "login":

        $controller = new UserController();
        $controller->login();

        break;


    /* =========================================================
       LOGOUT
       ========================================================= */

    case "logout":

        session_unset();
        session_destroy();

        header("Location: index.php?action=login");
        exit;

        break;


    /* =========================================================
       ACCESS DENIED
       ========================================================= */

    case "access_denied":

        require "view/access_denied.php";

        break;


    /* =========================================================
       DASHBOARD
       ========================================================= */

    case "dashboard":

        requireLogin();

        require "view/dashboard.php";

        break;


    /* =========================================================
       CATEGORY
       ========================================================= */

    case "category_list":

        requireRole(["responsable_inventaire"]);

        $controller = new CategoryController();
        $controller->list();

        break;


    case "category_add":

        requireRole(["responsable_inventaire"]);

        $controller = new CategoryController();
        $controller->add();

        break;


    case "category_edit":

        requireRole(["responsable_inventaire"]);

        $controller = new CategoryController();
        $controller->edit();

        break;


    case "category_delete":

        requireRole(["responsable_inventaire"]);

        $controller = new CategoryController();
        $controller->delete();

        break;


    /* =========================================================
       EQUIPMENT
       ========================================================= */

    case "equipment_list":

        requireRole(["responsable_inventaire", "client"]);

        $controller = new EquipmentController();
        $controller->list();

        break;


    case "equipment_add":

        requireRole(["responsable_inventaire"]);

        $controller = new EquipmentController();
        $controller->add();

        break;


    case "equipment_edit":

        requireRole(["responsable_inventaire"]);

        $controller = new EquipmentController();
        $controller->edit();

        break;


    case "equipment_delete":

        requireRole(["responsable_inventaire"]);

        $controller = new EquipmentController();
        $controller->delete();

        break;


    case "equipment_search":

        requireRole(["responsable_inventaire"]);

        $controller = new EquipmentController();
        $controller->search();

        break;


    /* =========================================================
       CLIENT CATALOGUE
       ========================================================= */

    case "client_catalogue":

        requireRole(["client"]);

        $controller = new EquipmentController();
        $controller->clientCatalogue();

        break;


    /* =========================================================
       USER
       ========================================================= */

    case "user_list":

        requireRole(["responsable_inventaire"]);

        $controller = new UserController();
        $controller->list();

        break;


    case "user_add":

        requireRole(["responsable_inventaire"]);

        $controller = new UserController();
        $controller->add();

        break;


    case "user_edit":

        requireRole(["responsable_inventaire"]);

        $controller = new UserController();
        $controller->edit();

        break;


    case "user_delete":

        requireRole(["responsable_inventaire"]);

        $controller = new UserController();
        $controller->delete();

        break;


    case "user_search":

        requireRole(["responsable_inventaire"]);

        $controller = new UserController();
        $controller->search();

        break;


    /* =========================================================
       RENTAL
       ========================================================= */

    case "rental_list":

        requireRole([
            "agent_location",
            "responsable_inventaire"
        ]);

        $controller = new RentalController();
        $controller->list();

        break;


    case "rental_add":

        requireRole(["agent_location"]);

        $controller = new RentalController();
        $controller->add();

        break;


    case "rental_edit":

        requireRole(["agent_location"]);

        $controller = new RentalController();
        $controller->edit();

        break;


    case "rental_delete":

        requireRole(["agent_location"]);

        $controller = new RentalController();
        $controller->delete();

        break;


    case "rental_return":

        requireRole([
            "agent_location",
            "responsable_inventaire"
        ]);

        $controller = new RentalController();
        $controller->returnEquipment();

        break;


    /* =========================================================
       RENTAL - CLIENT
       ========================================================= */

    case "client_rental_add":

        requireRole(["client"]);

        $controller = new RentalController();
        $controller->clientAdd();

        break;


    case "client_rental_list":

        requireRole(["client"]);

        $controller = new RentalController();
        $controller->clientList();

        break;


    /* =========================================================
       PDF - CONTRAT
       ========================================================= */

    case "pdf_contrat":

        requireRole([
            "agent_location",
            "responsable_inventaire"
        ]);

        $controller = new PdfController();
        $controller->contrat();

        break;


    /* =========================================================
       DEFAULT
       ========================================================= */

    default:

        echo "Page introuvable.";

        break;
}