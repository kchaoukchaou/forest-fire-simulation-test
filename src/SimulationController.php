<?php
namespace ForestFire;

class SimulationController {
    private Grid $grid;
    private float $probability;

    public function __construct(Grid $grid, float $probability) {
        $this->grid = $grid;
        $this->probability = $probability;
    }

    public function nextStep(): array {
        $gridData = $this->grid->getGrid();
        $newGrid = $gridData;

        foreach ($gridData as $i => $row) {
            foreach ($row as $j => $cell) {
                if ($cell === 'red') {
                    $newGrid[$i][$j] = 'ash';

                    foreach ([[-1, 0], [1, 0], [0, -1], [0, 1]] as $offset) {
                        $ni = $i + $offset[0];
                        $nj = $j + $offset[1];

                        if (isset($gridData[$ni][$nj]) && $gridData[$ni][$nj] === 'green') {
                            if (mt_rand() / mt_getrandmax() < $this->probability) {
                                $newGrid[$ni][$nj] = 'red';
                            }
                        }
                    }
                }
            }
        }

        $this->grid->setGrid($newGrid);
        return $newGrid;
    }

    public function isSimulationOver(): bool {
        return !$this->grid->isFireRemaining();
    }
}