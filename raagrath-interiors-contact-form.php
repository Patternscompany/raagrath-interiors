<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $subject = strip_tags(trim($_POST["subject"]));
    $message = isset($_POST["message"]) ? strip_tags(trim($_POST["message"])) : "No message provided.";

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration (inherited from existing setup)
// SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'localhost'; // Replace with your SMTP server address
        $mail->SMTPAuth = false;
        $mail->Username = ''; // Replace with your SMTP username
        $mail->Password = ''; // Replace with your SMTP password
        //   $mail->SMTPSecure = 'ssl'; 
        $mail->Port = 25; // Use 587 for TLS, 465 for SSL

        // Email settings
        $mail->setFrom('website@raagrathinteriors.com', 'Raagrath Website');
        $mail->addAddress('pandureddypatterns@gmail.com');
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "New Website Inquiry: $subject";

        // HTML Email Template
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #333; border-radius: 12px; overflow: hidden; background-color: #fff;'>
            <div style='background-color: #1a1a1a; padding: 20px 30px; text-align: left; border-bottom: 2px solid #dcb54e;'>
                <h1 style='color: #dcb54e; margin: 0; font-size: 20px; font-weight: normal; text-transform: uppercase;'>Raagrath Interiors Report</h1>
            </div>
            <div style='padding: 30px; color: #333;'>
                <p style='color: #888; font-size: 14px; margin-bottom: 30px;'>A new message has been received from the Raagrath Interiors website contact form:</p>
                <div style='background-color: #f7f7f7; padding: 20px; border-radius: 8px;'>
                    <table style='width: 100%; border-collapse: collapse;'>
                        <tr>
                            <td style='padding: 8px 0; font-size: 14px; color: #777; width: 100px;'>NAME:</td>
                            <td style='padding: 8px 0; font-size: 14px; color: #333; font-weight: bold;'>$name</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; font-size: 14px; color: #777;'>EMAIL:</td>
                            <td style='padding: 8px 0; font-size: 14px; color: #333; font-weight: bold;'>$email</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; font-size: 14px; color: #777;'>PHONE:</td>
                            <td style='padding: 8px 0; font-size: 14px; color: #333; font-weight: bold;'>$phone</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; font-size: 14px; color: #777;'>SUBJECT:</td>
                            <td style='padding: 8px 0; font-size: 14px; color: #333; font-weight: bold;'>$subject</td>
                        </tr>
                    </table>
                </div>
                <div style='margin-top: 30px;'>
                    <h3 style='color: #dcb54e; font-size: 14px; text-transform: uppercase; margin-bottom: 15px;'>Message Details:</h3>
                    <p style='line-height: 1.6; color: #444; background: #fff; padding: 15px; border: 1px solid #eee; border-radius: 4px;'>$message</p>
                </div>
                <div style='margin-top: 40px; text-align: center; border-top: 1px solid #eee; padding-top: 25px;'>
                    <a href='mailto:$email' style='background-color: #1a1a1a; color: #dcb54e; padding: 12px 35px; text-decoration: none; border-radius: 4px; font-weight: bold; border: 1px solid #dcb54e;'>REPLY NOW</a>
                </div>
            </div>
            <div style='background-color: #f7f7f7; padding: 20px; text-align: center; color: #aaa; font-size: 11px;'>
                <p>&copy; 2026 Raagrath Interiors. This is an automated lead notification.</p>
            </div>
        </div>";

        $mail->send();
        echo "success";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    header("Location: index.html");
    exit;
}
?>