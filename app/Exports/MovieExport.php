<?php

namespace App\Exports;

use App\Models\Movie;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class MovieExport implements FromCollection, WithHeadings, WithMapping
{
    private $key = 0;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Movie::orderBy('created_at', 'DESC')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Judul',
            'Durasi',
            'Genre',
            'Sutradara',
            'Usia Minimal',
            'Poster',
            'Sinopsis',
            'Status Aktif'
        ];
    }

    public function map($movie): array
    {
        return [
            ++$this->key,
            $movie->title,
            Carbon::parse($movie->duration)->format('H') . ' Jam' . Carbon::parse($movie->duration)->format('i') . ' Menit',
            $movie->genre,
            $movie->director,
            $movie->age_rating . '+',
            asset("storage") . '/' . $movie->poster,
            $movie->description,
            $movie->actived == 1 ? 'Aktif' : 'Non-Aktif'
        ];
    }
}
