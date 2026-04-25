@foreach($panels as $panel)
    @switch($panel['type']->value)
        @case('faq')
            <livewire:website.panels.faq-panel :panel="$panel" :key="'faq-'.$panel['id']" />
            @break
        @case('team')
            <livewire:website.panels.team-panel :panel="$panel" :key="'team-'.$panel['id']" />
            @break
        @case('cta')
            <livewire:website.panels.cta-panel :panel="$panel" :key="'cta-'.$panel['id']" />
            @break
        @case('features')
            <livewire:website.panels.features-panel :panel="$panel" :key="'features-'.$panel['id']" />
            @break
        @case('hero')
            <livewire:website.panels.hero-panel :panel="$panel" :key="'hero-'.$panel['id']" />
            @break
        @case('reviews')
            <livewire:website.panels.reviews-panel :panel="$panel" :key="'reviews-'.$panel['id']" />
            @break
        @case('contact')
            <livewire:website.panels.contact-panel :panel="$panel" :key="'contact-'.$panel['id']" />
            @break
        @case('stats')
            <livewire:website.panels.stats-panel :panel="$panel" :key="'stats-'.$panel['id']" />
            @break
        @case('gallery')
            <livewire:website.panels.gallery-panel :panel="$panel" :key="'gallery-'.$panel['id']" />
            @break
        @case('custom')
            <livewire:website.panels.custom-panel :panel="$panel" :key="'custom-'.$panel['id']" />
            @break
    @endswitch
@endforeach


