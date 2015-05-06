<?
( string ) $sliceId = 'REX_SLICE_ID';
( string ) $blockId = 'gmap_canvas-'.$sliceId;

( array ) $grid = rex_var::toArray('REX_VALUE[20]');
( string ) $grid = implode( ' ', $grid );
( int ) $padding = 'REX_VALUE[19]';
if( $padding == null ) {
    $padding = 100;
}

?>

<div class="<?=$grid;?>">
    <?
    if('REX_VALUE[5]') {
        echo '<h4 class="heading">' . 'REX_VALUE[5]' . '</h4>';
    }
    ?>

    <div class="gm" style="<?=($REX['REDAXO'] ? 'height: 0;overflow: hidden;position: relative;' : null);?>padding-top: <?=$padding . 'px';?>">
        <div class="gm-map" id="<?=$blockId;?>" <?=($REX['REDAXO'] ? 'style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;"' : null);?>></div>
    </div>
<style><?=$blockId;?> img{max-width:none!important;background:none!important}</style>

<script type="text/javascript">

if( typeof init_map == 'undefined' ) {

    function init_map( el, id, address, info ) {

        var vars = {},
            lat = 0,
            lng = 0;



        geo = new google.maps.Geocoder();
        geo.geocode( { 'address' : address }, function ( results , status ) {

            // If that was successful
            if ( status == google.maps.GeocoderStatus.OK ) {

                // Lets assume that the first marker is the one we want
                var p = results[0].geometry.location;
                lat=p.lat();
                lng=p.lng();


                var myOptions = {
                    zoom:14,
                    center:new google.maps.LatLng( lat, lng ),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                // Werksweg 2,  92551 Stulln

                vars['map'+id] = new google.maps.Map( document.getElementById( el ), myOptions );
                vars['marker'+id] = new google.maps.Marker({ 'map': vars['map'+id], 'position': new google.maps.LatLng( lat, lng ) } );

                vars['infowindow'+id] = new google.maps.InfoWindow({ 'content' : info });
                google.maps.event.addListener( vars['marker'+id], "click", function(){ vars['infowindow'+id].open( vars['map'+id], vars['marker'+id]); } );

                //vars['infowindow'+id].open(vars['map'+id],marker<?=$sliceId;?>);

            }
        });
    }
}

//google.maps.event.addDomListener(window, 'load', init_map);
init_map( '<?=$blockId;?>', '<?=$sliceId;?>','REX_VALUE[1], REX_VALUE[3] REX_VALUE[2], REX_VALUE[6]', "<b>REX_VALUE[4]</b><br/>REX_VALUE[1]<br />REX_VALUE[3] REX_VALUE[2]<br/>REX_VALUE[6]" );

</script>

</div>