import re
from collections import Counter
import json

with open('extracted.txt', 'r', encoding='utf-8') as f:
    text = f.read()

# The records seem to start with a pattern like \d{2}\.\d{2}\.\d+ 
# e.g., 11.02.01, 15.06.132, etc.
# But some might be slightly malformed. Let's find all matches.
pattern = r'(\d{2}\.\d{2}\.\d+)\s+([\s\S]*?)(?=\d{2}\.\d{2}\.\d+\s+|$)'

matches = re.findall(pattern, text)

categories = []
methods = []
years = []
donors = []

for match in matches:
    nomor = match[0]
    content = match[1].strip()
    
    # We can't perfectly parse everything without delimiters, but we can look for known keywords
    # Cara perolehan is usually 'Hibah' or 'Dititipkan' or 'Inventaris'
    if 'Hibah' in content:
        methods.append('Hibah')
    elif 'Dititipkan' in content or 'Titipan' in content:
        methods.append('Dititipkan')
    elif 'Inventaris' in content:
        methods.append('Inventaris')
    else:
        methods.append('Unknown')
        
    # Jenis koleksi: Numismatika/Heraldika, Alat Pertanian, Alat Rumah Tangga, Alat memakan sirih, Seni Rupa/ Kriya, Alat Musik, dll.
    cat = 'Unknown'
    if 'Alat Pertanian' in content: cat = 'Alat Pertanian'
    elif 'Alat Rumah Tangga' in content or 'Alat rumah tangga' in content: cat = 'Alat Rumah Tangga'
    elif 'Alat memakan sirih' in content or 'Alat memakan Sirih' in content: cat = 'Alat Memakan Sirih'
    elif 'Numismatika/Heraldika' in content: cat = 'Numismatika/Heraldika'
    elif 'Seni Rupa/ Kriya' in content or 'Seni Rupa/Kriya' in content: cat = 'Seni Rupa/Kriya'
    elif 'Pisau' in content or 'Senjata' in content: cat = 'Senjata/Pisau'
    elif 'Alat Musik' in content: cat = 'Alat Musik'
    elif 'Patung/Gana-gana' in content or 'Gana-gana/patung' in content: cat = 'Patung/Gana-Gana'
    elif 'Perhiasan' in content: cat = 'Perhiasan'
    elif 'Alat Pertukangan' in content: cat = 'Alat Pertukangan'
    elif 'Alat Berburu' in content: cat = 'Alat Berburu'
    elif 'Tongkat' in content: cat = 'Tongkat'
    elif 'Dokumentasi' in content: cat = 'Dokumentasi'
    
    categories.append(cat)
    
    # Find year (4 digits starting with 19 or 20)
    year_match = re.search(r'\b(19\d{2}|20\d{2})\b', content)
    if year_match:
        years.append(year_match.group(1))

# Summary
summary = {
    'total_items': len(matches),
    'methods': dict(Counter(methods)),
    'categories': dict(Counter(categories)),
    'years': dict(Counter(years)),
}

print(json.dumps(summary, indent=2))
