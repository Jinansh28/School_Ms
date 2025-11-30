<?php
require_once "../includes/auth.php";
require_role('admin');
require_once "../config/db.php";

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $term = trim($_POST['term']);
    $class_id = (int)($_POST['class_id'] ?? 0);
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?? null;

    if ($name && $class_id && $start_date && $end_date) {
        $stmt = $pdo->prepare("INSERT INTO exams (name, term, class_id, start_date, end_date)
                               VALUES (?,?,?,?,?)");
        $stmt->execute([$name, $term, $class_id, $start_date, $end_date]);
    } else {
        $error = "Name, class and dates are required.";
    }
}

$classes = $pdo->query("SELECT * FROM classes ORDER BY name, section")->fetchAll(PDO::FETCH_ASSOC);
$stmt = $pdo->query("SELECT e.*, c.name AS class_name, c.section 
                     FROM exams e
                     LEFT JOIN classes c ON e.class_id = c.id
                     ORDER BY e.start_date DESC");
$exams = $stmt->fetchAll(PDO::FETCH_ASSOC);

include_once "../includes/header.php";
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">ADMIN &middot; EXAMS</p>
        <h2>Exams</h2>
    </header>
    <div class="two-col">
        <div class="card card-form">
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <h3>Create Exam</h3>
            <form method="post">
                <label>Exam Name*</label>
                <input type="text" name="name" placeholder="Mid Term" required>
                <label>Term</label>
                <input type="text" name="term" placeholder="Term 1 / Term 2">
                <label>Class*</label>
                <select name="class_id" required>
                    <option value="">-- Select --</option>
                    <?php foreach ($classes as $c): ?>
                        <option value="<?php echo $c['id']; ?>">
                            <?php echo htmlspecialchars($c['name'].' '.$c['section']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label>Start Date*</label>
                <input type="date" name="start_date" required>
                <label>End Date*</label>
                <input type="date" name="end_date" required>
                <button type="submit" class="btn btn-primary full" style="margin-top:0.5rem;">Create Exam</button>
            </form>
        </div>
        <div class="table-card card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Exam</th>
                        <th>Term</th>
                        <th>Class</th>
                        <th>Start</th>
                        <th>End</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($exams as $e): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($e['name']); ?></td>
                        <td><?php echo htmlspecialchars($e['term']); ?></td>
                        <td><?php echo htmlspecialchars(($e['class_name'] ?? '').' '.($e['section'] ?? '')); ?></td>
                        <td><?php echo htmlspecialchars($e['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($e['end_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include_once "../includes/footer.php"; ?>
