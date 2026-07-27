@extends('layouts.admin')

@section('content')

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="chart-header">
        Ubah Kategori Budaya
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

    <form action="{{ route('kategori.update', $kategori->kategori_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $kategori->nama) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Unggah Ikon Baru (Opsional)</label>
            
            @if($kategori->icon)
                <div style="margin-bottom: 10px; display: flex; align-items: center; gap: 15px;">
                    <img src="{{ asset('storage/' . $kategori->icon) }}" alt="Ikon saat ini" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                    <span style="font-size: 12px; color: var(--text-gray);">Ikon saat ini</span>
                </div>
            @endif
            
            <input type="file" name="icon" class="form-control" style="padding-top: 9px;" accept="image/*">
            <small style="color: var(--text-gray); font-size: 11px; margin-top: 5px; display: block;">Maksimal ukuran file: 2MB. Hanya unggah jika ingin mengganti ikon lama.</small>
        </div>

        <div class="form-group" style="margin-bottom: 25px;">
            <label class="form-label">Deskripsi Singkat</label>
            <textarea name="deskripsi" class="form-control" style="height: 120px; resize: vertical;" required>{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn-submit">PERBARUI</button>
            <a href="{{ route('kategori.index') }}" class="btn-cancel">BATAL</a>
        </div>
    </form>
</div>
@endsection
