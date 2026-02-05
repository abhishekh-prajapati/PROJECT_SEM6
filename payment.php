<?php
session_start();
if (!isset($_SESSION['verified']) || $_SESSION['verified'] !== true) {
    header('Location: home.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Secure Checkout | ASPORD</title>
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="payment.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --bg: #f8fafc;
      --surface: #ffffff;
      --primary: #0f172a;
      --secondary: #2563eb;
      --border: #e2e8f0;
      --success: #10b981;
      --text-muted: #64748b;
      --shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
      --font-body: 'Inter', sans-serif;
      --font-head: 'Outfit', sans-serif;
    }

    * {
      box-sizing: border-box;
      -webkit-font-smoothing: antialiased;
    }

    body {
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      background: var(--bg);
      margin: 0;
      color: var(--primary);
      padding-bottom: 40px;
    }

    /* HEADER */
    .checkout-header {
      background: var(--surface);
      padding: 16px 20px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .brand {
      font-weight: 700;
      font-size: 18px;
      color: var(--secondary);
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .brand span {
      color: var(--primary);
      font-weight: 500;
      font-size: 14px;
    }

    .secure-badge {
      display: flex;
      align-items: center;
      gap: 4px;
      font-size: 12px;
      color: var(--success);
      font-weight: 600;
      background: #ecfdf5;
      padding: 4px 8px;
      border-radius: 4px;
    }

    .container {
      max-width: 480px;
      /* Mobile-first gateway width */
      margin: 20px auto;
      padding: 0 16px;
    }

    /* CARD STYLE */
    .card {
      background: var(--surface);
      border-radius: 12px;
      box-shadow: var(--shadow);
      border: 1px solid var(--border);
      overflow: hidden;
      margin-bottom: 20px;
    }

    /* ORDER SUMMARY */
    .summary-header {
      background: #fdfdfd;
      padding: 16px;
      border-bottom: 1px solid var(--border);
    }

    .summary-title {
      font-size: 14px;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-weight: 600;
      margin-bottom: 4px;
    }

    .order-total-large {
      font-family: var(--font-head);
      font-size: 32px;
      font-weight: 800;
      color: var(--primary);
      letter-spacing: -1px;
    }

    .item-list {
      padding: 24px;
      background: var(--surface);
    }

    .item-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 15px;
      margin-bottom: 12px;
      color: var(--primary);
      font-weight: 500;
    }

    .item-row span:last-child {
      font-weight: 700;
      font-family: var(--font-head);
    }

    .divider {
      height: 1px;
      background: var(--border);
      margin: 12px 0;
      border: none;
    }

    /* PAYMENT METHODS */
    .section-title {
      font-weight: 600;
      margin: 0 0 12px;
      font-size: 16px;
    }

    .payment-method {
      border: 1px solid var(--border);
      border-radius: 8px;
      margin-bottom: 10px;
      transition: all 0.2s;
      background: var(--surface);
      overflow: hidden;
    }

    .payment-method.active {
      border-color: var(--secondary);
      background: #fffbf2;
      /* Light orange tint */
      box-shadow: 0 0 0 1px var(--secondary);
    }

    .method-header {
      padding: 14px 16px;
      display: flex;
      align-items: center;
      cursor: pointer;
      gap: 12px;
    }

    .radio-custom {
      width: 18px;
      height: 18px;
      border: 2px solid #d1d5db;
      border-radius: 50%;
      position: relative;
      flex-shrink: 0;
    }

    .payment-method.active .radio-custom {
      border-color: var(--secondary);
    }

    .payment-method.active .radio-custom::after {
      content: '';
      width: 10px;
      height: 10px;
      background: var(--secondary);
      border-radius: 50%;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .method-info {
      flex: 1;
    }

    .method-title {
      font-weight: 500;
      font-size: 15px;
    }

    .method-icons {
      display: flex;
      gap: 6px;
      margin-top: 4px;
    }

    .pay-icon {
      height: 16px;
      opacity: 0.7;
    }

    /* METHOD DETAILS (Inputs) */
    .method-body {
      display: none;
      padding: 0 16px 16px;
      border-top: 1px solid rgba(0, 0, 0, 0.05);
      margin-top: -4px;
      padding-top: 12px;
    }

    .payment-method.active .method-body {
      display: block;
    }

    .input-group {
      margin-bottom: 12px;
    }

    .input-label {
      font-size: 12px;
      font-weight: 500;
      color: var(--text-muted);
      margin-bottom: 4px;
      display: block;
    }

    .form-input {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid var(--border);
      border-radius: 8px;
      font-size: 14px;
      outline: none;
      background: white;
      transition: all 0.3s;
    }

    .form-input:focus {
      border-color: var(--secondary);
      box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .form-row {
      display: flex;
      gap: 12px;
    }

    /* BOTTOM BAR */
    .pay-bar {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: var(--surface);
      padding: 16px;
      box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.05);
      border-top: 1px solid var(--border);
    }

    .pay-button {
      width: 100%;
      max-width: 440px;
      margin: auto;
      background: var(--primary);
      color: white;
      padding: 18px;
      border: none;
      border-radius: 12px;
      font-weight: 700;
      font-size: 17px;
      font-family: var(--font-head);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      transition: all 0.3s;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .pay-button:hover {
      background: var(--secondary);
      transform: translateY(-2px);
      box-shadow: 0 15px 30px rgba(37, 99, 235, 0.2);
    }

    /* OVERLAYS */
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255, 255, 255, 0.95);
      z-index: 100;
      display: none;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .spinner {
      width: 40px;
      height: 40px;
      border: 4px solid #f3f3f3;
      border-top: 4px solid var(--secondary);
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin-bottom: 16px;
    }

    .success-icon {
      width: 80px;
      height: 80px;
      background: #10b981;
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 40px;
      margin-bottom: 20px;
      box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
      animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .badge-container {
      display: flex;
      justify-content: center;
      gap: 12px;
      margin-top: 16px;
      opacity: 0.6;
    }

    .trust-badge {
      font-size: 10px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .upi-apps {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
      margin: 12px 0;
    }

    .upi-app-btn {
      border: 1.5px solid var(--border);
      border-radius: 12px;
      padding: 10px;
      text-align: center;
      cursor: pointer;
      transition: all 0.2s;
      background: white;
    }

    .upi-app-btn:hover {
      border-color: var(--secondary);
      background: #fffbf2;
    }

    .upi-app-btn img {
      height: 24px;
      display: block;
      margin: 0 auto 4px;
    }

    .upi-app-btn span {
      font-size: 11px;
      font-weight: 600;
      color: var(--primary);
    }

    .qr-toggle {
      text-align: center;
      margin-top: 12px;
      padding-top: 12px;
      border-top: 1px dashed var(--border);
    }

    .qr-link {
      color: var(--secondary);
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: underline;
    }

    .qr-container {
      display: none;
      text-align: center;
      padding: 20px;
      background: #fdfdfd;
      border-radius: 12px;
      margin-top: 10px;
    }

    .qr-placeholder {
      width: 150px;
      height: 150px;
      background: #eee;
      margin: 0 auto 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @keyframes pop {
      0% { transform: scale(0); }
      100% { transform: scale(1); }
    }
  </style>
</head>

<body>

  <header class="checkout-header">
    <div class="brand">ASPORD <span>PAY</span></div>
    <div class="secure-badge">
      Secure Process
      <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24">
        <path
          d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z" />
      </svg>
    </div>
  </header>

  <div class="container">

    <!-- Summary Card -->
    <div class="card">
      <div class="summary-header">
        <div class="summary-title">Amount to Pay</div>
        <div class="order-total-large" id="displayTotal">₹0.00</div>
      </div>
      <div class="item-list" id="itemList">
        <!-- Items injected here -->
      </div>
    </div>

    <div class="section-title">Select Payment Method</div>

    <!-- UPI -->
    <div class="payment-method active" onclick="selectMethod(this, 'upi')">
      <div class="method-header">
        <div class="radio-custom"></div>
        <div class="method-info">
          <div class="method-title">UPI / Valid VPA</div>
          <div class="method-icons">
            <span style="font-size: 10px; background: #e0e0e0; padding: 2px 4px; border-radius: 3px;">GPay</span>
            <span style="font-size: 10px; background: #e0e0e0; padding: 2px 4px; border-radius: 3px;">PhonePe</span>
            <span style="font-size: 10px; background: #e0e0e0; padding: 2px 4px; border-radius: 3px;">BHIM</span>
          </div>
        </div>
      </div>
      <div class="method-body">
        <div class="upi-apps">
          <div class="upi-app-btn" onclick="simulateUPI('GPay')">
            <i class="fab fa-google-pay" style="font-size: 24px; color: #4285F4;"></i>
            <span>GPay</span>
          </div>
          <div class="upi-app-btn" onclick="simulateUPI('PhonePe')">
            <i class="fas fa-wallet" style="font-size: 20px; color: #5f259f;"></i>
            <span>PhonePe</span>
          </div>
          <div class="upi-app-btn" onclick="simulateUPI('Paytm')">
            <i class="fas fa-university" style="font-size: 20px; color: #00baf2;"></i>
            <span>Paytm</span>
          </div>
        </div>

        <div class="input-group">
          <label class="input-label">Or enter UPI ID</label>
          <input type="text" class="form-input" placeholder="e.g. 9876543210@upi">
        </div>

        <div class="qr-toggle">
          <span class="qr-link" onclick="toggleQR()"><i class="fas fa-qrcode"></i> Show QR Code</span>
          <div id="qrContainer" class="qr-container">
            <div class="qr-placeholder">
               <i class="fas fa-qrcode fa-5x" style="color: #333;"></i>
            </div>
            <p style="font-size: 11px; color: #666;">Scan this code with any UPI app to pay</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Card -->
    <div class="payment-method" onclick="selectMethod(this, 'card')">
      <div class="method-header">
        <div class="radio-custom"></div>
        <div class="method-info">
          <div class="method-title">Credit / Debit Card</div>
          <div class="method-icons">
            <span style="font-size: 10px; background: #e0e0e0; padding: 2px 4px; border-radius: 3px;">VISA</span>
            <span style="font-size: 10px; background: #e0e0e0; padding: 2px 4px; border-radius: 3px;">MasterCard</span>
          </div>
        </div>
      </div>
      <div class="method-body">
        <div class="input-group">
          <label class="input-label">Card Number</label>
          <input type="text" class="form-input" placeholder="0000 0000 0000 0000" maxlength="19">
        </div>
        <div class="form-row">
          <div class="input-group" style="flex:1">
            <label class="input-label">Expiry</label>
            <input type="text" class="form-input" placeholder="MM/YY" maxlength="5">
          </div>
          <div class="input-group" style="flex:1">
            <label class="input-label">CVV</label>
            <input type="password" class="form-input" placeholder="123" maxlength="3">
          </div>
        </div>
      </div>
    </div>

    <!-- Cash -->
    <div class="payment-method" onclick="selectMethod(this, 'cash')">
      <div class="method-header">
        <div class="radio-custom"></div>
        <div class="method-info">
          <div class="method-title">Cash at Counter</div>
          <div class="method-icons" style="color:#666; font-size:12px;">Pay directly after ordering</div>
        </div>
      </div>
    </div>

    <!-- Trust Badges -->
    <div class="badge-container">
      <div class="trust-badge"><i class="fas fa-shield-alt"></i> PCI DSS</div>
      <div class="trust-badge"><i class="fas fa-lock"></i> 128-bit SSL</div>
      <div class="trust-badge"><i class="fas fa-check-circle"></i> VAA Verified</div>
    </div>

    <div style="height: 60px;"></div> <!-- Spacer -->

  </div>

  <!-- Sticky Pay Button -->
  <div class="pay-bar">
    <button class="pay-button" id="payButton" onclick="processPayment()">
      Pay <span id="btnAmount">₹0</span> <i class="fas fa-lock"></i>
    </button>
  </div>

  <!-- Processing Overlay -->
  <div class="overlay" id="loadingOverlay">
    <div class="spinner"></div>
    <h3>Processing Securely...</h3>
    <p style="font-size:13px; color:#666;">Do not close this window</p>
  </div>

  <!-- Success Overlay -->
  <div class="overlay" id="successOverlay">
    <div class="success-icon">✓</div>
    <h2>Payment Successful!</h2>
    <p>Your order has been placed.</p>
  </div>

  <script>
    // Load Data
    const cart = JSON.parse(sessionStorage.getItem("aspord_cart"));
    if (!cart) {
      window.location.href = "home.php";
    }

    let total = 0;
    const itemList = document.getElementById("itemList");

    Object.keys(cart).forEach(name => {
      const item = cart[name];
      const sum = item.price * item.qty;
      total += sum;

      itemList.innerHTML += `
                <div class="item-row">
                    <span>${name} <span style="color:#888; font-size:12px;">x${item.qty}</span></span>
                    <span>₹${sum}</span>
                </div>
            `;
    });

    // Add taxes/fees dummy
    const tax = Math.round(total * 0.05);
    const grandTotal = total + tax;

    itemList.innerHTML += `
            <hr class="divider">
            <div class="item-row">
                <span style="color:#666;">Taxes & Charges (5%)</span>
                <span>₹${tax}</span>
            </div>
            <div class="item-row" style="font-weight:700; font-size:16px; margin-top:8px;">
                <span>Grand Total</span>
                <span>₹${grandTotal}</span>
            </div>
        `;

    document.getElementById("displayTotal").textContent = "₹" + grandTotal;
    document.getElementById("btnAmount").textContent = "₹" + grandTotal;

    // Interaction
    let selectedMethod = 'upi';

    function selectMethod(el, method) {
      document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
      el.classList.add('active');
      selectedMethod = method;

      const btn = document.getElementById('payButton');
      if (method === 'cash') {
        btn.innerHTML = `Place Order (Pay Cash) <i class="fas fa-chevron-right"></i>`;
        btn.style.background = "#4b5563";
      } else {
        btn.innerHTML = `Pay ₹${grandTotal} <i class="fas fa-lock"></i>`;
        btn.style.background = "#d97706";
      }
    }

    function toggleQR() {
      const qr = document.getElementById('qrContainer');
      const isVisible = qr.style.display === 'block';
      qr.style.display = isVisible ? 'none' : 'block';
      document.querySelector('.qr-link').innerHTML = isVisible ? 
        '<i class="fas fa-qrcode"></i> Show QR Code' : 
        '<i class="fas fa-times"></i> Hide QR Code';
    }

    function simulateUPI(app) {
      const input = document.querySelector('.payment-method.active input');
      input.value = `paying-via-${app.toLowerCase()}@upi`;
      processPayment();
    }

    // Card Formatting
    const cardInput = document.querySelector('input[placeholder="0000 0000 0000 0000"]');
    if(cardInput) {
      cardInput.addEventListener('input', (e) => {
        let val = e.target.value.replace(/\D/g, '');
        let formatted = val.match(/.{1,4}/g)?.join(' ') || val;
        e.target.value = formatted.substring(0, 19);
      });
    }

    async function processPayment() {
      if (selectedMethod === 'upi') {
        const upiInput = document.querySelector('.payment-method.active input').value.trim();
        if (!upiInput) {
          alert('Please enter a valid UPI ID');
          return;
        }
      } else if (selectedMethod === 'card') {
        const inputs = document.querySelectorAll('.payment-method.active input');
        let valid = true;
        inputs.forEach(inp => { if (!inp.value.trim()) valid = false; });
        if (!valid) {
          alert('Please enter all card details');
          return;
        }
      }

      const loading = document.getElementById('loadingOverlay');
      const loadMsg = loading.querySelector('h3');
      const success = document.getElementById('successOverlay');

      loading.style.display = 'flex';
      
      const steps = [
        "Connecting to secure bank gateway...",
        "Requesting authorization...",
        "Encrypting transaction data...",
        "Verifying payment status..."
      ];

      for (let step of steps) {
        loadMsg.textContent = step;
        await new Promise(r => setTimeout(r, 600));
      }

      const currentCart = JSON.parse(sessionStorage.getItem("aspord_cart"));
      const orderData = {
          cart: currentCart,
          total: grandTotal
      };

      fetch('api/place_order.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          credentials: 'include',
          body: JSON.stringify(orderData)
      })
      .then(res => res.json())
      .then(data => {
          loading.style.display = 'none';
          if (data.success) {
               success.style.display = 'flex';
               let history = JSON.parse(sessionStorage.getItem("aspord_order_history")) || [];
               history.push({
                  id: data.order.order_id,
                  time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                  items: currentCart,
                  status: 'Paid',
                  method: selectedMethod.toUpperCase()
               });
               sessionStorage.setItem("aspord_order_history", JSON.stringify(history));
               sessionStorage.removeItem("aspord_cart");
               setTimeout(() => { window.location.href = "extrafood.php"; }, 2000);
          } else {
               alert('Order Failed: ' + (data.error || 'Unknown Error'));
          }
      })
      .catch(err => {
          loading.style.display = 'none';
          alert('Network Error: ' + err.message);
      });
    }
  </script>

</body>

</html>