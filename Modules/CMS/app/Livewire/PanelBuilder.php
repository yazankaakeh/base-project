<?php

namespace Modules\CMS\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\CMS\Enums\PanelItemTypeEnum;
use Modules\CMS\Enums\PanelTypeEnum;
use Modules\CMS\Models\Panel;
use Modules\CMS\Models\PanelItem;
use Modules\CMS\Repository\Panel\PanelInterface;
use Modules\CMS\Repository\PanelItem\PanelItemInterface;
use Modules\Core\App\Enums\LanguageEnum;
use Modules\Core\app\Traits\OptimizeLivewireTrait;
use Throwable;

class PanelBuilder extends Component
{
    use WithFileUploads, OptimizeLivewireTrait;

    public int $pageId;

    /** @var array<int, array> */
    public array $panels = [];

    public array $newPanel = [
        'type' => null,
        'title' => [],
        'is_active' => true,
        'settings' => [],
    ];
    public string $componentName = 'PanelBuilder';
    // Per-panel new item state
    public array $newItemType = [];
    public array $newItemTitle = [];
    public array $newItemContent = [];
    public array $newItemData = [];
    public array $newItemImage = [];
    public array $editPanelItem = [
        'title' => [],
        'description' => [],
        'image' => '',
        'socialMedia' => [
            'facebook' => '',
            'instagram' => '',
            'x' => '',
            'linkedin' => '',
        ],
    ];

    protected $listeners = [
        'refreshPanels' => '$refresh',
    ];

    public function mount(int $pageId): void
    {
        $this->pageId = $pageId;
        $this->loadPanels();

        // Initialize translatable structures with locales
        foreach (LanguageEnum::values() as $lang) {
            $this->newPanel['title'][$lang] = '';
        }
    }

    public function loadPanels(): void
    {
        /** @var PanelInterface $repo */
        $repo = app(PanelInterface::class);
        $this->panels = $repo
            ->getByPage($this->pageId)
            ->map(function (Panel $panel) {
                return [
                    'id' => $panel->id,
                    'type' => $panel->type->value,
                    'type_label' => $panel->type->label(),
                    'title' => $panel->title,
                    'is_active' => $panel->is_active,
                    'order' => $panel->order,
                    'can_have_items' => $panel->type->hasItems(),
                    'items' => $panel->items->map(function (PanelItem $item) {
                        return [
                            'id' => $item->id,
                            'type' => $item->type->value,
                            'type_label' => $item->type->label(),
                            'title' => $item->title,
                            'content' => $item->content,
                            'is_active' => $item->is_active,
                            'order' => $item->order,
                            'media_url' => $item->getFirstMediaUrl('item_image') ?: null,
                        ];
                    })->toArray(),
                ];
            })->toArray();
    }

    public function createPanel(): void
    {
        $this->validate([
            'newPanel.type' => 'required|string|in:'.implode(
                    ',',
                    array_map(fn($e) => $e->value, PanelTypeEnum::cases()),
                ),
            // Title is optional per locale
        ]);

        /** @var PanelInterface $repo */
        $repo = app(PanelInterface::class);

        $panelRequest = new class($this->pageId, $this->newPanel) extends Request {
            public function __construct(public int $pageId, public array $data)
            {
                parent::__construct();
            }

            public function validated(): array
            {
                return array_merge($this->data, [
                    'page_id' => $this->pageId,
                ]);
            }
        };

        $repo->store($panelRequest);
        // Reset new panel form
        $this->newPanel['type'] = null;
        foreach (LanguageEnum::values() as $lang) {
            $this->newPanel['title'][$lang] = '';
        }
        $this->loadPanels();
        $this->dispatch('toast', detail: ['type' => 'success', 'message' => 'Panel added']);
    }

    public function updatePanel(int $panelId, array $data): void
    {
        /** @var PanelInterface $repo */
        $repo = app(PanelInterface::class);

        $request = new class($data) extends Request {
            public function __construct(public array $data)
            {
                parent::__construct();
            }

            public function validated(): array
            {
                return $this->data;
            }
        };

        $repo->update($panelId, $request);
        $this->loadPanels();
        $this->dispatch('toast', detail: ['type' => 'success', 'message' => 'Panel updated']);
    }

    public function deletePanel(int $panelId): void
    {
        /** @var PanelInterface $repo */
        $repo = app(PanelInterface::class);
        $repo->destroy($panelId);
        $this->loadPanels();
        $this->dispatch('toast', detail: ['type' => 'success', 'message' => 'Panel deleted']);
    }

    public function togglePanel(int $panelId): void
    {
        /** @var PanelInterface $repo */
        $repo = app(PanelInterface::class);
        $repo->toggleStatus($panelId);
        $this->loadPanels();
    }

    public function editPanel($panelId) {}

    public function reorderPanels(array $orderedIds): void
    {
        /** @var PanelInterface $repo */
        $repo = app(PanelInterface::class);
        $repo->reorder($orderedIds);
        $this->loadPanels();
    }

    public function createItem(int $panelId): void
    {
        $this->validate([
            'newItemType.'.$panelId => 'required|string|in:'.implode(
                    ',',
                    array_map(fn($e) => $e->value, PanelItemTypeEnum::cases()),
                ),
        ]);

        /** @var PanelItemInterface $repo */
        $repo = app(PanelItemInterface::class);

        // Build translatable payload
        $title = [];
        $content = [];
        foreach (LanguageEnum::values() as $lang) {
            $title[$lang] = $this->newItemTitle[$panelId][$lang] ?? null;
            $content[$lang] = $this->newItemContent[$panelId][$lang] ?? null;
        }

        $payload = [
            'type' => $this->newItemType[$panelId],
            'title' => $title,
            'content' => $content,
            'is_active' => true,
            'data' => $this->newItemData[$panelId] ?? [],
        ];

        $request = new class($panelId, $payload) extends Request {
            public function __construct(public int $panelId, public array $data)
            {
                parent::__construct();
            }

            public function validated(): array
            {
                return array_merge($this->data, ['panel_id' => $this->panelId]);
            }
        };

        $item = $repo->store($request);

        // Handle optional image upload via Livewire temp file
        if (!empty($this->newItemImage[$panelId])) {
            $file = $this->newItemImage[$panelId];
            try {
                $item->clearMediaCollection('item_image');
                $item
                    ->addMedia($file->getRealPath())
                    ->usingFileName($file->getClientOriginalName())
                    ->toMediaCollection('item_image');
            } catch (Throwable $e) {
                // non-fatal
            }
        }
        // Reset per-panel new item form
        unset($this->newItemType[$panelId]);
        foreach (LanguageEnum::values() as $lang) {
            $this->newItemTitle[$panelId][$lang] = '';
            $this->newItemContent[$panelId][$lang] = '';
        }
        unset($this->newItemData[$panelId]);
        unset($this->newItemImage[$panelId]);
        $this->loadPanels();
        $this->dispatch('toast', detail: ['type' => 'success', 'message' => 'Item added']);
    }

    public function updateItem(int $itemId, array $data): void
    {
        /** @var PanelItemInterface $repo */
        $repo = app(PanelItemInterface::class);
        $request = new class($data) extends Request {
            public function __construct(public array $data)
            {
                parent::__construct();
            }

            public function validated(): array
            {
                return $this->data;
            }
        };
        $repo->update($itemId, $request);
        $this->loadPanels();
    }

    public function deleteItem(int $itemId): void
    {
        /** @var PanelItemInterface $repo */
        $repo = app(PanelItemInterface::class);
        $repo->destroy($itemId);
        $this->loadPanels();
    }

    public function reorderItems(int $panelId, array $orderedIds): void
    {
        // Persist item order for a specific panel
        /** @var PanelItemInterface $repo */
        $repo = app(PanelItemInterface::class);
        $repo->reorder($orderedIds);
        $this->loadPanels();
    }

    public function render(): View
    {
        return view('cms::livewire.panel-builder', [
            'panelTypes' => PanelTypeEnum::cases(),
            'itemTypes' => PanelItemTypeEnum::cases(),
        ]);
    }
}


