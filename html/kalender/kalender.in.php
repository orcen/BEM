<p>
  <label>Termine Anzahl</label><br />
  <input type='text' name='VALUE[5]' value='REX_VALUE[5]' size="60" /> <br />
</p>

<p>Es wird immer der Aktuellemonat angezeigt + vergangene oder bevorstehende Monate je nach einstellung</p>

<p>
  <label>Vergangene Monate anzeigen</label> <br />
  <select name='VALUE[10]'>
    <option<?php echo ('REX_VALUE[10]' == 0 ? ' selected' : null);?>>0</option>
    <option<?php echo ('REX_VALUE[10]' == 1 ? ' selected' : null);?>>1</option>
    <option<?php echo ('REX_VALUE[10]' == 2 ? ' selected' : null);?>>2</option>
    <option<?php echo ('REX_VALUE[10]' == 3 ? ' selected' : null);?>>3</option>
  </select>
</p>

<p>
<label>Bevorstehende Monate anzeigen</label> <br />
  <select name='VALUE[11]'>
    <option<?php echo ('REX_VALUE[11]' == 0 ? ' selected' : null);?>>0</option>
    <option<?php echo ('REX_VALUE[11]' == 1 ? ' selected' : null);?>>1</option>
    <option<?php echo ('REX_VALUE[11]' == 2 ? ' selected' : null);?>>2</option>
    <option<?php echo ('REX_VALUE[11]' == 3 ? ' selected' : null);?>>3</option>
    <option<?php echo ('REX_VALUE[11]' == 4 ? ' selected' : null);?>>4</option>
    <option<?php echo ('REX_VALUE[11]' == 5 ? ' selected' : null);?>>5</option>
    <option<?php echo ('REX_VALUE[11]' == 6 ? ' selected' : null);?>>6</option>
  </select>
</p>

<h2 style="margin: 1.2em 0; float: left; width: 100%;">Texte</h2>

<p>
  <label>Überschrift</label><br />
  <input name="VALUE[1]" value="REX_VALUE[1]" size="60" />
</p>

<p>
  <label>Anmerkungen</label><br />
  <textarea name="VALUE[2]" cols="50" rows="3" class="tinyMCEEditor-simple">REX_VALUE[2]</textarea>
</p>

<h2 style="margin: 1.2em 0; float: left; width: 100%;">Funktionen</h2>

<p>
  <label><input type="checkbox" name="VALUE[15]" value="1" <?=( 'REX_VALUE[15]' == 1 ? 'checked' : null );?> > Google-Maps Link</label>
  <small>Bei kompletter Adresse, wird ein Google-Maps Link über die Adresse eingefügt.</small>
</p>