<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #0f0f23; color: #e0e0e0; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #4263eb, #fa5252); padding: 30px; border-radius: 16px 16px 0 0; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 24px; }
        .header p { color: rgba(255,255,255,0.8); margin: 8px 0 0; font-size: 14px; }
        .body { background: #1a1a2e; padding: 30px; border: 1px solid rgba(255,255,255,0.1); }
        .order-details { background: rgba(255,255,255,0.05); border-radius: 12px; padding: 20px; margin: 20px 0; }
        .order-details table { width: 100%; border-collapse: collapse; }
        .order-details td { padding: 8px 0; font-size: 14px; }
        .order-details td:first-child { color: #9e9e9e; }
        .order-details td:last-child { text-align: right; font-weight: 600; }
        .total-row { border-top: 1px solid rgba(255,255,255,0.1); font-size: 18px !important; }
        .total-row td { padding-top: 16px !important; }
        .total-row td:last-child { color: #5c7cfa; }
        .footer { background: #16162a; padding: 20px; border-radius: 0 0 16px 16px; text-align: center; font-size: 12px; color: #666; border: 1px solid rgba(255,255,255,0.1); border-top: 0; }
        .badge { display: inline-block; background: #2e7d32; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛍️ Order Confirmed!</h1>
            <p>Thank you for your purchase, {{ $order->customer_name }}!</p>
        </div>

        <div class="body">
            <p>Hi {{ $order->customer_name }},</p>
            <p>Your order has been confirmed and is being processed. Here are your order details:</p>

            <div class="order-details">
                <table>
                    <tr>
                        <td>Order ID</td>
                        <td>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    <tr>
                        <td>Product</td>
                        <td>{{ $order->product->name }}</td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td>{{ $order->quantity }}</td>
                    </tr>
                    <tr>
                        <td>Price per item</td>
                        <td>₹{{ number_format($order->product->price, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><span class="badge">{{ ucfirst($order->status) }}</span></td>
                    </tr>
                    <tr class="total-row">
                        <td><strong>Total Amount</strong></td>
                        <td>₹{{ number_format($order->total_price, 2) }}</td>
                    </tr>
                </table>
            </div>

            <p style="font-size: 14px; color: #9e9e9e;">
                If you have any questions about your order, feel free to contact us.
            </p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Creator Merch Store. All rights reserved.</p>
            <p>This is an automated email. Please do not reply directly.</p>
        </div>
    </div>
</body>
</html>
