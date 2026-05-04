<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Submission Confirmation</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f3f4f6; padding: 40px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #2563eb, #10b981); padding: 30px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 40px; }
        .content h2 { color: #1e3a8a; }
        .content p { color: #4b5563; line-height: 1.6; }
        .details { background: #f0f9ff; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .details table { width: 100%; border-collapse: collapse; }
        .details td { padding: 8px 0; color: #374151; }
        .details td:first-child { font-weight: 600; width: 120px; }
        .badge { display: inline-block; background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .footer { padding: 20px 40px; background: #f9fafb; text-align: center; color: #9ca3af; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Data Submitted Successfully</h1>
        </div>
        <div class="content">
            <h2>Submission Confirmed ✅</h2>
            <p>Your market data has been submitted and is <span class="badge">Pending Review</span></p>

            <div class="details">
                <table>
                    <tr><td>Product:</td><td>{{ $marketData->product_name }}</td></tr>
                    <tr><td>Price:</td><td>₹{{ number_format($marketData->price, 2) }}</td></tr>
                    <tr><td>Location:</td><td>{{ $marketData->location }}</td></tr>
                    <tr><td>Date:</td><td>{{ $marketData->date->format('d M Y') }}</td></tr>
                </table>
            </div>

            <p>An admin will review your submission shortly. Once approved, it will be visible on the public dashboard.</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} DataBazaar. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
