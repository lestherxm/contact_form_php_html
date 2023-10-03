<?php
require("mail.php");
// Variables needed to handle interactive messages with sweet2
$status = "";
$status_message = "";

function validate($name, $email, $subject, $message, $form){
    return (!empty($name) && !empty($subject) && !empty($message) && validateEmail($email));
}

function validateEmail($email) {
    // Utiliza una expresión regular para validar el formato del correo electrónico
    return preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email);
}

if (isset($_POST["form"])) {
    try {
        // Validar si se envían datos vacíos
        if (validate(... $_POST)) { // validate($_POST["name"], $_POST["email"], $_POST["subject"], $_POST["message"])
            $name = $_POST["name"];
            $email = $_POST["email"];
            $subject = $_POST["subject"];
            $message = $_POST["message"];

            $body = 
            "$name <$email> is sending to you the folowing message: <br><br> $message";

            //Logica para mandar el correo
            sendMail($subject, $body, $email, $name, true);

            $status = "success";
            $status_message = "The message has been sent successfully";

        }else{ // Si se envían datos vacíos o el email no es válido, mostrar mensaje de error
            $status = "danger";
            $status_message = "Please fill out all the inputs in the form correctly";
        }
    } catch (\Throwable $th) {
        $status = "danger";
        $status_message = "Sorry, we could not send the message";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Sweet alert para mensajes bonitos :3 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Contact Form</title>
</head>

<body>
    <!-- SUCCESS MESSAGES -->
    <?php if($status == 'success') : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Good job!',
                text: '<?= $status_message ?>',
                confirmButtonText: 'Nice',
            }).then((result)=>{
                if(result.isConfirmed){
                    window.location = '<?= $_SERVER["PHP_SELF"] ?>';
                }
            })
        </script>
    <?php endif; ?>

    <!-- ERROR MESSAGES -->
    <?php if($status == 'danger') : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '<?= $status_message ?>',
                confirmButtonText: 'Ok',
            }).then((result)=>{
                if(result.isConfirmed){
                    window.location = '<?= $_SERVER["PHP_SELF"] ?>';
                }
            })
        </script>
    <?php endif; ?>

    <!-- FORM SECTION-->
    <form action="<?= $_SERVER["PHP_SELF"] ?>" autocomplete="off" method="post" id="contact_form">
        <h1>Contact Form</h1>

        <div class="input-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
        </div>

        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
        </div>

        <div class="input-group">
            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject">
        </div>

        <div class="input-group">
            <label for="message">Message:</label>
            <textarea name="message" id="message"></textarea>
        </div>

        <div class="button-container">
            <button name="form" type="submit">Send</button>
        </div>

        <div class="contact-info">
            <div class="info">
                <span><i class="fa-solid fa-map-location-dot"></i> Guatemala, Guatemala</span>
            </div>

            <div class="info">
                <span><i class="fa-solid fa-square-phone"></i> (+502) 1234-5678</span>
            </div>
        </div>
    </form>
    <script src="https://kit.fontawesome.com/415f4d1bf2.js" crossorigin="anonymous"></script>
</body>
</html>
