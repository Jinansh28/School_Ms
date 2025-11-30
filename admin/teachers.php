<?php
require_once "../includes/auth.php";
require_role('admin');
require_once "../config/db.php";
include_once "../includes/header.php";

$stmt = $pdo->query("SELECT * FROM teachers ORDER BY id DESC");
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">ADMIN &middot; TEACHERS</p>
        <h2>Teachers</h2>
        <p>Basic list view. You can extend this with add/edit forms.</p>
    </header>
    <div class="table-card card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Qualification</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($teachers as $t): ?>
                <tr>
                    <td><?php echo $t['id']; ?></td>
                    <td><?php echo htmlspecialchars($t['emp_code']); ?></td>
                    <td><?php echo htmlspecialchars($t['first_name'].' '.$t['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($t['phone']); ?></td>
                    <td><?php echo htmlspecialchars($t['qualification']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php include_once "../includes/footer.php"; ?>
