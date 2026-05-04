<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to DataBazaar</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f3f4f6; padding: 40px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #2563eb, #10b981); padding: 40px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 28px; }
        .content { padding: 40px; }
        .content h2 { color: #1e3a8a; }
        .content p { color: #4b5563; line-height: 1.6; }
        .btn { display: inline-block; background: #2563eb; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; margin-top: 20px; }
        .footer { padding: 20px 40px; background: #f9fafb; text-align: center; color: #9ca3af; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 DataBazaar</h1>
            <p>Market Databank Platform</p>
        </div>
        <div class="content">
            <h2>Welcome, {{ $user->name }}! 🎉</h2>
            <p>Thank you for joining DataBazaar — your gateway to market data intelligence.</p>
            <p>With DataBazaar, you can:</p>
            <ul style="color: #4b5563;">
                <li>Submit and track market prices</li>
                <li>Explore data trends across locations</li>
                <li>Export and share market insights</li>
                <li>Analyze price movements with charts</li>
            </ul>
            <a href="{{ url('/dashboard') }}" class="btn">Go to Dashboard →</a>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} DataBazaar. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
