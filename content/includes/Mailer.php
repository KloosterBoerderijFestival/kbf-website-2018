<?php

class Mailer
{
    private $from_name;
    private $mail_to;
    private $to_name;
    private $mail_subject;
    private $template;
    private $mail_details;
    private $from_mail;
    private $encoding;
    private $subject_preferences;

    function __construct($from_name, $from_mail, $mail_to, $to_name, $subject, $template, $mail_details)
    {
        $this->from_mail = $from_mail;
        $this->from_name = $from_name;
        $this->mail_to = $mail_to;
        $this->to_name = $to_name;
        $this->mail_subject = $subject;
        $this->mail_details = $mail_details;
        $this->template = $template;

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

        $message = $this->template;
        $message = str_replace(array("\r\n", "\r", "\n"), "<br />\r\n", $message);
        $message = str_replace('%naam%', $this->to_name, $message);
        $message = str_replace('%inschrijvingsdetails%', $this->mail_details, $message);
        mail($this->mail_to, $this->mail_subject, $message, $header);
    }
}

?>