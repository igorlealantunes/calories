<?php

namespace App\Http\Controllers;

use App\Modules\LLM\LLMDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Twilio\TwiML\MessagingResponse;

class TwilioWebhookController extends Controller
{
    public function __invoke(Request $request, LLMDriver $driver): MessagingResponse
    {
        Log::info(json_encode($request->all()));

        if ($mediaUrl = $request->input('MediaUrl0')) {
            $this->saveImage($mediaUrl, $request->input('WaId', 'other'));
        }

        header("content-type: text/xml");

        $response = new MessagingResponse();

        try {
            $calories = $driver->getCalories($mediaUrl);
            $response->message($calories->toString());
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            $response->message("Imagem ruim da gota, manda ota"); // TODO: improve lol
        }

        return $response;
    }

    private function saveImage(string $mediaUrl, string $phone): void
    {
        $imgBlob = Http::get($mediaUrl)->body();
        $filetype = request()->input('MediaContentType0', 'jpeg');
        $filetype = str_replace('image/', '', $filetype);

        $path = 'public/images/' . $phone . '/'  . time() . '.' . $filetype;
        Storage::put($path, $imgBlob);
    }
}
