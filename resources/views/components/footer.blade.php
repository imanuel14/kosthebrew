<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container">
        <div class="row g-4 mb-4">
            <!-- Brand -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-house-door-fill text-primary me-2 fs-2"></i>
                    <span class="h4 mb-0 fw-bold">KostHeBrew</span>
                </div>
                <p class="text-secondary">
                    Platform pencarian kost terpercaya di Indonesia. Temukan kost impian Anda dengan mudah dan cepat.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-secondary fs-5 hover:text-white"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-secondary fs-5 hover:text-white"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-secondary fs-5 hover:text-white"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-secondary fs-5 hover:text-white"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            
            <!-- Menu -->
            <div class="col-lg-2 col-md-6">
                <h5 class="fw-semibold mb-3">Menu</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}" class="footer-link">Beranda</a></li>
                    <li class="mb-2"><a href="{{ route('kosts.index') }}" class="footer-link">Cari Kost</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}" class="footer-link">Tentang Kami</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="footer-link">Kontak</a></li>
                </ul>
            </div>
            
            <!-- Categories -->
            <div class="col-lg-2 col-md-6">
                <h5 class="fw-semibold mb-3">Kategori</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('kosts.category', 'male') }}" class="footer-link">Kost Putra</a></li>
                    <li class="mb-2"><a href="{{ route('kosts.category', 'female') }}" class="footer-link">Kost Putri</a></li>
                    <li class="mb-2"><a href="{{ route('kosts.category', 'mixed') }}" class="footer-link">Kost Campur</a></li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-semibold mb-3">Hubungi Kami</h5>
                <ul class="list-unstyled text-secondary">
                    <li class="mb-2 d-flex align-items-center">
                        <i class="bi bi-telephone-fill me-2 text-primary"></i>
                        0812-3456-7890
                    </li>
                    <li class="mb-2 d-flex align-items-center">
                        <i class="bi bi-envelope-fill me-2 text-primary"></i>
                        info@kosthebrew.com
                    </li>
                    <li class="mb-2 d-flex align-items-center">
                        <i class="bi bi-geo-alt-fill me-2 text-primary"></i>
                        Jakarta, Indonesia
                    </li>
                </ul>
                
                <div class="mt-3">
                    <h6 class="fw-semibold mb-2">Newsletter</h6>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email Anda">
                        <button class="btn btn-primary" type="button">
                            <i class="bi bi-send"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <hr class="border-secondary">
        
        <div class="text-center text-secondary">
            <p class="mb-0">&copy; {{ date('Y') }} KostHeBrew. All rights reserved.</p>
        </div>
    </div>
</footer>