@php
    use Modules\Core\App\Enums\LanguageEnum;
    $isEdit = isset($portfolio);
@endphp

<div class="row">
    {{-- Left Column - Main Content --}}
    <div class="col-lg-8">
        {{-- Translatable Fields --}}
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="ti tabler-language me-2"></i> Content (Multi-language)</h6>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach(LanguageEnum::values() as $index => $lang)
                        <li class="nav-item">
                            <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#lang-{{ $lang }}"
                                    type="button">
                                {{ strtoupper($lang) }}
                                @if($lang === 'en')
                                    <span class="text-danger">*</span>
                                @endif
                            </button>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content pt-4">
                    @foreach(LanguageEnum::values() as $index => $lang)
                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="lang-{{ $lang }}">
                            {{-- Title --}}
                            <div class="mb-3">
                                <label class="form-label">
                                    Title ({{ strtoupper($lang) }})
                                    @if($lang === 'en')
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                <input type="text"
                                       name="title[{{ $lang }}]"
                                       class="form-control @error("title.{$lang}") is-invalid @enderror"
                                       value="{{ old("title.{$lang}", $isEdit ? $portfolio->getTranslation('title', $lang) : '') }}"
                                       placeholder="Portfolio title in {{ strtoupper($lang) }}">
                                @error("title.{$lang}")
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Short Description --}}
                            <div class="mb-3">
                                <label class="form-label">Short Description ({{ strtoupper($lang) }})</label>
                                <textarea name="short_description[{{ $lang }}]"
                                          class="form-control"
                                          rows="2"
                                          placeholder="Brief description for cards and listings">{{ old("short_description.{$lang}", $isEdit ? $portfolio->getTranslation('short_description', $lang) : '') }}</textarea>
                            </div>

                            {{-- Description --}}
                            <div class="mb-3">
                                <label class="form-label">Full Description ({{ strtoupper($lang) }})</label>
                                <textarea name="description[{{ $lang }}]"
                                          class="form-control tinymce-editor"
                                          rows="6"
                                          placeholder="Detailed portfolio description">{{ old("description.{$lang}", $isEdit ? $portfolio->getTranslation('description', $lang) : '') }}</textarea>
                            </div>

                            {{-- Category --}}
                            <div class="mb-3">
                                <label class="form-label">Category ({{ strtoupper($lang) }})</label>
                                <input type="text"
                                       name="category[{{ $lang }}]"
                                       class="form-control"
                                       value="{{ old("category.{$lang}", $isEdit ? $portfolio->getTranslation('category', $lang) : '') }}"
                                       placeholder="e.g., Web Development, Mobile App"
                                       list="categories-{{ $lang }}">
                                @if(!empty($categories))
                                    <datalist id="categories-{{ $lang }}">
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat }}">
                                        @endforeach
                                    </datalist>
                                @endif
                            </div>

                            {{-- Features --}}
                            <div class="mb-3">
                                <label class="form-label">Key Features ({{ strtoupper($lang) }})</label>
                                <textarea name="features[{{ $lang }}]"
                                          class="form-control"
                                          rows="3"
                                          placeholder="One feature per line">{{ old("features.{$lang}", $isEdit ? $portfolio->getTranslation('features', $lang) : '') }}</textarea>
                                <small class="text-muted">Enter one feature per line</small>
                            </div>

                            {{-- Challenges --}}
                            <div class="mb-3">
                                <label class="form-label">Challenges ({{ strtoupper($lang) }})</label>
                                <textarea name="challenges[{{ $lang }}]"
                                          class="form-control"
                                          rows="3"
                                          placeholder="Challenges faced during the project">{{ old("challenges.{$lang}", $isEdit ? $portfolio->getTranslation('challenges', $lang) : '') }}</textarea>
                            </div>

                            {{-- Solutions --}}
                            <div class="mb-3">
                                <label class="form-label">Solutions ({{ strtoupper($lang) }})</label>
                                <textarea name="solutions[{{ $lang }}]"
                                          class="form-control"
                                          rows="3"
                                          placeholder="Solutions implemented">{{ old("solutions.{$lang}", $isEdit ? $portfolio->getTranslation('solutions', $lang) : '') }}</textarea>
                            </div>

                            {{-- Results --}}
                            <div class="mb-3">
                                <label class="form-label">Results ({{ strtoupper($lang) }})</label>
                                <textarea name="results[{{ $lang }}]"
                                          class="form-control"
                                          rows="3"
                                          placeholder="Results achieved">{{ old("results.{$lang}", $isEdit ? $portfolio->getTranslation('results', $lang) : '') }}</textarea>
                            </div>

                            {{-- Testimonial --}}
                            <div class="mb-3">
                                <label class="form-label">Client Testimonial ({{ strtoupper($lang) }})</label>
                                <textarea name="testimonial[{{ $lang }}]"
                                          class="form-control"
                                          rows="3"
                                          placeholder="What the client said about the project">{{ old("testimonial.{$lang}", $isEdit ? $portfolio->getTranslation('testimonial', $lang) : '') }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Gallery Images --}}
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="ti tabler-photo me-2"></i> Gallery Images</h6>
            </div>
            <div class="card-body">
                @if($isEdit && count($portfolio->gallery_images) > 0)
                    <div class="row g-3 mb-4" id="gallery-preview">
                        @foreach($portfolio->gallery_images as $image)
                            <div class="col-md-3 gallery-item" data-id="{{ $image['id'] }}">
                                <div class="position-relative">
                                    <img src="{{ $image['thumb'] }}"
                                         class="img-fluid rounded"
                                         style="width: 100%; height: 120px; object-fit: cover;">
                                    <button type="button"
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-gallery-image"
                                            data-id="{{ $image['id'] }}">
                                        <i class="ti tabler-x"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="mb-3">
                    <label class="form-label">Add Gallery Images</label>
                    <input type="file"
                           name="gallery[]"
                           class="form-control"
                           accept="image/*"
                           multiple>
                    <small class="text-muted">Select multiple images. Max 5MB each. Supported: JPEG, PNG, WebP,
                        GIF</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column - Settings & Meta --}}
    <div class="col-lg-4">
        {{-- Featured Image --}}
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="ti tabler-photo me-2"></i> Featured Image</h6>
            </div>
            <div class="card-body">
                @if($isEdit && $portfolio->featured_image_url)
                    <div class="mb-3 text-center">
                        <img src="{{ $portfolio->featured_image_url }}"
                             class="img-fluid rounded"
                             style="max-height: 200px;">
                    </div>
                @endif
                <input type="file"
                       name="featured_image"
                       class="form-control @error('featured_image') is-invalid @enderror"
                       accept="image/*">
                @error('featured_image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Max 5MB. Supported: JPEG, PNG, WebP, GIF</small>
            </div>
        </div>

        {{-- Client Logo --}}
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="ti tabler-building me-2"></i> Client Logo</h6>
            </div>
            <div class="card-body">
                @if($isEdit && $portfolio->logo_url)
                    <div class="mb-3 text-center">
                        <img src="{{ $portfolio->logo_url }}"
                             class="img-fluid"
                             style="max-height: 80px;">
                    </div>
                @endif
                <input type="file"
                       name="logo"
                       class="form-control"
                       accept="image/*">
                <small class="text-muted">Max 2MB. Supports SVG</small>
            </div>
        </div>

        {{-- Project Details --}}
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="ti tabler-info-circle me-2"></i> Project Details</h6>
            </div>
            <div class="card-body">
                {{-- Slug --}}
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text"
                           name="slug"
                           class="form-control @error('slug') is-invalid @enderror"
                           value="{{ old('slug', $isEdit ? $portfolio->slug : '') }}"
                           placeholder="auto-generated-from-title">
                    @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Leave empty to auto-generate</small>
                </div>

                {{-- Client Name --}}
                <div class="mb-3">
                    <label class="form-label">Client Name</label>
                    <input type="text"
                           name="client_name"
                           class="form-control"
                           value="{{ old('client_name', $isEdit ? $portfolio->client_name : '') }}"
                           placeholder="Client or company name">
                </div>

                {{-- Client Company --}}
                <div class="mb-3">
                    <label class="form-label">Client Company</label>
                    <input type="text"
                           name="client_company"
                           class="form-control"
                           value="{{ old('client_company', $isEdit ? $portfolio->client_company : '') }}"
                           placeholder="Company name">
                </div>

                {{-- Project URL --}}
                <div class="mb-3">
                    <label class="form-label">Project URL</label>
                    <input type="url"
                           name="project_url"
                           class="form-control"
                           value="{{ old('project_url', $isEdit ? $portfolio->project_url : '') }}"
                           placeholder="https://example.com">
                </div>

                {{-- Technologies --}}
                <div class="mb-3">
                    <label class="form-label">Technologies Used</label>
                    <input type="text"
                           name="technologies"
                           class="form-control"
                           value="{{ old('technologies', $isEdit && $portfolio->technologies ? implode(', ', $portfolio->technologies) : '') }}"
                           placeholder="Laravel, Vue.js, MySQL">
                    <small class="text-muted">Comma-separated list</small>
                </div>

                {{-- Dates --}}
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date"
                                   name="start_date"
                                   class="form-control"
                                   value="{{ old('start_date', $isEdit && $portfolio->start_date ? $portfolio->start_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">Completion Date</label>
                            <input type="date"
                                   name="completion_date"
                                   class="form-control"
                                   value="{{ old('completion_date', $isEdit && $portfolio->completion_date ? $portfolio->completion_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                </div>

                {{-- Duration --}}
                <div class="mb-3">
                    <label class="form-label">Project Duration</label>
                    <input type="text"
                           name="project_duration"
                           class="form-control"
                           value="{{ old('project_duration', $isEdit ? $portfolio->project_duration : '') }}"
                           placeholder="e.g., 3 months">
                </div>

                {{-- Budget --}}
                <div class="mb-3">
                    <label class="form-label">Project Budget</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number"
                               name="project_budget"
                               class="form-control"
                               step="0.01"
                               min="0"
                               value="{{ old('project_budget', $isEdit ? $portfolio->project_budget : '') }}"
                               placeholder="0.00">
                    </div>
                </div>
            </div>
        </div>

        {{-- Testimonial Author --}}
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="ti tabler-quote me-2"></i> Testimonial Author</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Author Name</label>
                    <input type="text"
                           name="testimonial_author"
                           class="form-control"
                           value="{{ old('testimonial_author', $isEdit ? $portfolio->testimonial_author : '') }}"
                           placeholder="John Doe">
                </div>
                <div class="mb-3">
                    <label class="form-label">Author Position</label>
                    <input type="text"
                           name="testimonial_position"
                           class="form-control"
                           value="{{ old('testimonial_position', $isEdit ? $portfolio->testimonial_position : '') }}"
                           placeholder="CEO at Company">
                </div>
            </div>
        </div>

        {{-- Status & Visibility --}}
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="ti tabler-settings me-2"></i> Status & Visibility</h6>
            </div>
            <div class="card-body">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input"
                           type="checkbox"
                           name="is_active"
                           id="is_active"
                           value="1"
                        {{ old('is_active', $isEdit ? $portfolio->is_active : true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active (visible on website)</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input"
                           type="checkbox"
                           name="is_featured"
                           id="is_featured"
                           value="1"
                        {{ old('is_featured', $isEdit ? $portfolio->is_featured : false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">Featured (show in featured section)</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number"
                           name="order"
                           class="form-control"
                           min="0"
                           value="{{ old('order', $isEdit ? $portfolio->order : '') }}"
                           placeholder="Auto">
                </div>
            </div>
        </div>

        {{-- Submit Buttons --}}
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="ti tabler-device-floppy me-1"></i>
                {{ $isEdit ? 'Update Portfolio' : 'Create Portfolio' }}
            </button>
            <a href="{{ route('admin.portfolios.index') }}" class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>
    </div>
</div>

@push('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Delete gallery image
            document.querySelectorAll('.delete-gallery-image').forEach(btn => {
                btn.addEventListener('click', function () {
                    if (!confirm('Delete this image?')) return;

                    const id = this.dataset.id;
                    const portfolioId = {{ $isEdit ? $portfolio->id : 0 }};
                    const item = this.closest('.gallery-item');

                    fetch(`{{ url('admin/portfolios') }}/${portfolioId}/gallery/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                item.remove();
                            }
                        });
                });
            });
        });
    </script>
@endpush
