<?php
include 'adminheader.php';
$pageis = "inventory";
?>
    <title>eSell TSW eCommerce</title>
    <meta name="description" content="restricted">
    <link type="text/css" rel="stylesheet" href="<?php print($site_url); ?>/lib/jquery-te-1.4.0.css">

    <script type="text/javascript" src="<?php print($site_url); ?>/lib/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<style>
textarea{margin-left: 0;}
label[for=details]{padding-left: 20px;}
select.form-control > option .text-subcat{width: 100%; height: auto;text-decoration: underline; padding-left: 15px; color: blue !important; background: #fafaaa;}
.text-nosub{font-weight: 700;}

</style>
</head>
<body>
<?php
include 'adminmenutop.php';
include 'adminnavtop.php';
?>

        <div class="container">
            <div class="row">
                <article class="col-lg-6 col-xs-12">
<div class="panel panel-default">
<div class="panel-heading">

<?php
/*
`id`, `prod`, `short`, `details`, `price`, `prod_ref`, `cat`, `prod_link`,
`stknumb`, `qnty`, `location`, `feature`, `datein`, `prodstat`
*/
if( isset( $_POST['submit_newprod']))
{
include('../lib/class.upload.php');

$prod      = '';
$short     = '';
$details   = '';
$price     = '';
$prod_ref  = '';
$cat       = '';
$prod_link = '';
$qnty      = '';
$stknumb   = '';
$feature   = '';
$datein   = '';
$prodstat   = '';
$img_url   = '';

    	if (isset($_FILES["my_field"]))
    {
    	// set variables
    	$dir_dest = (isset($_GET['dir']) ? $_GET['dir'] : '../uploads');
    	$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $dir_dest);

     	$handle = new Upload($_FILES['my_field']);

		if ($handle->uploaded) {
		$appended = "_".date('mdYHis');
		$handle->file_max_size = '8001024'; // 8.1MB
		$handle->file_auto_rename = true;
		$handle->file_safe_name = true;
		$handle->file_name_body_add = $appended;
  			$handle->Process($dir_dest);



        	// we check if everything went OK
        	if ($handle->processed) {
            // everything was fine !
			$img_url = str_replace( "../", '', $dir_pics.'/'."$handle->file_dst_name" );
			} else {
            // one error occured
            echo '<p class="result">';
            echo '  <b>No file uploaded OR you used a temporary placeholder</b><br />';
            echo '  Error: ' . $handle->error . '';
            echo '</p>';
        	}
       		// we delete the temporary files
        	$handle-> Clean();

    	} else {
        // if we're here, the upload file failed for some reasons
        // i.e. the server didn't receive the file
        echo '<p class="result">';
        echo '  <b>Image either not uploaded or you used a temporary placeholder</b><br />';
        echo '  Note: ' . $handle->error . '';
        echo '</p>';
        }
    }


$prod      = $_POST['prod'];      //name
$short     = $_POST['short'];     //descript
$details   = $_POST['details'];   //textarea
$price     = $_POST['price'];     //price
$prod_ref  = $_POST['prod_ref'];  //sold per
$cat       = $_POST['cats'];      //cat
$prod_link = $_POST['prod_link']; //external link to prod
$qnty      = $_POST['qnty'];
$stknumb   = $_POST['stknumb'];
$datein    = $_POST['datein'];



$query = "INSERT INTO esell_fields
( prod, short, details, price, prod_ref, cat, prod_link, qnty, stknumb, location, datein )
VALUES
( :prod, :short, :details, :price, :prod_ref, :cat, :prod_link, :qnty, :stknumb, :location, :datein )";

$stmt = $pdo->prepare($query);

$params = array(
    "prod"      => $prod,
    "short"     => $short,
    "details"   => $details,
    "price"     => $price,
    "prod_ref"  => $prod_ref,
    "cat"       => $cat,
    "prod_link" => $prod_link,
    "qnty"      => $qnty,
    "stknumb"   => $stknumb,
    "location"  => $img_url,
    "datein"    => $datein,
    );

$inserted = $stmt->execute($params);

            if($inserted)
            {
echo "<BR>";
echo "<h4>You have Successfully Added a New Product</h4>";
echo "<p><a class=\"menutop\" href=\"index.php\">Back to Store Manager</a></p>";
            }
                else
                {
                echo "ERROR - inserting product failed";
                }
}
?>

</div>
<div id="ProdForm" class="panel-body">

    <form name="doinsert" method="post" action="" enctype="multipart/form-data">
    <fieldset><legend>New Product Details</legend>
        <p><label>Product Name</label><br>
	    <input name="prod" id="prod" type="text" class="form-control"></p>
        <p><label>Short Description</label><br>
	    <input type="text" size="38" name="short" id="short" type="text" class="form-control"></p>

        <p><label for="details">Overview of Product</label></p>

             <textarea class="jqte-text" name="details" cols="51" rows="12"></textarea>
<script>

/** calls the jquery text editor script
 *  class name is assignable to textarea
*/
    $('.jqte-text').jqte();

</script>
            <br>

        <span class="col-xs-5">
        <p><label>Price <small>No $, no comma</small></label><br>
	    <input name="price" id="price" type="text" class="form-control"></p></span>

        <span class="col-xs-7">
        <p><label>Sold by option <small>per feet, dozen, color...</small></label><br>
            <input name="prod_ref" id="prod_ref" type="text" class="form-control"
                value="each"></p></span>

        <p><label>External link to product information</label><br>
	    <input name="prod_link" id="prod_link" type="text"
                class="form-control" placeholder="optional"></p>

        <div class="col-lg-12 alert alert-info">
        <label for="cats"> Select Category for Product</label>
        <br><select class="form-control" name="cats">
            <option value="">Select Category to Put Product Under</option>

        <?php
        foreach($pdo->query('SELECT * FROM esell_catalog order by field(
                            cat_ref, `id`)DESC, id') as $data)
		{
        if( $data['cat_path'] == 1 ) { $class = "--- "; }
            else { $class = ""; }
            echo '<option value="';
            echo $data['id'];
            echo '">' . $class;
            echo $data['cat'] . "</option>";
        }
        ?>

        </select><br>
        </div>

        <p><label>Enter <u>alternate</u> URL link for product</label><br>
	       <input type="text" class="form-control" name="prod_link" placeholder="Optional external link if any"></p>

        <p><label>Add Product Image </label>
            <input type="hidden" name="action" value="image">
                <input type="file" name="my_field" value="" class="btn btn-default" id="myfile"></p>

        <p><a href="showimg.php" title="show images in gallery" target="_blank">Show existing photos</a></p>

        <p><label>Or enter <u>alternate</u> path for product image</label><br>
            <input type="text" class="form-control" name="pic" value="" placeholder="Optional external link for Image"></p>

        <p><label>Current Quantity </label> <input name="qnty" type="number" required placeholder="0 if not stocked"></p>

        <p><label>Product Number/Specification</label><br>
	        <input name="stknumb" id="stkNumb" type="text" value="" class="form-control"></p>


	        <p>database id and date inserted automatically</p>
            <input type="hidden" name="datein" value="<?php print( $date_entered ); ?>">
		    <input class="btn btn-success" type="submit" name="submit_newprod" value="Add New Product">
		    <input class="btn btn-link" type="reset" name="reset" value="Reset">
    </fieldset>
    </form><br>

</div>
<div class="panel-footer">
</div>
</div>
</article>

<article class="col-lg-6 col-xs-12">
<div class="panel panel-default">
<div class="panel-heading">
<h4>Update Products</h4></div>
<div class="panel-body">
<?php
if (isset( $_POST['submit_delet']))
{
    $id = $_POST['id'];


    // Delete
    $stmt = $pdo->prepare("DELETE FROM esell_fields WHERE id = ?");
    $deleted = $stmt->execute([$id]);
    // if successfully deleted
    if($deleted){

    echo "<div class=\"alert alert-danger\">";
    echo "Deleted Successfully";
    echo "</div>";
    echo "<p><a class=\"btn btn-link\" href=\"index.php\">Return to Control Panel</a></p>";
    }
    else
        {
        print("could not remove item");
        }
// close connection
//$pdo = null;
}
?>


<table class="table table-condensed small"><thead><tr><th>id</th><th>product</th><th>category</th><th>price</th><th> [ - ] </th></tr></thead>
<tbody>

<?php

    $statement = $pdo->query('SELECT * FROM esell_fields ORDER BY `id` DESC LIMIT 50');
    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
?>

<tr>
<td class="tiny"><? esc( $row['id'] ); ?></td>
    <td class="ellipsised"><? esc( $row['prod'] ); ?></td>
        <td><? esc( $row['cat'] ); ?></td>
            <td><? esc( $row['price'] ); ?></td>
                <td><form action="" method="POST">
                    <input type="hidden" name="id" value="<?php esc( $row['id'] ); ?>">
                    <input type="submit" name="submit_delet" value="delete" class="btn btn-danger btn-xs">
                    </form></td>
</tr>

<?php
// close while loop
}
?>
</tbody>
</table>
</div>
<div class="panel-footer">

<select name="cat">

        <?php
        foreach($pdo->query('SELECT * FROM esell_catalog') as $data)
		{
            echo "<option value=\"'" . $data['cat'] . "\">";
            echo $data['cat'] . "</option>";
        }
        ?>

        </select></p>
</div></div>
</article>

            </div>
        </div>
<script>
jQuery(function($) {
    $('form[data-async]').live('submit', function(event) {
        var $form = $(this);
        var $target = $($form.attr('data-target'));

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data, status) {
                $target.html(data);
            }
        });

        event.preventDefault();
    });
});

</script>
<?php
include('adminfooter.php'); ?>