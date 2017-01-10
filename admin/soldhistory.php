<?php
include 'adminheader.php';
$pageis = "catalog";
?>
<script type="text/javascript">
$(document).ready(function(){
if(document.URL.indexOf("#")==-1)
{
// Set the URL to whatever it was plus "#".
url = document.URL+"#";
location = "#";
location.reload(true);
}
});
</script>
<title>eSell TSW eCommerce</title>

<meta name="description" content="restricted">
<style>table.squished td { border-bottom: thin solid #ddd; border-right: thin solid #ddd; padding: 1px;}
table.squished td.uno { background: #aff;} .bgy{background-image: none; background: #fafaaa;}
</style>
</head>
<body>
<?php
include 'adminmenutop.php';
include 'adminnavtop.php';
?>




        <div class="container">
            <div class="row">
                <article class="col-lg-10 col-xs-12">
                    <table class="squished">

<?php
$stmt = $pdo->query("SELECT * FROM esell_sold");
foreach ($stmt as $data)
{
?>
    <tr>

    <td class="uno" title="database id"><?php esc( $data['id'] ); ?></td>
    <td title="company name">          <?php esc( $data['country'] ); ?></td>
    <td>                              <?php esc( $data['first_name'] ); ?></td>
    <td>                             <?php esc( $data['last_name'] ); ?></td>
    <td title="address">            <?php esc( $data['address'] ); ?></td>
    <td>                 <?php esc( $data['city'] ); ?></td>
    <td>                <?php esc( $data['state'] ); ?></td>
    <td>               <?php esc( $data['zip_code'] ); ?></td>
    <td title="phone"><?php esc( $data['phone_number'] ); ?></td>
    <td><a href="mailto:<?php esc( $data['email_address'] ); ?>"
      title="email"><?php esc( $data['email_address'] ); ?></a></td>

</tr><tr>
    <td title="billing info"></td><td><?php esc( $data['countryb'] ); ?></td>
    <td><?php esc( $data['first_nameb'] ); ?></td>
    <td><?php esc( $data['last_nameb'] ); ?></td>
    <td><?php esc( $data['addressb'] ); ?></td>
    <td><?php esc( $data['cityb'] ); ?></td>
    <td><?php esc( $data['stateb'] ); ?></td>
    <td><?php esc( $data['zip_codeb'] ); ?></td>
    <td><?php esc( $data['phone_numberb'] ); ?></td>
    <td><?php esc( $data['email_addressb'] ); ?></td>
</tr><tr>
    <td title="all prods"><?php $ids = array_filter(explode(', ', $data["prodcode"]));
echo implode(', ', $ids); ?></td>
    <td title="bsk date">      <?php esc( $data['proddate'] ); ?></td>
    <td title="paid on">       <?php esc( $data['paidon'] ); ?></td>
    <td title="delivered">     <?php esc( $data['deliver'] ); ?></td>
    <td title="sale_id">       <?php esc( $data['sale_id'] ); ?></td>
    <td title="mem_id">        <?php esc( $data['mem_id'] ); ?></td>
    <td title="total">         <?php esc( $data['persdata'] ); ?></td>
    <td title="stats">         <?php esc( $data['stats'] ); ?></td>
    <td><form action="" method="POST">
            <input type="hidden" name="basket" value="<?php esc($bsk_id); ?>">
            <input type="submit" name="submitbsk" value="<?php esc( $bsk_id ); ?>"
                class="btn btn-xs btn-link" title="basket view">
        </form></td>
    <td>$<?php esc( totalSale($data['id']) ); ?></td></tr>
<?php
}
?>
</table>
<hr>

<?php
            if(isset( $_POST['submitbsk'] ))
            { $id = $_POST['basket'];
echo "<script>
         $(window).load(function(){
             $('#basketModal').modal('show');
         });
    </script>";

            }
?>
<div class="modal fade" id="basketModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h5 class="modal-title" id="basketModalLabel">Success!</h5>
      </div>
      <div class="modal-body">
<?php
    $sql = "SELECT * FROM esell_basket where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);

	$prod     = $data['prod'];
    $bskqnty  = $data['qnty'];
    $price    = $data['price'];
    $sale_id  = $data['sale_id'];
?>

<ul>
<li>Product: <?php esc( $prod ); ?></li>
<li>$<?php        esc( $price ); ?></li>
<li>Qnty: <?php  esc( $bskqnty ); ?></li>
<li>Id: <?php   esc( $id ); ?></li>
<li>Cust <?php esc( $sale_id ); ?></li>
</ul>
<p><a class="btn btn-success" href="soldhistory.php">Validate and Return to Page</a></p>
<p><a class="btn btn-link" href="index.php">Back to Store Manager</a></p>
</div>

    </div>
  </div>
</div>
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
        </article>
    <div class="col-lg-2 col-xs-12">
        <h4>View basket by id number</h4>

        <form action="" method="post" class="form-horizontal">
            <div class="form-group">
                <input type="text" name="bskids" value="" class="form-control bgy">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="get basket" class="btn btn-primary">
            </div>
        </form>
        <p>&nbsp;</p>
        <table class="table table-condensed">
            <tbody><tr><td>&nbsp;</td></tr>
<?php
if(isset($_POST['submit']))
{
    $pdo = Database::connect();
    $bskid = $_POST['bskids'];
    $sql = $pdo->query("SELECT * FROM esell_basket
                        WHERE `id` = '" . $bskid . "'");
        foreach ( $sql as $data ) {
            $id  = $data['id'];
            $prodid  = $data['prodid'];
            $keeps  = $data['keeps'];
            $prod  = $data['prod'];
            $price  = $data['price'];
            $sale_id = $data['sale_id'];
            $proddate  = $data['proddate'];
            $memid  = $data['memid'];
            $prod_ref  = $data['prod_ref'];
            $qnty = $data['qnty'];
        }
?>

            <tr><td><?php esc('id ' . $id . '</td></tr><tr><td>prdid ' . $prodid . '</td></tr>
<tr><td>kps ' . $keeps . '</td></tr><tr><td>' . $prod . '</td></tr><tr><td>$' . frmPrc($price) . '</td></tr>
<tr><td>sale id ' . $sale_id . '</td></tr><tr><td>dt ' . $proddate . '</td></tr>
<tr><td>qnty ' . $qnty); ?><hr></td></tr>

<?php
}
?>
            </tbody>
        </table>

            </div>
        </div>
<?php include('adminfooter.php'); ?>