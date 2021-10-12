@extends('layouts.user')
@section('judul', 'Kartu Antrian')
@section('isi')

<main id="main">
    <section class="mt-2 blog">
        <div class="container mt-5" data-aos="fade-up">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-lg-8 entries">
                    

                    <form action="/visitors/exportpdf" method="POST" class="user">
                        @csrf
                        <article class="entry">                   
                            <h1 class="text-center">Nomor Antrian : </h1>
                            <br>
                            <h1 class="text-center">{{ $lokasi }} {{ $no_urut }}</h1> <br>
                            <h3 class="text-center">Nama : {{ $nama }}</h3>
                            
                            <input type="hidden" name="no_urut" value="{{ $no_urut }}">
                            <input type="hidden" name="lokasi" value="{{ $lokasi }}">
                            <input type="hidden" name="nama" value="{{ $nama }}">
                            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                            <input type="hidden" name="jam" value="{{ $jam }}">
                            <div class="container mt-3 text-center">
                                <button class="btn btn-primary" type="submit">Cetak Kartu</button>
                            </div>

                            {{-- <br>
                            <p>Terimakasih Telah Bersedia Untuk Mengantri</p>
                            <small class="text-center mt-n2">Kamu Menolak Segala Bentuk Gratifikasi</small> --}}
                        </article>
                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </section>
</main>
@endsection