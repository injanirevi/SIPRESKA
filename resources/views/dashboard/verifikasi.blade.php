<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Prestasi | SIPRESKA</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar,
        .sidebar * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        :root {
            --purple: #5B3A8E;
            --purple-dark: #432765;
            --gold: #C9A227;
            --text: #30283D;
            --muted: #81788F;
            --border: #EAE4F1;
            --green: #27834a;
            --amber: #b5830e;
            --red: #c0392b;
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
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR ADMIN */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 250px;
            height: 100vh;
            padding: 28px 20px;
            background: rgba(255,255,255,.98);
            border-right: 1px solid var(--border);
            z-index: 100;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            box-shadow: 5px 0 25px rgba(67,39,101,.035);
        }

        .logo {
            padding: 0 10px;
            font-size: 25px;
            font-weight: 800;
            background: linear-gradient(90deg,#8058B8,#5B3A8E,#432765);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .logo small {
            display: block;
            margin-top: 7px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 400;
            line-height: 1.6;
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
            padding: 11px 14px;
            border: 1px solid transparent;
            border-radius: 10px;
            color: #655B73;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.5;
            transition: all .2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu a:hover {
            background: #FAF7FD;
            color: var(--purple);
            transform: translateX(3px);
        }

        .menu a.active {
            background: linear-gradient(135deg, #F3ECF9 0%, #EDE1F7 100%);
            border-color: #E2D1F3;
            color: var(--purple);
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(91, 58, 142, 0.08);
        }

        .menu-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            color: inherit;
        }

        .menu a.active .menu-icon {
            color: var(--purple);
        }

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
            padding-top: 24px;
        }

        .logout button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #F5D3D3;
            border-radius: 10px;
            background: #FFF5F5;
            color: #B91C1C;
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s ease;
        }

        .logout button:hover {
            background: #FEE2E2;
            border-color: #F87171;
            transform: translateY(-1px);
        }

        .logout button:hover {
            background: #FCF1F3;
        }

        /* KONTEN */
        .content {
            width: calc(100% - 250px);
            min-width: 0;
            margin-left: 250px;
            padding: 36px 40px;
        }

        /* BANNER HALAMAN */
        .header {
            margin-bottom: 24px;
            padding: 24px 28px;
            border: 1px solid #E4D7F2;
            border-left: 5px solid var(--gold);
            border-radius: 15px;
            background: linear-gradient(115deg,#fff,#F0E7FB 55%,#E5D6F6);
            box-shadow: 0 8px 25px rgba(67,39,101,.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .header-content {
            max-width: 650px;
        }

        .eyebrow {
            margin-bottom: 9px;
            color: #8864B1;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        h1 {
            margin: 0 0 8px;
            color: var(--purple-dark);
            font-size: 26px;
        }

        .header p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .header-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 9px;
            background: #FFFFFF;
            border: 1px solid #D9C8ED;
            color: var(--purple);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(67,39,101,.06);
            transition: transform .15s, background .2s;
        }

        .header-btn:hover {
            transform: translateY(-2px);
            background: #F4EDFA;
        }

        /* NOTICES */
        .notice {
            margin-bottom: 20px;
            padding: 14px 17px;
            border: 1px solid #D7C8E9;
            border-radius: 10px;
            background: #F8F4FF;
            color: var(--purple-dark);
            font-size: 13px;
            overflow-wrap: anywhere;
        }

        .notice.success {
            border-color: #B7D9BE;
            background: #F1FAF2;
            color: #28623A;
        }

        .notice.error {
            border-color: #E8C3C7;
            background: #FFF4F4;
            color: #963944;
        }

        /* SEARCH BAR & FILTER */
        .search-box {
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 16px 18px;
            margin-bottom: 20px;
            box-shadow: 0 4px 14px rgba(67,39,101,.03);
        }

        .search-row {
            display: grid;
            grid-template-columns: minmax(220px, 2fr) minmax(180px, 1fr) auto;
            gap: 12px;
            align-items: center;
        }

        .search-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-icon-svg {
            position: absolute;
            left: 14px;
            color: #8C7C9E;
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1px solid #DDD1EA;
            border-radius: 9px;
            background: #FFFFFF;
            color: var(--text);
            font-size: 13px;
        }

        .search-input:focus {
            outline: 0;
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(91,58,142,.1);
        }

        .filter-select {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #DDD1EA;
            border-radius: 9px;
            background: #FFFFFF;
            color: var(--text);
            font-size: 12px;
            cursor: pointer;
        }

        .filter-select:focus {
            outline: 0;
            border-color: var(--purple);
        }

        .reset-btn {
            padding: 11px 16px;
            border: 1px solid #E5DBF0;
            border-radius: 9px;
            background: #FFFFFF;
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, color .2s;
            white-space: nowrap;
        }

        .reset-btn:hover {
            background: #FFF1F2;
            color: #B64B57;
        }

        .list-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 14px;
        }

        .list-heading {
            margin: 0;
            color: var(--purple-dark);
            font-size: 18px;
            font-weight: 800;
        }

        .counter-pill {
            padding: 5px 12px;
            border-radius: 20px;
            background: #F3EDFC;
            color: var(--purple);
            font-size: 12px;
            font-weight: 700;
        }

        /* COMPACT QUEUE TABLE */
        .table-responsive {
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(67,39,101,.04);
            margin-bottom: 28px;
        }

        .queue-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 12px;
        }

        .queue-table thead {
            background: #FAF7FD;
            border-bottom: 1px solid var(--border);
        }

        .queue-table th {
            padding: 14px 16px;
            color: var(--purple-dark);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .queue-table tbody tr {
            border-bottom: 1px solid #F2ECF7;
            transition: background .15s;
        }

        .queue-table tbody tr:hover {
            background: #FAF8FE;
        }

        .queue-table tbody tr:last-child {
            border-bottom: none;
        }

        .queue-table td {
            padding: 14px 16px;
            vertical-align: middle;
            color: var(--text);
        }

        .cell-index {
            color: var(--muted);
            font-weight: 600;
            width: 45px;
            text-align: center;
        }

        .cell-date {
            color: var(--muted);
            font-size: 11px;
            white-space: nowrap;
        }

        .cell-main {
            min-width: 260px;
        }

        .cell-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--purple-dark);
            line-height: 1.4;
            margin-bottom: 4px;
            overflow-wrap: anywhere;
        }

        .cell-subline {
            font-size: 11px;
            color: var(--muted);
            line-height: 1.5;
        }

        .cell-subline strong {
            color: #524765;
            font-weight: 600;
        }

        .badge-pill-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
            align-items: flex-start;
        }

        .badge-tag {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-tag.tingkat {
            background: #EFE8F9;
            color: var(--purple);
        }

        .badge-tag.kategori {
            background: #F4F1F8;
            color: #6C6080;
            border: 1px solid #EAE3F2;
        }

        .cell-capaian {
            font-weight: 700;
            color: var(--purple-dark);
            font-size: 12px;
            margin-bottom: 2px;
        }

        .cell-penyelenggara {
            font-size: 11px;
            color: var(--muted);
            overflow-wrap: anywhere;
        }

        .badge-evidence {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 9px;
            border-radius: 6px;
            background: #F7F3FC;
            border: 1px solid #EAE1F5;
            color: var(--purple);
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .btn-review-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 14px;
            border-radius: 8px;
            background: linear-gradient(135deg, #7A53B3, #5B3A8E);
            color: #FFFFFF;
            font-size: 11px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(91,58,142,.15);
            transition: background .2s, transform .15s, box-shadow .2s;
            white-space: nowrap;
        }

        .btn-review-action:hover {
            background: var(--purple-dark);
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(91,58,142,.25);
        }

        .empty-state {
            padding: 45px 20px;
            border: 1px dashed #D7C8E9;
            border-radius: 14px;
            background: #FCFAFE;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
            text-align: center;
            margin-bottom: 24px;
        }

        .empty-state h2 {
            color: var(--purple-dark);
            font-size: 18px;
            margin: 0 0 8px;
        }

        /* STATUS BADGE MODERN DENGAN DOT */
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

        /* MODAL TELAAH & VERIFIKASI (LUAS, LAPANG, BERSIH, TIDAK MEPET) */
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

        /* MODAL DECISION FORM */
        .modal-decision-box {
            background: #FAF7FE;
            border: 1px solid #E3D7F0;
            border-radius: 14px;
            padding: 22px 24px;
        }

        .decision-box-header {
            margin-bottom: 14px;
        }

        .decision-box-title {
            font-size: 13px;
            font-weight: 800;
            color: #352152;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 4px;
        }

        .decision-box-sub {
            font-size: 11.5px;
            color: #7C6E90;
            line-height: 1.5;
        }

        .decision-label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            color: #5B4775;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .modal-textarea {
            width: 100%;
            min-height: 85px;
            padding: 12px 14px;
            border: 1px solid #D5C7E6;
            border-radius: 10px;
            background: #FFFFFF;
            font-size: 13px;
            color: var(--text);
            resize: vertical;
            line-height: 1.55;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        .modal-textarea:focus {
            outline: 0;
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(91,58,142,.1);
        }

        .decision-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-decision {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s ease;
        }

        .btn-decision-reject {
            padding: 10px 22px;
            font-size: 12.5px;
            background: #FDF2F2;
            color: #DC2626;
            border: 1px solid #FACDCD;
        }

        .btn-decision-reject:hover {
            background: #FEE2E2;
            border-color: #F87171;
            transform: translateY(-1px);
        }

        .btn-decision-approve {
            padding: 10px 24px;
            font-size: 12.5px;
            background: linear-gradient(135deg, #10B981, #059669);
            color: #FFFFFF;
            border: none;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }

        .btn-decision-approve:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
        }
        /* RESPONSIVE */
        @media (max-width: 950px) {
            .sidebar {
                width: 210px;
                padding: 24px 14px;
            }

            .content {
                width: calc(100% - 210px);
                margin-left: 210px;
                padding: 25px 20px;
            }

            .search-row {
                grid-template-columns: 1fr;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 720px) {
            .layout { display: block; }
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: 0;
                padding: 20px;
            }
            .content {
                width: 100%;
                margin: 0;
                padding: 20px 16px;
            }
            .table-responsive {
                border-radius: 10px;
                overflow-x: auto;
            }
            .queue-table th, .queue-table td {
                padding: 10px 12px;
            }
            .decision-actions {
                width: 100%;
                flex-direction: column;
            }
            .btn-decision {
                width: 100%;
                text-align: center;
            }
        }

        /* MODERN SIPRESKA CONFIRMATION & ALERT DIALOG */
        .sipreska-dialog-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(36, 27, 49, 0.72);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 2500;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .sipreska-dialog-backdrop.active {
            display: flex;
            animation: dialogFadeIn .2s ease-out;
        }

        @keyframes dialogFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes dialogPopIn {
            from { opacity: 0; transform: scale(0.92) translateY(8px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .sipreska-dialog-card {
            background: #FFFFFF;
            border-radius: 20px;
            width: 100%;
            max-width: 440px;
            padding: 30px 26px 26px;
            box-shadow: 0 25px 50px -12px rgba(45, 27, 78, 0.35), 0 0 0 1px rgba(138, 99, 210, 0.15);
            text-align: center;
            animation: dialogPopIn .25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        .sipreska-dialog-icon-wrap {
            width: 62px;
            height: 62px;
            border-radius: 50%;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s ease;
        }

        .sipreska-dialog-icon-wrap.approve {
            background: #ECFDF5;
            color: #10B981;
            box-shadow: 0 0 0 8px #F0FDF4;
        }

        .sipreska-dialog-icon-wrap.reject {
            background: #FEF2F2;
            color: #EF4444;
            box-shadow: 0 0 0 8px #FFF1F2;
        }

        .sipreska-dialog-icon-wrap.warning {
            background: #FFFBEB;
            color: #F59E0B;
            box-shadow: 0 0 0 8px #FEF3C7;
        }

        .sipreska-dialog-title {
            font-size: 19px;
            font-weight: 800;
            color: #2D1B4E;
            margin: 0 0 8px;
            letter-spacing: -0.3px;
        }

        .sipreska-dialog-message {
            font-size: 13.5px;
            color: #64748B;
            line-height: 1.55;
            margin: 0 0 16px;
        }

        .sipreska-dialog-note-preview {
            background: #F8FAFC;
            border: 1px dashed #CBD5E1;
            border-radius: 12px;
            padding: 12px 14px;
            text-align: left;
            margin-bottom: 20px;
        }

        .sipreska-dialog-note-label {
            display: block;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748B;
            margin-bottom: 4px;
        }

        .sipreska-dialog-note-text {
            font-size: 12.5px;
            color: #334155;
            margin: 0;
            line-height: 1.45;
            word-break: break-word;
            font-style: italic;
        }

        .sipreska-dialog-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .sipreska-btn-cancel {
            flex: 1;
            padding: 12px 18px;
            border-radius: 10px;
            border: 1px solid #E2E8F0;
            background: #F8FAFC;
            color: #475569;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s ease;
        }

        .sipreska-btn-cancel:hover {
            background: #E2E8F0;
            color: #1E293B;
        }

        .sipreska-btn-confirm {
            flex: 1.2;
            padding: 12px 20px;
            border-radius: 10px;
            border: none;
            font-size: 13px;
            font-weight: 700;
            color: #FFFFFF;
            cursor: pointer;
            transition: all .15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .sipreska-btn-confirm.approve {
            background: linear-gradient(135deg, #10B981, #059669);
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
        }

        .sipreska-btn-confirm.approve:hover {
            filter: brightness(1.06);
            transform: translateY(-1px);
        }

        .sipreska-btn-confirm.reject {
            background: linear-gradient(135deg, #EF4444, #DC2626);
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);
        }

        .sipreska-btn-confirm.reject:hover {
            filter: brightness(1.06);
            transform: translateY(-1px);
        }

        .sipreska-btn-confirm.warning {
            background: linear-gradient(135deg, #F59E0B, #D97706);
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
        }

        .sipreska-btn-confirm.warning:hover {
            filter: brightness(1.06);
            transform: translateY(-1px);
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
            <a href="{{ route('dashboard') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </span>
                Dashboard
            </a>

            <a href="{{ route('admin.prestasi.index') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                </span>
                Daftar Prestasi
            </a>

            <a href="{{ route('admin.verifikasi.index') }}" class="active" aria-current="page">
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
            <a href="{{ route('superadmin.users.index') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </span>
                Manajemen Akun
            </a>
            @endif

            <a href="{{ route('admin.panduan') }}">
                <span class="menu-icon" aria-hidden="true">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </span>
                Panduan Penggunaan
            </a>
        </nav>

        <div class="logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    <span>Keluar dari Akun</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- KONTEN VERIFIKASI --}}
    <main class="content">

        <header class="header">
            <div class="header-content">
                <div class="eyebrow">PENGELOLAAN DATA PRESTASI</div>
                <h1>Verifikasi Prestasi</h1>
                <p>
                    Periksa data pengajuan, dokumen bukti pendukung, dan simpan keputusan verifikasi prestasi sivitas akademika secara cepat dan terstruktur.
                </p>
            </div>

            <a href="{{ route('admin.export', 'prestasi-menunggu') }}" class="header-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                <span>Unduh CSV Antrean Verifikasi</span>
            </a>
        </header>

        @if (session('success'))
            <div class="notice success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="notice error">
                {{ session('error') }}
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="notice error">
                <strong>Periksa kembali:</strong>
                <ul style="margin: 6px 0 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- SEARCH BAR & FILTER --}}
        <div class="search-box">
            <div class="search-row">
                <div class="search-input-wrap">
                    <svg class="search-icon-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input
                        type="search"
                        id="verifikasiSearchInput"
                        class="search-input"
                        placeholder="Cari judul prestasi, pengaju, NIM/NIP, prodi, atau penyelenggara..."
                        autocomplete="off"
                    >
                </div>

                <select id="verifikasiFilterTingkat" class="filter-select">
                    <option value="">Semua Tingkat Kompetisi</option>
                    @php
                        $tingkatList = $prestasis->map(fn($p) => $p->tingkat?->nama_tingkat)->filter()->unique();
                    @endphp
                    @foreach ($tingkatList as $tingkatNama)
                        <option value="{{ strtolower($tingkatNama) }}">{{ $tingkatNama }}</option>
                    @endforeach
                </select>

                <button type="button" id="verifikasiResetBtn" class="reset-btn">
                    Atur Ulang
                </button>
            </div>
        </div>

        <div class="list-header-row">
            <h2 class="list-heading">
                Antrean Pengajuan Menunggu Keputusan
            </h2>
            <span class="counter-pill">
                Menampilkan <strong id="verifikasiVisibleCount">{{ $prestasis->count() }}</strong> antrean pengajuan
            </span>
        </div>

        {{-- COMPACT QUEUE TABLE --}}
        @if ($prestasis->isNotEmpty())
            <div class="table-responsive">
                <table class="queue-table">
                    <thead>
                        <tr>
                            <th class="cell-index">#</th>
                            <th>Tanggal</th>
                            <th>Prestasi &amp; Pengaju</th>
                            <th>Tingkat &amp; Kategori</th>
                            <th>Capaian &amp; Penyelenggara</th>
                            <th>Dokumen Bukti</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="verifikasiTableBody">
                        @foreach ($prestasis as $prestasi)
                            @php
                                $tingkat = $prestasi->tingkat?->nama_tingkat ?? 'Belum ditentukan';
                                $kategori = $prestasi->kategori?->nama_kategori ?? 'Umum';

                                $pengaju = $prestasi->anggota->first(fn ($a) => $a->peran === 'pengaju')
                                    ?? $prestasi->anggota->first();

                                $namaPengaju = $pengaju?->nama ?? $pengaju?->sivitas?->nama ?? 'Nama Belum Terhubung';
                                $nimNipPengaju = $pengaju?->nim_nip ?? $pengaju?->sivitas?->user?->nim_nip ?? '—';
                                $roleSivitas = ucfirst($pengaju?->sivitas?->user?->role ?? $pengaju?->sivitas?->jenis_sivitas ?? 'Sivitas');
                                $prodi = $pengaju?->sivitas?->program_studi;
                                $fakultas = $pengaju?->sivitas?->fakultas;

                                $anggotaList = $prestasi->anggota->map(function ($a) {
                                    $nm = $a->nama ?? $a->sivitas?->nama ?? '';
                                    $id = $a->nim_nip ?? $a->sivitas?->user?->nim_nip ?? '';
                                    return $id ? "{$nm} ({$id})" : $nm;
                                })->filter()->implode(', ');

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
                                    ($prodi ?? '') . ' ' .
                                    ($fakultas ?? '')
                                );

                                // Dokumen bukti array untuk JSON Modal
                                $buktiData = $prestasi->bukti->map(function ($b) {
                                    return [
                                        'jenis' => $b->jenis_bukti,
                                        'nama' => $b->nama_file ?: 'Dokumen Bukti',
                                        'url' => \Illuminate\Support\Facades\Storage::disk('public')->url($b->file_path),
                                    ];
                                })->values();

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
                                    'tanggal_pengajuan' => $prestasi->created_at ? $prestasi->created_at->format('d M Y, H:i') : '—',
                                    'bukti' => $buktiData,
                                    'action_url' => route('admin.verifikasi.update', $prestasi),
                                ];
                            @endphp

                            <tr
                                class="queue-row"
                                data-search="{{ $searchCorpus }}"
                                data-tingkat="{{ strtolower($tingkat) }}"
                            >
                                <td class="cell-index">{{ $loop->iteration }}</td>
                                <td class="cell-date">
                                    {{ $prestasi->created_at ? $prestasi->created_at->format('d M Y') : '—' }}
                                </td>
                                <td class="cell-main">
                                    <div class="cell-title">{{ $prestasi->nama_prestasi }}</div>
                                    <div class="cell-subline">
                                        <strong>{{ $namaPengaju }}</strong> ({{ $nimNipPengaju }})
                                        &bull; {{ $roleSivitas }}
                                        @if ($prodi) &bull; {{ $prodi }} @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="badge-pill-group">
                                        <span class="badge-tag tingkat">{{ $tingkat }}</span>
                                        <span class="badge-tag kategori">{{ $kategori }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="cell-capaian">
                                        {{ $prestasi->peringkat ?: 'Tercatat' }}
                                        @if($prestasi->tahun) ({{ $prestasi->tahun }}) @endif
                                    </div>
                                    <div class="cell-penyelenggara">{{ $prestasi->penyelenggara ?: '—' }}</div>
                                </td>
                                <td>
                                    <span class="badge-evidence">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                        {{ $prestasi->bukti->count() }} Berkas
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <button
                                        type="button"
                                        class="btn-review-action"
                                        data-prestasi='@json($payload)'
                                        onclick="openReviewModal(this)"
                                    >
                                        Telaah &amp; Verifikasi
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <h2>Antrean Verifikasi Bersih</h2>
                <p>
                    Saat ini tidak ada pengajuan prestasi yang menunggu keputusan. Pengajuan baru dari sivitas akademika akan secara otomatis tampil di sini.
                </p>
            </div>
        @endif

        <div id="verifikasiEmptySearch" class="empty-state" style="display: none;">
            <h2>Pencarian Tidak Ditemukan</h2>
            <p>Tidak ada pengajuan verifikasi yang cocok dengan kata kunci atau filter pencarian saat ini.</p>
        </div>

    </main>
</div>


{{-- CUSTOM CONFIRMATION & ALERT DIALOG (MODERN SIPRESKA) --}}
<div class="sipreska-dialog-backdrop" id="sipreskaConfirmModal" aria-hidden="true" style="display:none;">
    <div class="sipreska-dialog-card" role="alertdialog" aria-modal="true" aria-labelledby="sipreskaDialogTitle">
        <div class="sipreska-dialog-icon-wrap" id="sipreskaDialogIconWrap">
            {{-- Dynamic SVG Icon --}}
        </div>
        <div class="sipreska-dialog-content">
            <h4 class="sipreska-dialog-title" id="sipreskaDialogTitle">Konfirmasi</h4>
            <p class="sipreska-dialog-message" id="sipreskaDialogMessage">Pesan konfirmasi</p>
            <div class="sipreska-dialog-note-preview" id="sipreskaDialogNotePreview" style="display:none;">
                <span class="sipreska-dialog-note-label">Catatan Verifikator:</span>
                <p class="sipreska-dialog-note-text" id="sipreskaDialogNoteText"></p>
            </div>
        </div>
        <div class="sipreska-dialog-actions" id="sipreskaDialogActions">
            <button type="button" class="sipreska-btn-cancel" id="sipreskaDialogBtnCancel" onclick="closeSipreskaDialog()">Batal</button>
            <button type="button" class="sipreska-btn-confirm" id="sipreskaDialogBtnConfirm">Lanjutkan</button>
        </div>
    </div>
</div>

{{-- MODAL TELAAH & VERIFIKASI (LUAS, LAPANG, BERSIH, TIDAK MEPET) --}}
<div class="modal-overlay" id="modalReviewOverlay" aria-hidden="true">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modalPrestasiJudul">
        <header class="modal-header">
            <div class="modal-header-main">
                <div class="modal-eyebrow">TELAAH &amp; VERIFIKASI PRESTASI</div>
                <h3 class="modal-header-title" id="modalPrestasiJudul">—</h3>
                <div class="modal-header-status">
                    <span class="status-badge-modern status-menunggu_verifikasi">
                        <span class="status-dot"></span>
                        <span>Menunggu Verifikasi</span>
                    </span>
                </div>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeReviewModal()" aria-label="Tutup Modal">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </header>

        <div class="modal-body">
            {{-- SEKSI 1: PROFIL PENGAJU UTAMA --}}
            <div class="modal-profile-strip">
                <div class="modal-profile-avatar" id="modalFieldPengajuAvatar">S</div>
                <div class="modal-profile-details">
                    <div class="modal-profile-name" id="modalFieldPengajuNama">—</div>
                    <div class="modal-profile-meta" id="modalFieldPengajuMeta">—</div>
                </div>
                <div class="modal-submission-date" id="modalFieldTanggal"></div>
            </div>

            {{-- ANGGOTA TIM (JIKA TIM) --}}
            <div class="modal-team-strip" id="modalTeamWrapper" style="display: none;">
                <strong style="color: #6E538E;">Anggota Tim Lainnya:</strong>
                <span id="modalFieldAnggota" style="margin-left: 6px;">—</span>
            </div>

            {{-- SEKSI 2: INFORMASI KOMPETISI & CAPAIAN --}}
            <div class="modal-section-clean">
                <div class="modal-clean-title">Informasi Capaian &amp; Kompetisi</div>
                <div class="modal-clean-grid">
                    <div class="modal-grid-item">
                        <span class="modal-item-label">Capaian / Peringkat</span>
                        <span class="modal-item-val highlight-capaian" id="modalFieldPeringkat">—</span>
                    </div>
                    <div class="modal-grid-item">
                        <span class="modal-item-label">Tingkat Kompetisi</span>
                        <span class="modal-item-val" id="modalFieldTingkat">—</span>
                    </div>
                    <div class="modal-grid-item">
                        <span class="modal-item-label">Kategori Bidang</span>
                        <span class="modal-item-val" id="modalFieldKategori">—</span>
                    </div>
                    <div class="modal-grid-item">
                        <span class="modal-item-label">Penyelenggara</span>
                        <span class="modal-item-val" id="modalFieldPenyelenggara">—</span>
                    </div>
                    <div class="modal-grid-item">
                        <span class="modal-item-label">Tahun Perolehan</span>
                        <span class="modal-item-val" id="modalFieldTahun">—</span>
                    </div>
                    <div class="modal-grid-item">
                        <span class="modal-item-label">Jenis Kepesertaan</span>
                        <span class="modal-item-val" id="modalFieldJenis">—</span>
                    </div>
                </div>
            </div>

            {{-- SEKSI 3: DESKRIPSI KEGIATAN --}}
            <div class="modal-section-clean" id="modalDescWrapper" style="display: none;">
                <div class="modal-clean-title">Deskripsi Kegiatan</div>
                <div class="modal-clean-desc" id="modalFieldDeskripsi"></div>
            </div>

            {{-- SEKSI 4: BERKAS BUKTI LAMPIRAN --}}
            <div class="modal-section-clean">
                <div class="modal-clean-title">Dokumen Bukti Lampiran</div>
                <ul class="modal-evidence-list-spacious" id="modalEvidenceList">
                    {{-- Diisi via JavaScript --}}
                </ul>
            </div>

            {{-- SEKSI 5: FORM KEPUTUSAN VERIFIKASI --}}
            <form id="modalDecisionForm" method="POST" action="">
                @csrf
                @method('PATCH')

                <div class="modal-decision-box">
                    <div class="decision-box-header">
                        <div class="decision-box-title">Form Keputusan Verifikasi Admin</div>
                        <div class="decision-box-sub">Tentukan persetujuan atau penolakan pengajuan prestasi ini. Wajib mengisi catatan jika ditolak.</div>
                    </div>

                    <label for="modalCatatan" class="decision-label">Catatan Verifikasi</label>
                    <textarea
                        id="modalCatatan"
                        name="catatan"
                        class="modal-textarea"
                        placeholder="Tuliskan catatan verifikasi atau alasan penolakan untuk pengaju..."
                    ></textarea>

                    <div class="decision-actions">
                        <button
                            type="button"
                            class="btn-decision btn-decision-reject"
                            onclick="submitDecision('ditolak')"
                        >
                            Tolak Pengajuan
                        </button>

                        <button
                            type="button"
                            class="btn-decision btn-decision-approve"
                            onclick="submitDecision('disetujui')"
                        >
                            Setujui Prestasi
                        </button>
                    </div>

                    <input type="hidden" name="status" id="modalStatusInput" value="">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // MODAL STATE & HANDLERS
    const modalOverlay = document.getElementById('modalReviewOverlay');
    const modalForm = document.getElementById('modalDecisionForm');
    const modalStatusInput = document.getElementById('modalStatusInput');
    const modalCatatan = document.getElementById('modalCatatan');

    function openReviewModal(btn) {
        const raw = btn.getAttribute('data-prestasi');
        if (!raw) return;

        try {
            const data = JSON.parse(raw);

            // Populate form action
            modalForm.action = data.action_url;
            modalStatusInput.value = '';
            modalCatatan.value = '';
            modalCatatan.style.borderColor = '#D5C7E6';

            // Populate fields
            document.getElementById('modalPrestasiJudul').textContent = data.nama_prestasi || '—';

            // Profil Pengaju
            const firstLetter = (data.nama_pengaju && data.nama_pengaju.trim() !== '')
                ? data.nama_pengaju.trim().charAt(0).toUpperCase()
                : 'S';
            document.getElementById('modalFieldPengajuAvatar').textContent = firstLetter;

            const pengajuFormatted = `${escapeHtml(data.nama_pengaju || 'Nama Pengaju')}` +
                (data.nim_nip && data.nim_nip !== '—' ? ` <span style="font-weight: 500; color: #7B6D8F;">(${escapeHtml(data.nim_nip)})</span>` : '');
            document.getElementById('modalFieldPengajuNama').innerHTML = pengajuFormatted;

            const metaParts = [];
            if (data.role_sivitas) metaParts.push(escapeHtml(data.role_sivitas));
            if (data.prodi) metaParts.push(escapeHtml(data.prodi));
            if (data.fakultas) metaParts.push(escapeHtml(data.fakultas));
            document.getElementById('modalFieldPengajuMeta').textContent = metaParts.length > 0 ? metaParts.join(' · ') : 'Sivitas Akademika';

            const tglEl = document.getElementById('modalFieldTanggal');
            if (tglEl) {
                tglEl.textContent = data.tanggal_pengajuan ? `Diajukan: ${data.tanggal_pengajuan}` : '';
            }

            // Anggota Tim
            const teamWrapper = document.getElementById('modalTeamWrapper');
            const anggotaField = document.getElementById('modalFieldAnggota');
            if (data.anggota_list && data.anggota_list.trim() !== '') {
                anggotaField.textContent = data.anggota_list;
                teamWrapper.style.display = 'block';
            } else {
                teamWrapper.style.display = 'none';
            }

            // Grid Kompetisi
            document.getElementById('modalFieldPeringkat').textContent = data.peringkat || '—';
            document.getElementById('modalFieldTingkat').textContent = data.tingkat || '—';
            document.getElementById('modalFieldKategori').textContent = data.kategori || '—';
            document.getElementById('modalFieldPenyelenggara').textContent = data.penyelenggara || '—';
            document.getElementById('modalFieldTahun').textContent = data.tahun || '—';
            document.getElementById('modalFieldJenis').textContent = data.jenis_prestasi || '—';

            // Deskripsi
            const descWrapper = document.getElementById('modalDescWrapper');
            const descBox = document.getElementById('modalFieldDeskripsi');
            if (data.deskripsi && data.deskripsi.trim() !== '') {
                descBox.textContent = data.deskripsi;
                descWrapper.style.display = 'block';
            } else {
                descWrapper.style.display = 'none';
            }

            // Evidence list
            const evidenceList = document.getElementById('modalEvidenceList');
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
                                <div class="evidence-file-kind">Berkas Bukti (${escapeHtml(b.jenis)})</div>
                            </div>
                        </div>
                        <a href="${b.url}" target="_blank" rel="noopener noreferrer" class="btn-open-doc">
                            <span>Buka Dokumen</span>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    `;
                    evidenceList.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.style.color = '#8C7E9E';
                li.style.fontSize = '12.5px';
                li.style.padding = '12px 16px';
                li.textContent = 'Tidak ada berkas dokumen bukti yang terlampir.';
                evidenceList.appendChild(li);
            }

            // Show modal
            modalOverlay.classList.add('active');
            modalOverlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        } catch (err) {
            console.error('Gagal membuka telaah verifikasi:', err);
        }
    }

    function closeReviewModal() {
        modalOverlay.classList.remove('active');
        modalOverlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
            closeReviewModal();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modalOverlay.classList.contains('active')) {
            closeReviewModal();
        }
    });

    // CUSTOM MODERN CONFIRMATION & ALERT MODAL LOGIC
    const dialogModal = document.getElementById('sipreskaConfirmModal');
    const dialogIconWrap = document.getElementById('sipreskaDialogIconWrap');
    const dialogTitle = document.getElementById('sipreskaDialogTitle');
    const dialogMessage = document.getElementById('sipreskaDialogMessage');
    const dialogNotePreview = document.getElementById('sipreskaDialogNotePreview');
    const dialogNoteText = document.getElementById('sipreskaDialogNoteText');
    const dialogBtnCancel = document.getElementById('sipreskaDialogBtnCancel');
    const dialogBtnConfirm = document.getElementById('sipreskaDialogBtnConfirm');

    let onConfirmCallback = null;

    function closeSipreskaDialog() {
        if (!dialogModal) return;
        dialogModal.classList.remove('active');
        dialogModal.style.display = 'none';
        dialogModal.setAttribute('aria-hidden', 'true');
        onConfirmCallback = null;
    }

    if (dialogBtnConfirm) {
        dialogBtnConfirm.addEventListener('click', () => {
            if (typeof onConfirmCallback === 'function') {
                const cb = onConfirmCallback;
                closeSipreskaDialog();
                cb();
            } else {
                closeSipreskaDialog();
            }
        });
    }

    if (dialogModal) {
        dialogModal.addEventListener('click', (e) => {
            if (e.target === dialogModal) {
                closeSipreskaDialog();
            }
        });
    }

    function showSipreskaConfirm({ type, title, message, note, confirmText, onConfirm }) {
        if (!dialogModal) return;

        onConfirmCallback = onConfirm;

        // Reset classes
        dialogIconWrap.className = 'sipreska-dialog-icon-wrap ' + type;
        dialogBtnConfirm.className = 'sipreska-btn-confirm ' + type;
        dialogBtnCancel.style.display = 'inline-block';

        // Set Icon
        if (type === 'approve') {
            dialogIconWrap.innerHTML = '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
        } else if (type === 'reject') {
            dialogIconWrap.innerHTML = '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';
        } else {
            dialogIconWrap.innerHTML = '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';
        }

        // Set Text
        dialogTitle.textContent = title;
        dialogMessage.textContent = message;
        dialogBtnConfirm.textContent = confirmText || 'Lanjutkan';

        // Set Note Preview
        if (note && note.trim() !== '') {
            dialogNoteText.textContent = note.trim();
            dialogNotePreview.style.display = 'block';
        } else {
            dialogNotePreview.style.display = 'none';
        }

        dialogModal.style.display = 'flex';
        // force reflow
        void dialogModal.offsetWidth;
        dialogModal.classList.add('active');
        dialogModal.setAttribute('aria-hidden', 'false');
    }

    function showSipreskaAlert({ type, title, message, buttonText }) {
        if (!dialogModal) return;

        onConfirmCallback = null;

        dialogIconWrap.className = 'sipreska-dialog-icon-wrap ' + (type || 'warning');
        dialogBtnConfirm.className = 'sipreska-btn-confirm ' + (type || 'warning');
        dialogBtnCancel.style.display = 'none';

        dialogIconWrap.innerHTML = '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';

        dialogTitle.textContent = title;
        dialogMessage.textContent = message;
        dialogBtnConfirm.textContent = buttonText || 'Mengerti';
        dialogNotePreview.style.display = 'none';

        dialogModal.style.display = 'flex';
        void dialogModal.offsetWidth;
        dialogModal.classList.add('active');
        dialogModal.setAttribute('aria-hidden', 'false');
    }

    function submitDecision(status) {
        modalStatusInput.value = status;
        const note = modalCatatan.value.trim();

        if (status === 'ditolak' && note === '') {
            modalCatatan.style.borderColor = '#EF4444';
            modalCatatan.focus();
            showSipreskaAlert({
                type: 'warning',
                title: 'Catatan Penolakan Wajib Diisi',
                message: 'Harap berikan penjelasan atau alasan penolakan pada kolom catatan verifikasi agar pengaju dapat mengetahui bagian yang perlu diperbaiki.',
                buttonText: 'Mengerti & Tulis Catatan'
            });
            return;
        }

        if (status === 'disetujui') {
            showSipreskaConfirm({
                type: 'approve',
                title: 'Setujui Pengajuan Prestasi?',
                message: 'Pengajuan prestasi ini akan divalidasi sebagai capaian sah dan otomatis ditampilkan pada daftar prestasi terverifikasi serta portofolio sivitas.',
                note: note,
                confirmText: 'Ya, Setujui Prestasi',
                onConfirm: () => {
                    modalForm.submit();
                }
            });
        } else {
            showSipreskaConfirm({
                type: 'reject',
                title: 'Tolak Pengajuan Prestasi?',
                message: 'Pengajuan prestasi ini akan ditolak. Pengaju akan menerima status ditolak beserta catatan alasan penolakan yang Anda cantumkan.',
                note: note,
                confirmText: 'Ya, Tolak Pengajuan',
                onConfirm: () => {
                    modalForm.submit();
                }
            });
        }
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // SEARCH & FILTER LOGIC
    const vSearch = document.getElementById('verifikasiSearchInput');
    const vFilterTingkat = document.getElementById('verifikasiFilterTingkat');
    const vReset = document.getElementById('verifikasiResetBtn');
    const vRows = [...document.querySelectorAll('#verifikasiTableBody .queue-row')];
    const vEmptySearch = document.getElementById('verifikasiEmptySearch');
    const vCount = document.getElementById('verifikasiVisibleCount');

    function filterVerifikasiTable() {
        const query = vSearch ? vSearch.value.trim().toLowerCase() : '';
        const tingkat = vFilterTingkat ? vFilterTingkat.value : '';

        let matched = 0;
        vRows.forEach((row) => {
            const cSearch = row.dataset.search || '';
            const cTingkat = row.dataset.tingkat || '';

            const mSearch = !query || cSearch.includes(query);
            const mTingkat = !tingkat || cTingkat === tingkat;

            const visible = mSearch && mTingkat;
            row.style.display = visible ? '' : 'none';
            if (visible) matched++;
        });

        if (vCount) vCount.textContent = matched;
        if (vEmptySearch) {
            vEmptySearch.style.display = (vRows.length > 0 && matched === 0) ? 'block' : 'none';
        }
    }

    if (vSearch) vSearch.addEventListener('input', filterVerifikasiTable);
    if (vFilterTingkat) vFilterTingkat.addEventListener('change', filterVerifikasiTable);
    if (vReset) {
        vReset.addEventListener('click', () => {
            if (vSearch) vSearch.value = '';
            if (vFilterTingkat) vFilterTingkat.value = '';
            filterVerifikasiTable();
            if (vSearch) vSearch.focus();
        });
    }
</script>
</body>
</html>
