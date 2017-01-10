<?php
session_start();
if (!isset($_SESSION['eselluser_session']))
{
header('Location: ../login.php');
}

include 'adminheader.php';
$pageis = "main";
?>

    <title>eSell TSW eCommerce</title>
    <meta name="description" content="restricted">
    <meta name="robots" content="nofollow" />

</head>
<body>
<?php
include 'adminmenutop.php';
include 'adminnavtop.php';
?>

        <div class="container">
            <div class="row">
                <article class="col-lg-12 col-xs-12" style="min-height:539px;">
<header>
<h4>Miscellaneous Form Requests</h4>
</header>

<?php
//updates sale as proccessed and stock count
if( isset( $_POST['submit_preproc']))
{
// @val 2= item processed, not(shipped/not-shipped)
$nstat = 2;

        $sql = "UPDATE esell_sold SET `stats` = :stats
        WHERE `id` = :id ";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
        ':stats' => $nstat,
        ':id'  => $prodcode
        ));

        if( $stmt !==false) {
            $msgp = "Updated_Stock_Successful"; }
            else { $msgp = "Updating_Failed"; }
                redirect("procprods.php?procid={$prodcode}&msgp={$msgp}");
}
?>

<?php
if (isset( $_POST['submit_rmvsold']))
{
$id = $_POST['soldid'];

// Delete data in mysql from row that has this id
$stmt = $pdo->prepare("DELETE FROM esell_sold WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$deleted = $stmt->execute();

// if successfully deleted
if($deleted){
echo "<p class=\"alert alert-danger\">Deleted Successfully (Please considering Archiving next time.)</p>";
echo "<p><a class=\"btn btn-link\" href=\"index.php\">Return to Control Panel</a> | ";
echo "<a class=\"btn btn-link\" href=\"soldprods.php\">Back to Sold Products Page</a></p>";
}

else {
print("could not remove item");
}
// close connection
//$pdo = null;
}
?>
        </article>
    </div>
</div>
<?php include('adminfooter.php'); ?>