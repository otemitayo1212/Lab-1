<?php
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
    <title>Haunted LMS - Spooky Web Systems</title>
    <link rel="stylesheet" href="styles.css">
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