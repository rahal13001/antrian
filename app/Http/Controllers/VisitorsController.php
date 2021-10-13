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
            'email' => 'email',
            'keperluan' => 'required'
        ]);

        $tanggal = date('Y-m-d');
        $jam = date('H:i:s');
        $nama = $request->nama;
        $no_hp = $request->no_hp;
        $lokasi = $request->lokasi;
        $email = $request->email;
        $keperluan = $request->keperluan;

        //cek lokasi untuk kode
        if ($lokasi == "Sorong") {
            $kode = "SOQ";
        } elseif ($lokasi == "Merauke") {
            $kode = "MKQ";
        } elseif ($lokasi == "Ambon") {
            $kode = "AMQ";
        } elseif ($lokasi == "Ternate") {
            $kode = "TTQ";
        } else {
            $kode = "OTI";
        }

        //perhatikan jumlah data berdasarkan tanggal, lokasi dan keperluan
        $cek_data = Visitor::where(['tanggal' => $tanggal, 'lokasi' => $lokasi, 'keperluan' => $keperluan])->get();
        $hitung = $cek_data->count();

        if ($hitung > 0) {
            $urutan = Visitor::where(['tanggal' => $tanggal, 'lokasi' => $lokasi, 'keperluan' => $keperluan])->latest('no_urut')->limit(1)->get('no_urut');
            foreach ($urutan as $urut) {
                $norut = $urut->no_urut;
            }
            $no_urut = $norut + 1;
        } else {
            $no_urut = $hitung + 1;
        }

        //display nomor urut
        $display_urut = sprintf("%03s", $no_urut);

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
                    'email' => $email,
                    'keperluan' => $keperluan
                ]);

                return view('pengunjung.nomorantrian', compact('jam', 'nama', 'tanggal', 'no_urut', 'lokasi', 'keperluan', 'kode', 'display_urut'));
            }
            //Cek Hari Kerja
        } else {
            if (date("H") > 23 && date("i") > 0) {
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
                    'email' => $email,
                    'keperluan' => $keperluan
                ]);

                return view('pengunjung.nomorantrian', compact('jam', 'nama', 'tanggal', 'no_urut', 'lokasi', 'keperluan', 'kode', 'display_urut'));
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




    public function exportpdf(Request $request)
    {

        $nama = $request->nama;
        $no_urut = $request->no_urut;
        $tanggal = $request->tanggal;
        $jam = $request->jam;
        $keperluan = $request->keperluan;
        $kode = $request->kode;



        $pdf = PDF::loadView('kartu.kartu', compact('nama', 'no_urut', 'tanggal', 'jam', 'keperluan', 'kode'))->setPaper('a5', 'landscape');
        return $pdf->download('kartuantrian.pdf');
    }
}
