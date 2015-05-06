<?php

( bool ) $debug = 0;  // 1 = Ja, 0 = Nein

// No Changes on the Code below

( int )    $limit = intval( 'REX_VALUE[1]' );
( object ) $sql = rex_sql::factory( );
( string ) $terms = null;
( array )  $tmpl = array(
                      'titleWithLink' => '<h2 class="eventlist-header"><a href="%s" class="eventlist-headerlink">%s</a></h2>',
                      'title' => '<h2 class="eventlist-header">%s</h2>',
                      'dateTime' => '%A, den %d. %B %Y um %H:%M',
                      'time' => '%A, %d. %B %Y'
                    );
( bool ) $showImages = ('REX_VALUE[6]' == 1 ? true : false );

( string ) $listHeader = ( ( $title = 'REX_VALUE[5]' ) != null ? $title : 'Termine' );

$sql->debugsql = $debug;

$sql->setTable( $REX[ 'TABLE_PREFIX' ] . 'calendar' );

$sql->setWhere( '1 AND `datum` > NOW() ORDER BY datum ASC LIMIT 0,' . $limit );

$sql->select( 'UNIX_TIMESTAMP(`datum`) AS `datum`, `name`, `link`, `link_text`, `image`, `ganztags`' );


if( ( $rows = $sql->getRows( ) ) > 0 ) {
 
  $cnt = 0;
  $article = '<div class="eventlist grid_xs_12">'      
      . ( ( (int)$urlId = 'REX_LINK_ID[1]' ) != null ? 
         sprintf( $tmpl['titleWithLink'], rex_getUrl( $urlId, 'REX_CLANG_ID' ) , $listHeader ) : 
         sprintf( $tmpl['title'], $listHeader )
         )
      . PHP_EOL;
      
  for( $i = 0; $i < $rows; $i++ ) {   
      
    if( ( $name = $sql->getValue( 'name' ) ) != ''  ) {

      $article .= '<div class="event small">';
      //$datum = strtotime($sql->getValue('datum') );
       
      $article .= '<span class="event-date">'
        . strftime( ( $sql->getValue( 'ganztags' ) == 1 ? $tmpl['date'] : $tmpl['dateTime'] ), $sql->getValue('datum') ) 
        . '</span>'
        . '<h3 class="event-name">' 
        . $name 
        . '</h3>';
      
      if( ( $imgFile = $sql->getValue( 'image' ) ) != '' && $showImages ) {

        $img = OOMedia::getMediaByFileName( $imgFile );
        
        if( $img instanceof OOMedia  ) {

          ( object ) $rex_image = rex_image_manager::getImageCache( $img->getFilename(), 'event-image' );

          ( int ) $ih = $rex_image->getHeight(); // Image Height
          ( int ) $iw = $rex_image->getWidth();  // Image Width

          $article .= '<picture class="event-picture">'
            . '<img src="' . seo42::getImageManagerFile( $img->getFilename(), 'event-image' ) . '"'
            . ' alt="' . $img->getTitle() . '" width="' . $iw . '" height="' . $ih . '" />'
            . '</picture>';
        }
      }

      $article .= '</div>';
    }
    $sql->next();    
  }

  $article .= '</div>';
  echo $article;   
}

?>