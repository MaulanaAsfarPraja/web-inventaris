@extends('layouts.app')

@section('title', 'Tambah Petugas')

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
    
    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-save:hover {
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
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-modern">
                <div class="form-header">
                    <h3>➕ Tambah Petugas Lab</h3>
                </div>

                <div class="p-4">
                    @if(!(auth()->check() && auth()->user()->isAdmin()))
                      <div class="alert alert-warning">Akses ditolak. Hanya admin yang dapat mengakses halaman ini.</div>
                    @else
                      <form action="{{ route('petugas.store') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          
                          <div class="mb-4">
                              <label class="form-label">Nama</label>
                              <input type="text" name="nama" class="form-control" required>
                          </div>
                          
                          <div class="mb-4">
                              <label class="form-label">Jabatan</label>
                              <input type="text" name="jabatan" class="form-control" required>
                          </div>
                          
                          <div class="mb-4">
                              <label class="form-label">No HP</label>
                              <input type="text" name="no_hp" class="form-control">
                          </div>
                          
                          <div class="mb-4">
                              <label class="form-label">Email</label>
                              <input type="email" name="email" class="form-control" required>
                          </div>

                          <div class="mb-4">
                              <label class="form-label">Foto</label>
                              <input type="file" name="foto" class="form-control" accept="image/*">
                              <small class="form-text text-muted">Format: JPG, PNG. Ukuran maksimal: 2MB</small>
                          </div>

                          <div class="d-flex gap-2">
                              <a href="{{ route('petugas.index') }}" class="btn btn-back">← Kembali</a>
                              <button class="btn btn-save">✓ Simpan</button>
                          </div>
                      </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
