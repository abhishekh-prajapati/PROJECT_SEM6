<?php
session_start();
if (!isset($_SESSION['verified']) || $_SESSION['verified'] !== true) {
    header('Location: home.php');
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Status | ASPORD</title>
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
            --border-soft: #e2e8f0;
            --accent: #2563eb;
            --success: #10b981;
            --font-head: 'Outfit', sans-serif;
            --font-body: 'Inter', sans-serif;
            /* Legacy Support */
            --obsidian: #0f172a;
            --gold: #2563eb;
            --secondary: #2563eb;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-body);
            background: var(--bg-main);
            color: var(--text-body);
            padding-bottom: 140px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            padding: 0 20px;
        }

        /* ===== STATUS HEADER ===== */
        .status-header {
            background: var(--surface);
            padding: 80px 20px 60px;
            text-align: center;
            border-bottom: 1px solid var(--border-soft);
            margin-bottom: 0;
        }

        .status-icon {
            width: 80px;
            height: 80px;
            background: #ecfdf5;
            color: var(--success);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 24px;
            border-radius: 50%;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.1);
        }

        .status-title {
            font-family: var(--font-head);
            font-size: 40px;
            font-weight: 800;
            margin-bottom: 10px;
            color: var(--text-dark);
            letter-spacing: -1.5px;
        }

        .status-subtitle {
            font-size: 15px;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* ===== ACCORDION SUMMARY ===== */
        .order-summary-box {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }

        .summary-toggle {
            width: 100%;
            padding: 20px 24px;
            background: white;
            border: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            color: var(--obsidian);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .summary-toggle:after {
            content: '\f078'; /* FontAwesome chevron-down */
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 12px;
            transition: transform 0.3s;
        }

        .summary-toggle.active:after { transform: rotate(180deg); }

        .summary-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            background: #f8fafc;
        }

        .summary-content.active { max-height: 1000px; }

        .summary-inner { padding: 30px 24px; }

        .summary-item {
            display: flex;
            justify-content: space-between;
            font-size: 15px;
            margin-bottom: 12px;
            color: var(--text-body);
            font-weight: 500;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-weight: 800;
            font-size: 20px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 2px solid var(--text-dark);
            color: var(--text-dark);
            font-family: var(--font-head);
        }

        .receipt-btn {
            display: block;
            width: 100%;
            margin-top: 30px;
            padding: 18px;
            background: var(--text-dark);
            color: white;
            border-radius: 12px;
            border: none;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s;
        }

        .receipt-btn:hover {
            background: var(--accent);
            transform: translateY(-2px);
        }

        .status-pill {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pill.pending { background: #fff7ed; color: #c2410c; }
        .status-pill.done { background: #f0fdf4; color: #15803d; }

        /* ===== DIGITAL RECEIPT CARD ===== */
        .glass-card {
            background: var(--surface);
            border: 1px solid var(--border-soft);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            margin: 60px auto;
            max-width: 540px;
            overflow: hidden;
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .bill-header {
            padding: 50px 20px;
            background: var(--text-dark);
            color: white;
            text-align: center;
            border-bottom: 2px dashed rgba(255,255,255,0.2);
        }

        .bill-header h2 {
            margin: 0;
            font-size: 28px;
            font-family: var(--font-head);
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .bill-header #billDate {
            margin-top: 12px;
            font-size: 13px;
            font-weight: 500;
            opacity: 0.8;
            letter-spacing: 1px;
        }

        .compact-food-list {
            padding: 30px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .food-tag {
            background: #f8fafc;
            padding: 16px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            border: 1px solid var(--border-soft);
        }

        .food-tag .name {
            color: var(--text-dark);
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
        }

        .food-tag .qty {
            color: var(--accent);
            font-weight: 800;
            font-size: 14px;
        }

        .details-toggle {
            width: 100%;
            padding: 18px 30px;
            background: #ffffff;
            border: none;
            border-top: 1px solid var(--border-soft);
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-muted);
            transition: all 0.2s;
        }

        .details-toggle:hover { color: var(--text-dark); background: #f8fafc; }

        .bill-table-container {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            background: white;
        }

        .bill-table-container.active { max-height: 2000px; }

        .bill-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .bill-table td {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-soft);
            color: var(--text-dark);
        }

        .bill-table td strong {
            color: var(--text-muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .download-bar {
            padding: 40px 20px;
            text-align: center;
            background: #f8fafc;
            border-top: 1px solid var(--border-soft);
        }

        .download-btn {
            background: var(--text-dark);
            color: white;
            border: none;
            padding: 18px 40px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 15px;
            font-family: var(--font-head);
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .download-btn:hover {
            background: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(37, 99, 235, 0.2);
        }

        /* ===== UPSELL & MENU ===== */
        .upsell-header {
            padding: 80px 20px 40px;
            text-align: center;
        }

        .upsell-header h3 {
            font-family: var(--font-head);
            font-size: 36px;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            letter-spacing: -1px;
        }

        .upsell-header p {
            font-size: 15px;
            color: var(--text-muted);
            margin-top: 8px;
            font-weight: 500;
        }

        .categories-wrapper {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border-soft);
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
            padding: 12px 24px;
            border-radius: 99px;
            font-size: 13px;
            font-weight: 700;
            background: white;
            border: 1px solid var(--border-soft);
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.3s;
        }

        .categories span.active {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.2);
        }

        .menu-grid {
            display: flex;
            flex-direction: column;
            background: white;
        }

        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @media print {
            body * { visibility: hidden; }
            #digitalBill, #digitalBill * { visibility: visible; }
            #digitalBill {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                box-shadow: none;
                border: none;
            }
            .download-bar, .details-toggle { display: none !important; }
            .bill-header { background: #000 !important; color: #fff !important; -webkit-print-color-adjust: exact; }
        }

        /* REUSE MENU CSS */
        .menu-grid {
            display: flex;
            flex-direction: column;
            gap: 0;
            padding-bottom: 40px;
            background: var(--sand);
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
        }

        .menu-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }

        .diet-icon {
            width: 16px;
            height: 16px;
            border: 2px solid;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .diet-icon.veg {
            border-color: #24963f;
        }

        .diet-icon.veg::after {
            content: "";
            width: 8px;
            height: 8px;
            background: #24963f;
            border-radius: 50%;
        }

        .diet-icon.nonveg {
            border-color: #dc2626; /* Red */
        }

        .diet-icon.nonveg::after {
            content: "▲";
            font-size: 10px;
            color: #dc2626;
            line-height: 0;
            position: relative;
            top: -1px;
        }

        .spicy-icon {
            color: #ea580c;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
        }
        .bill-table-container {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            background: white;
        }

        .bill-table-container.active {
            max-height: 1000px;
        }

        .bill-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            text-align: left;
        }

        .bill-table th {
            padding: 12px 0;
            border-bottom: 1px solid var(--border-soft);
            color: var(--text-muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .bill-table td {
            padding: 16px 0;
            border-bottom: 1px solid var(--border-soft);
            color: var(--text-dark);
        }

        .bill-table td strong {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
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
            font-family: var(--font-serif);
            font-size: 24px;
            font-weight: 400;
            color: var(--obsidian);
            margin: 4px 0 2px;
            line-height: 1.1;
            text-transform: capitalize;
        }

        .menu-price {
            font-size: 16px;
            color: var(--text-main);
            margin-top: 4px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .menu-rating {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 8px;
        }

        .stars {
            background: var(--obsidian);
            color: var(--gold);
            padding: 2px 8px;
            border-radius: 2px;
            font-weight: 800;
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 4px;
            height: 22px;
        }

        .star-symbol {
            font-size: 9px;
        }

        .votes {
            font-size: 12px;
            color: #888;
            font-weight: 500;
        }

        .menu-desc {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-top: 4px;
        }

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

        /* ADD BTN & QTY */
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
            background: var(--obsidian);
            border: 1px solid var(--obsidian);
            color: white;
            font-weight: 700;
            font-size: 13px;
            border-radius: 4px;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .add-btn-z:hover {
            background: var(--gold);
            border-color: var(--gold);
            color: var(--obsidian);
            transform: translateY(-2px);
        }

        /* Removed ::after content "ADD" to fix duplication */

        .qty-control-z {
            width: 100%;
            height: 100%;
            background: var(--gold);
            color: var(--obsidian);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(197, 160, 89, 0.2);
        }

        .qty-control-z button {
            width: 28px;
            height: 100%;
            background: transparent;
            border: none;
            color: #d97706;
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

        /* CART BAR */
        .cart-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--surface);
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.15);
            padding: 16px 18px;
            display: none;
            z-index: 60;
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
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            border: none;
            padding: 14px 26px;
            border-radius: 999px;
            font-weight: 600;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- STATUS HEADER -->
    <div class="status-header">
        <div class="status-icon"><i class="fas fa-check"></i></div>
        <h1 class="status-title">Order Placed!</h1>
        <div class="status-subtitle">Kitchen has received your order</div>
    </div>

    <!-- FUTURISTIC DIGITAL BILL -->
    <div class="glass-card" id="digitalBill">
        <div class="bill-header">
            <h2>DIGITAL RECEIPT</h2>
            <div id="billDate"></div>
        </div>
        
        <!-- Compact Summary (Visual tags) -->
        <div class="compact-food-list" id="compactItems">
            <!-- Items injected here -->
        </div>

        <!-- Detailed Table -->
        <button class="details-toggle" onclick="toggleDetails(this)">
            <span><i class="fas fa-info-circle"></i> VIEW ORDER DETAILS</span>
            <i class="fas fa-chevron-down"></i>
        </button>
        <div class="bill-table-container" id="billCollapse">
            <div style="padding: 20px;">
                <table class="bill-table">
                    <thead>
                        <tr>
                            <th>Details</th>
                            <th>Information</th>
                        </tr>
                    </thead>
                    <tbody id="billTableBody">
                        <!-- Table rows injected here -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="download-bar">
            <button class="download-btn" onclick="downloadBill()">
                <i class="fas fa-file-pdf"></i> DOWNLOAD BILL
            </button>
        </div>
    </div>

    <!-- UPSELL HEADER -->
    <div class="container upsell-header">
        <h3>Still Hungry?</h3>
        <p>Add more items to your table immediately.</p>
    </div>

    <!-- SEARCH/FILTER STUBS FOR APP.JS COMPATIBILITY -->
    <div style="display:none">
        <input id="searchInput">
        <div id="searchSuggestions"></div>
        <div class="lang-switch">
            <button class="active" data-lang="en"></button>
        </div>
    </div>

    <!-- CATEGORIES -->
    <div class="categories-wrapper">
        <div class="categories container"></div>
    </div>

    <!-- MENU GRID -->
    <div class="menu-grid container" id="menu"></div>

    <!-- CART BAR -->
    <div class="cart-bar" id="cartBar">
        <div class="cart-inner">
            <div id="cartItems"></div>
            <div class="cart-footer">
                <strong id="cartTotal">₹0</strong>
                <button class="place-btn" onclick="placeOrder()">Place Order</button>
            </div>
        </div>
    </div>


    <!-- SCRIPTS -->
    <script>
        // 1. RENDER FUTURISTIC BILL
        const historyJson = sessionStorage.getItem("aspord_order_history");
        const userJson = localStorage.getItem("aspordUser");
        
        const compactContainer = document.getElementById("compactItems");
        const tableBody = document.getElementById("billTableBody");
        const dateElement = document.getElementById("billDate");

        if (historyJson) {
            try {
                const history = JSON.parse(historyJson);
                const user = userJson ? JSON.parse(userJson) : { name: "Guest", email: "N/A" };
                const now = new Date();
                
                dateElement.textContent = now.toLocaleDateString() + " | " + now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                let totalAmt = 0;
                let lastMethod = "CASH";
                let allItems = {};

                history.forEach(order => {
                    lastMethod = order.method || "CASH";
                    Object.keys(order.items).forEach(name => {
                        if(!allItems[name]) allItems[name] = 0;
                        allItems[name] += order.items[name].qty;
                        totalAmt += (order.items[name].qty * order.items[name].price);
                    });
                });

                // 1. Render Compact Tags
                Object.keys(allItems).forEach(name => {
                    compactContainer.innerHTML += `
                        <div class="food-tag">
                            <span class="name">${name}</span>
                            <span class="qty">x${allItems[name]}</span>
                        </div>
                    `;
                });

                // 2. Render Table Rows
                const rows = [
                    { label: "TABLE NUMBER", value: sessionStorage.getItem('aspord_table') || "T-04" },
                    { label: "CUSTOMER NAME", value: user.name },
                    { label: "EMAIL ID", value: user.email },
                    { label: "ORDER TIMING", value: now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) },
                    { label: "TOTAL PAYABLE", value: "₹" + (totalAmt + Math.round(totalAmt * 0.05)) },
                    { label: "PAYMENT METHOD", value: lastMethod },
                    { label: "PAYMENT STATUS", value: lastMethod === 'CASH' ? 
                        '<span class="status-pill pending">PAYMENT PENDING</span>' : 
                        '<span class="status-pill done">DONE</span>' }
                ];

                rows.forEach(row => {
                    tableBody.innerHTML += `
                        <tr>
                            <td><strong>${row.label}</strong></td>
                            <td>${row.value}</td>
                        </tr>
                    `;
                });

            } catch (e) {
                console.error("Error building bill:", e);
            }
        }

        function toggleDetails(btn) {
            btn.classList.toggle("active");
            const content = document.getElementById("billCollapse");
            content.classList.toggle("active");
        }

        function downloadBill() {
            // Ensure table is expanded for printing
            const content = document.getElementById("billCollapse");
            const wasActive = content.classList.contains("active");
            if(!wasActive) content.classList.add("active");

            window.print();
            
            showPopup("Bill Download Processed!", '<i class="fas fa-file-invoice"></i>');
        }
    </script>

    <!-- REUSE APP LOGIC FOR MENU -->

    <script>
      window.isVerified = <?php echo isset($_SESSION['verified']) && $_SESSION['verified'] === true ? 'true' : 'false'; ?>;
    </script>
    <script src="./app.js?v=<?php echo time(); ?>"></script>

</body>

</html>