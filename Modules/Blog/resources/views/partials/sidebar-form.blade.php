@php use Modules\Blog\Enums\PostTypeEnum; @endphp

{{-- Sidebar Form Partial --}}
{{-- Parameters: $model (optional), $isEdit (boolean), $tagOptions (array), $relatedPostsOptions (array), $showImage (boolean), $showTags (boolean), $showType (boolean), $showRelatedPosts (boolean) --}}

<div class="col-3">
    <div class="card my-3">
        <div class="card-header">
            <h5 class="mb-1">{{trans('blog::blog.post.image')}}</h5>
        </div>
        <div class="card-body">
            @if($showImage ?? true)
                @if($isEdit && $model && $model->getFirstMediaUrl('img'))
                    <div class="mb-2">
                        <img src="{{ $model->getFirstMediaUrl('img') }}"
                             class="img-fluid rounded" alt=""/>
                    </div>
                @endif
                <x-core::input
                    label="blog::blog.post.image"
                    type="file"
                    name="image"
                    id="image"
                    :required="$isEdit ? '' : 'required'">
                </x-core::input>
            @endif

            @if($showRelatedPosts ?? true)
                <div class="mt-3">
                    <x-core::select
                        :label="trans('blog::blog.post.relatedPost')"
                        :placeholder="trans('blog::blog.post.relatedPost')"
                        id="relatedPosts"
                        name="relatedPosts[]"
                        :required="$isEdit ? '' : 'required'"
                        multiple="true"
                        :options="$relatedPostsOptions ?? []"
                        :values="$isEdit && $model ? $model->relatedPosts->pluck('id')->toArray() : []">
                    </x-core::select>
                </div>
            @endif

            @if($showTags ?? true)
                <div class="mt-3">
                    <label for="tags" class="form-label">{{ trans('blog::blog.post.tags') }}</label>
                    <div class="d-flex gap-2">
                        <select id="tags" name="tags[]" multiple class="form-select select2" style="flex: 1;">
                            @foreach($tagOptions ?? [] as $id => $name)
                                <option value="{{ $id }}"
                                    @if($isEdit && $model && $model->tags->contains('id', $id)) selected @endif>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-primary"
                                data-bs-toggle="modal" data-bs-target="#createTagModal">
                            <i class="ti tabler-plus"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if($showType ?? true)
                <div class="mt-3">
                    <x-core::select
                        :label="trans('blog::blog.post.type')"
                        :placeholder="trans('blog::blog.post.type')"
                        id="type"
                        name="type"
                        required="required"
                        :options="PostTypeEnum::getAllEnumValuesKeysLabel()"
                        :value="$isEdit && $model ? $model->type->value : ''">
                    </x-core::select>
                </div>
            @endif

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    {{ trans('core::core.env.save') }}
                </button>
            </div>
        </div>
    </div>
</div>
