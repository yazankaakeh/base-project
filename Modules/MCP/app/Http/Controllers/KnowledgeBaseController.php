<?php

namespace Modules\MCP\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\MCP\Http\Requests\StoreKnowledgeRequest;
use Modules\MCP\Http\Requests\UpdateKnowledgeRequest;
use Modules\MCP\Repository\BusinessKnowledge\BusinessKnowledgeInterface;

class KnowledgeBaseController extends Controller
{
    public function __construct(
        protected BusinessKnowledgeInterface $knowledgeRepository
    ) {}

    /**
     * Display knowledge base management page
     */
    public function index(Request $request): View
    {
        $filters = [
            'category' => $request->get('category'),
            'is_active' => $request->get('is_active'),
            'search' => $request->get('search'),
            'per_page' => $request->get('per_page', 15),
        ];

        $knowledge = $this->knowledgeRepository->index($filters);

        return view('mcp::knowledge.index', compact('knowledge', 'filters'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        return view('mcp::knowledge.create');
    }

    /**
     * Store new knowledge
     */
    public function store(StoreKnowledgeRequest $request)
    {
        $knowledge = $this->knowledgeRepository->store($request->validated());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $knowledge,
                'message' => 'Knowledge created successfully',
            ], 201);
        }

        return redirect()->route('mcp.knowledge.index')
            ->with('success', 'Knowledge created successfully');
    }

    /**
     * Show edit form
     */
    public function edit(int $id): View
    {
        $knowledge = $this->knowledgeRepository->find($id);

        return view('mcp::knowledge.edit', compact('knowledge'));
    }

    /**
     * Update knowledge
     */
    public function update(UpdateKnowledgeRequest $request, int $id)
    {
        $knowledge = $this->knowledgeRepository->update($id, $request->validated());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $knowledge,
                'message' => 'Knowledge updated successfully',
            ]);
        }

        return redirect()->route('mcp.knowledge.index')
            ->with('success', 'Knowledge updated successfully');
    }

    /**
     * Delete knowledge
     */
    public function destroy(int $id)
    {
        $this->knowledgeRepository->destroy($id);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Knowledge deleted successfully',
            ]);
        }

        return redirect()->route('mcp.knowledge.index')
            ->with('success', 'Knowledge deleted successfully');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(int $id): JsonResponse
    {
        $result = $this->knowledgeRepository->toggleActive($id);

        return response()->json([
            'success' => true,
            'data' => ['is_active' => $result],
            'message' => 'Status updated successfully',
        ]);
    }

    /**
     * Search knowledge base (API)
     */
    public function search(Request $request): JsonResponse
    {
        $searchTerm = $request->input('q');
        $category = $request->input('category');

        $results = $this->knowledgeRepository->search($searchTerm, $category);

        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }

    /**
     * Get popular knowledge
     */
    public function popular(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 10);
        $results = $this->knowledgeRepository->getPopular($limit);

        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }
}
