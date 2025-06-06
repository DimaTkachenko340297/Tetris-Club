<?php
include('partials/header.php');

$db = new Database();
$user = new User($db);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $userData = $user->show($id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $points = $_POST['points'];

        // Validate points
        if (!is_numeric($points) || $points < 0) {
            echo "<p style='color: red;'>Points must be a non-negative number.</p>";
        } else {
            if ($user->edit($id, $name, $email, $role, $points)) {
                header("Location: admin.php");
                exit;
            } else {
                echo "<p style='color: red;'>Error editing user. Možno už existuje používateľ s týmto emailom.</p>";
            }
        }
    }
}
?>

<section class="container">
    <h1>Update User</h1>
    <form id="user" action="" method="POST">
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($userData['name']) ?>" required><br>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required><br>
        <input type="number" id="points" name="points" value="<?= htmlspecialchars($userData['points']) ?>" required><br>

        <select id="role" name="role" required>
            <option value="0" <?= $userData['role'] == 0 ? 'selected' : '' ?>>Admin</option>
            <option value="1" <?= $userData['role'] == 1 ? 'selected' : '' ?>>User</option>
        </select><br>

        <input type="submit" value="Uložiť zmeny">
    </form>
</section>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php
include('partials/footer.php');
?>