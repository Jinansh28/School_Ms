<?php
require_once "../includes/auth.php";
require_role('admin');
require_once "../config/db.php";
include_once "../includes/header.php";

$stmt = $pdo->query("SELECT s.*, c.name AS class_name, c.section 
                     FROM students s 
                     LEFT JOIN classes c ON s.class_id = c.id
                     ORDER BY s.id DESC");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">ADMIN &middot; STUDENTS</p>
        <h2>Students</h2>
    </header>
    <a href="students_add.php" class="btn btn-primary">Add Student</a>

    <div class="table-card card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Admission No</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $s): ?>
                <tr>
                    <td><?php echo $s['id']; ?></td>
                    <td><?php echo htmlspecialchars($s['admission_no']); ?></td>
                    <td><?php echo htmlspecialchars($s['first_name'].' '.$s['last_name']); ?></td>
                    <td><?php echo htmlspecialchars(trim(($s['class_name'] ?? '').' '.($s['section'] ?? ''))); ?></td>
                    <td><?php echo htmlspecialchars($s['phone']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php include_once "../includes/footer.php"; ?>
