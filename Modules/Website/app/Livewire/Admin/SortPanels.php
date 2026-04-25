<?php

namespace Modules\Website\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\CMS\Models\Panel;
use Modules\CMS\Repository\Panel\PanelInterface;

class SortPanels extends Component
{
    public $panels;

    public function mount(PanelInterface $panelRepository): void
    {
        $this->loadPanels($panelRepository);
    }

    public function loadPanels(PanelInterface $panelRepository): void
    {
        $this->panels = $panelRepository->getByPage(1)->map(function (Panel $panel) {
            return [
                'id' => $panel->id,
                'title' => $panel->title[app()->getLocale()] ?? 'Untitled',
                'type' => $panel->type,
                'is_active' => $panel->is_active,
                'order' => $panel->order,
            ];
        })->sortBy('order')->values();
    }

    #[On('panelsReordered')]
    public function panelsReordered(array $ids): void
    {
        $this->bulkUpdateOrder($ids);
        $this->loadPanels(app(PanelInterface::class));
    }

    public function bulkUpdateOrder(array $orderedIds): void
    {
        DB::transaction(function () use ($orderedIds) {
            foreach ($orderedIds as $index => $id) {
                Panel::whereKey($id)->update(['order' => $index]);
            }
        });
    }

    public function render(): View
    {
        return view('website::livewire.admin.sort-panels')
            ->layout('website::livewire.admin.layout');
    }
}
