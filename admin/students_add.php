<?php
require_once "../includes/auth.php";
require_role('admin');
require_once "../config/db.php";

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admission_no = trim($_POST['admission_no']);
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);
    $class_id   = (int)($_POST['class_id'] ?? 0);
    $phone      = trim($_POST['phone']);

    if ($admission_no && $first_name && $email) {
        try {
            $pdo->beginTransaction();

            $username = $admission_no;
            $passwordPlain = 'student123';
            $hash = password_hash($passwordPlain, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("INSERT INTO users (username,email,password_hash,role)
                                   VALUES (?,?,?, 'student')");
            $stmt->execute([$username, $email, $hash]);
            $user_id = $pdo->lastInsertId();

            $stmt = $pdo->prepare("INSERT INTO students (user_id, admission_no, first_name, last_name, class_id, phone)
                                   VALUES (?,?,?,?,?,?)");
            $stmt->execute([$user_id, $admission_no, $first_name, $last_name, $class_id, $phone]);

            $pdo->commit();
            $success = "Student added. Default password: {$passwordPlain}";
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Admission No, First Name, and Email are required.";
    }
}

$classes = $pdo->query("SELECT * FROM classes ORDER BY name, section")->fetchAll(PDO::FETCH_ASSOC);

include_once "../includes/header.php";
?>
<section class="section narrow">
    <header class="section-header align-left">
        <p class="eyebrow">ADMIN &middot; STUDENTS</p>
        <h2>Add Student</h2>
    </header>
    <div class="card card-form">
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert" style="background:#ecfdf5;color:#166534;border:1px solid #bbf7d0;">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <label>Admission No*</label>
            <input type="text" name="admission_no" required>
            <label>First Name*</label>
            <input type="text" name="first_name" required>
            <label>Last Name</label>
            <input type="text" name="last_name">
            <label>Email*</label>
            <input type="email" name="email" required>
            <label>Phone</label>
            <input type="text" name="phone">
            <label>Class</label>
            <select name="class_id">
                <option value="">-- Select --</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>">
                        <?php echo htmlspecialchars($c['name'].' '.$c['section']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary full" style="margin-top:0.6rem;">Save Student</button>
        </form>
    </div>
</section>
<?php include_once "../includes/footer.php"; ?>
