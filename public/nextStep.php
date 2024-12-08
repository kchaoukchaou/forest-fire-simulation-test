<?php
require_once __DIR__ . '/../vendor/autoload.php';

use ForestFire\SimulationController;

session_start();

if (!isset($_SESSION['simulation'])) {
    die('Erreur : La simulation n\'est pas initialisée.');
}

$simulation = unserialize($_SESSION['simulation']);
if (!$simulation instanceof SimulationController) {
    die('Erreur : Objet SimulationController introuvable.');
}

if ($simulation->isSimulationOver()) {
    echo json_encode(["success" => false, "message" => "Simulation terminée."]);
    exit;
}

$grid = $simulation->nextStep();
$_SESSION['simulation'] = serialize($simulation);

header('Content-Type: application/json');
echo json_encode(["success" => true, "grid" => $grid]);