<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | SIPRESKA</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar, .sidebar * { font-family: Arial, sans-serif; }

        :root {
            --purple: #5B3A8E;
            --purple-dark: #432765;
            --gold: #C9A227;
            --text: #30283D;
            --muted: #81788F;
            --border: #EAE4F1;
            --lavender: #F5F0FB;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(circle at 90% 5%, rgba(197,165,233,.22), transparent 30%),
                linear-gradient(135deg, #FFFFFF, #F8F5FC 48%, #EEE5F8);
        }

        .layout {
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 250px;
            height: 100vh;
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            background: rgba(255,255,255,.98);
            border-right: 1px solid var(--border);
            box-shadow: 5px 0 25px rgba(67,39,101,.035);
            z-index: 100;
            overflow-y: auto;
        }

        .logo {
            padding: 0 10px;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: 1px;
            background: linear-gradient(90deg,#8058B8,#5B3A8E,#432765);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .logo small {
            display: block;
            max-width: 190px;
            margin-top: 7px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 400;
            line-height: 1.6;
            letter-spacing: 0;
        }

        .gold-line {
            width: 42px;
            height: 3px;
            flex-shrink: 0;
            margin: 16px 10px 30px;
            border-radius: 5px;
            background: var(--gold);
        }

        .menu-title {
            margin: 0 10px 13px;
            color: #A198AE;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.3px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: 1px solid transparent;
            border-radius: 9px;
            color: #655B73;
            text-decoration: none;
            font-size: 13px;
            line-height: 1.5;
            transition: background .2s, color .2s;
        }

        .menu a:hover,
        .menu a.active {
            background: linear-gradient(110deg,#F0EAF8,#E3D5F3);
            color: var(--purple);
        }

        .menu a.active {
            border-color: #E5D9F3;
            box-shadow: inset 3px 0 0 var(--purple);
            font-weight: 700;
        }

        .menu-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            border-radius: 7px;
            background: #F5F0FA;
            color: var(--purple);
            font-size: 15px;
        }

        .menu a.active .menu-icon { background: #FFFFFF; }

        .sidebar-counter-badge {
            margin-left: auto;
            padding: 2px 7px;
            border-radius: 999px;
            background: var(--gold, #C9A227);
            color: #FFFFFF;
            font-size: 10px;
            font-weight: 800;
            line-height: 1.2;
            box-shadow: 0 2px 6px rgba(201, 162, 39, 0.35);
        }

        .logout {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .logout button {
            width: 100%;
            padding: 12px;
            border: 0;
            border-radius: 9px;
            background: transparent;
            color: #B64B57;
            text-align: left;
            font-size: 13px;
            cursor: pointer;
            transition: background .2s;
        }

        .logout button:hover {
            background: #FFF1F2;
        }

        /* CONTENT */
        .content {
            width: calc(100% - 250px);
            min-width: 0;
            margin-left: 250px;
            padding: 36px 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
        }

        .eyebrow {
            margin-bottom: 10px;
            color: #8060A8;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.4px;
        }

        h1 {
            margin: 0 0 9px;
            color: var(--purple-dark);
            font-size: 28px;
        }

        .header p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .profile {
            flex-shrink: 0;
            padding: 9px 16px;
            border: 1px solid #E6DDF0;
            border-radius: 11px;
            background: #FFFFFF;
            color: var(--purple-dark);
            font-size: 13px;
            font-weight: 700;
            overflow-wrap: anywhere;
            box-shadow: 0 2px 10px rgba(67,39,101,.04);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* SAMBUTAN & QUICK EXPORT */
        .welcome {
            margin-bottom: 28px;
            padding: 27px;
            border: 1px solid #E3D5F2;
            border-left: 4px solid var(--gold);
            border-radius: 15px;
            background: linear-gradient(115deg,#FFFFFF,#F6F0FC 52%,#E7D9F5);
            box-shadow: 0 10px 30px rgba(91,58,142,.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .welcome-content {
            max-width: 650px;
        }

        .welcome h2 {
            margin: 0 0 10px;
            color: var(--purple-dark);
            font-size: 21px;
        }

        .welcome p {
            margin: 0;
            color: #776C88;
            font-size: 13px;
            line-height: 1.8;
        }

        /* EXPORT DROPDOWN BUTTON */
        .export-dropdown-wrapper {
            position: relative;
            display: inline-block;
        }

        .export-main-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            border: 1px solid #D5C2ED;
            border-radius: 10px;
            background: linear-gradient(135deg, #7A53B3, #5B3A8E);
            color: #FFFFFF;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(91,58,142,.2);
            transition: transform .15s, box-shadow .15s, background .2s;
        }

        .export-main-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 9px 22px rgba(91,58,142,.3);
            background: linear-gradient(135deg, #6C44A7, #482A75);
        }

        .export-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 290px;
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 14px 35px rgba(67,39,101,.15);
            padding: 8px;
            z-index: 1000;
        }

        .export-menu.show {
            display: block;
            animation: fadeIn .15s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .export-menu-title {
            padding: 8px 12px 6px;
            color: #A096AF;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .export-menu a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            border-radius: 8px;
            color: var(--text);
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: background .15s, color .15s;
        }

        .export-menu a:hover {
            background: #F4EEFA;
            color: var(--purple);
        }

        .export-menu a span.tag {
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            background: #EFE7F8;
            color: var(--purple);
            font-weight: 700;
        }

        .export-menu-divider {
            height: 1px;
            background: var(--border);
            margin: 6px 0;
        }

        /* STATISTIK */
        .section-title {
            margin: 0 0 16px;
            color: var(--purple-dark);
            font-size: 17px;
            font-weight: 700;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        @media (max-width: 1100px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .stats {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            min-width: 0;
            padding: 20px 22px;
            border: 1px solid #ECE4F4;
            border-radius: 14px;
            background: #FFFFFF;
            box-shadow: 0 4px 16px rgba(67, 39, 101, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(67, 39, 101, 0.08);
            border-color: #DCCFE8;
        }

        .stat-card-action.has-pending {
            background: #FFFFFF;
            border-color: #F1E2BF;
            box-shadow: 0 4px 16px rgba(201, 162, 39, 0.07);
        }

        .stat-card-action.has-pending:hover {
            border-color: #E2C784;
            box-shadow: 0 10px 24px rgba(201, 162, 39, 0.12);
        }

        .stat-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 14px;
        }

        .stat-label {
            color: #6C5E7F;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: -0.1px;
        }

        .stat-status-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.2;
            white-space: nowrap;
        }

        .stat-status-badge.pending {
            background: #FFF4DC;
            color: #9A6C05;
            border: 1px solid #F8DE9E;
        }

        .stat-status-badge.success {
            background: #EDF7F1;
            color: #1E7E45;
            border: 1px solid #CEEBD7;
        }

        .stat-status-badge.neutral {
            background: #F4EFF9;
            color: #6C528D;
            border: 1px solid #E6DCF1;
        }

        .stat-status-badge.growth {
            background: #EDF8F1;
            color: #198754;
            border: 1px solid #D1ECD9;
        }

        .stat-status-badge.growth.neutral {
            background: #F6F3FA;
            color: #796D89;
            border: 1px solid #EBE4F4;
        }

        .stat-number {
            color: #2D1A47;
            font-size: 30px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
            overflow-wrap: anywhere;
        }

        .stat-number-pending {
            color: #B47805 !important;
        }

        .stat-number-approved {
            color: #1E824C !important;
        }

        .stat-note {
            color: #8C7F9E;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.4;
        }

        .stat-card-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #9A6C05;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.15s ease, transform 0.15s ease;
        }

        .stat-card-link:hover {
            color: #694801;
            transform: translateX(2px);
        }

        /* EXPORT CENTER PANEL */
        .export-center-panel {
            margin-bottom: 28px;
            padding: 26px 28px;
            border: 1px solid #E5DBF2;
            border-radius: 16px;
            background: linear-gradient(135deg, #FFFFFF, #FAF7FE);
            box-shadow: 0 8px 26px rgba(67,39,101,.05);
        }

        .export-center-header {
            margin-bottom: 18px;
        }

        .export-center-header h2 {
            margin: 0 0 6px;
            color: var(--purple-dark);
            font-size: 19px;
            font-weight: 800;
        }

        .export-center-header p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .export-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .export-card-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 18px;
            border: 1px solid #E8DEF5;
            border-radius: 12px;
            background: #FFFFFF;
            text-decoration: none;
            color: var(--text);
            box-shadow: 0 4px 14px rgba(67,39,101,.03);
            transition: transform .2s, box-shadow .2s, border-color .2s;
        }

        .export-card-link:hover {
            transform: translateY(-2px);
            border-color: var(--purple);
            box-shadow: 0 8px 22px rgba(91,58,142,.12);
        }

        .export-card-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #F4EDFA;
            color: var(--purple);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .export-card-body {
            min-width: 0;
            flex: 1;
        }

        .export-card-title {
            margin: 0 0 4px;
            font-size: 13px;
            font-weight: 700;
            color: var(--purple-dark);
        }

        .export-card-desc {
            margin: 0;
            font-size: 11px;
            color: var(--muted);
            line-height: 1.5;
        }

        .export-card-badge {
            font-size: 10px;
            font-weight: 800;
            padding: 3px 7px;
            border-radius: 5px;
            background: #EFE7F8;
            color: var(--purple);
            flex-shrink: 0;
        }

        /* PANEL PENCARIAN & DAFTAR PRESTASI (BENTUK LIST, BUKAN TABLE) */
        .panel {
            padding: 26px 28px;
            border: 1px solid #E7DFF0;
            border-radius: 16px;
            background: rgba(255,255,255,.98);
            box-shadow: 0 7px 24px rgba(67,39,101,.045);
            margin-bottom: 28px;
        }

        .panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 18px;
        }

        .panel-header h2 {
            margin: 0 0 6px;
            color: var(--purple-dark);
            font-size: 19px;
            font-weight: 800;
        }

        .panel-description {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .view-all-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 15px;
            border: 1px solid #E3D5F2;
            border-radius: 9px;
            background: #F7F2FC;
            color: var(--purple);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: background .2s, transform .15s;
        }

        .view-all-btn:hover {
            background: #ECE2F8;
            transform: translateY(-1px);
        }

        /* SEARCH BAR & FILTERS ON ADMIN DASHBOARD */
        .search-filter-box {
            background: #FAF7FE;
            border: 1px solid #EAE1F5;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .search-main-row {
            margin-bottom: 10px;
        }

        .search-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-icon {
            position: absolute;
            left: 14px;
            color: #8C7C9E;
            font-size: 15px;
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 40px;
            border: 1px solid #DDD1EA;
            border-radius: 10px;
            background: #FFFFFF;
            color: var(--text);
            font-size: 13px;
            transition: border-color .2s, box-shadow .2s;
        }

        .search-input:focus {
            outline: 0;
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(91,58,142,.12);
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
        }

        .filter-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #DDD1EA;
            border-radius: 9px;
            background: #FFFFFF;
            color: var(--text);
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
        }

        .filter-select:focus {
            outline: 0;
            border-color: var(--purple);
        }

        .filter-reset-btn {
            padding: 10px 12px;
            border: 1px solid #E5DBF0;
            border-radius: 9px;
            background: #FFFFFF;
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, color .2s;
        }

        .filter-reset-btn:hover {
            background: #FFF1F2;
            color: #B64B57;
        }

        /* MODERN DATA TABLE (SUPER RAPI, PRESISI & TERSTRUKTUR) */
        .admin-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #ECE3F5;
            border-radius: 13px;
            background: #FFFFFF;
            box-shadow: 0 3px 12px rgba(67, 39, 101, 0.035);
        }

        .admin-prestasi-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        .admin-prestasi-table thead {
            background: #FAF8FD;
            border-bottom: 1px solid #ECE3F5;
        }

        .admin-prestasi-table th {
            padding: 13px 18px;
            font-size: 11px;
            font-weight: 700;
            color: #6C5B82;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            white-space: nowrap;
        }

        .admin-prestasi-table tbody tr {
            border-bottom: 1px solid #F3EDF8;
            transition: background 0.15s ease;
        }

        .admin-prestasi-table tbody tr:last-child {
            border-bottom: none;
        }

        .admin-prestasi-table tbody tr:hover {
            background: #FCFAFF;
        }

        .admin-prestasi-table td {
            padding: 14px 18px;
            vertical-align: middle;
        }

        .table-prestasi-title {
            font-size: 14px;
            font-weight: 700;
            color: #2D1A47;
            line-height: 1.35;
            margin-bottom: 4px;
            overflow-wrap: anywhere;
        }

        .table-prestasi-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
            font-size: 11.5px;
            color: #7E7092;
        }

        .badge-capaian-tag {
            display: inline-flex;
            align-items: center;
            padding: 1.5px 6.5px;
            border-radius: 4px;
            background: #F1E9F9;
            color: var(--purple);
            font-size: 11px;
            font-weight: 700;
        }

        .meta-separator {
            color: #CFC2DD;
            font-size: 11px;
        }

        .table-user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .table-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #F2ECFA;
            color: var(--purple);
            font-weight: 800;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid #E4D7F3;
        }

        .table-user-info {
            min-width: 0;
        }

        .table-user-name {
            font-size: 13px;
            font-weight: 700;
            color: #2D1A47;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table-user-sub {
            font-size: 11px;
            color: #8C7E9E;
            margin-top: 1px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .status-badge-modern {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 700;
            line-height: 1.3;
            white-space: nowrap;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .status-badge-modern.status-menunggu_verifikasi {
            background: #FFF8E6;
            color: #975A00;
            border: 1px solid #FFE4A0;
        }

        .status-badge-modern.status-menunggu_verifikasi .status-dot {
            background: #F59E0B;
        }

        .status-badge-modern.status-disetujui {
            background: #EDF9F1;
            color: #157A3C;
            border: 1px solid #C4ECCF;
        }

        .status-badge-modern.status-disetujui .status-dot {
            background: #10B981;
        }

        .status-badge-modern.status-ditolak {
            background: #FDF2F2;
            color: #B91C1C;
            border: 1px solid #FACDCD;
        }

        .status-badge-modern.status-ditolak .status-dot {
            background: #EF4444;
        }

        .status-badge-modern.status-perlu_perbaikan {
            background: #FFF7E6;
            color: #9C6500;
            border: 1px solid #FFE7B3;
        }

        .status-badge-modern.status-perlu_perbaikan .status-dot {
            background: #EAB308;
        }

        .btn-row-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 145px;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s ease, border-color 0.15s ease, transform 0.15s ease, box-shadow 0.15s ease;
            white-space: nowrap;
            box-sizing: border-box;
            background: #FFFFFF;
            border: 1px solid #D8CBE6;
            color: var(--purple);
        }

        .btn-row-action:hover {
            background: #F6F0FD;
            border-color: var(--purple);
            transform: translateY(-1px);
        }

        .btn-row-action.highlight {
            background: linear-gradient(135deg, #7A53B3, #5B3A8E);
            border: 1px solid transparent;
            color: #FFFFFF;
            box-shadow: 0 2px 8px rgba(91, 58, 142, 0.22);
        }

        .btn-row-action.highlight:hover {
            background: linear-gradient(135deg, #6C44A7, #482A75);
            box-shadow: 0 4px 12px rgba(91, 58, 142, 0.3);
            transform: translateY(-1px);
        }

        .empty-state {
            padding: 35px 20px;
            border: 1px dashed #D4C3E7;
            border-radius: 12px;
            background: #FAF7FE;
            color: var(--muted);
            text-align: center;
            font-size: 13px;
            line-height: 1.8;
        }

        .empty-state strong {
            display: block;
            margin-bottom: 5px;
            color: var(--purple-dark);
            font-size: 14px;
        }

        /* GRAFIK TREN PRESTASI */
        .trend-panel { margin-bottom: 22px; }
        .trend-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 20px;
        }
        .trend-download-button {
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 14px;
            border: 1px solid #DCCCF4;
            border-radius: 9px;
            background: #F8F4FC;
            color: var(--purple-dark);
            cursor: pointer;
            font: inherit;
            font-size: 11px;
            font-weight: 800;
            text-decoration: none;
            transition: background .2s, border-color .2s, color .2s;
        }
        .trend-download-button:hover {
            border-color: var(--purple);
            background: var(--purple);
            color: #fff;
        }
        .trend-panel h2 {
            margin: 0 0 6px;
            color: var(--purple-dark);
            font-size: 18px;
        }
        .trend-description {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }
        .trend-legend {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            color: var(--muted);
            font-size: 11px;
        }
        .trend-legend i {
            width: 10px;
            height: 10px;
            border-radius: 3px;
            background: var(--purple);
        }
        .trend-chart {
            display: grid;
            grid-template-columns: 42px minmax(0, 1fr);
            gap: 12px;
        }
        .trend-axis {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding-bottom: 24px;
            color: #9589A7;
            font-size: 10px;
            text-align: right;
        }
        .trend-plot { position: relative; min-width: 0; height: 220px; }
        .trend-grid {
            position: absolute;
            inset: 0 0 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .trend-grid span { border-top: 1px dashed #E7DFF0; }
        .trend-bars {
            position: relative;
            display: grid;
            grid-template-columns: repeat(var(--bar-count), minmax(0, 1fr));
            gap: 12px;
            height: 100%;
        }
        .trend-bar-group {
            display: flex;
            min-width: 0;
            height: 100%;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            color: var(--muted);
            font-size: 10px;
        }
        .trend-bar-track {
            display: flex;
            width: 100%;
            height: calc(100% - 24px);
            align-items: flex-end;
            justify-content: center;
        }
        .trend-bar {
            width: min(38px, 55%);
            min-height: 4px;
            border-radius: 5px 5px 0 0;
            background: linear-gradient(180deg, #B49AEA, var(--purple));
        }
        .trend-caption { margin: 12px 0 0; color: var(--muted); font-size: 11px; }

        /* ANALYTICS GRID (BAR CHART + DONUT CHART) */
        .analytics-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(0, 1fr);
            gap: 20px;
            margin-bottom: 28px;
            align-items: stretch;
        }

        .analytics-grid .panel {
            margin-bottom: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* DONUT CHART PANEL */
        .donut-panel {
            padding: 26px 28px;
        }

        .donut-content-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex: 1;
            padding: 8px 0;
        }

        .donut-chart-wrap {
            position: relative;
            flex-shrink: 0;
            width: 170px;
            height: 170px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .donut-pie {
            width: 170px;
            height: 170px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 18px rgba(67,39,101,.08);
            transition: transform .25s ease;
        }

        .donut-pie:hover {
            transform: scale(1.03);
        }

        .donut-center {
            width: 106px;
            height: 106px;
            border-radius: 50%;
            background: #FFFFFF;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 2px 6px rgba(0,0,0,.05);
            text-align: center;
            padding: 4px;
        }

        .donut-center-total {
            font-size: 24px;
            font-weight: 800;
            color: var(--purple-dark);
            line-height: 1.1;
        }

        .donut-center-label {
            font-size: 9.5px;
            color: var(--muted);
            font-weight: 700;
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .donut-legend {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .donut-legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 8px;
            background: #FAF7FE;
            border: 1px solid #ECE3F5;
            font-size: 11px;
        }

        .donut-legend-left {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
        }

        .donut-legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 3px;
            flex-shrink: 0;
        }

        .donut-legend-name {
            font-weight: 600;
            color: var(--purple-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .donut-legend-right {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .donut-legend-count {
            font-weight: 700;
            color: var(--text);
            font-size: 11px;
        }

        .donut-legend-pct {
            font-size: 9.5px;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
            background: #EFE7F8;
            color: var(--purple);
        }

        /* MODAL DETAIL PRESTASI (LUAS, LAPANG, BERSIH, TIDAK MEPET) */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(36, 27, 49, 0.65);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            overflow-y: auto;
        }

        .modal-overlay.active {
            display: flex;
            animation: modalFadeIn .2s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-card {
            background: #FFFFFF;
            border-radius: 18px;
            box-shadow: 0 24px 60px rgba(54, 28, 87, 0.28);
            width: 100%;
            max-width: 860px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
            border: 1px solid #ECE2F5;
        }

        .modal-header {
            padding: 24px 30px 20px;
            border-bottom: 1px solid #ECE4F4;
            background: #FAF8FD;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }

        .modal-header-main {
            flex: 1;
            min-width: 0;
        }

        .modal-eyebrow {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.2px;
            color: #8C6FA8;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .modal-header-title {
            margin: 0 0 10px;
            font-size: 20px;
            color: #2D1A47;
            font-weight: 800;
            letter-spacing: -0.3px;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .modal-header-status {
            display: flex;
            align-items: center;
        }

        .modal-close-btn {
            background: #FFFFFF;
            border: 1px solid #DCD0EA;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            color: #6C5D80;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .15s, color .15s, border-color .15s;
            flex-shrink: 0;
        }

        .modal-close-btn:hover {
            background: #FFF1F2;
            color: #D63031;
            border-color: #F8B4B4;
        }

        .modal-body {
            padding: 26px 30px;
            overflow-y: auto;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .modal-profile-strip {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            background: #FAF7FD;
            border-radius: 12px;
            border: 1px solid #ECE1F6;
        }

        .modal-profile-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8E65C9, #5B3A8E);
            color: #FFFFFF;
            font-weight: 800;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(91, 58, 142, 0.2);
        }

        .modal-profile-name {
            font-size: 14.5px;
            font-weight: 700;
            color: #2D1A47;
        }

        .modal-profile-meta {
            font-size: 12px;
            color: #7B6D8F;
            margin-top: 3px;
            line-height: 1.5;
        }

        .modal-submission-date {
            margin-left: auto;
            font-size: 11.5px;
            color: #8F81A3;
            font-weight: 600;
            white-space: nowrap;
        }

        .modal-team-strip {
            padding: 12px 18px;
            background: #FCFAFF;
            border: 1px dashed #DACEE8;
            border-radius: 10px;
            font-size: 12.5px;
            color: #433256;
            line-height: 1.5;
        }

        .modal-section-clean {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .modal-clean-title {
            font-size: 11.5px;
            font-weight: 800;
            color: #6E538E;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #F2ECFA;
        }

        .modal-clean-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px 20px;
        }

        @media (max-width: 768px) {
            .modal-clean-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 500px) {
            .modal-clean-grid {
                grid-template-columns: 1fr;
            }
        }

        .modal-grid-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .modal-item-label {
            font-size: 11px;
            font-weight: 600;
            color: #8C7E9E;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .modal-item-val {
            font-size: 13.5px;
            font-weight: 700;
            color: #2D1A47;
            line-height: 1.45;
            overflow-wrap: anywhere;
        }

        .modal-item-val.highlight-capaian {
            color: var(--purple);
            font-weight: 800;
        }

        .modal-clean-desc {
            font-size: 13px;
            line-height: 1.7;
            color: #4A3E5C;
            white-space: pre-line;
            background: #FAF8FE;
            padding: 16px 18px;
            border-radius: 12px;
            border: 1px solid #EBE2F4;
        }

        .modal-evidence-list-spacious {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .modal-evidence-item-spacious {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 18px;
            border-radius: 10px;
            background: #FAF8FE;
            border: 1px solid #ECE2F5;
            transition: border-color .15s, background .15s;
        }

        .modal-evidence-item-spacious:hover {
            background: #F6F0FD;
            border-color: #DCCFE8;
        }

        .evidence-item-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .evidence-file-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #EFE7F8;
            color: var(--purple);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .evidence-file-title {
            font-size: 13px;
            font-weight: 700;
            color: #2D1A47;
            overflow-wrap: anywhere;
        }

        .evidence-file-kind {
            font-size: 11px;
            color: #8C7E9E;
            margin-top: 2px;
        }

        .btn-open-doc {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            background: #FFFFFF;
            border: 1px solid #D5C6E6;
            color: var(--purple);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            transition: background .15s, border-color .15s;
        }

        .btn-open-doc:hover {
            background: #F1E9F9;
            border-color: var(--purple);
        }

        .modal-footer {
            padding: 18px 30px;
            border-top: 1px solid #ECE4F4;
            background: #FAF9FE;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-modal-dismiss {
            padding: 9px 20px;
            border-radius: 8px;
            border: 1px solid #D5C8E4;
            background: #FFFFFF;
            color: #5B3A8E;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-modal-dismiss:hover {
            background: #F4EEFB;
            border-color: #5B3A8E;
        }

        .btn-modal-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 22px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(135deg, #7A53B3, #5B3A8E);
            color: #FFFFFF;
            font-size: 12.5px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(91, 58, 142, 0.25);
            transition: all .15s;
        }

        .btn-modal-action:hover {
            background: linear-gradient(135deg, #6B43A6, #4A2B78);
            transform: translateY(-1px);
        }
        .footer-note {
            padding: 20px 0 10px;
            color: #9589A7;
            font-size: 11px;
            text-align: center;
            line-height: 1.7;
        }

        /* RESPONSIVE */
        @media (max-width: 1100px) {
            .analytics-grid {
                grid-template-columns: 1fr;
            }
            .export-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 950px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .content {
                padding: 28px 24px;
                width: calc(100% - 210px);
                margin-left: 210px;
            }
            .sidebar {
                width: 210px;
            }
            .filters-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .layout { display: block; }
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: 0;
                padding-bottom: 22px;
            }
            .content {
                width: 100%;
                margin: 0;
                padding: 24px 16px;
            }
            .header {
                align-items: flex-start;
                flex-direction: column;
            }
            .welcome {
                flex-direction: column;
                align-items: flex-start;
            }
            .export-dropdown-wrapper {
                width: 100%;
            }
            .export-main-btn {
                width: 100%;
                justify-content: center;
            }
            .export-menu {
                left: 0;
                right: 0;
                width: 100%;
            }
            .export-grid {
                grid-template-columns: 1fr;
            }
            .filters-grid {
                grid-template-columns: 1fr;
            }
            .prestasi-list-card {
                flex-direction: column;
                gap: 12px;
            }
            .trend-chart { grid-template-columns: 32px minmax(0, 1fr); gap: 8px; }
            .trend-plot { height: 180px; }
            .trend-bars { gap: 5px; }
        }

        @media (max-width: 440px) {
            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    {{-- SIDEBAR ADMIN --}}
    <aside class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SIPRESKA" width="34" height="36" style="display: block; margin-bottom: 8px; object-fit: contain;">
            SIPRESKA
            <small>
                Sistem Informasi Pendataan dan Pengelolaan
                Prestasi Sivitas Akademika
            </small>
        </div>

        <div class="gold-line"></div>
        <div class="menu-title">MENU ADMIN</div>

        <nav class="menu">
            <a
                href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </span>
                Dashboard
            </a>

            <a
                href="{{ route('admin.prestasi.index') }}"
                class="{{ request()->routeIs('admin.prestasi.index') ? 'active' : '' }}"
            >
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </span>
                Daftar Prestasi
            </a>

            <a
                href="{{ route('admin.verifikasi.index') }}"
                class="{{ request()->routeIs('admin.verifikasi.*') ? 'active' : '' }}"
            >
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </span>
                <span style="flex: 1;">Verifikasi Prestasi</span>
                @php
                    $badgePendingCount = rescue(fn() => \App\Models\Prestasi::where('status', 'menunggu_verifikasi')->count(), 0, false);
                @endphp
                @if ($badgePendingCount > 0)
                    <span class="sidebar-counter-badge">{{ $badgePendingCount }}</span>
                @endif
            </a>

            @if(auth()->user()?->role === 'super_admin')
            <a
                href="{{ route('superadmin.users.index') }}"
                class="{{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}"
            >
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </span>
                Manajemen Akun
            </a>
            @endif

            <a
                href="{{ route('admin.panduan') }}"
                class="{{ request()->routeIs('admin.panduan') ? 'active' : '' }}"
            >
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </span>
                Panduan Penggunaan
            </a>
        </nav>

        <div class="logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Keluar dari Akun</button>
            </form>
        </div>
    </aside>

    {{-- KONTEN DASHBOARD --}}
    <main class="content">

        <header class="header">
            <div>
                <div class="eyebrow">DASHBOARD ADMINISTRATOR</div>
                <h1>Dashboard Admin</h1>
                <p>
                    Pantau ringkasan data sistem, perkembangan prestasi, serta pencarian peserta dan prestasi.
                </p>
            </div>

            <div class="profile">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--purple); flex-shrink: 0;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span>{{ auth()->user()->admin?->nama ?? (auth()->user()?->role === 'super_admin' ? 'Super Admin' : 'Admin SIPRESKA') }}</span>
            </div>
        </header>

        {{-- SAMBUTAN & AKSI EKSPOR CEPAT --}}
        <section class="welcome">
            <div class="welcome-content">
                <h2>
                    Selamat datang, {{ auth()->user()->admin?->nama ?? 'Admin' }}!
                </h2>
                <p>
                    Gunakan fitur pencarian nama peserta atau prestasi, sistem ekspor data sistem lengkap (CSV), dan pemantauan verifikasi prestasi di bawah ini.
                </p>
            </div>

            <div class="export-dropdown-wrapper">
                <button type="button" class="export-main-btn" id="adminExportDropdownTrigger" aria-expanded="false">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Ekspor Data Sistem</span>
                    <span>▾</span>
                </button>
                <div class="export-menu" id="adminExportDropdownMenu">
                    <div class="export-menu-title">Ekspor Prestasi</div>
                    <a href="{{ route('admin.export', 'prestasi') }}">
                        <span>Semua Prestasi (Lengkap)</span>
                        <span class="tag">CSV</span>
                    </a>
                    <a href="{{ route('admin.export', 'prestasi-disetujui') }}">
                        <span>Prestasi Disetujui</span>
                        <span class="tag">CSV</span>
                    </a>
                    <a href="{{ route('admin.export', 'prestasi-menunggu') }}">
                        <span>Menunggu Verifikasi</span>
                        <span class="tag">CSV</span>
                    </a>
                    <a href="{{ route('admin.export', 'prestasi-ditolak') }}">
                        <span>Prestasi Ditolak</span>
                        <span class="tag">CSV</span>
                    </a>
                    <div class="export-menu-divider"></div>
                    <div class="export-menu-title">Ekspor Sivitas & Rekap</div>
                    <a href="{{ route('admin.export', 'mahasiswa') }}">
                        <span>Data Mahasiswa</span>
                        <span class="tag">CSV</span>
                    </a>
                    <a href="{{ route('admin.export', 'dosen') }}">
                        <span>Data Dosen</span>
                        <span class="tag">CSV</span>
                    </a>
                    <a href="{{ route('admin.export', 'verifikasi') }}">
                        <span>Log Riwayat Verifikasi</span>
                        <span class="tag">CSV</span>
                    </a>
                    <a href="{{ route('admin.export', 'tren-tahunan') }}">
                        <span>Rekap Perkembangan Tahunan</span>
                        <span class="tag">CSV</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- RINGKASAN STATISTIK --}}
        <h2 class="section-title">Ringkasan Data Sistem</h2>

        <section class="stats">
            {{-- KARTU 1: TOTAL PRESTASI (DILENGKAPI PERTUMBUHAN HARI INI) --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Total Prestasi</span>
                    @if(($pengajuanHariIni ?? 0) > 0)
                        <span class="stat-status-badge growth">+{{ number_format($pengajuanHariIni, 0, ',', '.') }} hari ini</span>
                    @else
                        <span class="stat-status-badge growth neutral">0 hari ini</span>
                    @endif
                </div>
                <div class="stat-number">
                    {{ number_format($totalPrestasi ?? 0, 0, ',', '.') }}
                </div>
                <div class="stat-note">Seluruh pengajuan tercatat di sistem</div>
            </article>

            {{-- KARTU 2: MENUNGGU VERIFIKASI (PRIORITAS TINDAKAN) --}}
            <article class="stat-card stat-card-action @if(($totalMenunggu ?? 0) > 0) has-pending @endif">
                <div class="stat-top-row">
                    <span class="stat-label">Menunggu Verifikasi</span>
                    @if(($totalMenunggu ?? 0) > 0)
                        <span class="stat-status-badge pending">Butuh Tindakan</span>
                    @endif
                </div>
                <div class="stat-number stat-number-pending">
                    {{ number_format($totalMenunggu ?? 0, 0, ',', '.') }}
                </div>
                @if(($totalMenunggu ?? 0) > 0)
                    <a href="{{ route('admin.verifikasi.index') }}" class="stat-card-link">
                        Tinjau Antrean Verifikasi →
                    </a>
                @else
                    <div class="stat-note">Semua pengajuan telah diproses</div>
                @endif
            </article>

            {{-- KARTU 3: PRESTASI DISETUJUI --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Prestasi Disetujui</span>
                    @php
                        $rasioDisetujui = ($totalPrestasi ?? 0) > 0
                            ? round((($totalDisetujui ?? 0) / $totalPrestasi) * 100)
                            : 0;
                    @endphp
                    <span class="stat-status-badge success">{{ $rasioDisetujui }}% Rasio</span>
                </div>
                <div class="stat-number stat-number-approved">
                    {{ number_format($totalDisetujui ?? 0, 0, ',', '.') }}
                </div>
                <div class="stat-note">Pencapaian valid & terpublikasi</div>
            </article>

            {{-- KARTU 4: TOTAL SIVITAS TERDAFTAR --}}
            <article class="stat-card">
                <div class="stat-top-row">
                    <span class="stat-label">Total Sivitas Terdaftar</span>
                    <span class="stat-status-badge neutral">Akun Aktif</span>
                </div>
                <div class="stat-number">
                    {{ number_format(($totalMahasiswa ?? 0) + ($totalDosen ?? 0), 0, ',', '.') }}
                </div>
                <div class="stat-note">{{ number_format($totalMahasiswa ?? 0, 0, ',', '.') }} Mahasiswa · {{ number_format($totalDosen ?? 0, 0, ',', '.') }} Dosen</div>
            </article>
        </section>

        {{-- PUSAT EKSPOR DATA SISTEM LENGKAP --}}
        <section class="export-center-panel">
            <div class="export-center-header">
                <h2>Pusat Ekspor Data Sistem</h2>
                <p>
                    Unduh setiap data yang ada di dalam sistem SIPRESKA ke dalam berkas CSV standar (kompatibel penuh dengan Microsoft Excel & Google Sheets).
                </p>
            </div>

            <div class="export-grid">
                {{-- KARTU 1: SEMUA PRESTASI --}}
                <a href="{{ route('admin.export', 'prestasi') }}" class="export-card-link">
                    <div class="export-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H8c-.55 0-1 .45-1 1v1c0 .55.45 1 1 1h8c.55 0 1-.45 1-1v-1c0-.55-.45-1-1-1h-1c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 4h12v6a6 6 0 0 1-12 0V4z"></path></svg>
                    </div>
                    <div class="export-card-body">
                        <div class="export-card-title">Semua Data Prestasi</div>
                        <div class="export-card-desc">Seluruh data prestasi, pengaju, anggota tim, dan verifikasi.</div>
                    </div>
                    <span class="export-card-badge">CSV</span>
                </a>

                {{-- KARTU 2: PRESTASI DISETUJUI --}}
                <a href="{{ route('admin.export', 'prestasi-disetujui') }}" class="export-card-link">
                    <div class="export-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <div class="export-card-body">
                        <div class="export-card-title">Prestasi Disetujui</div>
                        <div class="export-card-desc">Data prestasi resmi yang telah lolos verifikasi admin.</div>
                    </div>
                    <span class="export-card-badge">CSV</span>
                </a>

                {{-- KARTU 3: MENUNGGU VERIFIKASI --}}
                <a href="{{ route('admin.export', 'prestasi-menunggu') }}" class="export-card-link">
                    <div class="export-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div class="export-card-body">
                        <div class="export-card-title">Antrean Verifikasi</div>
                        <div class="export-card-desc">Pengajuan yang sedang menunggu keputusan verifikasi.</div>
                    </div>
                    <span class="export-card-badge">CSV</span>
                </a>

                {{-- KARTU 4: DATA MAHASISWA --}}
                <a href="{{ route('admin.export', 'mahasiswa') }}" class="export-card-link">
                    <div class="export-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                    </div>
                    <div class="export-card-body">
                        <div class="export-card-title">Data Mahasiswa</div>
                        <div class="export-card-desc">Direktori mahasiswa, NIM, prodi, dan perolehan prestasi.</div>
                    </div>
                    <span class="export-card-badge">CSV</span>
                </a>

                {{-- KARTU 5: DATA DOSEN --}}
                <a href="{{ route('admin.export', 'dosen') }}" class="export-card-link">
                    <div class="export-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <div class="export-card-body">
                        <div class="export-card-title">Data Dosen</div>
                        <div class="export-card-desc">Direktori dosen, NIP, prodi, dan capaian prestasi.</div>
                    </div>
                    <span class="export-card-badge">CSV</span>
                </a>

                {{-- KARTU 6: RIWAYAT VERIFIKASI --}}
                <a href="{{ route('admin.export', 'verifikasi') }}" class="export-card-link">
                    <div class="export-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect><line x1="9" y1="12" x2="15" y2="12"></line><line x1="9" y1="16" x2="13" y2="16"></line></svg>
                    </div>
                    <div class="export-card-body">
                        <div class="export-card-title">Riwayat Verifikasi</div>
                        <div class="export-card-desc">Log keputusan verifikasi admin dan catatan penolakan.</div>
                    </div>
                    <span class="export-card-badge">CSV</span>
                </a>
            </div>
        </section>

        {{-- PENCARIAN & DAFTAR PRESTASI TERBARU (BENTUK LIST, BUKAN TABLE) --}}
        <section class="panel">
            <div class="panel-header">
                <div>
                    <h2>Pengajuan Prestasi Terbaru (5 Teratas)</h2>
                    <p class="panel-description">
                        Menampilkan 5 data pengajuan prestasi paling baru. Gunakan bilah pencarian atau filter di bawah ini untuk menyaring ringkasan data.
                    </p>
                </div>
            </div>

            {{-- SEARCH BAR & FILTER --}}
            <div class="search-filter-box">
                <div class="search-main-row">
                    <div class="search-input-wrap">
                        <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input
                            type="search"
                            id="adminSearchInput"
                            class="search-input"
                            placeholder="Cari nama peserta, NIM/NIP, judul prestasi, penyelenggara, atau prodi..."
                            autocomplete="off"
                        >
                    </div>
                </div>

                <div class="filters-grid">
                    <select id="adminFilterStatus" class="filter-select">
                        <option value="">Semua Status Verifikasi</option>
                        <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="perlu_perbaikan">Perlu Perbaikan</option>
                        <option value="ditolak">Ditolak</option>
                    </select>

                    <select id="adminFilterTingkat" class="filter-select">
                        <option value="">Semua Tingkat Kompetisi</option>
                        @if (isset($tingkats))
                            @foreach ($tingkats as $tingkatItem)
                                <option value="{{ strtolower($tingkatItem->nama_tingkat) }}">
                                    {{ $tingkatItem->nama_tingkat }}
                                </option>
                            @endforeach
                        @endif
                    </select>

                    <select id="adminFilterKategori" class="filter-select">
                        <option value="">Semua Kategori</option>
                        @if (isset($kategoris))
                            @foreach ($kategoris as $kat)
                                <option value="{{ strtolower($kat->nama_kategori) }}">
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        @else
                            <option value="akademik">Akademik</option>
                            <option value="non akademik">Non Akademik</option>
                        @endif
                    </select>

                    <button type="button" id="adminResetFilterBtn" class="filter-reset-btn">
                        Atur Ulang Filter
                    </button>
                </div>
            </div>

            <div class="list-meta-bar" style="display: flex; align-items: center; justify-content: space-between; margin: 16px 4px 10px; font-size: 13px; color: #7B6D8F;">
                <div>
                    Menampilkan <strong id="adminVisibleCount" style="color: var(--purple-dark); font-weight: 800;">{{ min(5, $prestasis->count()) }}</strong> pengajuan terbaru dari {{ $prestasis->count() }} data pengajuan
                </div>
                <small id="adminFilterNote" style="color: var(--gold); font-weight: 700; display: none;">Filter aktif</small>
            </div>

            {{-- DAFTAR PRESTASI TERBARU (TABEL DATA MODERN & RAPI) --}}
            <div class="admin-table-wrapper" id="adminTableWrapper">
                @if (isset($prestasis) && $prestasis->isNotEmpty())
                    <table class="admin-prestasi-table">
                        <thead>
                            <tr>
                                <th style="width: 38%;">Prestasi &amp; Capaian</th>
                                <th style="width: 28%;">Pengaju / Sivitas</th>
                                <th style="width: 18%;">Status Verifikasi</th>
                                <th style="width: 16%; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="adminPrestasiTableBody">
                            @foreach ($prestasis->take(5) as $prestasi)
                                @php
                                    $tingkat = $prestasi->tingkat?->nama_tingkat ?? 'Belum ditentukan';
                                    $kategori = $prestasi->kategori?->nama_kategori ?? 'Umum';
                                    $status = $prestasi->status;

                                    $pengaju = $prestasi->anggota->first(fn ($a) => $a->peran === 'pengaju')
                                        ?? $prestasi->anggota->first();

                                    $namaPengaju = $pengaju?->nama ?? $pengaju?->sivitas?->nama ?? 'Nama Belum Terhubung';
                                    $nimNipPengaju = $pengaju?->nim_nip ?? $pengaju?->sivitas?->user?->nim_nip ?? '—';
                                    $roleSivitas = ucfirst($pengaju?->sivitas?->user?->role ?? $pengaju?->sivitas?->jenis_sivitas ?? 'Sivitas');
                                    $fakultas = $pengaju?->sivitas?->fakultas;
                                    $prodi = $pengaju?->sivitas?->program_studi;

                                    $anggotaList = $prestasi->anggota->map(function ($a) {
                                        $nm = $a->nama ?? $a->sivitas?->nama ?? '';
                                        $id = $a->nim_nip ?? $a->sivitas?->user?->nim_nip ?? '';
                                        return $id ? "{$nm} ({$id})" : $nm;
                                    })->filter()->implode(', ');

                                    $statusLabel = match ($status) {
                                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                        'disetujui' => 'Disetujui',
                                        'ditolak' => 'Ditolak',
                                        'perlu_perbaikan' => 'Perlu Perbaikan',
                                        default => ucfirst($status),
                                    };

                                    $buktiData = $prestasi->bukti->map(function ($b) {
                                        return [
                                            'jenis' => $b->jenis_bukti,
                                            'nama' => $b->nama_file ?: 'Dokumen Bukti',
                                            'url' => \Illuminate\Support\Facades\Storage::disk('public')->url($b->file_path),
                                        ];
                                    })->values();

                                    $searchCorpus = strtolower(
                                        $prestasi->nama_prestasi . ' ' .
                                        $namaPengaju . ' ' .
                                        $nimNipPengaju . ' ' .
                                        $anggotaList . ' ' .
                                        ($prestasi->penyelenggara ?? '') . ' ' .
                                        ($prestasi->peringkat ?? '') . ' ' .
                                        ($prestasi->tahun ?? '') . ' ' .
                                        $tingkat . ' ' .
                                        $kategori . ' ' .
                                        ($fakultas ?? '') . ' ' .
                                        ($prodi ?? '') . ' ' .
                                        $roleSivitas
                                    );

                                    $payload = [
                                        'id' => $prestasi->id,
                                        'nama_prestasi' => $prestasi->nama_prestasi,
                                        'nama_pengaju' => $namaPengaju,
                                        'nim_nip' => $nimNipPengaju,
                                        'role_sivitas' => $roleSivitas,
                                        'prodi' => $prodi,
                                        'fakultas' => $fakultas,
                                        'anggota_list' => $anggotaList,
                                        'tingkat' => $tingkat,
                                        'kategori' => $kategori,
                                        'peringkat' => $prestasi->peringkat ?: '—',
                                        'penyelenggara' => $prestasi->penyelenggara ?: '—',
                                        'tahun' => $prestasi->tahun ?: '—',
                                        'jenis_prestasi' => ucfirst($prestasi->jenis_prestasi ?? 'Individu'),
                                        'deskripsi' => $prestasi->deskripsi,
                                        'status' => $status,
                                        'status_label' => $statusLabel,
                                        'tanggal_pengajuan' => $prestasi->created_at ? $prestasi->created_at->format('d M Y, H:i') : '—',
                                        'bukti' => $buktiData,
                                        'verifikasi_url' => route('admin.verifikasi.index'),
                                    ];
                                @endphp

                                <tr
                                    class="prestasi-row"
                                    data-search="{{ $searchCorpus }}"
                                    data-status="{{ $status }}"
                                    data-tingkat="{{ strtolower($tingkat) }}"
                                    data-kategori="{{ strtolower($kategori) }}"
                                >
                                    {{-- KOLOM 1: PRESTASI & CAPAIAN --}}
                                    <td>
                                        <div class="table-prestasi-title">{{ $prestasi->nama_prestasi }}</div>
                                        <div class="table-prestasi-meta">
                                            @if ($prestasi->peringkat)
                                                <span class="badge-capaian-tag">{{ $prestasi->peringkat }}</span>
                                                <span class="meta-separator">•</span>
                                            @endif
                                            <span>{{ $tingkat }}</span>
                                            <span class="meta-separator">•</span>
                                            <span>{{ $kategori }}</span>
                                            @if ($prestasi->penyelenggara)
                                                <span class="meta-separator">•</span>
                                                <span>{{ $prestasi->penyelenggara }}</span>
                                            @endif
                                            @if ($prestasi->tahun)
                                                <span class="meta-separator">•</span>
                                                <span>Tahun {{ $prestasi->tahun }}</span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- KOLOM 2: PENGAJU / SIVITAS --}}
                                    <td>
                                        <div class="table-user-cell">
                                            <div class="table-avatar" aria-hidden="true">
                                                {{ strtoupper(mb_substr($namaPengaju, 0, 1)) }}
                                            </div>
                                            <div class="table-user-info">
                                                <div class="table-user-name" title="{{ $namaPengaju }}">
                                                    {{ $namaPengaju }}
                                                    @if ($nimNipPengaju && $nimNipPengaju !== '—')
                                                        <span style="font-weight: 500; color: #8F81A3;">({{ $nimNipPengaju }})</span>
                                                    @endif
                                                </div>
                                                <div class="table-user-sub">
                                                    {{ $roleSivitas }}@if ($prodi) · {{ $prodi }} @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- KOLOM 3: STATUS VERIFIKASI (RATA KIRI & SERAGAM) --}}
                                    <td>
                                        <span class="status-badge-modern status-{{ $status }}">
                                            <span class="status-dot"></span>
                                            <span>{{ $statusLabel }}</span>
                                        </span>
                                    </td>

                                    {{-- KOLOM 4: AKSI (RATA KANAN & UKURAN PERSIS SAMA) --}}
                                    <td style="text-align: right;">
                                        @if ($status === 'menunggu_verifikasi')
                                            <button
                                                type="button"
                                                class="btn-row-action highlight"
                                                data-prestasi='@json($payload)'
                                                onclick="openDetailPrestasiModal(this)"
                                                title="Tinjau dan verifikasi pengajuan ini"
                                            >
                                                Tinjau Prestasi →
                                            </button>
                                        @else
                                            <button
                                                type="button"
                                                class="btn-row-action"
                                                data-prestasi='@json($payload)'
                                                onclick="openDetailPrestasiModal(this)"
                                                title="Lihat rincian lengkap pengajuan ini"
                                            >
                                                Lihat Rincian
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <strong>Belum ada data prestasi.</strong> Data prestasi yang tersimpan akan ditampilkan di sini.
                    </div>
                @endif
            </div>

            <div id="adminEmptyState" class="empty-state" style="display: none; margin-top: 14px;">
                <strong>Pencarian Tidak Ditemukan</strong>
                Tidak ada data peserta atau prestasi yang cocok dengan kata kunci dan filter saat ini.
            </div>
        </section>

        {{-- VISUALISASI DATA: GRAFIK BATANG (TREN TAHUNAN) & GRAFIK LINGKARAN (DISTRIBUSI TINGKAT) --}}
        <div class="analytics-grid">
            {{-- GRAFIK BATANG: TREN TAHUNAN --}}
            <section class="panel trend-panel">
                <div class="trend-header">
                    <div>
                        <h2>Perkembangan Prestasi Tahunan</h2>
                        <p class="trend-description">Jumlah prestasi yang disetujui berdasarkan tahun perolehan.</p>
                    </div>
                    <a href="{{ route('admin.export', 'tren-tahunan') }}" class="trend-download-button">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Unduh CSV Tren</span>
                    </a>
                </div>

                @if (isset($trenPrestasi) && $trenPrestasi->isNotEmpty())
                    <div class="trend-legend"><i></i> Jumlah Prestasi Disetujui</div>
                    <div class="trend-chart">
                        <div class="trend-axis">
                            <span>100%</span><span>75%</span><span>50%</span><span>25%</span><span>0</span>
                        </div>
                        <div class="trend-plot">
                            <div class="trend-grid"><span></span><span></span><span></span><span></span><span></span></div>
                            <div class="trend-bars" style="--bar-count: {{ $trenPrestasi->count() }}">
                                @foreach ($trenPrestasi as $item)
                                    @php $tinggiBar = ($item->total / $jumlahMaksimalPrestasi) * 100; @endphp
                                    <div class="trend-bar-group" data-year="{{ $item->tahun }}" data-total="{{ $item->total }}">
                                        <div class="trend-bar-track" title="{{ $item->total }} prestasi pada tahun {{ $item->tahun }}">
                                            <div class="trend-bar" style="height: {{ max(5, $tinggiBar) }}%"></div>
                                        </div>
                                        <span>{{ $item->tahun }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <p class="trend-caption">Grafik menghitung prestasi yang telah disetujui.</p>
                @else
                    <div class="empty-state">
                        Belum ada prestasi disetujui yang memiliki tahun perolehan untuk ditampilkan.
                    </div>
                @endif
            </section>

            {{-- GRAFIK LINGKARAN (BULAT): DISTRIBUSI TINGKAT --}}
            <section class="panel donut-panel">
                <div class="trend-header">
                    <div>
                        <h2>Proporsi Tingkat Prestasi</h2>
                        <p class="trend-description">Distribusi perolehan prestasi sivitas berdasarkan tingkat kejuaraan.</p>
                    </div>
                </div>

                @php
                    $conicStops = [];
                    $currentDeg = 0;
                    if (isset($distribusiTingkat) && $distribusiTingkat->isNotEmpty()) {
                        foreach ($distribusiTingkat as $item) {
                            $deg = ($item['persen'] / 100) * 360;
                            $nextDeg = $currentDeg + $deg;
                            $conicStops[] = "{$item['warna']} {$currentDeg}deg {$nextDeg}deg";
                            $currentDeg = $nextDeg;
                        }
                    }
                    $conicGradient = !empty($conicStops) ? implode(', ', $conicStops) : '#5B3A8E 0deg 360deg';
                @endphp

                @if (isset($distribusiTingkat) && $distribusiTingkat->isNotEmpty())
                    <div class="donut-content-row">
                        <div class="donut-chart-wrap">
                            <div class="donut-pie" style="background: conic-gradient({{ $conicGradient }});">
                                <div class="donut-center">
                                    <span class="donut-center-total">{{ $totalPrestasiDisetujuiTingkat ?? 0 }}</span>
                                    <span class="donut-center-label">Prestasi</span>
                                </div>
                            </div>
                        </div>

                        <div class="donut-legend">
                            @foreach ($distribusiTingkat as $item)
                                <div class="donut-legend-item">
                                    <div class="donut-legend-left">
                                        <span class="donut-legend-dot" style="background: {{ $item['warna'] }};"></span>
                                        <span class="donut-legend-name" title="{{ $item['nama'] }}">{{ $item['nama'] }}</span>
                                    </div>
                                    <div class="donut-legend-right">
                                        <span class="donut-legend-count">{{ $item['total'] }}</span>
                                        <span class="donut-legend-pct">{{ $item['persen'] }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <p class="trend-caption">Diagram proporsi menghitung persebaran tingkat capaian prestasi sivitas.</p>
                @else
                    <div class="empty-state">
                        Belum ada data tingkat prestasi untuk ditampilkan dalam grafik lingkaran.
                    </div>
                @endif
            </section>
        </div>

        <div class="footer-note">
            SIPRESKA &copy; {{ date('Y') }} — Sistem Informasi Pendataan
            dan Pengelolaan Prestasi Sivitas Akademika
        </div>

    </main>
</div>

{{-- MODAL DETAIL PRESTASI (LUAS, LAPANG, BERSIH, TIDAK MEPET) --}}
<div class="modal-overlay" id="modalDetailOverlay" aria-hidden="true">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modalDetailFieldJudul">
        <header class="modal-header">
            <div class="modal-header-main">
                <div class="modal-eyebrow">RINCIAN DATA PRESTASI</div>
                <h3 class="modal-header-title" id="modalDetailFieldJudul">—</h3>
                <div class="modal-header-status" id="modalDetailFieldStatusBadge"></div>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeDetailPrestasiModal()" aria-label="Tutup Rincian">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </header>

        <div class="modal-body">
            {{-- SEKSI 1: PROFIL PENGAJU --}}
            <div class="modal-profile-strip">
                <div class="modal-profile-avatar" id="modalDetailFieldAvatar">S</div>
                <div class="modal-profile-details">
                    <div class="modal-profile-name" id="modalDetailFieldPengajuNama">—</div>
                    <div class="modal-profile-meta" id="modalDetailFieldPengajuMeta">—</div>
                </div>
                <div class="modal-submission-date" id="modalDetailTanggalPengajuan"></div>
            </div>

            {{-- ANGGOTA TIM (JIKA TIM) --}}
            <div class="modal-team-strip" id="modalDetailTeamWrapper" style="display: none;">
                <strong style="color: #6E538E;">Anggota Tim Lainnya:</strong>
                <span id="modalDetailFieldAnggota" style="margin-left: 6px;">—</span>
            </div>

            {{-- SEKSI 2: INFORMASI KOMPETISI & CAPAIAN --}}
            <div class="modal-section-clean">
                <div class="modal-clean-title">Informasi Capaian &amp; Kompetisi</div>
                <div class="modal-clean-grid">
                    <div class="modal-grid-item">
                        <span class="modal-item-label">Capaian / Peringkat</span>
                        <span class="modal-item-val highlight-capaian" id="modalDetailFieldPeringkat">—</span>
                    </div>
                    <div class="modal-grid-item">
                        <span class="modal-item-label">Tingkat Kompetisi</span>
                        <span class="modal-item-val" id="modalDetailFieldTingkat">—</span>
                    </div>
                    <div class="modal-grid-item">
                        <span class="modal-item-label">Kategori Bidang</span>
                        <span class="modal-item-val" id="modalDetailFieldKategori">—</span>
                    </div>
                    <div class="modal-grid-item">
                        <span class="modal-item-label">Penyelenggara</span>
                        <span class="modal-item-val" id="modalDetailFieldPenyelenggara">—</span>
                    </div>
                    <div class="modal-grid-item">
                        <span class="modal-item-label">Tahun Perolehan</span>
                        <span class="modal-item-val" id="modalDetailFieldTahun">—</span>
                    </div>
                    <div class="modal-grid-item">
                        <span class="modal-item-label">Jenis Kepesertaan</span>
                        <span class="modal-item-val" id="modalDetailFieldJenis">—</span>
                    </div>
                </div>
            </div>

            {{-- SEKSI 3: DESKRIPSI KEGIATAN --}}
            <div class="modal-section-clean" id="modalDetailDescWrapper" style="display: none;">
                <div class="modal-clean-title">Deskripsi Kegiatan</div>
                <div class="modal-clean-desc" id="modalDetailFieldDeskripsi"></div>
            </div>

            {{-- SEKSI 4: BERKAS BUKTI PENDUKUNG --}}
            <div class="modal-section-clean">
                <div class="modal-clean-title">Dokumen &amp; Berkas Bukti</div>
                <ul class="modal-evidence-list-spacious" id="modalDetailEvidenceList"></ul>
            </div>
        </div>

        <footer class="modal-footer">
            <button type="button" class="btn-modal-dismiss" onclick="closeDetailPrestasiModal()">
                Tutup Rincian
            </button>
            <a href="#" id="modalDetailBtnVerifikasi" class="btn-modal-action" style="display: none;">
                Buka Halaman Verifikasi &rarr;
            </a>
        </footer>
    </div>
</div>
<script>
    // DROPDOWN EXPORT LOGIC
    const adminExportTrigger = document.getElementById('adminExportDropdownTrigger');
    const adminExportMenu = document.getElementById('adminExportDropdownMenu');

    if (adminExportTrigger && adminExportMenu) {
        adminExportTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            adminExportMenu.classList.toggle('show');
            adminExportTrigger.setAttribute('aria-expanded', adminExportMenu.classList.contains('show'));
        });

        document.addEventListener('click', (e) => {
            if (!adminExportMenu.contains(e.target) && e.target !== adminExportTrigger) {
                adminExportMenu.classList.remove('show');
                adminExportTrigger.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // SEARCH & FILTER LOGIC ON DASHBOARD
    const adminSearch = document.getElementById('adminSearchInput');
    const adminStatus = document.getElementById('adminFilterStatus');
    const adminTingkat = document.getElementById('adminFilterTingkat');
    const adminKategori = document.getElementById('adminFilterKategori');
    const adminReset = document.getElementById('adminResetFilterBtn');
    const adminRows = [...document.querySelectorAll('#adminPrestasiTableBody tr.prestasi-row')];
    const adminEmpty = document.getElementById('adminEmptyState');
    const adminTableWrapper = document.getElementById('adminTableWrapper');

    function filterAdminList() {
        const query = adminSearch ? adminSearch.value.trim().toLowerCase() : '';
        const status = adminStatus ? adminStatus.value : '';
        const tingkat = adminTingkat ? adminTingkat.value : '';
        const kategori = adminKategori ? adminKategori.value : '';

        let count = 0;
        adminRows.forEach((row) => {
            const cSearch = row.dataset.search || '';
            const cStatus = row.dataset.status || '';
            const cTingkat = row.dataset.tingkat || '';
            const cKategori = row.dataset.kategori || '';

            const mSearch = !query || cSearch.includes(query);
            const mStatus = !status || cStatus === status;
            const mTingkat = !tingkat || cTingkat === tingkat;
            const mKategori = !kategori || cKategori === kategori;

            const visible = mSearch && mStatus && mTingkat && mKategori;
            row.style.display = visible ? '' : 'none';
            if (visible) count++;
        });

        if (adminEmpty) {
            adminEmpty.style.display = (adminRows.length > 0 && count === 0) ? 'block' : 'none';
        }
        if (adminTableWrapper) {
            adminTableWrapper.style.display = (adminRows.length > 0 && count === 0) ? 'none' : 'block';
        }

        const visibleCountEl = document.getElementById('adminVisibleCount');
        if (visibleCountEl) {
            visibleCountEl.textContent = count;
        }

        const filterNoteEl = document.getElementById('adminFilterNote');
        if (filterNoteEl) {
            filterNoteEl.style.display = (query || status || tingkat || kategori) ? 'inline-block' : 'none';
        }
    }

    function resetAdminFilter() {
        if (adminSearch) adminSearch.value = '';
        if (adminStatus) adminStatus.value = '';
        if (adminTingkat) adminTingkat.value = '';
        if (adminKategori) adminKategori.value = '';
        filterAdminList();
        if (adminSearch) adminSearch.focus();
    }

    if (adminSearch) adminSearch.addEventListener('input', filterAdminList);
    if (adminStatus) adminStatus.addEventListener('change', filterAdminList);
    if (adminTingkat) adminTingkat.addEventListener('change', filterAdminList);
    if (adminKategori) adminKategori.addEventListener('change', filterAdminList);
    if (adminReset) adminReset.addEventListener('click', resetAdminFilter);

    // MODAL DETAIL PRESTASI LOGIC (LEGA, RAPI, TIDAK MEPET)
    const modalDetailOverlay = document.getElementById('modalDetailOverlay');

    function openDetailPrestasiModal(btn) {
        const raw = btn.getAttribute('data-prestasi');
        if (!raw) return;

        try {
            const data = JSON.parse(raw);

            // Judul Prestasi
            document.getElementById('modalDetailFieldJudul').textContent = data.nama_prestasi || '—';

            // Status Badge
            const statusBadgeContainer = document.getElementById('modalDetailFieldStatusBadge');
            statusBadgeContainer.innerHTML = `
                <span class="status-badge-modern status-${data.status || 'menunggu_verifikasi'}">
                    <span class="status-dot"></span>
                    <span>${escapeHtml(data.status_label)}</span>
                </span>
            `;

            // Field Kompetisi
            document.getElementById('modalDetailFieldTingkat').textContent = data.tingkat || '—';
            document.getElementById('modalDetailFieldKategori').textContent = data.kategori || '—';
            document.getElementById('modalDetailFieldPeringkat').textContent = data.peringkat || '—';
            document.getElementById('modalDetailFieldPenyelenggara').textContent = data.penyelenggara || '—';
            document.getElementById('modalDetailFieldTahun').textContent = data.tahun || '—';
            document.getElementById('modalDetailFieldJenis').textContent = data.jenis_prestasi || '—';

            // Profil Pengaju Utama
            const firstLetter = (data.nama_pengaju && data.nama_pengaju.trim() !== '')
                ? data.nama_pengaju.trim().charAt(0).toUpperCase()
                : 'S';
            document.getElementById('modalDetailFieldAvatar').textContent = firstLetter;

            const pengajuNamaFormatted = `${escapeHtml(data.nama_pengaju || 'Nama Pengaju')}` +
                (data.nim_nip && data.nim_nip !== '—' ? ` <span style="font-weight: 500; color: #7B6D8F;">(${escapeHtml(data.nim_nip)})</span>` : '');
            document.getElementById('modalDetailFieldPengajuNama').innerHTML = pengajuNamaFormatted;

            const metaParts = [];
            if (data.role_sivitas) metaParts.push(escapeHtml(data.role_sivitas));
            if (data.prodi) metaParts.push(escapeHtml(data.prodi));
            if (data.fakultas) metaParts.push(escapeHtml(data.fakultas));
            document.getElementById('modalDetailFieldPengajuMeta').textContent = metaParts.length > 0 ? metaParts.join(' · ') : 'Sivitas Akademika';

            // Anggota Tim
            const teamWrapper = document.getElementById('modalDetailTeamWrapper');
            const anggotaField = document.getElementById('modalDetailFieldAnggota');
            if (data.anggota_list && data.anggota_list.trim() !== '') {
                anggotaField.textContent = data.anggota_list;
                teamWrapper.style.display = 'block';
            } else {
                anggotaField.textContent = 'Individu (Tanpa Anggota Tambahan)';
                teamWrapper.style.display = 'block';
            }

            // Tanggal Pengajuan
            const tglEl = document.getElementById('modalDetailTanggalPengajuan');
            if (tglEl) {
                tglEl.textContent = data.tanggal_pengajuan ? `Diajukan pada: ${data.tanggal_pengajuan}` : '';
            }

            // Deskripsi
            const descWrapper = document.getElementById('modalDetailDescWrapper');
            const descBox = document.getElementById('modalDetailFieldDeskripsi');
            if (data.deskripsi && data.deskripsi.trim() !== '') {
                descBox.textContent = data.deskripsi;
                descWrapper.style.display = 'block';
            } else {
                descWrapper.style.display = 'none';
            }

            // Evidence list
            const evidenceList = document.getElementById('modalDetailEvidenceList');
            evidenceList.innerHTML = '';
            if (data.bukti && data.bukti.length > 0) {
                data.bukti.forEach(b => {
                    const li = document.createElement('li');
                    li.className = 'modal-evidence-item-spacious';
                    li.innerHTML = `
                        <div class="evidence-item-left">
                            <div class="evidence-file-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                            <div>
                                <div class="evidence-file-title">${escapeHtml(b.nama)}</div>
                                <div class="evidence-file-kind">Jenis Berkas: ${escapeHtml(b.jenis)}</div>
                            </div>
                        </div>
                        <a href="${b.url}" target="_blank" rel="noopener noreferrer" class="btn-open-doc">
                            <span>Lihat Berkas</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    `;
                    evidenceList.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.style.color = '#8C7E9E';
                li.style.fontSize = '13px';
                li.style.padding = '12px 14px';
                li.style.background = '#FAF8FE';
                li.style.borderRadius = '8px';
                li.textContent = 'Tidak ada dokumen bukti yang terlampir pada pengajuan ini.';
                evidenceList.appendChild(li);
            }

            // Quick verifikasi button
            const btnVerif = document.getElementById('modalDetailBtnVerifikasi');
            if (data.status === 'menunggu_verifikasi' && data.verifikasi_url) {
                btnVerif.href = data.verifikasi_url;
                btnVerif.style.display = 'inline-flex';
            } else {
                btnVerif.style.display = 'none';
            }

            modalDetailOverlay.classList.add('active');
            modalDetailOverlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        } catch (err) {
            console.error('Gagal membuka rincian prestasi:', err);
        }
    }

    function closeDetailPrestasiModal() {
        if (modalDetailOverlay) {
            modalDetailOverlay.classList.remove('active');
            modalDetailOverlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
    }

    if (modalDetailOverlay) {
        modalDetailOverlay.addEventListener('click', (e) => {
            if (e.target === modalDetailOverlay) {
                closeDetailPrestasiModal();
            }
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeDetailPrestasiModal();
        }
    });

    function escapeHtml(str) {
        if (!str) return '';
        return str
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
</script>
</body>
</html>
