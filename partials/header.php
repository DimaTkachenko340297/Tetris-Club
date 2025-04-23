<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetris Club</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (актуальная версия) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Подключение своего CSS -->
    <?php
    $currentPage = basename($_SERVER['PHP_SELF'], '.php');
    
    switch ($currentPage) {
        case 'contact':
            echo '<link rel="stylesheet" href="css/style-contact.css">';
            break;
        default:
            echo '<link rel="stylesheet" href="css/main.css">';
            break;
    }
    ?>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <!-- Навигация -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                <div class="container" style="height: 4rem;">
                    <a class="navbar-brand p-0" href="index.php">Tetris Club</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                            <?php
                            require_once(__DIR__.'/../_inc/classes/Menu.php');

                            $menu = new Menu();
                            $menuItems = $menu->index();

                            foreach ($menuItems as $item) {
                                echo '<li class="nav-item">';
                                echo '<a class="nav-link" href="' . $item['link'] . '">';
                                echo '<i class="' . htmlspecialchars($item['icon']) . ' me-1"></i>';
                                echo $item['label'];
                                echo '</a>';
                                echo '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>