<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sertifikat Kenaikan Golongan</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Times New Roman', serif; }

/* Page A4 portrait */
.page {
    width: 210mm;
    height: 297mm;
    background: #fff;
    position: relative;
    overflow: hidden;
}

/* Border tali hijau - outer + inner */
.rope-outer { position: absolute; z-index: 10; }
.rope-outer.h { left: 0; right: 0; height: 6px; background: repeating-linear-gradient(90deg, #0f5c0f 0, #0f5c0f 5px, #3d9e3d 5px, #3d9e3d 8px, #0f5c0f 8px, #0f5c0f 11px, #c8e8c8 11px, #c8e8c8 13px); }
.rope-outer.v { top: 0; bottom: 0; width: 6px; background: repeating-linear-gradient(180deg, #0f5c0f 0, #0f5c0f 5px, #3d9e3d 5px, #3d9e3d 8px, #0f5c0f 8px, #0f5c0f 11px, #c8e8c8 11px, #c8e8c8 13px); }
.rope-outer.top { top: 0; }
.rope-outer.bottom { bottom: 0; }
.rope-outer.left { left: 0; }
.rope-outer.right { right: 0; }

.rope-inner { position: absolute; z-index: 10; }
.rope-inner.h { left: 8mm; right: 8mm; height: 3px; background: repeating-linear-gradient(90deg, #1a6b1a 0, #1a6b1a 4px, #6db86d 4px, #6db86d 6px, #1a6b1a 6px, #1a6b1a 9px, transparent 9px, transparent 11px); }
.rope-inner.v { top: 8mm; bottom: 8mm; width: 3px; background: repeating-linear-gradient(180deg, #1a6b1a 0, #1a6b1a 4px, #6db86d 4px, #6db86d 6px, #1a6b1a 6px, #1a6b1a 9px, transparent 9px, transparent 11px); }
.rope-inner.top { top: 8mm; }
.rope-inner.bottom { bottom: 8mm; }
.rope-inner.left { left: 8mm; }
.rope-inner.right { right: 8mm; }

/* Simpul sudut */
.knot {
    position: absolute;
    width: 17mm; height: 17mm;
    background: #fff;
    border-radius: 50%;
    border: 3px solid #0f5c0f;
    display: flex; align-items: center; justify-content: center;
    z-index: 20;
}
.knot::before { content: ''; position: absolute; width: 11mm; height: 11mm; border-radius: 50%; border: 2px solid #2d7a2d; }
.knot::after { content: '★'; position: absolute; color: #1a6b1a; font-size: 10.5pt; }
.k-tl { top: 0; left: 0; }
.k-tr { top: 0; right: 0; }
.k-bl { bottom: 0; left: 0; }
.k-br { bottom: 0; right: 0; }

/* Watermark */
.wm { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-35deg); font-size: 72pt; font-weight: bold; color: rgba(45, 122, 45, 0.04); letter-spacing: 10px; white-space: nowrap; pointer-events: none; z-index: 0; }

/* Content wrapper */
.content {
    position: absolute;
    top: 13mm; bottom: 13mm;
    left: 15mm; right: 15mm;
    z-index: 5;
}

/* Header dengan logo pramuka BESAR di kiri */
.header {
    display: flex;
    align-items: flex-start;
    gap: 8mm;
    padding-bottom: 4mm;
    border-bottom: 3px double #1a6b1a;
    margin-bottom: 3mm;
}

.logo-box {
    flex-shrink: 0;
    width: 35mm;
    padding: 3mm;
    border: 2px solid #1a6b1a;
    border-radius: 5px;
    background: #f5fdf5;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2mm;
}

.logo-pramuka-svg {
    width: 28mm;
    height: 28mm;
}

.logo-caption {
    font-size: 7pt;
    color: #1a5c1a;
    font-weight: bold;
    text-align: center;
    text-transform: uppercase;
    line-height: 1.4;
}

.header-text {
    flex: 1;
    padding-top: 2mm;
}

.org-title {
    font-size: 16pt;
    font-weight: bold;
    color: #1a5c1a;
    text-transform: uppercase;
    letter-spacing: 2px;
    line-height: 1.2;
    margin-bottom: 2mm;
}

.org-subtitle {
    font-size: 11pt;
    font-weight: bold;
    color: #2d7a2d;
    text-transform: uppercase;
    margin-bottom: 1mm;
}

.org-location {
    font-size: 9pt;
    color: #555;
    margin-top: 1mm;
}

/* Title sertifikat */
.title-section {
    text-align: center;
    padding: 3mm 0;
}

.title-main {
    font-size: 48pt;
    font-weight: bold;
    color: #1a5c1a;
    letter-spacing: 8px;
    text-transform: uppercase;
    line-height: 1;
    text-shadow: 2px 2px 0 #c8e8c8;
}

.title-sub {
    font-size: 11pt;
    color: #2d7a2d;
    letter-spacing: 5px;
    text-transform: uppercase;
    margin-top: 2mm;
}

.title-nomor {
    font-size: 9pt;
    color: #666;
    margin-top: 2mm;
}

.title-nomor strong {
    color: #1a5c1a;
    font-size: 10pt;
}

.title-rule {
    border: none;
    border-top: 2.5px solid #2d7a2d;
    width: 70%;
    margin: 2mm auto 0;
}

/* Deco */
.deco {
    text-align: center;
    color: #2d7a2d;
    font-size: 13pt;
    padding: 2mm 0;
    letter-spacing: 5px;
}

/* Body content */
.body-text {
    padding: 3mm 8mm;
    line-height: 2.2;
    text-align: justify;
    font-size: 11pt;
    color: #111;
}

.intro-text {
    font-size: 10pt;
    font-style: italic;
    color: #555;
    margin-bottom: 3mm;
}

.member-name {
    font-size: 26pt;
    font-weight: bold;
    font-style: italic;
    color: #111;
    font-family: 'Georgia', serif;
    text-align: center;
    padding: 2mm 0;
    border-bottom: 2px solid #2d7a2d;
    margin-bottom: 4mm;
}

.data-row {
    display: flex;
    padding: 1.5mm 0;
    font-size: 11pt;
}

.data-label {
    width: 45mm;
    color: #444;
    font-weight: normal;
}

.data-sep {
    width: 8mm;
    text-align: center;
}

.data-value {
    flex: 1;
    color: #111;
    font-weight: normal;
}

.data-value.bold {
    font-weight: bold;
    color: #1a5c1a;
    font-size: 12pt;
}

.body-text .hl {
    font-weight: bold;
    text-transform: uppercase;
}

/* Footer dengan TTD */
.footer {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding-top: 5mm;
    border-top: 2px solid #2d7a2d;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
}

.footer-left {
    font-size: 8pt;
    color: #aaa;
    line-height: 1.8;
    max-width: 45%;
}

.ttd-section {
    text-align: center;
    min-width: 70mm;
}

.ttd-location {
    font-size: 10pt;
    color: #333;
    margin-bottom: 0.5mm;
}

.ttd-date {
    font-size: 10pt;
    color: #333;
    margin-bottom: 3mm;
}

.ttd-role {
    font-size: 10.5pt;
    color: #222;
    font-weight: bold;
    margin-bottom: 1mm;
}

/* TTD DUMMY dengan SVG signature */
.ttd-signature {
    height: 22mm;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ttd-signature-svg {
    width: 60mm;
    height: 20mm;
}

.ttd-name {
    font-size: 11pt;
    font-weight: bold;
    color: #111;
    margin-top: 0;
    padding-top: 1mm;
    border-top: 1.5px solid #444;
    display: inline-block;
    min-width: 60mm;
}

.ttd-nip {
    font-size: 9pt;
    color: #666;
    margin-top: 1mm;
}
</style>
</head>
<body>
<div class="page">

<!-- Rope borders -->
<div class="rope-outer h top"></div>
<div class="rope-outer h bottom"></div>
<div class="rope-outer v left"></div>
<div class="rope-outer v right"></div>

<div class="rope-inner h top"></div>
<div class="rope-inner h bottom"></div>
<div class="rope-inner v left"></div>
<div class="rope-inner v right"></div>

<!-- Knots -->
<div class="knot k-tl"></div>
<div class="knot k-tr"></div>
<div class="knot k-bl"></div>
<div class="knot k-br"></div>

<!-- Watermark -->
<div class="wm">PRAMUKA</div>

<div class="content">

    <!-- HEADER dengan logo pramuka besar di kiri -->
    <div class="header">
        <div class="logo-box">
            <svg class="logo-pramuka-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="48" fill="#fff" stroke="#1a6b1a" stroke-width="3"/>
                <circle cx="50" cy="50" r="42" fill="none" stroke="#2d7a2d" stroke-width="1.5"/>
                <!-- Tunas kelapa -->
                <rect x="47" y="52" width="6" height="28" fill="#1a6b1a" rx="2"/>
                <ellipse cx="31" cy="38" rx="16" ry="7" fill="#2d7a2d" transform="rotate(-28 31 38)"/>
                <ellipse cx="28" cy="46" rx="13" ry="5" fill="#1a6b1a" transform="rotate(-48 28 46)"/>
                <ellipse cx="69" cy="38" rx="16" ry="7" fill="#2d7a2d" transform="rotate(28 69 38)"/>
                <ellipse cx="72" cy="46" rx="13" ry="5" fill="#1a6b1a" transform="rotate(48 72 46)"/>
                <ellipse cx="50" cy="28" rx="8" ry="19" fill="#3d8b3d"/>
                <ellipse cx="50" cy="52" rx="6" ry="5" fill="#1a6b1a"/>
                <path d="M45 77 Q41 82 37 80M50 79 Q50 84 50 83M55 77 Q59 82 63 80" stroke="#1a6b1a" stroke-width="2" fill="none" stroke-linecap="round"/>
                <!-- Bintang -->
                <polygon points="50,12 52.5,19 60,19 54,23.5 56.5,31 50,26.5 43.5,31 46,23.5 40,19 47.5,19" fill="#FFD700" stroke="#DAA520" stroke-width="0.5"/>
            </svg>
            <div class="logo-caption">Gerakan<br>Pramuka<br>Indonesia</div>
        </div>

        <div class="header-text">
            <div class="org-title">Gerakan Pramuka</div>
            <div class="org-subtitle">Kwartir Daerah 11 Jawa Timur</div>
            <div class="org-subtitle">Gugus Depan {{ $kenaikan->anggota->gugus_depan ?? '11.021-11.022' }}</div>
            <div class="org-location">Kwartir Cabang — Kota Surabaya</div>
        </div>
    </div>

    <!-- TITLE -->
    <div class="title-section">
        <div class="title-main">SERTIFIKAT</div>
        <div class="title-sub">Kenaikan Golongan Pramuka</div>
        <div class="title-nomor">Nomor: <strong>{{ $kenaikan->nomor_sertifikat }}</strong></div>
        <hr class="title-rule">
    </div>

    <div class="deco">— ❧ ✦ ❧ —</div>

    <!-- BODY TEXT -->
    <div class="body-text">
        <div class="intro-text">
            Yang bertanda tangan di bawah ini, Ketua Gugus Depan Gerakan Pramuka, dengan ini menerangkan bahwa:
        </div>

        <div class="member-name">{{ $kenaikan->anggota->nama }}</div>

        <div class="data-row">
            <div class="data-label">Tempat / Tanggal Lahir</div>
            <div class="data-sep">:</div>
            <div class="data-value">
                {{ $kenaikan->anggota->tempat_lahir }}, 
                {{ \Carbon\Carbon::parse($kenaikan->anggota->tanggal_lahir)->translatedFormat('d F Y') }}
            </div>
        </div>

        <div class="data-row">
            <div class="data-label">Nomor Anggota</div>
            <div class="data-sep">:</div>
            <div class="data-value">{{ $kenaikan->anggota->nomor_anggota }}</div>
        </div>

        <div class="data-row">
            <div class="data-label">Golongan Pramuka</div>
            <div class="data-sep">:</div>
            <div class="data-value bold">{{ $kenaikan->golongan_tujuan }}</div>
        </div>

        <p style="margin-top: 4mm; line-height: 2.2;">
            Telah menyelesaikan Syarat Kecakapan Umum (SKU) Pramuka 
            <span class="hl">{{ strtoupper($kenaikan->golongan_tujuan) }}</span>
            pada hari, tanggal 
            <span class="hl">{{ \Carbon\Carbon::parse($kenaikan->tanggal_kenaikan)->translatedFormat('l, d F Y') }}</span>
            dan dinyatakan <strong>NAIK GOLONGAN</strong> dari 
            <span class="hl">{{ strtoupper($kenaikan->golongan_awal) }}</span> menjadi 
            <span class="hl">{{ strtoupper($kenaikan->golongan_tujuan) }}</span>
            dalam Gerakan Pramuka Indonesia, 
            serta berhak memakai Tanda Kecakapan Umum sesuai golongan yang dicapai.
        </p>

        <p style="margin-top: 3mm; line-height: 2.0; color: #444; font-size: 10.5pt;">
            Dengan harapan semoga senantiasa meningkatkan keterampilan dan pengetahuannya 
            berdasarkan Tri Satya dan Dasa Darma Pramuka, 
            serta terus berprestasi demi kemajuan Gerakan Pramuka Indonesia.
        </p>
    </div>

    <!-- FOOTER TTD -->
    <div class="footer">
        <div class="footer-left">
            Sertifikat ini diterbitkan secara resmi<br>
            oleh Gugus Depan Gerakan Pramuka<br>
            Kwartir Cabang Kota Surabaya
        </div>

        <div class="ttd-section">
            <div class="ttd-location">
                Ditetapkan di: <strong>{{ $kenaikan->tempat_ditetapkan ?? 'Surabaya' }}</strong>
            </div>
            <div class="ttd-date">
                Pada Tanggal: <strong>{{ \Carbon\Carbon::parse($kenaikan->tanggal_kenaikan)->translatedFormat('d F Y') }}</strong>
            </div>
            <div class="ttd-role">Ketua Gugus Depan,</div>

            <!-- TTD DUMMY dengan SVG signature -->
            <div class="ttd-signature">
                <svg class="ttd-signature-svg" viewBox="0 0 200 60" xmlns="http://www.w3.org/2000/svg">
                    <!-- Signature dummy - garis bergelombang mirip tanda tangan -->
                    <path d="M10,30 Q30,15 50,30 T90,30 Q110,40 130,25 T170,30 Q180,35 190,30" 
                          stroke="#000" stroke-width="2" fill="none" stroke-linecap="round"/>
                    <path d="M40,35 Q50,28 60,35 T80,35" 
                          stroke="#000" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                    <circle cx="100" cy="20" r="2" fill="#000"/>
                </svg>
            </div>

            <div class="ttd-name">Drs. Bambang Sudirman, M.Pd.</div>
            <div class="ttd-nip">Pembina Pramuka Utama</div>
            <div class="ttd-nip">NIP. 196512151990031004</div>
        </div>
    </div>

</div>
</div>
</body>
</html>