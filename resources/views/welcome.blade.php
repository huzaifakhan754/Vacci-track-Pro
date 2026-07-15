<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VacciTrack  — Child Vaccination Management System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Css link -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
    <!-- ==================== NAVBAR ==================== -->
    <nav class="navbar navbar-expand-lg navbar-vacci fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand-vacci" href="#">
                <span class="brand-icon"><i class="bi bi-shield-check"></i></span>
                VacciTrack 
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link nav-link-vacci active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-vacci" href="#hospitals">Hospitals</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-vacci" href="#features">Vaccines</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-vacci" href="#about">About</a></li>
                </ul>
                @if (Route::has('login'))
                    <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center justify-content-lg-end gap-2 mt-3 mt-lg-0">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-login px-4 py-2">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-login px-4 py-2">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-register px-4 py-2">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- ==================== HERO ==================== -->
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-badge">
                        <i class="bi bi-patch-check-fill"></i>
                        Trusted by 50+ Hospitals
                    </div>
                    <h1 class="hero-title">
                        Protecting Your Child's Future, <span class="highlight">One Dose at a Time.</span>
                    </h1>
                    <p class="hero-subtitle">
                        Book vaccination slots at nearby hospitals, maintain digital records, and never miss a dose with smart reminders — all in one place.
                    </p>
                    <div class="hero-actions">
                        <a href="{{ route('register') }}" class="btn btn-get-started">
                            Book Now ! <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="#features" class="btn btn-learn-more">
                            <i class="bi bi-play-circle"></i> Learn More
                        </a>
                    </div>
                    <div class="hero-trust">
                        <div class="trust-avatars">
                            <img src="https://picsum.photos/seed/parent1/80/80.jpg" alt="Parent">
                            <img src="https://picsum.photos/seed/parent2/80/80.jpg" alt="Parent">
                            <img src="https://picsum.photos/seed/parent3/80/80.jpg" alt="Parent">
                            <img src="https://picsum.photos/seed/parent4/80/80.jpg" alt="Parent">
                        </div>
                        <div class="trust-text">
                            <strong>10,000+</strong> parents trust 
                            1k 
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-visual">
                        <div class="hero-img-wrapper">
                            <img src="https://picsum.photos/seed/childvaccine-doctor/700/500.jpg" alt="Child Vaccination" class="hero-illustration">
                        </div>
                        <div class="floating-card card-1">
                            <div class="fc-icon green"><i class="bi bi-check2-all"></i></div>
                            <div class="fc-text">
                                <strong>Vaccination Done</strong>
                                MMR — Dose 2 Complete
                            </div>
                        </div>
                        <div class="floating-card card-2">
                            <div class="fc-icon orange"><i class="bi bi-bell-fill"></i></div>
                            <div class="fc-text">
                                <strong>Upcoming</strong>
                                Hepatitis B — In 3 Days
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== STATS BAR ==================== -->
    <section class="stats-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-4 stat-item reveal">
                    <div class="stat-icon"><i class="bi bi-hospital"></i></div>
                    <div class="stat-number" data-count="6">0+</div>
                    <div class="stat-label">Partner Hospitals</div>
                </div>
                <div class="col-md-4 stat-item reveal">
                    <div class="stat-icon"><i class="bi bi-emoji-smile"></i></div>
                    <div class="stat-number" data-count="100">0+</div>
                    <div class="stat-label">Vaccinated Children</div>
                </div>
                <div class="col-md-4 stat-item reveal">
                    <div class="stat-icon"><i class="bi bi-headset"></i></div>
                    <div class="stat-number" data-count="24">0/7</div>
                    <div class="stat-label">Support Available</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== FEATURES ==================== -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="text-center reveal">
                <div class="section-label"><i class="bi bi-grid-3x3-gap-fill"></i> Key Features</div>
                <h2 class="section-title">Everything You Need for Your Child's Health</h2>
                <p class="section-subtitle">VacciTrack  simplifies the entire vaccination journey — from booking appointments to tracking records and receiving timely alerts.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="feature-card">
                        <div class="feature-icon icon-blue">
                            <i class="bi bi-calendar2-check"></i>
                        </div>
                        <h3 class="feature-title">Easy Booking</h3>
                        <p class="feature-desc">Search and book vaccination slots at nearby hospitals in just a few taps. Compare availability and choose the best time for your child.</p>
                        <a href="#hospitals" class="feature-link">Book a Slot <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="feature-card">
                        <div class="feature-icon icon-green">
                            <i class="bi bi-file-earmark-medical"></i>
                        </div>
                        <h3 class="feature-title">Digital Records</h3>
                        <p class="feature-desc">Maintain a complete vaccination history for each child. Download records as PDFs for school admissions or travel requirements.</p>
                        <a href="#" class="feature-link">View Records <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="feature-card">
                        <div class="feature-icon icon-orange">
                            <i class="bi bi-bell"></i>
                        </div>
                        <h3 class="feature-title">Smart Alerts</h3>
                        <p class="feature-desc">Get timely notifications about upcoming vaccine dates, missed schedules, and new vaccine availability so you never miss a dose.</p>
                        <a href="#" class="feature-link">Set Alerts <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== HOSPITAL SEARCH ==================== -->
    <section class="hospital-section" id="hospitals">
        <div class="container">
            <div class="text-center reveal">
                <div class="section-label"><i class="bi bi-search"></i> Hospital Search</div>
                <h2 class="section-title">Find a Hospital Near You</h2>
                <p class="section-subtitle">Browse our network of verified partner hospitals and book your child's vaccination with confidence.</p>
            </div>
            <div class="search-box-wrapper reveal">
                <div class="search-box">
                    <input type="text" id="hospitalSearch" placeholder="Search by hospital name, city, or vaccine..." autocomplete="off">
                    <button id="searchBtn"><i class="bi bi-search"></i> Search</button>
                </div>
            </div>
            <div class="row g-4" id="hospitalCards">
                <!-- Card 1 -->
                <div class="col-lg-4 col-md-6 hospital-col reveal" data-name="city children hospital mumbai polio mmr">
                    <div class="hospital-card">
                        <img src="https://donate.indushospital.org.pk/wp-content/uploads/2026/01/new-hospital-mob.webp" alt="City Children Hospital" class="hospital-img">
                        <span class="hospital-badge badge-verified"><i class="bi bi-patch-check-fill"></i> Verified Partner</span>
                        <h4 class="hospital-name">Indus Hospital and Health Network (IHHN)</h4>
                        <p class="hospital-location"><i class="bi bi-geo-alt-fill"></i> Main Crossing Near Aman Tower</p>
                        <div class="hospital-meta">
                            <span class="meta-item"><i class="bi bi-syringe"></i> 12 Vaccines</span>
                            <span class="meta-item"><i class="bi bi-star-fill" style="color:#fbbf24"></i> 4.8</span>
                            <span class="meta-item"><i class="bi bi-clock"></i> Open 24 Hours</span>
                        </div>
                        <button class="btn-view-details" onclick="showHospitalToast('City Children Hospital')">
                            View Details <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-lg-4 col-md-6 hospital-col reveal" data-name="sunrise wellness center delhi hepatitis bcg">
                    <div class="hospital-card">
                        <img src="https://propakistani.pk/wp-content/uploads/2024/05/jinnah-hospital.jpg" alt="Sunrise Wellness Center" class="hospital-img">
                        <span class="hospital-badge badge-verified"><i class="bi bi-patch-check-fill"></i> Verified Partner</span>
                        <h4 class="hospital-name">Jinnah Postgraduate Medical Centre (JPMC)</h4>
                        <p class="hospital-location"><i class="bi bi-geo-alt-fill"></i> Rafiqi H J Rd, Karachi Cantonment Cantonment, Karachi, Pakistan</p>
                        <div class="hospital-meta">
                            <span class="meta-item"><i class="bi bi-syringe"></i> 9 Vaccines</span>
                            <span class="meta-item"><i class="bi bi-star-fill" style="color:#fbbf24"></i> 4.6</span>
                            <span class="meta-item"><i class="bi bi-clock"></i> Open 24 Hours </span>
                        </div>
                        <button class="btn-view-details" onclick="showHospitalToast('Sunrise Wellness Center')">
                            View Details <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col-lg-4 col-md-6 hospital-col reveal" data-name="little stars pediatric clinic bangalore dpt rotavirus">
                    <div class="hospital-card">
                        <img src="https://i.aaj.tv/primary/2025/03/12232603483b243.jpg" alt="Little Stars Pediatric Clinic" class="hospital-img">
                        <span class="hospital-badge badge-verified"><i class="bi bi-patch-check-fill"></i> Verified Partner</span>
                        <h4 class="hospital-name">Dr. Ruth K. M. Pfau Civil Hospital Karachi</h4>
                        <p class="hospital-location"><i class="bi bi-geo-alt-fill"></i> Mission Rd, New Labour Colony Nanakwara, Karachi, Pakistan</p>
                        <div class="hospital-meta">
                            <span class="meta-item"><i class="bi bi-syringe"></i> 15 Vaccines</span>
                            <span class="meta-item"><i class="bi bi-star-fill" style="color:#fbbf24"></i> 4.9</span>
                            <span class="meta-item"><i class="bi bi-clock"></i> Open 24 Hours</span>
                        </div>
                        <button class="btn-view-details" onclick="showHospitalToast('Little Stars Pediatric Clinic')">
                            View Details <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="col-lg-4 col-md-6 hospital-col reveal" data-name="rainbow health hub chennai measles varicella">
                    <div class="hospital-card">
                        <img src="https://www.cgh-k.com/assets/img/about.jpg" alt="Rainbow Health Hub" class="hospital-img">
                        <span class="hospital-badge badge-verified"><i class="bi bi-patch-check-fill"></i> Verified Partner</span>
                        <h4 class="hospital-name">Chiniot General Hospital (commonly abbreviated as CGH)</h4>
                        <p class="hospital-location"><i class="bi bi-geo-alt-fill"></i> ST- 1, 2½ Landhi Rd, 3 41B Sector 41 B Korangi, Karachi, 74900, Pakistan</p>
                        <div class="hospital-meta">
                            <span class="meta-item"><i class="bi bi-syringe"></i> 11 Vaccines</span>
                            <span class="meta-item"><i class="bi bi-star-fill" style="color:#fbbf24"></i> 4.7</span>
                            <span class="meta-item"><i class="bi bi-clock"></i>Open 24 Hours</span>
                        </div>
                        <button class="btn-view-details" onclick="showHospitalToast('Rainbow Health Hub')">
                            View Details <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <!-- Card 5 -->
                <div class="col-lg-4 col-md-6 hospital-col reveal" data-name="tiny tots immunization kolkata ipv typhoid">
                    <div class="hospital-card">
                        <img src="https://shaukatkhanum.org.pk/wp-content/uploads/2024/11/about-us-2.webp" alt="Tiny Tots Immunization" class="hospital-img">
                        <span class="hospital-badge badge-verified"><i class="bi bi-patch-check-fill"></i> Verified Partner</span>
                        <h4 class="hospital-name">Shaukat Khanum Memorial Cancer Hospital and Research Centre</h4>
                        <p class="hospital-location"><i class="bi bi-geo-alt-fill"></i> 2FR4+QC, Dha City, Karachi, Pakistan</p>
                        <div class="hospital-meta">
                            <span class="meta-item"><i class="bi bi-syringe"></i> 8 Vaccines</span>
                            <span class="meta-item"><i class="bi bi-star-fill" style="color:#fbbf24"></i> 4.5</span>
                            <span class="meta-item"><i class="bi bi-clock"></i> Open 24 Hours</span>
                        </div>
                        <button class="btn-view-details" onclick="showHospitalToast('Tiny Tots Immunization')">
                            View Details <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <!-- Card 6 -->
                <div class="col-lg-4 col-md-6 hospital-col reveal" data-name="guardian health center hyderabad flu hpv">
                    <div class="hospital-card">
                        <img src="https://siut.org/wp-content/uploads/2023/02/siut-mehrunnisa-1024x680.jpeg" alt="Guardian Health Center" class="hospital-img">
                        <span class="hospital-badge badge-verified"><i class="bi bi-patch-check-fill"></i> Verified Partner</span>
                        <h4 class="hospital-name"> SIUT Mehrunnisa Medical Centre.</h4>
                        <p class="hospital-location"><i class="bi bi-geo-alt-fill"></i>Survey No. 103, Deh dih Tapo, Ibrahim Hyderi Sector No. 48, Korangi Township, Korangi Creek, Karachi, 75180, Pakistan</p>
                        <div class="hospital-meta">
                            <span class="meta-item"><i class="bi bi-syringe"></i> 14 Vaccines</span>
                            <span class="meta-item"><i class="bi bi-star-fill" style="color:#fbbf24"></i> 4.8</span>
                            <span class="meta-item"><i class="bi bi-clock"></i> Open 24 Hours</span>
                        </div>
                        <button class="btn-view-details" onclick="showHospitalToast('Guardian Health Center')">
                            View Details <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div id="noResults" class="text-center py-5" style="display:none;">
                <i class="bi bi-search" style="font-size:2.5rem; color:var(--border-light);"></i>
                <p class="mt-2" style="color:var(--text-light);">No hospitals found matching your search.</p>
            </div>
        </div>
    </section>

    <!-- ==================== CTA ==================== -->
    <section class="cta-section" id="about">
        <div class="container">
            <div class="cta-card reveal">
                <h2 class="cta-title">Ready to Protect Your Child's Health?</h2>
                <p class="cta-subtitle">Join thousands of parents who trust VacciTrack  for hassle-free vaccination management. Register today and take the first step.</p>
                <button class="btn-cta" data-bs-toggle="modal" data-bs-target="#registerModal">
                    Create Free Account <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <span class="brand-icon"><i class="bi bi-shield-check"></i></span>
                        VacciTrack 
                    </div>
                    <p class="footer-desc">A modern vaccination management platform helping parents track, book, and manage their child's immunization schedule with ease.</p>
                    <div class="footer-socials">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#hospitals">Hospitals</a></li>
                        <li><a href="#features">Vaccines</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Resources</h5>
                    <ul class="footer-links">
                        <li><a href="#">Vaccination Schedule</a></li>
                        <li><a href="#">Parent Guidelines</a></li>
                        <li><a href="#">Hospital Partners</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Contact Us</h5>
                    <div class="footer-contact-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>42 Health Avenue, Andheri East,<br>Mumbai, MH 400069</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-telephone-fill"></i>
                        <span>+91 1800-123-4567</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-envelope-fill"></i>
                        <span>support@VacciTrack .in</span>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; 2025 VacciTrack . All rights reserved. Made with <i class="bi bi-heart-fill" style="color:#ef4444;"></i> for healthier futures.
            </div>
        </div>
    </footer>

    <!-- ==================== LOGIN MODAL ==================== -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="loginModalLabel"><i class="bi bi-box-arrow-in-right text-primary me-2"></i> Welcome Back</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label-vacci" for="loginEmail">Email Address</label>
                            <input id="loginEmail" name="email" type="email" class="form-control form-control-vacci" placeholder="you@example.com" required autocomplete="username">
                        </div>
                        <div class="mb-3">
                            <label class="form-label-vacci" for="loginPassword">Password</label>
                            <input id="loginPassword" name="password" type="password" class="form-control form-control-vacci" placeholder="Enter your password" required autocomplete="current-password">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                                <label class="form-check-label" for="rememberMe" style="font-size:0.85rem;">Remember me</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-decoration-none" style="font-size:0.85rem; color:var(--primary);">Forgot password?</a>
                        </div>
                        <button type="submit" class="btn btn-submit">Login</button>
                        <p class="text-center mt-3" style="font-size:0.85rem; color:var(--text-light);">
                            Don't have an account? <a href="#" class="text-primary fw-semibold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== REGISTER MODAL ==================== -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="registerModalLabel"><i class="bi bi-person-plus-fill text-primary me-2"></i> Create Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row gx-3">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label-vacci" for="registerName">Full name</label>
                                <input id="registerName" name="name" type="text" class="form-control form-control-vacci" placeholder="John Doe" required autocomplete="name">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label-vacci" for="registerEmail">Email Address</label>
                                <input id="registerEmail" name="email" type="email" class="form-control form-control-vacci" placeholder="you@example.com" required autocomplete="username">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label-vacci" for="registerPhone">Phone Number</label>
                            <input id="registerPhone" name="phone_no" type="tel" class="form-control form-control-vacci" placeholder="+91 98765 43210" required autocomplete="tel">
                        </div>
                        <div class="mb-3">
                            <label class="form-label-vacci" for="registerRole">Register as</label>
                            <select id="registerRole" name="role" class="form-select form-control-vacci" required>
                                <option value="" disabled selected>Select role</option>
                                <option value="parent">Parent</option>
                                <option value="hospital">Hospital</option>
                            </select>
                        </div>
                        <div class="row gx-3">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label-vacci" for="registerPassword">Password</label>
                                <input id="registerPassword" name="password" type="password" class="form-control form-control-vacci" placeholder="Create a secure password" required autocomplete="new-password">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label-vacci" for="registerPasswordConfirmation">Confirm Password</label>
                                <input id="registerPasswordConfirmation" name="password_confirmation" type="password" class="form-control form-control-vacci" placeholder="Repeat your password" required autocomplete="new-password">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-submit w-100">Create account</button>
                        <p class="text-center mt-3" style="font-size:0.85rem; color:var(--text-light);">
                            Already have an account? <a href="#" class="text-primary fw-semibold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== TOAST ==================== -->
    <div class="toast-vacci" id="vacciToast">
        <div class="toast-icon"><i class="bi bi-info-circle-fill"></i></div>
        <div class="toast-body">
            <strong id="toastTitle">Hospital Details</strong>
            <span id="toastMessage">Login to view full hospital details and book slots.</span>
        </div>
        <button class="toast-close" onclick="hideToast()"><i class="bi bi-x-lg"></i></button>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ============ NAVBAR SCROLL ============
        const navbar = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // ============ REVEAL ON SCROLL ============
        const revealElements = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -40px 0px'
        });

        revealElements.forEach(el => revealObserver.observe(el));

        // ============ COUNTER ANIMATION ============
        const statNumbers = document.querySelectorAll('.stat-number');
        let statAnimated = false;

        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !statAnimated) {
                    statAnimated = true;
                    animateCounters();
                }
            });
        }, {
            threshold: 0.5
        });

        document.querySelectorAll('.stat-item').forEach(el => statsObserver.observe(el));

        function animateCounters() {
            statNumbers.forEach(el => {
                const count = parseInt(el.getAttribute('data-count'));
                const originalText = el.textContent;
                let current = 0;
                const increment = Math.max(1, Math.floor(count / 60));
                const suffix = originalText.includes('/') ? '/7' : '+';

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= count) {
                        current = count;
                        clearInterval(timer);
                    }
                    if (count >= 10000) {
                        el.textContent = (current / 1000).toFixed(current < count ? 0 : 0) + 'k+';
                        if (current >= count) el.textContent = '10k+';
                    } else {
                        el.textContent = current + suffix;
                    }
                }, 30);
            });
        }

        // ============ HOSPITAL SEARCH ============
        const searchInput = document.getElementById('hospitalSearch');
        const searchBtn = document.getElementById('searchBtn');
        const hospitalCols = document.querySelectorAll('.hospital-col');
        const noResults = document.getElementById('noResults');

        function performSearch() {
            const query = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;

            hospitalCols.forEach(col => {
                const name = col.getAttribute('data-name') || '';
                const hospitalName = col.querySelector('.hospital-name').textContent.toLowerCase();
                const location = col.querySelector('.hospital-location').textContent.toLowerCase();
                const match = !query || name.includes(query) || hospitalName.includes(query) || location.includes(query);

                col.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        searchInput.addEventListener('input', performSearch);
        searchBtn.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });

        // ============ TOAST ============
        let toastTimeout;

        function showHospitalToast(hospitalName) {
            const toast = document.getElementById('vacciToast');
            document.getElementById('toastTitle').textContent = hospitalName;
            document.getElementById('toastMessage').textContent = 'Login to view full details and book vaccination slots at ' + hospitalName + '.';
            toast.classList.add('show');
            clearTimeout(toastTimeout);
            toastTimeout = setTimeout(hideToast, 5000);
        }

        function hideToast() {
            document.getElementById('vacciToast').classList.remove('show');
        }

        // ============ FORM SUBMISSIONS ============
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const modal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
                if (modal) modal.hide();
                showToastCustom('Login Successful', 'Welcome back! Redirecting to your dashboard...', 'bi-check-circle-fill');
            });
        }

        const registerForm = document.getElementById('registerForm');
        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const modal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                if (modal) modal.hide();
                showToastCustom('Account Created', 'Welcome to VacciTrack ! Your account has been created successfully.', 'bi-check-circle-fill');
            });
        }

        function showToastCustom(title, message, icon) {
            const toast = document.getElementById('vacciToast');
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMessage').textContent = message;
            toast.querySelector('.toast-icon i').className = 'bi ' + icon;
            toast.classList.add('show');
            clearTimeout(toastTimeout);
            toastTimeout = setTimeout(hideToast, 5000);
        }

        // ============ SMOOTH SCROLL ============
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    const navHeight = navbar.offsetHeight;
                    const targetPos = target.getBoundingClientRect().top + window.pageYOffset - navHeight;
                    window.scrollTo({
                        top: targetPos,
                        behavior: 'smooth'
                    });

                    // Close mobile menu
                    const navCollapse = document.getElementById('navbarNav');
                    const bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
                    if (bsCollapse) bsCollapse.hide();
                }
            });
        });

        // ============ ACTIVE NAV LINK ON SCROLL ============
        const sections = document.querySelectorAll('section[id]');
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY + 100;
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                const sectionId = section.getAttribute('id');
                const navLink = document.querySelector(`.nav-link-vacci[href="#${sectionId}"]`);
                if (navLink) {
                    if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                        document.querySelectorAll('.nav-link-vacci').forEach(l => l.classList.remove('active'));
                        navLink.classList.add('active');
                    }
                }
            });
        });
    </script>
    
    <script src="https://cdn.botpress.cloud/webchat/v3.6/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2026/06/30/23/20260630234951-2M2KUXFW.js" defer></script>
</body>

</html>