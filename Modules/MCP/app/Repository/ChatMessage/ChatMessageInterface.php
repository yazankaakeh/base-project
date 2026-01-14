<?php

namespace Modules\MCP\Repository\ChatMessage;

use Modules\MCP\Models\ChatMessage;
use Illuminate\Database\Eloquent\Collection;

interface ChatMessageInterface
{
    public function store(array $data): ChatMessage;

    public function find(int $id): ChatMessage;

    public function getByConversation(int $conversationId): Collection;

    public function getLatestByConversation(int $conversationId, int $limit = 10): Collection;

    public function destroy(int $id): void;

    public function getBotMessages(int $conversationId): Collection;

    public function getUserMessages(int $conversationId): Collection;
}
