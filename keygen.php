<html>
<body>

<?php
    function randomKey($length) {
    $pool = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));

    for($i=0; $i < $length; $i++) {
        $key .= $pool[mt_rand(0, count($pool) - 1)];
    }
    return $key;
}

?>

<hr>

<?php
if( isset($_POST['submit'])){
$k = $_POST['keygen'];
        $rndm = randomKey($k);
        $sessdate = date('mdHi');
        $escooktmpname = $rndm.''.$sessdate;


echo "<p>&nbsp;</p>";
echo $escooktmpname;
}
?>


<form action ="" method="post">
<input type="text" name="keygen"><input type="submit" name="submit" value="submit"></form>

</body>
</html>