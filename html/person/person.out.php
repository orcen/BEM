<?php

/**
 * @author Advance Media
 * @copyright 2014
 */

if( !function_exists('encode_email_address') ) {
    function encode_email_address( $email ) {
         $output = '';
         for ($i = 0; $i < strlen($email); $i++) {
              $output .= '&#'.ord($email[$i]).';';
         }
         return $output;
    }
}

if( 'REX_VALUE[1]' == 'none' )
    break;


(string) $result = '';

$sql = rex_sql::factory();
$sql->debug = true;
$sql->setTable( $REX['TABLE_PREFIX'] . 'personal' );
$sql->setWhere( '1 AND `status` = 1 ORDER BY `prio`' );

$sql->select( '`id`, `name`, `surname`, `rank`,`description`, `telefon`, `telefax`,`email`, `image`' );

if( $sql->getRows() > 0 ) {

    for( $i=0; $i< $sql->getRows(); $i++ ) {

        $person = '<div class="person grid_xs_12 grid_sm_6 grid_md_3 clearfix">';

        (object) $image = OOMedia::getMediaByFileName( $sql->getValue('image') );

        if( $image instanceof OOMedia && $image->isImage() ) {

            $person .= '<figure class="person-image_wrap js-eqHeight"><img src="' . seo42::getImageManagerFile( $image->getFilename(), 'personal_big' ) . '" alt="'.$image->getTitle().'" class="person-image" /></figure>';
        }

        $person .= '<div class="person-rank">'. $sql->getValue('rank') . '</div>';
        $person .= '<div class="person-name"><strong>'. $sql->getValue('name') . ' ' . $sql->getValue('surname') . '</strong></div>';

        $person .= '<div class="person-info">';
            $person .= '<div class="description">'. $sql->getValue('description') .'</div>';
            $person .= '<p class="person-tel icon-phone"><strong>Tel: </strong>' . $sql->getValue('telefon') . '</p>';
            $person .= '<p class="person-fax icon-print"><strong>Fax: </strong>' . $sql->getValue('telefax') . '</p>';
            $person .= '<p class="person-email icon-email"><strong>Email: </strong><a href="' . encode_email_address( 'mailto:' . $sql->getValue('email') ) . '">' . str_replace( '@', ' (at) ', $sql->getValue('email') ) . '</a></p>';
        $person .= '</div>'
                . '</div>';

        $result .= $person;

        $sql->next();
    }

}

if( $result != '' ) {
    print $result;
}
?>