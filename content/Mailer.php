<?php

class Mailer
{
    private $from_name;
    private $mail_to;
    private $mail_subject;
    private $mail_message;
    private $from_mail;
    private $encoding;
    private $subject_preferences;

    function __construct($from_name, $from_mail, $mail_to, $subject, $mail_message)
    {
        $this->from_mail = $from_mail;
        $this->from_name = $from_name;
        $this->mail_to = $mail_to;
        $this->mail_subject = $subject;
        $this->mail_message = $mail_message;

        $this->encoding = "utf-8";
        $this->subject_preferences = array(
            "input-charset" => $this->encoding,
            "output-charset" => $this->encoding,
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );
    }

    function createHeader()
    {
        $header = "Content-type: text/html; charset=" . $this->encoding . " \r\n";
        $header .= "From: " . $this->from_name . " <" . $this->from_mail . "> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: " . date("r (T)") . " \r\n";
        $header .= iconv_mime_encode("Subject", $this->mail_subject, $this->subject_preferences);
        return $header;
    }

    function send()
    {
        $header = $this->createHeader();
        mail($this->mail_to, $this->mail_subject, $this->mail_message, $header);
    }
}

?>