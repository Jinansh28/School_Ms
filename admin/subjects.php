<?php
require_once "../includes/auth.php";
require_role('admin');
require_once "../config/db.php";

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $code = trim($_POST['code']);
    $class_id = (int)($_POST['class_id'] ?? 0);
    if ($name && $code && $class_id) {
        $stmt = $pdo->prepare("INSERT INTO subjects (name, code, class_id) VALUES (?,?,?)");
        $stmt->execute([$name, $code, $class_id]);
    } else {
        $error = "All fields are required.";
    }
}

$classes = $pdo->query("SELECT * FROM classes ORDER BY name, section")->fetchAll(PDO::FETCH_ASSOC);
$stmt = $pdo->query("SELECT s.*, c.name AS class_name, c.section FROM subjects s 
                     LEFT JOIN classes c ON s.class_id = c.id
                     ORDER BY c.name, c.section, s.name");
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

include_once "../includes/header.php";
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">ADMIN &middot; SUBJECTS</p>
        <h2>Subjects</h2>
    </header>
    <div class="two-col">
        <div class="card card-form">
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <h3>Add Subject</h3>
            <form method="post">
                <label>Subject Name*</label>
                <input type="text" name="name" required>
                <label>Code*</label>
                <input type="text" name="code" required>
                <label>Class*</label>
                <select name="class_id" required>
                    <option value="">-- Select --</option>
                    <?php foreach ($classes as $c): ?>
                        <option value="<?php echo $c['id']; ?>">
                            <?php echo htmlspecialchars($c['name'].' '.$c['section']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary full" style="margin-top:0.5rem;">Add</button>
            </form>
        </div>
        <div class="table-card card">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Code</th>
                        <th>Class</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($subjects as $s): ?>
                    <tr>
                        <td><?php echo $s['id']; ?></td>
                        <td><?php echo htmlspecialchars($s['name']); ?></td>
                        <td><?php echo htmlspecialchars($s['code']); ?></td>
                        <td><?php echo htmlspecialchars(($s['class_name'] ?? '').' '.($s['section'] ?? '')); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include_once "../includes/footer.php"; ?>
