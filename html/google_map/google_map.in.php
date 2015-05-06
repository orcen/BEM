<div class="tabs">

    <input type="radio" name="ctrl" class="ctrlparts" id="ctrlText" checked />
    <input type="radio" name="ctrl" class="ctrlparts" id="ctrlView"  />
    <input type="radio" name="ctrl" class="ctrlparts" id="ctrlHelp"  />

    <label class="ctrlparts-lab" id="ctrlText-lab" for="ctrlText">
        Adresse + Text
    </label>

    <label class="ctrlparts-lab" id="ctrlView-lab" for="ctrlView">
        Anzeige
    </label>
    <label class="ctrlparts-lab" id="ctrlHelp-lab" for="ctrlHelp">
        Hilfe
    </label>


    <div class="tab" id="text"> <!-- Texte Tab -->
        <label>Block Überschrift</label><br />
        <input type="text" name="VALUE[5]" value="REX_VALUE[5]" size="60" /><br />
        <br />

        <label>Name / Titel</label><br />
        <input type="text" size="60" name="VALUE[4]" value="REX_VALUE[4]" /><br />
        <br />
        <label>Strasse + Hausnr.</label><br />
        <input type="text" name="VALUE[1]" value="REX_VALUE[1]" size="70" /><br />
        <br />
        <label>Ort</label><br />
        <input type="text" name="VALUE[2]" value="REX_VALUE[2]" size="70" /><br />
        <br />
        <label>PLZ</label><br />
        <input type="text" name="VALUE[3]" value="REX_VALUE[3]" size="35" /><br />
        <br />
        <label>Land</label><br />
        <input type="text" name="VALUE[6]" value="<?=( 'REX_VALUE[6]' == null ? 'DE' : 'REX_VALUE[6]' );?>" size="70" />
    </div>

    <div class="tab" id="view"> <!-- Ansicht Tab -->
        <h3>Block Breite</h3><br />
        <?
        $sizes = rex_var::toArray('REX_VALUE[20]');
        $list = array(
            'XS'=> array( 6 => '1/2', 12 => '4/4' ),
            'SM'=> array( 6 => '1/2', 12 => '4/4' ),
            'MD'=> array( 3 => '1/4', 4 => '1/3', 6 => '1/2', 8 => '2/3', 9 => '3/4', 12 => '4/4' ),
            'L' => array( 3 => '1/4', 4 => '1/3', 6 => '1/2', 8 => '2/3', 9 => '3/4', 12 => '4/4' ),
            'XL'=> array( 3 => '1/4', 4 => '1/3', 6 => '1/2', 8 => '2/3', 9 => '3/4', 12 => '4/4' )
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
                foreach( $sz as $w=>$label ) {
                    $val = 'grid_'.strtolower($bp).'_'.$w;
                    echo '<option value="'.$val.'" ' . ($val == $sizes[$bp] ? 'selected' : null ).'>'.$label.'</option>';
                }
            echo '</select>' . '</label>';
        }
        ?>
        <br />
        <div class="clearer"></div>
        <br />
        <label>Höhe</label><br />
        <input type="number" name="VALUE[19]" value="REX_VALUE[19]" min="250" max="700" step="15"  />
    </div>

    <div class="tab" id="help"> <!-- Help Tab -->
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


<style type="text/css">
.tabs{position:relative}
.tabs .tab{display:none;min-height:15em;border-top:0.2em solid rgb( 35,155,210 );padding-top: 2em}
.tabs .ctrlparts{position:absolute;top:0;left:0;opacity:0;margin:0;padding:0;border:0;width:0;height:0}
.ctrlparts-lab.ctrlparts-lab.ctrlparts-lab.ctrlparts-lab{display:inline-block !important;padding:0.4em 1em;background-color:#EEE;color:#333;border-radius:0.2em 0.2em 0 0; cursor:pointer}

small{color: #666;}

fieldset {
    border-bottom: 1px solid currentColor:
}

#ctrlView:checked ~#ctrlView-lab,
#ctrlText:checked ~#ctrlText-lab,
#ctrlHelp:checked ~#ctrlHelp-lab {background-color:rgb( 35,155,210 ); color:#FFF; padding:0.4em 1.2em}

#ctrlView:checked ~#view,
#ctrlText:checked ~#text,
#ctrlHelp:checked ~ #help {display:block}

.grid-label{float: left !important; text-align: center; margin:0 5px;}
.clearer{clear: both; margin: 15px 0;}
</style>