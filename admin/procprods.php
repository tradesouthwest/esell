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
<style>.list-group-item span{color: green; font-size: 1.5em;}</style>
<script>
function printDiv(printInvoice) {
     var printContents = document.getElementById(printInvoice).innerHTML;
     var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents; }
</script>

</head>
<body>
<?php
include 'adminmenutop.php';
include 'adminnavtop.php';
?>

        <div class="container">
            <div class="row">
                <article class="col-lg-12 col-xs-12">
                    <header>
                        <h3>Order Summary - Ready to Ship</h3>
                    </header>

                    <section class="col-lg-6 col-xs-12">

<?php
/**
 * prodcode=id of prod,
 * proddate=cartdate,
 * paidon= paid date,
 * deliver= is/isnot(if-is= date),
 * sale_id=session from cart,
 * mem_id= shortcut to member (not memid),
 * persdata== ccproc,
 * stats= status (hold, reorder....),
 * esellopt= last basket id
 */

if( isset( $_POST['submit_procid']))
{
    $procid = $_POST['procid'];
}
    elseif (isset( $_GET['procid']))
    { ?>
    <script>
    $(document).ready(function(){
        if(document.URL.indexOf("#")==-1)
        {
        // Set the URL to what it was plus "#".
        url = document.URL+"#";
        location = "#";
        location.reload(true);
        }
    });
    </script>
    <?php
    $procid = $_GET['procid'];
    }
        else
        {
        $procid = '';
        }

if( !empty( $procid ))
{
    $sql = "SELECT * FROM esell_sold WHERE id = ?";
	$q = $pdo->prepare($sql);
    $q->execute(array($procid));
	$data = $q->fetch(PDO::FETCH_ASSOC);

    $id             = $data['id'];
    $country        = $data['country'];
    $first_name     = $data['first_name'];
    $last_name      = $data['last_name'];
    $address        = $data['address'];
    $city           = $data['city'];
    $state          = $data['state'];
    $zip_code       = $data['zip_code'];
    $phone_number   = $data['phone_number'];
    $email_address  = $data['email_address'];

    $countryb       = $data['countryb'];
    $first_nameb    = $data['first_nameb'];
    $last_nameb     = $data['last_nameb'];
    $addressb       = $data['addressb'];
    $cityb          = $data['cityb'];
    $stateb         = $data['stateb'];
    $zip_codeb      = $data['zip_codeb'];
    $phone_numberb  = $data['phone_numberb'];
    $email_addressb = $data['email_addressb'];

    $prodcode      = $data['prodcode'];    //id of product
    $proddate     = $data['proddate'];    //basket date
    $paidon      = $data['paidon'];      //pay date
    $deliver    = $data['deliver'];     //is delivered
    $sale_id   = $data['sale_id'];     //sale id
    $mem_id   = $data['mem_id'];      //member id
    $persdata = $data['persdata'];   //ccdata
    $stats    = $data['stats'];     // update this table stats
    $esellopt = $data['esellopt']; // basket id

}

/**
 * Here is where the magic begins
 * 1. Create stock order
 * 2. Update esell_sold table `stat`=2 (processed)
 * or Hold for pickup or ship `stat`=3 (shipped)
 * 3. Build invoice from esell_sold table/send to customer
 * 4. Internal processes (notify vendor if necsry, update stock)
 */
?>

<div id="printInvoice">
<table class="table table-condensed table-invoice">
<thead><tr><th colspan="3">Invoice No.: <?php $sale = substr( $sale_id, 0, 10 ); print($sale); ?></th>
<th colspan="3">Invoice Date: <?php echo date('m-d-Y'); ?></tr></thead>
<tbody>
<tr>
<td colspan="3">
    <p><?php print($site_title); ?></p>
    <p><?php print($warehouse); ?></p></td>
<td colspan="3">
    <p><?php esc($country); ?></p>
    <p><?php print($first_name); ?> <?php print($last_name); ?></p>
    <p><?php print($address); ?></p>
    <p><?php print($city); ?>, <?php print($state); ?> <?php print($zip_code); ?></p>
    <p>Phn: <?php print($phone_number); ?></p>
    <p>Email: <?php esc( $email_address ); ?></p></td>
</tr>
<tr><td colspan=6><?php $ids = array_filter(explode(', ', $data["prodcode"]));
echo implode(' ', $ids); ?></td>
</tbody>
<thead><tr><th>Product</th><th>Prod#</th><th>Qnty</th><th colspan=2>Option</th><th>Price</th></tr></thead>
<tbody>
<?php

    // 1.
    // @val $keeps= 0 is purchased (not in basket any more)
    $sql = $pdo->query(" SELECT id, prod, price, prodid, prod_ref, qnty
                         FROM esell_basket
                         WHERE sale_id = '" . $sale_id . "'
                         AND keeps = 0 ");
	if( $sql->rowCount() > 0)
    {
        while($data = $sql->fetch(PDO::FETCH_ASSOC))
        {
            esc('<tr>
            <td>' . $data['prod'] . '</td>
            <td>' . $data['id'] . '' . $data['prodid'] . '</td>
            <td>' . $data['qnty'] . '</td>
            <td colspan=2>' . $data['prod_ref'] . '</td>
            <td>$'); $prodtltb = $data['price']; $prodtltb = number_format($prodtltb, 2, '.', '');
        esc( $prodtltb ); $tlts += $prodtltb; esc('</td></tr>');
        }
        //Ends while-loop, now add up total purchase.
        print '<tr><td><b>Total</b>';
        $totals = number_format($tlts, 2, '.', '');
        print '</td><td colspan=4><input type="hidden" name="purchtotal" value ="' . $totals . '"></td>';
        print '<td>$' . $totals . '</td></tr>';
    }
?>

</tbody>
<tfoot><tr><td colspan="6"><a href="http://ups.com" title="shipping - opens in new window" target="_blank">Track Shipping Here</a></td></tr></tfoot>
</table>

</div>

            </section>




            <section class="col-lg-6 col-xs-12">

<?php if( isset( $_GET['msge'])){ ?><p class="alert alert-info"><?php print ($_GET['msge']); ?></p><?php } ?>
<?php if( isset( $_GET['msgp'])){ ?><p class="alert alert-info"><?php print ($_GET['msgp']); ?></p><?php } ?>

                <h4>Instructions</h4>
                <ul class="list-group">
                    <li class="list-group-item"><span>1. </span><p>Print Invoice for Records or as Shipping Label<br><button onclick="printDiv('printInvoice');" class="btn btn-primary btn-xs">Print Invoice for Records</button></p></li>

                    <li class="list-group-item"><span>2. </span><p>Update Sale as Processed and <u>Stock Count</u>

<?php
    /**
     *
     *
     *
     */

            $prdsprice = prodPrice($prodcode);
            $prdsleft = prodQnty($prodcode); esc($prdsleft); ?> Left.

                <form action="edit-misc.php" method="POST">
                    <input type="hidden" name="bskqnty" value="<?php esc($bskqnty); ?>">
                    <input type="hidden" name="prodqnty" value="<?php esc($prodqnty); ?>">
                    <input type="hidden" name="sale_id" value="<?php print($prodcode); ?>">
                    <input type="submit" name="submit_preproc"
                        value="Update <?php print($prodcode); ?>" class="btn btn-primary btn-xs">
                </form></p></li>

                    <li class="list-group-item"><span>3. </span><small>Shipping information can be add with module</small></li>

                    <li class="list-group-item"><span>4. </span>Send Invoice Using Email   ----- &darr;</li>
                </ul>

<form action="emailinvoice.php" method="POST">
<input type="hidden" name="site_title" value="<?php esc($site_title); ?>">
<input type="hidden" name="warehouse" value="<?php esc($warehouse); ?>">

<input type="hidden" name="country" value="<?php esc($country); ?> ">
<input type="hidden" name="first_name" value="<?php esc($first_name); ?> ">
<input type="hidden" name="first_name" value="<?php esc($last_name); ?>">
<input type="hidden" name="address" value="<?php esc($address); ?>">
<input type="hidden" name="city" value="<?php esc($city); ?>">
<input type="hidden" name="state" value="<?php esc($state); ?> ">
<input type="hidden" name="zip_code" value="<?php esc($zip_code); ?>">
<input type="hidden" name="phone_number" value="<?php esc($phone_number); ?>">

<input type="hidden" name="countryb" value="<?php esc($countryb); ?> ">
<input type="hidden" name="first_nameb" value="<?php esc($first_nameb); ?> ">
<input type="hidden" name="first_nameb" value="<?php esc($last_nameb); ?>">
<input type="hidden" name="addressb" value="<?php esc($addressb); ?>">
<input type="hidden" name="email_addressb" value="<?php esc($email_addressb); ?>">
<input type="hidden" name="cityb" value="<?php esc($cityb); ?>">
<input type="hidden" name="stateb" value="<?php esc($stateb); ?> ">
<input type="hidden" name="zip_codeb" value="<?php esc($zip_codeb); ?>">
<input type="hidden" name="phone_numberb" value="<?php esc($phone_numberb); ?>">

<input type="hidden" name="prod" value="<?php esc($prod); ?>">
<input type="hidden" name="prdsprice" value="<?php esc($prdsprice); ?>">
<input type="hidden" name="prod_ref" value="<?php esc($prod_ref); ?> ">
<input type="hidden" name="feature" value="<?php esc($feature); ?>">
<input type="hidden" name="bskprice" value="<?php esc($bskprice); ?>">
<input type="hidden" name="bskqnty" value="<?php esc($bskqnty); ?>">
<input type="hidden" name="email_address" value="<?php esc($email_address); ?>">
<input type="hidden" name="proddate" value="<?php esc($proddate); ?> ">
<input type="hidden" name="sale_id" value="<?php esc($sale_id); ?>">
<input type="hidden" name="message" value="<?php esc($message); ?>">
<input type="hidden" name="procid" value="<?php esc($procid); ?>">

<input type="hidden" name="esellopt" value="<?php esc($esellopt); ?>">
<input type="hidden" name="stknumb" value="<?php esc($stknumb); ?>">
<input type="hidden" name="prodcode" value="<?php print($prodcode); ?>">
<!--<input type="hidden" name="purchtotal" value="<?php print($purchtotal); ?>">-->

<p><input type="text" name="email_address" value="<?php esc($email_address); ?>">
<input type="submit" name="submit_tomail" value="Email Invoice"> <?php esc($procid); ?></p>
</form>

<hr>





                </section>
            </article>





            </div>
        </div>
<?php
include('adminfooter.php'); ?>