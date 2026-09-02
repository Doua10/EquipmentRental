
<?php

session_start();

require_once "controller/CategoryController.php";
require_once "controller/EquipmentController.php";
require_once "controller/UserController.php";
require_once "controller/RentalController.php";

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
       Responsable Inventaire uniquement
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
       Responsable Inventaire uniquement
       ========================================================= */

    case "equipment_list":

        requireRole(["responsable_inventaire"]);

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
       USER
       Responsable Inventaire uniquement
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
       Agent Location
       À développer ensuite
       ========================================================= */

    case "rental_list":

        requireRole(["agent_location"]);

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


    /* =========================================================
       DEFAULT
       ========================================================= */

    default:

        echo "Page introuvable.";

        break;
}
