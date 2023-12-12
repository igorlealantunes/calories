<?php

namespace App\Modules\LLM;

use App\Modules\DTO\AnalysisResult;
use OpenAI\Laravel\Facades\OpenAI;

readonly class OpenAIDriver extends LLMDriver
{
    public function getCalories(string $url): AnalysisResult
    {
        $response =  OpenAI::chat()->create([
            'model' => 'gpt-4-vision-preview',
            'messages' => [
                ['role' => 'system', 'content' => static::PROMPT,],
                [ 'role' => 'user', 'content' => [['type' => 'image_url', 'image_url' => ['url' => $url,],]],],
            ],
            'max_tokens' => 550,
            //'user' => 'test',
            //'temperature' => 0.7, // lower => more deterministic
            //'top_p' => 1.0,
            //'frequency_penalty' => 0.8,
            //'presence_penalty' => 0.8,
            //...$this->parameters
        ]);

        $res = data_get($response, 'choices.0.message.content');
        $processed = json_decode('{'.str($res)->between('{', '}').'}', flags: JSON_THROW_ON_ERROR);

        return new AnalysisResult(
            calories: data_get($processed, 'calories'),
            proteins: data_get($processed, 'proteins'),
            carbs: data_get($processed, 'carbs'),
            fats: data_get($processed, 'fats'),
        );
    }
}
