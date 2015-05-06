<?php

(string) $pageID = 'REX_VALUE[3]';
( bool ) $saBoxes = ('REX_VALUE[12]' == '1' ? true : false);

( string ) $grid = str_replace( '  ', ' ', implode( ' ', rex_var::toArray( 'REX_VALUE[20]' ) ) );
$grid = str_replace( 'l_', '', $grid );

(string) $artType = 'REX_VALUE[7]';



if( false === function_exists( 'findLink' ) ) {

    function findLink ( $message ) {
        return preg_replace( '#(http(s)?:\/\/[a-z0-9\.\/?&-_=]*) ?#i', '<a href="$1">$1</a> ', $message );
    }
}


if ( false === function_exists( 'showStatus' ) ) {
    /**
     * showStatus()
     *
     * @param bool $data
     * @return
     */
    function showStatus( $data = false ) {

        $result = null;

        if ( $data ) {

            if ( isset( $data['story'] ) ) {
                $story = $data['story'];
                $story = findLink ( $story );
                $result .= '<p class="fba-text">' . $story . '</p>';
                return false;
            }
            elseif ( isset( $data['message'] ) ) {
                $message = $data['message'];
                $message = findLink ( $message );
                $result .= '<p class="fba-text">' . $message . '</p>';
            }
            return $result;
        }

        return false;
    }
}

if ( false === function_exists( 'showLink' ) ) {
    /**
     * showLink()
     *
     * @param bool $data
     * @return
     */
    function showLink( $data = false ) {
        (string) $result = null;

        if ( $data ) {

            $result .= '<span class="fba-date grid_sm_12">' . strftime( FBA_DATE, strtotime( $data['created_time'] ) ) . '</span>';

            if ( isset( $data['message'] ) ) {
                $message = $data['message'];
                $message = findLink ( $message );
                $result .= '<p class="fba-text">' . $message . '</p>';
            }
            $result .= '<blockquote class="fba-quote clearfix">'
                . ( isset( $data['picture'] ) ?
                    '<picture class="fba-quote_image"><a href="' . $data['link'] . '" target="_blank"><img src="' . $data['picture'] . '" /></a></picture>'
                    : null
                )
                . '<h5 class=""><a href="' . $data['link'] . '" target="_blank">' . $data['name'] . '</a>' . '</h5>'
                . ( isset( $data['caption'] ) ? '<small class="">' . $data['caption'] . '</small>' : null )
                . '<p class="fba-quotetext">'
                . ( strlen( $data['description'] ) > 100 ? substr( $data['description'], 0, strpos( $data['description'], ' ', 85 ) ) . ' ...' : $data['description'] )
                . '</p></blockquote> <!-- fba-quote -->' . PHP_EOL;

            return $result;
        }
        return false;
    }
}

if ( false === function_exists( 'showPhoto' ) ) {
    /**
     * showPhoto()
     *
     * @param bool $data
     * @return
     */
    function showPhoto( $data = false, $picture ) {

        ( string ) $result = null;

        if ( $data ) {

            if ( isset( $data['message'] ) || isset( $data['name']) ) {
                $message = (isset($data['name']) ? $data['name'] : null) . $data['message'];

                $message = findLink ( $message );

                $result .= '<p class="fba-text">' . $message . '</p>';
            }


            $result .= //'<h5 class="fba-name">'.$data['name'].'</h5>'
                 '<picture class="fba-image">'
                . '<a href="' . $data['link'] . '" target="_blank">'
                . '<img src="' . $picture['source']  . '" '
                . ' width="'.$picture['width'].'" height="'.$picture['height'].'" alt="'.$data['name'].'">'
                . '</a></picture>';
            return $result;
        }
        return false;
    }
}

if ( false === function_exists( 'showVideo' ) ) {
    /**
     * showVideo()
     *
     * @param bool $data
     * @return
     */
    function showVideo( $data = false ) {

        ( string ) $result = null;

        if ( $data ) {

            if ( isset( $data['message'] ) ) {
                $message = $data['message'];

                $message = findLink ( $message );

                $result .= '<p class="fba-text">' . $message . '</p>';
            }
            /**$result .= '<picture class="fba-image fba-image--video">'
                . '<a href="' . $data['link'] . '" target="_blank">'
                . '<img src="' . str_replace('s130x130', 's200x200', $data['picture']) . '" >'
                . '</a></picture> <!-- fba-image -->' . PHP_EOL;*/
            $result .= '<video class="fba-video" controls poster="'.str_replace('s130x130', 'o480x480', $data['picture']).'"><source src="'.$data['source'].'" type="video/mp4"></video>';
            return $result;
        }
        return false;
    }
}

if ( false == function_exists( 'getInfo' ) ) {
    /**
     * getInfo()
     *
     * Likes und Kommentare des Eitnrags
     * Global für alle Einträge gleich
     *
     * @param mixed $data - entry data
     * @param bool $comments - true shows comments, default false
     * @return
     */
    function getInfo( $data, $comments = false ) {
        $result .= '<div class="fba-info row">'
        . '<p class="fba-likes grid_xs_12 grid_md_6" title="Likes"><i class="icon-likes"></i> <strong>'
        . count( $data['likes']['data'] ) . ' Person' . ( count( $data['likes']['data'] ) != 1 ? 'en' : null )
        . '</strong> gefällt das</p>';

        if ( count( $data['comments']['data'] ) > 0 && $comments == true ) {

            ( int ) $i = 0; // comments counter
            $result .= '<div class="fba-comments grid_xs_12" title="Kommentare">';

            foreach ( $data['comments']['data'] as $comment ) {

                if ( $i == 2 ) // show just 3 comments
                         break;

                $comment = '<div class="fba-comment grid_xs_12 clearfix">'
                    . '<img src="https://graph.facebook.com/' . $comment['from']['id'] . '/picture" class="fba-avatar grid_xs_3" alt="' . $comment['from']['name'] . '" title="' . $comment['from']['name'] . '" />'
                    . '<p class="fba-message grid_xs_9"><strong>' . $comment['from']['name'] . '</strong> ' . $comment['message'] . '</p>'
                    . '<p class="grid_xs_12">am '. strftime('%d. %B %Y', strtotime( $comment['created_time'] ) )
                    . '<i class="icon-likes icon-likes--small"></i>'. $comment['like_count'].'</p>'
                    . '</div> <!-- fba-info -->' . PHP_EOL;

                $result .= $comment;

                $i++;
            }
            $result .= '</div> <!-- fba-comments -->' . PHP_EOL;
        }
        elseif( $comments == false) {
            $result .= '<p class="fba-comments" title="Kommentare"><i class="icon-comment"></i> ' . count( $data['comments']['data'] ) . ' Kommentar'.( count( $data['likes']['data'] ) != 1 ? null : 'e' ).'</p>';
        }

        $result .=   '</div> <!-- fba-info -->' . PHP_EOL;

        return $result;
    }
}

if ( false === function_exists( 'getLink' ) ) {
    /**
     * getLink()
     *
     * @param bool $id
     * @param bool $url
     * @return
     */
    function getLink( $id = false, $url = false ) {
        $link = null;
        if ( $id ) {
            $id = explode( '_', $id );
            if ( !$url ) $link = '<a href="https://www.facebook.com/permalink.php?story_fbid=' . $id[1] . '&id=' . $id[0] . '" target="_blank">Mehr ...</a>';
            else  $link = 'https://www.facebook.com/permalink.php?story_fbid=' . $id[1] . '&id=' . $id[0];
        }
        return $link;
    }
}

if ( OOAddon::isAvailable( 'facebook_sdk' ) ) {



    $fb = new Facebook( array(
        'appId' => '664341493609239',
        'secret' => '665d3ae1bba0891d03dfad0d2a364d8a',
        'locale' => 'de_DE' ) );



    Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
    Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;

    $params = array();

    ( int ) $limit = 1000;
    if ( intval( 'REX_VALUE[5]' ) > 0 ) $limit = intval( 'REX_VALUE[5]' );


    $params['limit'] = 20;

    while ( $limit > $params['limit'] ) {
        $params['limit'] += 10;
    }

    $pageInfo = $fb->api( '/' . $pageID );

    $data = $fb->api( '/' . $pageID . '/feed', 'GET', $params );

    if ( !$saBoxes ) {
        echo '<div class="fb '.$grid.'">'
            . '<h4 class="fb-header"><span>'
            . ( 'REX_VALUE[10]' != '' ? 'REX_VALUE[10]' : 'Aktuelles' ) . '</span></h4>'
            . '<div class="fb-list clearfix">';
    }
    else {
        echo '<h4 class="fb-header grid_sm_12"><span>'
            . ( 'REX_VALUE[10]' != '' ? 'REX_VALUE[10]' : 'Aktuelles' ) . '</span></h4>';
    }
    //Auskommentieren um die Kontrolle per Modul zu erlangen
    //(string) $grid = 'grid_sm_6 grid_md_12 grid_12 grid_xl_12';
//    $saBoxes = true;

    $i = 0;
    foreach ( $data['data'] as $entry ) {

        if ( $i >= $limit ) break;

        if ( $entry['from']['id'] == $pageID &&  false === isset( $data['story'] ) ) {

            $result = false;
            unset( $entry['story'] );

            switch ( $entry['type'] ) {
                case 'photo':
                    if( $artType == 'all' || $artType == 'photo' ){
                        $picture = array();
                        if( isset( $entry['object_id']) ) {
                            $picture = $fb->api( '/' . $entry['object_id'] . '', 'GET' );
                            $result = showPhoto( $entry, $picture );
                        }
                    }
                    break;
                case 'event':
                case 'status':
                    if( $artType == 'all' || $artType == 'status' ) $result = showStatus( $entry);
                    break;
                case 'link':
                    if( $artType == 'all' || $artType == 'link' ) $result = showLink( $entry );
                    break;
                case 'video':
                    if( $artType == 'all' || $artType == 'video' ) $result = showVideo( $entry );
                    break;
                default:
                    $result = false;

            }

            if( $result != false ) {
                print '<div class="fba '.( $saBoxes ? $grid : null ).'" data-masonry="true" data-type="'.$entry['type'].'" data-id="'.$entry['id'].'">'
                    . '<span class="fba-date grid_sm_12">' . strftime( '%d. %B %Y %R', strtotime( $entry['created_time'] ) ) . '</span>'
                    . $result
                    . getInfo( $entry, 'REX_VALUE[6]' )
                    . '</div><!-- fba -->' . PHP_EOL;
                $i++;
            }
        }

    }

    //Auskommentieren um die Kontrolle per Modul zu erlangen
    //$saBoxes = false;

    if ( !$saBoxes ) {
        echo '</div> <!-- fb-list -->'
        . '<a href="' . $pageInfo['link'] . '" target="_blank" class="button_link"> ' . ( 'REX_VALUE[11]' == '' ? 'Unsere Timeline' : 'REX_VALUE[11]' ) . '</a>'
        . '</div> <!-- fb -->';
    }
    else {
        echo '<a href="' . $pageInfo['link'] . '" target="_blank" class="button_link"> ' . ( 'REX_VALUE[11]' == '' ? 'Unsere Timeline' : 'REX_VALUE[11]' ) . '</a>';
    }
    /*else {
        echo '<a href="' . $pageInfo['link'] . '" target="_blank" class="button '.$grid.'"  data-masonry="true">[[svgSprite#facebook]] ' . ( 'REX_VALUE[11]' == '' ? 'Unsere Timeline' : 'REX_VALUE[11]' ) . '</a>';
    }  */

    $fb->destroySession();
}
else {
    echo "Das AddOn 'Facebook_sdk' ist nicht installiert!";
}
?>