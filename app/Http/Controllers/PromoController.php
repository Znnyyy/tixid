<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PromoExport;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promos = Promo::all();
        return view('staff.promo.index', compact('promos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.promo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'promo_code' => 'required',
            'type' => 'required',
            'discount' => 'required'
        ], [
            'promo_code.required' => 'Kode Promo Wajib Diisi',
            'type.required' => 'Wajib  Memilih Tipe Promo',
            'discount.required' => 'Jumlah Diskon Wajib Diisi',
            
        ]);

        if ($request->type == 'percent' && $request->discount > 100) {
            return redirect()->back()->withErrors(['discount' => 'Pastikan nilai diskon yang anda masukkan sesuai'])->withInput();
        } elseif ($request->type == 'rupiah' && $request->discount < 500) {
            return redirect()->back()->withErrors(['discount' => 'Pastikan nilai diskon yang anda masukkan sesuai'])->withInput();
        }

        $createData = Promo::create([
            'promo_code' => $request->promo_code,
            'type' => $request->type,
            'discount' => $request->discount,
            'actived' => 1
        ]);
        if ($createData) {
            return redirect()->route('staff.promos.index')->with('success', 'Berhasil membuat data baru!');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Promo $promo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $promos = Promo::find($id);
        return view('staff.promo.edit', compact('promos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'promo_code' => 'required',
            'type' => 'required',
            'discount' => 'required'
        ], [
            'promo_code.required' => 'Kode Promo Wajib Diisi',
            'type.required' => 'Wajib  Memilih Tipe Promo',
            'discount.required' => 'Jumlah Diskon Wajib Diisi',
        ]);

        if ($request->type == 'percent' && $request->discount > 100) {
            return redirect()->back()->withErrors(['discount' => 'Pastikan nilai diskon yang anda masukkan sesuai'])->withInput();
        } elseif ($request->type == 'rupiah' && $request->discount < 500) {
            return redirect()->back()->withErrors(['discount' => 'Pastikan nilai diskon yang anda masukkan sesuai'])->withInput();
        }

        $updateData = Promo::where('id', $id)->update([
            'promo_code' => $request->promo_code,
            'type' => $request->type,
            'discount' => $request->discount,
            'actived' => 1
        ]);

        if ($updateData) {
            return redirect()->route('staff.promos.index')->with('success', 'Berhasil memperbarui data!');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Promo::where('id', $id)->delete();
        return redirect()->route('staff.promos.index')->with('success', 'Berhasil menghapus data!');
    }

        public function trash()
    {
        $promoTrash = Promo::onlyTrashed()->get();
        return view('staff.promo.trash', compact('promoTrash'));
    }

    public function restore($id)
    {
        $promo = Promo::onlyTrashed()->find($id);
        $promo->restore();
        return redirect()->route('staff.promos.index')->with('success', 'Promo Berhasil Dipulihkan');
    }

    public function deletePermanent($id)
    {
        $promo = Promo::onlyTrashed()->find($id);
        $promo->forceDelete();
        return redirect()->back()->with('success', 'Promo Berhasil Dihapus Seutuhnya');
    }

    public function export()
    {
        $fileName = 'data-promo.xlsx';
        return Excel::download(new PromoExport, $fileName);
    }
}
