<?php
require_once "../includes/auth.php";
require_role('admin');
require_once "../config/db.php";

$selected_exam_id = (int)($_POST['exam_id'] ?? 0);
$selected_class_id = (int)($_POST['class_id'] ?? 0);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_marks'])) {
    $exam_id = (int)$_POST['exam_id'];
    $class_id = (int)$_POST['class_id'];
    $subject_id = (int)$_POST['subject_id'];
    $max_marks = (float)$_POST['max_marks'];

    if ($exam_id && $class_id && $subject_id) {
        $studentsStmt = $pdo->prepare("SELECT * FROM students WHERE class_id = ? ORDER BY first_name");
        $studentsStmt->execute([$class_id]);
        $students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($students as $s) {
            $key = 'marks_' . $s['id'];
            if (isset($_POST[$key]) && $_POST[$key] !== '') {
                $marks_obtained = (float)$_POST[$key];
                $stmt = $pdo->prepare("REPLACE INTO exam_marks (exam_id, student_id, subject_id, marks_obtained, max_marks)
                                       VALUES (?,?,?,?,?)");
                $stmt->execute([$exam_id, $s['id'], $subject_id, $marks_obtained, $max_marks]);
            }
        }
        $message = "Marks saved.";
        $selected_exam_id = $exam_id;
        $selected_class_id = $class_id;
    } else {
        $message = "Select exam, class, and subject.";
    }
}

$classes = $pdo->query("SELECT * FROM classes ORDER BY name, section")->fetchAll(PDO::FETCH_ASSOC);
$exams = $pdo->query("SELECT e.*, c.name AS class_name, c.section 
                      FROM exams e
                      LEFT JOIN classes c ON e.class_id = c.id
                      ORDER BY e.start_date DESC")->fetchAll(PDO::FETCH_ASSOC);

$subjects = [];
if ($selected_class_id) {
    $stmt = $pdo->prepare("SELECT * FROM subjects WHERE class_id = ? ORDER BY name");
    $stmt->execute([$selected_class_id]);
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

include_once "../includes/header.php";
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">ADMIN &middot; EXAMS</p>
        <h2>Enter Exam Marks</h2>
    </header>
    <?php if ($message): ?>
        <div class="alert" style="background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="post" class="card card-form" style="margin-bottom:1rem;">
        <div class="two-col" style="gap:1rem;">
            <div>
                <label>Exam</label>
                <select name="exam_id" onchange="this.form.submit()">
                    <option value="">-- Select --</option>
                    <?php foreach ($exams as $e): ?>
                        <option value="<?php echo $e['id']; ?>" <?php if ($selected_exam_id==$e['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($e['name'].' ('.$e['class_name'].' '.$e['section'].')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Class</label>
                <select name="class_id" onchange="this.form.submit()">
                    <option value="">-- Select --</option>
                    <?php foreach ($classes as $c): ?>
                        <option value="<?php echo $c['id']; ?>" <?php if ($selected_class_id==$c['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($c['name'].' '.$c['section']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <noscript>
            <button type="submit" class="btn btn-outline" style="margin-top:0.5rem;">Load</button>
        </noscript>
    </form>

    <?php
    if ($selected_exam_id && $selected_class_id && $subjects):
        $studentsStmt = $pdo->prepare("SELECT * FROM students WHERE class_id = ? ORDER BY first_name");
        $studentsStmt->execute([$selected_class_id]);
        $students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);
        if ($students):
    ?>
    <form method="post" class="card">
        <input type="hidden" name="exam_id" value="<?php echo $selected_exam_id; ?>">
        <input type="hidden" name="class_id" value="<?php echo $selected_class_id; ?>">

        <div class="two-col" style="gap:1rem;margin-bottom:1rem;">
            <div>
                <label>Subject</label>
                <select name="subject_id" required>
                    <?php foreach ($subjects as $sub): ?>
                        <option value="<?php echo $sub['id']; ?>"><?php echo htmlspecialchars($sub['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Max Marks</label>
                <input type="number" step="0.01" name="max_marks" value="100">
            </div>
        </div>

        <div class="table-card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Marks Obtained</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($students as $s): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($s['first_name'].' '.$s['last_name']); ?></td>
                        <td>
                            <input type="number" step="0.01" name="marks_<?php echo $s['id']; ?>" style="width:100px;">
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button type="submit" name="save_marks" class="btn btn-primary" style="margin-top:0.7rem;">Save Marks</button>
    </form>
    <?php
        endif;
    endif;
    ?>
</section>
<?php include_once "../includes/footer.php"; ?>
