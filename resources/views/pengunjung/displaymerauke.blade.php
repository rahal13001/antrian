@extends('layouts.user')

@section('judul', 'Antrian Ambon')

@section('isi')

@php
    $date = date('Y-m-d');
@endphp


<main id="main">
    <section class="mt-2 blog">
        
        <div class="container mt-5" data-aos="fade-up">
            <div class="text-center mb-3">
            <h3>Antrian Merauke {{ $date }}</h3>
            </div>
            <div class="row">
                <div class="col-md-4 card">
                    <div class="ratio ratio-1x1">
                        <iframe src="/pelayananmerauke" title="Pelayanan Merauke" allowfullscreen></iframe>
                      </div>
                </div>
                <div class="col-md-4 card">
                    <div class="ratio ratio-1x1">
                        <iframe src="/pengaduanmerauke" title="Pengaduan Merauke" allowfullscreen></iframe>
                      </div>
                </div>
                <div class="col-md-4 card">
                    <div class="ratio ratio-1x1">
                        <iframe src="/konsultasimerauke" title="Konsultasi Merauke" allowfullscreen></iframe>
                      </div>
                </div>
                
            </div>
        </div>
    </section>
</main>

@endsection