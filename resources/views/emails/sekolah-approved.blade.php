<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Disetujui</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
            border-top: none;
        }
        .info-box {
            background-color: white;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #4CAF50;
        }
        .credentials {
            background-color: #e8f5e9;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .credentials strong {
            color: #2e7d32;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>✅ Selamat! Akun Anda Telah Disetujui</h1>
    </div>
    
    <div class="content">
        <p>Kepada Yth,<br>
        <strong>{{ $sekolah->nama_sekolah }}</strong></p>
        
        <p>Selamat! Kami dengan senang hati memberitahukan bahwa pendaftaran akun sekolah Anda di <strong>Sistem Informasi Penjaminan Mutu</strong> telah <strong>disetujui</strong>.</p>
        
        <div class="info-box">
            <h3>Informasi Akun:</h3>
            <table style="width: 100%;">
                <tr>
                    <td><strong>Nama Sekolah</strong></td>
                    <td>: {{ $sekolah->nama_sekolah }}</td>
                </tr>
                <tr>
                    <td><strong>NPSN</strong></td>
                    <td>: {{ $sekolah->npsn }}</td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td>: {{ $sekolah->email_belajar_id }}</td>
                </tr>
            </table>
        </div>
        
        <div class="credentials">
            <h3>Kredensial Login:</h3>
            <p>
                <strong>Username:</strong> {{ $sekolah->npsn }}<br>
                <strong>Password:</strong> {{ $sekolah->npsn }}
            </p>
            <p style="color: #d32f2f; font-size: 14px;">
                ⚠️ <em>Segera ubah password Anda setelah login pertama kali untuk keamanan akun.</em>
            </p>
        </div>
        
        <p>Anda sekarang dapat login dan mendaftarkan sekolah Anda ke berbagai kegiatan yang tersedia di sistem.</p>
        
        <center>
            <a href="{{ url('/login') }}" class="button">Login Sekarang</a>
        </center>
        
        <p>Jika Anda mengalami kesulitan atau memiliki pertanyaan, silakan hubungi administrator sistem.</p>
        
        <p>Terima kasih,<br>
        <strong>Tim Sistem Informasi Penjaminan Mutu</strong></p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} Sistem Informasi Penjaminan Mutu. All rights reserved.</p>
    </div>
</body>
</html>
