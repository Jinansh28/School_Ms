<?php
require_once "../includes/auth.php";
require_role('admin');
require_once "../config/db.php";

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $body  = trim($_POST['body']);
    $scope = $_POST['role_scope'] ?? 'all';

    if ($title && $body) {
        $stmt = $pdo->prepare("INSERT INTO announcements (title, body, role_scope, created_by) VALUES (?,?,?,?)");
        $stmt->execute([$title, $body, $scope, $_SESSION['user']['id']]);
    } else {
        $error = "Title and body are required.";
    }
}

$stmt = $pdo->query("SELECT a.*, u.username 
                     FROM announcements a
                     LEFT JOIN users u ON a.created_by = u.id
                     ORDER BY a.created_at DESC LIMIT 50");
$announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

include_once "../includes/header.php";
?>
<section class="section">
    <header class="section-header align-left">
        <p class="eyebrow">ADMIN &middot; NOTICES</p>
        <h2>Notices &amp; Announcements</h2>
    </header>
    <div class="two-col">
        <div class="card card-form">
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <h3>Create Notice</h3>
            <form method="post">
                <label>Title*</label>
                <input type="text" name="title" required>
                <label>Audience</label>
                <select name="role_scope">
                    <option value="all">Everyone</option>
                    <option value="students">Students</option>
                    <option value="teachers">Teachers</option>
                </select>
                <label>Message*</label>
                <textarea name="body" rows="4" style="resize:vertical;width:100%;padding:0.5rem;border-radius:0.7rem;border:1px solid #e5e7eb;"></textarea>
                <button type="submit" class="btn btn-primary full" style="margin-top:0.6rem;">Publish Notice</button>
            </form>
        </div>
        <div class="card table-card">
            <h3 style="margin-top:0;">Recent Notices</h3>
            <?php if (!$announcements): ?>
                <p style="font-size:0.9rem;color:#6b7280;">No notices yet.</p>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Audience</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($announcements as $a): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($a['title']); ?></td>
                            <td><?php echo htmlspecialchars($a['role_scope']); ?></td>
                            <td><?php echo htmlspecialchars($a['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php include_once "../includes/footer.php"; ?>
