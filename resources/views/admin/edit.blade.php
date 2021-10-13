@extends('layouts.layout')

@section('judul', 'Edit Antrian LPSPL Sorong')

@section('isi')


<div class="card shadow mb-4">
   
    <div class="col-lg-10 mx-auto">
        <div class="p-5">

            <form class="user" method="post" action="{{ route('admin_update', $visitor->id) }}" enctype="">
                @method('put')
                @csrf
                <div class="form-row mt-3">
                    <div class="form-group col-sm-4">
                    <label for="tanggal">Tanggal</label>
                      <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" placeholder="Masukan Tanggal" value="{{ $visitor->tanggal }}">
                      @error('tanggal') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="pulang">Jam</label>
                          <input type="time" class="form-control @error('jam') is-invalid @enderror" name="jam" id="jam" placeholder="Masukan Jam Pulang" value="{{ $visitor->jam}}">
                          @error('jam') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                        </div>
                </div>
                <div class="form-group mt-3">
                    <label for="nama">Nama</label>
                      <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" placeholder="Masukan Nama" value="{{ $visitor->nama }}">
                      @error('nama') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                    </div>
            
                    <div class="form-group mt-3">
                    <label for="no_hp">No HP</label>
                      <input type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" id="no_hp" placeholder="Masukan Nomor HP" value="{{ $visitor->no_hp }}">
                      @error('no_hp') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                    </div>
            
                    <div class="form-group mt-3">
                    <label for="email">Email</label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukan Alamat Email" value="{{ $visitor->email }}">
                      @error('email') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                    </div>
            
                    <div class="form-group mt-3">
                    <label for="lokasi">Lokasi</label>
                    <select class="form-control form-select @error('lokasi') is-invalid @enderror" aria-label="lokasi" name="lokasi">
                        <option selected value="{{ $visitor->lokasi }}">{{ $visitor->lokasi }}</option>
                        <option value="Sorong">Sorong</option>
                        <option value="Merauke">Merauke</option>
                        <option value="Ambon">Ambon</option>
                        <option value="Ternate">Ternate</option>
                        <option value="Morotai">Morotai</option>
                      </select>
                      @error('lokasi') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                    </div>

                    <div class="form-group mt-3">
                      <label for="keperluan">Lokasi</label>
                      <select class="form-control form-select @error('keperluan') is-invalid @enderror" aria-label="keperluan" name="keperluan">
                          <option selected value="{{ $visitor->keperluan }}">{{ $visitor->keperluan }}</option>
                          <option value="antri">antri</option>
                          <option value="Ada">Ada</option>
                          <option value="Tidak Ada">Tidak Ada</option>
                        </select>
                        @error('keperluan') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                      </div>
                
                      <div class="form-group mt-3">
                        <label for="status">Status Keberadaan</label>
                        <select class="form-control form-select @error('status') is-invalid @enderror" aria-label="status" name="status">
                            <option selected value="{{ $visitor->status }}">{{ $visitor->status }}</option>
                            <option value="antri">antri</option>
                            <option value="Ada">Ada</option>
                            <option value="Tidak Ada">Tidak Ada</option>
                          </select>
                          @error('status') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                      </div>
                    
            
                        <button type="submit" class="btn btn-primary float-left">Edit</button>
            </form>
            <!-- Button trigger modal -->
                <a href="/dashboard" class="btn btn-secondary ml-2 float-left">Batal</a>

                <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteModal">
                    Hapus
                </button>
        </div>
    </div>
</div>

<!-- Modal Delete-->
<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Hapus Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Yakin mau menghapus data ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
        <form action="/service/{{$visitor->id}}" method="post">
          @method('delete')
          @csrf
          <button type="submit" class="btn btn-danger d-inline">Hapus</button>
       </form> 
      </form>
      </div>
    </div>
  </div>
</div>


@endsection