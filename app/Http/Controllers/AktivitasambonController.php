<?php

namespace App\Http\Controllers;

use App\Models\Visitor;


use Illuminate\Http\Request;

class AktivitasambonController extends Controller
{
    public function status(Request $request)
    {

        $adapelayanan = $request->adapelayanan;
        $tidak_adapelayanan = $request->tidak_adapelayanan;
        $adakonsultasi = $request->adakonsultasi;
        $tidak_adakonsultasi = $request->tidak_adakonsultasi;
        $adapengaduan = $request->adapengaduan;
        $tidak_adapengaduan = $request->tidak_adapengaduan;

        $visitor = new Visitor();
        if ($adapelayanan == 1) {
            $visitor->where(['id' => $request->id])->update([
                'status' => 'Ada',
            ]);
            return redirect()->route('pemanfaatanjenisikan_ambon');
        } elseif ($tidak_adapelayanan == 1) {
            $visitor->where(['id' => $request->id])->update([
                'status' => 'Tidak Ada',
            ]);
            return redirect()->route('pemanfaatanjenisikan_ambon');
        } elseif ($adapengaduan == 1) {
            $visitor->where(['id' => $request->id])->update([
                'status' => 'Ada',
            ]);
            return redirect()->route('pengaduan_ambon');
        } elseif ($tidak_adapengaduan == 1) {
            $visitor->where(['id' => $request->id])->update([
                'status' => 'Tidak Ada',
            ]);
            return redirect()->route('pengaduan_ambon');
        } elseif ($adakonsultasi == 1) {
            $visitor->where(['id' => $request->id])->update([
                'status' => 'Ada',
            ]);
            return redirect()->route('konsultasi_ambon');
        } elseif ($tidak_adakonsultasi == 1) {
            $visitor->where(['id' => $request->id])->update([
                'status' => 'Tidak Ada',
            ]);
            return redirect()->route('konsultasi_ambon');
        }
    }
    public function pemanfaatanjenisikan(Visitor $visitor)
    {
        //Tanggal hari ini
        $tgl = date("Y-m-d");

        //cek data yang mengantri
        $data = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ambon', 'status' => 'antri', 'keperluan' => 'Pemanfatan Jenis Ikan']);

        //mengambil antrian pertama
        $antrian = $data->first();

        //mengambil lokasi dan no urut untuk dijadikan kode dan format nomor urut
        //cek dulu ada tau ga datanya
        $coba = $data->count();

        //jika ada tampilkan jika tidak ada tulis tidak ada antrian
        if ($coba > 0) {
            $display_urut = "Pemanfaatan Jenis Ikan AMQ " . sprintf("%03s", $antrian->no_urut);
        } else {
            $display_urut = "Tidak Ada Antrian";
        }

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
        $tes = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ambon', 'status' => 'antri', 'keperluan' => 'Pemanfatan Jenis Ikan'])->whereNotIn('id', [$jut]);
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
            $next = 'Nomor : Pemanfaatan Jenis Ikan AMQ ' . sprintf("%03s", $kemudian);
        }
        return view('gabungan.ambon.pemanfaatanjenisikan', compact('antrian', 'cekdata', 'next', 'display_urut'));
    }

    //Pengaduan ambon
    public function pengaduan(Visitor $visitor)
    {
        //Tanggal hari ini
        $tgl = date("Y-m-d");

        //cek data yang mengantri
        $data = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ambon', 'status' => 'antri', 'keperluan' => 'pengaduan']);

        //mengambil antrian pertama
        $antrian = $data->first();

        //mengambil lokasi dan no urut untuk dijadikan kode dan format nomor urut
        //cek dulu ada tau ga datanya
        $coba = $data->count();

        //jika ada tampilkan jika tidak ada tulis tidak ada antrian
        if ($coba > 0) {
            $display_urut = "Pengaduan AMQ " . sprintf("%03s", $antrian->no_urut);
        } else {
            $display_urut = "Tidak Ada Antrian";
        }


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
        $tes = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ambon', 'status' => 'antri', 'keperluan' => 'pengaduan'])->whereNotIn('id', [$jut]);
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
            $next = 'Nomor : Pengaduan AMQ ' . sprintf("%03s", $kemudian);
        }
        return view('gabungan.ambon.pengaduan', compact('antrian', 'cekdata', 'next', 'display_urut'));
    }

    //konsultasi ambon
    public function konsultasi(Visitor $visitor)
    {
        //Tanggal hari ini
        $tgl = date("Y-m-d");

        //cek data yang mengantri
        $data = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ambon', 'status' => 'antri', 'keperluan' => 'konsultasi']);

        //mengambil antrian pertama
        $antrian = $data->first();

        //mengambil lokasi dan no urut untuk dijadikan kode dan format nomor urut
        //cek dulu ada tau ga datanya
        $coba = $data->count();

        //jika ada tampilkan jika tidak ada tulis tidak ada antrian
        if ($coba > 0) {
            $display_urut = "Konsultasi AMQ " . sprintf("%03s", $antrian->no_urut);
        } else {
            $display_urut = "Tidak Ada Antrian";
        }
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
        $tes = Visitor::where(['tanggal' => $tgl, 'lokasi' => 'ambon', 'status' => 'antri', 'keperluan' => 'konsultasi'])->whereNotIn('id', [$jut]);
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
            $next = 'Nomor : Konsultasi AMQ ' . sprintf("%03s", $kemudian);
        }
        return view('gabungan.ambon.konsultasi', compact('antrian', 'cekdata', 'next', 'display_urut'));
    }
}
