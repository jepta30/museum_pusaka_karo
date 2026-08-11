@extends('layouts.admin')

@section('title', 'Kritik & Saran')

@section('content')
<div class="admin-header">
    <div class="header-left">
        <h1 class="page-title">Kritik & Saran</h1>
        <p class="page-subtitle">Kelola masukan dan saran dari pengunjung web.</p>
    </div>
</div>

<div class="data-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Tanggal</th>
                    <th width="20%">Nama Pengirim</th>
                    <th width="45%">Pesan / Saran</th>
                    <th width="15%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sarans as $index => $saran)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $saran->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <div style="font-weight: 600;">{{ $saran->nama }}</div>
                        @if($saran->email)
                            <div style="font-size: 12px; color: var(--text-gray);">{{ $saran->email }}</div>
                        @endif
                    </td>
                    <td>
                        <div style="max-height: 80px; overflow-y: auto; padding-right: 5px;">
                            {{ $saran->pesan }}
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons justify-center">
                            <form action="{{ route('saran.destroy', $saran->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus masukan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus Saran">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 40px 0; color: var(--text-gray);">
                        <i class="fa-regular fa-envelope-open" style="font-size: 48px; margin-bottom: 15px; color: #cbd5e1;"></i>
                        <p>Belum ada kritik dan saran dari pengunjung.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
