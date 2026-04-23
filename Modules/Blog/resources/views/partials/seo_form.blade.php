<?php /** @var array|string|null $seoTitle @var array|string|null $seoDescription */ ?>
        <h5 class="mb-1">SEO {{$lang}}</h5>

        <x-core::input label="seo::seo.seo.meta_title"
                       type="text"
                       name="meta_title[{{$lang}}]"
                       id="meta_title[{{$lang}}]"
                       :value="is_array($seoTitle ?? null) ? ($seoTitle[$lang] ?? '') : ''">
        </x-core::input>
        <x-core::input label="seo::seo.seo.meta_description"
                       type="text"
                       name="meta_description[{{$lang}}]"
                       id="meta_description[{{$lang}}]"
                       :value="is_array($seoDescription ?? null) ? ($seoDescription[$lang] ?? '') : ''">
        </x-core::input>


