<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Cinema;
use App\Models\Movie;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ScheduleExport;


class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cinemas = Cinema::all();
        $movies = Movie::all();

        $schedules = Schedule::with(['cinema', 'movie'])->get();
        return view('staff.schedule.index', compact('cinemas', 'movies', 'schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cinema_id' => 'required',
            'movie_id' => 'required',
            'price' => 'required|numeric',
            // karena hour array yg divalidasi isi item nya menggunakan dot (.*)
            // date_format:H:i = format time hour:menit
            'hour.*' => 'required|date_format:H:i',
        ], [
            'cinema_id.required' => 'Bioskop Wajib Dipilih',
            'movie_id.required' => 'Film Wajib Dipilih',
            'price.required' => 'Harga Wajib Diisi',
            'price.numeric' => 'Harga Wajib Berupa Angka',
            'hour.*.required' => 'Jam Tayang Wajib Diisi',
            'hour.*.date_format' => 'Format Jam Tayang Wajib Berupa Jam:Menit (H:i)',
        ]);

        // cek apakah data bioskop dam film yang dipilih sudah ada, kalo ada ambil jamnya
        $hour = Schedule::where('cinema_id', $request->cinema_id)->where('movie_id', 
        $request->movie_id)->value('hour');
        // value('hours') : dari schedule cmn ambil bagian hours
        // jika belum ada data bioskop dan film, hoursakan Nul ubah menjadi []
        $hourBefore = $hour ?? [];
        // gabungkan hours sebelumnya dengan hours yang baru akan ditambahkan
        $meregeHour = array_merge($hourBefore, $request->hour);
        // jika ada jam duplikat, ambil salah satu
        $newHour = array_unique($meregeHour);

        // updateOrCreate([1],[2]) : mengecek bedasarkan array 1, jika ada maka update array 2,jika tidak ada tambahkan data dari array 1 dan 2
        $createData = Schedule::updateOrCreate([
            'cinema_id' => $request->cinema_id,
            'movie_id' => $request->movie_id,
        ],[
            'price' => $request->price,
            'hour' => $newHour
      ]);

        if ($createData) {
            return redirect()->route('staff.schedules.index')->with('success', 'Jadwal Berhasil Ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Jadwal Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule, $id)
    {
        $schedule = Schedule::where('id', $id)->with(['cinema', 'movie'])->first();
        return view('staff.schedule.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric',
            'hour.*' => 'required|date_format:H:i',
        ],[
            'price.required' => 'Harga Wajib Diisi',
            'price.numeric' => 'Harga Wajib Berupa Angka',
            'hour.*.required' => 'Jam Tayang Wajib Diisi',
            'hour.*.date_format' => 'Format Jam Tayang Wajib Berupa Jam:Menit (H:i)',
        ]);
        
        $updateData = Schedule::where('id', $id)->update([
            'price' => $request->price,
            'hour' => $request->hour,
        ]);

        if ($updateData) {
            return redirect()->route('staff.schedules.index')->with('success', 'Jadwal Berhasil Diupdate');
        } else {
            return redirect()->back()->with('error', 'Jadwal Gagal Diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Schedule::where('id', $id)->delete();
        return redirect()->route('staff.schedules.index')->with('success', 'Jadwal Berhasil Dihapus');
    }

    public function export()
    {
        $fileName = 'data-schedule.xlsx';
        return Excel::download(new ScheduleExport, $fileName);
    }

    public function trash()
    {
        $scheduleTrash = Schedule::with(['cinema', 'movie'])->onlyTrashed()->get();
        return view('staff.schedule.trash', compact('scheduleTrash'));
    }

    public function restore($id)
    {
        $schedule = Schedule::onlyTrashed()->find($id);
        $schedule->restore();
        return redirect()->route('staff.schedules.index')->with('success', 'Jadwal Berhasil Dipulihkan');
    }

    public function deletePermanent($id)
    {
        $schedule = Schedule::onlyTrashed()->find($id);
        $schedule->forceDelete();
        return redirect()->back()->with('success', 'Jadwal Berhasil Dihapus Seutuhnya');
    }
}
