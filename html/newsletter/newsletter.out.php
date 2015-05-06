<?php

/*
 *  Newsletter Module
 *  Author: @orcen
 *
 */
    ( string ) $heading = '<h2 class="article-header">' . 'REX_VALUE[10]' . '</h2>';

    ( string ) $infoText = 'REX_HTML_VALUE[11]';

    ( string ) $succesText = '<div>'
        . '<h3>' . 'REX_VALUE[1]' . '</h3>'
            . 'REX_HTML_VALUE[2]'
        . '</div>';
    ( string ) $btnText = ( 'REX_VALUE[4]' ? 'REX_VALUE[4]' : 'Newsletter abonnieren');

    ( object ) $xform = new rex_xform( );

    $xform->setObjectparams ( 'form_skin', 'amform' );
    $xform->setObjectparams ( 'form_showformafterupdate', 0 );
    $xform->setObjectparams ( 'real_field_names', true );
    $xform->setObjectparams ( 'form_class', 'rex-xform newsletter' );
    $xform->setObjectparams ( 'form_action', rex_getUrl( $REX['ARTICLE_ID'] ) );


    $xform->setValueField ( 'text', array( 'email', 'Email' ) );
    $xform->setValueField ( 'hidden', array( 'status', '0' ) );
    $xform->setValueField ( 'hidden', array( 'link', rex_getUrl( 'REX_LINK_ID[1]' ) , null, 'no_db' ) );
    $xform->setValueField ( 'submit', array( 'send', $btnText ) );

    $xform->setValidateField ( 'email', array( 'email', 'Die eingegebene Email ist nicht korrekt!' ) );
    $xform->setValidateField ( 'unique', array( 'email', 'Diese Email ist bereits im System.', 'rex_newsletter' ) );

    $xform->setActionField( 'db2email', array( 'newsletter', 'email' ) );

    if( ( ( string ) $email = 'REX_VALUE[3]' ) != null ) {

        if( filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            $xform->setActionField( 'db2email', array( 'newsletter', 'Neue Newsletter Anmeldung', $email ) );
        }
    }

    $xform->setActionField( 'db', array( 'rex_newsletter' ) );

    ( string ) $formResult = $xform->getForm();

    echo '<article class="article newsletter grid_8 push_2">'
            . $heading
            . '<section class="article-content">'
                . ( $xform->objparams['postactions_executed'] ? $succesText : $infoText )
                . $formResult
            . '</section>'
        . '</article>';

?>