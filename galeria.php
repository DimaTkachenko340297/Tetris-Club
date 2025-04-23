<?php
    include('_inc/classes/Qna.php');
    include("partials/header.php");
?>

        <main class="main">
            <!-- Gallery Section -->
            <section class="gallery py-5">
                <div class="container" style="padding-top: 50px;">
                    <h2 class="text-center text-dark mb-4">Gallery</h2>

                    <div class="bg-dark p-5">
                        <div id="multiCarousel" class="carousel slide carousel-multi-item" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <img src="img/item0.png" class="d-block w-100" alt="Image 0">
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="img/item1.png" class="d-block w-100" alt="Image 1">
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="img/item2.png" class="d-block w-100" alt="Image 2">
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <img src="img/item3.png" class="d-block w-100" alt="Image 3">
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="img/item4.png" class="d-block w-100" alt="Image 4">
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="img/item5.png" class="d-block w-100" alt="Image 5">
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <img src="img/item6.png" class="d-block w-100" alt="Image 6">
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="img/item3.png" class="d-block w-100" alt="Image 7">
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="img/item2.png" class="d-block w-100" alt="Image 8">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#multiCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#multiCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <section class = "container">
                                <?php
                                $qna = new Qna();
                                $qnaItems = $qna->index();

                                foreach($qnaItems as $item){
                                    echo '<div class="accordion">';
                                    echo '<div class="question">' . $item['question'] . '</div>';
                                    echo '<div class="answer">' . $item['answer'] . '</div>';
                                    echo '</div>';
                                }
                                ?>
                            </section>

        <footer class="footer">
            <section class="stylfooter">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-6">
                            <h4>Information</h4>
                            <ul class="list-unstyled">
                                <li><a href="index.php">Home</a></li>
                                <li><a href="about.php">About Us</a></li>
                                <li><a href="gallery.php">Gallery</a></li>
                                <li><a href="contact.php">Contact</a></li>
                            </ul>
                        </div>

                        <div class="col-md-3 col-6">
                            <h4>Opening hours</h4>
                            <ul class="list-unstyled">
                                <li>Address: Mount Zobor, Tetris Village</li>
                                <li>Mon |Wed |Fri</li>
                                <li>6am-9am</li>
                            </ul>
                        </div>

                        <div class="col-md-3 col-6">
                            <h4>Contacts</h4>
                            <ul class="list-unstyled">
                                <li><a href="tel:00000001">000 000-01</a></li>
                                <li><a href="tel:00000010">000 000-10</a></li>
                                <li><a href="mailto:info@tetrisclub.com">info@tetrisclub.com</a></li>
                            </ul>
                        </div>

                        <div class="col-md-3 col-6">
                            <h4>Social networks</h4>
                            <div class="stylfooter-icons">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stylfooter-author">
                    <h4 class="text-center">© 2024 Tetris Club</h4>
                </div>
            </section>
        </footer> 
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
