@php
    // Dynamic SEO values (fallbacks if not set)
    $title = $meta_title ?? config('app.name');
    $description = $meta_description ?? config('app.name') . ' Official Website';
    $url = $canonical_url ?? url()->current();
    $image = $meta_image ?? asset('images/default-og.jpg');
    $locale = app()->getLocale().'_'. strtoupper(app()->getLocale());
@endphp

        <!-- 🔹 Basic Meta -->
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="language" content="{{ $locale }}">
<meta http-equiv="content-language" content="{{ $locale }}">
<link rel="canonical" href="{{ $url }}">

<!-- 🔹 Open Graph -->
<meta property="og:type" content="website"/>
<meta property="og:locale" content="{{ $locale }}"/>
<meta property="og:site_name" content="{{ config('app.name') }}"/>
<meta property="og:title" content="{{ $title }}"/>
<meta property="og:description" content="{{ $description }}"/>
<meta property="og:url" content="{{ $url }}"/>
<meta property="og:image" content="{{ $image }}"/>

<!-- 🔹 Twitter -->
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:site" content="@codliy"/>
<meta name="twitter:title" content="{{ $title }}"/>
<meta name="twitter:description" content="{{ $description }}"/>
<meta name="twitter:image" content="{{ $image }}"/>

<!-- 🔹 JSON-LD: Organization -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "{{ config('app.name') }}",
        "url": "{{ config('app.url') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "sameAs": [
            "https://twitter.com/codliy",
            "https://www.facebook.com/codliy",
            "https://www.linkedin.com/company/codliy"
        ]
    }
</script>

<!-- 🔹 JSON-LD: Breadcrumb (Dynamic) -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "name": "{{ config('app.name') }}",
            "item": "{{ config('app.url') }}"
          },
          {
            "@type": "ListItem",
            "position": 2,
            "name": "{{ $title }}",
            "item": "{{ $url }}"
          }
        ]
    }
</script>
