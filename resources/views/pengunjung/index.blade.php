@extends('layouts.user')

@section('judul', 'Antrian')

@section('isi')
    
<div class="container mt-5">
    <section class="about">
       
        
        @if (session('status'))
            <div class="mt-2">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session ('status') }}
                </div>
            </div>
        @endif
    

      <h3 class="mt-2"><span>Daftar Antrian</span></h3>
        <form action="{{ route('vis_store') }}" method="post" class="user mt-n2">
            @csrf
            <div class="form-group mt-3">
                <label for="nama">Nama</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" placeholder="Masukan Nama" value="{{ old('nama') }}">
                @error('nama') <div class="invalid-feedback"> {{ $message }} </div> @enderror
            </div>

            <div class="form-group mt-3">
                <label for="no_hp">No HP</label>
                  <input type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" id="no_hp" placeholder="Masukan Nomor HP" value="{{ old('no_hp') }}">
                  @error('no_hp') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                </div>

            <div class="form-group mt-3">
                <label for="lokasi">Lokasi</label>
                <select class="form-select @error('lokasi') is-invalid @enderror" aria-label="lokasi" name="lokasi">
                    <option selected value="{{ old('lokasi') }}">{{ old('lokasi') }}</option>
                    <option value="Sorong">Sorong</option>
                    <option value="Ambon">Ambon</option>
                    <option value="Ternate">Ternate</option>
                    <option value="Morotai">Morotai</option>
                    <option value="Merauke">Merauke</option>
            </select>
            @error('lokasi') <div class="invalid-feedback"> {{ $message }} </div> @enderror
            </div>

            <div class="form-group mt-3">
              <label for="keperluan">Keperluan</label>
              <select class="form-select @error('keperluan') is-invalid @enderror" aria-label="keperluan" name="keperluan">
                  <option selected value="{{ old('keperluan') }}">{{ old('keperluan') }}</option>
                  <option value="Pelayanan">Pelayanan</option>
                  <option value="Pengaduan">Pengaduan</option>
                  <option value="Konsultasi">Konsultasi</option>
          </select>
          @error('keperluan') <div class="invalid-feedback"> {{ $message }} </div> @enderror
          </div>

            <div class="form-group mt-3">
                <label for="email">Email</label>
                  <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukan Alamat Email Jika Ada" value="{{ old('email') }}">
                  @error('email') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                </div>
       
            <button type="submit" class="btn btn-primary mt-3">Daftar Mengantri</button>
            </form>

       

    </section>
     <!-- ======= Pricing Section ======= -->
     <section id="pricing" class="pricing ">
        <div class="container">
  
          <div class="row d-flex justify-content-center animate__animated animate__fadeInDown mt-2">
  
            <div class="col-lg-2 col-md-6 mt-4 mt-md-0">
                <div class="box featured">
                  <h3>Sorong</h3>
                  <h5>Jumlah Penunggu :</h5>
                  <h4>{{ $sorong }}<span> orang</span></h4>
                  
                  <div class="btn-wrap">
                    <a href="/antriansorong" class="btn-buy" target="_blank">Lihat Antrian</a>
                  </div>
                </div>
              </div>

              <div class="col-lg-2 col-md-6 mt-4 mt-md-0">
                <div class="box featured">
                  <h3>Merauke</h3>
                  <h5>Jumlah Penunggu :</h5>
                  <h4>{{ $merauke }}<span> orang</span></h4>
                  
                  <div class="btn-wrap">
                    <a href="/antrianmerauke" class="btn-buy" target="_blank">Lihat Antrian</a>
                  </div>
                </div>
              </div>

              <div class="col-lg-2 col-md-6 mt-4 mt-md-0">
                <div class="box featured">
                  <h3>Ambon</h3>
                  <h5>Jumlah Penunggu :</h5>
                  <h4>{{ $ambon }}<span> orang</span></h4>
                  
                  <div class="btn-wrap">
                    <a href="/antrianambon" class="btn-buy" target="_blank">Lihat Antrian</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-md-6 mt-4 mt-md-0">
                <div class="box featured">
                  <h3>Ternate</h3>
                  <h5>Jumlah Penunggu :</h5>
                  <h4>{{ $ternate }}<span> orang</span></h4>
                  
                  <div class="btn-wrap">
                    <a href="/antrianternate" class="btn-buy" target="_blank">Lihat Antrian</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-md-6 mt-4 mt-md-0">
                <div class="box featured">
                  <h3>Morotai</h3>
                  <h5>Jumlah Penunggu :</h5>
                  <h4>{{ $morotai }}<span> orang</span></h4>
                  
                  <div class="btn-wrap">
                    <a href="/antrianmorotai" class="btn-buy" target="_blank">Lihat Antrian</a>
                  </div>
                </div>
              </div> 
           

  
          </div>
  
        </div>
      </section><!-- End Pricing Section -->
</div>

@endsection