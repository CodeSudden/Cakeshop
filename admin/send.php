<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if sendUpdateEmail function is not already defined
if (!function_exists('sendUpdateEmail')) {
    // Include PHPMailer library and define sendUpdateEmail function
    
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';
    require '../phpmailer/src/Exception.php';

    function sendUpdateEmail($recipient_email, $subject, $body) {
    
    
        $mail = new PHPMailer(true);
    
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'cakebliss3d@gmail.com';  // Update with your SMTP username
            $mail->Password = 'gfid wnwc cdlg rliu';  // Update with your SMTP password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
        
            // Recipients
            $mail->setFrom('cakebliss3d@gmail.com', 'Cake Bliss');
            $mail->addAddress($recipient_email);  // Add a recipient
        
            // Content
            $mail->isHTML(true);  // Set email format to HTML
        
            // Set email subject and body
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body); // Convert HTML to plain text
        
            $mail->send();
            return true; // Email sent successfully
        } catch (Exception $e) {
            return $e->getMessage(); // Return the error message
        }
        
    }
    
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $recipient_email = isset($_POST['email']) ? $_POST['email'] : '';
    $order_status = isset($_POST['status']) ? $_POST['status'] : '';
    // Assuming you have a field for payment status in your form
    $payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : '';

    // Compose email subject and body
    $subject = 'Order Update';
    $body = 'Your order status has been updated to: ' . $order_status . '<br>';
    $body .= 'Payment status: ' . $payment_status;

    // Send update email
    $email_result = sendUpdateEmail($recipient_email, $subject, $body);
    if ($email_result === true) {
        echo "
        <script>
        alert('Order confirmation sent successfully.');
        document.location.href = 'admin_order.php';  // Redirect to a confirmation page
        </script>
        ";
    } elseif ($email_result === false) {
        echo "
        <script>
        alert('Message could not be sent. Please try again later.');
        document.location.href = 'admin_order.php';  // Redirect to an error page
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Email successfully sent! ');
        document.location.href = 'admin_order.php';  // Redirect to an error page
        </script>
        ";
    }
    
}
?>
