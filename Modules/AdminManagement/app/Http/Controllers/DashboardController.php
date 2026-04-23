<?php

namespace Modules\AdminManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Modules\AdminManagement\Models\Admin;
use Modules\AiChat\Models\AiConversation;
use Modules\AiChat\Models\AiMessage;
use Modules\Blog\Models\BlogPost;
use Modules\Blog\Models\BlogPostTags;
use Modules\CMS\Models\Page;
use Throwable;

class DashboardController extends Controller
{
    /**
     * Render the admin dashboard landing page.
     *
     * Stats are pulled opportunistically — every count is wrapped in a safe
     * resolver so the page still renders on a fresh install where some
     * modules may not be migrated yet.
     */
    public function index(): View
    {
        $stats = [
            'admins' => $this->safeCount(Admin::class),
            'blog_posts' => $this->safeCount(BlogPost::class),
            'blog_tags' => $this->safeCount(BlogPostTags::class),
            'cms_pages' => $this->safeCount(Page::class),
            'ai_chats' => $this->safeCount(AiConversation::class),
            'ai_messages' => $this->safeCount(AiMessage::class),
        ];

        $recentAdmins = Admin::query()
            ->latest('id')
            ->limit(5)
            ->get(['id', 'name', 'email', 'is_active', 'created_at']);

        return view('adminmanagement::dashboard.index', [
            'stats' => $stats,
            'recentAdmins' => $recentAdmins,
        ]);
    }

    /**
     * Count rows on a model without blowing up when the class / table is missing.
     */
    protected function safeCount(string $modelClass): int
    {
        try {
            if (! class_exists($modelClass)) {
                return 0;
            }

            return (int) $modelClass::query()->count();
        } catch (Throwable $e) {
            return 0;
        }
    }
}
