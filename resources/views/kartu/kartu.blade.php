<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('kartu/konten.css') }}">
</head>
<body>

    <div>
        <img src="{{ asset('kartu/logo.png') }}" class="logo" alt="Logo KKP" srcset="">

        <p class="kementerian"> Kementerian Kelautan dan Perikanan</p>
        <p class="djprl">Direktorat Jenderal Pengelolaan Ruang Laut</p>
        <p class="lpspl">LPSPL Sorong</p>    
      

        <img src="{{ asset('kartu/ZI.png') }}" class="ZI" alt="Logo ZI" srcset="">
    </div>

        

    <div class="container">
    <h3 class="antrian">Antrian Pelayanan LPSPL Sorong</h3>
    <h3 class="nomor_antrian">NOMOR ANTRIAN :</h3>
    <h1 class="no_urut">{{ $lokasi }} {{ $no_urut }}</h1>
    <h4 class="nama">Nama : {{ $nama }}</h4>
    <p class="waktu">Tanggal : {{ $tanggal}}  Jam : {{ $jam}} WIT</p>
    </div>
 

    <h3 class="bersinar">#BERSINAR</h3>
    <h5 class="panjangan">Bersih, Sinergis, Integritas dan Terarah</h5>

    <h5 class="pelayanan">Kontak Pelayanan : 081341745454</h5>
    <h5 class="pengaduan">Kontak Pengaduan :  08114874148</h5>
</body>
</html>