<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BookHaven – Discover & Borrow</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome + Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    :root {
      --primary: #04beb3;
      --primary-dark: #039d94;
      --primary-light: #3ae0d6;
      --secondary: #3e525d;
      --dark: #2d3e4a;
      --light: #f8fafc;
      --gray: #6b7280;
      --shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    body {
      font-family: system-ui, -apple-system, sans-serif;
      background: var(--light);
      color: #2d3748;
      margin: 0;
      padding-top: 100px;
    }

    .navbar {
      background: white;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
      z-index: 1030;
    }

    .navbar-brand {
      font-weight: 800;
      color: var(--primary) !important;
      font-size: 1.9rem;
    }

    .btn-primary {
      background-color: var(--primary) !important;
      border-color: var(--primary) !important;
      color: white !important;
      font-weight: 600;
    }

    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active {
      background-color: var(--primary-dark) !important;
      border-color: var(--primary-dark) !important;
      box-shadow: 0 4px 12px rgba(4, 190, 179, 0.25);
    }

    .btn-outline-primary {
      color: var(--primary);
      border-color: var(--primary);
      font-weight: 600;
    }

    .btn-outline-primary:hover,
    .btn-outline-primary:focus {
      background-color: var(--primary);
      color: white;
      border-color: var(--primary);
    }

    .text-primary {
      color: var(--primary) !important;
    }

    .bg-primary {
      background-color: var(--primary) !important;
    }

    .form-control {
      border: 1px solid #cbd5e1;
      border-radius: 10px;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
      border-color: var(--primary) !important;
      box-shadow: 0 0 0 3px rgba(4, 190, 179, 0.18) !important;
    }

    .password-wrapper {
      position: relative;
    }

    .password-input {
      padding-right: 48px !important;
    }

    .password-toggle {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #6c757d;
      font-size: 1.15rem;
    }

    .password-toggle:hover {
      color: var(--primary);
    }

    .side-panel {
      background-image: url('https://thumbs.dreamstime.com/b/depicts-allwhite-m%E2%80%A6large-skylight-floods-space-natural-384658265.jpg');
      background-size: cover;
      background-position: center;
      min-height: 380px;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    .brand-box {
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(8px);
      border-radius: 16px;
      padding: 2.5rem 2rem;
      text-align: center;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
      border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .brand-icon {
      font-size: 4.8rem;
      color: var(--primary);
      margin-bottom: 1rem;
    }

    .brand-title {
      font-size: 2.1rem;
      font-weight: 800;
      color: var(--dark);
      margin-bottom: 0.5rem;
    }

    .brand-subtitle {
      font-size: 1.1rem;
      color: var(--gray);
      margin: 0;
    }

    .modal-content {
      border-radius: 20px !important;
      overflow: hidden;
      border: none;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .modal-xl.login-modal-xl {
      max-width: 960px;
    }

    .modal-xl.register-modal-xl {
      max-width: 1100px;
    }

    .modal-body.scrollable {
      overflow-y: auto;
      max-height: 75vh;
      -webkit-overflow-scrolling: touch;
    }

    .mobile-hero {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)),
        url('https://thumbs.dreamstime.com/b/depicts-allwhite-m%E2%80%A6large-skylight-floods-space-natural-384658265.jpg') center/cover;
      min-height: 220px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
      padding: 2rem;
    }

    /* ── Improved Cart Modal Styles ── */
    .cart-item {
      transition: all 0.25s ease;
      border-radius: 12px;
    }

    .cart-item:hover {
      border-color: var(--primary-light);
      box-shadow: 0 10px 30px rgba(4, 190, 179, 0.12) !important;
      transform: translateY(-2px);
    }

    .quantity-btn {
      width: 44px;
      font-weight: 600;
      padding: 0.5rem 0.75rem;
    }

    .quantity-group {
      border: 1px solid #dee2e6;
      border-radius: 8px;
      overflow: hidden;
      background: white;
    }

    .qty-input {
      border: none !important;
      background: transparent;
      font-weight: 600;
      text-align: center;
    }

    .qty-input:focus {
      box-shadow: none !important;
    }

    .book-meta span {
      background: #f1f5f9;
      padding: 3px 9px;
      border-radius: 6px;
      font-size: 0.85rem;
      margin-right: 0.6rem;
    }

    .description-text {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      font-size: 0.875rem;
      line-height: 1.4;
    }

    .summary-box {
      background: white;
      border-radius: 12px;
      padding: 1.25rem;
      border: 1px solid #e5e7eb;
    }

    .shadow-xl {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
    }

    @media (max-width: 576px) {
      .cart-item .card-body {
        padding: 1.25rem !important;
      }

      .quantity-group {
        width: 100%;
      }

      .quantity-btn {
        flex: 1;
      }

      .qty-input {
        flex: 1;
        max-width: 80px;
      }
    }

    @media (max-width: 991px) {
      .modal-dialog.modal-xl {
        max-width: 95%;
        margin: 1rem auto;
      }

      .modal-body.scrollable {
        max-height: 65vh;
      }

      body {
        padding-top: 80px;
      }

      .brand-box {
        padding: 2rem 1.5rem;
      }

      .brand-icon {
        font-size: 3.8rem;
      }

      .brand-title {
        font-size: 1.8rem;
      }
    }

    .dropdown-menu {
    background: #fff3cd !important;     /* very visible yellow */
    border: 3px solid red !important;
    z-index: 1055 !important;
}
  </style>
</head>

<body>
@include('admin.components.loader')
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid px-4 px-lg-5">
      <a class="navbar-brand" href="index.php">Book Management System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item me-4">
            <a href="#" class="nav-link fs-4 position-relative" data-bs-toggle="modal" data-bs-target="#cartModal">
              <i class="fas fa-shopping-cart"></i>
              <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill">0</span>
            </a>
          </li>
@guest
    <!-- Guest: show Login / Sign Up -->
    <li class="nav-item me-3">
        <a class="btn btn-outline-primary px-4" data-bs-toggle="modal" data-bs-target="#loginModal">
            Login
        </a>
    </li>
    <li class="nav-item">
        <a class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#registerModal">
            Sign Up
        </a>
    </li>
@else
     <li class="nav-item" id="logoutBtn">
      <button class="btn btn-warning">logout</button>
     </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img
            src="{{ auth()->user()->profile_picture
                    ? asset(auth()->user()->profile_picture)
                    : asset('images/default-user.png') }}"
            class="rounded-circle border"
            width="40"
            height="40"
            style="object-fit: cover"
            alt="Profile">
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>{{ auth()->user()->name }}</li>
            <li><hr class="dropdown-divider"></li>
            <!-- <li> <a href="#" class="dropdown-item text-danger fw-semibold" id="logoutBtn">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
           </li> -->
        </ul>
    </li>
@endguest

        </ul>
      </div>
    </div>
  </nav>

  <!-- LOGIN MODAL -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl login-modal-xl">
      <div class="modal-content">
        <div class="row g-0">
          <div class="col-lg-6 d-none d-lg-block side-panel">
            <div class="brand-box">
              <i class="bi bi-bookshelf display-1 mb-3 d-block text-primary"></i>
              <h2 class="brand-title">Library Management System</h2>
              <p class="brand-subtitle">Manage books, members & issues with ease</p>
            </div>
          </div>
          <div class="col-12 d-lg-none mobile-hero">
            <div>
              <h4>Library Management System</h4>
              <p>Manage books, members & issues with ease</p>
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <div class="modal-header border-0 pb-0 pt-4 px-4 px-md-5">
              <h5 class="modal-title fw-bold text-secondary" id="loginModalLabel">Sign In</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 px-md-5 pb-5">
              <form id="userLoginForm" data-url="{{ route('login.submit') }}">
                @csrf
                <div class="mb-4 form-floating">
                  <input type="email" class="form-control" id="loginEmail" name="email" placeholder="name@example.com" required>
                  <label for="loginEmail">Email address</label>
                </div>
                <div class="mb-4 form-floating password-wrapper">
                  <input type="password" class="form-control password-input" id="loginPass" name="password" placeholder="Password" required>
                  <label for="loginPass">Password</label>
                  <i class="fas fa-eye-slash password-toggle" id="toggleLogin"></i>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">Login</button>
              </form>

              <div class="text-center mt-4 small">
                Don't have an account?
                <a href="#" class="text-primary fw-bold switch-to-register">Sign Up</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- REGISTER MODAL -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl register-modal-xl">
      <div class="modal-content">
        <div class="row g-0">
          <div class="col-lg-6 d-none d-lg-block side-panel">
            <div class="brand-box">
              <i class="bi bi-bookshelf display-1 mb-3 d-block text-primary"></i>
              <h2 class="brand-title">Library Management System</h2>
              <p class="brand-subtitle">Manage books, members & issues with ease</p>
            </div>
          </div>
          <div class="col-12 d-lg-none mobile-hero">
            <div>
              <h4>Library Management System</h4>
              <p>Manage books, members & issues with ease</p>
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <div class="modal-header border-0 pb-0 pt-4 px-4 px-md-5">
              <h5 class="modal-title fw-bold text-secondary" id="registerModalLabel">Create Account</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 px-md-5 pb-5 pt-2 scrollable">
              <form id="registerForm" enctype="multipart/form-data">
                @csrf

                <div class="d-flex justify-content-between align-items-center mb-4 small text-muted">
                  <span>Let's get started</span>
                  <span>Personal details</span>
                </div>

                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="regFullName" name="full_name" placeholder="Full Name"
                        required>
                      <label for="regFullName">Full Name</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating mb-3">
                      <input type="email" class="form-control" id="regEmail" name="email" placeholder="name@example.com"
                        required>
                      <label for="regEmail">Email address</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating mb-3 password-wrapper">
                      <input type="password" class="form-control password-input" id="regPass" name="password"
                        placeholder="Password" required>
                      <label for="regPass">Password</label>
                      <i class="fas fa-eye-slash password-toggle" id="toggleReg"></i>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating mb-3 password-wrapper">
                      <input type="password" class="form-control password-input" id="regConfirmPass"
                        name="password_confirmation" placeholder="Confirm Password" required>
                      <label for="regConfirmPass">Confirm Password</label>
                      <i class="fas fa-eye-slash password-toggle" id="toggleRegConfirm"></i>
                    </div>
                  </div>
                </div>

                <hr class="my-4 border-light">

                <h6 class="fw-bold text-secondary mb-3">Where do you live?</h6>

                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="house_street" placeholder="House / Street" required>
                      <label for="houseStreet">House / Street No</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="landmark" placeholder="Landmark">
                      <label for="landmark">Landmark (optional)</label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="city" placeholder="City" required>
                      <label for="city">City</label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="state" placeholder="State" required>
                      <label for="state">State</label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="zip_code" placeholder="ZIP Code" required>
                      <label for="zipCode">ZIP / Postal Code</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="country" placeholder="Country" required
                        value="India">
                      <label for="country">Country</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-4">
                      <textarea class="form-control" name="full_address" placeholder="Full Address"
                        style="height: 86px;" required></textarea>
                      <label for="fullAddress">Full Address</label>
                    </div>
                  </div>
                </div>

                <hr class="my-4 border-light">

                <div class="mb-4">
                  <label class="form-label fw-medium">Profile Picture <small
                      class="text-muted">(optional)</small></label>
                  <input type="file" class="form-control" name="profile_picture" accept="image/*">
                  <div class="form-text text-muted mt-1">JPG or PNG, max 2MB</div>
                </div>

                <button type="button" id="registerSubmitBtn"
                  class="btn btn-primary btn-lg w-100 py-3 fw-bold shadow-sm">
                  Create My Account
                </button>

                <div class="text-center mt-4 small text-muted">
                  Already have an account?
                  <a href="#" class="text-primary fw-bold switch-to-login">Sign in</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CART MODAL -->
  <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content border-0 shadow-xl" style="border-radius: 20px; overflow: hidden;">

        <div class="modal-header border-0 pb-1 pt-4 px-4 px-md-5">
          <h4 class="modal-title fw-bold text-dark" id="cartModalLabel">
            <i class="fas fa-shopping-cart text-primary me-3"></i>Your Cart
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body px-4 px-md-5 pb-5 pt-2">

          <div id="cartLoader" class="text-center py-5 my-5">
            <div class="spinner-border text-primary" style="width: 3.2rem; height: 3.2rem;"></div>
            <p class="mt-4 text-muted fs-5 fw-medium">Loading cart items...</p>
          </div>

          <div id="emptyCart" class="text-center py-5 d-none">
            <i class="fas fa-shopping-bag fa-6x text-muted mb-4 opacity-50"></i>
            <h5 class="text-secondary mb-3 fw-semibold">Your cart is empty</h5>
            <p class="text-muted mb-4 fs-5">Looks like you haven't added any books yet.</p>
            <button class="btn btn-outline-primary px-5 py-2 fw-medium" data-bs-dismiss="modal">
              Continue Shopping
            </button>
          </div>

          <div id="cartTableWrapper" class="d-none">

            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
              <h5 class="mb-0 fw-bold text-dark">Cart Items</h5>
              <a href="index.php" class="text-primary text-decoration-none fw-medium small">
                <i class="fas fa-arrow-left me-2"></i>Continue shopping
              </a>
            </div>

            <div class="cart-items">

              <!-- Example Item 1 -->
              <div class="cart-item card border mb-4 shadow-sm rounded-4 overflow-hidden">
                <div class="row g-0">
                  <div class="col-4 col-sm-3 col-md-2 bg-light p-3 d-flex align-items-center justify-content-center">
                    <img
                      src="https://agni.topscripts.in/Book-Management-System/storage/app/public/books/covers/pl3MuBe1VUqXgvzJEMnM7nisKUhObkMqFdgXG9Bt.jpg"
                      class="img-fluid rounded-3 shadow" alt="Atomic Habits"
                      style="max-height: 160px; object-fit: contain;">
                  </div>
                  <div class="col-8 col-sm-9 col-md-10">
                    <div class="card-body py-4 px-3 px-md-4">
                      <div class="d-flex justify-content-between align-items-start gap-3">
                        <div class="flex-grow-1">
                          <h6 class="fw-bold mb-1 fs-5 text-dark">Atomic Habits</h6>
                          <p class="text-muted mb-2 small">James Clear</p>

                          <div class="book-meta small mb-3">
                            <span><strong>Language:</strong> English</span>
                            <span><strong>Pages:</strong> 320</span>
                          </div>

                          <p class="text-muted small mb-0 description-text">
                            <strong>Description:</strong> No matter your goals, Atomic Habits offers a proven framework
                            for improving—every day. Tiny changes, remarkable results...
                          </p>
                        </div>
                        <button class="btn btn-link text-danger p-1 remove-btn fs-5" title="Remove">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>

                      <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-4">
                        <div class="price-info">
                          <span class="fw-bold fs-4 text-dark me-2">₹450</span>
                          <small class="text-muted text-decoration-line-through me-2">₹500</small>
                          <span class="badge bg-success fs-6 px-2 py-1">-10%</span>
                        </div>
                        <div class="quantity-group d-flex align-items-center">
                          <button class="btn btn-outline-secondary quantity-btn btn-minus rounded-start px-3">-</button>
                          <input type="number" class="form-control text-center qty-input border-0 bg-white" value="1"
                            min="1">
                          <button class="btn btn-outline-secondary quantity-btn btn-plus rounded-end px-3">+</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Example Item 2 -->
              <div class="cart-item card border mb-4 shadow-sm rounded-4 overflow-hidden">
                <div class="row g-0">
                  <div class="col-4 col-sm-3 col-md-2 bg-light p-3 d-flex align-items-center justify-content-center">
                    <img
                      src="https://agni.topscripts.in/Book-Management-System/storage/app/public/books/covers/fOgwCdKDm15WFcTLCCHvYd15Uc7bQ6FntuAJ8FlE.jpg"
                      class="img-fluid rounded-3 shadow" alt="Think Like a Monk"
                      style="max-height: 160px; object-fit: contain;">
                  </div>
                  <div class="col-8 col-sm-9 col-md-10">
                    <div class="card-body py-4 px-3 px-md-4">
                      <div class="d-flex justify-content-between align-items-start gap-3">
                        <div class="flex-grow-1">
                          <h6 class="fw-bold mb-1 fs-5 text-dark">Think Like a Monk</h6>
                          <p class="text-muted mb-2 small">Jay Shetty</p>

                          <div class="book-meta small mb-3">
                            <span><strong>Language:</strong> English</span>
                            <span><strong>Pages:</strong> 352</span>
                          </div>

                          <p class="text-muted small mb-0 description-text">
                            <strong>Description:</strong> Jay Shetty, social media superstar and host of the #1 podcast
                            'On Purpose', distills the timeless wisdom he has gained...
                          </p>
                        </div>
                        <button class="btn btn-link text-danger p-1 remove-btn fs-5" title="Remove">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>

                      <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-4">
                        <div class="price-info">
                          <span class="fw-bold fs-4 text-dark me-2">₹760</span>
                          <small class="text-muted text-decoration-line-through me-2">₹800</small>
                          <span class="badge bg-success fs-6 px-2 py-1">-5%</span>
                        </div>
                        <div class="quantity-group d-flex align-items-center">
                          <button class="btn btn-outline-secondary quantity-btn btn-minus rounded-start px-3">-</button>
                          <input type="number" class="form-control text-center qty-input border-0 bg-white" value="2"
                            min="1">
                          <button class="btn btn-outline-secondary quantity-btn btn-plus rounded-end px-3">+</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="modal-footer border-0 bg-light px-4 px-md-5 py-4 flex-column align-items-stretch">
          <div class="w-100 mb-4 summary-box">
            <div class="d-flex justify-content-between mb-2 small">
              <span class="text-muted">Subtotal</span>
              <span id="subTotal" class="fw-medium">₹0</span>
            </div>
            <div class="d-flex justify-content-between mb-2 small">
              <span class="text-muted">GST (5%)</span>
              <span id="gstAmount" class="fw-medium">₹0</span>
            </div>
            <div class="d-flex justify-content-between mb-3 small">
              <span class="text-muted">Delivery</span>
              <span class="fw-medium">₹50</span>
            </div>
            <hr class="my-3">
            <div class="d-flex justify-content-between align-items-center">
              <span class="fs-5 fw-bold">Grand Total</span>
              <span id="grandTotal" class="fs-4 fw-bold text-primary">₹0</span>
            </div>
          </div>

          <div class="d-grid gap-2">
            <button class="btn btn-primary btn-lg fw-bold py-3">
              <i class="fas fa-lock me-2"></i>Proceed to Checkout
            </button>
            <button class="btn btn-outline-secondary py-2" data-bs-dismiss="modal">
              <i class="fas fa-arrow-left me-2"></i>Keep Shopping
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Scripts -->
  <script>
    $(document).ready(function() {

            // Password visibility toggle (eye icon click)
            $(document).on('click', '.password-toggle', function() {
                const $icon = $(this);
                const $input = $icon.siblings('input');

                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');
                    $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    $input.attr('type', 'password');
                    $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });


            // Switch between login and register modals when clicking links
            $('.switch-to-register, .switch-to-login').on('click', function(e) {
                e.preventDefault();

                const targetModal = $(this).hasClass('switch-to-register') ?
                    '#registerModal' :
                    '#loginModal';

       $('.switch-to-register, .switch-to-login').on('click', function (e) {
    e.preventDefault();

    const targetId = $(this).hasClass('switch-to-register')
        ? 'registerModal'
        : 'loginModal';

    const openModalEl = document.querySelector('.modal.show');

    if (openModalEl) {
        const openInstance = bootstrap.Modal.getInstance(openModalEl);
        openInstance.hide();

        setTimeout(() => {
            new bootstrap.Modal(document.getElementById(targetId)).show();
        }, 300);
    } else {
        new bootstrap.Modal(document.getElementById(targetId)).show();
    }
});

            });


            // ────────────────────────────────────────────────
            // Registration form - AJAX submit
            // ────────────────────────────────────────────────
            $('#registerSubmitBtn').on('click', function(e) {
                e.preventDefault();

                const form = document.getElementById('registerForm');

                // Check browser built-in validation
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const formData = new FormData(form);

                showLoader(); // show loading overlay

                $.ajax({
                    url: "{{ route('register.submit') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(response) {
                        hideLoader(); // hide loading overlay

                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Account Created!',
                                text: response.message || 'Welcome to the Library Management System!',
                                timer: 2200,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end'
                            });

                            setTimeout(() => {
                                $('#registerModal').modal('hide');
                                // Optional: window.location.href = '/dashboard';
                            }, 1800);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Registration Failed',
                                text: response.message || 'Please try again',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },

                    error: function(xhr) {
                        hideLoader(); // hide loading overlay

                        if (xhr.status === 422) {
                            // Validation errors from Laravel
                            let errors = xhr.responseJSON?.errors || {};
                            let errorMessages = Object.values(errors).flat();

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: 'Please correct the following:<br>• ' + errorMessages.join('<br>• '),
                                confirmButtonColor: '#dc3545'
                            });
                        } else if (xhr.status === 419) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Session Expired',
                                text: 'CSRF token mismatch - please refresh the page',
                                confirmButtonColor: '#dc3545'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An unexpected error occurred. Please try again later.',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    }
                });
            });


            // ────────────────────────────────────────────────
            // login form - AJAX submit
            // ────────────────────────────────────────────────
            $(document).on('submit', '#userLoginForm', function(e) {
                e.preventDefault(); // stop page reload

                let form = $(this);
                let formData = form.serialize();
                let url = form.data('url'); // get URL from data attribute

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        form.find('button[type="submit"]').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Welcome!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                           const loginModalEl = document.getElementById('loginModal');
                            const loginInstance = bootstrap.Modal.getInstance(loginModalEl);
                            loginInstance.hide();
                            setTimeout(() => {
                              window.location.reload(); 
                                }, 500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Failed',
                                text: response.message || 'Invalid credentials'
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Something went wrong';
                        if (xhr.status === 401 || xhr.status === 403) {
                            message = xhr.responseJSON.message;
                        }
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            message = Object.values(errors)[0][0];
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: message
                        });
                    },
                    complete: function() {
                        form.find('button[type="submit"]').prop('disabled', false);
                    }
                });
            });


            // ────────────────────────────────────────────────
            // Logout - Ajax
            // ────────────────────────────────────────────────
            $(document).on('click', '#logoutBtn', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Logout?',
                    text: 'You will be signed out of your account',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Logout',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('logout') }}",
                            type: "POST",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },

                            success: function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Logged out',
                                    timer: 1200,
                                    showConfirmButton: false
                                });

                                setTimeout(() => {
                                    window.location.reload();
                                }, 1200);
                            },

                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Logout failed',
                                    text: 'Please try again'
                                });
                            }
                        });

                    }
                });
            });




            // ────────────────────────────────────────────────
            // Cart modal - loading when opened
            // ────────────────────────────────────────────────
            $('#cartModal').on('shown.bs.modal', function() {
                showLoader(); // show loading

                // Simulate loading cart data (replace with real fetch later)
                setTimeout(() => {
                    hideLoader(); // hide loading
                    calculateCartTotals();
                }, 800);
            });


            // Calculate cart totals and update display
            function calculateCartTotals() {
                let subTotal = 0;
                let itemCount = 0;

                $('.cart-item').each(function() {
                    const priceText = $(this).find('.price-info .fw-bold').first().text()
                        .replace('₹', '').trim();
                    const price = parseFloat(priceText) || 0;
                    const qty = parseInt($(this).find('.qty-input').val()) || 1;

                    subTotal += price * qty;
                    itemCount += qty;
                });

                const gst = subTotal * 0.05;
                const delivery = subTotal > 0 ? 50 : 0;
                const grandTotal = subTotal + gst + delivery;

                $('#subTotal').text('₹' + subTotal.toFixed(0));
                $('#gstAmount').text('₹' + gst.toFixed(0));
                $('#grandTotal').text('₹' + grandTotal.toFixed(0));

                // Show empty cart message or cart content
                if (itemCount === 0) {
                    $('#cartTableWrapper').addClass('d-none');
                    $('#emptyCart').removeClass('d-none');
                } else {
                    $('#cartTableWrapper').removeClass('d-none');
                    $('#emptyCart').addClass('d-none');
                }
            }


            // Cart quantity increase
            $(document).on('click', '.btn-plus', function() {
                let $input = $(this).closest('.quantity-group').find('.qty-input');
                $input.val(parseInt($input.val()) + 1);
                calculateCartTotals();
            });

            // Cart quantity decrease
            $(document).on('click', '.btn-minus', function() {
                let $input = $(this).closest('.quantity-group').find('.qty-input');
                let val = parseInt($input.val());
                if (val > 1) {
                    $input.val(val - 1);
                    calculateCartTotals();
                }
            });

            // Remove item from cart
            $(document).on('click', '.remove-btn', function() {
                $(this).closest('.cart-item').remove();
                calculateCartTotals();
            });

            // Quantity input manual change validation
            $(document).on('change', '.qty-input', function() {
                if ($(this).val() < 1 || isNaN($(this).val())) {
                    $(this).val(1);
                }
                calculateCartTotals();
            });


    })


  </script>

  

</body>

</html>