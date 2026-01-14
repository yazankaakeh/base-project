@php use Modules\Core\App\Enums\LanguageEnum; @endphp

{{-- Content Form Partial --}}
{{-- Parameters: $model (optional), $isEdit (boolean), $titleField (string), $descriptionField (string) --}}

<div class="tab-content m-0 p-0">
    @foreach(LanguageEnum::values() as $lang)
        <div class="tab-pane fade {{$lang == app()->getLocale() ? 'active show': ''}}"
             id="navs-tab-{{$lang}}" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-1">{{$lang}}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <x-core::input
                                :label="$titleField ?? 'blog::blog.post.title"
                                type="text"
                                :name="$titleField ?? 'title[{{$lang}}]'"
                                :id="$titleField ?? 'title[{{$lang}}]'"
                                :value="$isEdit && $model ? $model->getTranslation(str_replace('[{{$lang}}]', '', $titleField ?? 'title'), $lang) : ''">
                            </x-core::input>
                        </div>
                        <div class="col-12">
                            <div class="my-3">
                                <x-core::tinymce
                                    label="blog::blog.post.description"
                                    :name="($descriptionField ?? 'description') . '[' . $lang . ']'"
                                    :id="($descriptionField ?? 'postContent') . '-' . $lang"
                                    :lang="$lang"
                                    :uploadRoute="route('doctor.quillUpload.store')"
                                    :value="$isEdit && $model ? $model->getTranslation(str_replace('[{{$lang}}]', '', $descriptionField ?? 'description'), $lang) ?? '' : ''" />
                            </div>
                        </div>
                        @php
                            $seoTitle = null;
                            $seoDescription = null;
                            if ($isEdit && $model && $model->seo) {
                                $seoTitle = $model->seo->getTranslations('title') ?? null;
                                $seoDescription = $model->seo->getTranslations('meta_description') ?? null;
                            }
                        @endphp
                        @includeIf('blog::partials.seo_form', [
                            'seoTitle' => $seoTitle,
                            'seoDescription' => $seoDescription,
                            'lang' => $lang
                        ])
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
