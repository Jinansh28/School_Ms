<?php
require_once "../includes/auth.php";
require_role('admin');
require_once "../config/db.php";
include_once "../includes/header.php";

$counts = [];
foreach (['students','teachers','classes'] as $tbl) {
    $stmt = $pdo->query("SELECT COUNT(*) AS c FROM {$tbl}");
    $counts[$tbl] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['c'];
}
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">ADMIN</p>
        <h2>Admin Dashboard</h2>
        <p>Manage academics, users, exams and school notices.</p>
    </header>

    <div class="dashboard-grid">
        <div class="stat-card">
            <h3>Total Students</h3>
            <div class="value"><?php echo $counts['students']; ?></div>
        </div>
        <div class="stat-card">
            <h3>Total Teachers</h3>
            <div class="value"><?php echo $counts['teachers']; ?></div>
        </div>
        <div class="stat-card">
            <h3>Total Classes</h3>
            <div class="value"><?php echo $counts['classes']; ?></div>
        </div>
    </div>

    <div class="card" style="margin-top:1.5rem;">
        <h3>Quick Links</h3>
        <ul class="bullets">
            <li><a href="students.php">Manage Students</a></li>
            <li><a href="teachers.php">Manage Teachers</a></li>
            <li><a href="classes.php">Manage Classes</a></li>
            <li><a href="subjects.php">Manage Subjects</a></li>
            <li><a href="exams.php">Manage Exams</a></li>
            <li><a href="exam_marks.php">Enter Exam Marks</a></li>
            <li><a href="announcements.php">Notices &amp; Announcements</a></li>
        </ul>
    </div>
</section>
<?php include_once "../includes/footer.php"; ?>
