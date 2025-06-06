<?php
include('partials/header.php');
require_once '_inc/classes/Database.php';
require_once '_inc/classes/User.php';

$db = new Database();
$user = new User($db);

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $consent = isset($_POST['consent']) ? true : false;
    $return = $_POST['return'] ?? ''; // Получаем return из формы

    // Basic validation
    if (!$consent) {
        $error = "You must agree to the processing of personal data";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Default role for new registrations (1 for regular user)
        $role = 1;
        
        if ($user->create($name, $email, $role, $password)) {
            // Перенаправляем на login.php с параметром return
            $redirect = 'login.php';
            if ($return) {
                $redirect .= '?return=' . urlencode($return);
            }
            header("Location: $redirect");
            exit;
        } else {
            $error = "Error creating user. Maybe a user with this email already exists.";
        }
    }
} else {
    // Получаем return из URL
    $return = $_GET['return'] ?? '';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetris Club - Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="wrapper">
        <main class="main" style="padding-top: 3.4rem;">
            <div class="registration">
                <div class="container" style="padding-bottom: 4rem;">
                    <div class="row justify-content-center mt-5">
                        <div class="col-md-6">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <h2 class="card-title text-center mb-4">Registration</h2>

                                    <!-- Display error if exists -->
                                    <?php if (!empty($error)) : ?>
                                        <div class="alert alert-danger"><?= $error ?></div>
                                    <?php endif; ?>

                                    <!-- Registration Form -->
                                    <form id="registrationForm" method="POST" action="">
                                        <input type="hidden" name="return" value="<?php echo htmlspecialchars($return); ?>">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name:</label>
                                            <input type="text" class="form-control" id="name" name="name" required value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">E-mail:</label>
                                            <input type="email" class="form-control" id="email" name="email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password:</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirm Password:</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input" id="consent" name="consent" required>
                                            <label class="form-check-label" for="consent">I agree to the processing of personal data</label>
                                        </div>
                                        <button type="submit" class="btn btn-success w-100">Register</button>
                                    </form>

                                    <!-- Link to login page -->
                                    <div class="text-center mt-3">
                                        <p>Already have an account? <a href="login.php?return=<?php echo urlencode($return); ?>" class="btn btn-primary">Login</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include("partials/footer.php"); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>