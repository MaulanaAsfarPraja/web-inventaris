<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('barang')->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('transaksi.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal'   => 'required|date',
            'jenis'     => 'required|in:masuk,keluar',
            'jumlah'    => 'required|integer|min:1',
            'keterangan'=> 'nullable|string'
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        // Simpan transaksi
        Transaksi::create($request->all());

        // Update stok barang
        if ($request->jenis == 'masuk') {
            // Transaksi masuk: tambah kondisi_bagus
            $barang->kondisi_bagus += $request->jumlah;
        } else {
            // Transaksi keluar: kurang kondisi_bagus
            $barang->kondisi_bagus -= $request->jumlah;
        }

        $barang->save();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $barangs = Barang::all();

        return view('transaksi.edit', compact('transaksi', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal'   => 'required|date',
            'jenis'     => 'required|in:masuk,keluar',
            'jumlah'    => 'required|integer|min:1',
            'keterangan'=> 'nullable|string'
        ]);

        $barangLama = Barang::find($transaksi->barang_id);
        $barangBaru = Barang::find($request->barang_id);

        // Kembalikan stok lama
        if ($transaksi->jenis == 'masuk') {
            $barangLama->kondisi_bagus -= $transaksi->jumlah;
        } else {
            $barangLama->kondisi_bagus += $transaksi->jumlah;
        }
        $barangLama->save();

        // Update transaksi
        $transaksi->update($request->all());

        // Update stok baru
        if ($request->jenis == 'masuk') {
            $barangBaru->kondisi_bagus += $request->jumlah;
        } else {
            $barangBaru->kondisi_bagus -= $request->jumlah;
        }
        $barangBaru->save();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $barang = Barang::find($transaksi->barang_id);

        // Kembalikan stok
        if ($transaksi->jenis == 'masuk') {
            $barang->kondisi_bagus -= $transaksi->jumlah;
        } else {
            $barang->kondisi_bagus += $transaksi->jumlah;
        }

        $barang->save();
        $transaksi->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}