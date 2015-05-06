<?php

( string ) $result = null;

$wysiwigvalue = <<< EOD
REX_HTML_VALUE[3]
EOD;

if ( !function_exists( 'createImage' ) ) {

    function createImage( $imageFile, $width, $imgLink = false, $caption = false ) {

        if ( $image = OOMedia::getMediaByFileName( $imageFile ) ) {

            ( string ) $imgTag = null;
            ( object ) $rex_image = rex_image_manager::getImageCache( $image->getFilename(), 'article_' . $width);

            ( int ) $ih = $rex_image->getHeight(); // Image Height
            ( int ) $iw = $rex_image->getWidth();  // Image Width

            $imgTag = '<img src="'.seo42::getImageManagerFile($image->getFilename() , 'article_' . $width ).'" title="' . $image->getTitle() . '" '
                . 'alt="' . $image->getTitle() . '" width="'.$iw.'" height="'.$ih.'" />';

            // show description if available and allowed
            if ( ( $image->getDescription() != '' || $image->getTitle() != '' ) && $caption === true ) {

                $imgTag .= '<figcaption class="article-icaption"><div><p>' . $image->getTitle() . ' </p>'
                    . ( $image->getDescription() != '' ? '<p>'.$image->getDescription().'</p>' : null )
                    . '</div></figcaption>';
            }

            // create link to Popup version
            if ( $imgLink == 1 ) {

                $imgTag = '<a href="' . $image->getFullPath() . '" class="js-fancybox" title="' . $image->getTitle() . '">'
                    . $imgTag
                    . '</a>';
            }

            return array( 'tag' => $imgTag, 'dimensions' => array( 'width' => $iw, 'height' => $ih ) );

        }

        return false;
    }
}

( string ) $imgTag = null;
 ( array ) $imgTags = array();
 ( array ) $downloads = array();
( string ) $imgFiles = null;

// Process
if ( ( $imgFiles = 'REX_MEDIALIST[1]' ) != null ) {

    ( array )$files = explode( ',', $imgFiles . ',' );

    ( string ) $width = 'REX_VALUE[6]';
    ( bool ) $caption = ( 'REX_VALUE[8]' == 1 ? true : false );

    $floating = ( 'REX_VALUE[5]' == 'null' ? null : 'REX_VALUE[5]' );

    foreach ( $files as $index => $file ) {
        //image/jpeg application/pdf
        if ( $media = OOMedia::getMediaByFileName( $file ) ) {

            if ( $media->isImage() ) {

                ( array ) $img = createImage( $file,  $width, 'REX_VALUE[9]', $caption );
                ( string ) $imgClass = 'img-' . ( $index + 1 ).' article-image ';

                if ( $floating == 'left' || $floating == 'right' ) { // left or right float

                    $imgClass .= 'REX_VALUE[5]';
                }

                $imgTags[] = '<figure class="' . $imgClass . '" style="width: ' . $img['dimensions']['width'].'px;">' . $img['tag'] . '</figure>';

            }
        }
    }
}


$grid = str_replace( '  ', ' ', implode( ' ', rex_var::toArray( 'REX_VALUE[20]' ) ) );


//$push_sm = ('REX_VALUE[17]' != 0 ? 'push_sm_' . 'REX_VALUE[17]' : null );
//$push_xs = ('REX_VALUE[17]' != 0 ? 'push_sm_' . 'REX_VALUE[17]' : null );
//$push_md = ('REX_VALUE[16]' != 0 ? 'push_md_' . 'REX_VALUE[16]' : null );
//$push_l  = ('REX_VALUE[15]' != 0 ? 'push_l_'  . 'REX_VALUE[15]' : null );
//$push_xl = ('REX_VALUE[15]' != 0 ? 'push_xl_' . 'REX_VALUE[15]' : null );

// start div
$result .= '<article class="article ' . $grid .' clearfix" id="txt-REX_SLICE_ID">';

// wraps single words in header for css targeting

if ( 'REX_VALUE[7]' != '' && 'REX_MEDIA[2]' == '' ) { // header

    /*$titel = 'REX_VALUE[7]';
    $titel = explode( ' ', $titel );
    $nTitel = array();

    if ( count( $titel ) > 1 ) {

        foreach ( $titel as $idx => $word ) {

            $nTitel[] = '<span class="article-header-word ' . ( $idx == 0 ? 'first-word' : ( $idx == ( count( $titel ) - 1 ) ? 'last-word' : null ) ) . ' word-' . $idx . '">' . $word . '</span>';
        }
    }
    else {
        $nTitel = $titel;
    }

    $titel = implode( ' ', $nTitel );
    $result .= '<hREX_VALUE[10] class="article-header heading">' . $titel . '</hREX_VALUE[10]>';*/

    $titel = 'REX_VALUE[7]';
    $result .= '<hREX_VALUE[10] class="article-header heading"><span>' . $titel . '</span></hREX_VALUE[10]>';
}
elseif ( 'REX_MEDIA[2]' != '' ) {

    ( string ) $titelText = 'REX_VALUE[7]';
    ( object ) $titelImg = OOMedia::getMediaByFileName( 'REX_MEDIA[2]' );

    ( object ) $cacheImage = rex_image_manager::getImageCache( $titelImg->getFilename(), 'article_header');

    ( int ) $ih = $cacheImage->getHeight(); // Höhe
    ( int ) $iw = $cacheImage->getWidth();

    $titel = '<img src="'. seo42::getImageManagerFile( $titelImg->getFilename(), 'article_header').'" alt="' . $titelText . '" width="'.$iw.'" height="'.$ih.'" />';

    $result .= '<hREX_VALUE[10] class="article-header">' . $titel . '</hREX_VALUE[10]>';

}

if ( in_array( $floating, array( null, 'center', 'left', 'right' ) ) && !empty( $imgTags ) ) {

    $result .= array_shift( $imgTags );

}
elseif ( !empty( $imgTags ) ) {

    $result .= '<aside class="article-imgcol '
        . ( $floating == 'colLeft' ? 'left' : ( $floating == 'colRight' ? 'right' : null ) ) . '">'
        . implode(PHP_EOL, $imgTags )
        . '</aside>';
}

// now wrap of words
//if ( 'REX_VALUE[7]' != '' ) { // header
//    $titel = 'REX_VALUE[7]';
//    $result .= '<hREX_VALUE[10] class="article-header">' . $titel . '</hREX_VALUE[10]>';
//}


// Link Button
/*( string ) $button = null;
if( 'REX_LINK_ID[1]' != '' || 'REX_VALUE[15]') {

    ( string ) $url = null;
    ( string ) $urlText = null;
    ( string ) $class = 'article-button';
    ( string ) $target = null;

    switch ( $floating ) {

        case ( $floating == 'colLeft' ||  $floating == 'left'): $class .= '--left'; break;
        case ( $floating == 'colRight' ||  $floating == 'right'): $class .= '--right'; break;
    }

    if( 'REX_LINK_ID[1]' !== '' ) {
        $art = OOArticle::getArticleById( 'REX_LINK_ID[1]' );

        if( $art instanceof OOArticle ) {

            $url = $art->getUrl();
            $urlText = $art->getName();
        }
    }

    if( 'REX_VALUE[15]' !== '' ) {
        $target = 'target="_blank" ';
        $url = 'REX_VALUE[15]';

        if( substr( $url, 0, 4) != 'http' ) {
            $url = 'http://' . $url;
        }

    }

    if( 'REX_VALUE[16]' != '' ) {
        $urlText = 'REX_VALUE[16]';
    }

    $button = '<a href="'.$url.'" class="'.$class.' button" '.$target.'>'.$urlText.'</a>';


    if( in_array( $floating, array( 'left', 'right', 'colLeft', 'colRight' ) ) ){
        $result .= $button;
    }

} */




$result .= '<section class="article-content">';

// the content without first image
if ( trim( $wysiwigvalue ) != '' ) $result .= $wysiwigvalue;

// andere bilder anzeigen
if ( count( $imgTags ) > 1 && in_array( $floating, array( null, 'center', 'left', 'right' ) ) )
    $result .= implode(PHP_EOL, $imgTags );


// downloadlist anzeigen
if ( trim( 'REX_MEDIALIST[2]' ) != '' ) {

    $downloads = explode( ',', 'REX_MEDIALIST[2]' );

    if ( false == empty( $downloads ) ) {

        $result .= '<h3 class="download-header">Downloads</h3>';
        $result .= '<ul class="article-download">';

        foreach ( $downloads as $file ) {

            if ( $media = OOMedia::getMediaByFilename( $file ) ) {

                $type = explode( "/", $media->getType() );
                $result .= '<li><a href="' . $REX['SERVER'] . substr( $media->getFullPath(), 0 ) . '" class="article-downloadlink" target="_blank">'
                    . '<img src="'.$media->getIcon().'" width="32" height="32" alt="'.$media->getType().'" />' //'<i class="icon-' . $type[1] . '"></i>'
                    . ( $media->getTitle() != '' ? $media->getTitle() : $file ) . '</a>'
                    . ( $media->getDescription() != '' ? '<p class="article-downloaddescription">' . $media->getDescription() . '</p>' : null )
                    . '</li>';
            }
        }
        $result .= '</ul>';
    }
}

if( !in_array( $floating, array( 'left', 'right', 'colLeft', 'colRight' ) ) && $button !== null ){
        $result .= $button;
}

$result .= '</section></article>';

if( "REX_TEMPLATE_ID" == '1' ) {
    $result = '<div class="tab-content">' . $result . '</div>';
}

print( $result );

unset( $imgFiles, $imgTags, $imgTag );
?>