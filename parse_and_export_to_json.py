import re
import json
import logging

logging.basicConfig(level=logging.INFO)

with open('extracted.txt', 'r', encoding='utf-8') as f:
    text = f.read()

pattern = r'(\d{2}\.\d{2}\.\d+)\s+([\s\S]*?)(?=\d{2}\.\d{2}\.\d+\s+|$)'
matches = re.findall(pattern, text)

# Known lists to help parsing
known_jenis = [
    'Numismatika/Heraldika', 'Numismatika', 'Heraldika', 
    'Alat Pertanian', 'Alat pertanian', 
    'Alat Rumah Tangga', 'Alat rumah tangga',
    'Alat Memakan Sirih', 'Alat memakan Sirih', 'Alat memakan sirih',
    'Seni Rupa/ Kriya', 'Seni Rupa/Kriya', 'Seni Rupa / Kriya', 'Seni Rupa', 'Kriya',
    'Alat Musik', 'Patung/Gana-gana', 'Gana-gana/patung', 'Patung / Gana-gana', 'Patung', 'Gana-gana',
    'Perhiasan', 'Alat Pertukangan', 'Alat pertukangan', 'Alat Berburu', 'Alat berburu',
    'Tongkat', 'Dokumentasi', 'Pisau - Senjata', 'Pisau – Senjata', 'Senjata', 'Pisau'
]

known_cara = ['Hibah', 'Dititipkan', 'Titipan', 'Inventaris']

records = []

for idx, match in enumerate(matches):
    nomor = match[0]
    content = match[1].strip()
    
    # 1. Find Cara Perolehan
    cara_perolehan = ""
    cara_idx = -1
    for cara in known_cara:
        idx_cara = content.find(cara)
        if idx_cara != -1:
            cara_perolehan = cara
            cara_idx = idx_cara
            break
            
    # 2. Find Jenis Koleksi
    jenis_koleksi = ""
    jenis_idx = -1
    for jenis in known_jenis:
        idx_j = content.find(jenis)
        if idx_j != -1:
            jenis_koleksi = jenis
            jenis_idx = idx_j
            break
            
    nama_koleksi = ""
    nama_pemilik = ""
    tempat_perolehan = ""
    tanggal_masuk = ""
    keterangan = ""
    
    if jenis_idx != -1 and cara_idx != -1 and jenis_idx < cara_idx:
        nama_koleksi = content[:jenis_idx].strip()
        nama_pemilik = content[jenis_idx + len(jenis_koleksi):cara_idx].strip()
        
        rest = content[cara_idx + len(cara_perolehan):].strip()
        
        # Try to find a date in rest
        date_pattern = r'\b(\d{1,2}[-/]\d{1,2}[-/]\d{2,4}|\d{1,2}\s+[a-zA-Z]+\s+\d{4}|\d{4})\b'
        date_match = re.search(date_pattern, rest)
        if date_match:
            tanggal_masuk = date_match.group(1)
            date_start = date_match.start()
            date_end = date_match.end()
            
            tempat_perolehan = rest[:date_start].strip()
            keterangan = rest[date_end:].strip()
        else:
            tempat_perolehan = rest
            keterangan = ""
            
    elif jenis_idx != -1 and cara_idx == -1:
        nama_koleksi = content[:jenis_idx].strip()
        rest = content[jenis_idx + len(jenis_koleksi):].strip()
        nama_pemilik = rest
        keterangan = ""
        
    else:
        # Fallback if parsing failed
        nama_koleksi = content
        
    records.append({
        'nomor_koleksi': nomor,
        'nama_koleksi': nama_koleksi if nama_koleksi else "-",
        'jenis_koleksi': jenis_koleksi if jenis_koleksi else "Lainnya",
        'nama_pemilik': nama_pemilik if nama_pemilik else "-",
        'cara_perolehan': cara_perolehan if cara_perolehan else "-",
        'tempat_perolehan': tempat_perolehan if tempat_perolehan else "-",
        'tanggal_masuk': tanggal_masuk if tanggal_masuk else "-",
        'keterangan': keterangan if keterangan else "-"
    })

with open('koleksi_data.json', 'w', encoding='utf-8') as f:
    json.dump(records, f, indent=2, ensure_ascii=False)

logging.info(f"Processed {len(records)} records. Saved to koleksi_data.json.")
