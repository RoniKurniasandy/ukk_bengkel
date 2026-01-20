<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kings Bengkel Mobil - Servis Berkualitas, Harga Terjangkau</title>

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
            overflow-x: hidden;
        }

        html {
            scroll-behavior: smooth;
        }

        /* Navbar */
        .navbar-custom {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .navbar-custom.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #fff !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            color: #fff !important;
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: #fbbf24;
            transition: width 0.3s ease;
        }

        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 80%;
        }

        .btn-login {
            background: #fbbf24;
            color: #1e3a8a;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            border: 2px solid #fbbf24;
        }

        .btn-login:hover {
            background: transparent;
            color: #fbbf24;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(251, 191, 36, 0.3);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,144C960,149,1056,139,1152,122.7C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            background-position: bottom;
        }

        .hero-content {
            position: relative;
            z-index: 10;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .hero p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .btn-hero {
            background: #fbbf24;
            color: #1e3a8a;
            font-weight: 600;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(251, 191, 36, 0.3);
        }

        .btn-hero:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(251, 191, 36, 0.5);
            background: #f59e0b;
        }

        .hero-image {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Features Section */
        .features {
            padding: 5rem 0;
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #fbbf24);
            border-radius: 2px;
        }

        .section-subtitle {
            color: #64748b;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }

        .feature-card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: #3b82f6;
            box-shadow: 0 15px 40px rgba(59, 130, 246, 0.2);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: #fff;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: rotate(360deg);
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 1rem;
        }

        .feature-text {
            color: #64748b;
            line-height: 1.6;
        }

        /* Services Section */
        .services {
            padding: 5rem 0;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: #fff;
        }

        .services .section-title {
            color: #fff;
        }

        .services .section-subtitle {
            color: rgba(255, 255, 255, 0.9);
        }

        .service-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2.5rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            height: 100%;
        }

        .service-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-10px);
            border-color: #fbbf24;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .service-icon {
            width: 70px;
            height: 70px;
            background: #fbbf24;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #1e3a8a;
            margin-bottom: 1.5rem;
        }

        .service-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .service-description {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .service-price {
            font-size: 1.75rem;
            font-weight: 700;
            color: #fbbf24;
        }

        /* Contact Section */
        .contact {
            padding: 5rem 0;
            background: #f8fafc;
        }

        .contact-card {
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: #eff6ff;
            transform: translateX(10px);
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #fff;
            flex-shrink: 0;
        }

        .contact-info h5 {
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 0.25rem;
        }

        .contact-info p {
            color: #64748b;
            margin: 0;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: #fff;
            padding: 2rem 0;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }
        }

        /* Fix for Scrollspy and Fixed Navbar */
        section {
            scroll-margin-top: 100px;
        }
    </style>
</head>

<body class="position-relative">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-tools"></i>
                Kings Bengkel Mobil
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                style="background: #fff;">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Keunggulan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('login') }}" class="btn btn-login">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1>Bengkel Mobil Terpercaya di Indonesia</h1>
                    <p>Servis berkualitas dengan teknisi berpengalaman, harga terjangkau, dan layanan cepat. Jadikan
                        mobil Anda selalu prima!</p>
                    <a href="#services" class="btn btn-hero">
                        <i class="bi bi-arrow-right-circle me-2"></i>Lihat Layanan Kami
                    </a>
                </div>
                <div class="col-lg-6 text-center d-none d-lg-block">
                    <div class="hero-image">
                        <i class="bi bi-car-front-fill" style="font-size: 15rem; color: rgba(255, 255, 255, 0.2);"></i>
                    </div>

                    <!-- <div class="hero-image text-center">
                               <img src="{{ asset('img/mobil-mase.png') }}" class="img-fluid" style="max-height: 400px;"
                            alt="Bagus Bengkel">
                    </div> -->

                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Mengapa Memilih Kami?</h2>
                <p class="section-subtitle">Kepuasan pelanggan adalah prioritas utama kami</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <h4 class="feature-title">Teknisi Berpengalaman</h4>
                        <p class="feature-text">Tim mekanik profesional dengan pengalaman lebih dari 10 tahun di bidang
                            otomotif</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-wrench-adjustable-circle-fill"></i>
                        </div>
                        <h4 class="feature-title">Peralatan Modern</h4>
                        <p class="feature-text">Menggunakan peralatan servis terkini untuk hasil yang maksimal dan
                            akurat</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <h4 class="feature-title">Harga Terjangkau</h4>
                        <p class="feature-text">Harga kompetitif dengan kualitas terbaik, tanpa biaya tersembunyi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Layanan Populer Kami</h2>
                <p class="section-subtitle">Layanan yang paling sering dipilih pelanggan</p>
            </div>
            <div class="row g-4">
                @forelse($topLayanan as $layanan)
                    <div class="col-md-4">
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="bi bi-tools"></i>
                            </div>
                            <h4 class="service-title">{{ $layanan->nama_layanan }}</h4>
                            <p class="service-description">
                                {{ $layanan->deskripsi ?? 'Layanan berkualitas untuk kendaraan Anda' }}
                            </p>
                            <div class="service-price">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-white">Layanan akan segera tersedia</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('login') }}" class="btn btn-hero">
                    <i class="bi bi-calendar-check me-2"></i>Booking Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="section-subtitle">Kami siap melayani Anda setiap saat</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-card">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div class="contact-info">
                                <h5>Telepon</h5>
                                <p>0812-3456-7890</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="contact-info">
                                <h5>Alamat</h5>
                                <p>Jl. Raya Otomotif No.123, Jakarta</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div class="contact-info">
                                <h5>Jam Operasional</h5>
                                <p>Senin - Sabtu: 08.00 - 17.00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Kings Bengkel Mobil. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Robust Scrollspy using IntersectionObserver
        document.addEventListener('DOMContentLoaded', function () {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

            const observerOptions = {
                root: null,
                rootMargin: '-20% 0px -70% 0px', // Adjust this to control when section becomes active
                threshold: 0
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute('id');
                        navLinks.forEach(link => {
                            link.classList.remove('active');
                            if (link.getAttribute('href') === `#${id}`) {
                                link.classList.add('active');
                            }
                        });
                    }
                });
            }, observerOptions);

            sections.forEach(section => observer.observe(section));

            // Manual Smooth Scroll Fix for Navbar Links
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href.startsWith('#')) {
                        e.preventDefault();
                        const targetId = href.substring(1);
                        const targetElement = document.getElementById(targetId);
                        
                        if (targetElement) {
                            const offset = 80; // Navbar height
                            const elementPosition = targetElement.getBoundingClientRect().top;
                            const offsetPosition = elementPosition + window.pageYOffset - offset;

                            window.scrollTo({
                                top: offsetPosition,
                                behavior: "smooth"
                            });

                            // Close mobile menu if open
                            const navbarCollapse = document.getElementById('navbarNav');
                            if (navbarCollapse.classList.contains('show')) {
                                bootstrap.Collapse.getInstance(navbarCollapse).hide();
                            }
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>