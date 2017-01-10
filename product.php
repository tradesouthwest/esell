<?php
include 'header.php';
?>

<?php
/*
`id`, `prod`, `short`, `details`, `price`, `prod_ref`, `cat`, `prod_link`,
`stknumb`, `qnty`, `location`, `feature`, `datein`, `prodstat`
*/
if( isset( $_REQUEST['id']))
{
$id = $_GET['id'];

    $sql = "SELECT * FROM esell_fields where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);

	$prod     = $data['prod'];
    $short    = $data['short'];
    $details  = $data['details'];
    $price    = $data['price'];
    $cat      = $data['cat'];
    if(!empty($data['prod_ref'])) $prod_ref   = $data['prod_ref']; //sold per
    if(!empty($data['stknumb'])) $stknumb     = $data['stknumb'];    //stock nmbr
    $qnty     = $data['qnty'];
    if( !empty ( $data['location'] )) { $location = $data['location']; } //img url
        else { $location = "imgs/blueblank.png"; }
    if(!empty($data['feature'])) $feature     = $data['feature'];    //
    if(!empty($data['prod_link'])) $prod_link = $data['prod_link']; //alt link to prod
}
?>

<title>eSell eCommerce | <?php if( !empty( $prod )) esc( $prod ); ?></title>
<meta name="description" content="For sale <?php print($short); ?>">

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
        <a href="" title="esell by TSW">
        <img id="homelogo" src="favicon.png" alt="logo"
            class="img-responsive thumbnail" /></a>
        </figure>
        </header>
    </div>
</div>




<div class="container bgj">
    <div class="row">

    <article id="mainview" class="col-lg-9 col-xs-12">

    <form action="purchasing.php" method="POST" id="PurchaseForm">




    <table class="table table-responsive bgj"><tbody>
    <tr><td colspan="2"><h2><?php esc( $prod ); ?></h2>

<input type="hidden" name="prod" value="<?php esc( $prod ); ?>" /></td>

    </tr>
    <tr><td colspan="2" class="img-cell">
        <a title="<?php print( $short ); ?>" href="" data-toggle="modal"
            data-target="#imgModal"  onclick="centerModal();">
            <img class="img-responsive prodimg" src="<?php esc( $location ); ?>" alt="no img" /></a></td>
    </tr>
    <tr><td colspan="2"><?php esc( $short ); ?></td>
    </tr>
    <tr><td colspan="2"><?php esc( $details ); ?></td>
    </tr>
    <tr><td colspan="2">Price: $<?php esc( $price ); ?> <small> <?php esc( $prod_ref ); ?></small>
<input type="hidden" name="prod_ref" value="<?php esc( $prod_ref ); ?>">
<input type="hidden" name="price" value="<?php esc( $price ); ?>"></td>

    </tr>
    <tr><td colspan="2">Product Number: <?php esc( $stknumb ); ?></td>
    </tr>

    <tr><td colspan="2" class="underlined">Quantity - How many would you like?
<input type="number" size="15" name="howmany" required> </td>
    </tr>

    <tr><td colspan="2">imgs</td>
    </tr>

	<tr><td>Taxable Rate is: <b><?php print( $tax_rate ); ?></b></td>
        <td><p><span class="marg-r1">Check if you are tax exempt. </span>
<input type="checkbox" name="taxed" value="1"></p></td>
    </tr>

    <tr><td>
    <p><?php esc( $prod_link ); ?></p>


<input type="hidden" name="prod_id" value="<?php esc( $id ); ?>" readonly>
<input class="btn btn-primary" type="submit" name="submit_tobasket" value="Add to Basket"></td>

            <td>ads or relevant products can go here</td>
    </tr>

    <tr><td> </td><td><?php esc( $qnty . ' Left in Stock'); ?> </td>
    </tr>

    <tr><td colspan="2">Category: <?php esc( catName( $cat ) ); ?></td>
    </tr>

    </tbody>
    <tfoot><tr><td colspan="12"><a href="javascript:history.back(0)" title="back">&larr; Back</a></td></tr>
    </tfoot>
    </table>
    </form>
    </article>




            <div class="col-lg-3 col-xs-12">
                <div id="right-sidebar">
                <div class="panel panel-default">
                <div class="panel-heading">
                    <?php print( date('M-d-Y') ); ?>
                </div>
                <div class="panel-body">

                <?php include 'sidebar-right.php'; ?>

                </div>
                </div>
                </div>
            </div>




    </div>
</div>



            <div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="audModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="imgModalLabel"><?php esc( $prod ); ?></h4>
                  </div>
                  <div class="modal-body">

                    <img src="<?php esc( $location ); ?>" alt="no img" class="img-responsive"/>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

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

<?php
include('footer.php'); ?>