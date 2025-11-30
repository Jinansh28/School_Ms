<?php
require_once "../includes/auth.php";
require_role('student');
require_once "../config/db.php";
include_once "../includes/header.php";

$stmt = $pdo->prepare("SELECT * FROM announcements WHERE role_scope IN ('all','students') ORDER BY created_at DESC");
$stmt->execute();
$notices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">STUDENT &middot; NOTICES</p>
        <h2>Notices &amp; Announcements</h2>
    </header>
    <div class="card table-card">
        <?php if (!$notices): ?>
            <p class="helper-text">No notices to show.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($notices as $n): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($n['title']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($n['body'])); ?></td>
                        <td><?php echo htmlspecialchars($n['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>
<?php include_once "../includes/footer.php"; ?>
