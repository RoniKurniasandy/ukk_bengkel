<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bengkel Mobil Sejahtera</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }

        .hero {
            background-image: url('{{ asset( "image/bg_bengkel.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-black text-white fixed top-0 w-full z-50 shadow">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Bengkel Mobil Sejahtera</h1>
            <ul class="flex space-x-6">
                <li><a href="#tentang" class="hover:underline">Tentang</a></li>
                <li><a href="#layanan" class="hover:underline">Layanan</a></li>
                <li><a href="#kontak" class="hover:underline">Kontak</a></li>
                <a href="/login" class="btn btn-primary">Login</a>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero h-screen flex items-center justify-center text-white relative" >
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Selamat Datang di Bengkel Mobil Sejahtera</h1>
            <p class="text-lg md:text-xl mb-6">Servis cepat, harga hemat, kualitas terjamin!</p>
            <a href="#layanan"
                class="bg-white text-blue-800 font-semibold px-6 py-3 rounded hover:bg-gray-200 transition">Lihat
                Layanan</a>
        </div>
    </header>

    <!-- Tentang -->
    <section id="tentang" class="h-screen flex items-center bg-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6">Tentang Kami</h2>
            <p class="text-lg mx-auto">Bengkel Mobil Sejahtera telah melayani pelanggan sejak 2010. Kami
                menyediakan layanan servis mobil umum, tune-up, ganti oli, spooring balancing, dan banyak lagi dengan
                teknisi berpengalaman dan peralatan modern. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fuga aperiam tenetur excepturi, velit fugiat in. Totam reiciendis magnam quam ex deserunt eaque voluptas. Praesentium sed fugiat laboriosam neque, voluptatibus nisi. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nobis aspernatur debitis facere soluta laudantium harum sit similique voluptatem repellat accusamus quis aperiam, quam perferendis dolorum atque blanditiis porro voluptate libero. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quisquam neque, ut ex numquam impedit dolorem ipsum qui fugit dignissimos similique reiciendis alias ad quasi provident? Laborum magni ipsa suscipit! Iusto. Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem maxime omnis eaque expedita quaerat reiciendis illo. Ipsa aliquam magnam dolor quae facere repellendus tenetur placeat ipsum, est eligendi totam tempore. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vel soluta officia vero cumque hic repudiandae labore repellendus ullam id, exercitationem nulla ut animi. Amet, omnis eius dolorem laudantium quidem nemo! Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus voluptas iste eaque sequi. Ratione iusto deleniti alias rem, a provident architecto natus molestias neque ipsum, molestiae eaque, fugiat dolor aut?</p>
        </div>
    </section>

    <!-- Layanan -->
    <section id="layanan" class="h-screen flex items-center bg-gray-200">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-10">Layanan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-2">Tune Up & Servis Mesin</h3>
                    <p>Perawatan dan pembaruan mesin secara berkala agar mobil tetap prima dan aman di jalan.</p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-2">Servis Listrik</h3>
                    <p>Pengecekan listrik agar sistem listrik berfungsi dengan baik.</p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-2">Ganti Oli & Ban</h3>
                    <p>Oli & Ban yang berkualitas untuk menjaga performa mobil dan mesin Anda.</p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-2">Ganti Aki</h3>
                    <p>Pengisian & Ganti Aki yang berkualitas untuk mobil anda.</p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-2">Sparepart & Aksesoris</h3>
                    <p>Tersedia berbagai sparepart original dan aftermarket.</p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-2">Ganti AC</h3>
                    <p>Memperbarui atau mengganti AC agar pendingin mobil tetap dingin.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontak -->
    <section id="kontak" class="py-16 bg-white">
        <div class="container mx-auto px-6 ">
            <h2 class="text-3xl font-bold mb-4">Hubungi Kami</h2>
            <p class="mb-4">Ingin servis atau tanya-tanya dulu? Silakan hubungi kami:</p>
            <p class="text-lg font-semibold">0812-3456-7890</p>
            <p class="text-lg font-semibold">Jl. Raya Otomotif No.123, Jakarta</p>
            <p class="text-lg font-semibold mt-2">Senin - Sabtu: 08.00 - 17.00</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-800 text-white text-center py-4">
        &copy; {{ date('Y') }} Bengkel Mobil Sejahtera. All rights reserved.
    </footer>

</body>

</html>