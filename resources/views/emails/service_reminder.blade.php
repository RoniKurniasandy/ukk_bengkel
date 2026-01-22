<!DOCTYPE html>
<html>
<head>
    <title>Pengingat Servis Berkala</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
        <h2 style="color: #1e3a8a; text-align: center;">Kings Bengkel Mobil</h2>
        
        <p>Halo, <strong>{{ $user->nama }}</strong>!</p>
        
        <p>Kami ingin mengingatkan bahwa kendaraan Anda:</p>
        
        <div style="background-color: #f8fafc; padding: 15px; border-radius: 8px; margin: 15px 0;">
            <p style="margin: 5px 0;"><strong>Merk:</strong> {{ $kendaraan->merk }}</p>
            <p style="margin: 5px 0;"><strong>Model:</strong> {{ $kendaraan->model }}</p>
            <p style="margin: 5px 0;"><strong>Plat Nomor:</strong> {{ $kendaraan->plat_nomor }}</p>
        </div>

        <p>Sudah waktunya untuk melakukan pengecekan rutin atau ganti oli (3 bulan sejak servis terakhir). Perawatan berkala sangat penting untuk menjaga performa dan umur kendaraan Anda.</p>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('landing') }}" style="background-color: #3b82f6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Booking Servis Sekarang</a>
        </div>
        
        <p style="margin-top: 30px; font-size: 0.9em; color: #666;">
            Terima kasih telah mempercayakan kendaraan Anda kepada kami.<br>
            <em>Salam hangat, Tim Kings Bengkel Mobil.</em>
        </p>
    </div>
</body>
</html>
