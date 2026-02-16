<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Preview Sertifikat Pramuka</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Times New Roman', Times, serif; }
.page { width: 210mm; height: 297mm; background: #fff; position: relative; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.4); }
.rope-outer-t,.rope-outer-b{position:absolute;left:0;right:0;height:6px;z-index:10;background:repeating-linear-gradient(90deg,#0f5c0f 0,#0f5c0f 5px,#3d9e3d 5px,#3d9e3d 8px,#0f5c0f 8px,#0f5c0f 11px,#c8e8c8 11px,#c8e8c8 13px)}
.rope-outer-t{top:0}.rope-outer-b{bottom:0}
.rope-outer-l,.rope-outer-r{position:absolute;top:0;bottom:0;width:6px;z-index:10;background:repeating-linear-gradient(180deg,#0f5c0f 0,#0f5c0f 5px,#3d9e3d 5px,#3d9e3d 8px,#0f5c0f 8px,#0f5c0f 11px,#c8e8c8 11px,#c8e8c8 13px)}
.rope-outer-l{left:0}.rope-outer-r{right:0}
.rope-inner-t,.rope-inner-b{position:absolute;left:8mm;right:8mm;height:3px;z-index:10;background:repeating-linear-gradient(90deg,#1a6b1a 0,#1a6b1a 4px,#6db86d 4px,#6db86d 6px,#1a6b1a 6px,#1a6b1a 9px,transparent 9px,transparent 11px)}
.rope-inner-t{top:8mm}.rope-inner-b{bottom:8mm}
.rope-inner-l,.rope-inner-r{position:absolute;top:8mm;bottom:8mm;width:3px;z-index:10;background:repeating-linear-gradient(180deg,#1a6b1a 0,#1a6b1a 4px,#6db86d 4px,#6db86d 6px,#1a6b1a 6px,#1a6b1a 9px,transparent 9px,transparent 11px)}
.rope-inner-l{left:8mm}.rope-inner-r{right:8mm}
.knot{position:absolute;width:17mm;height:17mm;background:#fff;border-radius:50%;border:3px solid #0f5c0f;display:flex;align-items:center;justify-content:center;z-index:20}
.knot::before{content:'';position:absolute;width:11mm;height:11mm;border-radius:50%;border:2px solid #2d7a2d}
.knot::after{content:'★';position:absolute;color:#1a6b1a;font-size:10.5pt}
.k-tl{top:0;left:0}.k-tr{top:0;right:0}.k-bl{bottom:0;left:0}.k-br{bottom:0;right:0}
.wm{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%) rotate(-35deg);font-size:68pt;font-weight:bold;color:rgba(45,122,45,.045);letter-spacing:8px;white-space:nowrap;pointer-events:none;z-index:0}
.main{position:absolute;top:12mm;bottom:12mm;left:12mm;right:12mm;display:flex;flex-direction:column;z-index:5;padding-bottom:28mm}
.hdr{display:flex;align-items:center;justify-content:space-between;padding-bottom:3mm;border-bottom:3px double #1a6b1a;flex-shrink:0}
.hdr-logos{display:flex;align-items:center;gap:3mm}
.lsvg{width:20mm;height:20mm;flex-shrink:0}
.o-name{font-size:13pt;font-weight:bold;color:#1a5c1a;text-transform:uppercase;letter-spacing:1px;line-height:1.15}
.o-gudep{font-size:9pt;font-weight:bold;color:#1a5c1a;text-transform:uppercase}
.o-kwarcab{font-size:7.5pt;color:#444;margin-top:.5mm}
.ttl{text-align:center;padding:3mm 0 1.5mm;flex-shrink:0}
.ttl-main{font-size:44pt;font-weight:bold;color:#1a5c1a;letter-spacing:7px;text-transform:uppercase;line-height:1;text-shadow:2px 2px 0 #b8d8b8}
.ttl-sub{font-size:10.5pt;color:#2d7a2d;letter-spacing:4px;text-transform:uppercase;margin-top:1mm}
.ttl-nomor{font-size:8.5pt;color:#555;margin-top:1.5mm}
.ttl-nomor strong{color:#1a5c1a;font-size:9pt}
.ttl-rule{border:none;border-top:2px solid #2d7a2d;width:72%;margin:2mm auto 0}
.deco{text-align:center;color:#2d7a2d;font-size:12pt;padding:1.5mm 0;flex-shrink:0;letter-spacing:4px}
.body{display:flex;gap:5mm;flex:1;min-height:0}
.col-l{width:34mm;flex-shrink:0;display:flex;flex-direction:column;align-items:center;padding-top:1mm}
.lsvg-big{width:30mm;height:30mm}
.gugus-nm{font-size:7pt;color:#1a5c1a;font-weight:bold;text-align:center;text-transform:uppercase;margin-top:2mm;letter-spacing:.5px;line-height:1.5}
.col-sep{width:1px;background:#2d7a2d;flex-shrink:0;margin:1mm 0}
.col-r{flex:1;display:flex;flex-direction:column;min-width:0}
.intro{font-size:9.5pt;color:#444;font-style:italic;margin-bottom:3mm;line-height:1.5}
.mname{font-size:23pt;font-weight:bold;font-style:italic;color:#111;font-family:'Georgia',serif;line-height:1.2;padding-bottom:2mm;border-bottom:1.5px solid #2d7a2d;margin-bottom:3mm}
.dtbl{width:100%;border-collapse:collapse;margin-bottom:3mm;font-size:10.5pt}
.dtbl td{padding:1.2mm 0;color:#222;vertical-align:top;line-height:1.5}
.dtbl td.lbl{width:38mm;color:#333}
.dtbl td.sep{width:5mm;text-align:center}
.dtbl td.val-b{font-weight:bold;font-size:11pt;color:#1a5c1a}
.para{font-size:10pt;line-height:2.0;text-align:justify;color:#111;margin-bottom:2.5mm}
.para .hl{font-weight:bold;text-transform:uppercase}
.harapan{font-size:10pt;line-height:1.8;text-align:justify;color:#333;padding-top:2.5mm;border-top:1px dashed #a8d5a8;margin-bottom:5mm}

.ts-box{border:1px solid #a8d5a8;border-radius:3px;background:#f5fdf5;padding:4mm 5mm;margin-bottom:6mm}
.ts-title{font-size:9pt;font-weight:bold;color:#1a5c1a;text-align:center;letter-spacing:2px;margin-bottom:1.5mm}
.ts-text{font-size:9pt;color:#444;line-height:1.75;text-align:justify;font-style:italic}
.ftr{position:absolute;bottom:0;left:0;right:0;display:flex;justify-content:space-between;align-items:flex-end;padding-top:3mm;border-top:1.5px solid #2d7a2d}
.ftr-info{font-size:7.5pt;color:#aaa;line-height:1.7}
.ttd{text-align:center;min-width:55mm}
.ttd-issued{font-size:9pt;color:#333;line-height:1.6}
.ttd-role{font-size:9pt;color:#222;margin-top:1.5mm;margin-bottom:.5mm}
.ttd-space{height:26mm}
.ttd-line{border-bottom:1px solid #444;width:55mm;margin:0 auto}
.ttd-name{font-size:10pt;font-weight:bold;color:#111;margin-top:1.5mm}
.ttd-jab{font-size:8.5pt;color:#555}
</style>
</head>
<body>
<div class="page">
<div class="rope-outer-t"></div><div class="rope-outer-b"></div>
<div class="rope-outer-l"></div><div class="rope-outer-r"></div>
<div class="rope-inner-t"></div><div class="rope-inner-b"></div>
<div class="rope-inner-l"></div><div class="rope-inner-r"></div>
<div class="knot k-tl"></div><div class="knot k-tr"></div>
<div class="knot k-bl"></div><div class="knot k-br"></div>
<div class="wm">PRAMUKA</div>

<div class="main">

<div class="hdr">
  <div class="hdr-logos">
    <svg class="lsvg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
      <circle cx="50" cy="50" r="47" fill="#f5fdf5" stroke="#1a6b1a" stroke-width="3"/>
      <circle cx="50" cy="50" r="41" fill="none" stroke="#2d7a2d" stroke-width="1"/>
      <rect x="47" y="53" width="6" height="26" fill="#1a6b1a" rx="2"/>
      <ellipse cx="31" cy="38" rx="16" ry="7" fill="#2d7a2d" transform="rotate(-28 31 38)"/>
      <ellipse cx="28" cy="46" rx="13" ry="5" fill="#1a6b1a" transform="rotate(-48 28 46)"/>
      <ellipse cx="69" cy="38" rx="16" ry="7" fill="#2d7a2d" transform="rotate(28 69 38)"/>
      <ellipse cx="72" cy="46" rx="13" ry="5" fill="#1a6b1a" transform="rotate(48 72 46)"/>
      <ellipse cx="50" cy="28" rx="8" ry="19" fill="#3d8b3d"/>
      <ellipse cx="50" cy="53" rx="6" ry="5" fill="#1a6b1a"/>
      <path d="M45 77 Q41 82 37 80M50 79 Q50 84 50 83M55 77 Q59 82 63 80" stroke="#1a6b1a" stroke-width="2" fill="none" stroke-linecap="round"/>
      <polygon points="50,12 52.5,19 60,19 54,23.5 56.5,31 50,26.5 43.5,31 46,23.5 40,19 47.5,19" fill="#f5c518" stroke="#c8a000" stroke-width="0.5"/>
    </svg>
    <div>
      <div class="o-name">Gerakan Pramuka</div>
      <div class="o-gudep">Gugus Depan {{ $kenaikan->anggota->gugus_depan ?? "___________" }}</div>
      <div class="o-kwarcab">Kwartir Cabang — Kota Surabaya</div>
    </div>
  </div>
  <svg class="lsvg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <circle cx="50" cy="50" r="47" fill="#f5fdf5" stroke="#1a6b1a" stroke-width="3"/>
    <circle cx="50" cy="50" r="41" fill="none" stroke="#2d7a2d" stroke-width="1"/>
    <rect x="47" y="53" width="6" height="26" fill="#1a6b1a" rx="2"/>
    <ellipse cx="31" cy="38" rx="16" ry="7" fill="#2d7a2d" transform="rotate(-28 31 38)"/>
    <ellipse cx="28" cy="46" rx="13" ry="5" fill="#1a6b1a" transform="rotate(-48 28 46)"/>
    <ellipse cx="69" cy="38" rx="16" ry="7" fill="#2d7a2d" transform="rotate(28 69 38)"/>
    <ellipse cx="72" cy="46" rx="13" ry="5" fill="#1a6b1a" transform="rotate(48 72 46)"/>
    <ellipse cx="50" cy="28" rx="8" ry="19" fill="#3d8b3d"/>
    <ellipse cx="50" cy="53" rx="6" ry="5" fill="#1a6b1a"/>
    <path d="M45 77 Q41 82 37 80M50 79 Q50 84 50 83M55 77 Q59 82 63 80" stroke="#1a6b1a" stroke-width="2" fill="none" stroke-linecap="round"/>
    <polygon points="50,12 52.5,19 60,19 54,23.5 56.5,31 50,26.5 43.5,31 46,23.5 40,19 47.5,19" fill="#f5c518" stroke="#c8a000" stroke-width="0.5"/>
  </svg>
</div>

<div class="ttl">
  <div class="ttl-main">SERTIFIKAT</div>
  <div class="ttl-sub">Kenaikan Golongan Pramuka</div>
  <div class="ttl-nomor">Nomor: <strong>{{ $kenaikan->nomor_sertifikat }}</strong></div>
  <hr class="ttl-rule">
</div>

<div class="deco">— ❧ ✦ ❧ —</div>

<div class="body">
  <div class="col-l">
    <svg class="lsvg-big" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
      <circle cx="50" cy="50" r="47" fill="#edf7ed" stroke="#1a6b1a" stroke-width="3"/>
      <circle cx="50" cy="50" r="41" fill="none" stroke="#2d7a2d" stroke-width="1.2"/>
      <rect x="47" y="53" width="6" height="26" fill="#1a6b1a" rx="2"/>
      <ellipse cx="31" cy="38" rx="16" ry="7" fill="#2d7a2d" transform="rotate(-28 31 38)"/>
      <ellipse cx="28" cy="46" rx="13" ry="5" fill="#1a6b1a" transform="rotate(-48 28 46)"/>
      <ellipse cx="69" cy="38" rx="16" ry="7" fill="#2d7a2d" transform="rotate(28 69 38)"/>
      <ellipse cx="72" cy="46" rx="13" ry="5" fill="#1a6b1a" transform="rotate(48 72 46)"/>
      <ellipse cx="50" cy="28" rx="8" ry="19" fill="#3d8b3d"/>
      <ellipse cx="50" cy="53" rx="6" ry="5" fill="#1a6b1a"/>
      <path d="M45 77 Q41 82 37 80M50 79 Q50 84 50 83M55 77 Q59 82 63 80" stroke="#1a6b1a" stroke-width="2" fill="none" stroke-linecap="round"/>
      <polygon points="50,12 52.5,19 60,19 54,23.5 56.5,31 50,26.5 43.5,31 46,23.5 40,19 47.5,19" fill="#f5c518" stroke="#c8a000" stroke-width="0.5"/>
    </svg>
    <div class="gugus-nm">Gugus Depan<br>{{ $kenaikan->anggota->gugus_depan ?? "___________" }}<br>Kota Surabaya</div>
  </div>
  <div class="col-sep"></div>
  <div class="col-r">
    <div class="intro">Yang bertanda tangan di bawah ini, Ketua Gugus Depan Gerakan Pramuka, menerangkan bahwa:</div>
    <div class="mname">{{ $kenaikan->anggota->nama }}</div>
    <table class="dtbl">
      <tr><td class="lbl">Tempat / Tgl. Lahir</td><td class="sep">:</td><td>{{ $kenaikan->anggota->tempat_lahir }}, {{ Carbon::parse($kenaikan->anggota->tanggal_lahir)->translatedFormat("d F Y") }}</td></tr>
      <tr><td class="lbl">Nomor Anggota</td><td class="sep">:</td><td>{{ $kenaikan->anggota->nomor_anggota }}</td></tr>
      <tr><td class="lbl">Golongan Pramuka</td><td class="sep">:</td><td class="val-b">{{ $kenaikan->golongan_tujuan }}</td></tr>
    </table>
    <div class="para">
      Telah menyelesaikan SKU Pramuka <span class="hl">{{ $kenaikan->golongan_tujuan }}</span>
      pada hari, tanggal <span class="hl">{{ Carbon::parse($kenaikan->tanggal_kenaikan)->translatedFormat("l, d F Y") }}</span>
      dan dinyatakan naik golongan dari <span class="hl">{{ $kenaikan->golongan_awal }}</span>
      menjadi <span class="hl">{{ $kenaikan->golongan_tujuan }}</span> dalam Gerakan Pramuka,
      dengan memenuhi Syarat Kecakapan Umum (SKU) Pramuka Tingkat {{ $kenaikan->golongan_tujuan }}
      dan diberikan Hak Memakai Tanda Kecakapan.
    </div>
    <div class="harapan">
      Dengan harapan, semoga senantiasa meningkatkan keterampilan dan pengetahuannya
      berdasarkan Tri Satya dan Dasa Darma Pramuka, serta terus berprestasi demi kemajuan Gerakan Pramuka Indonesia.
    </div>
    <div class="ts-box">
      <div class="ts-title">✦ &nbsp; Tri Satya &nbsp; ✦</div>
      <div class="ts-text">
        Demi kehormatanku, aku berjanji akan bersungguh-sungguh menjalankan kewajibanku
        terhadap Tuhan Yang Maha Esa dan Negara Kesatuan Republik Indonesia, mengamalkan Pancasila,
        menolong sesama hidup, dan menepati Dasa Darma.
      </div>
    </div>
  </div>
</div>

<div class="ftr">
  <div class="ftr-info">
    Sertifikat ini diterbitkan secara resmi<br>
    oleh Gugus Depan Gerakan Pramuka<br>
    Kwartir Cabang Kota Surabaya
  </div>
  <div class="ttd">
    <div class="ttd-issued">Dikeluarkan di: <strong>Surabaya</strong></div>
    <div class="ttd-issued">Pada Tanggal: <strong>{{ Carbon::parse($kenaikan->tanggal_kenaikan)->translatedFormat("d F Y") }}</strong></div>
    <div class="ttd-role">Ketua Gugus Depan,</div>
    <div class="ttd-space"></div>
    <div class="ttd-line"></div>
    <div class="ttd-name">______________________________</div>
    <div class="ttd-jab">Pembina Pramuka</div>
  </div>
</div>

</div>
</div>
</body>
</html>