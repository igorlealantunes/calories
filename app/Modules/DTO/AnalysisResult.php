<?php

namespace App\Modules\DTO;

readonly class AnalysisResult
{
    public function __construct(
        public int $calories,
        public int $proteins,
        public int $carbs,
        public int $fats,
        public string $description,
    ) {}

    public function toString(): string
    {
        return json_encode([
            'calories' => $this->calories,
            'proteins' => $this->proteins,
            'carbs' => $this->carbs,
            'fats' => $this->fats,
            'description' => $this->description,
        ], JSON_PRETTY_PRINT);
    }
}
