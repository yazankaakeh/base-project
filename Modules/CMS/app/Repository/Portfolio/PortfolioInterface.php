<?php

namespace Modules\CMS\Repository\Portfolio;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Modules\CMS\Models\Portfolio;

interface PortfolioInterface
{
    /**
     * Get all portfolios with pagination
     */
    public function index(int $perPage = 15): LengthAwarePaginator;

    /**
     * Get all active portfolios
     */
    public function getActive(): Collection;

    /**
     * Get active portfolios with pagination
     */
    public function getActivePaginated(int $perPage = 12): LengthAwarePaginator;

    /**
     * Get featured portfolios
     */
    public function getFeatured(int $limit = 6): Collection;

    /**
     * Find portfolio by ID
     */
    public function find(int $id): ?Portfolio;

    /**
     * Find portfolio by slug
     */
    public function findBySlug(string $slug): ?Portfolio;

    /**
     * Find active portfolio by slug
     */
    public function findActiveBySlug(string $slug): ?Portfolio;

    /**
     * Store new portfolio
     */
    public function store(Request $request): Portfolio;

    /**
     * Update portfolio
     */
    public function update(int $id, Request $request): Portfolio;

    /**
     * Delete portfolio
     */
    public function destroy(int $id): void;

    /**
     * Toggle portfolio status
     */
    public function toggleStatus(int $id): Portfolio;

    /**
     * Toggle featured status
     */
    public function toggleFeatured(int $id): Portfolio;

    /**
     * Reorder portfolios
     */
    public function reorder(array $orderData): void;

    /**
     * Duplicate portfolio
     */
    public function duplicate(int $id): Portfolio;

    /**
     * Get portfolios by category
     */
    public function getByCategory(string $category, int $perPage = 12): LengthAwarePaginator;

    /**
     * Get all categories
     */
    public function getCategories(): array;

    /**
     * Search portfolios
     */
    public function search(string $query, int $perPage = 12): LengthAwarePaginator;

    /**
     * Get related portfolios
     */
    public function getRelated(Portfolio $portfolio, int $limit = 4): Collection;
}
