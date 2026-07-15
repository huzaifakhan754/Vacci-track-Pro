<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VacciTrack — Official Vaccination Certificate</title>
    <style>
        /* PDF and Print Page Standard */
        @page {
            size: A4 portrait;
            margin: 0; /* Zero margin for precise DOMPDF body rendering */
        }
        * {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }
        html, body {
            margin: 0;
            padding: 0;
            background-color: #0b0f19;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #f1f5f9;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        body {
            padding: 30px; /* Safe padding for browser view */
        }
        
        /* Main Certificate Box - Fully DomPDF and Screen Safe */
        .certificate {
            background-color: #0f172a;
            border: 3px solid #0d9488;
            border-radius: 12px;
            padding: 30px;
            /* Using width auto with margins prevents the DomPDF right-side cut off bug */
            width: auto; 
            margin: 0 auto;
            max-width: 850px;
            min-height: 90vh; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        /* Header Layout */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .logo-box {
            width: 50px;
            height: 50px;
            background-color: #0d9488;
            border-radius: 8px;
            text-align: center;
            line-height: 46px; /* Vertical align replacement for DomPDF */
            border: 2px solid #2dd4bf;
        }
        .logo-text {
            color: #ffffff;
            font-size: 26px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
        .brand-name {
            font-size: 22px;
            font-weight: bold;
            color: #2dd4bf;
            padding-left: 15px;
            margin: 0;
            display: inline-block;
        }
        .brand-tagline {
            font-size: 9px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-left: 15px;
            display: inline-block;
        }
        .cert-title-cell {
            text-align: right;
            vertical-align: middle;
        }
        .cert-title {
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            color: #ffffff;
            margin: 0;
        }
        .cert-subtitle {
            font-size: 9px;
            color: #2dd4bf;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Reference Bar Table */
        .cert-id-bar {
            background-color: #115e59;
            border: 1px solid #0d9488;
            color: #ffffff;
            width: 100%;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }
        .cert-id-table {
            width: 100%;
            border-collapse: collapse;
        }
        .cert-id-text {
            font-family: Courier, monospace;
            font-size: 13px;
            color: #2dd4bf;
            font-weight: bold;
        }
        .cert-date-text {
            text-align: right;
            font-size: 12px;
            color: #cbd5e1;
        }

        /* Section Titles */
        .section-label {
            margin-bottom: 10px;
            border-bottom: 2px solid #0d9488;
            padding-bottom: 5px;
        }
        .section-label h2 {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #2dd4bf;
            margin: 0;
        }

        /* Info Grid Table */
        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px;
            margin-left: -8px;
            margin-right: -8px;
            margin-bottom: 20px;
        }
        .info-cell {
            width: 50%;
            background-color: #1e293b;
            border: 1px solid #334155;
            border-top: 3px solid #0d9488;
            border-radius: 6px;
            padding: 10px 15px;
        }
        .info-label {
            font-size: 8.5px;
            font-weight: bold;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 13px;
            font-weight: bold;
            color: #ffffff;
            text-transform: capitalize;
        }

        .divider {
            height: 1px;
            background-color: #334155;
            margin: 15px 0;
        }

        /* Vaccine Records Table */
        .vax-table-container {
            border: 1.5px solid #0d9488;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .vax-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #1e293b;
        }
        .vax-table th {
            background-color: #0f766e;
            color: #ffffff;
            padding: 10px 12px;
            font-size: 9.5px;
            text-transform: uppercase;
            font-weight: bold;
            text-align: left;
            border-bottom: 2px solid #0d9488;
        }
        .vax-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #334155;
            font-size: 11.5px;
            color: #cbd5e1;
        }
        .vax-table tr:last-child td {
            border-bottom: none;
        }

        /* Badge */
        .badge {
            background-color: #022c22;
            color: #4ade80;
            border: 1px solid #22c55e;
            padding: 2px 7px;
            border-radius: 8px;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Verification Row */
        .footer-layout-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .notice-cell {
            width: 65%;
            font-size: 10px;
            color: #94a3b8;
            vertical-align: top;
            padding-right: 15px;
            line-height: 1.4;
        }
        .signature-cell {
            width: 35%;
            text-align: center;
            vertical-align: top;
        }
        .signature-line {
            border-top: 1px solid #0d9488;
            width: 140px;
            margin: 15px auto 4px auto;
        }
        .signature-name {
            font-size: 11px;
            font-weight: bold;
            color: #ffffff;
        }
        .signature-title {
            font-size: 8px;
            color: #2dd4bf;
        }

        /* Disclaimer Box */
        .disclaimer {
            margin-top: 15px;
            margin-bottom: 25px;
            padding: 10px 15px;
            background-color: #1e293b;
            border-left: 3.5px solid #2dd4bf;
            border-top: 1px solid #334155;
            border-right: 1px solid #334155;
            border-bottom: 1px solid #334155;
            border-radius: 6px;
            font-size: 9px;
            color: #94a3b8;
            line-height: 1.4;
        }

        /* Document Footer */
        .cert-footer {
            border-top: 1px solid #334155;
            padding-top: 10px;
            font-size: 9px;
            color: #64748b;
            width: 100%;
            display: block;
        }
        .footer-left { float: left; }
        .footer-right { float: right; }
        .clearfix { clear: both; }

        /* Print Override */
        @media print {
            body {
                padding: 1.5cm; /* Uses perfect margin during download/print */
                background-color: #0b0f19 !important;
            }
            .certificate {
                width: 100%;
                min-height: 100%;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>

    <div class="certificate">

        <div class="main-content">
            
            <table class="header-table">
                <tr>
                    <td style="width: 55px; vertical-align: middle;">
                        <div class="logo-box">
                            <span class="logo-text">V</span>
                        </div>
                    </td>
                    <td style="vertical-align: middle;">
                        <span class="brand-name">VacciTrack</span><br>
                        <span class="brand-tagline">Immunization Records System</span>
                    </td>
                    <td class="cert-title-cell">
                        <span class="cert-title">Official Vaccination Report</span><br>
                        <span class="cert-subtitle">Verified Medical Record</span>
                    </td>
                </tr>
            </table>

            <div class="cert-id-bar">
                <table class="cert-id-table">
                    <tr>
                        <td class="cert-id-text">
                            Report Reference: REPT-{{ str_pad($currentRequest->id, 6, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="cert-date-text">
                            Generated: <strong>{{ \Carbon\Carbon::now()->format('M d, Y') }}</strong>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="section-label">
                <h2>Child &amp; Parent Information</h2>
            </div>
            
            <table class="info-table">
                <tr>
                    <td class="info-cell">
                        <div class="info-label">Child's Full Name</div>
                        <div class="info-value">{{ $child->name }}</div>
                    </td>
                    <td class="info-cell">
                        <div class="info-label">Date of Birth</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($child->dob)->format('M d, Y') }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="info-cell">
                        <div class="info-label">Gender</div>
                        <div class="info-value">{{ $child->gender ?? 'N/A' }}</div>
                    </td>
                    <td class="info-cell">
                        <div class="info-label">Parent / Guardian Name</div>
                        <div class="info-value">{{ auth()->user()->name }}</div>
                    </td>
                </tr>
            </table>

            <div class="divider"></div>

            <div class="section-label">
                <h2>Completed Vaccination Details</h2>
            </div>

            <div class="vax-table-container">
                <table class="vax-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Vaccine Name</th>
                            <th style="width: 25%;">Date Administered</th>
                            <th style="width: 30%;">Authorized Hospital Center</th>
                            <th style="width: 15%; text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allVaccines as $vax)
                        <tr>
                            <td><strong style="color: #ffffff;">{{ $vax->vaccine->name }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($vax->updated_at)->format('M d, Y') }}</td>
                            <td>{{ $vax->hospital->name ?? 'Registered Medical Center' }}</td>
                            <td style="text-align: center;">
                                <span class="badge">Vaccinated</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #94a3b8; padding: 14px;">
                                No completed vaccinations found for this report.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>

            <table class="footer-layout-table">
                <tr>
                    <td class="notice-cell">
                        <p style="margin-top: 0; margin-bottom: 4px; color: #ffffff;"><strong>Verification Notice:</strong></p>
                        <p style="margin: 0;">This document presents a comprehensive record of all successful immunizations registered under VacciTrack system. Hospital administrators can verify this checklist directly in logs using the reference ID.</p>
                    </td>
                    <td class="signature-cell">
                        <div class="signature-line"></div>
                        <div class="signature-name">VacciTrack Registrar</div>
                        <div class="signature-title">Official Electronic Health Record</div>
                    </td>
                </tr>
            </table>

            <div class="disclaimer">
                <p style="margin: 0;">
                    <strong>Disclaimer:</strong> This is an electronically generated digital statement from <strong>VacciTrack</strong>. It fetches accurate live data records directly from secure logs and does not require manual hardware stamping.
                </p>
            </div>

        </div>

        <div class="cert-footer">
            <div class="footer-left">
                © {{ date('Y') }} VacciTrack — National Immunization Registry Management
            </div>
            <div class="footer-right">Official Record Page 1 of 1</div>
            <div class="clearfix"></div>
        </div>

    </div>

</body>
</html>