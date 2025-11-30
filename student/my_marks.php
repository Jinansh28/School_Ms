<?php
require_once "../includes/auth.php";
require_role('student');
require_once "../config/db.php";
include_once "../includes/header.php";

$user_id = $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT id FROM students WHERE user_id = ?");
$stmt->execute([$user_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$student) {
    echo "Student profile not found.";
    include "../includes/footer.php";
    exit;
}

$marksStmt = $pdo->prepare("
    SELECT em.*, e.name AS exam_name, e.term, s.name AS subject_name
    FROM exam_marks em
    JOIN exams e ON em.exam_id = e.id
    JOIN subjects s ON em.subject_id = s.id
    WHERE em.student_id = ?
    ORDER BY e.start_date DESC, s.name ASC
");
$marksStmt->execute([$student['id']]);
$marks = $marksStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">STUDENT &middot; REPORTS</p>
        <h2>My Exam Marks</h2>
    </header>
    <div class="card table-card">
        <?php if (!$marks): ?>
            <p class="helper-text">No marks available yet.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Exam</th>
                        <th>Term</th>
                        <th>Subject</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($marks as $m): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($m['exam_name']); ?></td>
                        <td><?php echo htmlspecialchars($m['term']); ?></td>
                        <td><?php echo htmlspecialchars($m['subject_name']); ?></td>
                        <td><?php echo htmlspecialchars($m['marks_obtained'])."/".htmlspecialchars($m['max_marks']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>
<?php include_once "../includes/footer.php"; ?>
