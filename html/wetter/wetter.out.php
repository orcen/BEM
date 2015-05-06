<?php
$ort = 'REX_VALUE[1]';
$land = 'REX_VALUE[2]';
$url = 'http://api.openweathermap.org/data/2.5/weather?q='.$ort.','.$land.'&lang=de&units=metric';

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$dataRaw = curl_exec($ch);
curl_close($ch);

if( $dataRaw ) {

  $data = json_decode($dataRaw, true);

  $icon = 'files/css/images/wetter/';
  $weather = $data['weather'][0];

  switch( substr($weather['id'],0,1) ) {
    case '2':
      $icon .= 'sturm.png';
      break;
    case '3':
      $icon .= 'leichter_regen.png';
      break;
    case '5':
      $icon .= 'regen.png';
      break;
    case '6':
      $icon .= 'schnee.png';
      break;
    case '7':
      $icon .= 'nebel.png';
      break;
    case '8':
        $icon .= 'wolken_'.$weather['id'].'.png';
      break;
  }

  list($width, $height) = getimagesize($REX['MEDIAFOLDER'] . '/../'. $icon);

  echo '<div class="wetter grid_xs_12 grid_sm_6 grid_l_3">'
    . '<h2 class="wetter-heading heading"><span>Aktuelles</span> Wetter</h2>'

    . ( 'REX_HAS_VALUE[3]' ? str_replace( '<p ', '<p class="wetter-text" ', 'REX_HTML_VALUE[3]' ) : null )

    . '<p class="wetter-text2">aktuelles Wetter für ' . $ort . ' ' . strftime('%d.%B&nbsp;%Y&nbsp;-&nbsp;%H:%M Uhr') . '</p>'
    . '<p class="wetter-icon" title="'.$data['weather'][0]['description'].'"><img src="'.$icon.'" width="'.$width.'" height="'.$height.'" alt="'.$data['weather'][0]['description'].'" /></p>'
    . '<dl class="wetter-info">'
    . '<dt class="wetter-infoname wetter-temp" title="Temperatur">Aktuell:</dt><dd class="wetter-infowert">'.round( floatval($data['main']['temp']), 1).'&deg;C</dd>'
    . '<dt class="wetter-infoname wetter-name" title="Wetter">Wetter:</dt><dd class="wetter-infowert">'.$data['weather'][0]['description'].'</dd>'
    . '<dt class="wetter-infoname wetter-tempmin" title="Temperatur Minimal">min:</dt><dd class="wetter-infowert">'.round( floatval($data['main']['temp_min']), 1).'&deg;C</dd>'
    . '<dt class="wetter-infoname wetter-tempmax" title="Temperatur Maximal">max:</dt><dd class="wetter-infowert">'.round( floatval($data['main']['temp_max']), 1).'&deg;C</dd>'
    . '<dt class="wetter-infoname wetter-humidity" title="Luftfeuchtigkeit">Luftfeuchtigkeit:</dt><dd class="wetter-infowert">'.round( floatval($data['main']['humidity']), 1).'&percnt;</dd>'
    . '<dt class="wetter-infoname wetter-humidity" title="Luftdruck">Luftdruck:</dt><dd class="wetter-infowert">'.round( floatval($data['main']['pressure']), 1).' hPa</dd>';

  $windOrientation = 'N';
  if( $data['wind']['deg'] < 90 )
    $windOrientation = 'NO';
  elseif( $data['wind']['deg'] < 180 && $data['wind']['deg'] > 90 )
    $windOrientation = 'SO';
  elseif( $data['wind']['deg'] < 270 && $data['wind']['deg'] > 180 )
    $windOrientation = 'SW';
  elseif( $data['wind']['deg'] > 270)
    $windOrientation = 'NW';

  echo '<dt class="wetter-infoname wetter-wind" title="Windstärke - '.$data['wind']['deg'].'&deg; '.$windOrientation.'">Wind:</dt><dd class="wetter-infowert">'.$data['wind']['speed'].' m/s '.$windOrientation.'</dd>';
  echo '</dl>';
  //echo '<span class="pressure">Luftdruck'.$data['main']['pressure'].' m/s</span>';
  echo '</div>';
}

?>
