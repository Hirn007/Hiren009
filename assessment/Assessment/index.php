<?php
/**
 * Smart Store API Suite
 * Developer Portal, Live Interactive API Playground & Section A Answers
 */

require_once __DIR__ . '/api/config/database.php';

$db = new Database();
$db_connected = false;
$db_message = "";

// Reset DB action for easy testing
if (isset($_GET['action']) && $_GET['action'] === 'reset_db') {
    try {
        $conn = $db->getConnection();
        $conn->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $conn->exec("DROP TABLE IF EXISTS `order_items`;");
        $conn->exec("DROP TABLE IF EXISTS `orders`;");
        $conn->exec("DROP TABLE IF EXISTS `products`;");
        $conn->exec("DROP TABLE IF EXISTS `users`;");
        $conn->exec("SET FOREIGN_KEY_CHECKS = 1;");
        
        // Re-establish connection which triggers auto-migration and seeds
        $db = new Database();
        $db->getConnection();
        
        header("Location: index.php?status=db_reset_success");
        exit();
    } catch (Exception $e) {
        $db_message = "Error resetting database: " . $e->getMessage();
    }
}

try {
    $conn = $db->getConnection();
    if ($conn) {
        $db_connected = true;
        $db_message = "Connected to MySQL. Schema fully migrated and seeded!";
    }
} catch (Exception $e) {
    $db_connected = false;
    $db_message = "Database offline: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Store API Suite - Developer Portal</title>
    
    <!-- SEO Optimization -->
    <meta name="description" content="Professional developer portal, live interactive playground, and comprehensive assessment solution for the Smart Store REST API Suite.">
    <meta name="author" content="Antigravity AI">
    
    <!-- Premium Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Premium Custom Styles (Vanilla CSS) -->
    <style>
        :root {
            --bg-dark: hsl(222, 47%, 9%);
            --bg-card: hsla(223, 47%, 14%, 0.6);
            --bg-card-hover: hsla(223, 47%, 18%, 0.8);
            --text-main: hsl(210, 40%, 96%);
            --text-muted: hsl(215, 20%, 65%);
            --accent: hsl(217, 91%, 60%);
            --accent-purple: hsl(263, 70%, 50%);
            --accent-green: hsl(142, 70%, 45%);
            --accent-red: hsl(0, 72%, 51%);
            --border: hsla(217, 30%, 20%, 0.5);
            --border-glow: hsla(217, 91%, 60%, 0.2);
            --font-outfit: 'Outfit', sans-serif;
            --font-code: 'Fira Code', monospace;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: var(--font-outfit);
            min-height: 100vh;
            line-height: 1.6;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 10% 20%, hsla(217, 91%, 60%, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, hsla(263, 70%, 50%, 0.08) 0%, transparent 40%);
        }

        /* Container Layout */
        .wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header section */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 3rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-icon {
            font-size: 2.2rem;
            background: linear-gradient(135deg, var(--accent), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 10px rgba(59, 130, 246, 0.3));
        }

        .logo-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .logo-title p {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* Live status badge */
        .status-panel {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: var(--bg-card);
            border: 1px solid var(--border);
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            backdrop-filter: blur(12px);
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: var(--accent-green);
            box-shadow: 0 0 12px var(--accent-green);
            position: relative;
        }

        .status-dot.offline {
            background-color: var(--accent-red);
            box-shadow: 0 0 12px var(--accent-red);
        }

        .status-dot.pulse::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: inherit;
            top: 0;
            left: 0;
            animation: pulse-ring 1.8s infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(2.5); opacity: 0; }
        }

        .status-panel span {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .btn-reset-db {
            background: rgba(239, 68, 68, 0.1);
            color: hsl(0, 84%, 60%);
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 0.4rem 1rem;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-smooth);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-reset-db:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.4);
            transform: translateY(-2px);
        }

        /* Tabs Navigation */
        .tabs-nav {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            background: var(--bg-card);
            padding: 0.5rem;
            border-radius: 12px;
            border: 1px solid var(--border);
            max-width: 600px;
        }

        .tab-btn {
            flex: 1;
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 0.8rem 1rem;
            font-family: var(--font-outfit);
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .tab-btn:hover {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.03);
        }

        .tab-btn.active {
            color: var(--text-main);
            background: var(--accent);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        /* Tabs Content */
        .tab-content {
            display: none;
            animation: fadeIn 0.4s ease forwards;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- Section A (Concept Application) styling --- */
        .accordion {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .accordion-item {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            transition: var(--transition-smooth);
        }

        .accordion-item:hover {
            border-color: var(--accent);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.05);
        }

        .accordion-header {
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }

        .accordion-header h3 {
            font-size: 1.15rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .accordion-header h3 i {
            color: var(--accent);
            font-size: 1.1rem;
        }

        .accordion-arrow {
            font-size: 1rem;
            color: var(--text-muted);
            transition: transform 0.3s ease;
        }

        .accordion-item.active .accordion-arrow {
            transform: rotate(180deg);
            color: var(--accent);
        }

        .accordion-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0, 1, 0, 1);
            background: rgba(0, 0, 0, 0.15);
            border-top: 1px solid transparent;
        }

        .accordion-item.active .accordion-body {
            max-height: 2000px; /* high value for auto height smooth transition */
            border-top: 1px solid var(--border);
            transition: max-height 0.4s cubic-bezier(1, 0, 1, 0);
        }

        .accordion-inner-content {
            padding: 1.5rem;
        }

        .accordion-inner-content p {
            color: var(--text-muted);
            margin-bottom: 1rem;
            font-size: 1.05rem;
        }

        .accordion-inner-content ul {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
            color: var(--text-muted);
        }

        .accordion-inner-content li {
            margin-bottom: 0.5rem;
        }

        .accordion-inner-content strong {
            color: var(--text-main);
        }

        /* Beautiful callout boxes in Section A responses */
        .explain-card {
            background: rgba(59, 130, 246, 0.05);
            border-left: 4px solid var(--accent);
            padding: 1rem;
            border-radius: 0 8px 8px 0;
            margin: 1.2rem 0;
        }

        .explain-card p {
            margin: 0;
            font-size: 0.95rem;
            font-style: italic;
        }

        /* Code snippets in answers */
        pre.inline-code-box {
            background: hsl(223, 47%, 7%);
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-family: var(--font-code);
            font-size: 0.9rem;
            overflow-x: auto;
            margin: 1rem 0;
            color: hsl(210, 40%, 90%);
        }

        /* --- API Sandbox Styling --- */
        .sandbox-layout {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 2rem;
            align-items: start;
        }

        @media (max-width: 992px) {
            .sandbox-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Sidebar Navigation */
        .endpoints-list {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem;
            max-height: 700px;
            overflow-y: auto;
        }

        .sidebar-section-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin: 1.2rem 0 0.6rem 0;
            padding-bottom: 0.3rem;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-section-title:first-child {
            margin-top: 0;
        }

        .endpoint-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.75rem 0.85rem;
            border-radius: 8px;
            cursor: pointer;
            margin-bottom: 0.4rem;
            transition: var(--transition-smooth);
            border: 1px solid transparent;
        }

        .endpoint-item:hover {
            background: rgba(255, 255, 255, 0.02);
            border-color: var(--border);
        }

        .endpoint-item.active {
            background: rgba(59, 130, 246, 0.08);
            border-color: rgba(59, 130, 246, 0.3);
        }

        /* HTTP method badges */
        .method-badge {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            width: 60px;
            text-align: center;
            font-family: var(--font-code);
        }

        .method-badge.get { background: rgba(16, 185, 129, 0.1); color: hsl(142, 70%, 45%); }
        .method-badge.post { background: rgba(59, 130, 246, 0.1); color: hsl(217, 91%, 60%); }
        .method-badge.put { background: rgba(245, 158, 11, 0.1); color: hsl(38, 92%, 50%); }
        .method-badge.delete { background: rgba(239, 68, 68, 0.1); color: hsl(0, 84%, 60%); }

        .endpoint-uri {
            font-size: 0.85rem;
            font-family: var(--font-code);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Sandbox Main Panel */
        .sandbox-panel {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            padding-bottom: 1rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .panel-title h2 {
            font-size: 1.4rem;
            font-weight: 600;
        }

        .panel-title p {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* JWT Authentication Block */
        .auth-bar {
            background: rgba(263, 70, 50, 0.04);
            border: 1px solid rgba(263, 70, 50, 0.15);
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .auth-bar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .auth-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: hsl(263, 90%, 75%);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .auth-inputs {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .input-text {
            flex: 1;
            min-width: 250px;
            background: hsl(223, 47%, 7%);
            border: 1px solid var(--border);
            color: var(--text-main);
            padding: 0.6rem 1rem;
            border-radius: 6px;
            font-family: var(--font-code);
            font-size: 0.85rem;
            transition: var(--transition-smooth);
        }

        .input-text:focus {
            border-color: var(--accent-purple);
            outline: none;
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.15);
        }

        .btn-action {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-smooth);
            font-family: var(--font-outfit);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-action:hover {
            transform: translateY(-1px);
            filter: brightness(1.1);
        }

        .btn-purple {
            background: var(--accent-purple);
        }

        /* Dynamic playground grid */
        .playground-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .playground-grid {
                grid-template-columns: 1fr;
            }
        }

        .block-title {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        /* Request Body Editor */
        .editor-container {
            position: relative;
            height: 380px;
            border-radius: 8px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .json-textarea {
            width: 100%;
            height: 100%;
            background: hsl(223, 47%, 6%);
            color: hsl(210, 40%, 90%);
            border: none;
            padding: 1rem;
            font-family: var(--font-code);
            font-size: 0.85rem;
            resize: none;
            outline: none;
            line-height: 1.5;
        }

        /* Response Display */
        .response-container {
            background: hsl(223, 47%, 5%);
            border: 1px solid var(--border);
            border-radius: 8px;
            height: 380px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .response-meta {
            background: rgba(0, 0, 0, 0.2);
            padding: 0.6rem 1rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
        }

        .status-badge {
            background: rgba(255, 255, 255, 0.05);
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-family: var(--font-code);
            font-weight: 700;
        }

        .status-badge.success-code {
            background: rgba(16, 185, 129, 0.1);
            color: var(--accent-green);
        }

        .status-badge.error-code {
            background: rgba(239, 68, 68, 0.1);
            color: var(--accent-red);
        }

        .response-body {
            padding: 1rem;
            overflow-y: auto;
            flex: 1;
            font-family: var(--font-code);
            font-size: 0.85rem;
            color: hsl(120, 39%, 54%); /* hacker/editor green style response */
            white-space: pre-wrap;
            word-break: break-all;
        }

        .response-body.error-text {
            color: hsl(0, 84%, 65%);
        }

        .response-body.loading-text {
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            font-style: italic;
        }

        /* Footer block */
        footer {
            margin-top: 5rem;
            border-top: 1px solid var(--border);
            padding-top: 2rem;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
            padding-bottom: 2rem;
        }

        footer a {
            color: var(--accent);
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        footer a:hover {
            color: var(--text-main);
        }

        /* Submission Package Card */
        .package-box {
            background: linear-gradient(135deg, hsla(217, 91%, 60%, 0.04), hsla(263, 70%, 50%, 0.04));
            border: 1px solid rgba(59, 130, 246, 0.15);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .package-info h3 {
            font-size: 1.2rem;
            margin-bottom: 0.3rem;
            color: hsl(210, 40%, 98%);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .package-info h3 i {
            color: var(--accent);
        }

        .package-info p {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .package-actions {
            display: flex;
            gap: 1rem;
        }

        .btn-download {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
            border: 1px solid rgba(59, 130, 246, 0.2);
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-download:hover {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
        }

        /* Responsive utility tables */
        .schema-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            font-size: 0.9rem;
        }

        .schema-table th, .schema-table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .schema-table th {
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-main);
            font-weight: 600;
        }

        .schema-table td {
            color: var(--text-muted);
        }

        .schema-table code {
            font-family: var(--font-code);
            color: hsl(263, 90%, 80%);
            background: rgba(139, 92, 246, 0.1);
            padding: 0.15rem 0.3rem;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <!-- Header -->
        <header>
            <div class="logo-area">
                <i class="fa-solid fa-store logo-icon"></i>
                <div class="logo-title">
                    <h1>Smart Store API Suite</h1>
                    <p>TOPS Technologies - Professional Web Services Assessment</p>
                </div>
            </div>
            <div class="status-panel">
                <div class="status-dot pulse <?php echo $db_connected ? '' : 'offline'; ?>"></div>
                <span>Server Status: <strong><?php echo $db_connected ? 'Active' : 'Offline'; ?></strong></span>
                <a href="index.php?action=reset_db" class="btn-reset-db" title="Wipes all tables, runs migrations, and inserts default seeds!">
                    <i class="fa-solid fa-arrows-rotate"></i> Reset Database State
                </a>
            </div>
        </header>

        <!-- Database Alert Status -->
        <?php if (isset($_GET['status']) && $_GET['status'] === 'db_reset_success'): ?>
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid var(--accent-green); border-radius: 8px; padding: 1rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.8rem;">
                <i class="fa-solid fa-circle-check" style="color: var(--accent-green); font-size: 1.2rem;"></i>
                <span style="color: var(--text-main); font-size: 0.95rem; font-weight: 500;">Database successfully reset, structure migrated, and core catalog data re-seeded!</span>
            </div>
        <?php endif; ?>

        <!-- Submission Download Banner -->
        <div class="package-box">
            <div class="package-info">
                <h3><i class="fa-solid fa-box-archive"></i> Smart Store Submission Package</h3>
                <p>Complete self-contained bundle including clean source code, auto-database initializer, exported Postman Collections, and full documentation.</p>
            </div>
            <div class="package-actions">
                <a href="Smart_Store_API_Suite.postman_collection.json" download class="btn-download">
                    <i class="fa-solid fa-file-code"></i> Download Postman Collection
                </a>
                <a href="smart_store.sql" download class="btn-download">
                    <i class="fa-solid fa-database"></i> Download Database SQL
                </a>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <nav class="tabs-nav">
            <button class="tab-btn active" onclick="switchTab(event, 'playground-tab')">
                <i class="fa-solid fa-circle-play"></i> Interactive Playground
            </button>
            <button class="tab-btn" onclick="switchTab(event, 'section-a-tab')">
                <i class="fa-solid fa-circle-question"></i> Section A Answers
            </button>
            <button class="tab-btn" onclick="switchTab(event, 'database-tab')">
                <i class="fa-solid fa-database"></i> Schema & Setup
            </button>
        </nav>

        <!-- TAB: Playground -->
        <section id="playground-tab" class="tab-content active">
            <div class="sandbox-layout">
                <!-- Sidebar endpoints selection -->
                <aside class="endpoints-list">
                    <div class="sidebar-section-title">Authentication</div>
                    <div class="endpoint-item active" onclick="loadEndpoint('auth-register')">
                        <span class="method-badge post">POST</span>
                        <span class="endpoint-uri">/auth?action=register</span>
                    </div>
                    <div class="endpoint-item" onclick="loadEndpoint('auth-login')">
                        <span class="method-badge post">POST</span>
                        <span class="endpoint-uri">/auth?action=login</span>
                    </div>

                    <div class="sidebar-section-title">Products Resource</div>
                    <div class="endpoint-item" onclick="loadEndpoint('products-get-all')">
                        <span class="method-badge get">GET</span>
                        <span class="endpoint-uri">/products</span>
                    </div>
                    <div class="endpoint-item" onclick="loadEndpoint('products-get-single')">
                        <span class="method-badge get">GET</span>
                        <span class="endpoint-uri">/products?id={id}</span>
                    </div>
                    <div class="endpoint-item" onclick="loadEndpoint('products-create')">
                        <span class="method-badge post">POST</span>
                        <span class="endpoint-uri">/products</span>
                    </div>
                    <div class="endpoint-item" onclick="loadEndpoint('products-update')">
                        <span class="method-badge put">PUT</span>
                        <span class="endpoint-uri">/products?id={id}</span>
                    </div>
                    <div class="endpoint-item" onclick="loadEndpoint('products-delete')">
                        <span class="method-badge delete">DELETE</span>
                        <span class="endpoint-uri">/products?id={id}</span>
                    </div>

                    <div class="sidebar-section-title">User Profiles</div>
                    <div class="endpoint-item" onclick="loadEndpoint('users-get-profile')">
                        <span class="method-badge get">GET</span>
                        <span class="endpoint-uri">/users</span>
                    </div>
                    <div class="endpoint-item" onclick="loadEndpoint('users-update-profile')">
                        <span class="method-badge put">PUT</span>
                        <span class="endpoint-uri">/users</span>
                    </div>

                    <div class="sidebar-section-title">Orders Resource</div>
                    <div class="endpoint-item" onclick="loadEndpoint('orders-get-all')">
                        <span class="method-badge get">GET</span>
                        <span class="endpoint-uri">/orders</span>
                    </div>
                    <div class="endpoint-item" onclick="loadEndpoint('orders-get-single')">
                        <span class="method-badge get">GET</span>
                        <span class="endpoint-uri">/orders?id={id}</span>
                    </div>
                    <div class="endpoint-item" onclick="loadEndpoint('orders-create')">
                        <span class="method-badge post">POST</span>
                        <span class="endpoint-uri">/orders</span>
                    </div>
                </aside>

                <!-- Playground Main Panel -->
                <main class="sandbox-panel">
                    <div class="panel-header">
                        <div class="panel-title">
                            <h2 id="endpoint-name">User Registration</h2>
                            <p id="endpoint-desc">Register a new store customer account. Returns detailed status details and profile records.</p>
                        </div>
                        <div class="status-badge" style="font-family: var(--font-code); background: rgba(255,255,255,0.02); padding: 0.4rem 0.8rem; border-radius: 6px; border: 1px solid var(--border);">
                            Endpoint: <strong id="endpoint-url-display" style="color: var(--accent);">api/auth.php?action=register</strong>
                        </div>
                    </div>

                    <!-- JWT Auth Token Bar -->
                    <div class="auth-bar">
                        <div class="auth-bar-header">
                            <div class="auth-title">
                                <i class="fa-solid fa-key"></i> JWT Authentication Token (Bearer Scheme)
                            </div>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">Automatically set on login, or paste manual token</span>
                        </div>
                        <div class="auth-inputs">
                            <input type="text" id="jwt-token-input" class="input-text" placeholder="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...">
                            <button class="btn-action btn-purple" onclick="clearToken()">
                                <i class="fa-solid fa-eraser"></i> Clear
                            </button>
                        </div>
                    </div>

                    <!-- Sandbox Request/Response Editor Grid -->
                    <div class="playground-grid">
                        <!-- Left Block: Request Params & Body -->
                        <div>
                            <div class="block-title">Request Properties</div>
                            
                            <!-- Dynamic Parameter input (ID query) -->
                            <div id="param-input-container" style="display: none; margin-bottom: 1rem; background: rgba(0,0,0,0.1); border: 1px solid var(--border); padding: 0.8rem; border-radius: 6px;">
                                <label style="display: block; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.4rem; font-weight: 600;">Resource ID (?id=):</label>
                                <input type="number" id="query-id-input" class="input-text" style="width: 100%; min-width: auto;" value="1">
                            </div>

                            <div id="body-container">
                                <label style="display: block; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.4rem; font-weight: 600;">JSON Payload Editor:</label>
                                <div class="editor-container">
                                    <textarea id="request-body" class="json-textarea"></textarea>
                                </div>
                            </div>
                            
                            <div style="margin-top: 1rem; display: flex; justify-content: flex-end;">
                                <button class="btn-action" onclick="sendSandboxRequest()">
                                    <i class="fa-solid fa-paper-plane"></i> Execute Request
                                </button>
                            </div>
                        </div>

                        <!-- Right Block: Response Console -->
                        <div>
                            <div class="block-title">Response Console</div>
                            <div class="response-container">
                                <div class="response-meta">
                                    <span>Time: <strong id="resp-latency">0ms</strong></span>
                                    <span>Status: <strong id="resp-status" class="status-badge">---</strong></span>
                                </div>
                                <div id="response-console" class="response-body loading-text">
                                    Fire a request from the sandbox to inspect real-time database JSON responses here...
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </section>

        <!-- TAB: Section A Concept Answers -->
        <section id="section-a-tab" class="tab-content">
            <div class="accordion">
                <!-- Question 1 -->
                <div class="accordion-item active">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <h3><i class="fa-solid fa-circle-info"></i> Q1. Explain REST resources, HTTP verbs, and status codes in the request-response cycle.</h3>
                        <i class="fa-solid fa-chevron-down accordion-arrow"></i>
                    </div>
                    <div class="accordion-body">
                        <div class="accordion-inner-content">
                            <p>In REST (Representational State Transfer), web services are built around distinct entities called <strong>Resources</strong>. Every resource is mapped to a logical location called a <strong>URI (Uniform Resource Identifier)</strong> (for example, <code>/api/products</code> represents the product inventory resource).</p>
                            
                            <p>In a standard request–response cycle:</p>
                            <ul>
                                <li><strong>The REST Resource</strong> represents the subject of the transaction (in this case, the product catalogue).</li>
                                <li><strong>The HTTP Verb (Method)</strong> represents the intent of the action. A <code>GET</code> request means the frontend wants to read/retrieve a representation of the products without causing any server side side-effects or state modifications.</li>
                                <li><strong>The HTTP Status Code</strong> represents the response status. Once the server evaluates the request, it returns a semantic code:
                                    <ul>
                                        <li><code>200 OK</code>: The products were successfully retrieved and returned in the body.</li>
                                        <li><code>404 Not Found</code>: The target resource or requested ID does not exist.</li>
                                        <li><code>500 Internal Server Error</code>: A database crash or backend issue occurred.</li>
                                    </ul>
                                </li>
                            </ul>

                            <div class="explain-card">
                                <p>"Together, they provide a standardized, self-describing protocol. The client requests a *resource* using an *intent verb*, and the server replies with a *data payload* alongside a standard *semantic code* summarizing the outcome."</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question 2 -->
                <div class="accordion-item">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <h3><i class="fa-solid fa-shield-halved"></i> Q2. How do HTTP methods ensure clarity and safety in CRUD operations (creation vs deletion)?</h3>
                        <i class="fa-solid fa-chevron-down accordion-arrow"></i>
                    </div>
                    <div class="accordion-body">
                        <div class="accordion-inner-content">
                            <p>HTTP verbs are categorized into two critical properties defined by the W3C standards: <strong>Safety</strong> and <strong>Idempotency</strong>. Adhering to these ensures web infrastructure remains reliable, cacheable, and predictable.</p>
                            
                            <ul>
                                <li><strong>Clarity:</strong> By matching database CRUD operations to specific HTTP methods, we build standard interfaces. 
                                    <ul>
                                        <li><code>POST</code> maps directly to <strong>Create</strong> (adds new records).</li>
                                        <li><code>GET</code> maps directly to <strong>Read</strong> (retrieves records).</li>
                                        <li><code>PUT</code> maps directly to <strong>Update</strong> (replaces existing records).</li>
                                        <li><code>DELETE</code> maps directly to <strong>Delete</strong> (removes records).</li>
                                    </ul>
                                </li>
                                <li><strong>Safety:</strong> A method is safe if it does not modify the server state (e.g., <code>GET</code>). Both <code>POST</code> and <code>DELETE</code> are <strong>unsafe</strong> methods because they alter database state.</li>
                                <li><strong>Idempotency:</strong> A method is idempotent if executing it multiple times yields the exact same server state as a single execution.
                                    <ul>
                                        <li><code>DELETE</code> is <strong>idempotent</strong>: Calling <code>DELETE /products/5</code> once removes product 5. Calling it 10 more times will still result in product 5 being deleted (and will return a <code>404 Not Found</code> after the first call), but the state of the database does not change further.</li>
                                        <li><code>POST</code> is <strong>non-idempotent</strong>: Calling <code>POST /products</code> multiple times will insert duplicate products, creating multiple identical products in the database.</li>
                                    </ul>
                                </li>
                            </ul>

                            <div class="explain-card">
                                <p>"Using POST prevents browsers from caching creation requests, while utilizing DELETE ensures that repeated network failures or clicks don't cause unintended destructive state alterations."</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question 3 -->
                <div class="accordion-item">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <h3><i class="fa-solid fa-vial-virus"></i> Q3. Why are automated tests (such as Postman Assertions) critical before deploying APIs?</h3>
                        <i class="fa-solid fa-chevron-down accordion-arrow"></i>
                    </div>
                    <div class="accordion-body">
                        <div class="accordion-inner-content">
                            <p>Automated tests written in testing platforms like Postman serve as quality gates. In highly active software development life cycles, automated testing is critical because:</p>
                            
                            <ul>
                                <li><strong>Prevents Regressions:</strong> Adding code, refactoring logic, or optimizing database queries can break existing routes. Automated tests immediately identify when a code change breaks a working endpoint.</li>
                                <li><strong>Saves Time:</strong> Manually typing payloads and testing responses in 20 endpoints after each update is slow. Automated test runners can run 100 assertions in under 2 seconds.</li>
                                <li><strong>Validates Boundary Conditions:</strong> Tests can systematically send incorrect payloads, invalid email schemas, empty passwords, or negative numbers to ensure the system rejects them with expected HTTP codes (e.g. <code>422 Unprocessable Entity</code>) instead of crashing with a <code>500 Internal Error</code>.</li>
                                <li><strong>Continuous Integration (CI/CD):</strong> Automated collections can run in automated pipelines (e.g., using Newman) to block broken code from reaching production servers.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Question 4 -->
                <div class="accordion-item">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <h3><i class="fa-solid fa-network-wired"></i> Q4. Shipping cost integrations: When is cURL preferred over file_get_contents()?</h3>
                        <i class="fa-solid fa-chevron-down accordion-arrow"></i>
                    </div>
                    <div class="accordion-body">
                        <div class="accordion-inner-content">
                            <p>While <code>file_get_contents()</code> is a fast way to download text from a URL in PHP, it has severe limitations when integrating with professional external APIs (like UPS, DHL, or Stripe). <strong>cURL (Client URL Library)</strong> is highly preferred for several reasons:</p>
                            
                            <ul>
                                <li><strong>HTTP Headers & Custom Authentication:</strong> External APIs require headers like <code>Authorization: Bearer <token></code> and <code>Content-Type: application/json</code>. Adding these in cURL is native, while <code>file_get_contents()</code> requires creating complex stream context configurations in PHP.</li>
                                <li><strong>HTTP Methods:</strong> <code>file_get_contents()</code> defaults to <code>GET</code>. If we need to send a <code>POST</code> request with a JSON payload to fetch live shipping quotes, cURL handles this easily.</li>
                                <li><strong>Error Handling & Detailed Diagnostics:</strong> If an API request fails, <code>file_get_contents()</code> throws a generic PHP warning and returns <code>false</code>, losing the details. cURL gives full access to response codes (via <code>curl_getinfo()</code>), raw response headers, connection times, and detailed error codes.</li>
                                <li><strong>Performance and Configuration:</strong> cURL allows setting timeout controls (e.g., abort the connection if the third-party shipping service doesn't respond in 2 seconds), handling proxies, cookies, and SSL certificate verification natively.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Question 5 -->
                <div class="accordion-item">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <h3><i class="fa-solid fa-key"></i> Q5. JWT Token-Based Auth vs Basic Authentication: Which protects APIs better and why?</h3>
                        <i class="fa-solid fa-chevron-down accordion-arrow"></i>
                    </div>
                    <div class="accordion-body">
                        <div class="accordion-inner-content">
                            <p><strong>Basic Authentication</strong> sends the raw username and password (encoded in Base64) with <em>every single request</em> in the <code>Authorization: Basic ...</code> header. <strong>JWT (JSON Web Token)</strong> authentication exchanges credentials for a signed token, which is then used in subsequent requests.</p>
                            
                            <p>JWT protects APIs significantly better due to these engineering advantages:</p>
                            <ul>
                                <li><strong>Minimizes Credential Exposure:</strong> In Basic Auth, the raw credentials must be saved in the client memory or local storage, making them vulnerable to Cross-Site Scripting (XSS) or browser storage sniffing. In JWT, credentials are sent only *once* during login. The client gets a token that is cryptographically signed and expires automatically.</li>
                                <li><strong>Stateless & Scalable:</strong> When a server receives a JWT, it does not need to query the database or look up session IDs in Redis to verify who the user is. The server simply verifies the HMAC-SHA256 signature using its secret key. This makes JWTs ideal for microservices and multi-server environments.</li>
                                <li><strong>Granular & Built-in Expiration:</strong> JWT payload claims contain automatic expiration timestamps (<code>exp</code>) and user privileges/roles (e.g. <code>"role": "admin"</code>). The server can reject expired tokens or block unauthorized roles without secondary lookups.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Question 6 -->
                <div class="accordion-item">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <h3><i class="fa-solid fa-gauge-high"></i> Q6. Peak traffic failures: How do rate limiting and proper status codes protect APIs?</h3>
                        <i class="fa-solid fa-chevron-down accordion-arrow"></i>
                    </div>
                    <div class="accordion-body">
                        <div class="accordion-inner-content">
                            <p>During extreme traffic spikes or distributed denial-of-service (DDoS) attacks, APIs can experience server overload, database locks, and performance degradation. <strong>Rate Limiting</strong> acts as a protective shield for backend servers:</p>
                            
                            <ul>
                                <li><strong>Preserves System Resources:</strong> Rate limiting caps the number of requests an individual user or IP address can send (e.g., 60 requests per minute). Excess requests are blocked before they trigger database queries, conserving memory and CPU.</li>
                                <li><strong>Defensive Status Codes:</strong> When a user exceeds their limit, the API must return a <code>429 Too Many Requests</code> HTTP status code instead of a generic <code>500 Error</code>. </li>
                                <li><strong>Retry-After Header:</strong> A well-behaved <code>429</code> response includes a <code>Retry-After: 30</code> header. This instructs client apps (like mobile frontends or third-party webhooks) to pause and wait 30 seconds before retrying, preventing automatic, high-frequency retry loops (a "thundering herd" problem) that would keep overloading the server.</li>
                            </ul>

                            <div class="explain-card">
                                <p>"Rate limiting changes a destructive server-crashing crash (500) into a controlled, well-communicated defensive block (429) that instructs client applications how to behave."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TAB: Database Schema & Setup -->
        <section id="database-tab" class="tab-content">
            <div style="background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; padding: 2rem; display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <h2>Smart Store Database Schema</h2>
                    <p style="color: var(--text-muted); margin-bottom: 1rem;">The system is built on top of MySQL with 4 core tables linked by integrity constraints.</p>
                </div>

                <h3>Table: <code>products</code></h3>
                <p style="color: var(--text-muted);">Stores details about store product inventory.</p>
                <table class="schema-table">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Type</th>
                            <th>Key</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>id</code></td>
                            <td>INT</td>
                            <td>PRIMARY</td>
                            <td>Auto-incrementing product identifier</td>
                        </tr>
                        <tr>
                            <td><code>name</code></td>
                            <td>VARCHAR(150)</td>
                            <td>-</td>
                            <td>Product name</td>
                        </tr>
                        <tr>
                            <td><code>description</code></td>
                            <td>TEXT</td>
                            <td>-</td>
                            <td>Detailed description of the product</td>
                        </tr>
                        <tr>
                            <td><code>price</code></td>
                            <td>DECIMAL(10,2)</td>
                            <td>-</td>
                            <td>Unit price</td>
                        </tr>
                        <tr>
                            <td><code>stock</code></td>
                            <td>INT</td>
                            <td>-</td>
                            <td>Available quantity</td>
                        </tr>
                        <tr>
                            <td><code>sku</code></td>
                            <td>VARCHAR(50)</td>
                            <td>UNIQUE</td>
                            <td>Stock Keeping Unit (unique code)</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Table: <code>users</code></h3>
                <p style="color: var(--text-muted);">Stores account profiles for customers and administrators.</p>
                <table class="schema-table">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Type</th>
                            <th>Key</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>id</code></td>
                            <td>INT</td>
                            <td>PRIMARY</td>
                            <td>Auto-incrementing user ID</td>
                        </tr>
                        <tr>
                            <td><code>name</code></td>
                            <td>VARCHAR(100)</td>
                            <td>-</td>
                            <td>Full name</td>
                        </tr>
                        <tr>
                            <td><code>email</code></td>
                            <td>VARCHAR(150)</td>
                            <td>UNIQUE</td>
                            <td>Email (used as login username)</td>
                        </tr>
                        <tr>
                            <td><code>password</code></td>
                            <td>VARCHAR(255)</td>
                            <td>-</td>
                            <td>Password hashed using BCRYPT</td>
                        </tr>
                        <tr>
                            <td><code>role</code></td>
                            <td>VARCHAR(20)</td>
                            <td>-</td>
                            <td>Access role (<code>customer</code> or <code>admin</code>)</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Table: <code>orders</code> & <code>order_items</code></h3>
                <p style="color: var(--text-muted);">Handles standard transaction orders with foreign key cascade settings.</p>
                <pre class="inline-code-box">
-- Active relationships:
orders.user_id -> users.id (ON DELETE CASCADE)
order_items.order_id -> orders.id (ON DELETE CASCADE)
order_items.product_id -> products.id (ON DELETE CASCADE)
                </pre>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <p>Smart Store API Suite &copy; 2026. Built with elegant Vanilla PHP &amp; CSS glassmorphic tokens.</p>
            <p style="font-size: 0.75rem; margin-top: 0.5rem; color: var(--text-muted);">Designed for TOPS Technologies Assessment. Model: Gemini Flash | Developer Agent: Antigravity</p>
        </footer>
    </div>

    <!-- Playground JS Logic -->
    <script>
        // Preset configurations for sandbox testing
        const ENDPOINTS_PRESETS = {
            'auth-register': {
                name: "User Registration",
                desc: "Register a new store customer account. Returns database status details and user profile.",
                url: "api/auth.php?action=register",
                method: "POST",
                requiresAuth: false,
                requiresId: false,
                body: {
                    name: "Alice Smith",
                    email: "alice@gmail.com",
                    password: "DemoPass123!"
                }
            },
            'auth-login': {
                name: "User Login",
                desc: "Authenticate using email and password. Returns a signed JWT token on success.",
                url: "api/auth.php?action=login",
                method: "POST",
                requiresAuth: false,
                requiresId: false,
                body: {
                    email: "john@gmail.com",
                    password: "DemoPass123!"
                }
            },
            'products-get-all': {
                name: "Get All Products",
                desc: "Public catalog route. Fetches list of products. No JWT required.",
                url: "api/products.php",
                method: "GET",
                requiresAuth: false,
                requiresId: false,
                body: null
            },
            'products-get-single': {
                name: "Get Single Product",
                desc: "Public endpoint to fetch a single product details by query parameter ID.",
                url: "api/products.php",
                method: "GET",
                requiresAuth: false,
                requiresId: true,
                body: null
            },
            'products-create': {
                name: "Add New Product",
                desc: "Protected route. Creates a new product in store stock. Requires Bearer JWT.",
                url: "api/products.php",
                method: "POST",
                requiresAuth: true,
                requiresId: false,
                body: {
                    name: "Omni Pro Drone",
                    description: "4K UHD video recording drone with obstacle avoidance sensors.",
                    price: 649.99,
                    stock: 12,
                    sku: "OMN-DRN-4K"
                }
            },
            'products-update': {
                name: "Update Product Details",
                desc: "Protected route. Modify product details using target ID. Requires Bearer JWT.",
                url: "api/products.php",
                method: "PUT",
                requiresAuth: true,
                requiresId: true,
                body: {
                    name: "Omni Pro Drone v2",
                    price: 699.99,
                    stock: 8,
                    sku: "OMN-DRN-4KV2"
                }
            },
            'products-delete': {
                name: "Delete Product Record",
                desc: "Protected route. Completely removes product from server inventory using ID parameter.",
                url: "api/products.php",
                method: "DELETE",
                requiresAuth: true,
                requiresId: true,
                body: null
            },
            'users-get-profile': {
                name: "View User Profile",
                desc: "Protected route. Retrieve account information of the logged-in JWT user.",
                url: "api/users.php",
                method: "GET",
                requiresAuth: true,
                requiresId: false,
                body: null
            },
            'users-update-profile': {
                name: "Update Profile Records",
                desc: "Protected route. Allows updating the authenticated user's name or password.",
                url: "api/users.php",
                method: "PUT",
                requiresAuth: true,
                requiresId: false,
                body: {
                    name: "John Doe Updated",
                    password: "NewSecurePassword123!"
                }
            },
            'orders-get-all': {
                name: "Get Order History",
                desc: "Protected route. Returns orders history for the authenticated user, along with items.",
                url: "api/orders.php",
                method: "GET",
                requiresAuth: true,
                requiresId: false,
                body: null
            },
            'orders-get-single': {
                name: "Get Order Details",
                desc: "Protected route. Retrieves single order details including products using order ID parameter.",
                url: "api/orders.php",
                method: "GET",
                requiresAuth: true,
                requiresId: true,
                body: null
            },
            'orders-create': {
                name: "Create New Order (Checkout)",
                desc: "Protected route. Submits cart details, decreases stock inside transactions. Requires valid JWT.",
                url: "api/orders.php",
                method: "POST",
                requiresAuth: true,
                requiresId: false,
                body: {
                    shipping_address: "Flat 402, Royal Gardens, Tech City",
                    items: [
                        { product_id: 1, quantity: 1 },
                        { product_id: 2, quantity: 2 }
                    ]
                }
            }
        };

        let currentActiveEndpointKey = 'auth-register';

        // Load Preset details into sandbox UI
        function loadEndpoint(key) {
            currentActiveEndpointKey = key;
            const preset = ENDPOINTS_PRESETS[key];
            
            // Highlight list item
            document.querySelectorAll('.endpoint-item').forEach(el => el.classList.remove('active'));
            event.currentTarget.classList.add('active');

            // Render details
            document.getElementById('endpoint-name').innerText = preset.name;
            document.getElementById('endpoint-desc').innerText = preset.desc;
            document.getElementById('endpoint-url-display').innerText = preset.url + (preset.requiresId ? '?id={id}' : '');

            // Handle URL ID query parameter input view
            const paramContainer = document.getElementById('param-input-container');
            if (preset.requiresId) {
                paramContainer.style.display = 'block';
            } else {
                paramContainer.style.display = 'none';
            }

            // Handle Body Editor View
            const bodyContainer = document.getElementById('body-container');
            const bodyTextarea = document.getElementById('request-body');
            
            if (preset.body) {
                bodyContainer.style.display = 'block';
                bodyTextarea.value = JSON.stringify(preset.body, null, 4);
            } else {
                bodyContainer.style.display = 'none';
                bodyTextarea.value = "";
            }
        }

        // Fire Sandbox REST Request
        async function sendSandboxRequest() {
            const preset = ENDPOINTS_PRESETS[currentActiveEndpointKey];
            const consoleBox = document.getElementById('response-console');
            const statusBox = document.getElementById('resp-status');
            const latencyBox = document.getElementById('resp-latency');

            consoleBox.className = "response-body loading-text";
            consoleBox.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Executing request against Smart API server...';
            statusBox.innerText = '---';
            statusBox.className = "status-badge";

            // Resolve Request URL
            let requestUrl = preset.url;
            if (preset.requiresId) {
                const idVal = document.getElementById('query-id-input').value;
                requestUrl += `?id=${idVal}`;
            }

            // Prepare headers
            const headers = {
                'Content-Type': 'application/json'
            };

            // Inject JWT Bearer Token if present
            const tokenInput = document.getElementById('jwt-token-input').value.trim();
            if (tokenInput) {
                // Ensure Bearer prefix is attached properly
                if (tokenInput.toLowerCase().startsWith('bearer ')) {
                    headers['Authorization'] = tokenInput;
                } else {
                    headers['Authorization'] = `Bearer ${tokenInput}`;
                }
            }

            // Build request options
            const options = {
                method: preset.method,
                headers: headers
            };

            // Set Request Body
            if (preset.body && preset.method !== 'GET' && preset.method !== 'DELETE') {
                const rawBody = document.getElementById('request-body').value.trim();
                try {
                    // Quick validation check on raw textarea JSON input
                    if (rawBody) {
                        JSON.parse(rawBody); // trigger throw if invalid
                        options.body = rawBody;
                    }
                } catch (e) {
                    consoleBox.className = "response-body error-text";
                    consoleBox.innerText = `JSON Syntax Error in Request Body Editor:\n${e.message}`;
                    statusBox.innerText = '400 Bad Request';
                    statusBox.className = "status-badge error-code";
                    return;
                }
            }

            const startTime = performance.now();

            try {
                const response = await fetch(requestUrl, options);
                const latency = Math.round(performance.now() - startTime);
                latencyBox.innerText = `${latency}ms`;

                const data = await response.json();
                
                // Set Status Code badge styles
                statusBox.innerText = `${response.status} ${response.statusText || ''}`;
                if (response.ok) {
                    statusBox.className = "status-badge success-code";
                    consoleBox.className = "response-body";
                } else {
                    statusBox.className = "status-badge error-code";
                    consoleBox.className = "response-body error-text";
                }

                // Render pretty printed JSON
                consoleBox.innerText = JSON.stringify(data, null, 4);

                // Auto-save JWT token in text input if user just logged in successfully!
                if (currentActiveEndpointKey === 'auth-login' && response.ok && data.data && data.data.token) {
                    document.getElementById('jwt-token-input').value = data.data.token;
                    // Flash action notification
                    const authBar = document.querySelector('.auth-bar');
                    authBar.style.boxShadow = "0 0 15px rgba(139, 92, 246, 0.4)";
                    setTimeout(() => { authBar.style.boxShadow = "none"; }, 1500);
                }

            } catch (err) {
                const latency = Math.round(performance.now() - startTime);
                latencyBox.innerText = `${latency}ms`;
                statusBox.innerText = 'Connection Failed';
                statusBox.className = "status-badge error-code";
                consoleBox.className = "response-body error-text";
                consoleBox.innerText = `Network/CORS Request Error:\n\n1. Ensure Apache/MySQL is running in XAMPP.\n2. Ensure CORS handles options headers.\n\nDetails: ${err.message}`;
            }
        }

        // Auth Bar token utility
        function clearToken() {
            document.getElementById('jwt-token-input').value = "";
        }

        // Tab Switching
        function switchTab(evt, tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            document.getElementById(tabId).classList.add('active');
            evt.currentTarget.classList.add('active');
        }

        // Accordion utility for Section A
        function toggleAccordion(header) {
            const item = header.parentElement;
            const isActive = item.classList.contains('active');
            
            // Optional: Close all other accordions for tab-like feel
            document.querySelectorAll('.accordion-item').forEach(el => {
                el.classList.remove('active');
            });

            if (!isActive) {
                item.classList.add('active');
            }
        }

        // Bootstrapping defaults
        window.addEventListener('DOMContentLoaded', () => {
            loadEndpoint('auth-register');
        });
    </script>
</body>
</html>
