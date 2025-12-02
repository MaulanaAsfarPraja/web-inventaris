@extends('layouts.app')

@section('title', 'Data Petugas')

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
    
    .search-form {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .search-form input {
        flex: 1;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 15px;
    }
    
    .search-form button {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
    }
</style>

<div class="page-header">
    <h2>👩‍💼 Data Petugas Lab</h2>
    {{-- Tombol "Tambah Petugas" --}}
    @if(auth()->check() && auth()->user()->isAdmin())
    <a href="{{ route('petugas.create') }}" class="btn btn-add">+ Tambah Petugas</a>
    @endif
</div>

@if (session('success'))
<div class="alert alert-success" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border: none; border-radius: 10px; padding: 15px;">{{ session('success') }}</div>
@endif

<div class="search-form">
    <form action="{{ route('petugas.index') }}" method="GET" style="display: flex; gap: 10px; width: 100%;">
        <input type="text" name="search" placeholder="Cari Nama Petugas" value="{{ request()->get('search') }}" style="border: 2px solid #e0e0e0; border-radius: 8px; padding: 10px 15px; flex: 1;">
        <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 10px 25px; border-radius: 8px; font-weight: 600;">Cari</button>
    </form>
</div>

<div class="card shadow-lg" style="border: none; border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover mb-0">
                <thead class="text-center">
                    <tr>
                        <th style="padding: 15px;">No</th>
                        <th style="padding: 15px;">Foto</th>
                        <th style="padding: 15px;">Nama</th>
                        <th style="padding: 15px;">Jabatan</th>
                        <th style="padding: 15px;">No HP</th>
                        <th style="padding: 15px;">Email</th>
                        <th style="padding: 15px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($petugas as $p)
                    <tr>
                        <td style="padding: 12px; text-align: center;">{{ $loop->iteration }}</td>
                        <td style="padding: 12px; text-align: center;">
                            @if($p->foto)
                                <img src="{{ asset('foto_petugas/' . $p->foto) }}" alt="Foto Petugas" width="60" class="img-thumbnail" style="border-radius: 8px;">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </td>
                        <td style="padding: 12px;">{{ $p->nama }}</td>        
                        <td style="padding: 12px;">{{ $p->jabatan }}</td>
                        <td style="padding: 12px;">{{ $p->no_hp }}</td>
                        <td style="padding: 12px;">{{ $p->email }}</td>
                        <td style="padding: 12px; text-align: center;">
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <a href="{{ route('petugas.edit', $p) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form method="POST" action="{{ route('petugas.destroy', $p->id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus petugas?')">Hapus</button>
                                </form>
                            @else
                                <span class="text-muted">Hanya admin</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
