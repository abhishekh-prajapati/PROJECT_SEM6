<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASPORD | Order Now</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --bg-main: #fdfdfd;
            --text-dark: #1a1d23;
            --text-body: #4b5563;
            --border-soft: #e5e7eb;
            --accent: #2563eb;
            --font-head: 'Outfit', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--bg-main);
            color: var(--text-body);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-container {
            text-align: center;
            width: 100%;
            max-width: 600px;
            padding: 24px;
            animation: fadeIn 1s ease-out;
        }

        .minimal-logo {
            font-family: var(--font-head);
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--text-dark);
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .minimal-logo i {
            font-size: 18px;
            color: var(--accent);
        }

        .hero-heading {
            font-family: var(--font-head);
            font-size: clamp(3rem, 10vw, 4.5rem);
            font-weight: 800;
            line-height: 1.1;
            color: var(--text-dark);
            margin-bottom: 20px;
            letter-spacing: -2px;
        }

        .hero-subtext {
            font-size: 18px;
            line-height: 1.6;
            color: var(--text-body);
            margin-bottom: 48px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: var(--text-dark);
            color: #fff;
            padding: 18px 40px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-family: var(--font-head);
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .cta-button:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
            background: var(--accent);
        }

        .cta-button i {
            font-size: 14px;
            transition: transform 0.3s ease;
        }

        .cta-button:hover i {
            transform: translateX(4px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Subtle background elements */
        .ambient-glow {
            position: absolute;
            width: 400px;
            height: 400px;
            background: var(--accent);
            filter: blur(120px);
            opacity: 0.05;
            z-index: -1;
            border-radius: 50%;
        }

        .glow-1 { top: -100px; left: -100px; }
        .glow-2 { bottom: -100px; right: -100px; }
    </style>
</head>

<body>
    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>

    <div class="hero-container">
        <div class="minimal-logo">
            <i class="fas fa-utensils"></i> ASPORD
        </div>
        
        <h1 class="hero-heading">Simply Great Dining.</h1>
        
        <p class="hero-subtext">Premium table-side ordering designed for the modern guest.</p>
        
        <a href="home.php" class="cta-button">
            Start Your Order <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    <script>
        // Capture Table Number from URL (e.g., index.php?t=04)
        const urlParams = new URLSearchParams(window.location.search);
        const table = urlParams.get('t') || urlParams.get('table') || 'T-04';
        sessionStorage.setItem('aspord_table', table);
        console.log('Table assigned:', table);
    </script>
</body>

</html>