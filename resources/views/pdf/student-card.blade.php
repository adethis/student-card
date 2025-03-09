<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Pelajar</title>
    <style>
        .card {
            background-image: url("{{ $bgSrc }}");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center 70%;
        }
    </style>
    <style>
        {{ $css }}
    </style>
    <style>
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <img src="{{ $imageSrc }}" alt="Logo" />
        </div>
        <div class="card-body">
            <div class="avatar">
                <img src="{{ $student['photo'] }}" alt="Logo" />
            </div>
            <h1 class="name">{{ $student['name'] }}</h1>
            <p class="nis">NIS: {{ $student['student_id'] }}</p>
        </div>
        <div class="card-footer">
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td>
                            <p>Nomor Pintro Card</p>
                            <h1 class="card-id">{{ $student['card_id'] }}</h1>
                        </td>
                        <td>
                            <img src="{{ $student['qr'] }}" alt="QR Code" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="page-break-after"></div>

    <div class="card">
        <div class="card-footer">
            <table style="width: 86%; height: 80%; text-align: center; margin-top: 80pt;">
                <tbody>
                    <tr>
                        <td>
                            <h1 class="card-id">{{ $student['school'] }}</h1>
                            <p style="margin-top: 20pt">{{ $student['url'] }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
