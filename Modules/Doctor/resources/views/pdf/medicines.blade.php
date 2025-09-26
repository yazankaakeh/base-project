@extends('doctor::pdf.layout.main')
@section('title', " وصفة طبية # $medicalExamination->id" )

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
            <col style="width:12%"> {{-- العدد --}}
            <col style="width:18%"> {{-- ملاحظة --}}
        </colgroup>
        <thead>
        <tr>
            <th>اسم الدواء</th>
            <th>التكرار</th>
            <th>طريقة الاستخدام</th>
            <th class="num">العدد</th>
            <th>ملاحظة</th>
        </tr>
        </thead>
        <tbody>
        @forelse($medicalExamination->medicines as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td class="num">{{ $item->pivot->type }}</td>
                <td class="">{{ $item->pivot->dosage }}</td>
                <td class="num ">{{ $item->pivot->count }}</td>
                <td>{{ $item->pivot->note }}</td>
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
            * يُنصح باتباع الإرشادات بدقة، وفي حال ظهور أي أعراض غير اعتيادية يُراجع الطبيب.
        </div>
    </div>
@endsection


