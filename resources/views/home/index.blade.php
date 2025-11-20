    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
        <title>Sembako Murah | Belanja Hemat Kebutuhan Pokok</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        <style>
            /* CSS Kustom Tambahan untuk Gaya WordPress */
            :root {
                --primary-color: #3C3D37; /* Biru Primer (Bisa diganti Merah/Hijau) */
                --secondary-color: #ffc107; /* Kuning Sekunder */
                --dark-color: #343a40;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f8f9fa; /* Latar belakang abu-abu muda */
            }
            
            /* Navbar Kustom */
            .navbar-custom {
                background-color: var(--primary-color);
            }
            .navbar-custom .nav-link, .navbar-custom .navbar-brand {
                color: white !important;
            }

            /* Hero Section */
            .hero-section {
                background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('placeholder-image-sembako.jpg') center center no-repeat;
                background-size: cover;
                color: white;
                padding: 80px 0;
                text-align: center;
                margin-bottom: 30px;
            }
            .hero-title {
                font-size: 3.5rem;
                font-weight: 700;
            }

            /* Card Produk */
            .product-card {
                border: none;
                border-radius: 10px;
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
            .product-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            }
            .card-price {
                color: #dc3545; /* Merah untuk harga diskon */
                font-size: 1.8rem;
                font-weight: bold;
            }

            /* Keunggulan Section (Fitur) */
            .feature-box {
                text-align: center;
                padding: 20px;
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
                margin-bottom: 20px;
            }
            .feature-box i {
                color: var(--primary-color);
                font-size: 2rem;
                margin-bottom: 15px;
            }

            /* Footer */
            .footer-custom {
                background-color: var(--dark-color);
                color: white;
                padding: 30px 0;
            }
        </style>
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">
                    <img src="{{ asset('images/logo.png') }}" height="25" class="d-inline-block align-text-top me-2"> SITEBUS MURAH
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                       {{--  <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#products">Produk</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login <i class="fa fa-sign-in" aria-hidden="true"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <section class="hero-section">
            <div class="container">
                <h1 class="hero-title mb-3">Hemat Belanja Hingga 50%</h1>
                <p class="lead mb-4">Dapatkan paket kebutuhan pokok (Sembako) lengkap dengan harga terjangkau.</p>
                {{-- <a href="#products" class="btn btn-warning btn-lg fw-bold text-dark shadow-lg">
                    <i class="fas fa-tags me-2"></i> Lihat Semua Promo Hari Ini!
                </a>
                <p class="mt-3 text-white-50">Stok terbatas! Penawaran berlaku untuk 100 pembeli pertama.</p> --}}
            </div>
        </section>

        <section id="features" class="container py-5">
            <h2 class="text-center mb-4 display-6 fw-bold">Kenapa Pilih Kami?</h2>
            <div class="row text-center">

                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-sack-dollar"></i>
                        <h5 class="fw-bold">Harga Murah</h5>
                        <p>Kami potong 50%.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-seedling"></i>
                        <h5 class="fw-bold">Kualitas Terbaik</h5>
                        <p>Produk selalu *fresh* dan bersertifikat BPOM.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-shipping-fast"></i>
                        <h5 class="fw-bold">Pengambilan Ditempat</h5>
                        <p>Layanan Ditempat.</p>
                    </div>
                </div>
            </div>
        </section>
        
    {{--     <hr class="container my-4">

        <section id="products" class="container py-5">
            <h2 class="text-center mb-5 display-5 fw-bold text-dark">Pilihan Paket Sembako Super Hemat</h2>
            
            <div class="row">

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card product-card">
                        <img src="https://via.placeholder.com/400x250/FF5733/FFFFFF?text=PAKET+HEMAT" class="card-img-top" alt="Paket Keluarga Hemat">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">Paket Keluarga Hemat</h5>
                            <p class="card-text text-muted">Beras 5kg, Minyak 1L, Gula 1kg, Teh kotak.</p>
                            <span class="badge bg-success mb-2">Paling Laris!</span>
                            <div class="card-price mb-3">Rp 99.000</div>
                            <a href="#" class="btn btn-primary w-100"><i class="fas fa-cart-plus me-2"></i> Beli Sekarang</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card product-card">
                        <img src="https://via.placeholder.com/400x250/C70039/FFFFFF?text=PAKET+KOMPLIT" class="card-img-top" alt="Paket Komplit Bulanan">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">Paket Komplit Bulanan</h5>
                            <p class="card-text text-muted">Beras 10kg, Minyak 2L, Telur 1 Tray, Kecap.</p>
                            <span class="badge bg-warning mb-2">Diskon 15%</span>
                            <div class="card-price mb-3">Rp 195.000</div>
                            <a href="#" class="btn btn-primary w-100"><i class="fas fa-cart-plus me-2"></i> Beli Sekarang</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card product-card">
                        <img src="https://via.placeholder.com/400x250/333333/FFFFFF?text=PAKET+SEHAT" class="card-img-top" alt="Paket Premium Sehat">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">Paket Premium Sehat</h5>
                            <p class="card-text text-muted">Beras Organik, Minyak Zaitun, Madu Murni.</p>
                            <span class="badge bg-danger mb-2">Eksklusif</span>
                            <div class="card-price mb-3">Rp 250.000</div>
                            <a href="#" class="btn btn-primary w-100"><i class="fas fa-cart-plus me-2"></i> Beli Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}

      {{--   <section class="bg-primary text-white py-5 mb-4 shadow-lg">
            <div class="container text-center">
                <h3 class="fw-bold mb-3">Siap Hemat Jutaan Rupiah Tahun Ini?</h3>
                <p class="lead mb-4">Klaim kupon diskon tambahan Anda sekarang sebelum kehabisan!</p>
                <a href="#contact" class="btn btn-lg btn-success fw-bold">
                    <i class="fas fa-whatsapp me-2"></i> Hubungi Kami via WhatsApp
                </a>
            </div>
        </section> --}}

        <footer id="contact" class="footer-custom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="fw-bold">Sitebus Murah</h5>
                        <p class="text-white-50">Solusi belanja kebutuhan pokok yang cerdas dan hemat untuk keluarga Indonesia.</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <h5 class="fw-bold">Tautan Cepat</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white-50 text-decoration-none">Tentang Kami</a></li>
                            <li><a href="#" class="text-white-50 text-decoration-none">Kebijakan Privasi</a></li>
                            <li><a href="#" class="text-white-50 text-decoration-none">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 mb-3">
                        <h5 class="fw-bold">Kontak</h5>
                        <ul class="list-unstyled">
                            <li class="text-white-50"><i class="fas fa-phone-alt me-2"></i> 0812-XXXX-YYYY</li>
                            <li class="text-white-50"><i class="fas fa-envelope me-2"></i> info@sembakomurah.com</li>
                            <li class="text-white-50"><i class="fas fa-map-marker-alt me-2"></i> Batam, Indonesia</li>
                        </ul>
                    </div>
                </div>
                <div class="text-center pt-3 border-top border-secondary">
                    <small class="text-white-50">&copy; 2025 Sitebus Murah.</small>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
    </html>