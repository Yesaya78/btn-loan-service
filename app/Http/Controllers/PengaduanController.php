<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    // Menampilkan halaman formulir
    public function create()
    {
        return view('pengaduan.create');
    }

    // Menyimpan laporan ke database
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate();

        // 2. Proses unggah foto
        $nama_foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nama_foto = time(). '.'. $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads'), $nama_foto);
        }

        // 3. Simpan data
        Pengaduan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'isi_laporan' => $request->isi_laporan,
            'foto' => $nama_foto,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Laporan Anda berhasil dikirim!');
    }
}