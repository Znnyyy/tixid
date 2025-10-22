<?php

namespace App\Exports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ScheduleExport implements FromCollection, WithHeadings, WithMapping
{
    private $key = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Schedule::orderBy('created_at', 'ASC')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Bioskop',
            'Judul Film',
            'Harga',
            'Jam Tayang'
        ];
    }

    public function map($schedule): array
    {
        return [
            ++$this->key,
            $schedule->cinema->name,
            $schedule->movie->title,
            $schedule->price ? 'Rp' . number_format($schedule->price, 0, ',', '.') : '',
            $schedule->hour
        ];
    }
}
