<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Mailer {
    
    private static string $HOST;
    private static string $USER;
    private static string $PASSWORD;
    private static int $PORT;
    private static bool $SMTP;
    private static bool $SMTP_AUTH;
    private static string $SMTP_SECURE;
    private static string $NAME;
    
    
    /**
     * @return void
     */
    public static function setServer(): void {
        
        // get the mail config
        $server = DataBase::load('website/mailer');
        
        // set the data
        self::$HOST = $server["host"];
        self::$USER = $server["user"];
        self::$PASSWORD = $server["password"];
        self::$PORT = $server["port"];
        self::$SMTP = $server["smtp"];
        self::$SMTP_AUTH = $server["smtp_auth"];
        self::$SMTP_SECURE = $server["smtp_secure"];
        self::$NAME = $server["name"];
        
    }
    
    
    /**
     * @return PHPMailer
     */
    private static function prepare(): PHPMailer {
        
        self::setServer();

        // 'true' enables exceptions
        $mail = new PHPMailer(true);
            
        // server settings
        $mail->Host = self::$HOST;
        $mail->Username = self::$USER;
        $mail->Password = self::$PASSWORD;
        $mail->Port = self::$PORT;
        if(self::$SMTP){
            $mail->isSMTP();  
            $mail->SMTPAuth = self::$SMTP_AUTH;
            $mail->SMTPSecure = self::$SMTP_SECURE;
        }
        $mail->setFrom(self::$USER, self::$NAME);

        return $mail;
        
    }
    
    
    /**
     * @param String $email
     * @param String $subject
     * @param String $message
     * @return void
     * @throws WebSiteException
     */
    public static function send(String $email, String $subject, String $message): void {
        try {
            
            // server settings
            $mail = self::prepare();

            // reciper
            $mail->addAddress($email);

            // content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->send();
            
        } catch (Exception $e) {
            throw new WebSiteException($e->getCode(), $e->getMessage(), "Mailer@send");
        }
    }
    
}
