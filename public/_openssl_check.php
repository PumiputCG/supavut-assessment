<?php
echo "extension_loaded(openssl) = ";
var_dump(extension_loaded('openssl'));
echo "function_exists(openssl_cipher_iv_length) = ";
var_dump(function_exists('openssl_cipher_iv_length'));
