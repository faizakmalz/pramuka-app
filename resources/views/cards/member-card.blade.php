<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
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

        /* Logo SVG inline supaya tidak perlu file eksternal */
        .logo-svg {
            width: 55px;
            height: 55px;
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

        .subtitle {
            font-size: 10px;
            color: #666;
            margin-bottom: 8px;
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
            color: #333;
        }

        .info-line strong {
            color: #8B0000;
            display: inline-block;
            width: 75px;
        }
    </style>
</head>
<body>
    <div class="card">
        
        {{-- Logo Pramuka SVG inline --}}
        <svg class="logo-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="48" fill="#8B0000" opacity="0.1"/>
            <circle cx="50" cy="50" r="42" fill="none" stroke="#8B0000" stroke-width="2"/>
            <!-- Tunas kelapa -->
            <rect x="47" y="52" width="6" height="28" fill="#8B0000" rx="2"/>
            <ellipse cx="31" cy="38" rx="16" ry="7" fill="#8B0000" transform="rotate(-28 31 38)"/>
            <ellipse cx="28" cy="46" rx="13" ry="5" fill="#6B0000" transform="rotate(-48 28 46)"/>
            <ellipse cx="69" cy="38" rx="16" ry="7" fill="#8B0000" transform="rotate(28 69 38)"/>
            <ellipse cx="72" cy="46" rx="13" ry="5" fill="#6B0000" transform="rotate(48 72 46)"/>
            <ellipse cx="50" cy="28" rx="8" ry="19" fill="#A00000"/>
            <ellipse cx="50" cy="52" rx="6" ry="5" fill="#8B0000"/>
            <path d="M45 77 Q41 82 37 80M50 79 Q50 84 50 83M55 77 Q59 82 63 80" stroke="#8B0000" stroke-width="2" fill="none" stroke-linecap="round"/>
            <polygon points="50,12 52.5,19 60,19 54,23.5 56.5,31 50,26.5 43.5,31 46,23.5 40,19 47.5,19" fill="#FFD700" stroke="#DAA520" stroke-width="0.5"/>
        </svg>

        <div class="title">Kartu Tanda Anggota</div>
        <div class="subtitle">Gerakan Pramuka Indonesia</div>

        <div class="name">{{ $anggota->nama }}</div>

        <div class="info-box">
            <div class="info-line">
                <strong>KTA:</strong> {{ $anggota->nomor_anggota }}
            </div>
            <div class="info-line">
                <strong>Golongan:</strong> {{ $anggota->golongan_pramuka }}
            </div>
            <div class="info-line">
                <strong>No Telp:</strong> {{ $anggota->no_telp ?? '-' }}
            </div>
        </div>

        <div class="bottom-deco"></div>

    </div>
</body>
</html>