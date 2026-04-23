<?php

namespace Modules\AiChat\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\RateLimiter;
use Modules\AiChat\Http\Requests\SendMessageRequest;
use Modules\AiChat\Services\AiChatService;

class AiChatController extends Controller
{
    public function __construct(
        protected AiChatService $service,
    ) {
    }

    public function send(SendMessageRequest $request): JsonResponse
    {
        $limit = (int) (config('aichat.defaults.rate_limit_per_hour') ?? 40);
        $key   = 'aichat:'.($request->session()->getId() ?: $request->ip());

        if (RateLimiter::tooManyAttempts($key, $limit)) {
            return response()->json([
                'error' => __('Too many messages — please wait a bit before trying again.'),
            ], 429);
        }
        RateLimiter::hit($key, 3600);

        try {
            $result = $this->service->send($request->input('message'));
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'error' => app()->hasDebugModeEnabled()
                    ? $e->getMessage()
                    : __('The assistant is unavailable right now. Please try again in a moment.'),
            ], 500);
        }

        return response()->json($result);
    }

    public function history(): JsonResponse
    {
        return response()->json([
            'messages' => $this->service->history(),
        ]);
    }

    public function reset(): JsonResponse
    {
        $this->service->reset();

        return response()->json(['status' => 'ok']);
    }
}
