@extends('layouts.public')

@section('title', 'Tentang Kami')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    :root {
        --primary-red: #7a1b1b;
        --dark-red: #4a0f0f;
        --gold: #c9a84c;
        --cream: #f8f4ed;
        --text-dark: #1a1a2e;
        --text-gray: #43536a;
    }

    .tentang-hero {
        background: linear-gradient(135deg, var(--dark-red) 0%, var(--primary-red) 100%);
        padding: 70px 5% 90px;
        color: white;
        text-align: center;
    }
    .tentang-hero .badge-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--gold);
        margin-bottom: 15px;
    }
    .tentang-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        margin-bottom: 15px;
    }
    .tentang-hero p {
        max-width: 640px;
        margin: 0 auto;
        opacity: 0.9;
        line-height: 1.7;
        font-size: 15px;
    }

    .tentang-container {
        max-width: 1100px;
        margin: -50px auto 0;
        padding: 0 5% 80px;
        position: relative;
        z-index: 2;
    }

    .profil-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 45px;
        margin-bottom: 40px;
    }
    .profil-card h2 {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        color: var(--text-dark);
        margin-bottom: 18px;
    }
    .profil-card p {
        color: var(--text-gray);
        line-height: 1.8;
        font-size: 14.5px;
        margin-bottom: 14px;
        text-align: justify;
        text-justify: inter-word;
    }

    .profil-section h3 {
        text-align: center;
        font-size: 22px;
        color: var(--primary-red);
        margin-top: 28px;
        margin-bottom: 30px;
        font-family: 'Playfair Display', serif;
        position: relative;
    }

    .profil-section h3::after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background: var(--gold);
        margin: 10px auto 0;
        border-radius: 2px;
    }

    .visi-misi-container {
        max-width: 850px;
        margin: 0 auto 20px;
    }

    .visi-box,
    .misi-box,
    .nilai-box {
        background: #f8f4ed;
        border: 1px solid rgba(122, 27, 27, 0.08);
        border-radius: 16px;
        padding: 30px 35px;
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .visi-box:hover,
    .misi-box:hover,
    .nilai-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.08);
    }

    .visi-icon,
    .misi-icon,
    .nilai-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--primary-red);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin: 0 auto 16px;
    }

    .visi-box h4,
    .misi-box h4,
    .nilai-box h4 {
        font-size: 18px;
        color: var(--primary-red);
        margin-bottom: 14px;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
    }

    .visi-box p,
    .nilai-box p {
        font-size: 15px;
        color: var(--text-gray);
        line-height: 1.8;
        margin-bottom: 0;
        text-align: center;
    }

    .misi-list-center {
        list-style: none;
        padding: 0;
        margin: 0;
        text-align: left;
        max-width: 700px;
        margin: 0 auto;
    }

    .misi-list-center li {
        font-size: 14.5px;
        color: var(--text-gray);
        line-height: 1.8;
        padding: 8px 0 8px 38px;
        position: relative;
        text-align: left;
        border-bottom: 1px dashed rgba(122, 27, 27, 0.06);
    }

    .misi-list-center li:last-child {
        border-bottom: none;
    }

    .misi-list-center li::before {
        content: counter(item) ".";
        counter-increment: item;
        position: absolute;
        left: 0;
        top: 8px;
        width: 28px;
        height: 28px;
        background: var(--primary-red);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
    }

    .misi-list-center {
        counter-reset: item;
    }

    .stats-row {
        display: flex;
        gap: 20px;
        margin-top: 25px;
        flex-wrap: wrap;
    }
    .stat-box {
        flex: 1;
        min-width: 140px;
        background: var(--cream);
        border: 1px solid #eee0c8;
        border-radius: 6px;
        padding: 20px;
        text-align: center;
    }
    .stat-box .num {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        color: var(--primary-red);
        font-weight: 700;
    }
    .stat-box .label {
        font-size: 12px;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 5px;
    }

    .story-section {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        padding: 40px 45px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        margin-bottom: 40px;
    }

    .story-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .story-section p {
        color: var(--text-gray);
        line-height: 1.8;
        font-size: 14.5px;
        margin-bottom: 16px;
        text-align: justify;
    }

    .story-section .highlight-text {
        background: linear-gradient(135deg, rgba(122, 27, 27, 0.05), rgba(236, 139, 95, 0.05));
        border-left: 4px solid var(--primary-red);
        padding: 16px 20px;
        border-radius: 0 8px 8px 0;
        margin: 20px 0;
        font-style: italic;
    }

    .story-section .highlight-text strong {
        color: var(--primary-red);
    }

    .story-grid {
        display: grid;
        gap: 20px;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        margin-top: 30px;
    }

    .story-card {
        background: #f8f4ed;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid rgba(122, 27, 27, 0.08);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .story-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 28px rgba(15, 23, 42, 0.08);
    }

    .story-number {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--primary-red);
        color: white;
        font-weight: 700;
        margin-bottom: 16px;
        font-size: 14px;
    }

    .story-card h4 {
        font-size: 16px;
        margin-bottom: 12px;
        color: var(--text-dark);
    }

    .story-card p {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.75;
        margin-bottom: 0;
        text-align: left;
    }

    .story-highlight {
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(122, 27, 27, 0.08), rgba(236, 139, 95, 0.08));
        border: 1px solid rgba(236, 139, 95, 0.15);
        padding: 32px;
        display: grid;
        gap: 16px;
        margin-top: 30px;
    }

    .story-highlight h3 {
        font-size: 20px;
        margin-bottom: 12px;
        color: var(--primary-red);
    }

    .story-highlight p {
        margin-bottom: 0;
        font-size: 15px;
        line-height: 1.8;
    }

    .koleksi-list {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 8px 24px;
        list-style: none;
        padding: 0;
        margin: 16px 0 0;
    }
    .koleksi-list li {
        font-size: 13.5px;
        color: var(--text-gray);
        line-height: 1.8;
        padding-left: 18px;
        position: relative;
    }
    .koleksi-list li::before {
        content: "›";
        position: absolute;
        left: 0;
        color: var(--primary-red);
        font-weight: 700;
        font-size: 18px;
    }

    @media (max-width: 768px) {
        .koleksi-list {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 480px) {
        .koleksi-list {
            grid-template-columns: 1fr;
        }
    }

    .feature-section,
    .timeline-section,
    .faq-section {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        padding: 40px 45px;
        margin-bottom: 45px;
    }

    .feature-section h2,
    .timeline-section h2,
    .faq-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: var(--text-dark);
        margin-bottom: 18px;
    }

    .feature-grid,
    .timeline-grid {
        display: grid;
        gap: 20px;
    }

    .feature-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .feature-box,
    .timeline-card,
    .faq-card {
        background: #f8f4ed;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid rgba(122, 27, 27, 0.08);
    }

    .feature-box h4,
    .timeline-card h4,
    .faq-card h4 {
        font-size: 17px;
        margin-bottom: 12px;
        color: var(--text-dark);
    }

    .feature-box p,
    .timeline-card p,
    .faq-card p {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.75;
        margin-bottom: 0;
    }

    .timeline-card {
        display: grid;
        gap: 16px;
    }

    .timeline-label {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--primary-red);
        font-weight: 700;
    }

    .faq-grid {
        display: grid;
        gap: 20px;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .faq-card h4 {
        font-size: 16px;
    }

    .program-section,
    .location-section {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        padding: 40px 45px;
        margin-bottom: 45px;
    }

    .program-section h2,
    .location-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: var(--text-dark);
        margin-bottom: 18px;
    }

    .program-grid {
        display: grid;
        gap: 20px;
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .program-card {
        background: #f8f4ed;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid rgba(122, 27, 27, 0.08);
    }

    .program-card h4 {
        font-size: 17px;
        margin-bottom: 12px;
        color: var(--text-dark);
    }

    .program-card p {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.75;
        margin-bottom: 0;
    }

    /* ===== VISIT SECTION - RENCANAKAN KUNJUNGAN ===== */
    .visit-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 45px;
        align-items: stretch;
    }

    .visit-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        padding: 40px 35px;
        box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .visit-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 24px 48px rgba(15, 23, 42, 0.1);
    }

    .visit-card .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: rgba(122, 27, 27, 0.08);
        color: var(--primary-red);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 18px;
    }

    .visit-card h3 {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        color: var(--text-dark);
        margin-bottom: 12px;
    }

    .visit-card p {
        color: var(--text-gray);
        line-height: 1.8;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .visit-card .visit-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        gap: 12px;
    }

    .visit-card .visit-list li {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 10px 14px;
        background: #f8f4ed;
        border-radius: 10px;
        border: 1px solid rgba(122, 27, 27, 0.05);
        transition: background 0.2s;
    }

    .visit-card .visit-list li:hover {
        background: #f0ebe3;
    }

    .visit-card .visit-list li i {
        color: var(--primary-red);
        font-size: 16px;
        min-width: 20px;
        text-align: center;
    }

    .visit-card .visit-list li span {
        color: var(--text-dark);
        font-size: 14px;
        line-height: 1.5;
    }

    .visit-card .visit-list li .label {
        color: var(--text-gray);
        font-weight: 500;
        min-width: 80px;
    }

    .visit-card .visit-list li .value {
        color: var(--text-dark);
        font-weight: 500;
    }

    .visit-card .visit-list li .value.closed {
        color: #c62828;
    }

    .visit-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 28px;
        border-radius: 999px;
        background: var(--primary-red);
        color: white;
        font-weight: 600;
        border: none;
        text-decoration: none;
        transition: all 0.3s;
        margin-top: 20px;
        font-size: 14px;
    }

    .visit-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(122, 27, 27, 0.25);
        color: white;
    }

    /* ===== LOCATION SECTION ===== */
    .location-card {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 30px;
        align-items: stretch;
    }

    .location-info {
        display: grid;
        gap: 16px;
    }

    .location-info p {
        color: var(--text-gray);
        line-height: 1.8;
        font-size: 14px;
        margin-bottom: 0;
    }

    .location-info ul {
        padding: 0;
        margin: 0;
        list-style: none;
        display: grid;
        gap: 10px;
    }

    .location-info ul li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 14px;
        background: #f8f4ed;
        border-radius: 10px;
        border: 1px solid rgba(122, 27, 27, 0.05);
        transition: background 0.2s;
        font-size: 14px;
        color: var(--text-gray);
        line-height: 1.6;
    }

    .location-info ul li:hover {
        background: #f0ebe3;
    }

    .location-info ul li i {
        color: var(--primary-red);
        min-width: 18px;
        margin-top: 2px;
        font-size: 15px;
    }

    .location-map {
        min-height: 320px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        border: 1px solid rgba(15, 23, 42, 0.06);
        position: relative;
    }

    .location-map #locationMap {
        width: 100%;
        height: 100%;
        min-height: 320px;
    }

    /* ===== PILAR SECTION ===== */
    .pilar-section {
        margin-bottom: 45px;
    }

    .pilar-section .section-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .pilar-section .section-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .pilar-section .section-header p {
        color: var(--text-gray);
        max-width: 560px;
        margin: 0 auto;
        font-size: 14px;
        line-height: 1.8;
    }

    .pilar-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .pilar-card {
        background: #fff;
        border: 1px solid rgba(15, 23, 42, 0.06);
        border-radius: 16px;
        padding: 35px 28px;
        text-align: center;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }

    .pilar-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        border-color: var(--primary-red);
    }

    .pilar-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--primary-red);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin: 0 auto 18px;
        transition: transform 0.3s;
    }

    .pilar-card:hover .pilar-icon {
        transform: scale(1.05);
    }

    .pilar-card h3 {
        font-size: 17px;
        color: var(--text-dark);
        margin-bottom: 10px;
        font-weight: 700;
    }

    .pilar-card p {
        font-size: 13.5px;
        color: var(--text-gray);
        line-height: 1.8;
        margin-bottom: 0;
    }

    /* ===== KONTAK CARD ===== */
    .kontak-card {
        background: var(--dark-red);
        border-radius: 16px;
        padding: 40px 45px;
        color: white;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin-top: 10px;
    }

    .kontak-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .kontak-item i {
        color: var(--gold);
        font-size: 20px;
        margin-bottom: 2px;
    }

    .kontak-item .k-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255,255,255,0.5);
        font-weight: 600;
    }

    .kontak-item .k-value {
        font-size: 14px;
        line-height: 1.6;
        color: rgba(255,255,255,0.9);
    }

    .kontak-item .k-value .today-hours {
        color: var(--gold);
        font-weight: 600;
    }

    .kontak-item .k-value .hours-detail {
        font-size: 12px;
        opacity: 0.7;
        display: block;
        margin-top: 4px;
        line-height: 1.8;
    }

    /* ===== SARAN SECTION ===== */
    .saran-section {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        padding: 40px 45px;
        margin-top: 45px;
    }

    .saran-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: var(--text-dark);
        margin-bottom: 15px;
    }

    .saran-section p {
        color: var(--text-gray);
        font-size: 14.5px;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .saran-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .saran-form .full-width {
        grid-column: 1 / -1;
    }

    .saran-form label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .saran-form input,
    .saran-form textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-family: 'Inter', sans-serif;
        font-size: 14.5px;
        outline: none;
        transition: border-color 0.2s;
    }

    .saran-form input:focus,
    .saran-form textarea:focus {
        border-color: var(--primary-red);
    }

    .btn-submit-saran {
        background-color: var(--primary-red);
        color: white;
        border: none;
        padding: 14px 30px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        font-size: 14.5px;
        transition: background-color 0.2s, transform 0.2s;
        display: inline-block;
        margin-top: 10px;
    }

    .btn-submit-saran:hover {
        background-color: var(--dark-red);
        transform: translateY(-2px);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 980px) {
        .visit-section {
            grid-template-columns: 1fr;
        }
        .location-card {
            grid-template-columns: 1fr;
        }
        .pilar-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .kontak-card {
            grid-template-columns: repeat(2, 1fr);
        }
        .feature-grid,
        .faq-grid,
        .timeline-grid {
            grid-template-columns: 1fr;
        }
        .saran-form {
            grid-template-columns: 1fr;
        }
    }
        .program-grid {
            grid-template-columns: 1fr;
        }
        .story-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .profil-card {
            padding: 24px;
        }
        .story-section,
        .feature-section,
        .timeline-section,
        .faq-section,
        .program-section,
        .location-section {
            padding: 24px;
        }
        .visit-card {
            padding: 28px 20px;
        }
        .kontak-card {
            padding: 24px;
            gap: 20px;
        }
        .visi-box,
        .misi-box,
        .nilai-box {
            padding: 24px 20px;
        }
        .visi-misi-container {
            padding: 0;
        }
    }

    @media (max-width: 600px) {
        .pilar-grid {
            grid-template-columns: 1fr;
        }
        .kontak-card {
            grid-template-columns: 1fr;
        }
        .visit-card .visit-list li {
            flex-wrap: wrap;
        }
        .visit-card .visit-list li .label {
            min-width: 60px;
            font-size: 13px;
        }
        .visit-card .visit-list li .value {
            font-size: 13px;
        }
        .location-info ul li {
            font-size: 13px;
        }
        .profil-card {
            padding: 16px;
        }
        .story-section,
        .feature-section,
        .timeline-section,
        .faq-section,
        .program-section,
        .location-section {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')

@php
// Data jam operasional
$operationalHours = [
    'senin' => ['day' => 'Senin', 'open' => null, 'close' => null, 'is_open' => false],
    'selasa' => ['day' => 'Selasa', 'open' => '10.00', 'close' => '17.00', 'is_open' => true],
    'rabu' => ['day' => 'Rabu', 'open' => '10.00', 'close' => '17.00', 'is_open' => true],
    'kamis' => ['day' => 'Kamis', 'open' => '10.00', 'close' => '17.00', 'is_open' => true],
    'jumat' => ['day' => 'Jumat', 'open' => '10.00', 'close' => '17.00', 'is_open' => true],
    'sabtu' => ['day' => 'Sabtu', 'open' => '10.00', 'close' => '17.00', 'is_open' => true],
    'minggu' => ['day' => 'Minggu', 'open' => '14.30', 'close' => '17.30', 'is_open' => true]
];

$dayMap = [
    'Monday' => 'senin',
    'Tuesday' => 'selasa',
    'Wednesday' => 'rabu',
    'Thursday' => 'kamis',
    'Friday' => 'jumat',
    'Saturday' => 'sabtu',
    'Sunday' => 'minggu'
];
$todayKey = $dayMap[date('l')] ?? 'senin';
@endphp

<div class="tentang-hero">
    <div class="badge-label">TENTANG KAMI</div>
    <h1>Museum Pusaka Karo</h1>
    <p>Lembaga pelestari budaya yang mengumpulkan, merawat, dan mendokumentasikan artefak serta pengetahuan tradisional masyarakat Karo melalui sistem informasi digital.</p>
</div>

<div class="tentang-container">

    <!-- ===== PROFIL MUSEUM ===== -->
    <div class="profil-card">
        <h2>Profil Museum</h2>
        <p>
            Museum Pusaka Karo hadir sebagai ruang pelestarian warisan budaya masyarakat Karo,
            mulai dari arsitektur rumah adat, kain tradisional, alat musik, hingga tradisi dan
            kearifan lokal yang diwariskan turun-temurun. Melalui Sistem Informasi Warisan Budaya
            Karo, seluruh koleksi dan dokumentasi budaya ini disajikan secara digital agar dapat
            diakses, dipelajari, dan dilestarikan oleh masyarakat luas maupun generasi muda Karo.
        </p>
        <p>
            Sistem ini dikembangkan untuk mendukung tugas kurator dalam mendokumentasikan warisan
            budaya, sekaligus menjadi jembatan informasi antara Museum Pusaka Karo dengan
            masyarakat, peneliti, dan wisatawan yang ingin mengenal lebih dekat kebudayaan Karo.
        </p>

        <div class="profil-section">
            <h3>Visi & Misi</h3>
            
            <div class="visi-misi-container">
                <div class="visi-box">
                    <div class="visi-icon"><i class="fa-solid fa-eye"></i></div>
                    <h4>Visi</h4>
                    <p>Mewujudkan pembangunan manusia yang berbudaya serta menciptakan rasa kepedulian akan Sejarah dan kebudayaan tanah air NKRI melalui pengelolaan cagar budaya Karo dan museum yang efektif, tangkas dan profesional.</p>
                </div>
            </div>

            <div class="visi-misi-container">
                <div class="misi-box">
                    <div class="misi-icon"><i class="fa-solid fa-bullseye"></i></div>
                    <h4>Misi</h4>
                    <ol class="misi-list-center">
                        <li>Wadah perhimpunan cagar budaya Karo dalam edukasi dan rekreasi Sejarah.</li>
                        <li>Merawat dan menjaga warisan budaya Karo dengan tata kelola yang berkelanjutan.</li>
                        <li>Pengelolaan cagar budaya Karo dan museum yang meningkatkan kesejahteraan umum.</li>
                        <li>Pemberdayaan cagar budaya Karo dan museum yang efektif dalam pelayanan kepada masyarakat umum.</li>
                        <li>Mewujudkan pembangunan manusia yang berbudaya yang menciptakan rasa kepedulian akan Sejarah dan kebudayaan tanah air NKRI.</li>
                    </ol>
                </div>
            </div>

            <div class="visi-misi-container" style="margin-top: 20px;">
                <div class="nilai-box">
                    <div class="nilai-icon"><i class="fa-solid fa-gem"></i></div>
                    <h4>Nilai</h4>
                    <p>Asli, terjaga, akuntabel, dan edukatif — sebagai pijakan dalam setiap aktivitas pelestarian budaya.</p>
                </div>
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-box">
                <div class="num">{{ $totalWarisan ?? 0 }}</div>
                <div class="label">Warisan Budaya</div>
            </div>
            <div class="stat-box">
                <div class="num">{{ $totalKategori ?? 0 }}</div>
                <div class="label">Jenis Koleksi</div>
            </div>
        </div>
    </div>

    <!-- ===== SEJARAH ===== -->
    <div class="story-section">
        <h2>Sejarah Singkat Museum</h2>
        
        <p>
            Museum Pusaka Karo merupakan museum umum dengan koleksi benda-benda warisan budaya asli dari masyarakat Karo yang didapatkan secara hibah ataupun yang dititipkan oleh masyarakat Karo itu sendiri. Museum ini diprakarsai oleh seorang misionaris Katolik asal negeri Belanda bernama <strong>Leonardus Edigius Joosten</strong> atau mais h dikenal dengan sebutan <strong>Pastor Leo</strong>. Museum ini diresmikan oleh Dirjen Pariwisata dan Ekonomi Dr. Ahman Sya dan Mgr. Anicetus B. Sinaga OFMCap.
        </p>
        
        <p>
            Pada pertengahan tahun 2009 muncul suatu gagasan dari Pastor Leo bersama para sahabat dan simpatisan beliau yang berada di Tanah Karo untuk berbagi suatu <em>"kegelisahan"</em> dan <em>"kekhawatiran"</em>. Beliau merasa cemas apabila suatu hari orang Karo sendiri tidak lagi memiliki rasa peduli dan kecintaan terhadap budayanya sendiri. Akhirnya beliau berinisiatif dengan menghimbau teman-teman sejarawan dan tokoh-tokoh adat agar pendirian Museum budaya dan sejarah khusus Karo segera terealisasikan.
        </p>

        <div class="highlight-text">
            <p><strong>Pastor Leo</strong> bersama tim perintis begitu bersemangat dan optimis untuk pembangunan Museum ini. Secara perlahan koleksi perdana mulai dikumpulkan dengan sosialisasi ke perkampungan di wilayah Kabupaten Karo sekitarnya. Selain itu tim perintis juga mengupayakan kerja sama dengan museum yang ada di negeri Belanda yaitu <strong>TropenMuseum di Amsterdam</strong> dalam hal perizinan mencetak dan mempublikasikan dokumentasi foto peradaban masyarakat Karo.</p>
        </div>

        <p>
            Pada awal pendirian museum, Pastor Leo memohon izin kepada Uskup Agung Medan Mgr. Pius Datubara OFMCap agar dapat memakai dan memanfaatkan gedung gereja Katolik St. Maria (Gedung Museum saat ini) di pusat kota Berastagi menjadi sebuah gedung Museum. Dengan modal awal dari komisi keuangan KAM dan para donatur museum yang cukup, maka pendirian museum pun akhirnya terealisasikan dengan nama <strong>MUSEUM PUSAKA KARO</strong> pada tanggal <strong>7 Juli 2011</strong>.
        </p>

        <p>
            Saat ini Museum Pusaka Karo dikelola oleh <strong>YAYASAN PUSAKA KARO</strong> sejak tahun 2017 yang diputuskan oleh Kemenkumham dengan nomor: <strong>AHU-0017524.AH.01.04 Tahun 2017</strong>.
        </p>

        <p>
            Hingga saat ini Museum Pusaka Karo menyimpan koleksi 1.000-an benda-benda bernilai sejarah yang terdiri dari jenis koleksi Etnografi, Geografi dan Sejarah. Mulai dari benda koleksi jenis:
        </p>

        <ul class="koleksi-list">
            <li>Peralatan Pertanian</li>
            <li>Peralatan Pertukangan</li>
            <li>Peralatan Rumah Tangga</li>
            <li>Peralatan Memakan Sirih</li>
            <li>Peralatan Upacara dan Ritual</li>
            <li>Peralatan Berburu dan Menangkap Ikan</li>
            <li>Permainan Tradisional</li>
            <li>Jenis-jenis Pisau dan Senjata</li>
            <li>Jenis-jenis Kain Tenun (Uis)</li>
            <li>Jenis-jenis Perhiasan</li>
            <li>Jenis-jenis Patung (Gana-gana)</li>
            <li>Jenis-jenis Alat Musik Tradisional Karo</li>
        </ul>

        <p style="margin-top: 20px;">
            Setidaknya sekitar <strong>65%</strong> dari koleksi museum ini adalah benda-benda yang dipinjamkan dari masyarakat Karo dan kolektor seperti <strong>Mehemoni Br Tarigan Silangit</strong> dari desa Sukajulu, Kec. Barus Jahe, Kabupaten Karo dan beberapa masyarakat Karo lainnya yang kami sebut sebagai <strong>PEMERHATI MUSEUM</strong>.
        </p>

        <div class="story-highlight">
            <h3>Prinsip Pastor Leo</h3>
            <p>"Museum ini milik kita bersama, kita yang memberi, kita yang menikmati." — Prinsip yang harus terus dikobarkan dari Pastor Leo semasa hidupnya.</p>
        </div>

        <p style="margin-top: 16px;">
            Museum Pusaka Karo ini sebagaimana dalam fungsi dan pengertian umum dari Museum, merupakan suatu badan yang bersifat bendawi, dan mengomunikasikannya kepada masyarakat umum. Museum ini berdiri semata-mata merupakan karya dan bakti orang Karo yang peduli akan budaya dan sejarah Karo, dengan keagungannya yang sarat nilai akan kebaikan dapat memberi sumbangsih pada pembangunan manusia Karo khususnya, bangsa Indonesia dan sekaligus peradaban dunia pada umumnya.
        </p>

        <div class="story-grid">
            <div class="story-card">
                <div class="story-number">2009</div>
                <h4>Gagasan Awal</h4>
                <p>Pastor Leo bersama sahabat dan tokoh adat menggagas pendirian museum khusus budaya dan sejarah Karo.</p>
            </div>
            <div class="story-card">
                <div class="story-number">2011</div>
                <h4>Peresmian</h4>
                <p>Museum resmi berdiri dan diresmikan di gedung eks Gereja St. Maria, Berastagi, pada 7 Juli 2011.</p>
            </div>
            <div class="story-card">
                <div class="story-number">2017</div>
                <h4>Pengelolaan Yayasan</h4>
                <p>Pengelolaan museum diserahkan kepada Yayasan Pusaka Karo berdasarkan keputusan Kemenkumham.</p>
            </div>
        </div>
    </div>

    <!-- ===== FITUR ===== -->
    <div class="feature-section">
        <h2>Apa yang Bisa Anda Temukan</h2>
        <div class="feature-grid">
            <div class="feature-box">
                <h4>Koleksi Artefak Lengkap</h4>
                <p>Ragam benda bersejarah, mulai dari pakaian adat hingga peralatan rumah tradisional, disajikan sebagai warisan hidup masyarakat Karo.</p>
            </div>
            <div class="feature-box">
                <h4>Informasi Interaktif</h4>
                <p>Setiap koleksi dilengkapi deskripsi dan latar belakang budaya sehingga pengunjung dapat memahami nilai historis dan maknanya.</p>
            </div>
            <div class="feature-box">
                <h4>Program Edukasi</h4>
                <p>Workshop, diskusi, dan kegiatan pembelajaran bagi pelajar dan komunitas untuk menjaga warisan Karo tetap relevan.</p>
            </div>
        </div>
    </div>

    <!-- ===== TIMELINE ===== -->
    <div class="timeline-section">
        <h2>Timeline Perjalanan Museum</h2>
        <div class="timeline-grid">
            <div class="timeline-card">
                <div class="timeline-label">2008</div>
                <h4>Awal Inspirasi</h4>
                <p>Konsep museum yang digagas oleh misionaris Katolik dari Belanda untuk pelestarian Budaya Karo .</p>
            </div>
            <div class="timeline-card">
                <div class="timeline-label">2010</div>
                <h4>Pengumpulan Koleksi</h4>
                <p>Mulai mengumpulkan artefak dan dokumentasi dari berbagai daerah untuk membangun koleksi representatif budaya Karo.</p>
            </div>
            <div class="timeline-card">
                <div class="timeline-label">2013</div>
                <h4>Pembukaan Publik</h4>
                <p>Museum resmi dibuka untuk umum, menawarkan ruang pameran dan informasi yang dapat dijangkau oleh masyarakat lokal dan wisatawan mancanegara.</p>
            </div>
            <div class="timeline-card">
                <div class="timeline-label">2026</div>
                <h4>Digitalisasi</h4>
                <p>Meluncurkan situs dan sistem informasi digital untuk memperluas akses ke koleksi dan informasi budaya secara online.</p>
            </div>
        </div>
    </div>

    <!-- ===== FAQ ===== -->
    <div class="faq-section">
        <h2>Pertanyaan Umum</h2>
        <div class="faq-grid">
            <div class="faq-card">
                <h4>Apa tujuan utama museum ini?</h4>
                <p>Menjaga, mendokumentasikan, dan menyebarkan pengetahuan tentang kebudayaan Karo agar generasi kini dan mendatang dapat mempelajari dan menghargainya.</p>
            </div>
            <div class="faq-card">
                <h4>Apakah ada tur edukasi?</h4>
                <p>Ya, museum menyediakan kegiatan edukatif dan kunjungan terarah bagi sekolah, komunitas, dan pengunjung umum.</p>
            </div>
            <div class="faq-card">
                <h4>Apakah koleksi dapat diakses secara online?</h4>
                <p>Informasi umum tentang koleksi tersedia di situs, sedangkan pameran dan katalog lengkap dapat dilihat pada halaman katalog.</p>
            </div>
            <div class="faq-card">
                <h4>Bagaimana cara mengunjungi museum?</h4>
                <p>Pengunjung dapat datang langsung pada jam operasional atau merencanakan kunjungan sebelumnya melalui informasi kontak yang tersedia.</p>
            </div>
        </div>
    </div>

    <!-- ===== RENCANAKAN KUNJUNGAN ===== -->
    <div class="visit-section">
        <div class="visit-card">
            <div class="card-icon"><i class="fa-solid fa-clock"></i></div>
            <h3>Jam Operasional</h3>
            <p>Bersiaplah untuk menjelajahi kebudayaan Karo secara lebih mendalam. Dapatkan informasi praktis dan rincian kunjungan yang memudahkan perjalanan Anda ke Museum Pusaka Karo.</p>
            <ul class="visit-list">
                @foreach($operationalHours as $schedule)
                    <li>
                        <i class="fa-solid {{ $schedule['is_open'] ? 'fa-circle-check' : 'fa-circle-xmark' }}" style="color: {{ $schedule['is_open'] ? '#2e7d32' : '#c62828' }};"></i>
                        <span>
                            <span class="label">{{ $schedule['day'] }}</span>
                            <span class="value {{ !$schedule['is_open'] ? 'closed' : '' }}">
                                {{ $schedule['is_open'] ? $schedule['open'] . ' - ' . $schedule['close'] : 'Tutup' }}
                            </span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="visit-card">
            <div class="card-icon"><i class="fa-solid fa-location-dot"></i></div>
            <h3>Informasi Lokasi</h3>
            <p>Museum Pusaka Karo terletak di pusat kota Berastagi, mudah dijangkau dan dekat dengan berbagai destinasi wisata.</p>
            <ul class="visit-list">
                <li>
                    <i class="fa-solid fa-map-pin"></i>
                    <span>
                        <span class="label">Alamat</span>
                        <span class="value">Jl. Perwira No. 3, Gundaling I, Berastagi</span>
                    </span>
                </li>
                <li>
                    <i class="fa-solid fa-phone"></i>
                    <span>
                        <span class="label">Telepon</span>
                        <span class="value">(0628) 9123456</span>
                    </span>
                </li>
                <li>
                    <i class="fa-solid fa-envelope"></i>
                    <span>
                        <span class="label">Email</span>
                        <span class="value">info@museumpusaka.karo.go.id</span>
                    </span>
                </li>
            </ul>
            <a href="{{ route('peta.persebaran') }}" class="visit-button">
                <i class="fa-solid fa-map-location-dot"></i>
                Lihat Peta Museum
            </a>
        </div>
    </div>

    <!-- ===== LOKASI MUSEUM ===== -->
    <div class="location-section">
        <h2>Lokasi Museum</h2>
        <div class="location-card">
            <div class="location-info">
                <p>Terletak di pusat kecamatan Berastagi, Museum Pusaka Karo mudah dijangkau dari pusat kota dan menawarkan akses langsung ke pengalaman budaya Karo yang otentik.</p>
                <ul>
                    <li><i class="fa-solid fa-map-pin"></i>Alamat lengkap: Jl. Perwira No. 3, Gundaling I, Berastagi</li>
                    <li><i class="fa-solid fa-location-dot"></i>Koordinat: 3.132200° N, 98.466500° E</li>
                    <li><i class="fa-solid fa-car"></i>Akses: Dekat dengan jalan utama dan jalur wisata menuju wisata PASAR BUNGA & BUAH serta Bukit Gundaling</li>
                    <li><i class="fa-solid fa-route"></i>Parkir: Tersedia area parkir tamu di sekitar museum</li>
                </ul>
            </div>
            <div class="location-map">
                <div id="locationMap"></div>
            </div>
        </div>
    </div>

    <!-- ===== TIGA PILAR UTAMA ===== -->
    <div class="pilar-section">
        <div class="section-header">
            <h2>Tiga Pilar Utama</h2>
            <p>Landasan kerja Museum Pusaka Karo dalam menjaga dan menghidupkan warisan budaya Karo.</p>
        </div>

        <div class="pilar-grid">
            <div class="pilar-card">
                <div class="pilar-icon"><i class="fa-solid fa-landmark"></i></div>
                <h3>Pelestarian</h3>
                <p>Pengembangan dan penjagaan nilai-nilai budaya Karo secara sistematis, agar warisan leluhur tetap terjaga keasliannya.</p>
            </div>
            <div class="pilar-card">
                <div class="pilar-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                <h3>Akuntabilitas</h3>
                <p>Penyajian informasi budaya yang berbasis kajian sejarah dan data yang dapat dipertanggungjawabkan.</p>
            </div>
            <div class="pilar-card">
                <div class="pilar-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                <h3>Edukasi</h3>
                <p>Menjadi sumber belajar bagi generasi muda Karo dan masyarakat umum untuk mengenal budaya leluhurnya.</p>
            </div>
        </div>
    </div>

    <!-- ===== KONTAK / FOOTER ===== -->
    <div class="kontak-card">
        <div class="kontak-item">
            <i class="fa-solid fa-location-dot"></i>
            <span class="k-label">Alamat</span>
            <span class="k-value">Jl. Perwira No. 3, Gundaling I,<br>Berastagi, Kabupaten Karo,<br>Sumatera Utara</span>
        </div>
        <div class="kontak-item">
            <i class="fa-solid fa-phone"></i>
            <span class="k-label">Telepon</span>
            <span class="k-value">(0628) 9123456</span>
        </div>
        <div class="kontak-item">
            <i class="fa-solid fa-envelope"></i>
            <span class="k-label">Email</span>
            <span class="k-value">info@museumpusaka.karo.go.id</span>
        </div>
        <div class="kontak-item">
            <i class="fa-solid fa-clock"></i>
            <span class="k-label">Jam Kunjungan</span>
            <span class="k-value">
                @php $todaySchedule = $operationalHours[$todayKey] ?? null; @endphp
                @if($todaySchedule && $todaySchedule['is_open'])
                    <span class="today-hours">Hari ini: {{ $todaySchedule['open'] }} - {{ $todaySchedule['close'] }} WIB</span>
                @else
                    <span class="today-hours">Hari ini: Tutup</span>
                @endif
                <span class="hours-detail">
                    @foreach($operationalHours as $schedule)
                        {{ $schedule['day'] }}: 
                        @if($schedule['is_open'])
                            {{ $schedule['open'] }} - {{ $schedule['close'] }}
                        @else
                            Tutup
                        @endif
                        @if(!$loop->last)<br>@endif
                    @endforeach
                </span>
            </span>
        </div>
        </div>
    </div>

    <!-- SARAN SECTION -->
    <div class="saran-section" id="saran-section">
        <h2>Kritik & Saran</h2>
        <p>Kami sangat menghargai setiap masukan, kritik, dan saran dari Anda untuk pengembangan Museum Pusaka Karo menjadi lebih baik lagi.</p>
        
        @if(session('success'))
            <div style="background-color: #dcfce7; color: #166534; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        
        <form action="{{ route('saran.store', [], false) }}" method="POST" class="saran-form" id="saranForm">
            @csrf
            <div>
                <label>Nama Lengkap <span style="color:red">*</span></label>
                <input type="text" name="nama" required placeholder="Masukkan nama Anda">
            </div>
            <div>
                <label>Email (Opsional)</label>
                <input type="email" name="email" placeholder="Masukkan alamat email Anda">
            </div>
            <div class="full-width">
                <label>Pesan / Masukan <span style="color:red">*</span></label>
                <textarea name="pesan" rows="5" required placeholder="Tuliskan kritik dan saran Anda di sini..."></textarea>
            </div>
            <div class="full-width">
                <button type="submit" class="btn-submit-saran" id="btnSubmitSaran">
                    <i class="fa-solid fa-paper-plane" style="margin-right: 6px;"></i> Kirim Pesan
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const locationMap = document.getElementById('locationMap');
        if (locationMap) {
            const map = L.map('locationMap', {
                scrollWheelZoom: false,
                attributionControl: false,
            }).setView([3.13220, 98.46650], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            L.marker([3.13220, 98.46650]).addTo(map)
                .bindPopup('<strong>Museum Pusaka Karo</strong><br>Jl. Perwira No. 3, Berastagi')
                .openPopup();
        }

        // Handle Form Saran / Kritik AJAX
        const saranForm = document.getElementById('saranForm');
        if (saranForm) {
            saranForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const btnSubmit = document.getElementById('btnSubmitSaran');
                const originalText = btnSubmit.innerHTML;
                
                // Loading state
                btnSubmit.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
                btnSubmit.disabled = true;

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Reset loading state
                    btnSubmit.innerHTML = originalText;
                    btnSubmit.disabled = false;

                    if (data.success) {
                        // Reset form
                        saranForm.reset();
                        
                        // SweetAlert Success
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Terimakasih telah mengisi saran dan pesan',
                            confirmButtonColor: '#7a1b1b',
                            confirmButtonText: 'Tutup'
                        });
                    }
                })
                .catch(error => {
                    // Reset loading state
                    btnSubmit.innerHTML = originalText;
                    btnSubmit.disabled = false;

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.',
                        confirmButtonColor: '#7a1b1b'
                    });
                });
            });
        }
    });
</script>
@endpush

@endsection