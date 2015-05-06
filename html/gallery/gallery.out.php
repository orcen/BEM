<?php

/**
 * @author Advance Media
 * @copyright 2015
**/

( string ) $list = 'REX_MEDIALIST[1]';
( string ) $result = '';

if( $list != '' ) {

    ( array ) $imgList = explode( ',', $list );

    if( count( $imgList ) > 0 ) {

        echo '<section class="gallery grid_sm_12 grid_md_6 grid_12">';


        if( 'REX_VALUE[1]' != '' ) {
            echo '<h3 class="gallery-heading">' . 'REX_VALUE[1]' . '</h3>';
        }

        if( 'REX_VALUE[2]' != '' ) {
            echo '<div class="gallery-description">' . 'REX_HTML_VALUE[2]' . '</div>';
        }


        for( $i = 0; $i < count( $imgList ); $i++ ) {

            ( object ) $img = OOMedia::getMediaByFileName( $imgList[$i] );

            if( $img instanceof OOMedia && $img->isImage() ) {

                $imgCache = rex_image_manager::getImageCache( $img->getFilename(), 'gallery' );

                ( int ) $ih = $imgCache->getHeight(); // Höhe
                ( int ) $iw = $imgCache->getWidth();

                ( string ) $class = ' grid_sm_12 grid_md_3 grid_3';

                //if( $i < 2 ) {
//                    $class = 'grid_xl_6 grid_6 grid_md_6 grid_sm_6';
//                }

                $result .= '<figure class="gallery-item ' . $class . '">'
                    . '<a href="'.seo42::getImageManagerFile( $img->getFilename(), 'gallery_popup' ).'" class="gallery-link js-fancybox" data-fancybox-group="gal-'.'REX_SLICE_ID'.'" title="'.$img->getTitle().'">'
                    . '<img class="gallery-image" src="'.seo42::getImageManagerFile( $img->getFilename(), 'gallery' ).'" alt="'.$img->getTitle().'" width="'.$iw.'" height="'.$ih.'" />';

                if( $img->getTitle() != '' || $img->getDescription() != '' ) {

                    $result .= '<figcaption class="gallery-caption"><div>'
                        . ( $img->getTitle() != '' ? $img->getTitle() . '<br />' : null )
                        . ( $img->getDescription() != '' ? $img->getDescription() : null )
                        . '</div></figcaption>';
                }

                $result .= '</a>' . '</figure>';
            }
        }

        echo $result;

        echo '</section>';
    }
}

?>