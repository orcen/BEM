<nav class="sitemap-wrap grid_xs_6 grid_l_3">
<h4 class="heading">Sitemap</h4>
<?
if( $REX['REDAXO'] == false )
    echo show_cats( OOCategory::getRootCategories(), 0, 0 , 0, 'sitemap' );
?>
</nav>
