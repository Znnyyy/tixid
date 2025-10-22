<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MovieExport;
use App\Models\Schedule;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movie.index', compact('movies'));
    }

    public function home()
    {
        // where('filed', 'operator', 'value') : cari data
        // operator: =, <, >, <=, >=, <>, !=, like
        // orderBy('filed', 'asc/desc') : mengurutkan data
        // ASC : ascending (dari kecil ke besar)
        // DESC : descending (dari besar ke kecil)
        // limit(n) : membatasi jumlah data yang diambil
        // get() : ambil hasil proses filter
        $movies = Movie::where('actived', 1)->orderBy('created_at', 'DESC')->limit(4)->get();
        return view('home', compact('movies'));
    }

    public function homeMovies(Request $request)
    {
        // ambil request dari input pencarian
        $namaMovie = $request->search_movie;
        if ($namaMovie != "") {
            // like mencari data yang sesuai dengan teks tertentu
            // % didepan mencari kata bellakang
            // % dibelakang mencari kata depan
            $movies = Movie::where('title', 'LIKE', '%' . $namaMovie . '%')->where('actived', 1)->orderBy('created_at', 'DESC')->get();     
        } else {
            $movies = Movie::where('actived', 1)->orderBy('created_at', 'DESC')->get();
        }
        return view('movies', compact('movies'));
    }

    public function deactivate($id)
    {
        Movie::where('id', $id)->update(['actived' => 0]);
        return redirect()->route('admin.movies.index')->with('success', 'Berhasil menonaktifkan film');
    }

    public function activate($id)
    {
        Movie::where('id', $id)->update(['actived' => 1]);
        return redirect()->route('admin.movies.index')->with('success', 'Berhasil mengaktifkan film');
    }

    public function movieSchedule($movie_id)
    {
        $movies = Movie::where('id', $movie_id)->with(['schedules', 'schedules.cinema'])->first();
        return view('schedule.detail', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.movie.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'genre' => 'required',
            'duration' => 'required',
            'director' => 'required',
            'age_rating' => 'required',
            'poster' => 'required|image|mimes:jpg,png,jpeg,svg,webp|max:2048',
            'description' => 'required|min:10',
        ], [
            'title.required' => 'Judul wajib diisi',
            'duration.required' => 'Durasi wajib diisi',
            'genre.required' => 'Genre wajib diisi',
            'director.required' => 'Director wajib diisi',
            'age_rating.required' => 'Age rating wajib diisi',
            'poster.required' => 'Poster wajib diisi',
            'poster.mimes' => 'Format poster wajib berupa jpg, png, jpeg, svg, webp',
            'description.required' => 'Deskripsi wajib diisi',
            'description.min' => 'Deskripsi minimal 10 karakter',
        ]);

        $poster = $request->file('poster');
        $namaFile = Str::random(10) . "poster." . $poster->getClientOriginalExtension();
        $path = $poster->storeAs("poster", $namaFile, "public");


        $createData = Movie::create([
            'title' => $request->title,
            'duration' => $request->duration,
            'genre' => $request->genre,
            'director' => $request->director,
            'age_rating' => $request->age_rating,
            'poster' => $path,
            'description' => $request->description,
            'actived' => 1
        ]);

        if ($createData) {
            return redirect()->route('admin.movies.index')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan data');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $movies = Movie::findOrFail($id);

        return view('schedule.detail', compact('movies'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $movies = Movie::find($id);
        return view('admin.movie.edit', compact('movies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'genre' => 'required',
            'duration' => 'required',
            'director' => 'required',
            'age_rating' => 'required',
            'description' => 'required|min:10',
        ], [
            'title.required' => 'Judul wajib diisi',
            'duration.required' => 'Durasi wajib diisi',
            'genre.required' => 'Genre wajib diisi',
            'director.required' => 'Director wajib diisi',
            'age_rating.required' => 'Age rating wajib diisi',
            'description.required' => 'Deskripsi wajib diisi',
            'description.min' => 'Deskripsi minimal 10 karakter',
        ]);

        $movies = Movie::find($id);
        if ($request->file('poster')) {
            $filePath = storage_path('app/public/' . $movies->poster);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $file = $request->file('poster');
            $namaFile = 'poster-' . Str::random(10) . '.' .
                $file->getClientOriginalExtension();
            $path = $file->storeAs("poster", $namaFile, "public");
        }

        $updateData = Movie::where('id', $id)->update([
            'title' => $request->title,
            'duration' => $request->duration,
            'genre' => $request->genre,
            'director' => $request->director,
            'age_rating' => $request->age_rating,
            'poster' => $request->hasFile('poster') ? $path : $movies->poster,
            'description' => $request->description,
        ]);

        if ($updateData) {
            return redirect()->route('admin.movies.index')->with('success', 'Berhasil mengupdate data');
        } else {
            return redirect()->back()->with('error', 'Gagal, silahkan coba lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $schedules = Schedule::where('movie_id', $id)->count();
        if ($schedules) {
            return redirect()->route('admin.movies.index')->with('error', 'Data tidak bisa dihapus karena masih memiliki jadwal');
        }

        $movies = Movie::findOrFail($id);

        // Hapus record dari database
        $movies->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Data dan poster berhasil dihapus.');
    }

        public function trash()
    {
        $movieTrash = Movie::onlyTrashed()->get();
        return view('admin.movie.trash', compact('movieTrash'));
    }

    public function restore($id)
    {
        $movie = Movie::onlyTrashed()->find($id);
        $movie->restore();
        return redirect()->route('admin.movies.index')->with('success', 'Film Berhasil Dipulihkan');
    }

    public function deletePermanent($id)
    {
        $movie = Movie::onlyTrashed()->find($id);

        // Hapus file poster dari storage (pakai disk public)
        if ($movie && $movie->poster && Storage::disk('public')->exists($movie->poster)) {
            Storage::disk('public')->delete($movie->poster);
        }

        if ($movie) {
            $movie->forceDelete();
            return redirect()->back()->with('success', 'Film Berhasil Dihapus Seutuhnya');
        } else {
            return redirect()->back()->with('error', 'Film tidak ditemukan di trash');
        }
    }

    public function export()
    {
        // nama file yang akan didownload
        // ekstensinya xlsx, xls, csv
        $fileName = 'data-film.xlsx';
        return Excel::download(new MovieExport, $fileName);
    }
}
