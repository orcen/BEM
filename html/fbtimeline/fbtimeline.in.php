<div class="tabs">
    <input type="radio" name="ctrl" class="ctrlparts" id="ctrlView" <?=('REX_VALUE[3]' != '' ? 'checked' : null );?> />
    <input type="radio" name="ctrl" class="ctrlparts" id="ctrlConnection"  <?=('REX_VALUE[3]' == '' ? 'checked' : null );?> />

    <label class="ctrlparts-lab" id="ctrlView-lab" for="ctrlView">
        Anzeige
    </label>
    <label class="ctrlparts-lab" id="ctrlConnection-lab" for="ctrlConnection">
        Verbindung
    </label>

<!--
   Darstellungeinstellungen

   Überschrift: Spricht für sich selber
   Timelinebutton text: Text für den Button am Ende der Liste
   Breite in Spalten: Das Grid System des Templates. Normalerweise ein 12er Grid.
                      Falls andere genutzt wird, muss es im Modul angepasst werden.
                      Eine Breite je Breakpoint!!
  Als einzelne Blöcke Anzeigen: Der Parent Block bekommt keinen Grid eingestellt,
                                stattdesen bekommen die Einstellungen die einzelnen
                                Artikel. Dadurch wird die Komplette Parent fläche genutzt.
  Kommentare anzeigen: Spricht für Sich. Bei Default abgestellt.
  Anzahl der Einträge: Bei 0 zeigt es alle an (maximal 500).

  TODO:
  Nur ausgewählte Typen anzeigen: Per Select Box kann man nur bestimmte Eintragstypen anzeigen (Photo, Status, Link, Video)

-->

<div class="tab" id="view">

    <label>Block Überschrift</label><br />
    <input type="text" size="60" name="VALUE[10]" value="REX_VALUE[10]" /><br />
    <br />
    <label>Timelinebutton Text</label><br />
    <input type="text" size="30" name="VALUE[11]" value="REX_VALUE[11]" /><br />
    <br />

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
    <br />
    <br />

    <label>Einträge als einzelne Blöcke Anzeigen <input type="checkbox" name="VALUE[12]" value="1" <?=('REX_VALUE[12]' == 1 ? 'checked' : null );?> /></label><br />
    <small>Falls Ja, wird die Spalten Breite für die einzelnen Einträge genommen.</small>
    <br />
    <br />

    <label>Kommentare anzeigen <input type="checkbox" name="VALUE[6]" value="1" <?=('REX_VALUE[6]' == 1 ? 'checked' : null);?> /></label><br /><small>(Ja/Nein)</small>
    <br />

    <br />
    <label>Anzahl der Einträge</label><br />
    <select name="VALUE[5]">
      <option <?php echo 'REX_VALUE[5]' ==  0 ? 'selected' : null;?>>0</option>
      <option <?php echo 'REX_VALUE[5]' ==  1 ? 'selected' : null;?>>1</option>
      <option <?php echo 'REX_VALUE[5]' ==  2 ? 'selected' : null;?>>2</option>
      <option <?php echo 'REX_VALUE[5]' ==  3 ? 'selected' : null;?>>3</option>
      <option <?php echo 'REX_VALUE[5]' ==  4 ? 'selected' : null;?>>4</option>
      <option <?php echo 'REX_VALUE[5]' ==  5 ? 'selected' : null;?>>5</option>
      <option <?php echo 'REX_VALUE[5]' == 10 ? 'selected' : null;?>>10</option>
      <option <?php echo 'REX_VALUE[5]' == 25 ? 'selected' : null;?>>25</option>
      <option <?php echo 'REX_VALUE[5]' == 50 ? 'selected' : null;?>>50</option>
    </select><br />
    <small>0 = alle</small><br />
    <br />

    <label>Eintragsart:</label><br />
    <select name="VALUE[7]">
        <option <?=( 'REX_VALUE[7]' == 'all' ? 'selected' : null );?> value="all">Alle</option>
        <option <?=( 'REX_VALUE[7]' == 'photo' ? 'selected' : null );?> value="photo">Fotos</option>
        <option <?=( 'REX_VALUE[7]' == 'status' ? 'selected' : null );?> value="status">Status</option>
        <option <?=( 'REX_VALUE[7]' == 'link' ? 'selected' : null );?> value="link">Links</option>
        <option <?=( 'REX_VALUE[7]' == 'video' ? 'selected' : null );?> value="video">Videos</option>
    </select>

</div>

<!--
    Facebook Verbindung
    App Id: es muss eine App bei Facebook erstellt werden, welche dann genutzt wird.
    App Secret: Sicherheits schlüssel der App
    Page ID: Id der Seite, von wo wir die News wollen
-->
<div class="tab" id="connection">

    <label>Facebook App ID</label><br />
    <input type="text" name="VALUE[1]" value="REX_VALUE[1]" size="60" /><br />
    <label>Facebook App Secret</label><br />
    <input type="password" name="VALUE[2]" value="REX_VALUE[2]" size="60" /><br />
    <label>Facebook Page ID</label><br />
    <input type="text" name="VALUE[3]" value="REX_VALUE[3]" size="60" />


    <br />
</div>
<style type="text/css">.tabs{position:relative}.tabs .tab{display:none;min-height:15em;border-top:0.2em solid rgb( 35,155,210 );padding-top: 2em}.tabs .ctrlparts{position:absolute;top:0;left:0;opacity:0;margin:0;padding:0;border:0;width:0;height:0}.ctrlparts-lab.ctrlparts-lab.ctrlparts-lab.ctrlparts-lab{display:inline-block !important;padding:0.4em 1em;background-color:#EEE;color:#333;border-radius:0.2em 0.2em 0 0}small{color: #666;}

#ctrlView:checked ~#ctrlView-lab,
#ctrlConnection:checked ~#ctrlConnection-lab,
#ctrlControls:checked ~#ctrlControls-lab {background-color:rgb( 35,155,210 ); color:#FFF; padding:0.4em 1.2em}

#ctrlView:checked ~#view {display:block}
#ctrlConnection:checked ~#connection {display:block}
#ctrlControls:checked ~ #controls {display:block}

.grid-label{float: left !important; text-align: center; margin:0 5px;}
</style>