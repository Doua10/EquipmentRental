<?php

require_once "controller/CategoryController.php";
require_once "controller/EquipmentController.php";
require_once "controller/UserController.php";

$action = $_GET["action"] ?? "category_list";

switch ($action) {

    /* =========================
       CATEGORY
       ========================= */

    case "category_list":

        $controller = new CategoryController();
        $controller->list();

        break;


    case "category_add":

        $controller = new CategoryController();
        $controller->add();

        break;


    case "category_edit":

        $controller = new CategoryController();
        $controller->edit();

        break;


    case "category_delete":

        $controller = new CategoryController();
        $controller->delete();

        break;


    /* =========================
       EQUIPMENT
       ========================= */

    case "equipment_list":

        $controller = new EquipmentController();
        $controller->list();

        break;


    case "equipment_add":

        $controller = new EquipmentController();
        $controller->add();

        break;


    case "equipment_edit":

        $controller = new EquipmentController();
        $controller->edit();

        break;


    case "equipment_delete":

        $controller = new EquipmentController();
        $controller->delete();

        break;


    case "equipment_search":

        $controller = new EquipmentController();
        $controller->search();

        break;
    /* =========================
       user
       ========================= */

    case "user_list":

    $controller = new UserController();
    $controller->list();

    break;


    case "user_add":

    $controller = new UserController();
    $controller->add();

    break;


    case "user_edit":

    $controller = new UserController();
    $controller->edit();

    break;


    case "user_delete":

    $controller = new UserController();
    $controller->delete();
    break;


    case "user_search":

    $controller = new UserController();
    $controller->search();

    break;
    default:

        echo "Page introuvable.";

        break;
}