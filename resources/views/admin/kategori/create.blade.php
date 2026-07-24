@extends('layouts.admin')

@section('content')
<style>
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: var(--text-dark); }
    .form-control { width: 100%; padding: 12px 15px; border: 1px solid var(--border-color); border-radius: 4px; font-family: 'Inter', sans-serif; font-size: 14px; outline: none; transition: border-color 0.2s; }
    .form-control:focus { border-color: var(--primary-red); }
    .btn-submit { background-color: var(--primary-red); color: white; padding: 12px 0; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: background-color 0.2s; width: 150px; }
    .btn-submit:hover { background-color: var(--primary-red-hover); }
    .btn-cancel { background-color: #6b7280; color: white; padding: 12px 0; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: background-color 0.2s; width: 150px; text-align: center; text-decoration: none; display: inline-block; }
    .btn-cancel:hover { background-color: #4b5563; }
</style>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="chart-header">
        Tambah Kategori Budaya Baru
    </div>

    @if($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: 4px; margin-bottom: 20px; font-size: 13px;">
            <strong style="margin-bottom: 5px; display: block;">Terjadi Kesalahan:</strong>
            <ul style="margin-left: 20px; margin-top: 5px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama" class="form-control" placeholder="Contoh: Senjata Tradisional" value="{{ old('nama') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Unggah Ikon (Gambar PNG/JPG/SVG)</label>
            <input type="file" name="icon" class="form-control" style="padding-top: 9px;" accept="image/*" required>
            <small style="color: var(--text-gray); font-size: 11px; margin-top: 5px; display: block;">Maksimal ukuran file: 2MB. Resolusi yang disarankan: 100x100 pixels persegi.</small>
        </div>

        <div class="form-group" style="margin-bottom: 25px;">
            <label class="form-label">Deskripsi Singkat</label>
            <textarea name="deskripsi" class="form-control" style="height: 120px; resize: vertical;" placeholder="Tuliskan deskripsi kategori di sini..." required>{{ old('deskripsi') }}</textarea>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn-submit">SIMPAN</button>
            <a href="{{ route('kategori.index') }}" class="btn-cancel">BATAL</a>
        </div>
    </form>
</div>
@endsection
