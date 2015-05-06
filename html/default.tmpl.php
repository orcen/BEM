<?php

    ( string ) $slides = '';
    ( string ) $style = '<style type="text/css">.header .inner{background-image:url(%1$s)}'
        . '@media '
        . 'only screen and (-webkit-min-device-pixel-ratio: 2)      and (min-width: 1300px),'
        . 'only screen and (   min--moz-device-pixel-ratio: 2)      and (min-width: 1300px),'
        . 'only screen and (     -o-min-device-pixel-ratio: 2/1)    and (min-width: 1300px),'
        . 'only screen and (        min-device-pixel-ratio: 2)      and (min-width: 1300px),'
        . 'only screen and (                min-resolution: 192dpi) and (min-width: 1300px),'
        . 'only screen and (                min-resolution: 2dppx)  and (min-width: 1300px) {'
        . '.header .inner{background-image:url(%2$s)}}'
        . '@media only screen and (max-width: 60em) {.header .inner{background-image:url(%3$s)}}'
        //. '@media only screen and (max-width: 48em) {.header .inner{background-image:url(%3$s)}}'
        . '</style>';
    ( object ) $art = OOArticle::getArticleById( 'REX_ARTICLE_ID' );
    ( object ) $startArt = OOArticle::getArticleById( 1 );
    ( string ) $file = '';

    $file = ( $art->getValue( 'art_file' ) != '' ? $art->getValue('art_file') : ( $startArt->getValue( 'art_file' ) ? $startArt->getValue('art_file') : null ) );

    $style = ( $file != null ? sprintf( $style,
                                        seo42::getImageManagerFile( $file, 'bg_header' ),
                                        seo42::getImageManagerFile( $file, 'bg_header@2x' ),
                                        seo42::getImageManagerFile( $file, 'bg_header-small' ),
                                        seo42::getImageManagerFile( $file, 'bg_header-tablet' ) ) : null );

?>
REX_TEMPLATE[2]
<!DOCTYPE HTML>
<!--[if lte IE 9 ]>    <html lang="de" class="no-js old-ie"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="de" class="no-js <?=( $REX['isMobile'] ? 'mobile' : null );?>"> <!--<![endif]-->
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <base href="<?php echo seo42::getBaseUrl(); ?>" />
    <title><?php echo seo42::getTitle(); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="description" content="<?php echo seo42::getDescription(); ?>" />
    <meta name="keywords" content="<?php echo seo42::getKeywords(); ?>" />
    <meta name="robots" content="<?php echo seo42::getRobotRules();?>" />
    <link rel="canonical" href="<?php echo seo42::getCanonicalUrl(); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <link rel="shortcut icon" type="image/png" href="/favicon.png" />
    <link href='http://fonts.googleapis.com/css?family=Philosopher:400,400italic,700,700italic' rel='stylesheet' type='text/css' />
    <link type="text/css" rel="stylesheet"  href="files/css/style.css" media="screen" />
    <!--[if lt IE 9 ]>
    <link type="text/css" rel="stylesheet" href="files/css/ie.css" media="screen" />
    <script type="text/javascript" src="files/js/html5shiv-printshiv.js"></script>
    <![endif]-->
    <link type="text/css" rel="stylesheet"  href="files/css/jquery.css" media="screen" />
    <?=$style;?>
  </head>
  <body>
  <!--[if lt IE 9 ]><div id="ie-warning"><p>Wissen Sie, dass Ihr Internet Explorer nicht mehr aktuell ist?<br />
      Um unsere Webseite bestmöglich zu nutzen, empfehlen wir Ihnen Ihren Browser auf eine aktuellere Version zu aktualisieren oder einen anderen Webbrowser zu nutzen.</p></div><![endif]-->
  <header class="header">
    <div class="inner inner--header container_12 clearfix">
          <nav id="nav_wrap" class="nav_wrap grid_xs_12 alpha omega" >
            <span id="nav_switch" class="nav-switch icon-menu" >Navigation</span>
          <?=show_cats(OOCategory::getRootCategories());?>
          </nav>
          <div class="subheader grid_md_12 alpha_md omega_md">
            <div class="grid_md_7 prefix_md_4 omega_md grid_l_6 prefix_l_0">
                <form id="rexsearch_form" class="search" action="<?=rex_getUrl(11);?>" method="get">
                    <fieldset>
                        <input type="text" class="search-field" name="rexsearch" placeholder="Suche" value="<?php if(!empty($_GET['rexsearch'])) echo htmlspecialchars($_GET['rexsearch']); ?>" /><button class="search-btn icon-search">Suchen</button>
                    </fieldset>
                </form>
            </div>
            <div class="mininav grid_md_5 alpha_md grid_l_6">
                <a class="mininav-link" href="<?=rex_getUrl(7);?>" title=""><i class="icon-phone"></i>Kontakt</a>
                <a class="mininav-link" href="<?=rex_getUrl();?>" title=""><i class="icon-impressum"></i>Impressum</a>
                <a class="mininav-link" href="https://www.facebook.com/" title=""><i class="icon-facebook-squared"></i>Facebook</a>
            </div>
          </div>
          <a class="header-logo" href="<?=rex_getUrl($REX['START_ARTICLE_ID']);?>"><img class="header-logoimage" src="files/logo.png" alt="<?=$REX['SERVERNAME'];?>" width="126" height="178" /></a>
      </div>
  </header>
  <main role="content" class="content">
    <div class="inner content-inner container_12 clearfix">
        REX_ARTICLE[]
    </div>
  </main>
  <footer class="footer">
    <div class="inner inner--footer container_12 clearfix">
        REX_ARTICLE[8]
    </div>
  </footer>
  <script type="text/javascript" src="files/js/modernizr.js"></script>
  <script type="text/javascript" src="files/js/default.js"></script>
  </body>
</html>