<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $staffs = User::whereIn('role', ['admin', 'staff'])->get();
        $staffs = User::all();
        return view('admin.staff.index', compact('staffs'));
    }


    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|min:3|max:255',
            'last_name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ], [
            'first_name.required' => 'First name wajib diisi',
            'first_name.min' => 'First name minimal 3 karakter',
            'last_name.required' => 'Last name wajib diisi',
            'last_name.min' => 'Last name minimal 3 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter'
        ]);

        $createData = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        if ($createData) {
            return redirect()->route('login')->with('success', 'Berhasil registrasi, silahkan login');
        } else {
            return redirect()->back()->with('error', 'Gagal registrasi, silahkan coba lagi');
        }
    }
    public function authentication(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);
        // memverifikassi data yang akan digunakan
        $data = $request->only('email', 'password');

        // Auth::attempt -> mencocokan data dengan database
        if (Auth::attempt($data)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil login sebagai admin');
            } 
            elseif (Auth::user()->role == 'staff') {
                return redirect()->route('staff.dashboard')->with('success', 'Berhasil login sebagai staff');
            }
            else {
                return redirect()->route('home')->with('success', 'Berhasil login');
            }
        } else {
            return redirect()->back()->with('error', 'Gagal login, silahkan coba lagi');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('logout', 'Anda telah logout, silahkan login kembali untuk akses lengkap');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'password' => 'required|min:8'
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'role.required' => 'Role wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter'
        ]);

        $validated['role'] = $validated['role'] ?? 'user';

        $createData = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if ($createData) {
            return redirect()->route('admin.staffs.index')->with('success', 'Berhasil menambahkan staff baru');
        } else {
            return redirect()->back()->with('error', 'Gagal, silahkan coba lagi');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //edit($id) => $id dari {id} di route edit
        // Cinema::find() => untuk mencari data dri table Cinema berdasarkan id
        $staffs = User::find($id);
        // dd untuk cek dara
        // dd($cinema->toArray());
        return view('admin.staff.edit', compact('staffs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8'
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'password.min' => 'Password minimal 8 karakter'
        ]);

        // siapkan data yang akan diupdate
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // hanya update password kalau ada isian
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $updateData = User::where('id', $id)->update($data);

        if ($updateData) {
            return redirect()->route('admin.staffs.index')->with('success', 'Berhasil mengupdate data');
        } else {
            return redirect()->back()->with('error', 'Gagal, silahkan coba lagi');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('admin.staffs.index')->with('success', 'Berhasil menghapus data!');
    }

        public function trash()
    {
        $staffTrash = User::onlyTrashed()->get();
        return view('admin.staff.trash', compact('staffTrash'));
    }

    public function restore($id)
    {
        $staff = User::onlyTrashed()->find($id);
        $staff->restore();
        return redirect()->route('admin.staffs.index')->with('success', 'Staff Berhasil Dipulihkan');
    }

    public function deletePermanent($id)
    {
        $staff = User::onlyTrashed()->find($id);
        $staff->forceDelete();
        return redirect()->back()->with('success', 'Staff Berhasil Dihapus Seutuhnya');
    }

    public function export()
    {
        $fileName = 'staffs.xlsx';
        return Excel::download(new UserExport, $fileName);
    }
}
