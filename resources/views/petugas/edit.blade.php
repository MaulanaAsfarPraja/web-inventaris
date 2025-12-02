@extends('layouts.app')

@section('title', 'Edit Petugas')

@section('content')

<style>
    .form-modern {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .form-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        padding: 25px;
    }
    
    .form-header h3 {
        margin: 0;
        font-weight: 700;
    }
    
    .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #2575fc;
        box-shadow: 0 0 0 3px rgba(37, 117, 252, 0.1);
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }
    
    .btn-update {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .btn-back {
        background: #e0e0e0;
        color: #333;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-back:hover {
        background: #d0d0d0;
        color: #333;
    }
    
    .photo-section {
        background: #f8f9ff;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .photo-preview {
        max-width: 150px;
        border-radius: 10px;
        margin-bottom: 10px;
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-modern">
                <div class="form-header">
                    <h3>✏️ Edit Petugas</h3>
                </div>

                <div class="p-4">
                    @if(!(auth()->check() && auth()->user()->isAdmin()))
                        <div class="alert alert-warning">Akses ditolak. Hanya admin yang dapat mengakses halaman ini.</div>
                    @else
                        <form action="{{ route('petugas.update', $petugas->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ $petugas->nama }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" value="{{ $petugas->jabatan }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">No HP</label>
                                <input type="text" name="no_hp" class="form-control" value="{{ $petugas->no_hp }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $petugas->email }}" required>
                            </div>

                            <div class="photo-section">
                                <label class="form-label" style="margin-bottom: 12px;">📷 Foto Saat Ini</label>
                                @if ($petugas->foto)
                                    <div>
                                        <img src="{{ asset('foto_petugas/' . $petugas->foto) }}" class="photo-preview img-thumbnail">
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="hapus_foto" id="hapus_foto" class="form-check-input" value="1">
                                        <label class="form-check-label" for="hapus_foto">
                                            Hapus foto lama
                                        </label>
                                    </div>
                                @else
                                    <p class="text-muted">Belum ada foto</p>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Upload Foto Baru</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Format: JPG, PNG. Ukuran maksimal: 2MB</small>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('petugas.index') }}" class="btn btn-back">← Kembali</a>
                                <button type="submit" class="btn btn-update">✓ Update</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
