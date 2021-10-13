<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\VisitorsExport;
use Maatwebsite\Excel\Facades\Excel;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Visitor $visitor, Request $request)
    {
        if (request()->ajax()) {

            //Jika request from_date ada value(datanya) maka
            if (!empty($request->from_date)) {
                //Jika tanggal awal(from_date) hingga tanggal akhir(to_date) adalah sama maka
                if ($request->from_date === $request->to_date) {
                    //kita filter tanggalnya sesuai dengan request from_date
                    $query = Visitor::whereDate('tanggal', '=', $request->from_date)->get();
                } else {
                    //kita filter dari tanggal awal ke akhir
                    $query = Visitor::whereBetween('tanggal', array($request->from_date, $request->to_date))->get();
                }
            } else {
                $query = Visitor::query();
            }

            return DataTables::of($query)

                ->addColumn('aksi', function ($query) {
                    // $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-info btn-sm edit-post"><i class="far fa-edit"></i> Edit</a>';
                    // $button .= '&nbsp;&nbsp;';
                    // $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</button>';
                    // return $button;

                    return '
                            <a href = "' . route('admin_edit', $query->id) . '"
                            class = "btn btn-warning float-left mr-2">
                                Edit </a>



                            <form action="' . route('admin_delete', $query->id) . '" method="POST">
                                ' . method_field('delete') . csrf_field() . '
                                <button type="submit" class="btn btn-danger" onclick = "return confirm(\'Anda yakin ingin menghapus data ?\') ">
                                    Hapus
                                </button>
                            </form>
                            ';
                })->rawColumns(['aksi'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tambah');
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
            'tanggal' => 'required',
            'jam' => 'required',
            'no_hp' => 'required',
            'lokasi' => 'required',
            'status' => 'required',
            'keperluan' => 'required'
        ]);

        $tanggal = $request->tanggal;
        $jam = $request->jam;
        $nama = $request->nama;
        $no_hp = $request->no_hp;
        $lokasi = $request->lokasi;
        $email = $request->email;
        $keperluan = $request->keperluan;

        if ($request->no_urut == null) {
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
        } else {
            $no_urut = $request->no_urut;
        }

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
        return redirect('/dashboard')->with('status', 'Data Tamu Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Visitor $visitor)
    {
        return view('admin.edit', compact('visitor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visitor $visitor)
    {
        $request->validate([
            'nama' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
            'no_hp' => 'required',
            'lokasi' => 'required',
            'status' => 'required',
            'keperluan' => 'required'
        ]);

        Visitor::where('id', $visitor->id)
            ->update([
                'nama' => $request->nama,
                'tanggal' => $request->tanggal,
                'status' => $request->status,
                'no_hp' => $request->no_hp,
                'email' => $request->email,
                'jam' => $request->jam,
                'lokasi' => $request->lokasi,
                'keperluan' => $request->keperluan
            ]);
        return redirect('/dashboard')->with('status', 'Data Pengantri Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $visitor)
    {

        Visitor::destroy($visitor->id);
        return redirect()->route('admin_index')->with('status', 'Data Pengunjung Berhasil Dihapus');
    }

    //ekspor excel
    public function exportexcel(Request $request)
    {

        $from_date = $request->from_date;
        $to_date = $request->to_date;

        return Excel::download(new VisitorsExport($from_date, $to_date), 'pengantri.xlsx');
    }
}
