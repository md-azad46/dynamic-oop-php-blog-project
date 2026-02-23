<?php
include 'inc/header.php';
include 'inc/sidebar.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ===== PHPMailer Path =====
require __DIR__ . '/PHPMailer-master/src/Exception.php';
require __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer-master/src/SMTP.php';

// Redirect if msgid not set
if (!isset($_GET['msgid']) || $_GET['msgid'] == NULL) {
    echo "<script>window.location = 'inbox.php'; </script>";
    exit();
} else {
    $msgid = mysqli_real_escape_string($db->link, $_GET['msgid']);
}
?>

<div class="grid_10">
<div class="box round first grid">
<h2>Reply Message</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $toEmail   = $_POST['toEmail'];
    $fromEmail = $_POST['fromEmail'];
    $subject   = $_POST['subject'];
    $message   = $_POST['message'];

    if (empty($fromEmail) || empty($subject) || empty($message)) {
        echo "<span class='error'>All fields are required!</span>";
    } else {

        $mail = new PHPMailer(true);

        try {

            // ===== SMTP CONFIG =====
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'azadcse14716@gmail.com'; 
            $mail->Password   = 'gtjpwlwultsdhcuh'; // NO SPACE
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->SMTPDebug  = 0; // 2 দিলে error দেখাবে

            // ===== EMAIL SETTINGS =====
            $mail->setFrom($mail->Username, 'Blog Admin');
            $mail->addAddress($toEmail);
            $mail->addReplyTo($fromEmail);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            if($mail->send()){
                echo "<span class='success'>Email Sent Successfully!</span>";
            }

        } catch (Exception $e) {
            echo "<span class='error'>Mailer Error: {$mail->ErrorInfo}</span>";
        }
    }
}
?>

<div class="block">
<form action="" method="POST">

<?php
$query = "SELECT * FROM tbl_contact WHERE id='$msgid'";
$showMsg = $db->select($query);

if ($showMsg) {
    while ($result = $showMsg->fetch_assoc()) {
?>

<table class="form">

<!-- Original Message Display - ঠিক আপনার প্রথম কোডের মতো -->
<tr>
    <td style="vertical-align: top; padding-top: 9px;">
        <label>Original Message</label>
    </td>
    <td>
        <textarea class="tinymce" readonly cols="10"><?php echo $result['body']; ?></textarea>
    </td>
</tr>

<tr>
    <td><label>To</label></td>
    <td>
        <input type="email" name="toEmail"
               value="<?php echo $result['email']; ?>"
               class="medium" readonly />
    </td>
</tr>

<tr>
    <td><label>From</label></td>
    <td>
        <input type="email" name="fromEmail"
               placeholder="Enter Your Email"
               class="medium" required />
    </td>
</tr>

<tr>
    <td><label>Subject</label></td>
    <td>
        <input type="text" name="subject"
               placeholder="Enter Subject"
               class="medium" required />
    </td>
</tr>

<!-- Message Field - এখন TinyMCE Editor দিয়ে সাজানো -->
<tr>
    <td style="vertical-align: top; padding-top: 9px;">
        <label>Reply Message</label>
    </td>
    <td>
        <textarea class="tinymce" name="message" cols="10" placeholder="Enter your reply message"></textarea>
    </td>
</tr>

<tr>
    <td></td>
    <td>
        <input type="submit" name="submit" Value="Send Email" style="padding:8px 15px; background:#28a745; color:#fff; border:none; cursor:pointer;" />
    </td>
</tr>

</table>

<?php } } ?>

</form>
</div>
</div>
</div>

<!-- Load TinyMCE - আপনার প্রথম কোড থেকে নেওয়া -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
    });
</script>

<?php include 'inc/footer.php'; ?>