<?php
if( isset( $_POST['submit_updates']))
{
include '../inc/controls.php';
$id        = $_POST['id'];
$prod      = $_POST['prod'];      //name
$short     = $_POST['short'];     //descript
$details   = $_POST['details'];   //textarea
$price     = $_POST['price'];     //price
$prod_ref  = $_POST['prod_ref'];  //sold per
$cat       = $_POST['cat'];       //cat
$prod_link = $_POST['prod_link']; //external link to prod
$qnty      = $_POST['qnty'];
$datein    = $_POST['datein'];
$prodstat  = $_POST['prodstat'];

$sql = "UPDATE esell_fields
SET `prod` = :prod, `short` = :short, `details` = :details, `price` = :price,
`prod_ref` = :prod_ref, `cat` = :cat, `prod_link` = :prod_link, `qnty` = :qnty,
`location` = :location, `datein` = :datein, `prodstat` = :prodstat
WHERE `id` = :id";

	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
        ':prod'      => $prod,
        ':short'     => $short,
        ':details'   => $details,
        ':price'     => $price,
        ':prod_ref'  => $prod_ref,
        ':cat'       => $cat,
        ':prod_link' => $prod_link,
        ':qnty'      => $qnty,
        ':location'  => $location,
        ':datein'    => $datein,
        ':prodstat'  => $prodstat,
        ':id'        => $id
        ));
		if( $stmt !==false){
            $msge = "Updated Successful"; }
            else { $msge = "Updating Failed"; }
                redirect("stockitems.php?msge={$msge}");
}
?>