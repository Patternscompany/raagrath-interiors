<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $project = strip_tags(trim($_POST["subject"]));
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
        $mail->setFrom('leads@raagrathinteriors.com', 'Raagrath Google Ads');
        $mail->addAddress('pandureddypatterns@gmail.com');
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "🔥 NEW GOOGLE ADS LEAD: $name";

        // HTML Email Template
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #dcb54e; border-radius: 12px; overflow: hidden; background-color: #f9f9f9;'>
            <div style='background-color: #1a1a1a; padding: 30px; text-align: center; border-bottom: 3px solid #dcb54e;'>
                <h1 style='color: #dcb54e; margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 2px;'>Raagrath Interiors</h1>
                <p style='color: #fff; margin: 5px 0 0; font-size: 14px;'>Google Ads Campaign Inquiry</p>
            </div>
            <div style='padding: 30px;'>
                <h2 style='color: #333; font-size: 18px; margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px;'>Lead Details</h2>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr>
                        <td style='padding: 12px 0; color: #777; width: 120px;'><strong>Name:</strong></td>
                        <td style='padding: 12px 0; color: #333;'>$name</td>
                    </tr>
                    <tr>
                        <td style='padding: 12px 0; color: #777;'><strong>Email:</strong></td>
                        <td style='padding: 12px 0; color: #333;'><a href='mailto:$email' style='color: #dcb54e; text-decoration: none;'>$email</a></td>
                    </tr>
                    <tr>
                        <td style='padding: 12px 0; color: #777;'><strong>Phone:</strong></td>
                        <td style='padding: 12px 0; color: #333;'><a href='tel:$phone' style='color: #dcb54e; text-decoration: none;'>$phone</a></td>
                    </tr>
                    <tr>
                        <td style='padding: 12px 0; color: #777;'><strong>Project Type:</strong></td>
                        <td style='padding: 12px 0; color: #333;'>$project</td>
                    </tr>
                </table>
                <div style='margin-top: 30px; padding: 20px; background-color: #fff; border-left: 4px solid #dcb54e; border-radius: 4px;'>
                    <p style='margin: 0; color: #777; font-size: 12px; text-transform: uppercase;'>Message:</p>
                    <p style='margin: 10px 0 0; color: #333; line-height: 1.6;'>$message</p>
                </div>
                <div style='margin-top: 40px; text-align: center;'>
                    <a href='mailto:$email' style='background-color: #dcb54e; color: #000; padding: 15px 40px; text-decoration: none; border-radius: 30px; font-weight: bold; display: inline-block; box-shadow: 0 4px 10px rgba(220, 181, 78, 0.3);'>REPLY TO LEAD</a>
                </div>
            </div>
            <div style='background-color: #1a1a1a; padding: 20px; text-align: center; color: #999; font-size: 11px;'>
                <p style='margin: 0;'>&copy; 2026 Raagrath Interiors. All Rights Reserved.</p>
                <p style='margin: 5px 0 0;'>This inquiry was captured via the Google Ads Campaign Landing Page.</p>
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