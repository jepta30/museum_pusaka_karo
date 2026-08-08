@extends('layouts.admin')

@section('content')

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="chart-header">
        Tambah Jenis Koleksi Baru
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
            <label class="form-label">Nama Jenis Koleksi</label>
            <input type="text" name="nama" class="form-control" placeholder="Contoh: Senjata Tradisional" value="{{ old('nama') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Unggah Ikon (Gambar PNG/JPG/SVG)</label>
            <input type="file" name="icon" class="form-control" style="padding-top: 9px;" accept="image/*" required>
            <small style="color: var(--text-gray); font-size: 11px; margin-top: 5px; display: block;">Maksimal ukuran file: 2MB. Resolusi yang disarankan: 100x100 pixels persegi.</small>
        </div>

        <div class="form-group" style="margin-bottom: 25px;">
            <label class="form-label">Deskripsi Singkat</label>
            <textarea name="deskripsi" class="form-control" style="height: 120px; resize: vertical;" placeholder="Tuliskan deskripsi jenis koleksi di sini..." required>{{ old('deskripsi') }}</textarea>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn-submit">SIMPAN</button>
            <a href="{{ route('kategori.index') }}" class="btn-cancel">BATAL</a>
        </div>
    </form>
</div>
@endsection
