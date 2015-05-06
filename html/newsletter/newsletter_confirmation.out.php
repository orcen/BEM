<?php

/**
 * @author Advance Media
 * @copyright 2015
**/

    ( object ) $sql = rex_sql::factory( );

    $sql->debugsql = false;

    if( $email = rex_request( 'email', 'string' ) ) {

        if( filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {

            $sql->setTable( 'rex_newsletter' );
            $sql->setWhere( 'email = "' . $email . '"');
            $sql->select( '`id`, `status`' );

            if( $sql->getRows() == 1 ) {

                $sql->setTable( 'rex_newsletter' );
                $sql->setWhere( '`id` = ' . $sql->getValue( 'id' ) );

                if( ( ( bool ) $status = rex_request( 'status', 'bool' ) ) == 1 && $sql->getValue( 'status' ) == 0 ) {

                    $sql->setValue( 'status', 1 );
                    if( $sql->update() ) {
                        print '<article class="article grid_12">'
                            . '<h2 class="article-header">' . 'REX_VALUE[1]' . '</h2>'
                            . '<section class="article-content">' . 'REX_HTML_VALUE[2]' . '</section>'
                            . '</article>';
                    }
                }
                elseif( $status == 0 && $sql->getValue( 'status' ) == 1 ) {

                    $sql->setValue( 'status', 0 );

                    if( $sql->update() ) {
                        print '<article class="article grid_12">'
                            . '<h2 class="article-header">' . 'REX_VALUE[3]' . '</h2>'
                            . '<section class="article-content">' . 'REX_HTML_VALUE[4]' . '</section>'
                            . '</article>';
                    }
                }


            }
        }
    }

?>