<?php
session_start();
require_once '_inc/classes/Database.php';
require_once '_inc/classes/Authenticate.php';
require_once '_inc/classes/Contact.php';
require_once '_inc/classes/User.php';

$db = new Database();
$auth = new Authenticate($db);
$contact = new Contact($db);
$user = new User($db);

$auth->requireLogin();

$userRole = $auth->getUserRole();
$userEmail = $_SESSION['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_message'])) {
    $name = $_SESSION['name'] ?? 'Unknown';
    $email = $_SESSION['email'] ?? '';
    $message = $_POST['message'] ?? '';
    
    if (!empty($message) && $contact->create($name, $email, $message)) {
        header("Location: admin.php?message_sent=1");
        exit;
    } else {
        $error = "Ошибка при отправке сообщения";
    }
}

if (isset($_GET['delete'])) {
    $messageId = $_GET['delete'];
    $message = $contact->show($messageId);
    if ($message && ($userRole == 0 || ($message['email'] ?? '') == $userEmail)) {
        $contact->destroy($messageId);
        header("Location: admin.php");
        exit;
    } else {
        $error = "Вы не авторизованы для удаления этого сообщения.";
    }
}

if ($userRole == 0 && isset($_GET['delete_user'])) {
    $userId = $_GET['delete_user'];
    if ($userId != $_SESSION['user_id']) {
        if ($user->destroy($userId)) {
            header("Location: admin.php");
            exit;
        } else {
            $error = "Ошибка при удалении пользователя";
        }
    } else {
        $error = "Вы не можете удалить самого себя";
    }
}

if ($userRole == 0) {
    $contacts = $contact->index();
} else {
    $contacts = $contact->getUserMessages($userEmail);
}

$currentUser = $user->getUserById($_SESSION['user_id'] ?? 0);
$points = $currentUser['points'] ?? 0;

include('partials/header.php');
?>

<main class="main" style="padding-top: 3.4rem;">
    <div class="container">

        <h2 class="mt-4">Messages</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['message_sent'])): ?>
            <div class="alert alert-success">Сообщение успешно отправлено!</div>
        <?php endif; ?>
        <?php if (!empty($contacts)): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Message</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $con): ?>
                            <tr>
                                <td><?= htmlspecialchars($con['name'] ?? 'Unknown') ?></td>
                                <td><pre style="white-space: pre-wrap;"><?= htmlspecialchars($con['message'] ?? 'No message') ?></pre></td>
                                <td>
                                    <a href="contact-show.php?id=<?= htmlspecialchars($con['id']) ?>" class="btn btn-sm btn-info">View</a>
                                    <?php if ($userRole == 0 || ($con['email'] ?? '') == $userEmail): ?>
                                        <a href="contact-edit.php?id=<?= htmlspecialchars($con['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="?delete=<?= htmlspecialchars($con['id']) ?>" class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Удалить это сообщение?')">Delete</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>There are no messages yet.</p>
        <?php endif; ?>

        <br>


        <?php if ($userRole == 0): ?>
            <?php
            $users = $user->index();
            ?>
            <h2 class="mt-5">Users</h2>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Points</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?= htmlspecialchars($u['id']) ?></td>
                                <td><?= htmlspecialchars($u['name']) ?></td>
                                <td><?= htmlspecialchars($u['email']) ?></td>
                                <td><?= ($u['role'] == 0) ? 'Admin' : 'User' ?></td>
                                <td><?= htmlspecialchars($u['points']) ?></td>
                                <td>
                                    <a href="user-edit.php?id=<?= htmlspecialchars($u['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                        <a href="?delete_user=<?= htmlspecialchars($u['id']) ?>" class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Удалить этого пользователя?')">Delete</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>

            <div class="card mt-4">
                <div class="card-body">
                    <h2 class="card-title">Your points</h2>
                    <p>You have <?= htmlspecialchars($points) ?> points.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>
<br><br><br><br><br><br>
<br><br><br><br><br><br>

<?php include('partials/footer.php'); ?>