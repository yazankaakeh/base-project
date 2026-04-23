<form action="{{ route('admin.theme.settings.update') }}" method="POST" enctype="multipart/form-data" id="theme-form-{{ $scope }}">
    @csrf
    <input type="hidden" name="scope" value="{{ $scope }}">

    <div class="row">
        <!-- Left Column - Settings -->
        <div class="col-lg-8">
            <!-- Light Mode Colors Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ti ti-sun me-2"></i>{{ trans('core::core.theme_settings.colors') }} (Light Mode)</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach(['primary', 'secondary', 'success', 'info', 'warning', 'danger'] as $colorType)
                            <div class="col-md-6">
                                <label class="form-label">{{ trans("core::core.theme_settings.{$colorType}_color") }}</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color"
                                           id="{{ $colorType }}_color_{{ $scope }}"
                                           name="{{ $colorType }}_color"
                                           value="{{ old("{$colorType}_color", $settings->{$colorType.'_color'}) }}">
                                    <input type="text" class="form-control"
                                           id="{{ $colorType }}_color_{{ $scope }}_text"
                                           value="{{ old("{$colorType}_color", $settings->{$colorType.'_color'}) }}"
                                           pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Dark Mode Colors Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ti ti-moon me-2"></i>{{ trans('core::core.theme_settings.colors') }} (Dark Mode)</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach(['primary', 'secondary', 'success', 'info', 'warning', 'danger'] as $colorType)
                            <div class="col-md-6">
                                <label class="form-label">{{ trans("core::core.theme_settings.{$colorType}_color") }}</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color"
                                           id="dark_{{ $colorType }}_color_{{ $scope }}"
                                           name="dark_{{ $colorType }}_color"
                                           value="{{ old("dark_{$colorType}_color", $settings->{'dark_'.$colorType.'_color'}) }}">
                                    <input type="text" class="form-control"
                                           id="dark_{{ $colorType }}_color_{{ $scope }}_text"
                                           value="{{ old("dark_{$colorType}_color", $settings->{'dark_'.$colorType.'_color'}) }}"
                                           pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Typography Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ti ti-typography me-2"></i>{{ trans('core::core.theme_settings.typography') }}</h5>
                </div>
                <div class="card-body">
                    @php
                        $ccv = is_array($settings->custom_css_variables ?? null) ? $settings->custom_css_variables : [];
                        $currentGoogleFontUrl = $ccv['google_font_url'] ?? '';
                        $currentExtraFontUrls = isset($ccv['google_font_urls']) && is_array($ccv['google_font_urls'])
                            ? implode("\n", $ccv['google_font_urls'])
                            : '';
                        $knownFonts = ['Public Sans', 'Inter', 'Roboto', 'Open Sans', 'Poppins', 'Cairo', 'Tajawal', 'Montserrat', 'Lato', 'Nunito', 'Work Sans', 'IBM Plex Sans', 'IBM Plex Sans Arabic', 'Almarai', 'Noto Kufi Arabic'];
                        $currentFamily = old('font_family', $settings->font_family);
                        $isCustomFamily = $currentFamily && !in_array($currentFamily, $knownFonts, true);
                    @endphp
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="font_family_{{ $scope }}">{{ trans('core::core.theme_settings.font_family') }}</label>
                            <select
                                class="form-select"
                                name="font_family"
                                id="font_family_{{ $scope }}">
                                @foreach($knownFonts as $fontOption)
                                    <option value="{{ $fontOption }}" @selected(!$isCustomFamily && $currentFamily === $fontOption)>{{ $fontOption }}</option>
                                @endforeach
                                <option value="__custom__" @selected($isCustomFamily)>— Custom (type below) —</option>
                            </select>
                            <small class="text-muted">Choose a preset or pick "Custom" to type a font name.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="font_family_custom_{{ $scope }}">Custom font family</label>
                            <input
                                type="text"
                                class="form-control"
                                name="font_family_custom"
                                id="font_family_custom_{{ $scope }}"
                                placeholder="e.g. Manrope"
                                value="{{ old('font_family_custom', $isCustomFamily ? $currentFamily : '') }}">
                            <small class="text-muted">Overrides the dropdown when filled. Must match the family name used in the Google Fonts URL below.</small>
                        </div>
                        <div class="col-md-6">
                            <x-core::input
                                :label="trans('core::core.theme_settings.font_size_base')"
                                type="text"
                                name="font_size_base"
                                id="font_size_base_{{ $scope }}"
                                value="{{ old('font_size_base', $settings->font_size_base) }}">
                            </x-core::input>
                            <small class="text-muted">e.g., 0.9375rem or 15px</small>
                        </div>
                        <div class="col-md-6">
                            <x-core::input
                                :label="trans('core::core.theme_settings.headings_font_family')"
                                type="text"
                                name="headings_font_family"
                                id="headings_font_family_{{ $scope }}"
                                placeholder="Leave empty to use base font"
                                value="{{ old('headings_font_family', $settings->headings_font_family) }}">
                            </x-core::input>
                        </div>
                        <div class="col-md-6">
                            <x-core::select
                                :label="trans('core::core.theme_settings.headings_font_weight')"
                                name="headings_font_weight"
                                id="headings_font_weight_{{ $scope }}"
                                :options="['300' => 'Light (300)', '400' => 'Normal (400)', '500' => 'Medium (500)', '600' => 'Semi Bold (600)', '700' => 'Bold (700)']"
                                value="{{ old('headings_font_weight', $settings->headings_font_weight) }}">
                            </x-core::select>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3"><i class="ti ti-link me-2"></i>Google Fonts</h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="google_font_url_{{ $scope }}">Primary Google Fonts URL</label>
                            <input
                                type="url"
                                class="form-control"
                                name="google_font_url"
                                id="google_font_url_{{ $scope }}"
                                placeholder="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
                                value="{{ old('google_font_url', $currentGoogleFontUrl) }}">
                            <small class="text-muted">Paste the full <code>https://fonts.googleapis.com/css2?...</code> URL from Google Fonts. Leave empty to auto-generate from the chosen font family.</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="google_font_urls_{{ $scope }}">Extra Google Fonts URLs</label>
                            <textarea
                                class="form-control font-monospace"
                                name="google_font_urls"
                                id="google_font_urls_{{ $scope }}"
                                rows="3"
                                placeholder="One URL per line">{{ old('google_font_urls', $currentExtraFontUrls) }}</textarea>
                            <small class="text-muted">Additional Google Fonts URLs (e.g. a separate heading font). One URL per line.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Layout Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ti ti-layout me-2"></i>{{ trans('core::core.theme_settings.layout') }}</h5>
                </div>
                <div class="card-body">
                    <h6 class="mb-3">Light Mode</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">{{ trans('core::core.theme_settings.body_bg') }}</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color"
                                       id="body_bg_{{ $scope }}" name="body_bg"
                                       value="{{ old('body_bg', $settings->body_bg) }}">
                                <input type="text" class="form-control" id="body_bg_{{ $scope }}_text"
                                       value="{{ old('body_bg', $settings->body_bg) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ trans('core::core.theme_settings.card_bg') }}</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color"
                                       id="card_bg_{{ $scope }}" name="card_bg"
                                       value="{{ old('card_bg', $settings->card_bg) }}">
                                <input type="text" class="form-control" id="card_bg_{{ $scope }}_text"
                                       value="{{ old('card_bg', $settings->card_bg) }}">
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-3">Dark Mode</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">{{ trans('core::core.theme_settings.body_bg') }} (Dark)</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color"
                                       id="dark_body_bg_{{ $scope }}" name="dark_body_bg"
                                       value="{{ old('dark_body_bg', $settings->dark_body_bg) }}">
                                <input type="text" class="form-control" id="dark_body_bg_{{ $scope }}_text"
                                       value="{{ old('dark_body_bg', $settings->dark_body_bg) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ trans('core::core.theme_settings.card_bg') }} (Dark)</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color"
                                       id="dark_card_bg_{{ $scope }}" name="dark_card_bg"
                                       value="{{ old('dark_card_bg', $settings->dark_card_bg) }}">
                                <input type="text" class="form-control" id="dark_card_bg_{{ $scope }}_text"
                                       value="{{ old('dark_card_bg', $settings->dark_card_bg) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <x-core::input
                                :label="trans('core::core.theme_settings.border_radius')"
                                type="text"
                                name="border_radius"
                                id="border_radius_{{ $scope }}"
                                value="{{ old('border_radius', $settings->border_radius) }}">
                            </x-core::input>
                            <small class="text-muted">e.g., 0.375rem or 6px</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Branding Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ti ti-brand-tabler me-2"></i>{{ trans('core::core.theme_settings.branding') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <x-core::input
                                :label="trans('core::core.theme_settings.site_title')"
                                type="text"
                                name="site_title"
                                id="site_title_{{ $scope }}"
                                value="{{ old('site_title', $settings->site_title) }}">
                            </x-core::input>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ trans('core::core.theme_settings.logo') }}</label>
                            @if($settings->getFirstMediaUrl('logo'))
                                <div class="mb-2 d-flex align-items-center gap-2">
                                    <img src="{{ $settings->getFirstMediaUrl('logo') }}" alt="Logo"
                                         class="img-thumbnail bg-light" style="max-height: 80px;">
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox"
                                           name="remove_logo" id="remove_logo_{{ $scope }}" value="1">
                                    <label class="form-check-label text-danger small" for="remove_logo_{{ $scope }}">
                                        <i class="ti tabler-trash me-1"></i>{{ __('Remove current logo') }}
                                    </label>
                                </div>
                            @endif
                            <input type="file" class="form-control" name="logo" accept="image/*">
                            <small class="text-muted">{{ __('Shown in the header. PNG, SVG, or WebP.') }}</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ trans('core::core.theme_settings.logo_dark') }}</label>
                            @if($settings->getFirstMediaUrl('logo_dark'))
                                <div class="mb-2 d-flex align-items-center gap-2">
                                    <img src="{{ $settings->getFirstMediaUrl('logo_dark') }}" alt="Dark Logo"
                                         class="img-thumbnail" style="max-height: 80px; background: #111;">
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox"
                                           name="remove_logo_dark" id="remove_logo_dark_{{ $scope }}" value="1">
                                    <label class="form-check-label text-danger small" for="remove_logo_dark_{{ $scope }}">
                                        <i class="ti tabler-trash me-1"></i>{{ __('Remove current dark logo') }}
                                    </label>
                                </div>
                            @endif
                            <input type="file" class="form-control" name="logo_dark" accept="image/*">
                            <small class="text-muted">{{ __('Shown in dark mode. Optional.') }}</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ trans('core::core.theme_settings.favicon') }}</label>
                            @if($settings->getFirstMediaUrl('favicon'))
                                <div class="mb-2 d-flex align-items-center gap-2">
                                    <img src="{{ $settings->getFirstMediaUrl('favicon') }}" alt="Favicon"
                                         class="img-thumbnail" style="max-height: 32px;">
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox"
                                           name="remove_favicon" id="remove_favicon_{{ $scope }}" value="1">
                                    <label class="form-check-label text-danger small" for="remove_favicon_{{ $scope }}">
                                        <i class="ti tabler-trash me-1"></i>{{ __('Remove current favicon') }}
                                    </label>
                                </div>
                            @endif
                            <input type="file" class="form-control" name="favicon" accept=".ico,.png">
                            <small class="text-muted">{{ __('Browser tab icon. 32×32 PNG or ICO.') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            @if($scope === 'website')
                @php
                    // Pull the provider catalog from the AiChat module so the admin
                    // only sees providers whose API key is actually set in .env.
                    $aiCatalog = [];
                    try {
                        if (app()->bound(\Modules\AiChat\Services\ProviderFactory::class)) {
                            $aiCatalog = app(\Modules\AiChat\Services\ProviderFactory::class)->catalog();
                        }
                    } catch (\Throwable $e) {
                        $aiCatalog = [];
                    }
                    $currentAiProvider = old('ai_provider', $settings->ai_provider);
                    $currentAiModel    = old('ai_model', $settings->ai_model);
                    $currentAiPrompt   = old('ai_system_prompt', $settings->ai_system_prompt);
                    $currentAiEnabled  = (bool) old('ai_enabled', $settings->ai_enabled ?? false);
                @endphp

                <!-- AI Assistant Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ti ti-robot me-2"></i>{{ trans('core::core.theme_settings.ai_assistant', [], null) ?: 'AI Assistant' }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info d-flex align-items-start mb-4">
                            <i class="ti ti-info-circle me-2 mt-1"></i>
                            <div class="small">
                                Configure a floating live-chat assistant powered by an LLM provider.
                                API keys are read from your <code>.env</code> file
                                (<code>OPENAI_API_KEY</code>, <code>ANTHROPIC_API_KEY</code>,
                                <code>GEMINI_API_KEY</code>, <code>GROK_API_KEY</code>).
                                Only providers with a configured key will work.
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label d-block">Enable chat widget</label>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="ai_enabled" value="0">
                                    <input class="form-check-input" type="checkbox"
                                           role="switch"
                                           id="ai_enabled_{{ $scope }}"
                                           name="ai_enabled"
                                           value="1"
                                           @checked($currentAiEnabled)>
                                    <label class="form-check-label" for="ai_enabled_{{ $scope }}">
                                        Show the AI chat bubble on the front-end
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    When off, the widget is not rendered anywhere.
                                </small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="ai_provider_{{ $scope }}">Provider</label>
                                <select class="form-select" name="ai_provider" id="ai_provider_{{ $scope }}">
                                    <option value="">— Use default from config —</option>
                                    @foreach($aiCatalog as $providerKey => $providerInfo)
                                        <option value="{{ $providerKey }}"
                                                @selected($currentAiProvider === $providerKey)
                                                @disabled(! $providerInfo['configured'])>
                                            {{ $providerInfo['label'] }}
                                            @if(! $providerInfo['configured'])
                                                (no API key)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">
                                    ChatGPT (OpenAI), Claude (Anthropic), Gemini (Google), Grok (xAI).
                                </small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="ai_model_{{ $scope }}">Model (optional)</label>
                                <input type="text" class="form-control"
                                       list="ai_models_{{ $scope }}"
                                       name="ai_model"
                                       id="ai_model_{{ $scope }}"
                                       placeholder="e.g. gpt-4o-mini"
                                       value="{{ $currentAiModel }}">
                                <datalist id="ai_models_{{ $scope }}">
                                    @foreach($aiCatalog as $providerInfo)
                                        @foreach(($providerInfo['available_models'] ?? []) as $m)
                                            <option value="{{ $m }}">{{ $providerInfo['label'] }}</option>
                                        @endforeach
                                    @endforeach
                                </datalist>
                                <small class="text-muted">
                                    Leave blank to use the provider's default model.
                                </small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Configured providers</label>
                                <div class="d-flex flex-wrap gap-2 py-1">
                                    @forelse($aiCatalog as $providerKey => $providerInfo)
                                        <span class="badge rounded-pill {{ $providerInfo['configured'] ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-muted' }}"
                                              title="{{ $providerInfo['configured'] ? 'API key set' : 'Missing API key' }}">
                                            <i class="ti ti-{{ $providerInfo['configured'] ? 'check' : 'x' }} me-1"></i>
                                            {{ $providerInfo['label'] }}
                                        </span>
                                    @empty
                                        <span class="text-muted small">AiChat module not loaded.</span>
                                    @endforelse
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="ai_system_prompt_{{ $scope }}">System prompt</label>
                                <textarea class="form-control"
                                          name="ai_system_prompt"
                                          id="ai_system_prompt_{{ $scope }}"
                                          rows="5"
                                          placeholder="You are a helpful assistant for {{ config('app.name') }}...">{{ $currentAiPrompt }}</textarea>
                                <small class="text-muted">
                                    Sets the assistant's persona and ground rules. Applied to every conversation.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Advanced Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ti ti-code me-2"></i>{{ trans('core::core.theme_settings.advanced') }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <x-core::textarea
                            :label="trans('core::core.theme_settings.custom_css') . ' (Light Mode)'"
                            name="custom_css"
                            id="custom_css_{{ $scope }}"
                            rows="8"
                            class="font-monospace"
                            value="{{ old('custom_css', $settings->custom_css) }}">
                        </x-core::textarea>
                        <small class="text-muted">Add custom CSS for light mode</small>
                    </div>

                    <div>
                        <x-core::textarea
                            :label="trans('core::core.theme_settings.custom_css') . ' (Dark Mode)'"
                            name="dark_custom_css"
                            id="dark_custom_css_{{ $scope }}"
                            rows="8"
                            class="font-monospace"
                            value="{{ old('dark_custom_css', $settings->dark_custom_css) }}">
                        </x-core::textarea>
                        <small class="text-muted">Add custom CSS for dark mode</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Preview & Actions -->
        <div class="col-lg-4">
            <!-- Live Preview -->
            <div class="card mb-4 sticky-top" style="top: 20px;">
                <div class="card-header">
                    <h5 class="mb-0">{{ trans('core::core.theme_settings.preview') }}</h5>
                </div>
                <div class="card-body">
                    <div class="theme-preview-box" id="preview-{{ $scope }}">
                        <div class="preview-card p-3 mb-3" style="background: white; border-radius: 0.375rem;">
                            <h6>Preview Card</h6>
                            <p class="mb-2">This is how your content will look</p>
                            <button class="btn btn-sm preview-button text-white">Primary Button</button>
                        </div>
                        <p class="small text-muted">Colors and styles will update in real-time</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="ti ti-device-floppy me-1"></i>{{ trans('core::core.theme_settings.save_changes') }}
                    </button>
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="if(confirm('{{ trans('core::core.theme_settings.reset_confirm') }}')) { document.getElementById('reset-form-{{ $scope }}').submit(); }">
                        <i class="ti ti-refresh me-1"></i>{{ trans('core::core.theme_settings.reset_defaults') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Reset Form -->
<form id="reset-form-{{ $scope }}" action="{{ route('admin.theme.settings.reset') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="scope" value="{{ $scope }}">
</form>