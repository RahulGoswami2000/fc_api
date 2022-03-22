<?php

namespace App\Services;


use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class UtilityService
{
    public static function response($success, $msg, $data, $status = 200)
    {
        $responseArray = array('success' => $success, 'message' => $msg, 'responseData' => $data);
        Log::info("==Response==" . json_encode($responseArray));
        return response()->json($responseArray, $status);
    }

    public static function makeTimeStamp($prifix = null)
    {
        $t = microtime(true);
        $micro = sprintf("%'6d", ($t - floor($t)) * 1000000);
        return $prifix . date('YmdHis') . $micro;
    }
    public static function makeMicroTime($prifix = null)
    {
        $t = microtime(true);
        $micro = sprintf("%'6d", ($t - floor($t)) * 1000000);
        return $prifix . date('His') . '-' . $micro;
    }
    public static function RandomString($length = 2)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function sequelizeCharactor($char)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr($characters, strpos($characters, $char) + 1, 1);
    }

    public static function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function mailSend($subject, $html_message, $toEmail, $ccEmail = null, $ccBCC = null, $pdf_content = null, $attachment = 0, $attachmentName = "")
    {

        $mail = new PHPMailer(true);
        try {
            // Enable verbose debug output
            $mail->SMTPDebug = 0;
            // Set mailer to use SMTP
            $mail->isSMTP();
            // Specify main and backup SMTP servers
            $mail->Host = MAIL_HOST;
            // Enable SMTP authentication
            $mail->SMTPAuth = true;
            // SMTP username
            $mail->Username = MAIL_USERNAME;
            // SMTP password
            $mail->Password = MAIL_PASSWROD;
            // Enable TLS encryption, `ssl` also accepted
            $mail->SMTPSecure = 'tls';
            // TCP port to connect to
            $mail->Port = 587;
            //Recipients
            $mail->setFrom(MAIL_SENDER, MAIL_SENDER_NAME);
            $email = explode(',', $toEmail);
            for ($i = 0; $i < count($email); $i++) {
                $mail->addAddress($email[$i], '');     // Add a recipient
            }

            // Name is optional
            $mail->addReplyTo(MAIL_SENDER, MAIL_SENDER_NAME);
            if ($ccEmail != null) {
                $emailCC = explode(',', $ccEmail);
                for ($i = 0; $i < count($emailCC); $i++) {
                    $mail->addCC($emailCC[$i]);
                }
            }
            if ($ccBCC != null) {
                $emailBCC = explode(',', $ccBCC);
                for ($i = 0; $i < count($emailBCC); $i++) {
                    $mail->addBCC($emailBCC[$i]);
                }
            }
            if ($attachment == 0) {
                // Set email format to HTML
                $mail->isHTML(true);
                $mail->MsgHTML($html_message);
            } else {
                // Set email attachment
                if (is_array($pdf_content)) {
                    for ($i = 0; $i < count($pdf_content); $i++) {
                        $mail->addAttachment($pdf_content[$i], $attachmentName[$i]);
                    }
                } else {
                    // Optional name
                    $mail->addAttachment($pdf_content, $attachmentName);
                }
                // Set email format to HTML
                $mail->isHTML(true);
                $mail->MsgHTML($html_message);
            }
            // Set email format to HTML
            $mail->isHTML(true);
            $mail->Subject = $subject;

            return $mail->send();
        } catch (Exception $e) {
            Log::error("Mail Fail==" . $e->errorMessage());
            return 0;
        }
    }
}
