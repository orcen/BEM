<div class="tabs">
    <input type="radio" name="ctrl" class="ctrlparts" id="ctrlLokal" checked />
    <input type="radio" name="ctrl" class="ctrlparts" id="ctrlView" />


    <label class="ctrlparts-lab" id="ctrlLokal-lab" for="ctrlLokal">
        Video
    </label>
    <label class="ctrlparts-lab" id="ctrlView-lab" for="ctrlView">
        Anzeige
    </label>


    <div class="tab" id="lokal">
        <h3>Video</h3>
        <label>Videodatei</label><br />
        REX_MEDIA_BUTTON[1]<br />
        <br />
        <label for="autoplay"><input type="checkbox" name="VALUE[11]" value="1" id="autoplay" <?=('REX_VALUE[11]' == 1 ? 'checked' : null);?> /> Autoplay</label><br />
    </div>

    <div class="tab" id="view"> <!-- Anzeige Tab -->

        <h3>Breite in Spalten</h3>
        <?
        $sizes = rex_var::toArray('REX_VALUE[20]');
        $list = array(
            //'XS'=> array( 6 => '1/2', 12 => '4/4' ),
            'SM'=> array( 6 => '1/2', 12 => '4/4' ),
            'MD'=> array( 3 => '1/4', 4 => '1/3', 6 => '1/2', 8 => '2/3', 9 => '3/4', 12 => '4/4' ),
            'L' => array( 3 => '1/4', 4 => '1/3', 6 => '1/2', 8 => '2/3', 9 => '3/4', 12 => '4/4' ),
            //'XL'=> array( 3 => '1/4', 4 => '1/3', 6 => '1/2', 8 => '2/3', 9 => '3/4', 12 => '4/4' )
        );
        $labels = array(
            'XS'=> 'Alte Smartphones',
            'SM'=> 'Smartphones',
            'MD'=> 'Tablets',
            'L' => 'Notebook',
            'XL'=> 'Desktop'
        );

        foreach( $list as $bp=>$sz ) {

            echo '<label class="grid-label '.( $sizes[$bp] == '' ? 'is-disabled' : null).'">'. $labels[$bp] .'<br />';
            echo '<select name="VALUE[20]['.$bp.']" style="width: 120px; text-align: center;">';
            if( $bp != 'XS' ) {
                echo '<option value="">Nicht angegeben</option>';
            }
                foreach( $sz as $w => $label ) {
                    $val = 'grid_'.strtolower($bp).'_'.$w;
                    echo '<option value="'.$val.'" ' . ($val == $sizes[$bp] ? 'selected' : null ).'>'.$label.'</option>';
                }
            echo '</select>' . '</label>';
        }

        //echo '<button onclick="alert(\"\Wähle Bildschirm grösse");">+</button>';

        ?>
        <p class="hilfe"><small>Die Höchste angegebene Breite wird für alle weiteren Bildschirm Grössen übernommen.<br />
        Beispiele:
        <ol>
            <li><strong>"Altes Smartphone"</strong> ist auf <strong>4/4</strong> gesetzt.<br />
        Dadurch erscheint dieser Block <strong>bei jeder Bildschirm grösse</strong> in der Breite <strong>4/4</strong>.</li>
            <li><strong>"Altes Smartphone"</strong> ist auf <strong>4/4</strong> gesetzt, und <strong>"Tablet"</strong> auf <strong>1/2</strong>.<br />
            Dadurch ist der Block <strong>bis zur Tablet grösse</strong> auf die <strong>volle Breite</strong> und beim <strong>Tablet, Desktop, und XL Desktop</strong> auf die <strong>hälfte der Breite</strong>.</li>
        </ol>
        <br />
        <strong>"Nicht angegeben"</strong> bedeutet das die Vorherige Breite übernommen wird.
        </small>
        </p>

    </div>

</div>

<style type="text/css">.tabs{position:relative}.tabs .tab{display:none;min-height:15em;border-top:0.2em solid rgb( 35,155,210 );padding-top: 2em}.tabs .ctrlparts{position:absolute;top:0;left:0;opacity:0;margin:0;padding:0;border:0;width:0;height:0}.ctrlparts-lab.ctrlparts-lab.ctrlparts-lab.ctrlparts-lab{display:inline-block !important;padding:0.4em 1em;background-color:#EEE;color:#333;border-radius:0.2em 0.2em 0 0; cursor:pointer}small{color: #666;}

fieldset {
    border-bottom: 1px solid currentColor:
}

#ctrlLokal:checked ~#ctrlLokal-lab,
#ctrlYoutube:checked ~#ctrlYoutube-lab,
#ctrlView:checked ~#ctrlView-lab {background-color:rgb( 35,155,210 ); color:#FFF; padding:0.4em 1.2em}

#ctrlView:checked ~#view,
#ctrlLokal:checked ~#lokal,
#ctrlYoutube:checked ~ #youtube {display:block}


table td {
    padding: 0 1em;
}

.grid-label{float: left !important; text-align: center; margin:0 5px;}
/*.grid-label.is-disabled{opacity: 0.2}*/
</style>