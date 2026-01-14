<?php

namespace Modules\MCP\Services\AI;

interface AIServiceInterface
{
    public function generateResponse(string $userMessage, array $context = []): array;

    public function buildContext(array $messages, array $knowledge = []): array;

    public function estimateTokens(string $text): int;
}
