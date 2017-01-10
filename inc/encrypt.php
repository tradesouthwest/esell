<form method="POST" action="">
<p><input type="text" name="ccprod"></p>
<input type="submit" name="submit_ccprod" value="encrypt"></form>

<?php
if( isset( $_POST['submit_ccprod']))
{
require 'Encryption.class.php';

$key = "23c34eWrg56fSdrt"; // Encryption Key
$crypt = new Encryption($key);

$number = $_POST['ccprod']; // your credit card number

$encrypted_string = $crypt->encrypt($number); // Encrypt your credit card number

$decrypted_string = $crypt->decrypt($encrypted_string); // Decrypt your encrypted string.

// Show Results

echo "number: $number";
echo "<br><br>";
echo "encrypted_string: $encrypted_string";
echo "<br><br>";
echo "decrypted_string: $decrypted_string";
}
?>