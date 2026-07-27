@extends('layouts.admin')

@section('header_title', 'Komentar')

@section('content')
<style>
    .table-header { padding: 28px; }
    .table-header h3 { font-family: 'Playfair Display', serif; font-size: 22px; color: var(--text-dark); margin: 0; }
    .comment-text { color: #6b7280; line-height: 1.75; }
</style>

@if(session('success'))
    <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; border: 1px solid #34d399;">
        <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}
    </div>
@endif

<div class="table-container">
    <div class="table-header">
        <h3>Moderasi Komentar</h3>
        <select class="select-input">
            <option>Semua Status</option>
            <option>Pending</option>
            <option>Disetujui</option>
            <option>Ditolak</option>
        </select>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="15%">NAMA</th>
                <th width="35%">KOMENTAR</th>
                <th width="15%">TANGGAL</th>
                <th width="15%">STATUS</th>
                <th width="15%">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($komentars as $index => $komentar)
            <tr>
                <td>{{ ($komentars->firstItem() ?? 1) + $index }}</td>
                <td>
                    <strong>{{ $komentar->nama }}</strong><br>
                    <span style="font-size: 11px; color: #9ca3af;">{{ $komentar->email }}</span>
                </td>
                <td class="comment-text">{{ $komentar->isi_komentar }}</td>
                <td>
                    <div style="color: var(--text-dark); font-weight: 500;">{{ $komentar->created_at->format('d/m/Y') }}</div>
                    <div style="color: #9ca3af; font-size: 11px; margin-top: 4px;">{{ $komentar->created_at->format('H:i') }}</div>
                </td>
                <td>
                    @if($komentar->status == 'pending')
                        <span class="badge">Pending</span>
                    @elseif($komentar->status == 'approved')
                        <span class="badge approved">Disetujui</span>
                    @else
                        <span class="badge rejected">Ditolak</span>
                    @endif
                </td>
                <td>
                    <div class="action-icons">
                        <form action="{{ route('komentar.update', $komentar->komentar_id) }}" method="POST" style="display: {{ $komentar->status == 'approved' ? 'none' : 'inline' }};">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn-action-square" title="Setujui"><i class="fa-solid fa-check"></i></button>
                        </form>
                        
                        <form action="{{ route('komentar.update', $komentar->komentar_id) }}" method="POST" style="display: {{ $komentar->status == 'rejected' ? 'none' : 'inline' }};">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn-action-square" title="Tolak"><i class="fa-solid fa-xmark"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: var(--text-gray); padding: 40px;">
                    Belum ada komentar dari pengunjung.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="table-footer">
        <div style="font-size: 13px; color: var(--text-gray);">
            Menampilkan {{ $komentars->firstItem() ?? 0 }} sampai {{ $komentars->lastItem() ?? 0 }} dari {{ $komentars->total() }} data
        </div>
        
        @if ($komentars->hasPages())
        <div class="pagination-controls">
            @if ($komentars->onFirstPage())
                <span class="page-btn" style="color: #ccc; cursor: not-allowed;"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $komentars->previousPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-left"></i></a>
            @endif

            <span class="page-btn active">{{ $komentars->currentPage() }}</span>

            @if ($komentars->hasMorePages())
                <a href="{{ $komentars->nextPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="page-btn" style="color: #ccc; cursor: not-allowed;"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
