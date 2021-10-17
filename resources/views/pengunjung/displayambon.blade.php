@extends('layouts.user')

@section('judul', 'Antrian Ambon')

@section('isi')

@php
    $date = date('Y-m-d');
@endphp

<section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

      <div class="d-flex justify-content-between align-items-center">
        <h2>Antrian Pelayanan di Ambon</h2>
      </div>

    </div>
  </section>

<main id="main">
    <section class="blog">
        <div class="container" data-aos="fade-up">
            <div class="text-center mb-3">
            <h3>Tanggal : {{ $date }}</h3>
            </div>
            <div class="row">
                <div class="col-md-4 card">
                    <div class="ratio ratio-1x1">
                        <iframe src="/pemanfaatanjenisikanambon" title="Pelayanan Ambon" allowfullscreen></iframe>
                      </div>
                </div>
                <div class="col-md-4 card">
                    <div class="ratio ratio-1x1">
                        <iframe src="/pengaduanambon" title="Pelayanan Sorong" allowfullscreen></iframe>
                      </div>
                </div>
                <div class="col-md-4 card">
                    <div class="ratio ratio-1x1">
                        <iframe src="/konsultasiambon" title="Pelayanan Sorong" allowfullscreen></iframe>
                      </div>
                </div>
                
            </div>
        </div>
    </section>
</main>

@endsection