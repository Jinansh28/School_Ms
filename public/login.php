<?php
require_once "../config/db.php";
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usernameOrEmail && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :ue OR email = :ue LIMIT 1");
        $stmt->execute(['ue' => $usernameOrEmail]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            if ((int)$user['status'] !== 1) {
                $error = "Account is disabled. Please contact the school office.";
            } else {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                ];
                header('Location: /schoolms/public/dashboard.php');
                exit;
            }
        } else {
            $error = "Invalid username/email or password.";
        }
    } else {
        $error = "Please enter username/email and password.";
    }
}
?>
<?php include_once "../includes/header.php"; ?>

<section class="section narrow">
    <header class="section-header align-left">
        <p class="eyebrow">PORTAL LOGIN</p>
        <h2>Sign in to Lord Buddha School Portal</h2>
        <p>Students, teachers and admins can use their assigned credentials.</p>
    </header>

    <div class="card card-form">
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Username or Email</label>
            <input type="text" name="username" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <button type="submit" class="btn btn-primary full">Login</button>
        </form>
        <p class="helper-text">
            For demo, the first admin user you create in the database can log in here.
        </p>
    </div>
</section>

<?php include_once "../includes/footer.php"; ?>
