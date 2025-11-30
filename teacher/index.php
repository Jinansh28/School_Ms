<?php
require_once "../includes/auth.php";
require_role('teacher');
require_once "../config/db.php";
include_once "../includes/header.php";

$stmt = $pdo->prepare("SELECT id, first_name, last_name FROM teachers WHERE user_id = ?");
$stmt->execute([$_SESSION['user']['id']]);
$teacher = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">TEACHER</p>
        <h2>Teacher Dashboard</h2>
        <p>Welcome to Lord Buddha School teacher portal.</p>
    </header>

    <div class="dashboard-grid">
        <div class="stat-card">
            <h3>Teacher</h3>
            <div class="value">
                <?php echo htmlspecialchars(($teacher['first_name'] ?? '').' '.($teacher['last_name'] ?? '')); ?>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top:1.5rem;">
        <h3>Quick Links</h3>
        <ul class="bullets">
            <li><a href="attendance.php">Mark Attendance</a></li>
            <li><a href="marks.php">Enter Marks (for your subjects)</a></li>
        </ul>
    </div>
</section>
<?php include_once "../includes/footer.php"; ?>
