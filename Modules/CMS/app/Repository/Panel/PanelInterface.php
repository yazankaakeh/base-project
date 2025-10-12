<?php

namespace Modules\CMS\Repository\Panel;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Modules\CMS\Enums\PanelTypeEnum;
use Modules\CMS\Models\Panel;

interface PanelInterface
{
    /**
     * Get all panels for a specific page
     */
    public function getByPage(int $pageId): Collection;

    /**
     * Get active panels for a specific page
     */
    public function getActiveByPage(int $pageId): Collection;

    /**
     * Find a panel by ID
     */
    public function find(int $id): ?Panel;

    /**
     * Find a panel by ID with items
     */
    public function findWithItems(int $id): ?Panel;

    /**
     * Create a new panel
     */
    public function store(Request $request): Panel;

    /**
     * Update a panel
     */
    public function update(int $id, Request $request): Panel;

    /**
     * Delete a panel
     */
    public function destroy(int $id): void;

    /**
     * Reorder panels
     */
    public function reorder(array $orderData): void;

    /**
     * Duplicate a panel
     */
    public function duplicate(int $id): Panel;

    /**
     * Toggle panel status
     */
    public function toggleStatus(int $id): Panel;

    /**
     * Get panels by type
     */
    public function getByType(PanelTypeEnum $type): Collection;

    /**
     * Get next order number for a page
     */
    public function getNextOrder(int $pageId): int;
}