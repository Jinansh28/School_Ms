<?php
require_once "../includes/auth.php";
require_role('admin');
require_once "../config/db.php";

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $section = trim($_POST['section']);
    if ($name) {
        $stmt = $pdo->prepare("INSERT INTO classes (name, section) VALUES (?, ?)");
        $stmt->execute([$name, $section]);
    } else {
        $error = "Class name is required.";
    }
}

$stmt = $pdo->query("SELECT * FROM classes ORDER BY name, section");
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

include_once "../includes/header.php";
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">ADMIN &middot; CLASSES</p>
        <h2>Classes</h2>
    </header>
    <div class="two-col">
        <div class="card card-form">
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <h3>Add Class</h3>
            <form method="post">
                <label>Class Name*</label>
                <input type="text" name="name" placeholder="e.g. Class VI" required>
                <label>Section</label>
                <input type="text" name="section" placeholder="A / B / C">
                <button type="submit" class="btn btn-primary full" style="margin-top:0.5rem;">Add</button>
            </form>
        </div>
        <div class="table-card card">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Class</th>
                        <th>Section</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($classes as $c): ?>
                    <tr>
                        <td><?php echo $c['id']; ?></td>
                        <td><?php echo htmlspecialchars($c['name']); ?></td>
                        <td><?php echo htmlspecialchars($c['section']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include_once "../includes/footer.php"; ?>
