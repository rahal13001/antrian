<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/teskkp.jpg') }}">
    <link href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type= "text/css" href="{{ asset('css/style.css') }}">
      <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/wa.min.css') }}" rel="stylesheet">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"> --}}

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


    <title>@yield('judul')</title>
</head>
<body>
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
    

        <div class="container" data-aos="fade-up">
           
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8 entries">
                    <article class="entry">
                    
                    @if ($cekdata == 0)
                    <main id="main">
                        <section class="mt-2 blog">
                        <h3 class="text-center">Tidak ada Antrian Pelayanan</h3>
                        <br>

                        <p class="text-center">Klik refresh untuk update data</p>
                        <div class="col text-center">
                        <a href="/pelayananmerauke" class="btn btn-danger text-center">Refresh</a>
                        @guest
                        <a class="btn btn-primary float" href="{{ route('index') }}" target="_blank">Daftar Untuk Mengantri</a> 
                        @endguest
                        
                        </div>

                        </section>
                    </main>
                    @else
                    <h1 class="text-center">Nomor Antrian : </h1>
                    <br>

                    <h1 class="text-center">{{$display_urut }}</h1> <br>
                    <h3 class="text-center">Nama : {{ $antrian->nama }}</h3>

                    <p class="text-center">Antrian Selanjutnya {{ $next }}</p>
                        

                    @guest
                    <p class="text-center">Klik refresh untuk update data</p>
                    <div class="col text-center">
                    <a href="/pelayananmerauke" class="btn btn-danger text-center">Refresh</a>
                    <div class="container mt-3 text-center">
                        <a class="btn btn-primary" href="{{ route('index') }}" target="_blank">Daftar Untuk Mengantri</a>
                    </div>
                    @endguest
                        
                    @auth
                    <form action="{{ route('status_merauke', $antrian->id) }}" method="POST">
                        @method('put')
                        @csrf
                            <input type="hidden" value="{{ $antrian->id }}" name="id">
                            <div class="col text-center">
                            <button class="btn btn-danger" name="tidak_adapelayanan" type = 'submit' value="1">Tidak Ada</button>
                            <a href="#" hidden disabled class="button"></a>
                            <button class="btn btn-primary" name="adapelayanan" type = 'submit' value="1">Ada</button>
                            </div>
                        </form>
                  
                    <div class="container mt-3 text-center">
                        <textarea id="my_text" cols="100" class="form-control">Nomor. Antrian. Pelayanan. MKQ. {{$antrian->no_urut }}</textarea>
                        <br>
                        <button onclick="play();" class="btn btn-outline-primary"><i class="bi bi-play-circle-fill"></i></button>
                        <button onclick="stop();" class="btn btn-outline-danger"><i class="bi bi-stop-circle-fill"></i></button>
                        <button onclick="pause();" class="btn btn-outline-dark"><i class="bi bi-pause-circle-fill"></i></button>
                        <button onclick="resume();" class="btn btn-outline-success"><i class="bi bi-arrow-clockwise"></i></button>
                    </div>

                    @endauth

                    @endif 
                </div>
            </div>
            </div>
       
        </div>

<script src={{ asset("assets/vendor/bootstrap/js/bootstrap.bundle.min.js") }}></script>
<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>

</html>