<?php
include('partials/header.php');
require_once '_inc/classes/Database.php';
require_once '_inc/classes/Authenticate.php';

$db = new Database();
$auth = new Authenticate($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $return = $_POST['return'] ?? ''; // Получаем return из формы

    if ($auth->login($email, $password)) {
        $role = $_SESSION['role'] ?? 1; // По умолчанию обычный пользователь
        // Проверяем, если пользователь хочет на admin.php, но не админ
        if ($return === 'admin.php' && $role !== 0) {
            header('Location: tetris.php'); // Перенаправляем не-админов на tetris.php
        } elseif ($return && in_array($return, ['tetris.php', 'admin.php'])) {
            header('Location: ' . $return); // Редирект на выбранную страницу
        } elseif ($role === 0) {
            header('Location: admin.php'); // Админы по умолчанию на admin.php
        } else {
            header('Location: tetris.php'); // Пользователи по умолчанию на tetris.php
        }
        exit;
    } else {
        $error = "Nepodarilo sa prihlásiť";
    }
} else {
    // Получаем return из URL для передачи в форму
    $return = $_GET['return'] ?? '';
}
?>

<main class="main">
    <section class="container py-5">
        <h2 class="display-4 text-center mb-4">Prihlásenie</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form method="POST" class="mx-auto" style="max-width: 400px;">
            <input type="hidden" name="return" value="<?php echo htmlspecialchars($return); ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Heslo</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Prihlásiť sa</button>
        </form>
        <div class="text-center mt-3">
            <p>Don't have an account? <a href="index.php?return=<?php echo urlencode($return); ?>" class="btn btn-link">Register</a></p>
        </div>
    </section>
</main>
<br>
<br>
<br>
<?php
include('partials/footer.php');
?>