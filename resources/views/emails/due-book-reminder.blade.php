<!DOCTYPE html>
<html>
<head>
    <title>Nhắc nhở trả sách</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nhắc nhở trả sách</h1>
        </div>
        <div class="content">
            <p>Xin chào {{ $user->name }},</p>
            <p>Bạn có sách <strong>"{{ $book->title }}"</strong> sắp đến hạn trả vào ngày <strong>{{ $dueDate->format('d/m/Y') }}</strong>.</p>
            <p>Vui lòng trả sách đúng hạn để tránh phí phạt.</p>
            <p>Trân trọng,</p>
            <p>Thư viện</p>
        </div>
        <div class="footer">
            <p>Đây là email tự động, vui lòng không trả lời.</p>
        </div>
    </div>
</body>
</html>