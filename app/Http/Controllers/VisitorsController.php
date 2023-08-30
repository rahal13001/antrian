<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Models\Schedule;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\App;
use Spatie\OpeningHours\OpeningHours;


class VisitorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tgl = date('Y-m-d');

        //Mennampilkan jumlah pengantri secara umum
        $sorong = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'sorong', 'status' => 'antri'])->count();
        $ambon = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ambon', 'status' => 'antri'])->count();
        $merauke = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'merauke', 'status' => 'antri'])->count();
        $ternate = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ternate', 'status' => 'antri'])->count();
        $morotai = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'morotai', 'status' => 'antri'])->count();

        //Melihat Jadwal Libur
        $libur = Holiday::whereDate('mulai', '<=', $tgl)->whereDate('selesai', '>=', $tgl)->orderBy('mulai')->limit(1)->get();

        //melihat hari ini libur atau ga
        $ceklibur = $libur->count();
        //eksekusi perintah jika libur
        if ($ceklibur > 0) {
            foreach ($libur as $holiday) {

                $selesai = $holiday->selesai;
                $keterangan = $holiday->keterangan;
                //membuat jason menjadi array
                $lokasi = json_decode($holiday->lokasi);
            }

            //menampilkan data json dari kolom lokasi
            $lokasi = implode(" , ", $lokasi);
            //tampilan tanggal supaya Indonesia Banget
            $selesai = date('d-m-Y', DateTime::createFromFormat('d-m-Y', $selesai));
            //Kasih tau kalau kami lagi libur
            $info = "Hari Ini Kami Di " . $lokasi . " Sedang Libur Sampai Tanggal " . $selesai . " Dalam Rangka " . $keterangan;
            return view('pengunjung.index', compact('sorong', 'ambon', 'ternate', 'morotai', 'merauke', 'info'));
        }

        $monday = Schedule::where(['hari' => 'Senin'])->get();
       
        foreach ($monday as $senin) { 
            $masuk_monday = date("H:i", strtotime($senin->masuk));
            $istirahat_monday = date("H:i", strtotime($senin->istirahat));
            $buka_monday = date("H:i", strtotime($senin->buka));
            $tutup_monday = date("H:i", strtotime($senin->tutup));
        }
       

        $tuesday = Schedule::where(['hari' => 'Selasa'])->get();
        foreach ($tuesday as $selasa) {
            $masuk_tuesday = date("H:i", strtotime($selasa->masuk));
            $istirahat_tuesday = date("H:i", strtotime($selasa->istirahat));
            $buka_tuesday = date("H:i", strtotime($selasa->buka));
            $tutup_tuesday = date("H:i", strtotime($selasa->tutup));
        }

        $wednesday = Schedule::where(['hari' => 'Rabu'])->get();
        foreach ($wednesday as $rabu) {
            $masuk_wednesday = date("H:i", strtotime($rabu->masuk));
            $istirahat_wednesday = date("H:i", strtotime($rabu->istirahat));
            $buka_wednesday = date("H:i", strtotime($rabu->buka));
            $tutup_wednesday = date("H:i", strtotime($rabu->tutup));
        }

        $thursday = Schedule::where(['hari' => 'Kamis'])->get();
        foreach ($thursday as $kamis) {
            $masuk_thursday = date("H:i", strtotime($kamis->masuk));
            $istirahat_thursday = date("H:i", strtotime($kamis->istirahat));
            $buka_thursday = date("H:i", strtotime($kamis->buka));
            $tutup_thursday = date("H:i", strtotime($kamis->tutup));
        }

        $friday = Schedule::where(['hari' => 'Jumat'])->get();
        foreach ($friday as $jumat) {
            $masuk_friday = date("H:i", strtotime($jumat->masuk));
            $istirahat_friday = date("H:i", strtotime($jumat->istirahat));
            $buka_friday = date("H:i", strtotime($jumat->buka));
            $tutup_friday = date("H:i", strtotime($jumat->tutup));
        }

        $saturday = Schedule::where(['hari' => 'Sabtu'])->get();
        foreach ($saturday as $sabtu) {
            $masuk_saturday = date("H:i", strtotime($sabtu->masuk));
            $istirahat_saturday = date("H:i", strtotime($sabtu->istirahat));
            $buka_saturday = date("H:i", strtotime($sabtu->buka));
            $tutup_saturday = date("H:i", strtotime($sabtu->tutup));
        }

        $sunday = Schedule::where(['hari' => 'Minggu'])->get();
        foreach ($sunday as $minggu) {
            $masuk_sunday = date("H:i", strtotime($minggu->masuk));
            $istirahat_sunday = date("H:i", strtotime($minggu->istirahat));
            $buka_sunday = date("H:i", strtotime($minggu->buka));
            $tutup_sunday = date("H:i", strtotime($minggu->tutup));
        }
       
        //Buat jadwal pake spatie-opening hours
        $range = [
            'monday'     => [$buka_monday . '-' . $istirahat_monday, $masuk_monday . '-' . $tutup_monday],
            'tuesday'    => [$buka_tuesday . '-' . $istirahat_tuesday, $masuk_tuesday . '-' . $tutup_tuesday],
            'wednesday'  => [$buka_wednesday . '-' . $istirahat_wednesday, $masuk_wednesday . '-' . $tutup_wednesday],
            'thursday'   => [$buka_thursday . '-' . $istirahat_thursday, $masuk_thursday . '-' . $tutup_thursday],
            'friday'     => [$buka_friday . '-' . $istirahat_friday, $masuk_friday . '-' . $tutup_friday],
            'saturday'   => [$buka_saturday . '-' . $istirahat_saturday, $masuk_saturday . '-' . $tutup_saturday],
            'sunday'     => [$buka_sunday . '-' . $istirahat_sunday, $masuk_sunday . '-' . $tutup_sunday],
        ];

        $openingHours = OpeningHours::createAndMergeOverlappingRanges($range);
     
        $now = new DateTime('now');
        $range = $openingHours->currentOpenRange($now);
        
        if ($range) {
            $woro = "Halo Sahabat Pelayanan LPSPL Sorong, Hari Ini Kami Buka Pukul " . $range->start() . " - " . $range->end() . " WIT";

            //ini kalau ga lagi libur dan di jam pelayanan
            return view('pengunjung.index', compact('sorong', 'ambon', 'ternate', 'morotai', 'merauke', 'woro'));
        } else {
        
            // Display pemberitahuan
            $info = 'Mohon Maaf Pelayanan Tutup, Silahkan Coba Kembali Pada Hari dan Jam Kerja';

            //ini kalau ga lagi libur tapi di luar jam pelayanan
            return view('pengunjung.index', compact('sorong', 'ambon', 'ternate', 'morotai', 'merauke', 'info'));
        }
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
            'email' => 'email|nullable',
            'keperluan' => 'required'
        ]);

        $tanggal = date('Y-m-d');
        $jam = date('H:i:s');
        $nama = $request->nama;
        $no_hp = $request->no_hp;
        $lokasi = $request->lokasi;
        $email = $request->email;
        $keperluan = $request->keperluan;

        //Melihat Jadwal Libur
        $libur = Holiday::whereDate('mulai', '<=', $tanggal)->whereDate('selesai', '>=', $tanggal)->orderBy('mulai')->limit(1)->get();

        //melihat hari ini libur atau ga
        $ceklibur = $libur->count();

        //melihat lokasi yang libur
        foreach ($libur as $loks) {
            $loklibur = json_decode($loks->lokasi);
        }
        //Jika hari libur
        if ($ceklibur > 0) {
            //Cek apakah lokasi yang dituju libur atau buka
            if (in_array($lokasi, $loklibur)) {
                return redirect()->back()->with('status', 'Pelayanan Sedang Libur, Silahkan Isi Pada Hari dan Jam Kerja');
            }
        }

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

        $monday = Schedule::where(['hari' => 'Senin'])->get();
        foreach ($monday as $senin) {
            $masuk_monday = date("H:i", strtotime($senin->masuk));
            $istirahat_monday = date("H:i", strtotime($senin->istirahat));
            $buka_monday = date("H:i", strtotime($senin->buka));
            $tutup_monday = date("H:i", strtotime($senin->tutup));
        }

        $tuesday = Schedule::where(['hari' => 'Selasa'])->get();
        foreach ($tuesday as $selasa) {
            $masuk_tuesday = date("H:i", strtotime($selasa->masuk));
            $istirahat_tuesday = date("H:i", strtotime($selasa->istirahat));
            $buka_tuesday = date("H:i", strtotime($selasa->buka));
            $tutup_tuesday = date("H:i", strtotime($selasa->tutup));
        }

        $wednesday = Schedule::where(['hari' => 'Rabu'])->get();
        foreach ($wednesday as $rabu) {
            $masuk_wednesday = date("H:i", strtotime($rabu->masuk));
            $istirahat_wednesday = date("H:i", strtotime($rabu->istirahat));
            $buka_wednesday = date("H:i", strtotime($rabu->buka));
            $tutup_wednesday = date("H:i", strtotime($rabu->tutup));
        }

        $thursday = Schedule::where(['hari' => 'Kamis'])->get();
        foreach ($thursday as $kamis) {
            $masuk_thursday = date("H:i", strtotime($kamis->masuk));
            $istirahat_thursday = date("H:i", strtotime($kamis->istirahat));
            $buka_thursday = date("H:i", strtotime($kamis->buka));
            $tutup_thursday = date("H:i", strtotime($kamis->tutup));
        }

        $friday = Schedule::where(['hari' => 'Jumat'])->get();
        foreach ($friday as $jumat) {
            $masuk_friday = date("H:i", strtotime($jumat->masuk));
            $istirahat_friday = date("H:i", strtotime($jumat->istirahat));
            $buka_friday = date("H:i", strtotime($jumat->buka));
            $tutup_friday = date("H:i", strtotime($jumat->tutup));
        }

        $saturday = Schedule::where(['hari' => 'Sabtu'])->get();
        foreach ($saturday as $sabtu) {
            $masuk_saturday = date("H:i", strtotime($sabtu->masuk));
            $istirahat_saturday = date("H:i", strtotime($sabtu->istirahat));
            $buka_saturday = date("H:i", strtotime($sabtu->buka));
            $tutup_saturday = date("H:i", strtotime($sabtu->tutup));
        }

        $sunday = Schedule::where(['hari' => 'Minggu'])->get();
        foreach ($sunday as $minggu) {
            $masuk_sunday = date("H:i", strtotime($minggu->masuk));
            $istirahat_sunday = date("H:i", strtotime($minggu->istirahat));
            $buka_sunday = date("H:i", strtotime($minggu->buka));
            $tutup_sunday = date("H:i", strtotime($minggu->tutup));
        }
        //Buat jadwal pake spatie-opening hours
        $range = [
            'monday'     => [$buka_monday . '-' . $istirahat_monday, $masuk_monday . '-' . $tutup_monday],
            'tuesday'    => [$buka_tuesday . '-' . $istirahat_tuesday, $masuk_tuesday . '-' . $tutup_tuesday],
            'wednesday'  => [$buka_wednesday . '-' . $istirahat_wednesday, $masuk_wednesday . '-' . $tutup_wednesday],
            'thursday'   => [$buka_thursday . '-' . $istirahat_thursday, $masuk_thursday . '-' . $tutup_thursday],
            'friday'     => [$buka_friday . '-' . $istirahat_friday, $masuk_friday . '-' . $tutup_friday],
            'saturday'   => [$buka_saturday . '-' . $istirahat_saturday, $masuk_saturday . '-' . $tutup_saturday],
            'sunday'     => [$buka_sunday . '-' . $istirahat_sunday, $masuk_sunday . '-' . $tutup_sunday],
        ];
        $openingHours = OpeningHours::createAndMergeOverlappingRanges($range);
        $now = new DateTime('now');
        $range = $openingHours->currentOpenRange($now);

        if ($range) {

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
        } else {
            //Memanggil hari dalam bahasa inggris
            $bukalagi = $openingHours->nextOpen($now)->format('D');
            //Mengubah hari ke bahasa Indoonesia
            switch ($bukalagi) {
                case 'Mon':
                    $hari = "Senin";
                    break;
                case 'Tue':
                    $hari = "Selasa";
                    break;
                case 'Wed':
                    $hari = "Rabu";
                    break;
                case 'Thur':
                    $hari = "Kamis";
                    break;
                case 'Fri':
                    $hari = "Jumat";
                    break;
                case 'Sat':
                    $hari = "Sabtu";
                    break;
                case 'Sun':
                    $hari = "Minggu";
                    break;
            }
            //Display pemberitahuan
            return redirect()->back()->with('status', 'Pelayanan Tutup, Kami Akan Buka Kembali Pada ' . $hari . ' Pukul ' . $openingHours->nextOpen($now)->format('H:i') . ' WIT');
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
