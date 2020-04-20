<?php
$to      = 'mixdior@gmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    "Content-Type: text/plain; charset=\"UTF-8\"\r\n".
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);