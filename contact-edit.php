<?php
include('partials/header.php');
$db = new Database();
$contact = new Contact($db);

if(isset($_GET['id'])){
    //print_r($_GET['id']);
    $id = $_GET['id'];
    $contactData = $contact->show($id);
    //print_r($contactData);
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        //print_r($_POST);
        if ($contact->edit($id,$name, $email, $message)) {
          header("Location: admin.php");
          exit;
        } else {
            echo "Error editing contact.";
        }
      }
}

?>
<main class="main">
<br>
<br>
<br>
<br>
<section class="container">
    <h1>Update contact</h1>
    <form id="contact" action="" method="POST">
        <input type="text" id ="name" name="name" value="<?php echo($contactData['name']);?>" required><br>
        <input type="email" id="email" name="email" value="<?php echo($contactData['email']);?>"required><br>
        <textarea id="message" name="message"><?php echo($contactData['message']);?></textarea><br>
        <input type="submit" value="Odoslať">
    </form>
</section>
</main>
<?php
include('partials/footer.php');
?>