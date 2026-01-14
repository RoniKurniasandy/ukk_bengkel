<h1>Reset Password</h1>

Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.

<p>
    Silakan klik link di bawah ini untuk meriset password Anda:
    <br>
    <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}">Reset Password</a>
</p>

Kalimat ini akan kadaluarsa dalam 60 menit.

Jika Anda tidak merasa melakukan permintaan ini, abaikan saja email ini.
