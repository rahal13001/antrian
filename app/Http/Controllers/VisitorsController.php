<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\App;

class VisitorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tgl = date("Y-m-d");

        $sorong = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'sorong', 'status' => 'antri'])->count();
        $ambon = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ambon', 'status' => 'antri'])->count();
        $merauke = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'merauke', 'status' => 'antri'])->count();
        $ternate = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ternate', 'status' => 'antri'])->count();
        $morotai = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'morotai', 'status' => 'antri'])->count();

        return view('pengunjung.index', compact('sorong', 'ambon', 'ternate', 'morotai', 'merauke'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'lokasi' => 'required',
            'email' => 'email'
        ]);

        $tanggal = date('Y-m-d');
        $jam = date('H:i:s');
        $nama = $request->nama;
        $no_hp = $request->no_hp;
        $lokasi = $request->lokasi;
        $email = $request->email;

        $cek_data = Visitor::where(['tanggal' => $tanggal, 'lokasi' => $lokasi])->get();
        $hitung = $cek_data->count();

        if ($hitung > 0) {
            $urutan = Visitor::where(['tanggal' => $tanggal, 'lokasi' => $lokasi])->latest('no_urut')->limit(1)->get('no_urut');
            foreach ($urutan as $urut) {
                $norut = $urut->no_urut;
            }
            $no_urut = $norut + 1;
        } else {
            $no_urut = $hitung + 1;
        }

        //Cek Hari Libur
        if (date("D") === "Sun" || date("D") === "Sat") {
            return redirect()->back()->with('status', 'Pelayanan Sedang Libur, Silahkan Isi Pada Hari dan Jam Kerja');

            //Cek Hari Jumat
        } elseif (date("D") === "Fri") {
            if (date("H") > 16 && date("i") > 30) {
                return redirect()->back()->with('status', 'Pelayanan Sudah Tutup, Silahkan Isi Pada Hari dan Jam Kerja');
            } elseif (date("H") < 8) {
                return redirect()->back()->with('status', 'Pelayanan Belum Buka, Silahkan Isi Pada Hari dan Jam Kerja');
            } else {
                Visitor::create([
                    'tanggal' => $tanggal,
                    'no_urut' => $no_urut,
                    'no_hp' => $no_hp,
                    'nama' => $nama,
                    'lokasi' => $lokasi,
                    'jam' => $jam,
                    'email' => $email
                ]);

                return view('pengunjung.nomorantrian', compact('jam', 'nama', 'tanggal', 'no_urut', 'lokasi'));
            }
            //Cek Hari Kerja
        } else {
            if (date("H") > 16 && date("i") > 0) {
                return redirect()->back()->with('status', 'Pelayanan Sudah Tutup, Silahkan Isi Pada Hari dan Jam Kerja');
            } elseif (date("H") < 8) {
                return redirect()->back()->with('status', 'Pelayanan Belum Buka, Silahkan Isi Pada Hari dan Jam Kerja');
            } else {
                Visitor::create([
                    'tanggal' => $tanggal,
                    'no_urut' => $no_urut,
                    'no_hp' => $no_hp,
                    'nama' => $nama,
                    'lokasi' => $lokasi,
                    'jam' => $jam,
                    'email' => $email
                ]);

                return view('pengunjung.nomorantrian', compact('jam', 'nama', 'tanggal', 'no_urut', 'lokasi'));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function show(Visitor $visitor)
    {
        return view('pengunjung.nomorantrian');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function edit(Visitor $visitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visitor $visitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $visitor)
    {
        //
    }

    public function status(Request $request)
    {

        $ada = $request->ada;
        $tidak_ada = $request->tidak_ada;

        $visitor = new Visitor();
        if ($ada == 1) {
            $visitor->where(['id' => $request->id])->update([
                'status' => 'Ada',
            ]);
            return redirect()->route('display_sorong');
        } else {
            $visitor->where(['id' => $request->id])->update([
                'status' => 'Tidak Ada',
            ]);
            return redirect()->route('display_sorong');
        }
    }


    public function sorong(Visitor $visitor)
    {
        //Tanggal hari ini
        $tgl = date("Y-m-d");

        //cek data yang mengantri
        $data = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'sorong', 'status' => 'antri']);
        //mengambil antrian pertama
        $antrian = $data->first();
        //menghituung jumlah antrian
        $cekdata = $data->count();

        //melihat apakah ada lagi yang sedang mengantri
        if ($cekdata > 0) {
            $count = $data->orderBy('no_urut', 'ASC')->limit(1)->get();
            foreach ($count as $ljt) {
                $jut = $ljt->id;
            }
        } else {
            $jut = 0;
        }
        //mengambil nomor urut terendah yang sedang ditampilkan

        //melihat pengantri selain yang sedang ditampilkan
        $tes = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'sorong', 'status' => 'antri'])->whereNotIn('id', [$jut]);
        //menghitung jumlah pengantri yang belum ditampilkan namanya
        $call = $tes->count();

        //melihat siapa yang akan dipanggil
        $selanjutnya = $tes->orderBy('no_urut', 'ASC')->limit(1)->get('no_urut');
        //mengambil nomor urut orang yang akan diambil
        foreach ($selanjutnya as $lanjut) {
            $kemudian = $lanjut->no_urut;
        }
        //cek apakah ada antrian selanjutnyya atau tidak
        if ($call == 0) {
            //jika tidak ada pengantri
            $next = "Tidak ada";
        } else {
            //jika ada pengantri lalu tampilkan nomor urut yang akan dipanggil
            $next = 'Nomor : Sorong ' . $kemudian;
        }
        return view('pengunjung.displaysorong', compact('antrian', 'cekdata', 'next'));
    }

    public function merauke(Visitor $visitor)
    {
        //Tanggal hari ini
        $tgl = date("Y-m-d");

        //cek data yang mengantri
        $data = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'merauke', 'status' => 'antri']);
        //mengambil antrian pertama
        $antrian = $data->first();
        //menghituung jumlah antrian
        $cekdata = $data->count();

        //melihat apakah ada lagi yang sedang mengantri
        if ($cekdata > 0) {
            $count = $data->orderBy('no_urut', 'ASC')->limit(1)->get();
            foreach ($count as $ljt) {
                $jut = $ljt->id;
            }
        } else {
            $jut = 0;
        }
        //mengambil nomor urut terendah yang sedang ditampilkan

        //melihat pengantri selain yang sedang ditampilkan
        $tes = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'merauke', 'status' => 'antri'])->whereNotIn('id', [$jut]);
        //menghitung jumlah pengantri yang belum ditampilkan namanya
        $call = $tes->count();

        //melihat siapa yang akan dipanggil
        $selanjutnya = $tes->orderBy('no_urut', 'ASC')->limit(1)->get('no_urut');
        //mengambil nomor urut orang yang akan diambil
        foreach ($selanjutnya as $lanjut) {
            $kemudian = $lanjut->no_urut;
        }
        //cek apakah ada antrian selanjutnyya atau tidak
        if ($call == 0) {
            //jika tidak ada pengantri
            $next = "Tidak ada";
        } else {
            //jika ada pengantri lalu tampilkan nomor urut yang akan dipanggil
            $next = 'Nomor : Sorong ' . $kemudian;
        }
        return view('pengunjung.displaymerauke', compact('antrian', 'cekdata', 'next'));
    }

    public function ambon(Visitor $visitor)
    {
        //Tanggal hari ini
        $tgl = date("Y-m-d");

        //cek data yang mengantri
        $data = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ambon', 'status' => 'antri']);
        //mengambil antrian pertama
        $antrian = $data->first();
        //menghituung jumlah antrian
        $cekdata = $data->count();

        //melihat apakah ada lagi yang sedang mengantri
        if ($cekdata > 0) {
            $count = $data->orderBy('no_urut', 'ASC')->limit(1)->get();
            foreach ($count as $ljt) {
                $jut = $ljt->id;
            }
        } else {
            $jut = 0;
        }
        //mengambil nomor urut terendah yang sedang ditampilkan

        //melihat pengantri selain yang sedang ditampilkan
        $tes = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ambon', 'status' => 'antri'])->whereNotIn('id', [$jut]);
        //menghitung jumlah pengantri yang belum ditampilkan namanya
        $call = $tes->count();

        //melihat siapa yang akan dipanggil
        $selanjutnya = $tes->orderBy('no_urut', 'ASC')->limit(1)->get('no_urut');
        //mengambil nomor urut orang yang akan diambil
        foreach ($selanjutnya as $lanjut) {
            $kemudian = $lanjut->no_urut;
        }
        //cek apakah ada antrian selanjutnyya atau tidak
        if ($call == 0) {
            //jika tidak ada pengantri
            $next = "Tidak ada";
        } else {
            //jika ada pengantri lalu tampilkan nomor urut yang akan dipanggil
            $next = 'Nomor : Sorong ' . $kemudian;
        }
        return view('pengunjung.displayambon', compact('antrian', 'cekdata', 'next'));
    }


    public function ternate(Visitor $visitor)
    {
        //Tanggal hari ini
        $tgl = date("Y-m-d");

        //cek data yang mengantri
        $data = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ternate', 'status' => 'antri']);
        //mengambil antrian pertama
        $antrian = $data->first();
        //menghituung jumlah antrian
        $cekdata = $data->count();

        //melihat apakah ada lagi yang sedang mengantri
        if ($cekdata > 0) {
            $count = $data->orderBy('no_urut', 'ASC')->limit(1)->get();
            foreach ($count as $ljt) {
                $jut = $ljt->id;
            }
        } else {
            $jut = 0;
        }
        //mengambil nomor urut terendah yang sedang ditampilkan

        //melihat pengantri selain yang sedang ditampilkan
        $tes = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ternate', 'status' => 'antri'])->whereNotIn('id', [$jut]);
        //menghitung jumlah pengantri yang belum ditampilkan namanya
        $call = $tes->count();

        //melihat siapa yang akan dipanggil
        $selanjutnya = $tes->orderBy('no_urut', 'ASC')->limit(1)->get('no_urut');
        //mengambil nomor urut orang yang akan diambil
        foreach ($selanjutnya as $lanjut) {
            $kemudian = $lanjut->no_urut;
        }
        //cek apakah ada antrian selanjutnyya atau tidak
        if ($call == 0) {
            //jika tidak ada pengantri
            $next = "Tidak ada";
        } else {
            //jika ada pengantri lalu tampilkan nomor urut yang akan dipanggil
            $next = 'Nomor : Sorong ' . $kemudian;
        }
        return view('pengunjung.displayternate', compact('antrian', 'cekdata', 'next'));
    }


    public function morotai(Visitor $visitor)
    {
        //Tanggal hari ini
        $tgl = date("Y-m-d");

        //cek data yang mengantri
        $data = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ambon', 'status' => 'antri']);
        //mengambil antrian pertama
        $antrian = $data->first();
        //menghituung jumlah antrian
        $cekdata = $data->count();

        //melihat apakah ada lagi yang sedang mengantri
        if ($cekdata > 0) {
            $count = $data->orderBy('no_urut', 'ASC')->limit(1)->get();
            foreach ($count as $ljt) {
                $jut = $ljt->id;
            }
        } else {
            $jut = 0;
        }
        //mengambil nomor urut terendah yang sedang ditampilkan

        //melihat pengantri selain yang sedang ditampilkan
        $tes = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ambon', 'status' => 'antri'])->whereNotIn('id', [$jut]);
        //menghitung jumlah pengantri yang belum ditampilkan namanya
        $call = $tes->count();

        //melihat siapa yang akan dipanggil
        $selanjutnya = $tes->orderBy('no_urut', 'ASC')->limit(1)->get('no_urut');
        //mengambil nomor urut orang yang akan diambil
        foreach ($selanjutnya as $lanjut) {
            $kemudian = $lanjut->no_urut;
        }
        //cek apakah ada antrian selanjutnyya atau tidak
        if ($call == 0) {
            //jika tidak ada pengantri
            $next = "Tidak ada";
        } else {
            //jika ada pengantri lalu tampilkan nomor urut yang akan dipanggil
            $next = 'Nomor : Sorong ' . $kemudian;
        }
        return view('pengunjung.displaymorotai', compact('antrian', 'cekdata', 'next'));
    }


    public function exportpdf(Request $request)
    {

        $nama = $request->nama;
        $no_urut = $request->no_urut;
        $tanggal = $request->tanggal;
        $jam = $request->jam;
        $lokasi = $request->lokasi;



        $pdf = PDF::loadView('kartu.kartu', compact('nama', 'no_urut', 'tanggal', 'jam', 'lokasi'))->setPaper('a5', 'landscape');
        return $pdf->download('kartuantrian.pdf');
    }
}
