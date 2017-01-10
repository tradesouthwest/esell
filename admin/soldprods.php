<?php
session_start();
if (!isset($_SESSION['eselluser_session']))
{
header('Location: ../login.php');
}

include 'adminheader.php';
$pageis = "finance";
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
                <article class="col-lg-6 col-xs-12">
                    <header>
                        <h4>Order Requests but Not Yet Purchased</h4>

<?php
if (isset( $_POST['submit_rmvbsk']))
{
    $id = $_POST['rmvid'];

    // Delete data in mysql from row that has this id
    $stmt = $pdo->prepare("DELETE FROM esell_basket WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $deleted = $stmt->execute();

    // if successfully deleted
    if($deleted){
    echo "<p class=\"alert alert-danger\">Deleted Successfully</p>";
    echo "<p><a class=\"btn btn-link\" href=\"index.php\">Return to Control Panel</a> | ";
    echo "<a class=\"btn btn-link\" href=\"soldprods.php\">Clear Message - Refresh This Page</a></p>";
    }

    else {
        print("could not remove item");
    }
// close connection
//$pdo = null;
}
?>

                    </header>
                <table class="table table-condensed"><thead>
                    <tr><th>Date Saved</th><th>$Amt</th><th>Qnty</th><th>Prod/All-Custmr</th><th>Id / [archv]</th></tr></thead>
                <tbody>

<?php
/**
 * @id= `esell_basket` table index
 * @sale_id= should match custs other prods
 * @proddate= basket date
 * @memid= user_id
 * @prod= prod name
 * @prod_ref= sold as
 * @price= this basket
 * @prodid= is_prod
 * @qnty= this prod only
 * @keeps= 0= sold 1=in basket 2=archive
 */
$sql = $pdo->query("SELECT * FROM esell_basket ORDER BY `proddate` ASC LIMIT 250");
if( $sql->rowCount() > 0)
{
	while($data = $sql->fetch(PDO::FETCH_ASSOC))
    {
?>

<tr>
<td><small><? echo $data['proddate']; ?></small></td>

    <td><? echo frmPrc( $data['price'] ); ?></td>

        <td><?php esc( $data['qnty'] ); ?></td>

            <td><p><form action="" method="POST">
                <input type="hidden" name="bskid" value="<?php print($data['id']); ?>">
                <input type="submit" name="submit_bskid" value="<?php esc( $data['id'] ); ?>">
                <input type="hidden" name="sale_id" value="<?php print($data['sale_id']); ?>">
                <input type="submit" name="submit_salesid" value="[+]"></form></p></td>

                <td><form action="" method="POST"><p><?php esc( $data['id'] ); ?>
                    <input type="hidden" name="rmvid" value="<? echo $data['id']; ?>">
                    <input type="submit" name="submit_rmvbsk" value="[ - ]" class="btn btn-danger btn-xs"></p></form></td>
</tr>

<?php
    }
}
    else { esc("<tr><td colspan=5><p class=\"alert alert-info\">There are no products pending at this time.</p></td></tr>"); }
?>

</tbody>
<tfoot><tr><td colspan="5"><a href="#" title="top">Top of Page</a></td></tr></tfoot>
</table>

<hr>



            </article>

            <article class="col-lg-6 col-xs-12">

                <header>
                    <h4>Completed Orders - Sold Products Listing</h4>
                </header>
                <table class="table table-condensed"><thead>
                <tr><th>Purchased</th><th>Product Id(s)</th><th>Total Sale</th><th>Id/Process</th><th>[-]</th></tr></thead>
                <tbody>

<?php
/**
 * paidon= paid date,
 * deliver= is/isnot(if-is= date),
 * sale_id=session from cart,
 * memid= shortcut to member,
 * purchtotal= price,
 * stat= status (0=sold 2=proc 3=deliver),
 * esellopt= last basket id
 */
    $sql = $pdo->query("SELECT id, prodcode, persdata, paidon
                        FROM esell_sold");
    if( $sql->rowCount() > 0)
    {
	   while($data = $sql->fetch(PDO::FETCH_ASSOC))
        {
?>

<tr>
<td><small><?php esc( $data['paidon'] ); ?></small></td>

    <td><small><?php
                    $ids = array_filter(explode(', ', $data["prodcode"]));
                    echo implode(', ', $ids); ?></small></td>

        <td>$<?php esc($data['persdata']); ?></td>

            <td><form action="procprods.php" method="POST"><p><?php esc( $data['id'] ); ?>
            <input type="hidden" name="procid" value="<?php esc( $data['id'] ); ?>">
            <input type="submit" name="submit_procid" value="[ proccess ]"
                            class="btn btn-success btn-xs"></p></form></td>

                <td><form action="edit-misc.php" method="POST">
                <p><small><?php esc( $data['id'] ); ?></small>
                <input type="hidden" name="soldid" value="<?php esc( $data['id'] ); ?>">
                <input type="submit" name="submit_rmvsold" value="[-]" class="btn btn-link btn-xs" title="consider archiving instead of deleting"></p></form></td>
</tr>

<?php
    }
}
    else { esc("<tr><td colspan=5><p class=\"alert alert-info\">There are no products sold at this time.</p></td></tr>"); }
?>

                </tbody>
                <tfoot><tr><td colspan="5"><a href="#" title="top">Top of Page</a></td></tr></tfoot>
                </table>
                    <hr>

            </article>




<?php
if (isset( $_POST['submit_bskid']))
{
$bskid = $_POST['bskid'];

    $sql = "SELECT * FROM esell_basket where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($bskid));
		$data = $q->fetch(PDO::FETCH_ASSOC);
    $id       = $data['id'];
	$prod     = $data['prod'];
    $prodid   = $data['prodid'];
    $qnty     = $data['qnty'];
    $price    = $data['price'];
    $sale_id  = $data['sale_id'];

echo "<script>
         $(window).load(function(){
             $('#baskModal').modal('show');
         });
    </script>";
?>

            <div class="modal fade" id="baskModal" tabindex="-1" role="dialog" aria-labelledby="baskModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                    <h4 class="modal-title" id="baskModalLabel">Prod Id: <?php esc( $prodid ); ?></h4>
                  </div>
                  <div class="modal-body">

<ul>
<li>Product  <?php esc( $prod ); ?></li>
<li>        $<?php esc( $price ); ?></li>
<li>Stock:   <?php esc( $qnty ); ?></li>
<li>Bsk Id:  <?php esc( $id ); ?></li>
<li>Cust     <?php esc( $sale_id ); ?></li>
</ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
<?php
}
?>



<!-- modal separator -->



<?php
if( isset( $_POST['submit_salesid'] ))
{

    echo "<script>
         $(window).load(function(){
             $('#potnModal').modal('show');
         });
    </script>";
?>

            <div class="modal fade" id="potnModal" tabindex="-1" role="dialog" aria-labelledby="potnModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                    <h4 class="modal-title" id="potnModalLabel">All items not sold yet for this customer</h4>
                  </div>
                  <div class="modal-body">

                    <?php

?>

<table>
<thead><tr><th>More Data on Non-Purchased Items By Potential Customer</th></tr></thead>
<tbody>

<?php
    $sale_id = $_POST['sale_id'];
    //loop for all products in basket table $proddate= empty is sold!
    $sql = (" SELECT * FROM esell_basket WHERE `sale_id` = :sale_id ");

	$q = $pdo->prepare($sql);
	$q->execute(array(':sale_id' => $sale_id));
        while($data = $q->fetch(PDO::FETCH_ASSOC))
        {
?>

<tr><td><?php esc($data['prod']); ?> | <?php esc($data['proddate']); ?></td></tr>

<?php
        }
?>

</tbody>
<tfoot><tr><td><a href="#" title="Top of Page">Top of Page</a></td></tr></tfoot>
</table>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
<?php
}
?>

    <!-- create centered modal on any device -->
    <script>
    function centerModal() {
        $(this).css('display', 'block');
            var $dialog = $(this).find(".modal-dialog");
            var offset = ($(window).height() - $dialog.height()) / 2;
            // Center modal vertically in window
            $dialog.css("margin-top", offset);
    }
        $('.modal').on('show.bs.modal', centerModal);
        $(window).on("resize", function () {
            $('.modal:visible').each(centerModal);
    });
    </script>
            </div>
        </div>
<?php
include('adminfooter.php'); ?>