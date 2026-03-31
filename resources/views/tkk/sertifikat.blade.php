<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat TKK</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            background: #fff;
            width: 794px;
            height: 1123px;
            overflow: hidden;
        }

        .page {
            width: 794px;
            height: 1123px;
            position: relative;
            overflow: hidden;
        }

        /* --- Decorative frames --- */
        .frame-outer {
            position: absolute;
            top: 20px; left: 20px; right: 20px; bottom: 20px;
            border: 3px solid #1a5c1a;
            z-index: 1;
        }
        .frame-inner {
            position: absolute;
            top: 30px; left: 30px; right: 30px; bottom: 30px;
            border: 1px solid #2d7a2d;
            z-index: 1;
        }

        /* TKK: corner ornament berbeda — diamond shape */
        .corner {
            position: absolute;
            width: 50px;
            height: 50px;
            z-index: 2;
        }
        .corner-tl { top: 20px;    left: 20px;   border-top: 3px solid #C5922B; border-left: 3px solid #C5922B; }
        .corner-tr { top: 20px;    right: 20px;  border-top: 3px solid #C5922B; border-right: 3px solid #C5922B; }
        .corner-bl { bottom: 20px; left: 20px;   border-bottom: 3px solid #C5922B; border-left: 3px solid #C5922B; }
        .corner-br { bottom: 20px; right: 20px;  border-bottom: 3px solid #C5922B; border-right: 3px solid #C5922B; }

        /* Badge TKK di pojok — khas pembeda dari kenaikan golongan */
        .badge-tkk {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 62px;
            height: 62px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .badge-tkk svg {
            width: 62px;
            height: 62px;
        }

        /* --- Content --- */
        .content {
            position: relative;
            z-index: 5;
            width: 794px;
            padding: 46px 46px 46px 46px;
        }

        /* ===================== HEADER ===================== */
        .header {
            width: 100%;
            margin-bottom: 5mm;
            border-bottom: 2px solid #1a5c1a;
            padding-bottom: 3mm;
            overflow: hidden;
        }

        .header-logo {
            float: left;
            width: 70px;
            margin-right: 15px;
            text-align: center;
        }

        .header-logo img {
            width: 65px;
            height: 65px;
        }

        .header-text {
            overflow: hidden;
        }

        .org-name {
            font-size: 13pt;
            font-weight: bold;
            color: #1a5c1a;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.2;
            margin-bottom: 2px;
        }

        .org-sub {
            font-size: 9pt;
            font-weight: bold;
            color: #2d7a2d;
            line-height: 1.4;
            margin-bottom: 1px;
        }

        .org-loc {
            font-size: 8pt;
            color: #555;
            margin-top: 2px;
        }

        /* ===================== TITLE ===================== */
        .title-section {
            text-align: center;
            margin: 8px 0 4px 0;
            width: 702px;
            clear: both;
        }

        .title-main {
            font-size: 30pt;
            font-weight: bold;
            color: #1a5c1a;
            letter-spacing: 8px;
            text-transform: uppercase;
            line-height: 1;
        }

        .title-sub {
            font-size: 9pt;
            color: #2d7a2d;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: bold;
            margin-top: 3px;
        }

        /* TKK: divider dua warna — hijau + emas */
        .divider {
            width: 55%;
            margin: 5px auto;
            height: 4px;
            background: linear-gradient(to right, #1a5c1a 40%, #C5922B 40%, #C5922B 60%, #1a5c1a 60%);
        }

        .title-nomor {
            font-size: 8.5pt;
            color: #666;
        }

        .title-nomor strong {
            color: #1a5c1a;
            font-family: 'Courier New', monospace;
        }

        /* TKK: ornamen berbeda — pakai simbol TKK */
        .ornament {
            text-align: center;
            color: #C5922B;
            font-size: 10pt;
            margin: 2mm 0 4mm 0;
            letter-spacing: 6px;
        }

        /* ===================== BODY ===================== */
        .body-section {
            margin-top: 4px;
            width: 702px;
        }

        .intro-text {
            font-size: 9pt;
            color: #555;
            font-style: italic;
            text-align: center;
            line-height: 1.6;
            margin-bottom: 8px;
        }

        .member-name {
            font-size: 20pt;
            font-weight: bold;
            font-style: italic;
            color: #111;
            font-family: Georgia, 'Times New Roman', serif;
            text-align: center;
            padding-bottom: 4px;
            border-bottom: 2px solid #C5922B;
            margin-bottom: 8px;
            word-wrap: break-word;
        }

        /* ===================== DATA TABLE ===================== */
        .data-table {
            width: 400px;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 8px;
        }

        .data-table td {
            font-size: 9pt;
            color: #333;
            padding: 2px 0;
            vertical-align: top;
            word-wrap: break-word;
        }

        .data-table .lbl {
            width: 40px;
            color: #444;
            text-align: left;
        }
        .data-table .sep {
            width: 18px;
            text-align: center;
        }
        .data-table .val {
            color: #111;
            text-align: left;
        }
        .data-table .val.green {
            font-weight: bold;
            color: #1a5c1a;
        }
        /* TKK khusus: nilai TKK warna emas */
        .data-table .val.gold {
            font-weight: bold;
            color: #C5922B;
        }

        /* ===================== PARAGRAPHS ===================== */
        .achievement-text {
            font-size: 9pt;
            line-height: 1.75;
            text-align: justify;
            color: #111;
            margin-bottom: 6px;
            word-wrap: break-word;
            width: 702px;
        }

        .achievement-text .bold { font-weight: bold; text-transform: uppercase; }
        .achievement-text .green { font-weight: bold; color: #1a5c1a; }
        .achievement-text .gold { font-weight: bold; color: #C5922B; }

        .closing-text {
            font-size: 8pt;
            line-height: 1.6;
            color: #555;
            font-style: italic;
            text-align: justify;
            word-wrap: break-word;
            width: 702px;
        }

        /* ===================== SIGNATURE ===================== */
        .signature-section {
            margin-top: 16px;
            padding-top: 8px;
            border-top: 1.5px solid #2d7a2d;
            width: 702px;
        }

        .sig-table {
            width: 702px;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .sig-left {
            width: 310px;
            vertical-align: bottom;
            padding-right: 10px;
        }

        .sig-left-text {
            font-size: 7pt;
            color: #999;
            line-height: 1.5;
        }

        .sig-right {
            width: 392px;
            text-align: center;
            vertical-align: top;
        }

        .sig-place-date {
            font-size: 9pt;
            color: #333;
            line-height: 1.7;
        }

        .sig-role {
            font-size: 9.5pt;
            font-weight: bold;
            color: #222;
            margin-top: 4px;
            margin-bottom: 34px;
        }

        .sig-name {
            font-size: 9.5pt;
            font-weight: bold;
            color: #111;
            border-top: 1px solid #444;
            display: inline-block;
            padding-top: 3px;
            min-width: 160px;
        }

        .sig-nip {
            font-size: 7.5pt;
            color: #666;
            margin-top: 2px;
        }
    </style>
</head>
<body>
<div class="page">

    <!-- Decorative border frames -->
    <div class="frame-outer"></div>
    <div class="frame-inner"></div>
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

    <!-- All content in normal flow -->
    <div class="content">

        <!-- HEADER -->
        <div class="header">
            <div class="header-logo">
                @php
                    $logoPath = public_path('storage/logo-pramukaaa.png');
                    if (!file_exists($logoPath)) {
                        $logoPath = public_path('logo-pramukaaa.png');
                    }
                    if (!file_exists($logoPath)) {
                        $logoPath = storage_path('app/public/logo-pramukaaa.png');
                    }
                @endphp

                @if(file_exists($logoPath))
                    <img src="{{ $logoPath }}" alt="Logo Pramuka">
                @else
                    <div style="width:65px;height:65px;border:2px solid #1a5c1a;border-radius:50%;display:inline-block;line-height:65px;background:#f0f9f0;font-size:8pt;color:#1a5c1a;font-weight:bold;">LOGO<br>PRAMUKA</div>
                @endif
            </div>
            <div class="header-text">
                <div class="org-name">GERAKAN PRAMUKA</div>
                <div class="org-sub">Kwartir Daerah 11 Jawa Timur</div>
                <div class="org-sub">Gugus Depan {{ $settings->nomor_gugus_depan ?? '11.021-11.022' }}</div>
                <div class="org-loc">Kwartir Cabang &mdash; Kota Surabaya</div>
            </div>
        </div>

        <!-- TITLE -->
        <div class="title-section">
            <div class="title-main">SERTIFIKAT</div>
            <div class="title-sub">Tanda Kecakapan Khusus (TKK)</div>
            <div class="divider"></div>
            <div class="title-nomor">Nomor: <strong>{{ $tkk->nomor_sertifikat }}</strong></div>
        </div>

        <div class="ornament">&#9670; &mdash; &#9670; &mdash; &#9670;</div>

        <!-- BODY -->
        <div class="body-section">

            <div class="intro-text">
                Yang bertanda tangan di bawah ini, Ketua Gugus Depan Gerakan Pramuka,<br>
                dengan ini menerangkan bahwa:
            </div>

            <div class="member-name">{{ $tkk->anggota->nama }}</div>

            <table class="data-table">
                <tr>
                    <td class="lbl">Tempat / Tanggal Lahir</td>
                    <td class="sep">:</td>
                    <td class="val">
                        {{ $tkk->anggota->tempat_lahir }},
                        {{ \Carbon\Carbon::parse($tkk->anggota->tanggal_lahir)->translatedFormat('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td class="lbl">Nomor Anggota</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $tkk->anggota->nomor_anggota }}</td>
                </tr>
                <tr>
                    <td class="lbl">Golongan Pramuka</td>
                    <td class="sep">:</td>
                    <td class="val green">{{ $tkk->golongan_sekarang }}</td>
                </tr>
                <tr>
                    <td class="lbl">Tanda Kecakapan Khusus</td>
                    <td class="sep">:</td>
                    <td class="val gold">
                        {{ $tkk->nama_tkk }}
                        @if($tkk->tingkat)
                            <span style="font-weight:normal;color:#888;font-size:8pt;">({{ $tkk->tingkat }})</span>
                        @endif
                    </td>
                </tr>
            </table>

            <div class="achievement-text">
                Telah menyelesaikan Syarat Kecakapan Khusus (SKK) bidang
                <span class="gold">{{ strtoupper($tkk->nama_tkk) }}</span>
                @if($tkk->tingkat)
                    tingkat <span class="bold">{{ strtoupper($tkk->tingkat) }}</span>
                @endif
                pada hari, tanggal
                <span class="green">{{ \Carbon\Carbon::parse($tkk->tanggal_penetapan)->translatedFormat('l, d F Y') }}</span>
                dan telah dinyatakan <span class="bold">LULUS</span> ujian TKK
                dengan penguji <strong>{{ $tkk->nama_penguji }}</strong>
                @if($tkk->penguji_is_pembina)
                    <span style="font-size:8.5pt;color:#666;">(Pembina Pramuka)</span>
                @endif,
                serta berhak memakai Tanda Kecakapan Khusus sesuai bidang yang dicapai.
            </div>

            @if($tkk->catatan)
            <div class="achievement-text" style="background:#fffbf2;border-left:3px solid #C5922B;padding:4px 8px;margin-bottom:6px;">
                <span style="font-style:italic;color:#888;">Catatan:</span> {{ $tkk->catatan }}
            </div>
            @endif

            <div class="closing-text">
                Dengan harapan semoga senantiasa meningkatkan keterampilan dan pengetahuannya
                dalam bidang ini, berdasarkan Tri Satya dan Dasa Darma Pramuka,
                serta terus berprestasi demi kemajuan Gerakan Pramuka Indonesia.
            </div>

        </div>

        <!-- SIGNATURE -->
        <div class="signature-section">
            <table class="sig-table">
                <tr>
                    <td class="sig-left">
                        <div class="sig-left-text">
                            Sertifikat ini diterbitkan secara resmi<br>
                            oleh Gugus Depan Gerakan Pramuka<br>
                            Kwartir Cabang Kota Surabaya
                        </div>
                    </td>
                    <td class="sig-right">
                        <div class="sig-place-date">
                            Ditetapkan di: <strong>{{ $tkk->tempat_penetapan ?? 'Surabaya' }}</strong>
                        </div>
                        <div class="sig-place-date">
                            Pada Tanggal: <strong>{{ \Carbon\Carbon::parse($tkk->tanggal_penetapan)->translatedFormat('d F Y') }}</strong>
                        </div>
                        <div class="sig-role">Ketua Gugus Depan,</div>
                        @php $ketua = $settings->getKetuaPembina(); @endphp
                        <div>
                            <span class="sig-name">{{ $ketua['nama'] ?? 'Ketua Pembina' }}</span>
                        </div>
                        @if(!empty($ketua['nip']))
                            <div class="sig-nip">NIP. {{ $ketua['nip'] }}</div>
                        @endif
                        <div class="sig-nip">Pembina Pramuka</div>
                    </td>
                </tr>
            </table>
        </div>

    </div><!-- /content -->
</div><!-- /page -->
</body>
</html>