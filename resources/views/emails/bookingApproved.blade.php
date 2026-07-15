<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Booking Approved — VacciTrack</title>
  <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f7fafc;margin:0;padding:0}
    .container{max-width:680px;margin:28px auto;background:#fff;border-radius:8px;overflow:hidden;border:1px solid #e5e7eb}
    .header{background:#10B981;color:#fff;padding:18px 24px}
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
      <h2 style="margin:0 0 6px">Your booking has been approved</h2>
      <p class="muted">Hello {{ $parentName }},</p>
      <p>Good news — your booking request has been <strong>approved</strong>. Below are your booking details.</p>

      <div class="details">
        <p><strong>Booking ID:</strong> {{ $bookingId ?? 'N/A' }}</p>
        <p><strong>Child:</strong> {{ $childName ?? 'N/A' }}</p>
        <p><strong>Vaccine:</strong> {{ $vaccine ?? 'N/A' }}</p>
        <p><strong>Hospital:</strong> {{ $hospital ?? 'N/A' }}</p>
        <p><strong>Date:</strong> {{ $date ?? 'N/A' }} <strong>Time:</strong> {{ $time ?? 'N/A' }}</p>
      </div>

      @if(!empty($adminNotes))
      <p><strong>Note from admin:</strong> {{ $adminNotes }}</p>
      @endif

      <p>If you need to reschedule or have questions, please reply to this email or visit your account.</p>

      <p style="margin-top:18px"><a href="{{ url('/') }}" class="cta">Open VacciTrack</a></p>
    </div>
    <div class="footer">© {{ date('Y') }} VacciTrack — keeping children safe</div>
  </div>
</body>
</html>
