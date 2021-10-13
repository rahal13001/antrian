<?php

namespace App\Exports;

use App\Models\Visitor;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class VisitorsExport implements FromQuery, WithHeadings, WithStyles, WithColumnWidths
{
    use Exportable;

    protected $from_date;
    protected $to_date;

    public function __construct($from_date, $to_date)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }
    public function query()
    {
        if (!empty($this->from_date)) {
            if ($this->from_date === $this->to_date) {
                $data = DB::table('visitors')
                    ->where('tanggal', '=', $this->to_date)
                    ->select('tanggal', 'lokasi', 'no_urut', 'jam', 'keperluan', 'nama', 'no_hp',  'email', 'status')->orderBy('tanggal');
            } else {
                $data = DB::table('visitors')
                    ->whereBetween('tanggal', [$this->from_date, $this->to_date])
                    ->select('tanggal', 'lokasi', 'no_urut', 'jam', 'keperluan', 'nama', 'no_hp',  'email', 'status')->orderBy('tanggal');
            }  // return Book::query()->whereBetween('tanggal', [$this->from_date, $this->to_date]);
        } else {
            $data =  DB::table('visitors')
                ->select('tanggal', 'lokasi', 'no_urut', 'jam', 'keperluan', 'nama', 'no_hp',  'email', 'status')->orderBy('tanggal');
        }
        return $data;
    }
    public function headings(): array
    {
        return [
            'Tanggal',
            'Lokasi',
            'Nomor Urut',
            'Jam',
            'Keperluan',
            'Nama',
            'Nomor HP',
            'Email',
            'Status',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 12,
            'C' => 10,
            'D' => 15,
            'E' => 15,
            'F' => 35,
            'G' => 20,
            'H' => 35,
            'I' => 15,
        ];
    }
}
