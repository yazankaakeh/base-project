@php  app()->setLocale('en'); @endphp
        <!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Reçete</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        .container {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .container td, .container th {
            border: 1px solid black;
            padding: 8px;
        }

        .title {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="title">Reçete</div>
<table class="container" width="100%">
    <tr>
        <td width="50%">
            Hastanın Adı Soyadı: {{ $medicalExamination->patient->name }}
        </td>
        <td width="50%">
            Tarih: {{ $medicalExamination->created_at }} <br>
            Protokol No: {{-- {{ $protocol_no }} --}}
        </td>
    </tr>
    <tr>
        <td>
            TC Kimlik No: {{-- {{ $tc_no }} --}}
        </td>
        <td>
            Dr. Adı Soyadı: {{ $medicalExamination->doctor->name }} <br>
            Dip. No: {{-- {{ $diploma_no }} --}} <br>
            Kaşe
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Tanı: @foreach($medicalExamination->finalDiagnosis as $finalDiagnoses )
                {{ $finalDiagnoses->name}} ,
            @endforeach

        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center; font-weight:bold;">
            İlaçlar
        </td>
    </tr>
    <tr>
    </tr>
    <tr>
        <td colspan="2">
            @foreach($medicalExamination->medicines as $medicine)
                {{ $medicine->name }} ,
            @endforeach
        </td>
    </tr>
</table>
</body>
</html>