<?php

/**
 * @author Advance Media
 * @copyright 2013
 */
 

( bool ) $debug = false;

/******************************************************************
        No Edit after this Point
*******************************************************************/


 if( false === function_exists( createMonthCal )  ) {

    function createMonthCal( $year, $month, $tClass = 'calender', $markedDays, $nav = false ) {

        ( string ) $today = mktime(0,0,0);
        
        ( string ) $result = '<table class="' . $tClass .'">';
        
        if( ( $pos = strpos( $tClass, ' ', 0) ) )
            $tClass = substr( $tClass, 0, $pos );

        ( array ) $tpl = array( 
                            'head-link' => '<a href="%s" class="' . $tClass . '-link">%s</a>',
                            'thead' => '<thead class="' . $tClass . '-head">%s</thead>',
                            'thead-frstrow' => '<tr><td class="' . $tClass . '-nav prev">%s</td><td colspan="5" class="' . $tClass . '-name">%s</td>'
                                . '<td class="' . $tClass . '-nav next">%s</td></tr>',
                            'col-weekday' => '<td class="' . $tClass . '-weekday">%s</td>',
                            'col-day' => '<td class="' . $tClass . '-day %2$s"><span data-item="%3$s">%1$s</span></td>',
                            'week-start' => '<tr class="' . $tClass . '-week">',
                            'week-end' => '</tr>'
                        );
        ( array ) $weekdays = array( 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So' );
        ( string ) $frstRow = '<tr><td colspan="7" class="month-name">'. strftime('%B %Y',strtotime($year.'-'.$month.'-1')) .'</td>';

        // navigation between months
        if( $nav ) {
            
            ( int ) $prevM = $month - 1;
            ( int ) $nextM = $month + 1;
            ( int ) $prevY = $year;
            ( int ) $nextY = $year;

            if( $month == 1 ) {

                $prevM = 12; 
                --$prevY;
            }
            elseif( $month == 12 ) {

                $nextM = 1;
                ++$nextY;  
            }
            
            ( string ) $prevLink = rex_getUrl( 'REX_ARTICLE_ID', 0, array( 'monat' => $prevY . '-' . $prevM ) );
            ( string ) $nextLink = rex_getUrl( 'REX_ARTICLE_ID', 0, array( 'monat' => $nextY . '-' . $nextM ) );

            ( string ) $frstRow = sprintf( 
                             $tpl['thead-frstrow'], 
                             sprintf($tpl['head-link'], $prevLink, '&laquo;'), 
                             strftime('%B %Y',strtotime($year.'-'.$month.'-1')) , 
                             sprintf( $tpl['head-link'], $nextLink ,'&raquo;') 
                        );  
        }
     
        
        $weekdaysRow = null; // weekdays row

        for( $d = 0; $d < 7; $d++ ) {

            $weekdaysRow .= sprintf( $tpl['col-weekday'], $weekdays[ $d ] );
        }

        $weekdaysRow = '<tr>' . $weekdaysRow . '</tr>' . PHP_EOL;
        
        $result .= sprintf( $tpl['thead'], $frstRow . $weekdaysRow );

        // wochentag vom ersten des monats. +1 damit die woche am montag anfängt
        ( int ) $startingWeekDay = date( 'w', mktime( 0, 0, 0, $month, 1, $year ) );

        ( int ) $weekDay = 1;

        if( $startingWeekDay == 0 )
            $startingWeekDay = 7;

        for( $d = 1; $d <= cal_days_in_month( CAL_GREGORIAN, $month, $year ); $d++ ) {

            ( int ) $tstamp = mktime( 0, 0, 0, $month, $d, $year );

            if( $d == 1 ) $result .= $tpl['week-start'];
        
            if( $startingWeekDay != 0 && $d == 1 ) {
                
                for( $wd = 1; $wd < $startingWeekDay; $wd++ ) {

                    $result .= sprintf( $tpl['col-day'], '&nbsp;', null, null );
                }

                $weekDay = $startingWeekDay;
            }

// echo strftime( '%c', $tstamp ) . ' = ' . $tstamp . '<br />'; 
            ( string ) $dayClass = trim( ( array_key_exists( $tstamp, $markedDays ) ? 'marked' : null )
                . '' . ( $tstamp == $today ? 'today' : null ) );


            $result .= sprintf( $tpl['col-day'], $d, $dayClass, ( array_key_exists( $tstamp, $markedDays ) ? $markedDays[$tstamp] : null ) );
            
            if( $weekDay == 7 ) {
                $weekDay = 0;
                $result .= $tpl['week-end'] . $tpl['week-start'];
            }

            $weekDay++;
        }

        $result .=  '</table>';
        
        return $result;
    }
} // Function createMonthCal end


( int ) $visibleItemsCount = intval( 'REX_VALUE[5]' );
( int ) $prevMonthsCount   = intval( 'REX_VALUE[10]' );
( int ) $nextMonthsCount   = intval( 'REX_VALUE[11]' );

( array ) $markedDays = array( );

( bool ) $gMap = ( 'REX_VALUE[15]' == 1 ? true : false );

( object ) $sql = rex_sql::factory( );

$sql->debugsql = $debug;

$sql->setTable( 'rex_calendar' );
$sql->setWhere( '1 ORDER BY `datum` ASC' );
$sql->select( '`id`, UNIX_TIMESTAMP( `datum` ) AS `datum`, UNIX_TIMESTAMP( DATE_FORMAT( `datum`, "%Y-%m-%d 00:00:00" ) ) AS `datum_tag`,'
             . ' `name`, `strasse`, `ort`, `plz`, `link`, `link_text`, `image`, `beschreibung`' );

( string ) $events = null;

( array ) $tpl = array( 
                       'img' => '<img src="%s" alt="%s" width="%d" height="%d" class="" />'
                       );

if( ( $rows = $sql->getRows() ) > 0 ) {

    $events .= '<div class="eventlist grid_xs_12 grid_md_8 pull_md_4 row">';
    $cnt = 0;

    for( $i = 0; $i < $rows; $i++ ) {

        ( int ) $datum = $sql->getValue( 'datum' );
        ( int ) $datumTag = $sql->getValue( 'datum_tag' );
        ( int ) $id = $sql->getValue( 'id' );
        ( string ) $imgTag = null;
        ( string ) $event = null;

        if( ( $image = $sql->getValue( 'image' ) ) != '' ) {

            ( object ) $img = OOMedia::getMediaByFileName($image);
            
            if( $img instanceof OOMedia && $img->isImage() ) {

                ( object ) $rex_image = rex_image_manager::getImageCache( $image, 'event-image');

                ( int ) $ih = $rex_image->getHeight( ); // Image Height
                ( int ) $iw = $rex_image->getWidth( );  // Image Width

                $imgTag = sprintf( $tpl[ 'img' ], seo42::getImageManagerFile( $image, 'event-image' ), $img->getTitle( ), $iw, $ih );
            }
        }


        ( string ) $link = null;
        ( bool )   $linkExtern = false;

        if( ( ( string ) $url = $sql->getValue( 'link' ) ) != null ) {

            ( string ) $linkText = ( $sql->getValue( 'link_text' ) != null ? $sql->getValue( 'link_text' ) : $sql->getValue( 'link' ) );

            if( false === strpos( $url, 'http' ) && false === strpos( $url, 'redaxo' ) ) {

                $url = 'http://' . $url;
            }

            if( false === strpos( $url , $REX['SERVER'], 0 ) && false === strpos( $url, 'redaxo' ) ) {
                $linkExtern = true;
            }

            $link = '<a href="' . $url . '" ' . ( $linkExtern ? 'target="_blank"' : null ) . ' class="button event-link">' . $linkText . '</a>';
        }

        ( string ) $address = '<div class="event-address ' . ( $gMap ? 'icon-direction' : null ) . '">' 
                . '<span class="event-street">' . $sql->getValue( 'strasse' ) . '</span><br />'
                . '<span class="event-city">' 
                    . $sql->getValue('plz') 
                    . ' '
                    . $sql->getValue('ort') 
                . '</span>'
            . '</div>';

        if( $gMap === true) {

            ( string ) $addressStr = $sql->getValue( 'strasse' ) . ', ' . $sql->getValue( 'plz' ) . ' ' . $sql->getValue( 'ort' );
            ( string ) $gMapUrl = 'http://maps.google.com/?q=' . urlencode( $addressStr );
            $address = '<a href="' . $gMapUrl . '" target="_blank">' . $address . '</a>';
        }

        $event = '<div class="event is-closed || grid_xs_12 grid_md_6" id="item-' . $sql->getValue('id') . '" data-item="' . $sql->getValue('id') . '">'
            . '<picture class="event-picture">' . $imgTag . '</picture>'
            . '<h3 class="event-name">' . $sql->getValue( 'name' ) . '</h3>'
            . '<span class="event-date">' . strftime( '%A, %e. %B %Y' ,  $datum ) . '</span>'
            . $address
            . '<div class="event-description">' . $sql->getValue('beschreibung') . '</div>'
            . $link
            . '</div>';

        if( $cnt < $visibleItemsCount  && $datum > time() ) 
            $cnt++;  

        if( isset( $markedDays[ $datumTag ] ) )
            $markedDays[ $datumTag ] .= ',' . $id;
        else
            $markedDays[ $datumTag ] = $id ;
        
        $sql->next();

        $events .= $event;
    
    } 

    // $events .= '<p class="grid_xs_12"><span id="showTerms">&gt; alle Termine anzeigen</span></p>';

    $events .= '</div><!-- Eventliste Ende -->' . PHP_EOL;  
}



( int ) $tstamp = time();
( int ) $month = date( 'm', $tstamp );
( int ) $year = date( 'Y', $tstamp );

if( (string ) $req_month = rex_request( 'monat' ) ) {

    list( $year, $month ) = explode( '-', $req_month );
    $tstamp = mktime( 0, 0, 0, $month, null, $year );
}    

( int ) $day = date( 'j', $tstamp );

( int ) $actMonth = intval( $month );
( int ) $actYear = intval( $year );


?>

<article class="article grid_xs_12 row clearfix">
<h2 class="article-header grid_xs_12">REX_VALUE[1]</h2>
<section class="calendar grid_xs_12 grid_md_4 push_md_8">
<?php

    ( int ) $month = $startMonth = $month - $prevMonthsCount;
    ( int ) $endMonth = $month + $nextMonthsCount + 1;
    ( int ) $year = $actYear;  
    ( int ) $monthCount = $prevMonthsCount + $nextMonthsCount + 1;    
    

    if( $monthCount == 1 ) {    

        echo createMonthCal( $year, $month, ( $month == $actMonth && $year == $actYear ? 'month actual': 'month'), $markedDays, true);
    }
    else {   
    
        for( $m = 0; $m < $monthCount; $m++ ) {
            if( $month < 1 ) {
                $month = $month + 12;
                --$year;
            }
            elseif( $month == 13 ) {
                $month = 1;
                ++$year;  
            }
            
            echo createMonthCal( $year, $month, ($month == $actMonth && $year == $actYear ? 'month actual': 'month'),$markedDays, ($month == $actMonth && $year == $actYear ? true : false ) );

            ++$month;
        }

    }
    
    echo '</section>';


    echo ( ( $anmerkung = trim( 'REX_VALUE[2]' ) ) != '' ? '<p>' . $anmerkung . '</p>' : null );
    
    echo $events; 

?>
</article>