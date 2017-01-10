<?php
include 'adminheader.php';
$pageis = "catalog";
?>
<title>eSell TSW eCommerce</title>
<meta name="description" content="<?php //print($produt); ?>">
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
<h4>Manage Categories</h4></div>
<div class="panel-body">

	<form id="catalog" name="catalog" method="post" action="">

	    <br><h4>New Category Name</h4>
	    <p><input name="cat" type="text" class="form-control"></p>


        <p><label>Category Reference (second level name)</label></p>
        <p><select name="cat_ref" class="form-control">
        <option value="0">Leave as Parent Category</option>
        <?php
        //cat_ref = parent cat of sub cat
        foreach($pdo->query('SELECT * FROM esell_catalog') as $data)
		{
            echo "<option value = '{$data['id']}'";
            echo ">{$data['cat']}</option>";
        }
        /** reserve zero for category hierarchy
         * cat_path will be 1-3 levels max
         * assign number to @cat_path
         */
        $catpath = 0;
        ?>

        </select></p>
        <p><input name="cat_path" type="hidden" value="<?php print( $catpath ); ?>"></p>
        <p><input name="submit_newcat" class="btn btn-default" type="submit"
                  value=" Submit " class="btn btn-default"></p>

    </form><br><hr><br>

</div>
<div class="panel-footer">

<?php
if( isset( $_POST['submit_newcat']))
{
$cat      = $_POST['cat'];
$cat_ref  = $_POST['cat_ref'];    //0 to parent cat, parent cat id to sub cat
$cat_path = ( $cat_ref > 0) ? $cat_path = 1 : $cat_path =  $_POST['cat_path'];

    $query = "INSERT INTO esell_catalog
                    (cat, cat_ref, cat_path)
              VALUES (:cat, :cat_ref, :cat_path)";
    $stmt = $pdo->prepare($query);

    $params = array(':cat' => $cat, ':cat_ref' => $cat_ref, ':cat_path' => $cat_path );

        $inserted = $stmt->execute($params);

            if($inserted)
            {
echo "<script>
         $(window).load(function(){
             $('#refreshModal').modal('show');
         });
    </script>";

            }
                else
                {
                echo "ERROR - inserting category name into db failed";
                }
}
?>

</div>
</div>
</article>




<article class="col-lg-6 col-xs-12">
<div class="panel panel-default">
<div class="panel-heading">
<h4>Update Category <small>Sub of "1" = Is a Parent Category</small></h4></div>
<div class="panel-body">
<?php
if (isset( $_POST['submit_delet']))
{
$id = $_POST['id'];

// Delete data in mysql from row that has this id
$stmt = $pdo->prepare("DELETE FROM esell_catalog WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$deleted = $stmt->execute();

// if successfully deleted
if($deleted){
echo "<p class=\"alert alert-danger\">Deleted Successfully</p>";
echo "<p><a class='btn btn-link' href='index.php'>Return to Control <span>P</span>anel</a> | ";
echo "<a class='btn btn-link' href='catalog.php'>Clear Message - Refresh This Page</a></p>";
}

else {
print("could not remove item");
}
// close connection
//$pdo = null;
}
?>
<table class="table"><thead>
<tr><th>Id</th><th>Category</th><th>Path</th><th>Sub of</th><th> [ - ] </th></tr></thead>
<tbody>

<?php
    $statement = $pdo->query("SELECT * FROM esell_catalog
                              ORDER by cat_ref");
        while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
?>

<tr>
<td><? esc( $row['id'] ); ?></td>
<td><? esc( $row['cat'] ); ?></td>
<td><? esc( $row['cat_path'] ); ?></td>
<td><? esc( $row['cat_ref'] ); ?></td>
<td><form action="" method="POST"><input type="hidden" name="id" value="<?php esc( $row['id'] ); ?>"><input type="submit" name="submit_delet" value="delete" class="btn btn-danger btn-xs"></form></td>
</tr>

<?php
// close while loop
}
?>

</tbody>
</table>
</div>
<div class="panel-footer" style="min-height: 60px;">
<form action="" method="POST">
<div class="col-xs-6">
<select name="cat_id">

        <?php
        foreach($pdo->query('SELECT * FROM esell_catalog') as $data)
		{
            echo "<option value = '{$data['id']}'";
            echo ">{$data['cat']}</option>";
        }
        ?>

        </select>
</div>
<div class="col-xs-6">
<input type="submit" name="submit_edit" value="Edit Category">
</div>
</form>

<?php
if( isset( $_POST['submit_edit']))
{
    $id = $_POST['cat_id'];
?>

<br><hr>
<form action="" method="POST">
<table class="table"><tbody>

<?php
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM esell_catalog where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
        $id = $data['id'];
            $cat = $data['cat'];
                $cat_path = $data['cat_path'];
                    $cat_ref = $data['cat_ref'];
?>

<tr><td><input type="text" name="id" value="<? esc( $id ); ?>" readonly> Id (readonly)</td></tr>
<tr><td><input type="text" name="cat" value="<? esc( $cat ); ?>"> Category Name</td></tr>
<tr><td><input type="text" name="cat_path" value="<? esc( $row['cat_path'] ); ?>"> Cat_Path</td></tr>
<tr><td><input type="text" name="cat_ref" value="<? esc( $row['cat_ref'] ); ?>"> Cat_Ref</td></tr>
<tr><td><input type="submit" name="submit_catupdate" value="update"
class="btn btn-info btn-sm"> Update</td></tr>

<?php
print('</tbody></table></form>');

}

?>


<?php
if( isset( $_POST['submit_catupdate']))
{
	$id       = $_POST['id'];
	$cat      = $_POST['cat'];
	$cat_path = $_POST['cat_path'];
	$cat_ref  = $_POST['cat_ref'];

         $sql = "UPDATE esell_catalog
				SET `cat` = :cat, `cat_path` = :cat_path, `cat_ref` = :cat_ref
                WHERE `id` = :id";
				$stmt = $pdo->prepare($sql);
				$stmt->execute(array(
                ':cat' => $cat,
                ':cat_path' => $cat_path,
                ':cat_ref' => $cat_ref,
                ':id' => $id
                ));
				if( $stmt !==false){
echo "<div class='alert alert-success'><h3>Successfull activity</h3>
<h4>Entry No. '" . $id . "' Name '" . $cat . "' Updated</h4></div>
<p>You must refresh this page to view new results.</p>
<p><a href=\"catalog.php\" class=\"btn btn-primary\">Refresh List</a></p>";
				} else { print('no go'); }
}
?>

                </div>
            </div>

<hr>
<div class="modal fade" id="refreshModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h5 class="modal-title" id="myModalLabel">Success!</h5>
      </div>
      <div class="modal-body">
<h4>New Catergory Successfully Entered</h4>
<p><a class="btn btn-success btn-lg" href="catalog.php">Validate and Return to Page</a></p>
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

            </div>
        </div>
<?php
include('adminfooter.php'); ?>