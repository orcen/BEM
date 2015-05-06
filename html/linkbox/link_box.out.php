<?php
  /**
  * @author Advance Media
  * @copyright 2014
  */

 ( string ) $imageUrl = '';
 ( string ) $linkUrl = '';
 ( string ) $linkText = '';
 ( object ) $imgObj = '';
 ( string ) $buttonTitle = '';
 ( string ) $buttonText = '';

 if ( 'REX_MEDIA[1]' != '' ) {

     $imgObj = OOMedia::getMediaByFileName( 'REX_MEDIA[1]' );

     if( $imgObj instanceof OOMedia ) {

         $imageUrl = seo42::getImageManagerFile( $imgObj->getFilename(), 'button' );
     }
 }

 if( 'REX_VALUE[1]' != '' ) {
    $titleText = 'REX_VALUE[1]';

    $titleText = preg_replace( '#^([\w]+)\s#', '<span>$1</span>', $titleText);

    $buttonTitle = '<h2 class="lb-heading heading">' . $titleText . '</h2>';
 }
 if( 'REX_VALUE[2]' != '' ) {
    $buttonText = '<div class="lb-text">' . 'REX_HTML_VALUE[2]' . '</div>';
 }

 if ( 'REX_LINK[1]' != '' && trim('REX_VALUE[3]') == '' ) {
     $linkUrl = rex_getUrl( 'REX_LINK_ID[1]' );
     $linkText = OOArticle::getArticleById( 'REX_LINK_ID[1]' )->getName();
 }

 if ( trim('REX_VALUE[3]') != '' ) {
     $linkUrl = $linkText = 'REX_VALUE[3]';
 }

 if ( 'REX_VALUE[4]' != '' ) {
     $linkText = 'REX_VALUE[4]';
 }
?>

<div class="lb grid_xs_12 grid_sm_6 grid_md_6 grid_l_3 ">
    <?=$buttonTitle . $buttonText ;?>
    <div class="lb-image"><img src="<?=$imageUrl;?>" alt="<?=$imgObj->getTitle;?>" /></div>

    <a href="<?= $linkUrl;?>" class="lb-btn"><?= $linkText;?></a>
</div>
