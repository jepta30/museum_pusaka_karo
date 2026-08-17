@extends('layouts.admin')

@section('header_title', 'Koleksi Budaya')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    .page-header { margin-bottom: 25px; }
    .search-input { width: 300px; }
    .action-icons { gap: 8px; }
</style>

<div class="page-header">
    <div class="page-title">
        <h3>Kelola Koleksi Budaya</h3>
        <p>Manajemen data daftar koleksi budaya Karo</p>
    </div>
    <div class="header-actions">
        <button type="button" class="btn-add" onclick="openModal('add')">
            <i class="fa-solid fa-plus"></i> Tambah Data
        </button>
    </div>
</div>

@if(session('success'))
    <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; border: 1px solid #34d399;">
        <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}
    </div>
@endif

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

<form method="GET" class="filter-bar">
    <div class="filter-group">
        <input type="text" name="q" value="{{ request('q') }}" class="search-input" placeholder="Cari judul atau lokasi...">
        <select name="kategori_id" class="select-input">
            <option value="">Semua Jenis Koleksi</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->kategori_id }}" {{ request('kategori_id') == $kat->kategori_id ? 'selected' : '' }}>
                    {{ $kat->nama }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn-search"><i class="fa-solid fa-search"></i> Cari</button>
    </div>
</form>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="25%">NAMA</th>
                <th width="20%">JENIS KOLEKSI</th>
                <th width="20%">LOKASI</th>
                <th width="15%">STATUS</th>
                <th width="15%">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($warisans as $index => $warisan)
            <tr>
                <td>{{ $warisans->firstItem() + $index }}</td>
                <td><strong>{{ $warisan->judul }}</strong></td>
                <td>{{ $warisan->kategori->nama ?? 'Umum' }}</td>
                <td>{{ $warisan->lokasi }}</td>
                <td>
                    <span class="badge {{ $warisan->status == 'aktif' ? '' : 'draft' }}">
                        {{ $warisan->status == 'aktif' ? 'Publik' : 'Draf' }}
                    </span>
                </td>
                <td>
                    <div class="action-icons">
                        <button type="button" class="btn-action-square" title="Edit" onclick="openModal('edit', {{ json_encode($warisan) }})">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('warisan.destroy', $warisan->warisan_budaya_id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-square" title="Hapus"><i class="fa-regular fa-trash-can"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: var(--text-gray); padding: 40px;">
                    Belum ada data koleksi budaya.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="table-footer">
        <div style="font-size: 13px; color: var(--text-gray);">
            Menampilkan {{ $warisans->firstItem() ?? 0 }} sampai {{ $warisans->lastItem() ?? 0 }} dari {{ $warisans->total() }} data
        </div>
        
        @if ($warisans->hasPages())
        <div class="pagination-controls">
            {{-- Previous Page Link --}}
            @if ($warisans->onFirstPage())
                <span class="page-btn" style="color: #ccc; cursor: not-allowed;"><i class="fa-solid fa-chevron-left"></i></span>
            @else
                <a href="{{ $warisans->previousPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-left"></i></a>
            @endif

            {{-- Pagination Elements --}}
            <span class="page-btn active">{{ $warisans->currentPage() }}</span>

            {{-- Next Page Link --}}
            @if ($warisans->hasMorePages())
                <a href="{{ $warisans->nextPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="page-btn" style="color: #ccc; cursor: not-allowed;"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Modal Dialog -->
<div class="modal-overlay" id="warisanModal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 id="modalTitle">TAMBAH DATA KOLEKSI</h4>
            <button class="btn-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <form id="warisanForm" action="{{ route('warisan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">NAMA KOLEKSI BUDAYA</label>
                        <input type="text" name="judul" id="inputJudul" class="form-control" placeholder="mis. Uis Nipes" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">JENIS KOLEKSI</label>
                            <select name="kategori_id" id="inputKategori" class="form-control" required>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->kategori_id }}">{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">NAMA PEMILIK/PENITIP</label>
                        <input type="text" name="nama_pemilik" id="inputNamaPemilik" class="form-control" placeholder="Contoh: Bpk. Tarigan">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">ASAL DAERAH / SUKU</label>
                        <input type="text" name="asal" id="inputAsal" class="form-control" placeholder="mis. Suku Karo">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">KEBERADAAN</label>
                        <input type="text" name="lokasi" id="inputLokasi" class="form-control" placeholder="mis. Kabanjahe, Tanah Karo" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">STATUS PUBLIKASI</label>
                        <select name="status" id="inputStatus" class="form-control" required>
                            <option value="aktif">Publik</option>
                            <option value="nonaktif">Draf</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">KONDISI KELESTARIAN</label>
                        <select name="kondisi" id="inputKondisi" class="form-control">
                            <option value="">Pilih Kondisi</option>
                            <option value="Dilestarikan">Dilestarikan</option>
                            <option value="Terancam">Terancam</option>
                            <option value="Punah">Punah</option>
                            <option value="Rusak">Rusak</option>
                            <option value="Baik">Baik</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label">TITIK KOORDINAT PETA (Latitude & Longitude)</label>
                    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                        <button type="button" class="btn-outline" onclick="searchLocation()" style="font-size: 12px; padding: 8px 12px;"><i class="fa-solid fa-magnifying-glass-location"></i> Cari Asal di Peta</button>
                        <span id="mapStatus" style="font-size: 12px; color: var(--text-gray); align-self: center;">Anda bisa geser pin merah pada peta untuk koordinat yang lebih akurat.</span>
                    </div>
                    <div id="mapForm" style="height: 250px; width: 100%; border-radius: 12px; border: 1px solid rgba(216, 224, 235, 0.95); z-index: 1;"></div>
                    <input type="hidden" name="latitude" id="inputLatitude">
                    <input type="hidden" name="longitude" id="inputLongitude">
                </div>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label">DESKRIPSI UMUM</label>
                    <textarea name="deskripsi" id="inputDeskripsi" class="form-control" style="height: 120px; resize: vertical;" placeholder="Tuliskan gambaran umum koleksi budaya ini..." required></textarea>
                </div>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label">SEJARAH & MAKNA FILOSOFIS (Opsional)</label>
                    <textarea name="sejarah" id="inputSejarah" class="form-control" style="height: 120px; resize: vertical;" placeholder="Tuliskan sejarah, asal usul, atau makna filosofis dari koleksi budaya ini..."></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">FOTO / GAMBAR</label>
                    <div class="upload-area">
                        <i class="fa-solid fa-arrow-up-from-bracket upload-icon"></i>
                        <div class="upload-text">Seret file ke sini atau klik untuk unggah</div>
                        <div class="upload-subtext">Format JPG/PNG, maksimal 5MB</div>
                        <input type="file" name="gambar" id="inputGambar" class="upload-input" accept="image/png, image/jpeg, image/jpg" onchange="previewFileName(this)">
                        <div id="fileNameDisplay" style="margin-top: 10px; font-weight: 600; color: #1f2937;"></div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-save">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    let map, marker;
    function initMap() {
        if (map) return;
        map = L.map('mapForm').setView([3.194752, 98.508299], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
        marker = L.marker([3.194752, 98.508299], { draggable: true }).addTo(map);
        
        marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            document.getElementById('inputLatitude').value = position.lat;
            document.getElementById('inputLongitude').value = position.lng;
            document.getElementById('mapStatus').innerText = "Koordinat diperbarui secara manual.";
        });

        // Isi nilai awal agar form selalu mengirim koordinat saat disimpan.
        var initialPosition = marker.getLatLng();
        document.getElementById('inputLatitude').value = initialPosition.lat;
        document.getElementById('inputLongitude').value = initialPosition.lng;

        const form = document.getElementById('warisanForm');
        if (form) {
            form.addEventListener('submit', function () {
                if (!document.getElementById('inputLatitude').value && !document.getElementById('inputLongitude').value) {
                    const position = marker.getLatLng();
                    document.getElementById('inputLatitude').value = position.lat;
                    document.getElementById('inputLongitude').value = position.lng;
                }
            });
        }
    }

    function searchLocation() {
        if (!map) {
            initMap();
        }
        const asal = document.getElementById('inputAsal').value.trim();
        const status = document.getElementById('mapStatus');
        if (!asal) {
            status.innerText = "Ketikkan asal daerah terlebih dahulu.";
            return;
        }
        status.innerText = "Mencari lokasi berdasarkan asal daerah...";

        const queries = [
            `${asal}, Kabupaten Karo, Sumatera Utara, Indonesia`,
            `${asal}, Sumatera Utara, Indonesia`,
            `${asal}, Indonesia`,
            asal
        ];

        const trySearch = (index = 0) => {
            if (index >= queries.length) {
                status.innerHTML = `<span style="color: #dc2626;"><i class="fa-solid fa-circle-xmark"></i> Lokasi tidak ditemukan. Coba ketik lebih spesifik (misal: nama desa atau kecamatan).</span>`;
                return;
            }

            fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=5&addressdetails=1&accept-language=id&q=${encodeURIComponent(queries[index])}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const best = data.find(item => item.display_name && item.display_name.toLowerCase().includes('karo')) || data[0];
                        const lat = parseFloat(best.lat);
                        const lon = parseFloat(best.lon);
                        map.setView([lat, lon], 14);
                        marker.setLatLng([lat, lon]);
                        document.getElementById('inputLatitude').value = lat;
                        document.getElementById('inputLongitude').value = lon;
                        status.innerHTML = `<span style="color: #16a34a;"><i class="fa-solid fa-circle-check"></i> Lokasi ditemukan: ${best.display_name}</span>`;
                    } else {
                        trySearch(index + 1);
                    }
                })
                .catch(() => {
                    status.innerText = "Terjadi kesalahan koneksi saat mencari.";
                });
        };

        trySearch();
    }

    function openModal(mode, data = null) {
        const modal = document.getElementById('warisanModal');
        const form = document.getElementById('warisanForm');
        const title = document.getElementById('modalTitle');
        const method = document.getElementById('formMethod');
        
        // Reset form
        form.reset();
        document.getElementById('fileNameDisplay').textContent = '';
        document.getElementById('inputStatus').value = 'aktif';
        document.getElementById('inputKondisi').value = '';
        document.getElementById('inputNamaPemilik').value = '';
        document.getElementById('inputLatitude').value = '';
        document.getElementById('inputLongitude').value = '';
        document.getElementById('mapStatus').innerText = 'Anda bisa geser pin merah pada peta untuk koordinat yang lebih akurat.';
        
        if (mode === 'add') {
            title.textContent = 'TAMBAH DATA KOLEKSI';
            form.action = '{{ route("warisan.store") }}';
            method.value = 'POST';
            document.getElementById('inputGambar').required = true;
        } else if (mode === 'edit') {
            title.textContent = 'UBAH DATA KOLEKSI';
            form.action = '/warisan/' + data.warisan_budaya_id;
            method.value = 'PUT';
            document.getElementById('inputGambar').required = false;
            
            // Populate data
            document.getElementById('inputJudul').value = data.judul;
            document.getElementById('inputKategori').value = data.kategori_id;
            document.getElementById('inputLokasi').value = data.lokasi || '';
            document.getElementById('inputAsal').value = data.asal || '';
            document.getElementById('inputStatus').value = data.status || 'aktif';
            document.getElementById('inputKondisi').value = data.kondisi || '';
            document.getElementById('inputNamaPemilik').value = data.nama_pemilik || '';
            document.getElementById('inputDeskripsi').value = data.deskripsi || '';
            document.getElementById('inputSejarah').value = data.sejarah || '';
        }
        
        modal.classList.add('active');
        
        setTimeout(() => {
            initMap();
            map.invalidateSize();
            if (mode === 'edit' && data.latitude && data.longitude) {
                map.setView([data.latitude, data.longitude], 14);
                marker.setLatLng([data.latitude, data.longitude]);
                document.getElementById('inputLatitude').value = data.latitude;
                document.getElementById('inputLongitude').value = data.longitude;
            } else if (mode === 'add') {
                map.setView([3.194752, 98.508299], 12);
                marker.setLatLng([3.194752, 98.508299]);
            }
        }, 150);
    }
    
    function closeModal() {
        document.getElementById('warisanModal').classList.remove('active');
    }
    
    function previewFileName(input) {
        const display = document.getElementById('fileNameDisplay');
        if (input.files && input.files[0]) {
            display.textContent = "File terpilih: " + input.files[0].name;
        } else {
            display.textContent = "";
        }
    }
    
    // Check if there are validation errors, if so, reopen modal
    @if($errors->any())
        document.addEventListener("DOMContentLoaded", function() {
            openModal('add'); // Reopen to show errors
        });
    @endif
</script>
@endpush
