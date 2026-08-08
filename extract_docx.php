<?php
$file = 'Induk Inventaris benda MPK 2026.docx';

$zip = new ZipArchive;
if ($zip->open($file) === TRUE) {
    $xml = $zip->getFromName('word/document.xml');
    $zip->close();
    
    // Strip XML tags to get raw text
    $text = strip_tags(str_replace('<w:p', "\n<w:p", $xml));
    $text = preg_replace('/\s+/', ' ', $text);
    
    file_put_contents('extracted.txt', $text);
    echo "Extracted successfully";
} else {
    echo "Failed to open docx";
}
