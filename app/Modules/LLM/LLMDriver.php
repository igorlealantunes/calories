<?php

namespace App\Modules\LLM;

use App\Modules\DTO\AnalysisResult;

abstract readonly class LLMDriver
{
    const PROMPT = '
        I am doing an experiment and want to try to analyse images and guess the amount of calories, proteins, carbs and fats in the image.
        Analyse the image attached and return the information in a JSON format for example:
        {
            "calories": 100,
            "proteins": 10,
            "carbs": 20,
            "fats": 30
        }

        For example:
        1. {"calories": 100, "proteins": 10, "carbs": 20, "fats": 30"}
        2. {"calories": 250, "proteins": 20, "carbs": 15, "fats": 20"}
        3. {"calories": 1000, "proteins": 100, "carbs": 20, "fats": 30"}

        Only return the JSON object, as I will parse the message programmatically.
    ';

    abstract public function getCalories(string $url): AnalysisResult;
}
