<?php

namespace App\Modules\LLM;

use App\Modules\DTO\AnalysisResult;

abstract readonly class LLMDriver
{
    const FROM_IMG_PROMPT = '
        I am doing an experiment and want to try to analyse images and guess the amount of calories, proteins, carbs and fats in the image.
        Analyse the image attached and return the information in a JSON format for example:
        {
            "calories": 100,
            "proteins": 10,
            "carbs": 20,
            "fats": 30,
            "description": "A plate with 200g of beans and 100g of rice"
        }

        For example:
        1. {"calories": 100, "proteins": 10, "carbs": 20, "fats": 30, "description": "3 large bananas"}
        2. {"calories": 250, "proteins": 20, "carbs": 15, "fats": 20", "description": "250g of chicken breast"}
        3. {"calories": 1000, "proteins": 100, "carbs": 20, "fats": 30", "description": "100g of salmon and 500g of rice"}

        Only return the JSON object, as I will parse the message programmatically.
    ';

    const FROM_DESCRIPTION_PROMPT = '
        I am doing an experiment and want to try to analyse descriptions and guess the amount of calories, proteins, carbs and fats in the description.
        Analyse the description and return the information in a JSON format for example:
        {
            "calories": 100,
            "proteins": 10,
            "carbs": 20,
            "fats": 30,
            "description": "A plate with 200g of beans and 100g of rice"
        }

        For example:
        1. {"calories": 100, "proteins": 10, "carbs": 20, "fats": 30, "description": "3 large bananas"}
        2. {"calories": 250, "proteins": 20, "carbs": 15, "fats": 20", "description": "250g of chicken breast"}
        3. {"calories": 1000, "proteins": 100, "carbs": 20, "fats": 30", "description": "100g of salmon and 500g of rice"}

        Only return the JSON object, as I will parse the message programmatically.
    ';

    abstract public function getCaloriesFromImage(string $url): AnalysisResult;
    abstract public function getCaloriesFromDescription(string $description): AnalysisResult;
}
