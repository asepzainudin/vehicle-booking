<?php
namespace App\Exports;

use App\Enums\FuelType;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportFuel implements FromQuery, WithHeadings, WithStyles, ShouldAutoSize, WithEvents, Responsable, WithMapping
{
    use Exportable;


    private $aspects;
    private static $aspectsWithSymbol = [];
    private $structureOnly = false;

    /**
     * @var Builder
     */
    private $query;

    /**
     * @var Builder
     */
    private $groups;

    /**
     * @var array
     */
    private $input = [];

    /**
     * @var int
     */
    private $recNo = 0;

    /**
     * @var int
     */
    private $lastCol = 0;

    /**
     * It"s required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = "filename.xlsx";

    /**
     * Optional Writer Type
     */
    private $writerType = Excel::XLSX;

    private static $startTableRow = 1;
    private static $startTableCol = "A";
    private static $lastTableCol = "A";

    /**
     * GenerateExcelTahfidz constructor.
     * @param Builder $query
     * @param Request|null $request
     */
    public function __construct($query = null)
    {
        $this->query = $query;
        $this->lastCol = $query->get()->count();

        $this->fileName = "konsumsi-bbm-" . (request()->input('month') != null ? request()->input('month') : now()->format('Y-m')) . ".xlsx";
    }

    public function query()
    {
        return $this->query;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function headings(): array
    {
        $header = [
            "A" => "NO.",
            "B" => "Kode Pemesanan",
            "C" => "Nama Kendaraan",
            "D" => "Tanggal Isi BBM",
            "E" => "Jumlah Bensin",
            "F" => "Jenis Bensin",
            "G" => "Biaya Bensin",
            "H" => "Keterangan",
        ];

        $headers = [
            ["A" => "Konsumsi BBM " . (request()->input('month') != null ? request()->input('month') : now()->format('Y-m'))],
            ["A" => ""],
            ["A" => ""],

            $header,
        ];

        return $headers;
    }

    public function map($row): array
    {
        $rows =
        [
            ++$this->recNo,
            $row->vehicleOrder?->code ?? '' ,
            $row->vehicleOrder?->vehicle?->name ?? '' ,
            $row->date_fuel_consumption ?? '' ,
            $row->fuel_consumption ?? '' ,
            $row->fuel_type ? FuelType::from($row->fuel_type->value)->label() : '',
            $row->fuel_cost ?? '',
            $row->additional['noted'] ?? '',
        ];

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true],],
            2 => ['font' => ['bold' => true],],
            'A' => ['alignment' => ['horizontal' => 'center']],
            'E' => ['alignment' => ['horizontal' => 'center']],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Format header
                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');

                $sheet->mergeCells('A2:H2');


                // $colAngka = [
                //     "F"
                // ];

                // // Set format angka di kolom nominal
                // foreach ($colAngka as $key => $value) {
                //     $sheet->getStyle($value)->getNumberFormat()->setFormatCode('#,##0');
                // }

            }
        ];
    }
}