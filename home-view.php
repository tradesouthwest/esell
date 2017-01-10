<?php
    $statement = $pdo->query('SELECT * FROM esell_fields ORDER BY `id` DESC LIMIT 50');
    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
?>

<div class="col-lg-4 col-xs-12 homeview">
    <table class="table bgj"><tbody>
    <tr><td colspan="2"><h5><? esc( $row['prod'] ); ?></h5></td></tr>
    <tr class="img-row"><td><a class="btn btn-default btn-sm" href="product.php?id=<?php esc( $row['id'] ); ?>&prod=<?php echo seoUrl( $row['prod'] ); ?>"><?php $location = ( !empty($row['location'] )) ? $row['location'] : "imgs/blueblank.png"; ?><img src="<?php esc( $location ); ?>" alt="no img" class="img-responsive thumbnail"/></a></td><td class="maxwidth"><?php esc( $row['short'] ); ?></td></tr>
    <tr><td><a class="btn btn-default btn-sm" href="product.php?id=<?php esc( $row['id'] ); ?>&prod=<?php echo seoUrl( $row['prod'] ); ?>">View</a></td><td class="text-right"><span class="pricetag">$<? esc( $row['price'] ); ?></span></td></tr>
    <tr><td colspan=2><?php esc( catName( $row['cat'] )); ?></td></tr>
    </tbody></table>
</div>
<?php
// close while loop
}
?>
