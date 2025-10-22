<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Exports\CinemaExport;
use Maatwebsite\Excel\Facades\Excel;

class CinemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // mengambil semua data cinema Model::all();
        $cinemas = Cinema::all();
        // compact -> mengirim data ke blade
        return view('admin.cinema.index', compact('cinemas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cinema.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required|min:10',
        ], [
            'name.required' => 'Nama bioskop wajib diisi',
            'location.required' => 'Lokasi bioskop wajib diisi',
            'location.min' => 'Lokasi bioskop minimal 10 karakter'
        ]);
        $createData = Cinema::create([
            'name' => $request->name,
            'location' => $request->location,
        ]);
        if ($createData) {
            return redirect()->route('admin.cinemas.index')->with('success', 'Berhasil menambahkan data baru');
        } else {
            return redirect()->back()->with('error', 'Gagal, silahkan coba lagi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cinema $cinema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //edit($id) => $id dari {id} di route edit
        // Cinema::find() => untuk mencari data dri table Cinema berdasarkan id
        $cinema = Cinema::find($id);
        // dd untuk cek dara
        // dd($cinema->toArray());
        return view('admin.cinema.edit', compact('cinema'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //(Request $request, $id) :Request $request (ambil data form)
        $request->validate([
            'name' => 'required',
            'location' => 'required|min:10',
        ], [
            'name.required' => 'Nama bioskop wajib diisi',
            'location.required' => 'Lokasi bioskop wajib diisi',
            'location.min' => 'Lokasi bioskop minimal 10 karakter'
        ]);
        // where('id', $id) sebelum d update wajib cari data nya.
        $updateData = Cinema::where('id', $id)->update([
            'name' => $request->name,
            'location' => $request->location
        ]);
        if ($updateData) {
            return redirect()->route('admin.cinemas.index')->with('success', 'Berhasil mengupdate data');
        } else {
            return redirect()->back()->with('error', 'Gagal, silahkan coba lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $schedules = Schedule::where('cinema_id', $id)->count();
        if ($schedules) {
            return redirect()->route('admin.cinemas.index')->with('error', 'Data tidak bisa dihapus karena masih memiliki jadwal');
        }

        Cinema::where('id', $id)->delete();
        return redirect()->route('admin.cinemas.index')->with('success', 'Berhasil menghapus data!');
    }

        public function trash()
    {
        $cinemaTrash = Cinema::onlyTrashed()->get();
        return view('admin.cinema.trash', compact('cinemaTrash'));
    }

    public function restore($id)
    {
        $cinema = Cinema::onlyTrashed()->find($id);
        $cinema->restore();
        return redirect()->route('admin.cinemas.index')->with('success', 'Bioskop Berhasil Dipulihkan');
    }

    public function deletePermanent($id)
    {
        $cinema = Cinema::onlyTrashed()->find($id);
        $cinema->forceDelete();
        return redirect()->back()->with('success', 'Bioskop Berhasil Dihapus Seutuhnya');
    }

    public function export()
    {
        $fileName = 'cinemas.xlsx';
        return Excel::download(new CinemaExport, $fileName);
    }
}
