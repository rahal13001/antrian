@extends('layouts.layout')

@section('judul', 'Buku Tamu LPSPL Sorong')

@section('isi')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
integrity="sha256-pODNVtK3uOhL8FUNWWvFQK0QoQoV3YA9wGGng6mbZ0E=" crossorigin="anonymous" />

<div class="card shadow mb-4">
    <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Data Tamu LPSPL Sorong</h6>
    </div>
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session ('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
    </div>
    @endif
        <div class="card-body">
            <div class="row">
                <div class="col-sm-2">
                    <a href="javascript:void(0)" id="tombol-tambah" class="btn btn-primary mt-2">
                        Tambah Data
                    </a>
                </div>
        
                <div class="col-sm-10">     
                    <!-- MULAI DATE RANGE PICKER -->
                
                <form action="{{ route('export') }}" method="GET">
                    @csrf
                    <div class="row input-daterange mb-3">
                        <div class="col-md-2 mt-2">
                            <input type="text" name="from_date" id="from_date" class="form-control" placeholder="Dari Tanggal"
                                readonly />
                        </div>
                        <div class="col-md-2 mt-2">
                            <input type="text" name="to_date" id="to_date" class="form-control" placeholder="Ke Tanggal"
                                readonly />
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="button" name="filter" id="filter" class="btn btn-primary mt-2">Filter</button>
                            <button type="button" name="refresh" id="refresh" class="btn btn-secondary mt-2">Refresh</button>
                            <button type="submit" class="btn btn-success mt-2">Export Excel</button>
                        </div>
                    </div>
                    
                </form>
                </div>  
     </div>
            <!-- AKHIR DATE RANGE PICKER -->
            <div class="table-responsive">
                    <table class="table table-bordered table-hover scroll-horizontal-vertical" id="crudTable" width="100%" cellspacing="0" id="crudtable">
                <thead class="thead-dark text-center">
                    <tr>
                        <th scope="col">+</th>
                        <th scope="col">No</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">No Urut</th>
                        <th scope="col">Nama</th>
                        <th scope="col">No HP</th>
                        <th scope="col">Status</th>
                        <th scope="col">Panggil</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
            </table>
            </div>
    </div>
</div>



<!-- MULAI MODAL FORM TAMBAH/EDIT-->
<div class="modal fade" id="tambah-edit-modal" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-judul"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-12">

                            <input type="hidden" name="id" id="id">

                            <div class="form-group">
                                <label for="name" class="col-sm-12 control-label">Nama</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-12 control-label">No HP</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="no_hp" name="no_hp"
                                        value="" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-12 control-label">E-mail</label>
                                <div class="col-sm-12">
                                    <input type="email" class="form-control" id="email" name="email" value=""
                                        required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-12 control-label">Lokasi</label>
                                <div class="col-sm-12">
                                    <select name="lokasi" id="lokasi" class="form-control required">
                                        <option value="">Pilih Lokasi</option>
                                        <option value="Sorong">Sorong</option>
                                        <option value="Merauke">Merauke</option>
                                        <option value="Ambon">Ambon</option>
                                        <option value="Ternate">Ternate</option>
                                        <option value="Morotai">Morotai</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-offset-2 col-sm-12">
                            <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan"
                                value="create">Simpan
                            </button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- AKHIR MODAL -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js"
integrity="sha256-siqh9650JHbYFKyZeTEAhq+3jvkFCG8Iz+MHdr9eKrw=" crossorigin="anonymous"></script>

@endsection

@push('addon-script')




{{-- Tombol panah Anak Table --}}
<style>

    td.details-control {
        background: url('../img/chevron-double-down.svg') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('../img/chevron-double-up.svg') no-repeat center center;
    }
    </style>

    <script>

function template ( d ) {


    return '<table class="table table-bordered table-hover scroll-horizontal-vertical table-responsive">'+
        '<tr>'+
            '<td>Jam</td>'+
            '<td>'+d.jam+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Email</td>'+
            '<td>'+d.emaik+'</td>'+
        '</tr>'+
        '</table>'

}

//TOMBOL TAMBAH DATA
//jika tombol-tambah diklik maka
$('#tombol-tambah').click(function () {
    $('#button-simpan').val("create-post"); //valuenya menjadi create-post
    $('#id').val(''); //valuenya menjadi kosong
    $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
    $('#modal-judul').html("Tambah Antrian Baru"); //valuenya tambah pegawai baru
    $('#tambah-edit-modal').modal('show'); //modal tampil
});

//Ajax Data Table Mulai
       $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

    load_data();

        //Iniliasi datepicker pada class input
        $('.input-daterange').datepicker({
                todayBtn: 'linked',
                format: 'yyyy-mm-dd',
                autoclose: true
            });


            $('#filter').click(function () {
                var from_date = $('#from_date').val(); 
                var to_date = $('#to_date').val(); 
                if (from_date != '' && to_date != '') {
                    $('#crudTable').DataTable().destroy();
                    load_data(from_date, to_date);
                } else {
                    alert('Rentang Tanggal Harus Diisi');
                }
            });
            $('#refresh').click(function () {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#crudTable').DataTable().destroy();
                load_data();
            });


        // AJAX DataTable
        function load_data(from_date = '', to_date = '') {
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            order: [[ 2, "desc" ]],
            ajax: {
                url: '{!! url()->current() !!}',
                type: 'GET',
                data:{from_date:from_date, to_date:to_date}
            },
            columns: [
                    // {data: 'null', sortable : false,
                    // render : function (data, type, row, meta){
                    // return meta.row + meta.setting._iDisplayStart + 1;}},
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "searchable":     false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { data:'id',
                      sortable: false, 
                       render: function (data, type, row, meta) {
                     return meta.row + meta.settings._iDisplayStart + 1;
                      } },
                    // {data: 'id', name : 'id'},
                    {data: 'tanggal', name : 'tanggal'},
                    {data: 'no_urut', name : 'no_urut'},
                    {data: 'nama', name : 'nama'},
                    {data: 'no_hp', name : 'no_hp'},
                    {data: 'status', name : 'status'},
                    {
                        data: 'cek',
                        name : 'cek',
                        orderable : false,
                        searchable : false,
                        width : '15%'
                    },
                    {
                        data: 'aksi',
                        name : 'aksi',
                        orderable : false,
                        searchable : false,
                        width : '15%'
                    },
            ]
        });
        $('#crudTable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = datatable.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( template(row.data()) ).show();
            tr.addClass('shown');
        }
    });




        }
    });

   


    </script>
@endpush