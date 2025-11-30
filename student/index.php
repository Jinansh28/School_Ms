<?php
require_once "../includes/auth.php";
require_role('student');
require_once "../config/db.php";
include_once "../includes/header.php";

$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("SELECT id, first_name, last_name, class_id FROM students WHERE user_id = ?");
$stmt->execute([$user_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    echo "Student profile not found.";
    include "../includes/footer.php";
    exit;
}

$classStmt = $pdo->prepare("SELECT * FROM classes WHERE id = ?");
$classStmt->execute([$student['class_id']]);
$class = $classStmt->fetch(PDO::FETCH_ASSOC);

$marksStmt = $pdo->prepare("
    SELECT em.*, e.name AS exam_name, s.name AS subject_name
    FROM exam_marks em
    JOIN exams e ON em.exam_id = e.id
    JOIN subjects s ON em.subject_id = s.id
    WHERE em.student_id = ?
    ORDER BY e.start_date DESC, s.name ASC
    LIMIT 20
");
$marksStmt->execute([$student['id']]);
$marks = $marksStmt->fetchAll(PDO::FETCH_ASSOC);

$noticeStmt = $pdo->prepare("SELECT * FROM announcements WHERE role_scope IN ('all','students') ORDER BY created_at DESC LIMIT 5");
$noticeStmt->execute();
$notices = $noticeStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">STUDENT</p>
        <h2>Student Dashboard</h2>
    </header>

    <div class="dashboard-grid">
        <div class="stat-card">
            <h3>Name</h3>
            <div class="value"><?php echo htmlspecialchars($student['first_name'].' '.$student['last_name']); ?></div>
        </div>
        <div class="stat-card">
            <h3>Class</h3>
            <div class="value"><?php echo htmlspecialchars(($class['name'] ?? '').' '.($class['section'] ?? '')); ?></div>
        </div>
    </div>

    <div class="two-col" style="margin-top:1.5rem;gap:1.3rem;">
        <div class="card table-card">
            <h3 style="margin-top:0;">Recent Exam Marks</h3>
            <?php if (!$marks): ?>
                <p class="helper-text">Marks will appear here once exams are evaluated.</p>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Exam</th>
                            <th>Subject</th>
                            <th>Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($marks as $m): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($m['exam_name']); ?></td>
                            <td><?php echo htmlspecialchars($m['subject_name']); ?></td>
                            <td><?php echo htmlspecialchars($m['marks_obtained'])."/".htmlspecialchars($m['max_marks']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <div class="card">
            <h3 style="margin-top:0;">Latest Notices</h3>
            <?php if (!$notices): ?>
                <p class="helper-text">No notices yet.</p>
            <?php else: ?>
                <ul class="bullets">
                    <?php foreach ($notices as $n): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($n['title']); ?></strong><br>
                            <span style="font-size:0.8rem;color:#6b7280;">
                                <?php echo htmlspecialchars(substr($n['body'], 0, 80)); ?>...
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php include_once "../includes/footer.php"; ?>
