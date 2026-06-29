<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VacciTrack — Official Vaccination Certificate</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* [Aapka purana premium CSS design code jo aapne diya tha, woh poora yahan bilkul wese hi rahega] */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #0d9488; --primary-dark: #0f766e; --primary-darker: #115e59; --primary-light: #99f6e4;
            --primary-subtle: #f0fdfa; --accent: #96c93d; --accent-dark: #65a30d; --slate-900: #0f172a;
            --slate-800: #1e293b; --slate-700: #334155; --slate-600: #475569; --slate-500: #64748b;
            --slate-400: #94a3b8; --slate-300: #cbd5e1; --slate-200: #e2e8f0; --slate-100: #f1f5f9;
            --bg-page: #f8fafc; --white: #ffffff; --success-bg: #f0fdf4; --success-border: #bbf7d0; --success-text: #166534;
            --radius-sm: 6px; --radius-md: 10px; --radius-lg: 16px; --radius-xl: 20px;
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.08), 0 8px 10px -6px rgba(0,0,0,0.04);
        }
        html { font-size: 14px; -webkit-font-smoothing: antialiased; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-page); color: var(--slate-800); padding: 40px 20px; display: flex; flex-direction: column; align-items: center; }
        .action-bar { display: flex; gap: 12px; margin-bottom: 32px; }
        .btn-print { display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: var(--white); border: none; border-radius: 50px; font-size: 0.9rem; font-weight: 600; cursor: pointer; box-shadow: 0 4px 14px rgba(13, 148, 136, 0.35); }
        .certificate-wrapper { width: 210mm; position: relative; animation: fadeInUp 0.5s ease-out; }
        .certificate { background: var(--white); border-radius: var(--radius-xl); box-shadow: var(--shadow-xl); overflow: hidden; position: relative; }
        .certificate::before { content: ''; position: absolute; top: 12px; left: 12px; right: 12px; bottom: 12px; border: 2px solid var(--primary-light); border-radius: var(--radius-lg); opacity: 0.6; pointer-events: none; z-index: 1; }
        .watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg); font-size: 5.5rem; font-weight: 800; color: var(--primary); opacity: 0.025; white-space: nowrap; pointer-events: none; z-index: 0; }
        .cert-header { padding: 36px 48px 28px; display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid var(--primary-light); position: relative; z-index: 2; }
        .logo-container { width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; }
        .logo-container svg { width: 36px; height: 36px; color: var(--white); }
        .brand-text { display: flex; flex-direction: column; margin-left: 16px; }
        .brand-name { font-size: 1.55rem; font-weight: 800; color: var(--primary-dark); }
        .brand-tagline { font-size: 0.7rem; color: var(--slate-500); text-transform: uppercase; letter-spacing: 0.12em; }
        .cert-title { font-size: 1.15rem; font-weight: 700; text-transform: uppercase; text-align: right; }
        .cert-subtitle { font-size: 0.72rem; color: var(--slate-500); text-transform: uppercase; }
        .cert-id-bar { background: linear-gradient(135deg, var(--primary-darker), var(--primary-dark)); padding: 10px 48px; display: flex; justify-content: space-between; color: white; position: relative; z-index: 2; }
        .cert-id { font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; }
        .cert-date-issued { font-size: 0.72rem; }
        .cert-body { padding: 32px 48px; position: relative; z-index: 2; }
        .section { margin-bottom: 28px; }
        .section-label { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
        .section-label h2 { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; }
        .section-label-line { flex: 1; height: 1px; background: linear-gradient(90deg, var(--slate-200), transparent); }
        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .info-item { background: var(--bg-page); border: 1px solid var(--slate-200); border-radius: var(--radius-md); padding: 14px 18px; }
        .info-label { font-size: 0.65rem; font-weight: 600; color: var(--slate-500); text-transform: uppercase; }
        .info-value { font-size: 0.95rem; font-weight: 600; color: var(--slate-800); }
        .divider { height: 1px; background: linear-gradient(90deg, transparent, var(--slate-200), transparent); margin: 28px 0; }
        .table-container { border: 1px solid var(--slate-200); border-radius: var(--radius-md); overflow: hidden; }
        .vax-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        .vax-table thead { background: linear-gradient(135deg, var(--primary-darker), var(--primary-dark)); color: white; }
        .vax-table th { padding: 13px 18px; text-align: left; font-size: 0.7rem; text-transform: uppercase; font-weight: 700; }
        .vax-table td { padding: 14px 18px; border-bottom: 1px solid var(--slate-100); }
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 14px; border-radius: 50px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; background: var(--success-bg); color: var(--success-text); border: 1px solid var(--success-border); }
        .badge-dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; }
        .verification-section { display: grid; grid-template-columns: 1fr auto; gap: 32px; align-items: end; }
        .signature-area { text-align: center; }
        .signature-line { width: 200px; height: 1px; background: var(--slate-400); margin-bottom: 8px; margin-left: auto; margin-right: auto; }
        .signature-name { font-size: 0.78rem; font-weight: 600; }
        .signature-title { font-size: 0.65rem; color: var(--slate-500); }
        .disclaimer { margin-top: 28px; padding: 14px 20px; background: var(--bg-page); border-left: 4px solid var(--primary); font-size: 0.68rem; color: var(--slate-500); border-top: 1px solid var(--slate-200); border-right: 1px solid var(--slate-200); border-bottom: 1px solid var(--slate-200); border-radius: 0 var(--radius-md) var(--radius-md) 0; }
        .cert-footer { background: var(--bg-page); border-top: 1px solid var(--slate-200); padding: 14px 48px; display: flex; justify-content: space-between; font-size: 0.6rem; color: var(--slate-400); }
        @media print { .action-bar { display: none !important; } body { padding: 0 !important; background: white !important; } .certificate-wrapper { width: 100% !important; box-shadow: none !important; } .certificate { border-radius: 0 !important; } }
    </style>
</head>
<body>

    <div class="action-bar">
        <button class="btn-print" onclick="window.print()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18.75 12.75h.008v.008h-.008v-.008zm-3 0h.008v.008h-.008v-.008z"/></svg>
            Print Report
        </button>
    </div>

    <div class="certificate-wrapper">
        <div class="certificate">

            <div class="watermark">VACCI&nbsp;TRACK</div>

            <header class="cert-header">
                <div class="header-left" style="display: flex; align-items: center;">
                    <div class="logo-container">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/></svg>
                    </div>
                    <div class="brand-text">
                        <div class="brand-name">VacciTrack</div>
                        <div class="brand-tagline">Immunization Records System</div>
                    </div>
                </div>
                <div class="header-right">
                    <div class="cert-title">Official Vaccination<br>Report</div>
                    <div class="cert-subtitle">Verified Medical Record</div>
                </div>
            </header>

            <div class="cert-id-bar">
                <div class="cert-id">Report Reference: <span>REPT-{{ str_pad($currentRequest->id, 6, '0', STR_PAD_LEFT) }}</span></div>
                <div class="cert-date-issued">Generated: <strong>{{ \Carbon\Carbon::now()->format('M d, Y') }}</strong></div>
            </div>

            <div class="cert-body">

                <div class="section">
                    <div class="section-label">
                        <h2>Child &amp; Parent Information</h2>
                        <div class="section-label-line"></div>
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Child's Full Name</div>
                            <div class="info-value text-capitalize">{{ $child->name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Date of Birth</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($child->dob)->format('M d, Y') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Gender</div>
                            <div class="info-value text-capitalize">{{ $child->gender ?? 'N/A' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Parent / Guardian Name</div>
                            <div class="info-value text-capitalize">{{ auth()->user()->name }}</div>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="section">
                    <div class="section-label">
                        <h2>Completed Vaccination Details</h2>
                        <div class="section-label-line"></div>
                    </div>
                    <div class="table-container">
                        <table class="vax-table">
                            <thead>
                                <tr>
                                    <th>Vaccine Name</th>
                                    <th>Date Administered</th>
                                    <th>Authorized Hospital Center</th>
                                    <th style="text-align: center;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- 🔥 Dynamic Loop: Bache ki jitni completed/vaccinated vaccines hain wo sab yahan ayengi --}}
                                @forelse($allVaccines as $vax)
                                <tr>
                                    <td>
                                        <strong style="color: var(--slate-800);">{{ $vax->vaccine->name }}</strong>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($vax->updated_at)->format('M d, Y') }}
                                    </td>
                                    <td>
                                        {{ $vax->hospital->name ?? 'Registered Medical Center' }}
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="badge"><span class="badge-dot"></span>Vaccinated</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; color: var(--slate-500); padding: 20px;">
                                        No completed vaccinations found for this report.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="section" style="margin-bottom: 0;">
                    <div class="verification-section">
                        <div style="color: var(--slate-500); font-size: 0.75rem;">
                            <p style="margin-bottom: 4px;"><strong>Verification Notice:</strong></p>
                            <p>This document presents a comprehensive record of all successful immunizations registered under VacciTrack system for the respective infant. Hospitals can verify this checklist directly in the database logs using the reference ID given above.</p>
                        </div>
                        
                        <div class="signature-area">
                            <div class="signature-line"></div>
                            <div class="signature-name">VacciTrack Registrar</div>
                            <div class="signature-title">Official Electronic Health Record</div>
                        </div>
                    </div>
                </div>

                <div class="disclaimer">
                    <p>
                        <strong>Disclaimer:</strong> This is an electronically generated digital statement from <strong>VacciTrack</strong> portal. It fetches accurate live data records directly from secure clinic logs and does not require manual hardware stamping for general verification purposes. Any fake replication or unauthorized tamper attempts are strictly punishable under IT and healthcare regulations.
                    </p>
                </div>

            </div><footer class="cert-footer">
                <div>
                    © {{ date('Y') }} VacciTrack — National Immunization Registry Management
                </div>
                <div>Official Record Page 1 of 1</div>
            </footer>

        </div></div></body>
</html>