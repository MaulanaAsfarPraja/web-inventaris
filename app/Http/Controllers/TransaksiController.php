<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\StatusBarang;
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
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        DB::transaction(function () use ($validated) {

            $transaksi = Transaksi::create($validated);

            $barang = Barang::findOrFail($validated['barang_id']);
            $qty = (int)$validated['jumlah'];

            if ($validated['jenis'] === 'masuk') {
                // MASUK = barang bagus bertambah
                $barang->kondisi_bagus += $qty;

            } else {
                // KELUAR = barang rusak berkurang
                $barang->kondisi_rusak = max(0, $barang->kondisi_rusak - $qty);

                // TAMBAH CATATAN KE STATUSBARANG
                StatusBarang::create([
                    'barang_id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'jumlah_rusak' => $qty,
                    'tanggal_rusak' => $validated['tanggal'],
                    'keterangan' => 'Barang keluar (mengurangi stok rusak)',
                ]);
            }

            $barang->save();
        });

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $barangs = Barang::all();

        return view('transaksi.edit', compact('transaksi', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        DB::transaction(function () use ($id, $validated) {

            $transaksi = Transaksi::findOrFail($id);

            $oldBarang = Barang::findOrFail($transaksi->barang_id);
            $oldQty = (int)$transaksi->jumlah;

            // ROLLBACK stok lama
            if ($transaksi->jenis === 'masuk') {
                $oldBarang->kondisi_bagus -= $oldQty;
            } else {
                $oldBarang->kondisi_rusak += $oldQty;
            }
            $oldBarang->save();

            // Update transaksi
            $transaksi->update($validated);

            // Terapkan stok baru
            $barang = Barang::findOrFail($validated['barang_id']);
            $qty = (int)$validated['jumlah'];

            if ($validated['jenis'] === 'masuk') {
                $barang->kondisi_bagus += $qty;

            } else {
                $barang->kondisi_rusak = max(0, $barang->kondisi_rusak - $qty);

                // BUAT CATATAN BARU STATUS BARANG
                StatusBarang::create([
                    'barang_id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'jumlah_rusak' => $qty,
                    'tanggal_rusak' => $validated['tanggal'],
                    'keterangan' => 'Update transaksi keluar (mengurangi stok rusak)',
                ]);
            }

            $barang->save();
        });

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diubah');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            $transaksi = Transaksi::findOrFail($id);
            $barang = Barang::findOrFail($transaksi->barang_id);
            $qty = (int)$transaksi->jumlah;

            // Kembalikan stok sebelum hapus transaksi
            if ($transaksi->jenis === 'masuk') {
                $barang->kondisi_bagus -= $qty;
            } else {
                $barang->kondisi_rusak += $qty;

                // Catatan pengembalian status
                StatusBarang::create([
                    'barang_id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'jumlah_rusak' => $qty,
                    'tanggal_rusak' => now(),
                    'keterangan' => 'Hapus transaksi keluar (stok rusak dikembalikan)',
                ]);
            }

            $barang->save();
            $transaksi->delete();
        });

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }
}
