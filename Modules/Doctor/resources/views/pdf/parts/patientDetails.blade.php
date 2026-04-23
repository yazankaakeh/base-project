<div class="info-card">
    <div class="info-grid">
        <div><span class="label">الاسم:</span> <span class="value">{{ $patient->name ?? '-' }}</span></div>
        <div><span class="label">العمر:</span> <span class="value">{{ $patient->age ?? '-' }}</span></div>
        <div><span class="label">الجنس:</span> <span class="value">{{ $patient->gender->label() ?? '-' }}</span></div>
        <div><span class="label">الهاتف:</span> <span class="value ltr">{{ $patient->phone ?? '-' }}</span></div>
        {{--<div><span class="label">الوزن:</span> <span class="value">{{ $patient->weight ?? '-' }}</span></div>
        <div><span class="label">الطول:</span> <span class="value">{{ $patient->height ?? '-' }}</span></div>--}}
    </div>
</div>
