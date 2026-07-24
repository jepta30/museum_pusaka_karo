@extends('layouts.admin')

@section('header_title', 'Komentar')

@section('content')
<style>
    .table-container { background-color: #fff; border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; }
    .table-header { padding: 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); }
    .table-header h3 { font-family: 'Playfair Display', serif; font-size: 22px; color: var(--text-dark); }
    .select-input { padding: 10px 15px; border: 1px solid var(--border-color); border-radius: 4px; font-size: 13px; outline: none; background-color: white; min-width: 150px; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background-color: #fff; text-align: left; padding: 20px 30px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #4b5563; border-bottom: 1px solid var(--border-color); letter-spacing: 0.5px; }
    .data-table td { padding: 25px 30px; font-size: 13px; color: var(--text-dark); border-bottom: 1px solid var(--border-color); vertical-align: top; }
    .comment-text { color: #6b7280; line-height: 1.5; }

    .badge { padding: 6px 15px; border-radius: 20px; font-size: 11px; font-weight: 600; background-color: #f3f4f6; color: #4b5563; }
    .badge.approved { background-color: #1f2937; color: white; }
    .badge.rejected { background-color: #fff; border: 1px solid var(--border-color); color: #9ca3af; }

    .action-icons { display: flex; gap: 10px; }
    .btn-action-square { width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color); border-radius: 4px; color: #9ca3af; background-color: #fff; cursor: pointer; text-decoration: none; font-size: 14px; transition: all 0.2s;}
    .btn-action-square:hover { color: var(--text-dark); border-color: var(--text-dark); }
    
    .table-footer { padding: 20px; background-color: #fff; display: flex; justify-content: space-between; align-items: center; }
    .pagination-controls { display: flex; gap: 5px; }
    .page-btn { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color); background-color: #fff; color: var(--text-dark); text-decoration: none; font-size: 13px; border-radius: 4px; transition: all 0.2s;}
    .page-btn.active { background-color: #1f2937; color: #fff; border-color: #1f2937; }
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

            @foreach ($komentars->links()->elements as $element)
                @if (is_string($element))
                    <span class="page-btn" style="border: none;">{{ $element }}</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $komentars->currentPage())
                            <span class="page-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

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
