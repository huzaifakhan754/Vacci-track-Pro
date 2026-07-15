<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Booking Rejected — VacciTrack</title>
  <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f7fafc;margin:0;padding:0}
    .container{max-width:680px;margin:28px auto;background:#fff;border-radius:8px;overflow:hidden;border:1px solid #e5e7eb}
    .header{background:#ef4444;color:#fff;padding:18px 24px}
    .logo{font-weight:800;font-size:20px}
    .content{padding:24px;color:#111827}
    .muted{color:#6B7280}
    .details{background:#f9fafb;border:1px solid #eef2f7;padding:14px;border-radius:6px;margin:12px 0}
    .cta{display:inline-block;padding:10px 16px;background:#10B981;color:#fff;border-radius:6px;text-decoration:none}
    .footer{padding:16px;text-align:center;color:#9CA3AF;font-size:13px}
    @media (max-width:480px){.container{margin:12px}} 
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="logo">VacciTrack</div>
    </div>
    <div class="content">
      <h2 style="margin:0 0 6px">Booking request not approved</h2>
      <p class="muted">Hello {{ $parentName }},</p>
      <p>We’re sorry to inform you that your booking request was <strong>rejected</strong>. See details below.</p>

      <div class="details">
        <p><strong>Request ID:</strong> {{ $requestId ?? 'N/A' }}</p>
        <p><strong>Child:</strong> {{ $childName ?? 'N/A' }}</p>
        <p><strong>Vaccine:</strong> {{ $vaccine ?? 'N/A' }}</p>
        <p><strong>Hospital:</strong> {{ $hospital ?? 'N/A' }}</p>
        <p><strong>Preferred Date:</strong> {{ $date ?? 'N/A' }} <strong>Time:</strong> {{ $time ?? 'N/A' }}</p>
      </div>

      @if(!empty($adminNotes))
      <p><strong>Reason:</strong> {{ $adminNotes }}</p>
      @endif

      <p>If you think this is a mistake, please contact support or submit a new request.</p>

      <p style="margin-top:18px"><a href="{{ url('/') }}" class="cta">Open VacciTrack</a></p>
    </div>
    <div class="footer">© {{ date('Y') }} VacciTrack</div>
  </div>
</body>
</html>
