@extends('doctor::pdf.layout.main')
@section('title', " تحاليل طبية #$medicalExamination->id" )

@section('content')
    {{-- رأس الصفحة --}}

    @includeIf('doctor::pdf.parts.header',['medicalExamination' => $medicalExamination])

    {{-- معلومات المريض --}}
    @includeIf('doctor::pdf.parts.patientDetails',['patient' => $medicalExamination->patient])
    {{-- جدول الأدوية --}}
    <table class="rx-table">
        <colgroup>
            <col style="width:26%"> {{-- اسم الدواء --}}
            <col style="width:14%"> {{-- التكرار --}}
            <col style="width:30%"> {{-- طريقة الاستخدام/الجرعة --}}
        </colgroup>
        <thead>
        <tr>
            <th>اسم التحليل</th>
            <th>نوع التحليل</th>
            <th>نتيجة التحليل</th>
        </tr>
        </thead>
        <tbody>
        @forelse($medicalExamination->medicalTests as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td class="num">{{ $item->type->label() }}</td>
                <td class="">  {{ $item->pivot->value }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="num">— لا توجد أدوية —</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{-- تذييل (توقيع + ختم + ملاحظة) --}}
    <div class="footer">
        <div class="sign-box">
            <div class="label">توقيع الطبيب / الختم</div>
        </div>
        <div class="foot-note">
            *في حال ظهور أي نتائج غير طبيعية أو أعراض غير اعتيادية يُراجع الطبيب المختص.
        </div>
    </div>
@endsection

