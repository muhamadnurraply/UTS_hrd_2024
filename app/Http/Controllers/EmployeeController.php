<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
       /**
     * Menampilkan daftar resource.
     */
    public function index()
    {
        $karyawan = Employees::all();
        
        if ($karyawan->isEmpty()) {
            return response()->json([
                'pesan' => 'Data kosong',
                'data' => []
            ], 200);
        }
    
        return response()->json([
            'pesan' => 'Menampilkan seluruh resource',
            'data' => $karyawan
        ], 200);
    }

    /**
     * Menampilkan formulir untuk membuat resource baru.
     */
    public function create()
    {
        //
    }

    /**
     * Menyimpan resource yang baru dibuat ke dalam penyimpanan.
     */
    public function store(Request $request)
    {
        try {
            $validasi = $request->validate([
                'name' => 'required|string',
                'gender' => 'required|in:M,F',  // menggunakan validasi in untuk gender
                'phone' => 'required|string',
                'address' => 'required|string',
                'email' => 'required|email|unique:employees,email',
                'status' => 'required|string',
                'hired_on' => 'required|date',
            ]);
    
            $karyawan = Employees::create($validasi);
    
            return response()->json([
                'pesan' => 'Resource berhasil ditambahkan',
                'data' => $karyawan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'pesan' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan resource yang ditentukan.
     */
    public function show($id)
    {
        $karyawan = Employees::find($id);

        if (!$karyawan) {
            return response()->json([
                'pesan' => 'Resource tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'pesan' => 'Menampilkan detail resource',
            'data' => $karyawan
        ], 200);
    }

    /**
     * Menampilkan formulir untuk mengedit resource yang ditentukan.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Memperbarui resource yang ditentukan dalam penyimpanan.
     */
    public function update(Request $request, $id)
{
    $karyawan = Employees::find($id);

    if (!$karyawan) {
        return response()->json([
            'pesan' => 'Resource tidak ditemukan',
            'data' => null
        ], 404);
    }

    $validasi = $request->validate([
        'name' => 'required|string',
        'gender' => 'required|in:M,F',  // Perbaiki validasi gender
        'phone' => 'required|string',
        'address' => 'required|string',
        'email' => 'required|email|unique:employees,email,' . $id,  // Perbaiki validasi email
        'status' => 'required|string',
        'hired_on' => 'required|date',
    ]);

    // Update data
    $karyawan->update($validasi);

    return response()->json([
        'pesan' => 'Resource berhasil diperbarui',
        'data' => $karyawan
    ], 200);
}

    /**
     * Menghapus resource yang ditentukan dari penyimpanan.
     */
    public function destroy($id)
    {
        $karyawan = Employees::find($id);
    
        if (!$karyawan) {
            return response()->json([
                'pesan' => 'Resource tidak ditemukan'
            ], 404);
        }
    
        $karyawan->delete();
    
        return response()->json([
            'pesan' => 'Resource berhasil dihapus'
        ], 200);
    }

    public function search($name)
    {
        $karyawan = Employees::where('name', 'like', '%' . $name . '%')->get();
    
        if ($karyawan->isEmpty()) {
            return response()->json([
                'pesan' => 'Resource tidak ditemukan',
                'data' => []
            ], 404);
        }
    
        return response()->json([
            'pesan' => 'Menampilkan resource yang dicari',
            'data' => $karyawan
        ], 200);
    }

    public function active()
    {
        $karyawan = Employees::where('status', 'active')->get();
    
        return response()->json([
            'pesan' => 'Menampilkan resource aktif',
            'total' => $karyawan->count(),
            'data' => $karyawan
        ], 200);
    }

    public function inactive()
    {
        $karyawan = Employees::where('status', 'inactive')->get();
    
        return response()->json([
            'pesan' => 'Menampilkan resource tidak aktif',
            'total' => $karyawan->count(),
            'data' => $karyawan
        ], 200);
    }

    public function terminated()
    {
        $karyawan = Employees::where('status', 'terminated')->get();
    
        return response()->json([
            'pesan' => 'Menampilkan resource dihentikan',
            'total' => $karyawan->count(),
            'data' => $karyawan
        ], 200);
    }
    

}
