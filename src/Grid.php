<?php
namespace ForestFire;

class Grid {
    private array $grid;

    public function __construct(int $rows, int $cols, array $firePositions) {
        $this->grid = array_fill(0, $rows, array_fill(0, $cols, 'green'));

        foreach ($firePositions as [$row, $col]) {
            if (isset($this->grid[$row][$col])) {
                $this->grid[$row][$col] = 'red';
            }
        }
    }

    public function getGrid(): array {
        return $this->grid;
    }

    public function setGrid(array $grid): void {
        $this->grid = $grid;
    }

    public function isFireRemaining(): bool {
        foreach ($this->grid as $row) {
            if (in_array('red', $row, true)) {
                return true;
            }
        }
        return false;
    }
}