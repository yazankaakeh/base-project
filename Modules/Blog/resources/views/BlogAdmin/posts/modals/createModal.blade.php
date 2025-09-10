<div class="modal fade" id="storeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form class="row g-3" enctype="multipart/form-data"
              action="{{route('blogCategory.category.store')}}"
              method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start ">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-md-12 mb-3">
                            <label class="form-label" for="slug">{{trans('blog::posts.slug')}}</label>
                            <x-blog::inputComponent type="text" name="slug" divClass="form-control"
                                                    id="slug" required='required'>
                            </x-blog::inputComponent>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-md-12 mb-3">
                            <label class="form-label" for="create_img">Img</label>
                            <input type="file" required class="form-control" id="create_img" name="img">
                        </div>
                        <div class="col-lg-6 col-sm-6 col-md-12 mb-3">
                            <label class="form-label" for="create_parentId">Parent</label>
                            <select name="parent_id" class="form-select select2"
                                    data-allow-clear="true" id="create_parentId">
                                <option value="">Select One</option>
                                @foreach($posts as $post)
                                    <option value="{{$post->id}}">{{$post->getTranslation(app()->getLocale(),'name')}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="card-header pt-1">
                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#en" aria-controls="en" aria-selected="true">
                                        en
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#ar" aria-controls="ar"
                                            aria-selected="false">
                                        ar
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" data-bs-target="#tr" aria-controls="tr" class="nav-link"
                                            data-bs-toggle="tab"
                                            role="tab" aria-selected="false">
                                        tr
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body pt-3">
                            <div class="tab-content p-0">
                                <div class="tab-pane fade show active" id="en" role="tabpanel">
                                    <div class="row">
                                        <x-blog::inputMultiLanguageComponent
                                                divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                label="Name"
                                                name="name"
                                                type="text" id="name" required language="en"/>
                                        <x-blog::textareaMultiLanguageComponent
                                                divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                label="Description"
                                                name="description"
                                                type="text" id="description" required language="en"/>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="ar" role="tabpanel">
                                    <div class="row">
                                        <x-blog::inputMultiLanguageComponent
                                                divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                label="Title"
                                                name="title"
                                                type="text" id="title" language="ar"/>
                                        <x-blog::textareaMultiLanguageComponent
                                                divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                label="Short Description"
                                                name="short_description"
                                                type="text" id="short_description" language="ar"/>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tr" role="tabpanel">
                                    <div class="row">
                                        <x-blog::inputMultiLanguageComponent
                                                divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                label="Name"
                                                name="name"
                                                type="text" id="name" language="tr"/>
                                        <x-blog::textareaMultiLanguageComponent
                                                divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                label="Description"
                                                name="description"
                                                type="text" id="description" language="tr"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12 mb-3">
                            <textarea name="content" id="editor"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-md-12 mb-3">
                            <input type="checkbox" name="is_active" class="form-check-input" id="create_active"
                                   required/>
                            <label class="form-check-label" for="create_active">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer px-0">
                        <button type="button" class="btn btn-label-secondary"
                                data-bs-dismiss="modal">{{trans('admin.close')}}</button>
                        <button type="submit" class="btn btn-primary">{{trans('admin.save')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
