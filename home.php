<?php session_start(); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ASPORD Menu</title>
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    :root {
      --bg-main: #f8fafc;
      --surface: #ffffff;
      --text-dark: #0f172a;
      --text-body: #475569;
      --text-muted: #94a3b8;
      --border: #e2e8f0;
      --accent: #2563eb;
      --font-head: 'Outfit', sans-serif;
      --font-body: 'Inter', sans-serif;
      /* Legacy support */
      --obsidian: #0f172a;
      --gold: #2563eb;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: var(--font-body);
    }

    body {
      margin: 0;
      background: var(--bg-main);
      color: var(--text-body);
      padding-bottom: 100px;
      min-height: 100vh;
      line-height: 1.5;
    }

    /* ===== CONTAINER ===== */
    .container {
      max-width: 1100px;
      margin: auto;
      padding: 0 20px;
    }

    /* ===== NAV ===== */
    nav {
      background: var(--surface);
      border-bottom: 1px solid var(--border-soft);
      padding: 16px 0;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .nav-inner {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .brand-id {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      color: var(--text-dark);
    }

    .brand-id i {
      font-size: 20px;
      color: var(--accent);
    }

    .brand-name {
      font-family: var(--font-head);
      font-size: 22px;
      font-weight: 700;
      letter-spacing: -0.5px;
    }

    .nav-left strong {
      display: block;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--text-muted);
      margin-top: 2px;
    }

    #welcomeUser {
      color: var(--text-body);
      font-size: 13px;
      font-weight: 600;
    }

    @media (max-width: 640px) {
      .nav-inner {
        gap: 10px;
      }
    }

    /* ===== LANGUAGE SWITCH ===== */
    .lang-switch button {
      margin-left: 8px;
      padding: 8px 16px;
      border-radius: 4px;
      border: 1px solid var(--border);
      background: transparent;
      cursor: pointer;
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.3s;
    }

    .lang-switch button.active {
      background: var(--obsidian);
      color: white;
      border-color: var(--obsidian);
    }

    /* ===== OFFER CAROUSEL ===== */
    .offer-carousel {
      padding: 16px 0;
      overflow: hidden;
    }

    .carousel-container {
      display: flex;
      transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
      width: 100%;
      will-change: transform;
      transform: translate3d(0,0,0);
    }

    .carousel-slide {
      min-width: 100%;
      flex-shrink: 0;
      padding: 0;
    }

    .offer-card {
      background: var(--surface);
      border: none;
      height: 200px;
      border-radius: 0; /* Let container handle clipping */
      display: flex;
      align-items: center;
      padding: 0 50px;
      color: var(--text-dark);
      position: relative;
      overflow: hidden;
    }

    .offer-content h2 {
      margin: 0;
      font-family: var(--font-accent);
      font-size: 24px;
      font-weight: 600;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: var(--muted);
    }

    .offer-content h3 {
      margin: 10px 0;
      font-family: var(--font-head);
      font-size: 40px;
      font-weight: 800;
      line-height: 1;
      letter-spacing: -1px;
      text-transform: uppercase;
      color: var(--text-dark);
    }

    .offer-content p {
      font-size: 14px;
      font-weight: 500;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .order-btn {
      background: black;
      color: white;
      border: none;
      padding: 10px 24px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 14px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 15px;
      transition: transform 0.2s;
    }

    .order-btn:hover {
      transform: scale(1.05);
    }

    .offer-images {
      position: absolute;
      right: 40px;
      top: 50%;
      transform: translateY(-50%);
      display: flex;
      gap: -20px;
    }

    .floating-food {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 4px solid white;
      object-fit: cover;
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
      background: white;
    }

    .floating-food:nth-child(2) {
      margin-left: -40px;
      transform: scale(0.85) rotate(-10deg);
      z-index: 1;
    }

    .coupon-icon {
      position: absolute;
      background: #ffe5ec;
      color: #c9184a;
      padding: 4px 8px;
      border-radius: 6px;
      font-weight: 900;
      font-size: 10px;
      box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
      transform: rotate(-15deg);
    }

    .c1 { top: 15px; left: 15px; opacity: 0.8; }
    .c2 { top: 15px; right: 15px; opacity: 0.8; }
    .c3 { bottom: 60px; right: 15px; transform: rotate(15deg); opacity: 0.8; }

    .carousel-dots {
      display: flex;
      justify-content: center;
      gap: 8px;
      position: absolute;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 10;
    }

    .dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: rgba(0, 0, 0, 0.2);
      cursor: pointer;
      transition: 0.3s;
    }

    .dot.active {
      width: 24px;
      border-radius: 4px;
      background: white;
      /* Changed to white for better visibility on dark gradients */
    }

    .divider-dashed {
      border-bottom: 1px dashed var(--border);
      margin: 0 16px;
    }

    /* Fix peeking issue in carousel */
    .offer-carousel .container {
      overflow: hidden !important;
      border-radius: 20px;
      padding: 0 !important; /* Full width inside container */
      box-shadow: 0 10px 30px rgba(0,0,0,0.04);
      border: 1px solid var(--border-soft);
    }

    @media (max-width: 640px) {
      .offer-carousel .container {
        border-radius: 0 !important;
      }
    }

    /* ===== SEARCH ===== */
    .search-wrapper {
      padding: 0 0 24px;
      background: transparent;
      margin-top: 10px;
    }

    .search-box {
      background: var(--surface);
      border: 1px solid var(--border-soft);
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.02);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .search-box:focus-within {
        border-color: var(--accent);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
    }

    .search-box input {
      border: none;
      background: transparent;
      outline: none;
      width: 100%;
      height: 54px;
      padding: 0 20px 0 52px;
      font-size: 15px;
      font-weight: 500;
      color: var(--text-dark);
    }

    .search-box i {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-size: 16px;
      pointer-events: none;
    }

    /* CUSTOM POPUP STYLING */
    #customPopup {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%) translateY(-100px);
      background: white;
      padding: 15px 30px;
      border-radius: 999px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      z-index: 2000;
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 600;
      transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    #customPopup.show {
      transform: translateX(-50%) translateY(0);
    }

    #customPopup .icon {
      width: 24px;
      height: 24px;
      background: var(--secondary);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
    }

    @media (max-width: 640px) {
      .search-container {
        margin-top: 12px !important;
        margin-bottom: 12px !important;
        padding: 0 16px !important;
        background: var(--bg-main);
      }

      .search-box {
        border-radius: 10px;
        background: white;
      }

      .search-box input {
        height: 48px;
        padding: 0 16px 0 44px;
        font-size: 14px;
      }

      .search-box i {
        left: 16px;
        font-size: 14px;
      }

      .offer-carousel {
        padding: 0;
      }

      .carousel-slide {
        padding: 0;
      }

      .offer-card {
        padding: 0 20px;
        height: 220px;
        border-radius: 0;
      }

      .offer-content h3 {
        font-size: 40px;
      }

      .offer-content h2 {
        font-size: 28px;
      }

      .floating-food {
        width: 80px;
        height: 80px;
      }

      .offer-images {
        right: 10px;
      }
    }

    /* ===== CATEGORIES WRAPPER ===== */
    .categories-wrapper {
      position: sticky;
      top: 60px;
      z-index: 90;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(15px);
      border-bottom: 1px solid var(--border);
    }

    .categories {
      display: flex;
      gap: 12px;
      padding: 16px 20px;
      overflow-x: auto;
      scrollbar-width: none;
    }

    .categories span {
      flex-shrink: 0;
      padding: 10px 22px;
      border-radius: 99px;
      font-size: 13px;
      font-weight: 700;
      background: var(--surface);
      border: 1px solid var(--border);
      color: var(--text-dark);
      cursor: pointer;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      transition: all 0.3s;
    }

    .categories span.active {
      background: var(--accent);
      color: white;
      border-color: var(--accent);
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    /* ===== MENU (ZOMATO STYLE REFINED) ===== */
    .menu-grid {
      display: flex;
      flex-direction: column;
      gap: 0;
      padding-bottom: 40px;
      background: var(--sand);
      min-height: 100vh;
    }

    .menu-item-z {
      display: flex;
      justify-content: space-between;
      padding: 30px 20px;
      background: transparent;
      gap: 20px;
      border-bottom: 1px solid var(--border);
      position: relative;
    }

    .menu-left {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      min-width: 0;
      /* for truncation to work */
    }

    .menu-meta {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 4px;
    }

    /* CSS VEG/NON-VEG ICONS */
    .diet-icon {
      width: 16px;
      height: 16px;
      border: 1.5px solid;
      border-radius: 3px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: 8px;
    }

    .diet-icon.veg {
      border-color: #24963f;
      color: #24963f;
    }

    .diet-icon.nonveg {
      border-color: #dc2626; /* Red */
      color: #dc2626;
    }

    .spicy-icon {
      color: #ea580c; /* Orange-Red chilli color */
      font-size: 14px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .tag-bestseller {
      font-size: 10px;
      font-weight: 800;
      color: var(--gold);
      background: var(--obsidian);
      padding: 2px 8px;
      border-radius: 2px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .menu-title {
      font-family: var(--font-head);
      font-size: 20px;
      font-weight: 700;
      color: var(--text-dark);
      margin: 0 0 4px;
    }

    .menu-price {
      font-size: 16px;
      font-weight: 700;
      color: var(--text-dark);
      margin-top: 8px;
    }

    .menu-rating {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 6px;
    }

    .stars {
      background: #f1f5f9;
      color: #64748b;
      padding: 2px 8px;
      border-radius: 6px;
      font-weight: 700;
      font-size: 12px;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .stars i {
        color: #f59e0b;
    }

    .votes {
      font-size: 12px;
      font-weight: 500;
      color: var(--text-muted);
    }

    .menu-desc {
        font-size: 13px;
        color: var(--text-body);
        margin-top: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* RIGHT SIDE */
    .menu-right {
      width: 130px;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
    }

    .img-wrapper {
      width: 120px;
      height: 120px;
      position: relative;
      margin-bottom: 12px;
    }

    .img-wrapper img {
      width: 100%;
      height: 100%;
      border-radius: 16px;
      object-fit: cover;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* ACTION AREA (Floating Button) */
    .add-action-area {
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 90px;
      height: 36px;
      z-index: 5;
    }

    .add-btn-z {
      width: 100%;
      height: 100%;
      background: var(--text-dark);
      color: #fff;
      font-weight: 700;
      font-size: 12px;
      border-radius: 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.3s ease;
      border: none;
    }

    .add-btn-z:hover {
      background: var(--accent);
      transform: translateY(-2px);
    }

    .qty-control-z {
      width: 100%;
      height: 100%;
      background: var(--accent);
      color: white;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      overflow: hidden;
    }

    .qty-control-z button {
      width: 28px;
      height: 100%;
      background: transparent;
      border: none;
      color: white;
      font-size: 18px;
      font-weight: 700;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0;
    }

    .qty-control-z span {
      font-weight: 700;
      font-size: 15px;
    }

    /* ===== CART ===== */
    .cart-bar {
      position: fixed;
      bottom: 24px;
      left: 20px;
      right: 20px;
      background: var(--text-dark);
      box-shadow: 0 20px 40px rgba(0,0,0,0.2);
      padding: 16px 24px;
      display: none;
      z-index: 2000;
      border-radius: 16px;
      color: white;
    }

    .cart-inner {
      max-width: 1100px;
      margin: auto;
    }

    .cart-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .place-btn {
      background: var(--accent);
      color: white;
      border: none;
      padding: 12px 24px;
      border-radius: 8px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 12px;
      transition: all 0.3s;
    }

    .place-btn:hover {
        background: #1e40af;
    }

    /* ===== AUTH MODAL ===== */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      backdrop-filter: blur(4px);
    }

    .modal-content {
      background: var(--surface);
      padding: 40px;
      border-radius: 20px;
      width: 90%;
      max-width: 420px;
      text-align: center;
      box-shadow: 0 30px 60px rgba(15, 23, 42, 0.15);
      border: 1px solid var(--border);
      animation: modalFadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes modalFadeUp {
      from {
        transform: translateY(20px);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .modal-content h3 {
      font-family: var(--font-head);
      font-size: 28px;
      font-weight: 800;
      margin: 0 0 10px;
      color: var(--text-dark);
      letter-spacing: -0.5px;
    }

    .modal-content p {
      color: var(--text-muted);
      margin-bottom: 30px;
      font-size: 15px;
      line-height: 1.6;
    }

    .modal-input {
      width: 100%;
      padding: 16px;
      margin-bottom: 16px;
      border: 1px solid var(--border);
      background: white;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 500;
      font-family: var(--font-body);
      transition: all 0.3s;
    }

    .modal-input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
      outline: none;
    }

    .modal-btn {
      width: 100%;
      padding: 18px;
      background: var(--text-dark);
      color: white;
      border: none;
      border-radius: 12px;
      font-weight: 700;
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 1px;
      cursor: pointer;
      margin-top: 20px;
      transition: all 0.3s;
    }

    .modal-btn:hover {
        background: var(--accent);
        transform: translateY(-2px);
    }

    #otpSection {
      display: none;
    }

    .otp-inputs {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin: 20px 0;
    }

    .otp-digit {
      width: 50px;
      height: 65px;
      text-align: center;
      font-size: 28px;
      font-weight: 700;
      font-family: var(--font-head);
      border: 1px solid var(--border);
      border-radius: 12px;
      background: #f8fafc;
      transition: all 0.3s;
    }

    .otp-digit:focus {
      border-color: var(--accent);
      border-width: 2px;
      outline: none;
      background: white;
      box-shadow: 0 5px 15px rgba(37, 99, 235, 0.1);
    }

    /* Hide numeric spinners */
    .otp-digit::-webkit-outer-spin-button,
    .otp-digit::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    .otp-digit {
      -moz-appearance: textfield;
    }

    /* ===== LANGUAGE DROPDOWN (MOBILE ONLY) ===== */
    .lang-dropdown {
      display: none;
      padding: 6px 12px;
      border-radius: 999px;
      border: 1px solid var(--border);
      font-size: 13px;
      background: var(--surface);
      cursor: pointer;
    }

    @media (max-width: 640px) {
      .lang-switch button[data-lang] {
        display: none;
      }

      .lang-dropdown {
        display: block;
      }
    }
  </style>
</head>

<body>
  <!-- ===== NAV ===== -->
  <nav>
    <div class="container nav-inner">
      <div class="nav-left">
        <div class="brand-name">ASP<span>ORD.</span></div>
        <strong>Table T-04</strong>
        <div id="welcomeUser">Welcome, Guest</div>
      </div>


      <div class="lang-switch">
        <button data-lang="en" class="active">EN</button>
        <button data-lang="hi">हिंदी</button>
        <button data-lang="mr">मराठी</button>

        <select id="langDropdown" class="lang-dropdown">
          <option value="en">English</option>
          <option value="hi">हिंदी</option>
          <option value="mr">मराठी</option>
        </select>
      </div>
    </div>
  </nav>

  <!-- ===== SEARCH BELOW NAV ===== -->
  <div class="search-container container" style="margin-top: 16px;">
    <div class="search-box">
      <i class="fas fa-search"></i>
      <input type="text" id="searchInput" placeholder="Search for dishes...">
      <div id="searchSuggestions" style="position: absolute; top: 100%; left: 0; right: 0; background: white; z-index: 1000; border: 1px solid var(--border-soft); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); display: none; margin-top: 8px; overflow: hidden;"></div>
    </div>
  </div>

  <!-- ===== OFFER CAROUSEL ===== -->
  <section class="offer-carousel">
    <div class="container overflow-hidden" style="position: relative;">
      <div class="carousel-container" id="carouselContainer">
        <!-- Slide 1 -->
        <div class="carousel-slide">
          <div class="offer-card">
            <div class="coupon-icon c1"><i class="fas fa-percent"></i></div>
            <div class="coupon-icon c2"><i class="fas fa-percent"></i></div>
            <div class="coupon-icon c3"><i class="fas fa-percent"></i></div>
            <div class="offer-content">
              <h2>FLAT</h2>
              <h3>50% OFF</h3>
              <p>with FREE delivery</p>
              <button class="order-btn"
                onclick="document.getElementById('menu').scrollIntoView({behavior: 'smooth'})">Order now
                &rsaquo;</button>
            </div>
            <div class="offer-images">
              <img src="images/panner_butter_masala.jpg" alt="Paneer Butter Masala" class="floating-food">
              <img src="images/Chicken_Biryani.webp" alt="Chicken Biryani" class="floating-food">
            </div>
          </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-slide">
          <div class="offer-card"
            style="background: radial-gradient(circle at center, #4361ee 0%, #3f37c9 100%); box-shadow: 0 10px 25px rgba(63, 55, 201, 0.3);">
            <div class="coupon-icon c1" style="color: #3f37c9;">★</div>
            <div class="offer-content">
              <h2>COMBO</h2>
              <h3>SAVE 30%</h3>
              <p>Special Weekend Deals</p>
              <button class="order-btn"
                onclick="document.getElementById('menu').scrollIntoView({behavior: 'smooth'})">View Menu
                &rsaquo;</button>
            </div>
            <div class="offer-images">
              <img src="images/Veg-Fried-Rice.webp" alt="Veg Fried Rice" class="floating-food">
              <img src="images/Chicken-Manchurian.jpg" alt="Chicken Manchurian" class="floating-food">
            </div>
          </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-slide">
          <div class="offer-card"
            style="background: radial-gradient(circle at center, #2b9348 0%, #007f5f 100%); box-shadow: 0 10px 25px rgba(0, 127, 95, 0.3);">
            <div class="coupon-icon c2" style="color: #007f5f;">FREE</div>
            <div class="offer-content">
              <h2>FRESH</h2>
              <h3>BUY 1 GET 1</h3>
              <p>On all Veg Main Course</p>
              <button class="order-btn"
                onclick="document.getElementById('menu').scrollIntoView({behavior: 'smooth'})">Order now
                &rsaquo;</button>
            </div>
            <div class="offer-images">
              <img src="images/dal_tadka.jpg" alt="Dal Tadka" class="floating-food">
              <img src="images/veg_handi.jpg" alt="Veg Handi" class="floating-food">
            </div>
          </div>
        </div>
        <!-- Slide 4 -->
        <div class="carousel-slide">
          <div class="offer-card"
            style="background: radial-gradient(circle at center, #fb8500 0%, #ffb703 100%); box-shadow: 0 10px 25px rgba(251, 133, 0, 0.3);">
            <div class="coupon-icon c3" style="color: #fb8500;">NEW</div>
            <div class="offer-content">
              <h2>DESI</h2>
              <h3>UP TO 40%</h3>
              <p>Authentic North Indian</p>
              <button class="order-btn"
                onclick="document.getElementById('menu').scrollIntoView({behavior: 'smooth'})">Explore &rsaquo;</button>
            </div>
            <div class="offer-images">
              <img src="images/Chicken_Curry.webp" alt="Chicken Curry" class="floating-food">
              <img src="images/Mutton_Biryani.webp" alt="Mutton Biryani" class="floating-food">
            </div>
          </div>
        </div>
        <!-- Slide 5 -->
        <div class="carousel-slide">
          <div class="offer-card"
            style="background: radial-gradient(circle at center, #7209b7 0%, #560bad 100%); box-shadow: 0 10px 25px rgba(114, 9, 183, 0.3);">
            <div class="coupon-icon c1" style="color: #7209b7;">%</div>
            <div class="offer-content">
              <h2>SNACKS</h2>
              <h3>FLAT ₹100 OFF</h3>
              <p>On Orders above ₹400</p>
              <button class="order-btn"
                onclick="document.getElementById('menu').scrollIntoView({behavior: 'smooth'})">Order now
                &rsaquo;</button>
            </div>
            <div class="offer-images">
              <img src="images/Chicken_Lollipop.webp" alt="Lollipop" class="floating-food">
              <img src="images/Fish_Fry.webp" alt="Fish Fry" class="floating-food">
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-dots" id="carouselDots">
        <div class="dot active" data-index="0"></div>
        <div class="dot" data-index="1"></div>
        <div class="dot" data-index="2"></div>
        <div class="dot" data-index="3"></div>
        <div class="dot" data-index="4"></div>
      </div>
    </div>
  </section>

  <!-- ===== CATEGORIES ===== -->
  <div class="categories-wrapper">
    <div class="categories container"></div>
  </div>

  <!-- ===== MENU ===== -->
  <div class="menu-grid container" id="menu"></div>

  <!-- ===== CART ===== -->
  <div class="cart-bar" id="cartBar">
    <div class="cart-inner">
      <div id="cartItems"></div>
      <div class="cart-footer">
        <strong id="cartTotal">₹0</strong>
        <button class="place-btn" onclick="placeOrder()"><i class="fas fa-shopping-bag"></i> Place Order</button>
      </div>
    </div>
  </div>

  <!-- ===== SCRIPTS ===== -->
  <!-- ===== AUTH MODAL ===== -->
  <div class="modal-overlay" id="authModal" onclick="if(event.target === this) this.style.display='none'">
    <div class="modal-content">
      <div id="authDetailsSection">
        <h3><i class="fas fa-user-shield"></i> Enter Details</h3>
        <p>A 6-digit code will be sent to your email.</p>
        <input type="text" id="authName" class="modal-input" placeholder="Your Name" required>
        <input type="email" id="authEmail" class="modal-input" placeholder="Email Address" required>
        <div id="authError" style="color: #dc2626; font-size: 14px; margin: 10px 0; display: none;"></div>
        <button class="modal-btn" id="sendOtpBtn" onclick="sendEmailOTP()">
          <span id="sendOtpText"><i class="fas fa-paper-plane"></i> Send Verification Code</span>
          <span id="sendOtpLoader" style="display: none;">Sending Email...</span>
        </button>
      </div>

      <!-- OTP Verification Section -->
      <div id="otpSection" style="display: none;">
        <h3>Verify Email</h3>
        <p id="otpMessage">Enter the 6-digit code sent to your email</p>
        <div class="otp-inputs">
          <input type="number" class="otp-digit" maxlength="1" oninput="moveFocus(this, 0)">
          <input type="number" class="otp-digit" maxlength="1" oninput="moveFocus(this, 1)">
          <input type="number" class="otp-digit" maxlength="1" oninput="moveFocus(this, 2)">
          <input type="number" class="otp-digit" maxlength="1" oninput="moveFocus(this, 3)">
          <input type="number" class="otp-digit" maxlength="1" oninput="moveFocus(this, 4)">
          <input type="number" class="otp-digit" maxlength="1" oninput="moveFocus(this, 5)">
        </div>
        <div id="otpError" style="color: #dc2626; font-size: 14px; margin: 10px 0; display: none;"></div>
        <button class="modal-btn" id="verifyOtpBtn" onclick="verifyEmailOTP()">
          <span id="verifyOtpText">Verify & Proceed</span>
          <span id="verifyOtpLoader" style="display: none;">Verifying...</span>
        </button>
        <button class="modal-btn" id="resendOtpBtn" onclick="sendEmailOTP()"
          style="background: #6b7280; margin-top: 10px; display: none;">
          <span id="resendText">Resend Code</span>
          <span id="resendCountdown"></span>
        </button>
      </div>
    </div>
  </div>

  <script src="./auth.js?v=<?php echo time(); ?>"></script>
  <script>
    window.isVerified = <?php echo isset($_SESSION['verified']) && $_SESSION['verified'] === true ? 'true' : 'false'; ?>;
  </script>
  <script src="./otp-api.js?v=<?php echo time(); ?>"></script>
  <script src="./app.js?v=<?php echo time(); ?>"></script>
  <script>
    // ===== CAROUSEL LOGIC =====
    const container = document.getElementById('carouselContainer');
    const dots = document.querySelectorAll('.dot');
    let currentIndex = 0;
    const totalSlides = 5;

    function updateCarousel() {
      container.style.transform = `translateX(-${currentIndex * 100}%)`;
      dots.forEach((dot, idx) => {
        dot.classList.toggle('active', idx === currentIndex);
      });
    }

    function nextSlide() {
      currentIndex = (currentIndex + 1) % totalSlides;
      updateCarousel();
    }

    // Auto-scroll every 4 seconds (Slower for better readability)
    let interval = setInterval(nextSlide, 4000);

    // Dot navigation
    dots.forEach(dot => {
      dot.addEventListener('click', () => {
        clearInterval(interval);
        currentIndex = parseInt(dot.dataset.index);
        updateCarousel();
        interval = setInterval(nextSlide, 4000);
      });
    });

    // Pause on hover
    document.querySelector('.offer-carousel').addEventListener('mouseenter', () => clearInterval(interval));
    document.querySelector('.offer-carousel').addEventListener('mouseleave', () => interval = setInterval(nextSlide, 4000));
  </script>
  <!-- ===== CUSTOM POPUP ===== -->
  <div id="customPopup">
    <div class="icon"><i class="fas fa-check"></i></div>
    <div class="msg">Message here</div>
  </div>
</body>

</html>