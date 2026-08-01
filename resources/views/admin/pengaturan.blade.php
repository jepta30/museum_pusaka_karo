@extends('layouts.admin')

@section('header_title', 'Pengaturan Akun')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h3>Pengaturan Akun</h3>
        <p>Kelola informasi profil dan keamanan akun Anda.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: 10px; border: 1px solid #f87171; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="display: flex; gap: 30px; flex-wrap: wrap;">
    <!-- Form Profil -->
    <div class="card" style="flex: 1; min-width: 300px;">
        <h4 style="margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">Informasi Profil</h4>
        <form action="{{ route('pengaturan.profile') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" class="search-input" style="width: 100%;" required>
            </div>
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="search-input" style="width: 100%;" required>
            </div>
            
            <button type="submit" class="btn-search" style="width: 100%;">Simpan Profil</button>
        </form>
    </div>

    <!-- Form Ganti Password -->
    <div class="card" style="flex: 1; min-width: 300px;">
        <h4 style="margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">Ganti Kata Sandi</h4>
        <form action="{{ route('pengaturan.password') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Kata Sandi Saat Ini</label>
                <input type="password" name="current_password" class="search-input" style="width: 100%;" required>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Kata Sandi Baru</label>
                <input type="password" name="password" class="search-input" style="width: 100%;" required>
                <small style="color: #64748b; font-size: 11px; margin-top: 5px; display: block;">Minimal 6 karakter.</small>
            </div>
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="password_confirmation" class="search-input" style="width: 100%;" required>
            </div>
            
            <button type="submit" class="btn-search" style="width: 100%; background-color: var(--primary-red);">Perbarui Kata Sandi</button>
        </form>
    </div>
</div>
@endsection
