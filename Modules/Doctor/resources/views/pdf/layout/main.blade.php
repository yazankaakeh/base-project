<!doctype html>
@php
    app()->setLocale('ar');
@endphp
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">

    <title>
        @yield('title','مستند')
    </title>

    {{-- اختياري: Bootstrap RTL من CDN (لو السيرفر عليه إنترنت) --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{ asset('build/assets/pdf.css') }}">
    <style>
        @page {
            size: A4;
            margin: 14mm 14mm 18mm 14mm;
        }

        html, body {
            font-size: 12px;
            line-height: 1.6;
            direction: rtl;
            color: #111;
        }

        .doc-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .clinic-name {
            font-size: 18px;
            font-weight: 700;
        }

        .muted {
            color: #666;
            font-size: 11px;
        }

        .info-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 12px;
            background: #fcfcfc;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 8px 12px;
        }

        .label {
            color: #666;
            font-size: 11px;
        }

        .value {
            font-weight: 600;
        }

        .rx-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 6px;
            border: 1px solid #e2e2e2;
            border-radius: 10px;
            overflow: hidden;
        }

        .rx-table thead th {
            background: #f4f5f7;
            border-bottom: 1px solid #e2e2e2;
            padding: 10px 12px;
            text-align: right;
            font-weight: 700;
        }

        .rx-table td {
            padding: 9px 12px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
            word-break: break-word;
        }

        .rx-table tr:last-child td {
            border-bottom: 0;
        }

        .rx-table .num {
            text-align: center;
        }

        .rx-table .ltr {
            direction: ltr;
            unicode-bidi: plaintext;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 18px;
            align-items: flex-end;
        }

        .sign-box {
            width: 42%;
            height: 70px;
            border: 1px dashed #bbb;
            border-radius: 8px;
            padding: 8px;
        }

        .foot-note {
            font-size: 10px;
            color: #777;
        }

        /* تكرار هيدر الجدول لو تعدّى صفحة */
        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
@yield('content')

</body>
</html>