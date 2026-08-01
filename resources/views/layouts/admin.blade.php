<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Museum Pusaka Karo</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-red: #7A1B1B;
            --primary-red-hover: #5C1010;
            --cream: #Fdfbf7;
            --bg-color: #Fdfbf7;
            --sidebar-bg: #ffffff;
            --card-bg: #ffffff;
            --surface-bg: #ffffff;
            --surface-light: #f8fafc;
            --text-dark: #2d3748;
            --text-gray: #4a5568;
            --border-color: #e2e8f0;
            --sidebar-width: 260px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            background-color: var(--cream);
        }

        .sidebar-logo-container {
            background-color: var(--surface-light);
        }

        .page-header {
            background: transparent;
        }

        .nav-link.active {
            background-color: var(--primary-red);
            color: white;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar-logo-container {
            width: 80px;
            height: 80px;
            background-color: var(--surface-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .sidebar-logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .sidebar-logo-placeholder {
            color: var(--text-gray);
            font-size: 24px;
        }

        .sidebar-logo-text {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 15px;
            color: var(--text-dark);
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .sidebar-subtitle {
            font-size: 9px;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.4;
        }

        .nav-menu {
            list-style: none;
            padding: 15px 0;
            flex: 1;
        }

        .nav-item {
            margin-bottom: 2px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-link i {
            width: 24px;
            margin-right: 10px;
            color: var(--text-gray);
            font-size: 16px;
            text-align: center;
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--surface-light);
            color: var(--primary-red);
            border-right: 3px solid var(--primary-red);
        }

        .nav-link:hover i, .nav-link.active i {
            color: var(--primary-red);
        }

        .sidebar-footer {
            padding: 15px 25px;
            border-top: 1px solid var(--border-color);
        }
        
        .btn-logout {
            display: flex;
            align-items: center;
            width: 100%;
            background: none;
            border: none;
            color: var(--text-gray);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            padding: 10px 0;
            transition: color 0.2s;
        }
        
        .btn-logout i {
            width: 24px;
            margin-right: 10px;
            font-size: 16px;
        }

        .btn-logout:hover {
            color: var(--primary-red);
        }

        /* Logout Modal */
        .logout-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
        }
        
        .logout-modal-overlay.active {
            display: flex;
        }
        
        .logout-modal-box {
            background: white;
            width: 450px;
            padding: 40px 40px 20px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .logout-watermark {
            position: absolute;
            top: -10px;
            right: -10px;
            font-size: 120px;
            color: #000;
            opacity: 0.04;
            z-index: 0;
            pointer-events: none;
        }
        
        .logout-icon-wrapper {
            width: 50px;
            height: 50px;
            margin: 0 auto 20px;
            border: 1px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #000;
            position: relative;
            z-index: 1;
        }
        
        .logout-modal-box h3 {
            font-size: 20px;
            font-weight: 700;
            color: #000;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }
        
        .logout-modal-box p {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 30px;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }
        
        .logout-modal-actions {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }
        
        .btn-logout-cancel {
            flex: 1;
            padding: 12px;
            background: white;
            border: 1px solid #cbd5e1;
            color: #000;
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-logout-cancel:hover {
            background: #f8fafc;
        }
        
        .btn-logout-confirm {
            flex: 1;
            padding: 12px;
            background: #000;
            border: 1px solid #000;
            color: white;
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
        }
        
        .btn-logout-confirm:hover {
            background: #222;
        }
        
        .logout-modal-footer {
            border-top: 1px solid #f1f5f9;
            padding-top: 15px;
            font-size: 9px;
            color: #94a3b8;
            letter-spacing: 1px;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            width: calc(100% - var(--sidebar-width));
        }

        /* Top Header */
        .top-header {
            height: var(--header-height);
            background-color: var(--sidebar-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
        }

        .header-title h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-name {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-gray);
        }

        .avatar {
            width: 32px;
            height: 32px;
            background-color: var(--surface-light);
            color: var(--text-gray);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        /* Content Area */
        .content-area {
            padding: 40px;
            flex: 1;
        }

        /* Utility Classes */
        .card {
            background-color: var(--card-bg);
            border-radius: 18px;
            border: 1px solid rgba(216, 224, 235, 0.65);
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.06);
            padding: 30px;
            margin-bottom: 25px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 18px;
        }

        .page-title h3 {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .page-title p {
            font-size: 14px;
            color: var(--text-gray);
            line-height: 1.75;
        }

        .page-title p + p {
            margin-top: 0.75rem;
        }

        .page-note,
        .info-box {
            padding: 18px 22px;
            border-radius: 18px;
            background: var(--surface-light);
            color: var(--text-dark);
            border: 1px solid rgba(148, 163, 184, 0.25);
            font-size: 14px;
            line-height: 1.75;
            margin-bottom: 24px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 14px 16px;
            border-radius: 10px;
            border: 1px solid #34d399;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .reset-link {
            font-size: 13px;
            color: var(--text-gray);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .reset-link:hover {
            color: var(--primary-red);
        }

        .filter-separator {
            color: var(--text-gray);
            font-size: 13px;
            white-space: nowrap;
        }

        .page-btn.disabled {
            color: var(--text-gray);
            border-color: rgba(216, 224, 235, 0.9);
            background: var(--surface-light);
            pointer-events: none;
        }

        .secondary-text {
            color: var(--text-gray);
        }

        .inline-form {
            display: inline;
        }

        .empty-row td {
            text-align: center;
            color: var(--text-gray);
            padding: 40px;
        }

        .btn-add,
        .btn-outline,
        .btn-search,
        .btn-cancel,
        .btn-save,
        .btn-submit {
            transition: all 0.25s ease;
        }

        .btn-add {
            background: var(--primary-red);
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 16px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            box-shadow: 0 14px 30px rgba(197, 50, 50, 0.18);
        }

        .btn-add:hover {
            background: var(--primary-red-hover);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: var(--surface-bg);
            color: var(--text-dark);
            padding: 12px 20px;
            border-radius: 16px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(216, 224, 235, 0.95);
            cursor: pointer;
        }

        .btn-outline:hover {
            border-color: var(--primary-red);
            color: var(--primary-red);
        }

        .btn-back {
            font-size: 13px;
            color: var(--text-gray);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-search {
            background: var(--text-dark);
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 16px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-search:hover {
            background: rgba(45, 55, 72, 0.85);
        }

        .filter-bar,
        .filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: center;
        }

        .search-input,
        .select-input,
        .filter-bar input[type="text"],
        .filter-bar input[type="date"],
        .filter-bar select {
            padding: 12px 16px;
            border: 1px solid rgba(216, 224, 235, 0.95);
            border-radius: 16px;
            font-size: 14px;
            color: var(--text-dark);
            background: var(--surface-bg);
            outline: none;
            min-width: 160px;
        }

        .search-input:focus,
        .select-input:focus,
        .filter-bar input:focus,
        .filter-bar select:focus {
            border-color: rgba(197, 50, 50, 0.5);
            box-shadow: 0 0 0 4px rgba(197, 50, 50, 0.08);
        }

        .table-container {
            background: var(--card-bg);
            border: 1px solid rgba(216, 224, 235, 0.9);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.05);
            margin-bottom: 24px;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table th {
            background: var(--surface-light);
            text-align: left;
            padding: 18px 24px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-gray);
            border-bottom: 1px solid rgba(216, 224, 235, 0.9);
            letter-spacing: 0.08em;
        }

        .data-table td {
            padding: 18px 24px;
            font-size: 14px;
            color: var(--text-dark);
            border-bottom: 1px solid rgba(216, 224, 235, 0.9);
            vertical-align: middle;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: var(--card-bg);
            border: 1px solid rgba(216, 224, 235, 0.95);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 18px 35px rgba(15, 23, 42, 0.05);
            min-height: 130px;
            display: grid;
            gap: 10px;
            justify-content: center;
        }

        .summary-number {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-red);
        }

        .summary-label {
            font-size: 13px;
            color: var(--text-gray);
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .table-footer {
            padding: 18px 24px;
            border-top: 1px solid var(--border-color);
            background: var(--surface-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--text-gray);
        }

        .pagination-controls {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .page-btn {
            min-width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(216, 224, 235, 0.9);
            background: var(--surface-bg);
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 14px;
            font-size: 13px;
        }

        .page-btn.active {
            background: var(--text-dark);
            color: #fff;
            border-color: var(--text-dark);
        }

        .action-icons {
            display: flex;
            gap: 12px;
        }

        .btn-action-square {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(216, 224, 235, 0.9);
            border-radius: 14px;
            color: var(--text-gray);
            background: var(--surface-bg);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-action-square:hover {
            color: var(--text-dark);
            border-color: rgba(197, 50, 50, 0.85);
            transform: translateY(-1px);
        }

        @media (max-width: 900px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }
            .sidebar-header {
                padding: 15px;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                text-align: left;
            }
            .sidebar-logo-container {
                width: 40px;
                height: 40px;
                margin-bottom: 0;
                margin-right: 15px;
            }
            .sidebar-logo-text {
                font-size: 14px;
                margin-bottom: 0;
            }
            .sidebar-subtitle {
                display: none;
            }
            .nav-menu {
                display: flex;
                overflow-x: auto;
                padding: 10px 15px;
                gap: 10px;
                white-space: nowrap;
            }
            .nav-item {
                display: inline-block;
                margin-bottom: 0;
            }
            .nav-link {
                padding: 8px 15px;
                border-radius: 20px;
                border: 1px solid var(--border-color);
            }
            .nav-link:hover, .nav-link.active {
                border-right: none;
                border: 1px solid var(--primary-red);
            }
            .sidebar-footer {
                display: none;
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            .top-header {
                padding: 0 15px;
            }
            .content-area {
                padding: 15px;
            }
            .modal-content {
                width: 95%;
                margin: 0 auto;
            }
            .modal-footer {
                flex-direction: column;
            }
            .btn-cancel, .btn-save, .btn-submit {
                width: 100%;
            }

            .summary-cards {
                grid-template-columns: 1fr;
            }
            .page-header {
                flex-direction: column;
                align-items: stretch;
            }
            .page-header .header-actions {
                width: 100%;
                justify-content: flex-start;
            }
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .data-table th,
            .data-table td {
                padding: 14px 16px;
            }
            .data-table {
                display: block;
                overflow-x: auto;
            }
            .data-table thead {
                display: none;
            }
            .data-table tr {
                display: block;
                margin-bottom: 16px;
                background: #fff;
                border-radius: 20px;
                box-shadow: 0 10px 25px rgba(15, 23, 42, 0.05);
            }
            .data-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: none;
            }
            .data-table td::before {
                content: attr(data-label);
                flex: 1;
                font-size: 12px;
                color: var(--text-gray);
                text-transform: uppercase;
                letter-spacing: 0.08em;
                margin-right: 12px;
            }
            .data-table td:last-child {
                justify-content: flex-end;
            }
            .table-footer {
                flex-direction: column;
                align-items: stretch;
            }
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            background: var(--surface-light);
            color: var(--text-dark);
        }

        .badge.approved,
        .badge-approved {
            background: rgba(34, 197, 94, 0.15);
            color: #065f46;
        }

        .badge.pending,
        .badge-pending {
            background: rgba(245, 158, 11, 0.15);
            color: #92400e;
        }

        .badge.rejected,
        .badge-rejected {
            background: rgba(239, 68, 68, 0.15);
            color: #991b1b;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.35);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 24px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            width: 680px;
            max-width: 100%;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            border-radius: 24px;
            background: var(--surface-bg);
            box-shadow: 0 28px 80px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px;
            border-bottom: 1px solid rgba(216, 224, 235, 0.9);
            flex-shrink: 0;
        }

        .modal-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            color: var(--text-dark);
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: 0;
            overflow: hidden;
        }

        .modal-body {
            padding: 24px;
            overflow-y: auto;
            flex: 1;
            min-height: 0;
        }

        .modal-footer {
            padding: 20px 24px;
            border-top: 1px solid rgba(216, 224, 235, 0.9);
            display: flex;
            justify-content: flex-end;
            gap: 14px;
            background: var(--surface-light);
            flex-shrink: 0;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-dark);
            letter-spacing: 0.03em;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid rgba(216, 224, 235, 0.95);
            border-radius: 16px;
            font-size: 14px;
            color: var(--text-dark);
            background: var(--surface-bg);
            outline: none;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .form-control:focus {
            border-color: rgba(197, 50, 50, 0.5);
            box-shadow: 0 0 0 4px rgba(197, 50, 50, 0.08);
        }

        .btn-cancel {
            padding: 12px 24px;
            border: 1px solid rgba(216, 224, 235, 0.95);
            background: var(--surface-bg);
            color: var(--text-dark);
            border-radius: 16px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 700;
        }

        .btn-cancel:hover {
            background: rgba(241, 245, 249, 0.9);
        }

        .btn-save,
        .btn-submit {
            padding: 12px 24px;
            background: var(--primary-red);
            color: #fff;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 700;
        }

        .btn-save:hover,
        .btn-submit:hover {
            background: var(--primary-red-hover);
        }

        .summary-box {
            background: linear-gradient(180deg, rgba(255,255,255,0.98), var(--surface-light));
            border: 1px solid rgba(216, 224, 235, 0.9);
            border-radius: 20px;
            padding: 22px;
            box-shadow: 0 18px 35px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }

        .summary-box .num {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            font-weight: 700;
            color: var(--primary-red);
            margin-bottom: 10px;
        }

        .summary-box .label {
            font-size: 12px;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .bar-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .bar-track {
            flex: 1;
            background: #f3f4f6;
            border-radius: 4px;
            height: 16px;
            overflow: hidden;
        }

        .bar-fill {
            background: var(--primary-red);
            height: 100%;
            border-radius: 4px;
        }

        .bar-value {
            width: 30px;
            font-size: 12.5px;
            text-align: right;
            color: var(--text-dark);
            font-weight: 600;
        }

        .catatan {
            font-size: 12px;
            color: var(--text-gray);
            background: var(--surface-light);
            padding: 12px 15px;
            border-radius: 6px;
            margin-top: 15px;
        }

        .upload-area {
            border: 2px dashed rgba(209, 213, 219, 1);
            border-radius: 4px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            background-color: var(--surface-light);
            position: relative;
        }

        .upload-area:hover {
            background-color: rgba(241, 245, 249, 0.9);
        }

        .upload-icon {
            font-size: 24px;
            color: var(--text-gray);
            margin-bottom: 10px;
        }

        .upload-text {
            font-size: 13px;
            color: var(--text-gray);
            margin-bottom: 5px;
        }

        .upload-subtext {
            font-size: 11px;
            color: var(--text-gray);
        }

        .upload-input {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <!-- Logo area matching wireframe -->
            <div class="sidebar-logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="sidebar-logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <i class="fa-regular fa-image sidebar-logo-placeholder" style="display: none;"></i>
            </div>
            
            <div class="sidebar-logo-text">MUSEUM PUSAKA KARO</div>
            <div class="sidebar-subtitle">SISTEM INFORMASI WARISAN<br>BUDAYA</div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group"></i> Kategori Budaya
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('warisan.index') }}" class="nav-link {{ request()->routeIs('warisan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-open"></i> Warisan Budaya
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('media.index') }}" class="nav-link {{ request()->routeIs('media.*') ? 'active' : '' }}">
                    <i class="fa-regular fa-images"></i> Media Dokumentasi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('komentar.index') }}" class="nav-link {{ request()->routeIs('komentar.*') ? 'active' : '' }}">
                    <i class="fa-regular fa-comments"></i> Komentar
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pengunjung.index') }}" class="nav-link {{ request()->routeIs('pengunjung.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-address-book"></i> Buku Tamu Pengunjung
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('koleksi.index') }}" class="nav-link {{ request()->routeIs('koleksi.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-stacked"></i> Buku Induk Koleksi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i> Laporan
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <button type="button" class="btn-logout" onclick="openLogoutModal()">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-title">
                <h2>@yield('header_title', 'Dashboard')</h2>
            </div>
            
            <div class="header-actions">
                <a href="{{ route('pengaturan.index') }}" style="text-decoration: none; display: flex; align-items: center; gap: 12px; padding: 5px 10px; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='var(--surface-light)'" onmouseout="this.style.background='transparent'">
                    <div style="display: flex; flex-direction: column; align-items: flex-end;">
                        <span class="admin-name" style="color: var(--text-dark);">{{ Auth::user()->nama_lengkap ?? 'Administrator' }}</span>
                        <span style="font-size: 10px; color: var(--text-gray); text-transform: uppercase;">Pengaturan Akun</span>
                    </div>
                    <div class="avatar">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                </a>
            </div>
        </header>

        <!-- Dynamic Content -->
        <div class="content-area">
            @yield('content')
        </div>
    </main>

    <!-- Logout Confirmation Modal -->
    <div class="logout-modal-overlay" id="logoutModal">
        <div class="logout-modal-box">
            <div class="logout-icon-wrapper">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </div>
            <h3>Konfirmasi Keluar</h3>
            <p>Yakin ingin keluar dari sistem? Semua sesi aktif<br>Anda akan diakhiri.</p>
            
            <div class="logout-modal-actions">
                <button type="button" class="btn-logout-cancel" onclick="closeLogoutModal()">BATAL</button>
                <form action="{{ route('logout') }}" method="POST" style="flex: 1; display: flex; margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout-confirm">LOGOUT</button>
                </form>
            </div>
            
            <div class="logout-modal-footer">
                MUSEUM PUSAKA KARO
            </div>
            
            <!-- Watermark icon -->
            <i class="fa-solid fa-monument logout-watermark"></i>
        </div>
    </div>

    <script>
        function openLogoutModal() {
            document.getElementById('logoutModal').classList.add('active');
        }
        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.remove('active');
        }
    </script>

    <!-- Custom Scripts -->
    @stack('scripts')
</body>
</html>
