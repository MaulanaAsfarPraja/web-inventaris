<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['inilogin', 'admin']);
    }

    public function index()
    {
        $petugas = Petugas::paginate(10);
    return view('petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:petugass,email',
            'no_hp' => 'nullable',
            'jabatan' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fotoName = null;
        if ($request->hasFile('foto')) {
            $fotoName = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->move(public_path('foto_petugas'), $fotoName);
        }

        Petugas::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'jabatan' => $request->jabatan,
            'foto' => $fotoName,
        ]);

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);
        return view('petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:petugass,email,' . $id,
            'no_hp' => 'nullable',
            'jabatan' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fotoName = $petugas->foto;

        // Hapus foto lama jika user memilih untuk menghapusnya
        if ($request->hapus_foto && $petugas->foto && file_exists(public_path('foto_petugas/' . $petugas->foto))) {
            unlink(public_path('foto_petugas/' . $petugas->foto));
            $fotoName = null;
        }

        // Update foto jika ada file baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada sebelum upload yang baru
            if ($fotoName && file_exists(public_path('foto_petugas/' . $fotoName))) {
                unlink(public_path('foto_petugas/' . $fotoName));
            }

            $fotoName = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->move(public_path('foto_petugas'), $fotoName);
        }

        $petugas->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'jabatan' => $request->jabatan,
            'foto' => $fotoName,
        ]);

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);

        if ($petugas->foto && file_exists(public_path('foto_petugas/' . $petugas->foto))) {
            unlink(public_path('foto_petugas/' . $petugas->foto));
        }

        $petugas->delete();
        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil dihapus');
    }
}
