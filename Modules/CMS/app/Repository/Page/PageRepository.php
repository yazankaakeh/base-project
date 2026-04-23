<?php

namespace Modules\CMS\Repository\Page;

use App\Enum\Pagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\CMS\Enums\PageStatusEnum;
use Modules\CMS\Models\Page;
use Modules\Seo\Models\SeoMeta;

class PageRepository implements PageInterface
{
    public function index(): LengthAwarePaginator
    {
        return Page::query()
            ->with(['parent'])
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(Pagination::PAG->value);
    }

    public function store(Request $request): Page
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($request, $validated) {
            $page = new Page();
            $page->title = $validated['title'];
            $page->slug = $validated['slug'];
            $page->content = $validated['content'] ?? [];
            $page->excerpt = $validated['excerpt'] ?? [];
            $page->status = $validated['status'];
            $page->template = $validated['template'];
            $page->parent_id = $validated['parent_id'] ?? null;
            $page->order = $validated['order'] ?? 0;
            $page->meta_data = $validated['meta_data'] ?? [];
            $page->published_at = $this->resolvePublishedAt($validated);
            $page->use_panel_builder = $request->boolean('use_panel_builder');
            $page->save();

            if ($request->hasFile('featured_image')) {
                $page->addMediaFromRequest('featured_image')->toMediaCollection('featured_image');
            }

            $this->saveSeo($page, $validated);

            return $page;
        });
    }

    /**
     * Decide the published_at timestamp.
     * If the page is set to Published but no published_at was provided,
     * default to "now" so the page is immediately visible on the front-end.
     * Draft / archived pages keep whatever the form provided (or null).
     */
    private function resolvePublishedAt(array $validated): ?Carbon
    {
        $raw = $validated['published_at'] ?? null;
        $status = $validated['status'] ?? null;

        if ($status instanceof PageStatusEnum) {
            $status = $status->value;
        }

        if (!empty($raw)) {
            return Carbon::parse($raw);
        }

        if ($status === PageStatusEnum::PUBLISHED->value) {
            return now();
        }

        return null;
    }

    /**
     * Persist the SEO record for a page.
     *
     * `meta_title` and `meta_description` arrive as arrays keyed by locale
     * (e.g. ['en' => 'My Title', 'ar' => 'عنواني']) because SeoMeta's
     * `title` / `meta_description` columns are Spatie-Translatable JSON
     * fields. Previously we assigned scalar strings here, which Spatie
     * interpreted as "save under current locale only" — so switching
     * the app locale would return to a blank meta_title.
     */
    private function saveSeo(Page $page, array $validated): void
    {
        $metaTitle       = $this->normalizeTranslatable($validated['meta_title']       ?? null);
        $metaDescription = $this->normalizeTranslatable($validated['meta_description'] ?? null);

        // Nothing to save → also nothing to create an empty row for.
        if (empty($metaTitle) && empty($metaDescription)) {
            return;
        }

        $seo = $page->seo ?: new SeoMeta();
        if (!empty($metaTitle)) {
            $seo->title = $metaTitle;
        }
        if (!empty($metaDescription)) {
            $seo->meta_description = $metaDescription;
        }
        $page->seo()->save($seo);
    }

    /**
     * Turn a form-submitted value into a [locale => string] array that
     * Spatie Translatable can store directly. Drops empty translations so
     * a fresh admin who only fills English doesn't persist blank JSON keys
     * for Arabic / Turkish.
     */
    private function normalizeTranslatable(mixed $value): array
    {
        if (is_array($value)) {
            return array_filter(
                array_map(fn ($v) => is_string($v) ? trim($v) : $v, $value),
                fn ($v) => filled($v),
            );
        }
        if (is_string($value) && trim($value) !== '') {
            return [app()->getLocale() => trim($value)];
        }
        return [];
    }

    public function update(int $id, Request $request): Page
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($id, $request, $validated) {
            $page = $this->find($id);
            $page->title = $validated['title'];
            $page->slug = $validated['slug'];
            $page->content = $validated['content'] ?? [];
            $page->excerpt = $validated['excerpt'] ?? [];
            $page->status = $validated['status'];
            $page->template = $validated['template'];
            $page->parent_id = $validated['parent_id'] ?? null;
            $page->order = $validated['order'] ?? 0;
            $page->meta_data = $validated['meta_data'] ?? [];
            $page->published_at = $this->resolvePublishedAt($validated);
            $page->use_panel_builder = $request->boolean('use_panel_builder');
            $page->save();

            // Handle featured image
            if ($request->boolean('remove_featured_image')) {
                $page->clearMediaCollection('featured_image');
            } elseif ($request->hasFile('featured_image')) {
                $page->clearMediaCollection('featured_image');
                $page->addMediaFromRequest('featured_image')->toMediaCollection('featured_image');
            }

            $this->saveSeo($page, $validated);

            return $page;
        });
    }

    public function find(int $id): Page
    {
        return Page::query()->with(['parent', 'children'])->findOrFail($id);
    }

    public function destroy(int $id): void
    {
        $page = $this->find($id);
        $page->delete();
    }

    public function getParentOptions(): array
    {
        return Page::query()
            ->select(['id', 'title'])
            ->whereNull('parent_id')
            ->get()
            ->mapWithKeys(function (Page $page) {
                $title = $page->getTranslation('title', app()->getLocale());
                return [$page->id => is_string($title) ? $title : (json_encode($title) ?: 'Page ' . $page->id)];
            })->toArray();
    }

    public function findBySlug(string $slug): ?Page
    {
        return Page::query()
            ->with(['parent', 'children'])
            ->bySlug($slug)
            ->first();
    }

    public function getHomePage(): ?Page
    {
        return $this->findBySlug('home');
    }
}
