<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>@yield('title','مستند')</title>
    {{-- DO NOT use @vite here. Browsershot prefers a plain link to built CSS. --}}
    {{-- Bootstrap CDN --}}
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
            rel="stylesheet"
            integrity="sha384-vlJRAciYZ2dLZ+uG0LQwxxRch27iZyXGb/3ULnA7/wfFZxHqzFwxwz9XsjtIhZtN"
            crossorigin="anonymous"
    >

    {{-- Your custom print CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/pdf.css') }}">
</head>
<body>
<div class="header">
    <div style="display:flex; justify-content:space-between; font-size:10px;">
        <h1>@yield('header_left')</h1>
        <h1>@yield('header_right')</h1>
    </div>
</div>

<div class="footer">
    <div style="display:flex; justify-content:space-between; font-size:10px;">
        <h1>@yield('footer_left')</h1>
        <div class="page-numbers"></div>
    </div>
</div>

<main style="margin-top:40px; margin-bottom:32px;">
    @yield('content')
</main>
</body>
</html>
