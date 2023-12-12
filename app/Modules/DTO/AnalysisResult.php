<?php

namespace App\Modules\DTO;

readonly class AnalysisResult
{
    public function __construct(
        public int $calories,
        public int $proteins,
        public int $carbs,
        public int $fats,
    ) {}

    public function toString()
    {
        return json_encode([
            'calories' => $this->calories,
            'proteins' => $this->proteins,
            'carbs' => $this->carbs,
            'fats' => $this->fats,
        ], JSON_PRETTY_PRINT);
    }
}
