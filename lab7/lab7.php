<?php
// Database configuration from the shadow realm
$host = 'localhost';
$dbname = 'lab7';
$username = 'root'; // Change to your username
$password = '';     // Change to your password`1

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("💀 The database spirits refuse to connect: " . $e->getMessage());
}

// Handle archiving request (Part 5)
if (isset($_POST['archive'])) {
    try {
        // Create archive tables if they don't exist
        $pdo->exec("CREATE TABLE IF NOT EXISTS archived_lectures (
            id INT AUTO_INCREMENT PRIMARY KEY,
            lecture_key VARCHAR(50) NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        $pdo->exec("CREATE TABLE IF NOT EXISTS archived_labs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            lab_key VARCHAR(50) NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Fetch JSON data
        $stmt = $pdo->prepare("SELECT course_content FROM courses WHERE crn = 31313");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && $result['course_content']) {
            $courseData = json_decode($result['course_content'], true);
            
            // Clear existing archives
            $pdo->exec("TRUNCATE TABLE archived_lectures");
            $pdo->exec("TRUNCATE TABLE archived_labs");
            
            // Archive lectures
            if (isset($courseData['Websys_course']['Lectures'])) {
                $stmt = $pdo->prepare("INSERT INTO archived_lectures (lecture_key, title, description) VALUES (?, ?, ?)");
                foreach ($courseData['Websys_course']['Lectures'] as $key => $lecture) {
                    $stmt->execute([$key, $lecture['Title'], $lecture['Description']]);
                }
            }
            
            // Archive labs
            if (isset($courseData['Websys_course']['Labs'])) {
                $stmt = $pdo->prepare("INSERT INTO archived_labs (lab_key, title, description) VALUES (?, ?, ?)");
                foreach ($courseData['Websys_course']['Labs'] as $key => $lab) {
                    $stmt->execute([$key, $lab['Title'], $lab['Description']]);
                }
            }
            
            $archiveMessage = "✅ Course content successfully archived in the eternal database!";
        }
    } catch(PDOException $e) {
        $archiveMessage = "💀 Archive ritual failed: " . $e->getMessage();
    }
}

// Handle delete archive tables request
if (isset($_POST['delete_archives'])) {
    try {
        $pdo->exec("DROP TABLE IF EXISTS archived_lectures");
        $pdo->exec("DROP TABLE IF EXISTS archived_labs");
        $archiveMessage = "🔥 Archive tables have been banished to the void!";
    } catch(PDOException $e) {
        $archiveMessage = "💀 Failed to banish archives: " . $e->getMessage();
    }
}

// Fetch course content for display
$courseContent = null;
try {
    $stmt = $pdo->prepare("SELECT course_content FROM courses WHERE crn = 31313");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result && $result['course_content']) {
        $courseContent = json_decode($result['course_content'], true);
    }
} catch(PDOException $e) {
    $error = "Failed to summon course content: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎃 Haunted LMS - Spooky Web Systems 👻</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            background: linear-gradient(135deg, #1a0033 0%, #330033 50%, #1a0033 100%);
            color: #ff6b35;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Spooky animated background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(120, 0, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 0, 100, 0.1) 0%, transparent 50%);
            animation: pulse 4s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        
        .container {
            position: relative;
            z-index: 1;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            text-align: center;
            padding: 30px 0;
            border-bottom: 3px solid #ff6b35;
            margin-bottom: 30px;
            animation: flicker 2s infinite;
        }
        
        @keyframes flicker {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        h1 {
            font-size: 3em;
            text-shadow: 0 0 20px #ff6b35, 0 0 40px #ff0066;
            margin-bottom: 10px;
            letter-spacing: 3px;
        }
        
        .subtitle {
            color: #b366ff;
            font-size: 1.2em;
            text-shadow: 0 0 10px #b366ff;
        }
        
        .main-content {
            display: flex;
            gap: 20px;
            min-height: 600px;
        }
        
        /* Navigation sidebar */
        .navigation {
            flex: 0 0 300px;
            background: rgba(0, 0, 0, 0.6);
            border: 2px solid #ff6b35;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 30px rgba(255, 107, 53, 0.3);
            max-height: calc(100vh - 300px);
            overflow-y: auto;
        }
        
        .navigation h2 {
            color: #b366ff;
            margin-bottom: 15px;
            text-shadow: 0 0 10px #b366ff;
            border-bottom: 2px solid #b366ff;
            padding-bottom: 10px;
        }
        
        .nav-section {
            margin-bottom: 25px;
        }
        
        .nav-section h3 {
            color: #ff6b35;
            margin-bottom: 10px;
            font-size: 1.1em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .nav-item {
            padding: 10px;
            margin: 5px 0;
            background: rgba(255, 107, 53, 0.1);
            border-left: 3px solid #ff6b35;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 5px;
        }
        
        .nav-item:hover {
            background: rgba(255, 107, 53, 0.3);
            transform: translateX(5px);
            box-shadow: 0 0 15px rgba(255, 107, 53, 0.5);
        }
        
        .nav-item.active {
            background: rgba(179, 102, 255, 0.3);
            border-left-color: #b366ff;
            box-shadow: 0 0 15px rgba(179, 102, 255, 0.5);
        }
        
        /* Preview area */
        .preview {
            flex: 1;
            background: rgba(0, 0, 0, 0.6);
            border: 2px solid #b366ff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 30px rgba(179, 102, 255, 0.3);
        }
        
        .preview-content {
            min-height: 400px;
        }
        
        .preview h2 {
            color: #ff6b35;
            font-size: 2em;
            margin-bottom: 20px;
            text-shadow: 0 0 15px #ff6b35;
        }
        
        .preview .type-badge {
            display: inline-block;
            padding: 5px 15px;
            background: rgba(179, 102, 255, 0.3);
            border: 1px solid #b366ff;
            border-radius: 20px;
            font-size: 0.8em;
            margin-bottom: 15px;
            text-shadow: 0 0 5px #b366ff;
        }
        
        .preview p {
            line-height: 1.8;
            color: #ffd699;
            font-size: 1.1em;
        }
        
        .empty-preview {
            text-align: center;
            padding: 100px 20px;
            color: #666;
            font-style: italic;
        }
        
        /* Control buttons */
        .controls {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        button {
            padding: 12px 30px;
            background: linear-gradient(135deg, #ff6b35 0%, #ff0066 100%);
            border: 2px solid #ff6b35;
            color: white;
            font-family: 'Courier New', monospace;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s;
            text-shadow: 0 0 5px rgba(0,0,0,0.5);
            box-shadow: 0 0 15px rgba(255, 107, 53, 0.5);
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(255, 107, 53, 0.8);
            background: linear-gradient(135deg, #ff0066 0%, #ff6b35 100%);
        }
        
        .archive-btn {
            background: linear-gradient(135deg, #b366ff 0%, #6b35ff 100%);
            border-color: #b366ff;
            box-shadow: 0 0 15px rgba(179, 102, 255, 0.5);
        }
        
        .archive-btn:hover {
            background: linear-gradient(135deg, #6b35ff 0%, #b366ff 100%);
            box-shadow: 0 0 25px rgba(179, 102, 255, 0.8);
        }
        
        .delete-btn {
            background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%);
            border-color: #ff0000;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.5);
        }
        
        .delete-btn:hover {
            background: linear-gradient(135deg, #cc0000 0%, #ff0000 100%);
            box-shadow: 0 0 25px rgba(255, 0, 0, 0.8);
        }
        
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            background: rgba(0, 0, 0, 0.6);
            border: 2px solid #4CAF50;
            color: #4CAF50;
            animation: fadeIn 0.5s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.3);
        }
        
        ::-webkit-scrollbar-thumb {
            background: #ff6b35;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #ff0066;
        }
        
        footer {
            text-align: center;
            padding: 30px 0;
            margin-top: 50px;
            border-top: 2px solid #ff6b35;
            color: #b366ff;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🎃 HAUNTED LMS 👻</h1>
            <p class="subtitle">💀 Spooky Web Systems - Where Learning is Frightfully Fun! 🕷️</p>
        </header>
        
        <?php if (isset($archiveMessage)): ?>
            <div class="message"><?php echo $archiveMessage; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="message" style="border-color: #ff0000; color: #ff0000;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="main-content">
            <!-- Navigation Sidebar -->
            <aside class="navigation">
                <h2>📚 Cursed Curriculum</h2>
                
                <?php if ($courseContent): ?>
                    <!-- Lectures Section -->
                    <?php if (isset($courseContent['Websys_course']['Lectures'])): ?>
                        <div class="nav-section">
                            <h3>🎓 Lectures from Beyond</h3>
                            <?php foreach ($courseContent['Websys_course']['Lectures'] as $key => $lecture): ?>
                                <div class="nav-item" 
                                     data-type="lecture" 
                                     data-title="<?php echo htmlspecialchars($lecture['Title']); ?>"
                                     data-description="<?php echo htmlspecialchars($lecture['Description']); ?>">
                                    <?php echo htmlspecialchars($lecture['Title']); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Labs Section -->
                    <?php if (isset($courseContent['Websys_course']['Labs'])): ?>
                        <div class="nav-section">
                            <h3>🧪 Laboratory of Horrors</h3>
                            <?php foreach ($courseContent['Websys_course']['Labs'] as $key => $lab): ?>
                                <div class="nav-item" 
                                     data-type="lab" 
                                     data-title="<?php echo htmlspecialchars($lab['Title']); ?>"
                                     data-description="<?php echo htmlspecialchars($lab['Description']); ?>">
                                    <?php echo htmlspecialchars($lab['Title']); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <p style="color: #666; text-align: center; padding: 20px;">
                        No cursed content found... 👻
                    </p>
                <?php endif; ?>
            </aside>
            
            <!-- Preview Area -->
            <main class="preview">
                <div class="preview-content" id="previewContent">
                    <div class="empty-preview">
                        <h2>🕸️ Select a lecture or lab to begin your haunted journey... 🕸️</h2>
                        <p style="margin-top: 20px;">Click on any item from the navigation to reveal its dark secrets!</p>
                    </div>
                </div>
            </main>
        </div>
        
        <!-- Control Buttons -->
        <div class="controls">
            <form method="post" style="display: inline;">
                <button type="submit" onclick="return confirm('🔄 Refresh the cursed content from the database?');">
                    🔄 Refresh Course Content
                </button>
            </form>
            
            <form method="post" style="display: inline;">
                <button type="submit" name="archive" class="archive-btn" 
                        onclick="return confirm('📦 Archive all course content into separate database tables?');">
                    📦 Archive Content
                </button>
            </form>
            
            <form method="post" style="display: inline;">
                <button type="submit" name="delete_archives" class="delete-btn" 
                        onclick="return confirm('🔥 Are you sure you want to banish the archive tables forever?');">
                    🔥 Delete Archive Tables
                </button>
            </form>
        </div>
        
        <footer>
            <p>⚠️ Warning: This LMS may contain traces of supernatural activity ⚠️</p>
            <p>Created with 💀 for Web Systems Lab 7</p>
        </footer>
    </div>
    
    <script>
        // Handle navigation item clicks
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all items
                document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
                
                // Add active class to clicked item
                this.classList.add('active');
                
                // Get data
                const type = this.dataset.type;
                const title = this.dataset.title;
                const description = this.dataset.description;
                
                // Update preview
                const previewContent = document.getElementById('previewContent');
                const typeEmoji = type === 'lecture' ? '🎓' : '🧪';
                const typeName = type === 'lecture' ? 'Lecture' : 'Laboratory Exercise';
                
                previewContent.innerHTML = `
                    <span class="type-badge">${typeEmoji} ${typeName}</span>
                    <h2>${title}</h2>
                    <p>${description}</p>
                `;
            });
        });
    </script>
</body>
</html>