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

        try {
            if ($mediaUrl = $request->input('MediaUrl0')) {
                $this->saveImage($mediaUrl, $request->input('WaId', 'other'));
                $calories = $driver->getCaloriesFromImage($mediaUrl);
            } else if ($message = $request->input('Body')) {
                $calories = $driver->getCaloriesFromDescription($message);
            }

            $returnMessage = $calories->toString();
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            if (empty($mediaUrl)) {
                $returnMessage = 'Invalid image. Please send a valid image.';
            } else if (empty($message)) {
                $returnMessage = 'Invalid message. Please send a valid message.';
            } else {
                $returnMessage = 'Something went wrong. Please try again later.';
            }
        }

        header("content-type: text/xml");

        $response = new MessagingResponse();
        $response->message($returnMessage);

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
