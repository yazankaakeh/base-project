{{-- resources/views/pdf/invoice.blade.php --}}
@extends('doctor::pdf.layout.main')

@section('title', 'فاتورة #' )

@section('header_left')
    المعاينة رقم #  {{$medicalExamination-> id }}
@endsection

@section('header_right')
    {{ now()->format('Y-m-d') }}
@endsection

@section('footer_left')
    الدكتور بسام جاويش
@endsection

@section('content')
    <h2>بيانات المريض</h2>
    <div class="section">
        <div>الاسم: {{ $medicalExamination->patient->name }}</div>
        <div>الهاتف: {{ $medicalExamination->patient->phone }}</div>
    </div>

    <h2 class="section">تفاصيل الوصفة الطبية</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width: 24%">اسم الدواء</th>
            <th style="width: 24%">التكرار</th>
            <th style="width: 24%">طريقة الاستخدام</th>
            <th style="width: 24%">العدد</th>
            <th style="width: 24%">ملاحظة</th>
        </tr>
        </thead>
        <tbody>
        @foreach($medicalExamination->medicines as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td class="is-numeric"><span class="ltr">{{ $item->pivot->type }}</span></td>
                <td><span class="ltr">{{ $item->pivot->dosage }}</span></td>
                <td class="is-numeric"><span class="ltr">{{ $item->pivot->count }}</span></td>
                <td>{{ $item->pivot->note }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
