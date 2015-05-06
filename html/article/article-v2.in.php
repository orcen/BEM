<div class="tabs">
    <input type="radio" name="ctrl" class="ctrlparts" id="ctrlText" checked />
    <input type="radio" name="ctrl" class="ctrlparts" id="ctrlImage"  />
    <input type="radio" name="ctrl" class="ctrlparts" id="ctrlDownload" />
    <input type="radio" name="ctrl" class="ctrlparts" id="ctrlOther" />
    <input type="radio" name="ctrl" class="ctrlparts" id="ctrlView" />


    <label class="ctrlparts-lab" id="ctrlText-lab" for="ctrlText">
        Texte
    </label>
    <label class="ctrlparts-lab" id="ctrlImage-lab" for="ctrlImage">
        Bilder
    </label>
    <label class="ctrlparts-lab" id="ctrlDownload-lab" for="ctrlDownload">
        Downloads
    </label>
    <label class="ctrlparts-lab" id="ctrlView-lab" for="ctrlView">
        Anzeige
    </label>





    <div class="tab" id="text"> <!-- Texte Tab -->

        <h2>Texte</h2>
        <label>Überschrift</label><br />
        <input name="VALUE[7]" type='text' value='REX_VALUE[7]' size='40' />
        <label>Ebene</label>
        <select name="VALUE[10]">
            <option value='1' <?php echo 'REX_VALUE[10]'=='1'?'selected':'';?>>H1</option>
            <option value='2' <?php echo 'REX_VALUE[10]'=='2'?'selected':'';?>>H2</option>
            <option value='3' <?php echo 'REX_VALUE[10]'=='3'?'selected':'';?>>H3</option>
            <option value='4' <?php echo 'REX_VALUE[10]'=='4'?'selected':'';?>>H4</option>
        </select>&nbsp;&nbsp;<label>Als Ribbon <input type="checkbox" name="VALUE[11]" value="1" <?=( 'REX_VALUE[11]' == '1' ? 'checked' : null );?> /></label><br />

        <br />

        <label>Überschriftbild</label><br />
        REX_MEDIA_BUTTON[2]<br />
        <small>Das wird als ersatz für die Überschrift angezeigt. Die Textüberschrift sollte aber auch gesetzt sein</small>
        <br />

        <label>Fliesstext:</label><br />
        <textarea name="VALUE[3]" class="tinyMCEEditor-table" style="width:100%; height:400px;">REX_VALUE[3]</textarea><br />

    </div>

    <div class="tab" id="images"> <!-- Bilder Tab -->

        <label>Bild Dateien:</label><br />
        REX_MEDIALIST_BUTTON[1]<br />
        <br />
        <label>Bild Grösse</label><br />
        <select name="VALUE[6]">
<?php
        for($i=100; $i<=500; $i=$i+100 ) echo '<option value="'.$i.'"'.('REX_VALUE[6]' == $i ? ' selected="selected"' : null).'>'.$i.'</option>';

?>
        </select><br />
        <label>Bild position</label><br />
        <select name="VALUE[5]">
            <option value='null' <?php echo 'REX_VALUE[5]' == 'null' ? 'selected' : '' ;?>>Normal</option>

            <optgroup label="Einzel Bild">
            <option value='left' <?php echo 'REX_VALUE[5]' == 'left' ? 'selected' : '' ;?>>Links</option>
            <option value='right' <?php echo 'REX_VALUE[5]' == 'right' ? 'selected' : '' ;?>>Rechts</option>
            </optgroup>
            <optgroup label="Mehrere Bilder">
            <option value="colLeft" <?php echo 'REX_VALUE[5]' =='colLeft' ? 'selected' : '' ;?>>Linke Spalte</option>
            <option value="colRight" <?php echo 'REX_VALUE[5]' == 'colRight' ? 'selected' : '' ;?>>Rechte Spalte</option>
            </optgroup>
        </select><br />
        <br />
        <label><input name="VALUE[8]" type="checkbox" value="1" <?php echo 'REX_VALUE[8]' == '1' ? 'checked' : '' ;?> />&Tab;Bildunterschriftanzeigen</label><br />
        <br />
        <label><input name="VALUE[9]" type='checkbox' value='1' <?php echo 'REX_VALUE[9]' == '1' ? 'checked' : '' ;?>/>&Tab;Bildlink zum vergrössern</label><br />
        <br />

    </div>

    <div class="tab" id="downloads"> <!-- Downloads Tab -->
        <h2>Downloads</h2>
        <label>Download Dateien:</label><br />
        REX_MEDIALIST_BUTTON[2]<br />

    </div>

    <div class="tab" id="view"> <!-- Anzeige Tab -->

        <h3>Breite in Spalten</h3>
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

#ctrlView:checked ~#ctrlView-lab,
#ctrlText:checked ~#ctrlText-lab,
#ctrlImage:checked ~#ctrlImage-lab,
#ctrlOther:checked ~#ctrlOther-lab,
#ctrlDownload:checked ~#ctrlDownload-lab {background-color:rgb( 35,155,210 ); color:#FFF; padding:0.4em 1.2em}

#ctrlView:checked ~#view,
#ctrlText:checked ~#text,
#ctrlImage:checked ~ #images,
#ctrlOther:checked ~ #other,
#ctrlDownload:checked ~ #downloads {display:block}


table td {
    padding: 0 1em;
}

.grid-label{float: left !important; text-align: center; margin:0 5px;}
/*.grid-label.is-disabled{opacity: 0.2}*/
</style>