<div class="doc-header">
    <div>
        <div class="clinic-name">{{ $medicalExamination->patient->clinics->first()->name ?? 'العيادة/المستشفى' }}</div>
        <div class="muted">{{  $medicalExamination->doctor->name ?? 'د. اسم الطبيب' }}
            — {{ $medicalExamination->doctor->medicalSpecialty->name ?? 'اختصاص' }}</div>
    </div>
    <div class="muted">
        التاريخ: {{ now()->format('Y-m-d') }}<br>
        رقم الزيارة: {{ $medicalExamination->id }}
    </div>
</div>