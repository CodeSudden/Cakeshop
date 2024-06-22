<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '';  // Update with your SMTP username
        $mail->Password = '';  // Update with your SMTP password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('cakebliss3d@gmail.com', 'Cake Bliss');
        $mail->addAddress($_POST['email'], $_POST['name']);  // Add a recipient

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Order Confirmation';
        $mail->Body    = 'Dear ' . $_POST['name'] . ',<br>Your order is being processed. Thank you for shopping with us!';
        $mail->AltBody = 'Dear ' . $_POST['name'] . ',\nYour order is being processed. Thank you for shopping with us!';

        $mail->send();
        echo "
        <script>
        alert('Order confirmation sent successfully.');
        document.location.href = 'order.php';  // Redirect to a confirmation page
        </script>
        ";
    } catch (Exception $e) {
        echo "
        <script>
        alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');
        document.location.href = 'menu.php';  // Redirect to an error page
        </script>
        ";
    }
}
?>
