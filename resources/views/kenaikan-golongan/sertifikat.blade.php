<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kenaikan Golongan - {{ $kenaikan->nomor_sertifikat }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            background: #fff;
            width: 297mm;
            height: 210mm;
            overflow: hidden;
        }

        .page {
            width: 297mm;
            height: 210mm;
            position: relative;
            background: #fff;
        }

        /* ====== BORDER DEKORATIF ====== */
        .outer-border {
            position: absolute;
            top: 6mm;
            left: 6mm;
            right: 6mm;
            bottom: 6mm;
            border: 3px solid #7B2D00;
        }

        .inner-border {
            position: absolute;
            top: 10mm;
            left: 10mm;
            right: 10mm;
            bottom: 10mm;
            border: 1px solid #C5922B;
        }

        /* ====== ORNAMEN SUDUT ====== */
        .corner {
            position: absolute;
            width: 20mm;
            height: 20mm;
            font-size: 28pt;
            color: #7B2D00;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .corner-tl { top: 6mm;  left: 6mm;   }
        .corner-tr { top: 6mm;  right: 6mm;  transform: scaleX(-1); }
        .corner-bl { bottom: 6mm; left: 6mm; transform: scaleY(-1); }
        .corner-br { bottom: 6mm; right: 6mm; transform: scale(-1, -1); }

        /* ====== HEADER / KOP ====== */
        .header {
            position: relative;
            text-align: center;
            padding: 16mm 25mm 6mm;
            border-bottom: 2px solid #C5922B;
            margin: 12mm 12mm 0;
            background: linear-gradient(135deg, #fdf6ec 0%, #fff 100%);
        }

        .logo-area {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10mm;
            margin-bottom: 3mm;
        }

        .logo-placeholder {
            width: 18mm;
            height: 18mm;
            border: 2px solid #C5922B;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 7pt;
            color: #C5922B;
            text-align: center;
        }

        .org-info {
            text-align: center;
        }

        .org-name {
            font-size: 11pt;
            font-weight: bold;
            color: #7B2D00;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .org-sub {
            font-size: 8pt;
            color: #555;
        }

        /* ====== JUDUL SERTIFIKAT ====== */
        .title-section {
            text-align: center;
            margin: 5mm 12mm 0;
            padding: 4mm 0 2mm;
        }

        .cert-label {
            font-size: 9pt;
            letter-spacing: 5px;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 1mm;
        }

        .cert-title {
            font-size: 24pt;
            font-weight: bold;
            color: #7B2D00;
            letter-spacing: 2px;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .cert-subtitle {
            font-size: 10pt;
            color: #C5922B;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 1mm;
        }

        /* ====== DIVIDER ====== */
        .divider {
            text-align: center;
            margin: 2mm 12mm;
            color: #C5922B;
            font-size: 12pt;
            letter-spacing: 3px;
        }

        /* ====== BODY CONTENT ====== */
        .content {
            margin: 0 12mm;
            text-align: center;
            padding: 2mm 10mm;
        }

        .given-to {
            font-size: 9pt;
            color: #666;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 1mm;
        }

        .member-name {
            font-size: 22pt;
            font-weight: bold;
            color: #2c2c2c;
            font-family: 'Georgia', serif;
            border-bottom: 2px solid #C5922B;
            display: inline-block;
            padding: 0 10mm;
            margin-bottom: 2mm;
            line-height: 1.4;
        }

        .member-meta {
            font-size: 8.5pt;
            color: #555;
            margin-bottom: 3mm;
        }

        .promotion-text {
            font-size: 9.5pt;
            color: #333;
            margin-bottom: 3mm;
            line-height: 1.6;
        }

        /* ====== GOLONGAN BOX ====== */
        .golongan-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8mm;
            margin: 2mm 0 4mm;
        }

        .golongan-box {
            text-align: center;
            padding: 3mm 8mm;
            border: 2px solid #C5922B;
            border-radius: 4px;
            min-width: 35mm;
            background: #fdf6ec;
        }

        .golongan-box .label {
            font-size: 7pt;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 1mm;
        }

        .golongan-box .value {
            font-size: 11pt;
            font-weight: bold;
            color: #7B2D00;
        }

        .arrow {
            font-size: 18pt;
            color: #C5922B;
            font-weight: bold;
        }

        /* ====== FOOTER / TANDA TANGAN ====== */
        .footer {
            position: absolute;
            bottom: 14mm;
            left: 12mm;
            right: 12mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 0 8mm;
        }

        .footer-left {
            text-align: center;
        }

        .footer-center {
            text-align: center;
        }

        .footer-right {
            text-align: center;
        }

        .cert-number {
            font-size: 7.5pt;
            color: #888;
            margin-bottom: 1mm;
        }

        .cert-number strong {
            color: #555;
            font-size: 8pt;
        }

        .cert-date {
            font-size: 8pt;
            color: #555;
            margin-bottom: 1mm;
        }

        .ttd-label {
            font-size: 7.5pt;
            color: #666;
            margin-bottom: 0.5mm;
        }

        .ttd-space {
            height: 12mm;
            border-bottom: 1px solid #aaa;
            width: 45mm;
            margin: 0 auto;
        }

        .ttd-name {
            font-size: 8.5pt;
            font-weight: bold;
            color: #333;
            margin-top: 1mm;
        }

        .ttd-role {
            font-size: 7.5pt;
            color: #777;
        }

        /* ====== LENCANA / WATERMARK ====== */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 60pt;
            color: rgba(197, 146, 43, 0.06);
            font-weight: bold;
            white-space: nowrap;
            pointer-events: none;
            z-index: 0;
            letter-spacing: 5px;
        }

        .accent-strip {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4mm;
            background: linear-gradient(90deg, #7B2D00, #C5922B, #7B2D00);
        }

        .accent-strip-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4mm;
            background: linear-gradient(90deg, #7B2D00, #C5922B, #7B2D00);
        }
    </style>
</head>
<body>
<div class="page">

    <!-- Accent strips -->
    <div class="accent-strip"></div>
    <div class="accent-strip-bottom"></div>

    <!-- Borders -->
    <div class="outer-border"></div>
    <div class="inner-border"></div>

    <!-- Corner ornaments -->
    <div class="corner corner-tl">❧</div>
    <div class="corner corner-tr">❧</div>
    <div class="corner corner-bl">❧</div>
    <div class="corner corner-br">❧</div>

    <!-- Watermark -->
    <div class="watermark">PRAMUKA</div>

    <!-- Header -->
    <div class="header">
        <div class="logo-area">
            <div class="logo-placeholder">LOGO<br>KWARCAB</div>
            <div class="org-info">
                <div class="org-name">Gerakan Pramuka</div>
                <div class="org-name" style="font-size: 9.5pt;">Kwartir Cabang</div>
                <div class="org-sub">Telp. (xxx) xxx-xxxx &nbsp;|&nbsp; Email: kwarcab@pramuka.or.id</div>
            </div>
            <div class="logo-placeholder">LOGO<br>GUDEP</div>
        </div>
    </div>

    <!-- Title -->
    <div class="title-section">
        <div class="cert-label">Diberikan kepada</div>
        <div class="cert-title">Sertifikat</div>
        <div class="cert-subtitle">Kenaikan Golongan Pramuka</div>
    </div>

    <div class="divider">— ✦ —</div>

    <!-- Content -->
    <div class="content">
        <div class="given-to">Dengan bangga diberikan kepada</div>
        <div class="member-name">{{ $kenaikan->anggota->nama }}</div>
        <div class="member-meta">
            No. Anggota: {{ $kenaikan->anggota->nomor_anggota }}
            &nbsp;|&nbsp; NIK: {{ $kenaikan->anggota->nik }}
        </div>

        <div class="promotion-text">
            Telah berhasil memenuhi syarat dan dinyatakan naik golongan dalam Gerakan Pramuka
        </div>

        <div class="golongan-row">
            <div class="golongan-box">
                <div class="label">Golongan Asal</div>
                <div class="value">{{ $kenaikan->golongan_awal }}</div>
            </div>
            <div class="arrow">➜</div>
            <div class="golongan-box">
                <div class="label">Golongan Baru</div>
                <div class="value">{{ $kenaikan->golongan_tujuan }}</div>
            </div>
        </div>

        @if($kenaikan->catatan)
        <div style="font-size: 8pt; color: #777; font-style: italic; margin-top: 1mm;">
            "{{ $kenaikan->catatan }}"
        </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-left">
            <div class="cert-number">No. Sertifikat</div>
            <div class="cert-number"><strong>{{ $kenaikan->nomor_sertifikat }}</strong></div>
            <div class="cert-date" style="margin-top: 1mm;">
                Ditetapkan: {{ \Carbon\Carbon::parse($kenaikan->tanggal_kenaikan)->translatedFormat('d F Y') }}
            </div>
        </div>

        <div class="footer-center">
            <div style="font-size: 7pt; color: #aaa; letter-spacing: 1px;">⬡ PRAMUKA ⬡</div>
        </div>

        <div class="footer-right">
            <div class="ttd-label">Ketua Kwartir Cabang,</div>
            <div class="ttd-space"></div>
            <div class="ttd-name">______________________</div>
            <div class="ttd-role">Pembina Utama</div>
        </div>
    </div>

</div>
</body>
</html>