<?php
include('partials/header.php');
$db = new Database();
$contact = new Contact($db);

if(isset($_GET['id'])){
    //print_r($_GET['id']);
    $id = $_GET['id'];
    $contactData = $contact->show($id);
    //print_r($contactData);
}

?>
<main class="main">
<br>
<br>
<br>
<br>
<section class="container">
    <h1>Contact show</h1>
    <p>Name: <?php echo($contactData['name']);?></p>
    <p>Email: <?php echo($contactData['email']);?></p>
    <p>Message: <?php echo($contactData['message']);?></p>
    <a href="admin.php">Back to Contacts</a>
</section>
</main>
<?php
include('partials/footer.php');
?>