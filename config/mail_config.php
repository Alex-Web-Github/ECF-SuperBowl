<?php
return [
  'host' => 'smtp.example.com',
  'SMTPAuth' => true,
  // 'SMTPSecure' => 'tls', // 'ssl' for `PHPMailer::ENCRYPTION_SMTPS`
  'SMPTDebug' => 0, // 2 for verbose debug output
  'port' => 587,
  'username' => 'your_username',
  'password' => 'your_password',
  'encryption' => 'tls',
  // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
];
