
            <div class="panel panel-default">
                <div class="panel-heading">

                    <?php print( "Categories" ); ?>

                </div>
                <div class="panel-body">

<div class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
      <span class="visible-sm navbar-brand">Sidebar menu</span>
    </div>
    <div class="navbar-collapse collapse sidebar-navbar-collapse">

        <ul class="list-group" id="sideCats">

                        <?php
                        foreach($pdo->query("SELECT * FROM esell_catalog WHERE cat_path = 0") as $data)
                    	{
                         ?>
            <li class="list-group-item"><a href="catalog.php?id=<?php esc( $data['id'] ); ?>&cat=<?php esc($data['cat']); ?>" title="category <?php esc($data['cat']); ?>"><?php esc( $data['cat'] ); ?></a></li>
                        <?php
                        }
                        ?>

        </ul>

    </div>
</div>
</div>

            <div class="panel-footer">
            <ul class="list-inline condensed">
        <li><a href="https://linkedin.com" title="linked in"><i class="far fa-linkedin"></i></a><li>
        <li><a href="https://www.facebook.com/" title="facebook"><i class="far fa-facebook"></i></a></li>
        <li><a href="https://twitter.com/" title="twitter"><i class="far fa-twitter"></i></a><li>
        <li><a href="https://plus.google.com/" title="google plus"><i class="far fa-google-plus"></i></a></li>
            </ul>
            </div>
</div>