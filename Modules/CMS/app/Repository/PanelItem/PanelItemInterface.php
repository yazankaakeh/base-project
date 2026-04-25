<?php

namespace Modules\CMS\Repository\PanelItem;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Modules\CMS\Enums\PanelItemTypeEnum;
use Modules\CMS\Models\PanelItem;

interface PanelItemInterface
{
    /**
     * Get all items for a specific panel
     */
    public function getByPanel(int $panelId): Collection;

    /**
     * Get active items for a specific panel
     */
    public function getActiveByPanel(int $panelId): Collection;

    /**
     * Find an item by ID
     */
    public function find(int $id): ?PanelItem;

    /**
     * Create a new panel item
     */
    public function store(Request $request): PanelItem;

    /**
     * Update a panel item
     */
    public function update(int $id, Request $request): PanelItem;

    /**
     * Delete a panel item
     */
    public function destroy(int $id): void;

    /**
     * Reorder panel items
     */
    public function reorder(array $orderData): void;

    /**
     * Duplicate a panel item
     */
    public function duplicate(int $id): PanelItem;

    /**
     * Toggle item status
     */
    public function toggleStatus(int $id): PanelItem;

    /**
     * Bulk delete items
     */
    public function bulkDelete(array $ids): void;

    /**
     * Get items by type
     */
    public function getByType(PanelItemTypeEnum $type): Collection;

    /**
     * Get next order number for a panel
     */
    public function getNextOrder(int $panelId): int;

    /**
     * Bulk update order for multiple panel items
     */
    public function bulkUpdateOrder(array $orderedIds): void;
}
