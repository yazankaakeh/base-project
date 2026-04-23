<?php

namespace Modules\Notification\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppCallBackController extends Controller
{
    const MESSAGE_EVENT = 'message-event';

    public function checkMessage(Request $request): JsonResponse
    {
        $data = $request->all();
        $payload = $data['payload'];
        if ($data['type'] == self::MESSAGE_EVENT && $payload['type'] == WhatsAppStatus::SENT->value) {
            $messageID = $payload['gsId'];
            WhatsAppMessageLog::query()->where([
                'messageId' => $messageID,
            ])->update([
                'status' => WhatsAppStatus::SENT->value,
            ]);
            Log::info('Payload Data: ' . json_encode($payload));
        }
        Log::info('Payload Data: ' . json_encode($data));

        return response()->json([
            'status' => 'success',
        ]);
    }
}

/**
 * {"app":"Apptech",
 *
 * "timestamp":1712047274315,
 * "version":2,
 * "type":"message-event",
 * "payload":
 * {"id":"a53cbd1e-6217-4230-aa34-1a22fdc6e5ab",
 * "gsId":"73c81eeb-d4a5-4774-ae2a-c6cb06cb9417",
 * "type":"sent",
 * "destination":"905522998130",
 * "payload":{"ts":1712047273},
 * "conversation":{"id":"5fa35822c1c863daa8245963a73cd72e",
 * "expiresAt":1712133720,"type":"authentication"},
 * "pricing":{"policy":"CBP","category":"authentication"}}}
 *
 * {"id":"e0ceca99-e68d-44d3-9bfa-674e06b74bee","gsId":"ca022314-3560-4efb-9dfa-f3b1be6c1235","type":"sent","destination":"905522998130","payload":{"ts":1712048973},"conversation":{"id":"5fa35822c1c863daa8245963a73cd72e","expiresAt":1712133720,"type":"authentication"},
 * "pricing":{"policy":"CBP","category":"authentication"}
 */
