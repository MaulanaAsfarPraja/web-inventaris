@extends('layouts/app')

@section('title', 'Data Barang')

@section('content')

    <style>
        .table-modern {
            border-collapse: collapse;
        }

        .table-modern thead {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
        }

        .table-modern tbody tr {
            transition: all 0.3s ease;
        }

        .table-modern tbody tr:hover {
            background-color: #f8f9ff;
        }

        .btn-custom-edit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            border: none;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 0.875rem;
        }

        .btn-custom-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.4);
        }

        .btn-custom-delete {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white !important;
            border: none;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 0.875rem;
        }

        .btn-custom-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(245, 87, 108, 0.4);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding: 20px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border-radius: 10px;
            color: white;
        }

        .page-header h2 {
            margin: 0;
            font-weight: 700;
        }

        .btn-add {
            background: white;
            color: #2575fc;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: #2575fc;
        }
    </style>

    <div class="page-header">
        <h2>📦 Data Barang</h2>
        <a href="{{ route('barang.create') }}" class="btn btn-add">+ Tambah Barang</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success"
            style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border: none; border-radius: 10px; padding: 15px;">
            {{ session('success') }}</div>
    @endif

    <div class="card shadow-lg" style="border: none; border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover mb-0">
                    <thead class="text-center">
                        <tr>
                            <th style="padding: 15px;">No</th>
                            <th style="padding: 15px;">Nama Barang</th>
                            <th style="padding: 15px;">Total</th>
                            <th style="padding: 15px;">Bagus</th>
                            <th style="padding: 15px;">Rusak</th>
                            <th style="padding: 15px;">Keterangan</th>
                            <th style="padding: 15px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangs as $barang)
                            <tr>
                                <td style="padding: 12px; text-align: center;">{{ $loop->iteration }}</td>
                                <td style="padding: 12px;">{{ $barang->nama_barang }}</td>
                                <td style="padding: 12px; text-align: center;">{{ $barang->total }}</td>
                                <td style="padding: 12px; text-align: center;"><span
                                        style="background: #d4edda; color: #155724; padding: 5px 10px; border-radius: 5px;">{{ $barang->kondisi_bagus }}</span>
                                </td>
                                <td style="padding: 12px; text-align: center;"><span
                                        style="background: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 5px;">{{ $barang->kondisi_rusak }}</span>
                                </td>
                                <td style="padding: 12px;">{{ $barang->keterangan }}</td>
                                <td style="padding: 12px; text-align: center;">
                                    <a href="{{ route('barang.edit', $barang->id) }}"
                                        class="btn btn-sm btn-custom-edit">Edit</a>
                                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-custom-delete"
                                            onclick="return confirm('Yakin hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
