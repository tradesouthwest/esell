<?php
include 'adminheader.php';
$pageis = "catalog";
?>
<title>eSell TSW eCommerce</title>
<meta name="description" content="restricted">
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
<style>table.squished td { border-bottom: thin solid #ddd; border-right: thin solid #ddd; padding: 1px;}
table.squished td.uno { background: #aff;}tr.onhover:hover {background: #eee;}
</style>
</head>
<body>

<?php
include 'adminmenutop.php';
include 'adminnavtop.php';
?>




        <div class="container">
            <div class="row">
                <article class="col-lg-12 col-xs-12">
<?php if( isset( $_GET['msge'])){ ?><p class="alert alert-info"><?php print ($_GET['msge']); ?></p><?php } ?>
                    <table class="squished">
<thead><tr><th>id</th><th>prod</th><th>price</th><th>prod_ref</th><th>cat</th><th>qnty</th><th>datein</th><th>prodstat</th><th>modify</th></tr></thead>
</tbody>
<?php
/*
`id`, `prod`, `short`, `details`, `price`, `prod_ref`, `cat`, `prod_link`,
`stknumb`, `qnty`, `location`, `feature`, `datein`, `prodstat`
*/
$stmt = $pdo->query("SELECT * FROM esell_fields");
foreach ($stmt as $data)
{

?>

    <tr class="onhover">
    <td class="uno"><?php esc( $data['id'] ); ?></td>
    <td><?php esc( $data['prod'] ); ?></td>
    <td><?php esc( $data['price'] ); ?></td>
    <td><?php esc( $data['prod_ref'] ); ?></td>
    <td><?php esc( $data['cat'] ); ?></td>
    <td><?php esc( $data['qnty'] ); ?></td>
    <td><?php esc( $data['datein'] ); ?></td>
    <td><?php esc( $data['prodstat'] ); ?></td>
    <td><form action="" method="POST">
            <input type="hidden" name="product" value="<?php esc($data['id']); ?>">
            <input type="submit" name="submit_prod" value="update" class="btn btn-xs btn-link">
        </form></td>
    </tr>

<?php
}
?>

</tbody>
                    </table>
                    <hr>

<form action="stockupdate.php" method="POST">
<fieldset><legend>Updates to Stock</legend>
<?php
    if(isset( $_POST['submit_prod'] ))
    {
    $id = $_POST['product'];

    $sql = "SELECT * FROM esell_fields where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);

?>
    <input type="hidden" name="id" value="<?php esc( $data['id'] ); ?>">
    <p><label>prod</label>
    <input type="text" name="prod" value="<?php esc( $data['prod']); ?>" class="form-control"></p>
    <p><label>short</label>
    <input type="text" name="short" value="<?php esc( $data['short'] ); ?>" class="form-control"></p>
    <p><label>details</label>
    <textarea name="details"><?php esc( $data['details'] ); ?></textarea>
    <p><label>price</label>
    <input type="text" name="price" value="<?php esc( $data['price'] ); ?>" class="form-control"></p>
    <p><label>prod_ref</label>
    <input type="text" name="prod_ref" value="<?php esc( $data['prod_ref'] ); ?>" class="form-control"></p>
    <p><label>cat</label>
    <input type="text" name="cat" value="<?php esc( $data['cat'] ); ?>" class="form-control"></p>
    <p><label>prod_link</label>
    <input type="text" name="prod_link" value="<?php esc( $data['prod_link'] ); ?>" class="form-control"></p>
    <p><label>qnty</label>
    <input type="text" name="qnty" value="<?php esc( $data['qnty'] ); ?>" class="form-control"></p>
    <p><label>location</label>
    <input type="text" name="location" value="<?php esc( $data['location'] ); ?>" class="form-control"></p>
    <p><label>datein</label>
    <input type="text" name="datein" value="<?php esc( $data['datein'] ); ?>" class="form-control"></p>
    <p><label>status</label>
    <input type="text" name="prodstat" value="<?php esc( $data['prodstat'] ); ?>" class="form-control"></p>

    <p><input type="submit" name="submit_updates" class="btn btn-success" value="Update"></p>

<?php
}
?>

</fieldset>
</form>
<p><a href="#" title="top of page">Top of Page</a></p>
        </article>

            </div>
        </div>
<?php include('adminfooter.php'); ?>