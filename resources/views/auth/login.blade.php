<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Kings Bengkel Mobil</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, rgba(30, 58, 138, 0.95) 0%, rgba(59, 130, 246, 0.9) 100%),
        url('{{ asset("image/uploaded_image_1764054764874.jpg") }}');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      position: relative;
    }

    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.3);
      z-index: 0;
    }

    .login-container {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 450px;
      padding: 20px;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 25px;
      padding: 3rem 2.5rem;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .brand-logo {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #3b82f6, #1e40af);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      font-size: 2.5rem;
      color: #fff;
    }

    .login-title {
      font-size: 2rem;
      font-weight: 700;
      color: #1e3a8a;
      text-align: center;
      margin-bottom: 0.5rem;
    }

    .login-subtitle {
      text-align: center;
      color: #64748b;
      margin-bottom: 2rem;
      font-size: 0.95rem;
    }

    .form-label {
      font-weight: 600;
      color: #1e3a8a;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
    }

    .form-control {
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      padding: 0.75rem 1rem;
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .input-icon {
      position: relative;
    }

    .input-icon i {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 1.1rem;
    }

    .btn-login {
      background: linear-gradient(135deg, #3b82f6, #1e40af);
      color: #fff;
      font-weight: 600;
      padding: 0.85rem 2rem;
      border-radius: 12px;
      border: none;
      width: 100%;
      font-size: 1rem;
      transition: all 0.3s ease;
      margin-top: 1rem;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
    }

    .form-check-input:checked {
      background-color: #3b82f6;
      border-color: #3b82f6;
    }

    .register-link {
      text-align: center;
      margin-top: 1.5rem;
      color: #64748b;
      font-size: 0.9rem;
    }

    .register-link a {
      color: #3b82f6;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .register-link a:hover {
      color: #1e40af;
      text-decoration: underline;
    }

    .alert {
      border-radius: 12px;
      border: none;
      margin-bottom: 1.5rem;
    }

    .divider {
      text-align: center;
      margin: 1.5rem 0;
      position: relative;
    }

    .divider::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 1px;
      background: #e2e8f0;
    }

    .divider span {
      background: rgba(255, 255, 255, 0.95);
      padding: 0 1rem;
      color: #94a3b8;
      font-size: 0.85rem;
      position: relative;
    }

    @media (max-width: 576px) {
      .login-card {
        padding: 2rem 1.5rem;
      }

      .login-title {
        font-size: 1.5rem;
      }
    }
  </style>
  <!-- Google reCAPTCHA -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>


<body>

  <div class="login-container">
    <div class="login-card">
      <div class="brand-logo">
        <i class="bi bi-tools"></i>
      </div>
      <h1 class="login-title">Selamat Datang!</h1>
      <p class="login-subtitle">Masuk ke akun Anda untuk melanjutkan</p>

      @if ($errors->any())
        <div class="alert alert-danger">
          <i class="bi bi-exclamation-circle me-2"></i>
          <strong>Oops!</strong> Terjadi kesalahan:
          <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
          <label for="login" class="form-label">Email atau Nomor HP</label>
          <div class="input-icon">
            <input id="login" name="login" type="text" value="{{ old('login') }}" required autofocus
              class="form-control" placeholder="nama@email.com atau 0812...">
            <i class="bi bi-person"></i>
          </div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <input id="password" name="password" type="password" required class="form-control"
              placeholder="Masukkan password" style="border-right: none;">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border: 2px solid #e2e8f0; border-left: none; border-radius: 0 12px 12px 0; background: #fff;">
              <i class="bi bi-eye-slash" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember" style="color: #64748b; font-size: 0.9rem;">
              Ingat saya
            </label>
          </div>
          <a href="{{ route('password.request') }}" style="color: #3b82f6; font-size: 0.9rem; text-decoration: none;">Lupa password?</a>
        </div>

        <div class="mb-3 d-flex justify-content-center">
            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
        </div>

        <button type="submit" class="btn btn-login">
          <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
        </button>
      </form>

      <div class="register-link">
        Belum punya akun?
        <a href="{{ route('register') }}">Daftar sekarang</a>
      </div>

      <div class="divider">
        <span>atau kembali ke</span>
      </div>

      <div class="text-center">
        <a href="{{ route('landing') }}"
          style="color: #3b82f6; text-decoration: none; font-weight: 500; font-size: 0.9rem;">
          <i class="bi bi-house-door me-1"></i>Halaman Utama
        </a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function() {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      eyeIcon.classList.toggle('bi-eye');
      eyeIcon.classList.toggle('bi-eye-slash');
    });
  </script>

</body>

</html>