<?php

error_reporting(E_ERROR);


require_once(__DIR__."/autoload.php");

spl_autoload_register('autoload');

require_once(__DIR__."/globals.php");

define("ipAddr", "127.0.0.1");

define("dbName", "portfolio_3");

define("serverUSER", "root");
define("serverPASS", "password");

$serve = new \PDO("mysql:host=".ipAddr.";dbname=".dbName, serverUSER, serverPASS);

$user_db = new User_Table();
$user_db->initialize($serve, "users");

$project_db = new Project_Table();
$project_db->initialize($serve, "projects");




use Controller\ProjController;
$curRouter = new Router();

$curRouter->addDefaultRoute(ProjController::class, "login");
$curRouter->addURL("login", ProjController::class, "login");

$curRouter->addURL("submit", ProjController::class, "connect");

$curRouter->addURL("port", ProjController::class, "sendData");
$curRouter->addURL("logout", ProjController::class, "logOut");

$curRouter->addURL("addAccount", ProjController::class, "addAccount");
$curRouter->addURL("pAddAccount", ProjController::class, "p_addAccount");

$curRouter->addURL("deleteAccount", ProjController::class, "deleteAccount");

$curRouter->addURL("addProject", ProjController::class, "addProject");
$curRouter->addURL("pAddProject", ProjController::class, "p_addProject");

$curRouter->addURL("register", ProjController::class, "registerPage");
$curRouter->addURL("home", ProjController::class, "home");
$curRouter->addURL("deleteProject", ProjController::class, "deleteProject");

$curRouter->addURL("setting", ProjController::class, "setting");
$curRouter->addURL("maintenancePage", ProjController::class, "maintenancePage");

$curRouter->dispatch($_SERVER["REQUEST_URI"]);


?>
