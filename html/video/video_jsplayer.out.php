<?php
if ( 'REX_MEDIA[1]' != null ) {

    ( string ) $class = 'video-wrap ';

    ( string ) $grid = str_replace( '  ', ' ', implode( ' ', rex_var::toArray( 'REX_VALUE[20]' ) ) );

    $grid = str_replace( 'l_', '', $grid);

    $class .= $grid;

    echo '<div class="'.$class.'">'
        . '<div class="video">';


    if ( 'REX_MEDIA[1]' != null ) { // Lokale Videos

        ( string ) $fileList = '';

        if( $med = OOMedia::getMediaByFileName( 'REX_MEDIA[1]' ) ) {

            list( $type, $extension ) = explode( '/', $med->getType() );

            $ext = array(
            'm4v' => 'mp4',
            'ogv' => 'ogv',
            'webm' => 'webm',
            'poster' => 'jpg' );
            $snapshot = '';

            $fileList .= array_search( $extension, $ext ) . ': "' . $med->getFullPath() . '",';
            $fileList .= 'poster: "' . $this->posterImages[0] . '",';

            foreach ( $ext as $t => $ex ) {

                if ( $ex != $extension ) {

                    $fileName = substr( $med->getFilename(), 0, -3 );

                    if ( $m = OOMedia::getMediaByFileName( $fileName . $ex ) ) {

                        $fileList .= $t . ': "' . $m->getFullPath() . '",';
                    }
                }
            }
            $fileList = substr( $fileList, 0, -1 );
        }

?>

        <div id="jp_container_REX_SLICE_ID" class="video-player jplayer jp-video jp-video-360p" style="display: none;">
        <div class="jp-type-single">
          <div id="jquery_jplayer_REX_SLICE_ID" class="jp-jplayer"></div>
          <div class="jp-gui">
            <div class="jp-interface">
              <div class="jp-progress">
                <div class="jp-seek-bar">
                  <div class="jp-play-bar"></div>
                </div>
              </div>
              <div class="jp-current-time"></div>
              <div class="jp-duration"></div>
              <div class="jp-controls-holder">
                <ul class="jp-controls">
                  <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                  <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                  <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="jp-no-solution">
            <span>Update Required</span>
            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
          </div>
        </div>
      </div>
  <script type="text/javascript">

    function yourFunctionToRun(){
        $.getScript( "files/js/jquery.jplayer/jquery.jplayer.js", function( data, textStatus, jqxhr ) {

            /*var cssLink = $("<link>");
            $("head").append(cssLink); //IE hack: append before setting href
            cssLink.attr({
              rel:  "stylesheet",
              type: "text/css",
              href: 'files/js/jquery.jplayer/blue.monday/jplayer.blue.monday.css'
            }); */

            $(window).load( function() {

              $("#jquery_jplayer_REX_SLICE_ID").jPlayer({
                ready: function () {
                    $(this).jPlayer( "setMedia", { <?=$fileList;?> });
                    $('#jp_container_REX_SLICE_ID').show();
                },
                cssSelectorAncestor: "#jp_container_REX_SLICE_ID",
                swfPath: "/files/js/jquery.jplayer/",
                supplied: "m4v, ogv, webm",
                autohide: {
                    restored: true
                },
                size: {
        			width: "640px",
        			height: "360px",
        			cssClass: "jp-video-360p"
        		}});
            });
        });
    }

    function runYourFunctionWhenJQueryIsLoaded() {
        if (window.$){
            //possibly some other JQuery checks to make sure that everything is loaded here
            yourFunctionToRun();
        } else {
            setTimeout(runYourFunctionWhenJQueryIsLoaded, 50);
        }
    }

    runYourFunctionWhenJQueryIsLoaded();


</script>


<?
    }  // Lokale Videos end

    echo '</div></div>';

}
?>