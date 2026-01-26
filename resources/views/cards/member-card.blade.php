<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: sans-serif;
            padding: 0;
            margin: 0;
        }

        .card {
            width: 350px;
            height: 210px;
            border: 2px solid #8B0000;
            border-radius: 12px;
            padding: 18px;
            background: linear-gradient(135deg, #ffffff, #f7f2f2);
            position: relative;
            overflow: hidden;
        }

        /* Top decorative corner */
        .card::before {
            content: "";
            position: absolute;
            top: -40px;
            right: -40px;
            width: 120px;
            height: 120px;
            background: #8B0000;
            opacity: 0.12;
            border-radius: 50%;
        }

        /* Bottom decorative wave */
        .bottom-deco {
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 100%;
            height: 60px;
            background: #8B0000;
            border-top-left-radius: 50% 40px;
            border-top-right-radius: 50% 40px;
            opacity: 0.15;
        }

        .logo {
            width: 55px;
            position: absolute;
            top: 15px;
            right: 15px;
        }

        .title {
            font-size: 14px;
            color: #8B0000;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .name {
            font-size: 22px;
            font-weight: bold;
            margin-top: 10px;
            color: #333;
        }

        .info-box {
            margin-top: 12px;
            font-size: 13px;
            padding: 8px;
            background: #faf7f7;
            border-left: 3px solid #8B0000;
            border-radius: 5px;
        }

        .info-line {
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <div class="card">

        <img src="{{ public_path('logo-pramukaaa.png') }}" class="logo">

        <div class="title">Kartu Tanda Anggota</div>

        <div class="name">{{ $anggota->nama }}</div>

        <div class="info-box">
            <div class="info-line"><strong>KTA:</strong> {{ $anggota->nomor_anggota }}</div>
            <div class="info-line"><strong>Golongan:</strong> {{ $anggota->golongan_pramuka }}</div>
            <div class="info-line"><strong>No Telp:</strong> {{ $anggota->no_telp }}</div>
        </div>

        <!-- Bottom decorative shape -->
        <div class="bottom-deco"></div>

    </div>
</body>
</html>
