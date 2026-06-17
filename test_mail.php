<?php
$fp = @fsockopen('127.0.0.1', 1025, $err, $errs, 2);
echo $fp ? "SMTP 127.0.0.1:1025 pieejams!\n" : "Nav pieejams: $errs\n";

$fp2 = @fsockopen('localhost', 1025, $err, $errs, 2);
echo $fp2 ? "SMTP localhost:1025 pieejams!\n" : "localhost nav pieejams: $errs\n";
