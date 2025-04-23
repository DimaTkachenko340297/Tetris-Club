<?php
  include('partials/header.php');
  require_once '_inc/classes/Database.php';
  require_once '_inc/classes/Contact.php'; // если используешь Contact

$db = new Database();
$contact = new Contact($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if ($contact->create($name, $email, $message)) {
        header("Location: thankyou.php");
        exit;
    } else {
        $error = "Ошибка при отправке сообщения.";
    }
}
?>
        <main class="main" style="padding-top: 4rem;">
            <!-- Main banner -->
             <div class="menu">
                <div class="bg-primary text-white text-center py-5">
                    <div class="container">
                        <h1 class="display-4">Welcome to Tetris Club!</h1>
                        <p class="lead">Connecting Tetris fans from around the world.</p>
                        <a href="#registration" class="btn btn-light btn-lg">Join us</a>
                    </div>
                </div>
             </div>

            <!-- Features Section -->
            <section class="option">
                <div class="container py-5">
                    <h2 class="text-center text-dark mb-4">What We Offer:</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card h-100">
                                <img class="card-img-top" src="img/obrazok_title0.png" alt="obrazok Lessons and Strategies">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Lessons and Strategies</h5>
                                    <p class="card-text">Learn secrets from professional players and improve your skills.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <img class="card-img-top" src="img/obrazok_title1.png"  alt="obrazok Tournaments">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Tournaments</h5>
                                    <p class="card-text">Join our competitions and showcase your best results.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <img class="card-img-top" src="img/obrazok_title2.png"  alt="obrazok Community">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Community</h5>
                                    <p class="card-text">Engage with other Tetris fans and share your experience.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="text-center py-3">
                <h2>Featured Links</h2>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="random_button">
                                <a href="blog.php" class="btn btn-success btn-lg rounded-pill">Blog</a>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="random_button">
                                <!-- kreatívny bod -->
                                <a href="random.php" class="btn btn-danger btn-lg rounded-pill">Who are you today?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

<!-- HTML часть -->
<div id="registration" class="registration">
    <div class="container" style="padding-bottom: 4rem;">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Registration</h2>

                        <!-- Отображаем ошибку, если есть -->
                        <?php if (!empty($error)) : ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <!-- Обратите внимание: action теперь указывает на тот же файл -->
                        <form id="registrationForm" method="POST" action="">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message:</label>
                                <textarea class="form-control" id="message" name="message" required></textarea>
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="consent" name="consent" required>
                                <label class="form-check-label" for="consent">Consent to the processing of personal data</label>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            
        </main>
<?php
  include("partials/footer.php")
?>