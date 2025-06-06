<?php
include("partials/header.php");
require_once '_inc/classes/Database.php';
require_once '_inc/classes/User.php';

$db = new Database();
$user = new User($db);
$users = $user->index(); // Fetch all users with role = 1, sorted by points DESC
?>

<main class="main" style="padding-top: 3.4rem;">
    <!-- Main banner -->
    <div class="menu">
        <div class="bg-primary text-white text-center py-5">
            <div class="container">
                <h1 class="display-4">Welcome to Tetris Club!</h1>
                <p class="lead">Connecting Tetris fans from around the world.</p>
            </div>
        </div>
    </div>

    <!-- Accordion Section -->
    <section class="accordion-section mt-5">
        <div class="container">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            History of Tetris
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Tetris was invented in 1984 by Russian scientist Alexey Pajitnov. The game quickly gained popularity around the world and became one of the most famous and iconic video games.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Our Events
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            At Tetris Club we regularly host tournaments, parties, and other events for our members. Join to participate and win prizes!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Table Section -->
    <section class="table-section mt-5">
        <div class="container">
            <h2 class="text-center mb-4 text-dark">Winners Table</h2>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Player</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $rank = 1; ?>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?= $rank++ ?></td>
                                <td><?= htmlspecialchars($u['name']) ?></td>
                                <td><?= htmlspecialchars($u['points']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No winners yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Disclaimer Section -->
    <section class="accordion-section mt-5" style="padding-bottom: 1rem;">
        <div class="container">
            <div class="accordion" id="accordionExample2">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDisclaimer">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDisclaimer" aria-expanded="true" aria-controls="collapseDisclaimer">
                            <strong>!!!Disclaimer!!!</strong>
                        </button>
                    </h2>
                    <div id="collapseDisclaimer" class="accordion-collapse collapse show" aria-labelledby="headingDisclaimer" data-bs-parent="#accordionExample2">
                        <div class="accordion-body">
                            <p><strong>Important! All content on this website is purely a joke and has no intention to offend or demean anyone. All texts, images, and events mentioned on the Tetris Club pages are fictional and created solely for entertainment purposes. We do not aim to hurt the feelings of individuals, organizations, or anyone else.</strong></p> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include("partials/footer.php");
?>