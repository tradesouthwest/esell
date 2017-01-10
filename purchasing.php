<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

    //create expire time for session 3600= 1hr.
    $estimeout = 7200;
    if(isset($_SESSION['estimeout']))
    {
        $duration = time() - (int)$_SESSION['estimeout'];
        if($duration > $estimeout) {
            // Destroy the session and restart it.
            session_destroy();
            session_start();
        }
    }

    // Update the timeout field with the current time.
    $_SESSION['estimeout'] = time();

       //add pseudo cookie to sale_id
        function randomKey($length)
        {
        $pool = array_merge(range(0,9), range('A', 'Z'));
            for($i=0; $i < $length; $i++) {
                $key .= $pool[mt_rand(0, count($pool) - 1)];
            }
        return $key;
        }
//html starts here
include 'header.php';
?>

    <title>eSell eCommerce | Purchasing</title>
    <meta name="description" content="restricted">
    <meta name="robots" content="nofollow">
<style> ul.list-prod { list-style: none;position: relative; padding: 0; margin: 0; }
.list-prod > li span { border-bottom: 1px solid #ddd; display: inline-block; min-width: 200px; padding: 4px;}
checkbox {font-size: 21px;}
</style>

</head>
<body>

<?php
include 'menutop.php';
?>

<div class="container">
    <div class="row">

        <header class="page-head">
        <div class="col-xs-9">
        <h1>eSell TSW eCommerce MarketPlace</h1>

        </div>
        <figure class="col-xs-3 pull-right">
            <a href="index.php" title="esell by TSW"><img id="homelogo" src="favicon.png" alt="logo"
                class="img-responsive thumbnail" /></a>
        </figure>
        </header>

    </div>
</div>

<?php
/* `id, `prod`, `price`, `prod_ref`, `howmany`, `feature`
 * @uses submit_tobasket from product.pg
 */

if( isset( $_POST['submit_tobasket']))
{

?>

<div class="container bgj">
    <div class="row">


    <article class="col-lg-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>Ready for Purchasing Information</h4></div>
            <div class="panel-body">


<?php

    // clear vals
    $feature  = ''; $howmany  = ''; $memid = ''; $prdqnty  = ''; $price = ''; $prodtlt  = '';
    $prod = ''; $prod_ref = '';  $prod_id = ''; $qntyleft = ''; $sale_id = ''; $taxed = '';

    $price    = filter_input(INPUT_POST, 'price',     FILTER_SANITIZE_NUMBER_INT );
    $prod_id  = filter_input(INPUT_POST, 'prod_id',   FILTER_SANITIZE_NUMBER_INT );  //id of product
    $howmany  = filter_input(INPUT_POST, 'howmany',   FILTER_SANITIZE_STRING );     //customer quantity
    $prod     = filter_input(INPUT_POST, 'prod',      FILTER_SANITIZE_STRING );    //prod name
    $prod_ref = filter_input(INPUT_POST, 'prod_ref',  FILTER_SANITIZE_STRING );   //sold per
    $feature  = filter_input(INPUT_POST, 'feature',   FILTER_SANITIZE_STRING );  //options
    $prod_ref = filter_input(INPUT_POST, 'prod_link', FILTER_SANITIZE_STRING ); //extrnl url
    $taxed    = isset( $_POST['taxed'] )&& $_POST['taxed']  ? "1" : "0";       //checked= prod is NOT taxed

    /**
     * first query is to get stock level and tax rate
     * of item selected
     */
    $prdqnty = prodQnty($prod_id);
    $qntyleft = $prdqnty - $howmany;

    // if not out of stock= go
    if( $qntyleft > 0 )
    {

        //calc sub total
        $prodprice = prodPrice($prod_id);
        $subtlt = $prodprice * $howmany;

        // establish if taxed, exempt= 1(checked)
        if( $taxed  == 0 )
        {
            $taxvalue = $tax_rate * .01;
            $tax_value = $subtlt * $taxvalue;
        } else {
                   $tax_value = 0;
               }

        //format purchase total
        $prodtlt = $subtlt + $tax_value;
        $prodtlt = frmPrc($prodtlt);


            /**
             * Creating session for basket of users which
             * do not have a login account.
             *
             * @string $esecooktmpname= random caps + numbers + part' date
             *
             * @string $duration= subtract set time from start time
             * @uses $estimeout= number of seconds. (in head)
             */
            if(!isset($_SESSION["escooktmpname"]))
            {
                $rndm          = randomKey(5);
                $sessdate      = date('mdHi');
                $escooktmpname = $rndm.''.$sessdate;

                // setting temp session for non member
                $_SESSION["escooktmpname"] = $escooktmpname;
            }

            //customer id (tmpcookie or user_id) to pass to purchase
            $sale_id = $_SESSION["escooktmpname"];

                if( isset( $_SESSION['eselluser_session']))
                {
                    $memid = $_SESSION['user_id'];
                }

            /**
             * @id= `esell_basket` row index
             * @sale_id= should match custs other prods
             * @proddate= now
             * @memid= cookie
             * @prod= prod name
             * @prod_ref= sold as
             * @price= this purch total
             * @prodid= is_product id
             * @qnty= this purch only ($howmany)
             * ******************************
             * This section only processes the current item that is being bought.
             * Once this item is added to basket - all other items in basket are
             * added to the checkout page (myaccount.pg).
             */


            $proddate = $date_entered;         //now
            //add to cart table
            $query = ("INSERT INTO esell_basket
                ( sale_id, proddate, memid, prod, prod_ref, price, prodid, qnty )
                VALUES
                ( :sale_id, :proddate, :memid, :prod, :prod_ref, :price, :prodid, :qnty )");

                $stmt = $pdo->prepare($query);

                $q = array(
                "sale_id"      => $sale_id,       //cust id
                "proddate"    => $proddate,      //now
                "memid"      => $memid,         //user cookie
                "prod_ref"  => $prod_ref,      //sold by
                "prod"     => $prod,          //have to display name
                "price"   => $prodtlt . '_' . $taxvalue,       //total
                "prodid" => $prod_id,       //prod id
                "qnty"  => $howmany,       //number of
                );

                $inserted = $stmt->execute($q);
                $last_id = $pdo->lastInsertId(); //new basket identifier
                if($inserted)
                {
?>

            <h4>You have selected the following: </h4>
            <ul class="list-prod">
            <li><h4>                             <?php esc( $prod ); ?></h4></li>
            <li>                                $<?php esc( $prodprice . ' ' . $prod_ref ); ?></li>
            <?php if( isset( $_SESSION['user_id'] )) { ?>
            <li><span>Customer Id:</span>         <?php esc( $memid ); ?></li>
            <?php } ?>
            <li><span>Sale Id: </span>            <?php esc( $sale_id ); ?></li>
            <li><span>Quantity: </span>           <?php esc( $howmany ); ?></li>
            <li><span>Purchase Nmbr.: </span>     <?php print( $_SESSION["escooktmpname"] ); ?></li>
            <li><span>Product Id: </span>         <?php esc( $prod_id ); ?></li>
            <li><span>Sub Total: </span>         $<?php esc( frmPrc($subtlt) ); ?></li>
            <li><span>Tax: </span>               $<?php esc( frmPrc($tax_value) . ' rate ' . $tax_rate); ?></li>
            <li><span>Total: </span>             $<?php esc( $prodtlt ); ?></li>
            </ul>

            <form name="purchasenow" action="purchasing.php" method="POST">
                <input type="hidden" name="sale_id" value="<?php esc( $sale_id ); ?>">
                <!-- <input type="hidden" name="prodid" value="<?php //esc( $prod_id ); ?>"> -->
                <input type="hidden" name="last_id" value="<?php esc( $last_id); ?>">

                <p><input class="btn btn-primary" type="submit"
                          name="submit_purchase" value="Purchase Now"></p>
            </form><?php esc( $sale_id ); ?>

<?php
print "<h4 class=\"alert alert-success\">You have Successfully Added a New Product to Your Basket</h4>";
                print "<hr>";
                }
                    else
                    {
                    print "ERROR - inserting product basket items failed";
                    }
?>

                <hr>

<?php
    } //ends do after qnty is in stock
        else
        {
        esc("<h1>Product is Out of Stock at this time.</h1>
                <h4>Please call shop to find out more.</h4>");
        }
?>

            </div>
                <div class="panel-footer">
                  <a href="index.php" class="btn btn-default" title="back to store">Return to Store</a>
                </div>
        </div>
     </article>
    </div>
</div>

<?php
} //ends process basket
?>




<?php

    /**
     * @sale_id= should match custs other prods
     * ******************************
     * This section processes the current item and gets
     * all other items in basket.
     * @uses $sale_id= $escooktmpname (Cookie session string)
     * @form submit button and EOForm is in part-purch.php
     */
if( isset ( $_POST['submit_purchase'] ))
{
    $sale_id  = filter_var($_SESSION["escooktmpname"], FILTER_SANITIZE_STRING  ); //id to get all items with
    $esellopt = filter_input(INPUT_POST, 'last_id', FILTER_SANITIZE_NUMBER_INT ); //last item in basket

    //Allow post value from history on myaccount page.
    if( isset( $_POST['basket_id']))
    {
    $esellopt  = filter_input(INPUT_POST, 'basket_id', FILTER_SANITIZE_NUMBER_INT );
    }
?>

<div class="container bgj">
    <div class="row">
        <article class="col-lg-6 col-xs-12 marg-t1">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Account and Purchasing Information</h4>

<?php
if( isset ( $_SESSION['eselluser_session']))
{
    $memid = $_SESSION['user_id'];

    echo("<h4>Looks like you have an account with us {$_SESSION['firstname']}</h4>
    <p>Would you like to use the account information to apply to this purchase?</p>
    <form action=\"\" method=\"POST\" id=\"autoFills\">
        <input type=\"hidden\" name=\"idm\" value=\"{$memid}\">
        <p><input type=\"submit\" name=\"submit_memid\" value=\"YES\" class=\"btn btn-primary\"></p>
    </form>" );
}
?>

                </div>
                <div class="panel-body">




                <form class="form-horizontal" method="post" action="part-purch.php" name="purchForm">




                <table class="table"><thead class="alert alert-warning fade in">
                <tr><th colspan=3>Mark All Products You Want to Purchase</th></tr></thead>
                    <tbody>
                    <tr><td>Select</td><td>Product</td><td>Price</td></tr>

<?php

    $tlts = 0;
    /**
     * display all items belonging to this user
     * @val $keeps= 1 is not purchased (basket only)
     *
     * @checkbox is id of basket to update (@val= 0)
     * When checked id is passed to mysql UPDATE
     *
     * @input= prodcode, prod ids concatenate into one string.
     * @col= prodcode,  256 chr max.
     */
    $sql = $pdo->query(" SELECT * FROM esell_basket
                         WHERE sale_id = '" . $sale_id . "'
                         AND keeps > 0 ");

	if( $sql->rowCount() > 0)
    {
	   while($data = $sql->fetch(PDO::FETCH_ASSOC))
        {
?>

<tr class="alert alert-warning">
<td><input type="checkbox" name="keepsid[]" value="<?php esc($data['id']); ?>" checked=checked>
<small><input type="hidden" name="prodcode[]" value="<?php esc($data['id']); ?>"></small></td>
     <td><?php esc($data['prod'] . ' ' . $data['id'] . '' . $data['prodid']); ?></td>
         <td><?php $prodtltb = $data['price']; $prodtltb = number_format($prodtltb, 2, '.', '');
               esc($prodtltb); $tlts += $prodtltb; ?></td>
</tr>

<?php
        }

        //Ends while-loop, now add up total purchase.
        print '<tr><td><b>Total</b>';
        $totals = number_format($tlts, 2, '.', '');
        print '</td><td><input type="hidden" name="purchtotal" value ="' . $totals . '"></td>';
        print '<td>$' . $totals . '</td></tr>';

    } else { esc("<tr><td colspan=3>There are no purchases at this time. Try enabling your Cookies on your Browser.</td></tr>"); }


?>

</tbody><tfoot><tr><td colspan=3> <a href="#" title="top of page">Top of Page</a></td></tr><tfoot>
</table>
<script>

</script>
<hr>

<?php
        //display only the last item in detail
        $sql = "SELECT * FROM esell_basket
                WHERE id = ?";
	    $q = $pdo->prepare($sql);
        $q->execute(array($esellopt));
	    $data = $q->fetch(PDO::FETCH_ASSOC);

            $id       = $data['id'];        //bskid
            $sale_id  = $data['sale_id'];   //cust
            $proddate = $data['proddate'];  //now
            $prod_ref = $data['prod_ref'];  //sold by
            $howmany  = $data['qnty'];      //no.
            $price    = $data['price'];     //per
            $prod     = $data['prod'];      //name
            $prod_id  = $data['prodid'];
            $prodprice    = frmPrc($price);

        $prodprice = prodPrice($prod_id);
        $subtlt = $prodprice * $howmany;
        if( $taxed  == 0 )
        {
            $taxvalue = $tax_rate * .01;
            $tax_value = $subtlt * $taxvalue;
        }  else {
                $tax_value = 0;
                }

        //format purchase total
        $prodtlt = $subtlt + $tax_value;
        $prodtlt = frmPrc($prodtlt);
?>

           <h4>Most Recent Product You are Purchasing</h4>
            <ul class="list-prod">
              <li><h4><?php esc( $prod . ' #' . $data['id'] . '' . $data['prodid']  ); ?></h4></li>

              <li><span>Purchased Id: </span> <?php esc( $esellopt . '' . $prod_id ); ?></li>

            <li><span>Cost: </span>          $<?php esc( $prodprice . ' ' . $prod_ref ); ?></li>
            <?php if( isset( $_SESSION['user_id'] )) { ?>
            <li><span>Customer Id:</span>     <?php esc( $user_id ); ?></li>
            <?php } ?>
            <li><span>Sale Id: </span>        <?php esc( $sale_id ); ?></li>
            <li><span>Quantity: </span>       <?php esc( $howmany ); ?></li>
            <li><span>Purchase Nmbr.: </span> <?php print( $_SESSION["escooktmpname"] ); ?></li>
            <li><span>Product Id: </span>     <?php esc( $prod_id ); ?></li>
            <li><span>Sub Total: </span>     $<?php esc( frmPrc($subtlt) ); ?></li>
            <li><span>Tax: </span>           $<?php esc( frmPrc($tax_value) . ' rate ' . $tax_rate); ?></li>
            <li><span>Total: </span>         $<?php esc( $prodtlt ); ?></li>
            </ul>


                    </div>

                    <div class="panel-footer">
                        <a href="#" title="top" class="btn btn-link">Top of Page</a>
                    </div>
                </div>
            </article>




                    <article class="col-lg-6 col-xs-12 marg-t1">

                        <?php
                            //customer/shipping information form part
                            include 'part-pay.php'; ?>

                        <?php
                            //billing/with cc form part
                            include 'part-billing.php'; ?>

                    </article>

            </form>


    </div>
</div>

<?php
}
?>

<?php include('footer.php'); ?>