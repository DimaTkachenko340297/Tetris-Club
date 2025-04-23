<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Your Fortune</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        img {
            max-width: 80%;
            height: auto;
            border: 2px solid #ccc;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 24px;
            color: #333;
        }
    </style>
</head>
<body>
    
    <h1 id="fortune-text">Today you are...</h1>
    <img id="fortune-image" src="" alt="Random Fortune">
    
    <script src="js/random.js"></script>

    <a href="index.php" class="btn btn-primary btn-lg rounded-pill">Home</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
