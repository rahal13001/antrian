@extends('layouts.layout')

@section('judul', 'Tambah Pengantri LPSPL Sorong')

@section('isi')


<div class="card shadow mb-4">
   
    <div class="col-lg-10 mx-auto">
        <div class="p-5">

            <form class="user" method="post" action="{{ route('admin_store') }}" enctype="">
                @csrf
                <div class="form-row mt-3">
                    <div class="form-group col-sm-4">
                    <label for="tanggal">Tanggal</label>
                      <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" placeholder="Masukan Tanggal" value="{{ old('tanggal') }}">
                      @error('tanggal') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="jam">Jam</label>
                          <input type="time" class="form-control @error('jam') is-invalid @enderror" name="jam" id="jam" placeholder="Masukan Jam" value="{{ old('jam')}}">
                          @error('jam') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="no_urut">Nomoor Urut</label>
                            <input type="number" class="form-control @error('no_urut') is-invalid @enderror" name="no_urut" id="no_urut" placeholder="Masukan Nomor Urut Jika Perlu" value="{{ old('no_urut')}}">
                            @error('no_urut') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                          </div>
                </div>
                <div class="form-group mt-3">
                    <label for="nama">Nama</label>
                      <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" placeholder="Masukan Nama" value="{{old('nama') }}">
                      @error('nama') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                    </div>
            
                    <div class="form-group mt-3">
                    <label for="no_hp">No HP</label>
                      <input type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" id="no_hp" placeholder="Masukan Nomor HP" value="{{ old('no_hp') }}">
                      @error('no_hp') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                    </div>
            
                    <div class="form-group mt-3">
                    <label for="email">Email</label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukan Alamat Email" value="{{ old('email') }}">
                      @error('email') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                    </div>
            
                    <div class="form-group mt-3">
                    <label for="lokasi">Lokasi</label>
                    <select class="form-control form-select @error('lokasi') is-invalid @enderror" aria-label="lokasi" name="lokasi">
                        <option selected value="{{ old('lokasi') }}">{{ old('lokasi') }}</option>
                        <option value="Sorong">Sorong</option>
                        <option value="Merauke">Merauke</option>
                        <option value="Ambon">Ambon</option>
                        <option value="Ternate">Ternate</option>
                        {{-- <option value="Morotai">Morotai</option> --}}
                      </select>
                      @error('lokasi') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                    </div>

                    <div class="form-group mt-3">
                      <label for="keperluan">Keperluan</label>
                      <select class="form-control form-select @error('keperluan') is-invalid @enderror" aria-label="keperluan" name="keperluan">
                          <option selected value="{{ old('keperluan') }}">{{ old('keperluan') }}</option>
                          <option value="Pelayanan">Pelayanan</option>
                          <option value="Konsultasi">Konsultasi</option>
                          <option value="Pengaduan">Pengaduan</option>
                        </select>
                        @error('keperluan') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                      </div>
                
                      <div class="form-group mt-3">
                        <label for="status">Status Keberadaan</label>
                        <select class="form-control form-select @error('status') is-invalid @enderror" aria-label="status" name="status">
                            <option selected value="{{ old('status') }}">{{ old('status') }}</option>
                            <option value="antri">antri</option>
                            <option value="Ada">Ada</option>
                            <option value="Tidak Ada">Tidak Ada</option>
                          </select>
                          @error('status') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                      </div>
                    
            
                        <button type="submit" class="btn btn-primary float-left">Tambah</button>
            </form>
            <!-- Button trigger modal -->
                <a href="/dashboard" class="btn btn-secondary ml-2">Batal</a>

        </div>
    </div>
</div>



@endsection