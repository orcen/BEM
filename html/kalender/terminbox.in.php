<label>Boxüberschrift</label><br />
<input type="text" name="VALUE[5]" value="REX_VALUE[5]" size="60" /><br />
<br />
<label><input type="checkbox" name="VALUE[6]" value="1" <?=('REX_VALUE[6]' == 1 ? 'checked' : null);?> /> Bilderanzeigen</label><br />
<br />

<label>Termine Anzahl</label><br />
<select name='VALUE[1]'>
  <option<?php echo ('REX_VALUE[1]' == 1 ? ' selected' : null);?>>1</option>
  <option<?php echo ('REX_VALUE[1]' == 2 ? ' selected' : null);?>>2</option>
  <option<?php echo ('REX_VALUE[1]' == 3 ? ' selected' : null);?>>3</option>
  <option<?php echo ('REX_VALUE[1]' == 4 ? ' selected' : null);?>>4</option>
  <option<?php echo ('REX_VALUE[1]' == 5 ? ' selected' : null);?>>5</option>
</select>
<br />
<label>Terminübersicht</label><br />
REX_LINK_BUTTON[1]