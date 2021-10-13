@extends('layouts.user')

@section('judul', 'Antrian Sorong')

@section('isi')

@php
    $date = date('Y-m-d');
@endphp

<main id="main">
    <section class="mt-2 blog">
        <div class="container mt-5" data-aos="fade-up">
        <div class="text-center mb-3">
            <h3>Antrian Sorong {{ $date }}</h3>
        </div>
            <div class="row mt-2">
                <div class="col-md-4 card">
                    <div class="ratio ratio-1x1">
                        <iframe src="/pelayanansorong" title="Pelayanan Sorong" ></iframe>
                      </div>
                </div>
                <div class="col-md-4 card">
                    <div class="ratio ratio-1x1">
                        <iframe src="/pengaduansorong" title="Pelayanan Sorong" allowfullscreen></iframe>
                      </div>
                </div>
                <div class="col-md-4 card">
                    <div class="ratio ratio-1x1">
                        <iframe src="/konsultasisorong" title="Pelayanan Sorong" allowfullscreen></iframe>
                      </div>
                </div>
                
            </div>
        </div>
    </section>
</main>


@endsection