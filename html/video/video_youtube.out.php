<?php
if ( 'REX_VALUE[1]' != null ) {

    ( string ) $class = 'video-wrap ';

    ( string ) $grid = str_replace( '  ', ' ', implode( ' ', rex_var::toArray( 'REX_VALUE[20]' ) ) );

    $grid = str_replace( 'l_', '', $grid);

    $class .= $grid;

    echo '<div class="'.$class.'">'
        . '<div class="video">';

    if( 'REX_VALUE[1]' != null ) {

        ( string ) $videoId = null;
        ( string ) $videoUrl = 'REX_VALUE[1]';

        preg_match( '#(?<=v=|v\/|vi=|vi\/|youtu.be\/)[a-zA-Z0-9_-]{11}#', $videoUrl, $match );

        if( isset( $match[0] ) && $match[0] != null ) {
            $videoId = $match[0];
        }

        ( string ) $settings = null;

        $settings .= '\'autoplay\' : '.('REX_VALUE[2]' == 1 ? '1' : '0').',';
        $settings .= '\'hl\' : \'de_DE\',';
        $settings .= '\'modestbranding\' : 1,';
        $settings .= '\'rel\' : 0,';
        $settings .= '\'showinfo\' : 0,';

        $settings = substr( $settings, 0 , -1 );

?>

<div id="ytplayer" class="video-player"></div>

<script>
  // Load the IFrame Player API code asynchronously.
  var tag = document.createElement('script');
  tag.src = "https://www.youtube.com/player_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  // Replace the 'ytplayer' element with an <iframe> and
  // YouTube player after the API code downloads.
  var player;
  function onYouTubePlayerAPIReady() {
    player = new YT.Player('ytplayer', {
      height: '390',
      width: '640',
      videoId: '<?=$videoId;?>',
      playerVars: {
        <?=$settings;?>
      }
    });
  }
</script>

<?
    }

    echo '</div></div>';

}
?>