<?php
require_once __DIR__ . '/../vendor/autoload.php';

use ForestFire\Grid;
use ForestFire\SimulationController;

session_start();

// Charger le fichier de configuration
$config = json_decode(file_get_contents(__DIR__ . '/../config.json'), true);

if (!isset($_SESSION['simulation'])) {
    $rows = $config['dimensions'][0];
    $cols = $config['dimensions'][1];
    $firePositions = $config['initial_fire_positions'];
    $probability = $config['propagation_probability'];

    $grid = new Grid($rows, $cols, $firePositions);
    $simulation = new SimulationController($grid, $probability);

    $_SESSION['simulation'] = serialize($simulation);
} else {
    $simulation = unserialize($_SESSION['simulation']);
}

$grid = $simulation->nextStep();
$_SESSION['simulation'] = serialize($simulation);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forest Fire Simulation</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<h1>Forest Fire Simulation</h1>
<div id="grid">
    <table>
        <?php foreach ($grid as $row): ?>
            <tr>
                <?php foreach ($row as $cell): ?>
                    <td class="<?= $cell ?>"></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<button id="nextStep">Prochaine étape</button>
<button id="reset">Réinitialiser</button>
<script src="assets/script.js"></script>
</body>
</html>