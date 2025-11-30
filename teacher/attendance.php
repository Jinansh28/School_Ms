<?php
require_once "../includes/auth.php";
require_role('teacher');
require_once "../config/db.php";
include_once "../includes/header.php";

$stmt = $pdo->prepare("SELECT id FROM teachers WHERE user_id = ?");
$stmt->execute([$_SESSION['user']['id']]);
$teacher = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$teacher) {
    echo "Teacher profile not found.";
    include "../includes/footer.php";
    exit;
}
$teacher_id = $teacher['id'];

$date = $_POST['date'] ?? date('Y-m-d');
$class_id = (int)($_POST['class_id'] ?? 0);
$subject_id = (int)($_POST['subject_id'] ?? 0);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['take_attendance'])) {
    if ($class_id && $subject_id) {
        $studentsStmt = $pdo->prepare("SELECT * FROM students WHERE class_id = ? ORDER BY first_name");
        $studentsStmt->execute([$class_id]);
        $students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($students)) {
            foreach ($students as $s) {
                $status = $_POST['status_'.$s['id']] ?? 'Absent';
                $stmtIns = $pdo->prepare("REPLACE INTO attendance 
                    (student_id, class_id, subject_id, teacher_id, date, status) 
                    VALUES (?,?,?,?,?,?)");
                $stmtIns->execute([$s['id'], $class_id, $subject_id, $teacher_id, $date, $status]);
            }
            $message = "Attendance saved for {$date}.";
        } else {
            $message = "No students in this class.";
        }
    } else {
        $message = "Select class and subject.";
    }
}

$classesStmt = $pdo->prepare("SELECT DISTINCT c.* FROM classes c
                              JOIN subjects s ON s.class_id = c.id
                              WHERE s.teacher_id = ?");
$classesStmt->execute([$teacher_id]);
$classes = $classesStmt->fetchAll(PDO::FETCH_ASSOC);

$subjects = [];
if ($class_id) {
    $subStmt = $pdo->prepare("SELECT * FROM subjects WHERE class_id = ? AND teacher_id = ? ORDER BY name");
    $subStmt->execute([$class_id, $teacher_id]);
    $subjects = $subStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">TEACHER &middot; ATTENDANCE</p>
        <h2>Mark Attendance</h2>
    </header>

    <?php if ($message): ?>
        <div class="alert" style="background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="post" class="card card-form" style="margin-bottom:1rem;">
        <label>Date</label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($date); ?>">
        <label>Class</label>
        <select name="class_id" onchange="this.form.submit()">
            <option value="">-- Select --</option>
            <?php foreach ($classes as $c): ?>
                <option value="<?php echo $c['id']; ?>" <?php if ($c['id']==$class_id) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($c['name'].' '.$c['section']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label>Subject</label>
        <select name="subject_id">
            <option value="">-- Select --</option>
            <?php foreach ($subjects as $sub): ?>
                <option value="<?php echo $sub['id']; ?>" <?php if ($sub['id']==$subject_id) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($sub['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-outline" name="filter" style="margin-top:0.5rem;">Load Students</button>
    </form>

    <?php
    if ($class_id && $subject_id) {
        $studentsStmt = $pdo->prepare("SELECT * FROM students WHERE class_id = ? ORDER BY first_name");
        $studentsStmt->execute([$class_id]);
        $students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);
        if ($students):
    ?>
    <form method="post" class="card table-card">
        <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
        <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">

        <table class="table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Present</th>
                    <th>Absent</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $s): ?>
                <tr>
                    <td><?php echo htmlspecialchars($s['first_name'].' '.$s['last_name']); ?></td>
                    <td><input type="radio" name="status_<?php echo $s['id']; ?>" value="Present" checked></td>
                    <td><input type="radio" name="status_<?php echo $s['id']; ?>" value="Absent"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary" name="take_attendance" style="margin-top:0.7rem;">Save Attendance</button>
    </form>
    <?php
        else:
            echo '<p class="helper-text">No students in this class.</p>';
        endif;
    }
    ?>
</section>
<?php include_once "../includes/footer.php"; ?>
