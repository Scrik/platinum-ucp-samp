<?php

/*
 * Platinum UCP SAMP by brebvix
 */

class Mail {

    public function send($to, $title, $text) {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";

        $headers .= "From: UserControlPanel\r\n";
        return mail($to, $title, $text, $headers);
    }

}
