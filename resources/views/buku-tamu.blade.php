@extends('layouts.public')

@section('title', 'Buku Tamu')

@push('styles')
<style>
    .bt-hero { background: linear-gradient(135deg, var(--dark-red) 0%, var(--primary-red) 100%); padding: 60px 5% 80px; color: white; text-align: center; }
    .bt-hero h1 { font-family: 'Playfair Display', serif; font-size: 34px; margin-bottom: 12px; }
    .bt-hero p { max-width: 560px; margin: 0 auto; opacity: 0.9; font-size: 14.5px; line-height: 1.7; }

    .bt-container { max-width: 560px; margin: -45px auto 80px; padding: 0 5%; }
    .bt-card { background: #fff; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 40px; }

    .bt-alert { background-color: #d1fae5; color: #065f46; padding: 14px 16px; border-radius: 6px; margin-bottom: 22px; font-size: 14px; border: 1px solid #34d399; }
    .bt-error { background-color: #fee2e2; color: #991b1b; padding: 14px 16px; border-radius: 6px; margin-bottom: 22px; font-size: 13px; }

    .bt-group { margin-bottom: 18px; display: flex; flex-direction: column; gap: 7px; }
    .bt-group label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px; color: var(--text-dark); }
    .bt-group input { padding: 12px 15px; border: 1px solid #e2e2e2; border-radius: 4px; font-size: 14px; font-family: 'Inter', sans-serif; }
    .bt-group input:focus { outline: none; border-color: var(--primary-red); }

    .bt-submit { width: 100%; padding: 13px; background: var(--primary-red); color: #fff; border: none; border-radius: 4px; font-size: 14px; font-weight: 600; cursor: pointer; margin-top: 8px; }
    .bt-submit:hover { background: var(--dark-red); }
    .bt-note { margin: 0 auto 24px; max-width: 560px; padding: 18px 22px; border-radius: 10px; background: #f9fafb; color: #374151; border: 1px solid #e5e7eb; font-size: 14px; line-height: 1.7; }
</style>
@endpush

@section('content')
<div class="bt-hero">
    <h1>Buku Tamu</h1>
    <p>Terima kasih sudah berkunjung ke Museum Pusaka Karo. Silakan isi data kunjungan Anda di bawah ini.</p>
</div>

<div class="bt-note">
    Form ini adalah buku tamu publik. Setiap kunjungan yang Anda kirim akan masuk ke daftar admin museum dan dapat dipantau sebagai laporan pengunjung.
</div>

<div class="bt-container">
    <div class="bt-card">
        @if(session('success'))
            <div class="bt-alert"><i class="fa-solid fa-circle-check" style="margin-right:8px;"></i>{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="bt-error">
                <strong>Mohon periksa kembali isian Anda:</strong>
                <ul style="margin: 6px 0 0 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('buku-tamu.store') }}" method="POST">
            @csrf
            <div class="bt-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required>
            </div>
            <div class="bt-group">
                <label>Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" required>
            </div>
            <div class="bt-group">
                <label>Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" required>
            </div>
            <button type="submit" class="bt-submit">Kirim Data Kunjungan</button>
        </form>
    </div>
</div>
@endsection
