<div class="card">
    <div class="card-header">
        <h5 class="mb-1">SEO {{$lang}}</h5>
    </div>
    <div class="card-body">
        <x-core::input label="seo::seo.seo.meta_title"
                       type="text"
                       name="meta_title[{{$lang}}]"
                       id="meta_title[{{$lang}}]">

        </x-core::input>
        <x-core::input label="seo::seo.seo.meta_description"
                       type="text"
                       name="meta_description[{{$lang}}]"
                       id="meta_description[{{$lang}}]">

        </x-core::input>
    </div>
</div>