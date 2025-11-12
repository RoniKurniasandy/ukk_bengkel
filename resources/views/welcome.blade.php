<!-- 
@extends('layouts.landing')

@section('title', 'Selamat Datang di PPDB Online')


@section('content')
    <header id="home" class="d-flex align-items-center" style="position: relative; min-height: 100dvh; background: url({{ asset('images/my/hero-section.png') }}) no-repeat center center; background-size: cover;">

        <div
            style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0.1));">
        </div>

        <div class="container mt-5 pt-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8 text-center">
                    <h1 class="mt-sm-3 text-white mb-4 f-w-600 wow fadeInUp" data-wow-delay="0.2s" style="font-size: 3.5rem;">
                        Selamat Datang
                        <br>
                        <span class="text-primary">Harapan Bangsa</span>
                    </h1>
                    <h5 class="mb-4 text-white opacity-75 wow fadeInUp" data-wow-delay="0.4s" style="font-size: 1.25rem;">
                        Wujudkan Masa Depan Gemilang Melalui Pendidikan Berkualitas.
                        <br class="d-none d-md-block">
                        Daftar dengan mudah dan cepat melalui sistem pendaftaran siswa baru kami.
                    </h5>
                    <div class="my-5 wow fadeInUp" data-wow-delay="0.6s">
                        <a href="{{ route('register') }}"
                            class="btn btn-primary btn-lg d-inline-flex align-items-center me-2" target="_blank">Daftar
                            Sekarang <i class="ti ti-arrow-right ms-2"></i></a>
                        <a href="#alur" class="btn btn-outline-light btn-lg me-2">Lihat Alur Pendaftaran</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section>
        <div class="container title">
            <div class="row justify-content-center text-center wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-md-10 col-xl-6">
                    <h5 class="text-primary mb-0">Pendidikan Terbaik</h5>
                    <h2 class="my-3">Mengapa Memilih Sekolah Kami?</h2>
                    <p class="mb-0">Kami berkomitmen untuk menyediakan lingkungan belajar yang inspiratif dengan kurikulum
                        terbaik untuk masa depan cerah putra-putri Anda.</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-sm-6 col-lg-4">
                    <div class="card wow fadeInUp" data-wow-delay="0.4s">
                        <div class="card-body">
                            <img src="../assets/images/landing/img-feature1.svg"
                                alt="Ruang kelas modern dengan proyektor dan kursi ergonomis" class="img-fluid">
                            <h5 class="my-3">Fasilitas Modern</h5>
                            <p class="mb-0 text-muted">Lingkungan belajar nyaman dengan fasilitas terkini, dari lab,
                                perpustakaan, hingga sarana olahraga lengkap.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card wow fadeInUp" data-wow-delay="0.6s">
                        <div class="card-body">
                            <img src="../assets/images/landing/img-feature2.svg"
                                alt="Guru sedang mengajar di depan kelas menggunakan papan tulis interaktif"
                                class="img-fluid">
                            <h5 class="my-3">Kurikulum Unggulan</h5>
                            <p class="mb-0 text-muted">Kurikulum dirancang untuk mengembangkan potensi akademik dan
                                non-akademik siswa secara seimbang.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card wow fadeInUp" data-wow-delay="0.8s">
                        <div class="card-body">
                            <img src="../assets/images/landing/img-feature3.svg"
                                alt="Sekelompok guru yang ramah dan profesional berdiskusi di ruang guru" class="img-fluid">
                            <h5 class="my-3">Pendidik Profesional</h5>
                            <p class="mb-0 text-muted">Didukung oleh guru berpengalaman dan berdedikasi dalam membimbing
                                siswa menjadi pribadi cerdas dan berkarakter.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-0" id="alur">
        <div class="container title">
            <div class="row justify-content-center text-center wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-md-10 col-xl-6">
                    <h5 class="text-primary mb-0">Proses Cepat & Mudah</h5>
                    <h2 class="my-3">Alur Pendaftaran</h2>
                    <p class="mb-0">Ikuti 4 langkah mudah untuk menjadi bagian dari keluarga besar Sekolah Harapan Bangsa.
                    </p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-sm-6 col-lg-3">
                    <div class="card wow fadeInUp" data-wow-delay="0.4s">
                        <div class="card-body text-center">
                            <i class="ti ti-user-plus f-36 text-primary"></i>
                            <h5 class="my-3">1. Buat Akun</h5>
                            <p class="mb-0 text-muted">Daftarkan diri Anda dengan mengisi email dan password untuk membuat
                                akun.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card wow fadeInUp" data-wow-delay="0.6s">
                        <div class="card-body text-center">
                            <i class="ti ti-file-text f-36 text-primary"></i>
                            <h5 class="my-3">2. Lengkapi Data</h5>
                            <p class="mb-0 text-muted">Login dan lengkapi formulir biodata serta unggah dokumen yang
                                diperlukan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card wow fadeInUp" data-wow-delay="0.8s">
                        <div class="card-body text-center">
                            <i class="ti ti-search f-36 text-primary"></i>
                            <h5 class="my-3">3. Proses Seleksi</h5>
                            <p class="mb-0 text-muted">Tim kami akan melakukan verifikasi dan seleksi terhadap berkas
                                pendaftaran Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card wow fadeInUp" data-wow-delay="1.0s">
                        <div class="card-body text-center">
                            <i class="ti ti-bell f-36 text-primary"></i>
                            <h5 class="my-3">4. Pengumuman</h5>
                            <p class="mb-0 text-muted">Hasil seleksi akan diumumkan secara online melalui akun Anda
                                masing-masing.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="cta-block" style="position: relative; padding: 120px 0; background-image: url('{{ asset("assets/images/my/join-us.png") }}'); background-repeat: no-repeat; background-position: center center; background-size: cover; background-attachment: fixed;">


        <div class="container" style="position: relative; z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="text-white mb-4" style="font-size: 2.8rem; font-weight: 600;">Siap Bergabung dengan <span
                            class="text-primary">Sekolah Harapan
                            Bangsa?</span></h2>
                    <p class="text-white opacity-75 mb-4 lead">Pendaftaran akan segera ditutup. Jangan lewatkan
                        kesempatan untuk
                        menjadi siswa berprestasi di sekolah kami. Klik tombol di bawah untuk memulai proses pendaftaran.
                    </p>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Daftar Sekarang <i
                            class="ti ti-arrow-right ms-2"></i></a>
                </div>
            </div>
   
    </section>
    <section class="bg-white">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <h2 class="m-0 text-primary">1200+</h2>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="mb-2">Total Pendaftar</h4>
                                    <p class="mb-0">Antusiasme tinggi dari calon siswa baru setiap tahunnya.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <h2 class="m-0 text-primary">350</h2>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="mb-2">Kursi Tersedia</h4>
                                    <p class="mb-0">Kuota terbatas untuk menjaga kualitas proses belajar mengajar.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <h2 class="m-0 text-primary">3</h2>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="mb-2">Jurusan Unggulan</h4>
                                    <p class="mb-0">Pilihan jurusan yang relevan dengan kebutuhan industri saat ini.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-0">
        <div class="container title">
            <div class="row justify-content-center text-center wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-md-10 col-xl-6">
                    <h5 class="text-primary mb-0">Testimoni</h5>
                    <h2 class="my-3">Apa Kata Mereka?</h2>
                    <p class="mb-0">Kami bangga dapat memberikan dampak positif. Simak pengalaman para alumni dan orang
                        tua siswa kami.</p>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row cust-slider">
                <div class="col-md-6 col-lg-4">
                    <div class="card wow fadeInRight" data-wow-delay="0.2s">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="../assets/images/user/avatar-1.jpg"
                                        alt="Foto close-up alumni pria tersenyum" class="img-fluid wid-40 rounded-circle">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">Lingkungan Belajar Kondusif</h5>
                                    <div class="star f-12 mb-3">
                                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i
                                            class="fas fa-star text-warning"></i><i
                                            class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                                    </div>
                                    <p class="mb-2 text-muted">Sekolah ini memberikan fondasi yang kuat untuk saya
                                        melanjutkan ke perguruan tinggi favorit. Guru-gurunya sangat mendukung.</p>
                                    <h6 class="mb-0">Budi Santoso, Alumni</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card wow fadeInRight" data-wow-delay="0.4s">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="../assets/images/user/avatar-2.jpg"
                                        alt="Foto close-up orang tua siswa wanita tersenyum"
                                        class="img-fluid wid-40 rounded-circle">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">Pengembangan Karakter</h5>
                                    <div class="star f-12 mb-3">
                                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i
                                            class="fas fa-star text-warning"></i><i
                                            class="fas fa-star text-warning"></i><i
                                            class="fas fa-star-half-alt text-warning"></i>
                                    </div>
                                    <p class="mb-2 text-muted">Anak saya berkembang pesat di sini, tidak hanya akademis
                                        tapi juga karakternya. Lingkungannya sangat positif.</p>
                                    <h6 class="mb-0">Rina Wulandari, Orang Tua Siswa</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card wow fadeInRight" data-wow-delay="0.6s">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="../assets/images/user/avatar-3.jpg"
                                        alt="Foto close-up alumni wanita berhijab tersenyum"
                                        class="img-fluid wid-40 rounded-circle">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">Fasilitas Sangat Memadai</h5>
                                    <div class="star f-12 mb-3">
                                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i
                                            class="fas fa-star text-warning"></i><i
                                            class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                                    </div>
                                    <p class="mb-2 text-muted">Fasilitasnya lengkap dan modern, membuat kegiatan belajar
                                        mengajar menjadi sangat efektif dan menyenangkan.</p>
                                    <h6 class="mb-0">Siti Aminah, Alumni</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
 -->
