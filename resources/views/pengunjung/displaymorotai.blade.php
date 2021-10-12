@extends('layouts.user')

@section('judul', 'Antrian Morotai')

@section('isi')

{{-- <script src='https://code.responsivevoice.org/responsivevoice.js'></script> --}}
<script src="{{ asset('voice/responsive.js') }}"></script>
 <script type="text/javascript">
  function play (){
    var TextSpeak = document.getElementById('my_text').value;
   responsiveVoice.speak(
    TextSpeak,"Indonesian Female",
    {
     pitch: 1, 
     rate: 1, 
     volume: 1
    }
   );
  }

  function stop (){
   responsiveVoice.cancel();
  }

  function pause (){
   responsiveVoice.pause();
  }

  function resume (){
   responsiveVoice.resume();
  }
 </script>
    
<main id="main">
    <section class="mt-2 blog">
        <div class="container mt-5" data-aos="fade-up">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-lg-8 entries">
                    <article class="entry">
                    
                   
                    @if ($cekdata == 0)
                        <h3 class="text-center">Tidak ada Antrian</h3>
                        <br>

                        <p class="text-center">Klik refresh untuk update data</p>
                        <div class="col text-center">
                        <a href="/sorong" class="btn btn-primary text-center">Refresh</a>
                        </div>
                    @else
                    <h1 class="text-center">Nomor Antrian : </h1>
                    <br>
                    <h1 class="text-center">TERNATE {{$antrian->no_urut }}</h1> <br>
                    <h3 class="text-center">Nama : {{ $antrian->nama }}</h3>

                    <p class="text-center">Antrian Selanjutnya {{ $next }}</p>

                    @guest
                    <div class="container mt-3 text-center">
                        <a class="btn btn-primary" href="{{ route('index') }}" >Daftar Untuk Mengantri</a>
                    </div>
                    @endguest
                        
                    @auth
                    <form action="{{ route('status_update', $antrian->id) }}" method="POST">
                        @method('put')
                        @csrf
                            <input type="hidden" value="{{ $antrian->id }}" name="id">
                            <div class="col text-center">
                            <button class="btn btn-danger" name="tidak_ada" type = 'submit' value="1">Tidak Ada</button>
                            <a href="#" hidden disabled class="button"></a>
                            <button class="btn btn-primary" name="ada" type = 'submit' value="1">Ada</button>
                            </div>
                        </form>
                  
                    <div class="container mt-3 text-center">
                        <textarea id="my_text" cols="100" class="form-control">Nomor. Antrian. TERNATE. {{$antrian->no_urut }}</textarea>
                        <br>
                        <button onclick="play();" class="btn btn-outline-primary"><i class="bi bi-play-circle-fill"></i></button>
                        <button onclick="stop();" class="btn btn-outline-danger"><i class="bi bi-stop-circle-fill"></i></button>
                        <button onclick="pause();" class="btn btn-outline-dark"><i class="bi bi-pause-circle-fill"></i></button>
                        <button onclick="resume();" class="btn btn-outline-success"><i class="bi bi-arrow-clockwise"></i></button>
                    </div>

                    @endauth

                    @endif 
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </section>
</main>
{{-- <script src="https://code.responsivevoice.org/responsivevoice.js?key=Kb78eWQ2"></script> --}}

{{-- <script type="text/javascript">
	function play()
		{
		var TextSpeak = document.getElementById('my_text').value;
		responsiveVoice.speak(TextSpeak, "Indonesian Male",
			{
				pitch: 1,
				rate: 1,
				volume: 1
			}
			);
		}
	function stop(){
		responsiveVoice.cancel();
	}
	function pause(){
		responsiveVoice.pause();
	}
	function resume(){
		responsiveVoice.resume();
	}
</script> --}}

@endsection