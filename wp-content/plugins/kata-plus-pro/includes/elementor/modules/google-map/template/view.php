<?php
/**
 * Google Map module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

use Elementor\Plugin;

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings              = $this->get_settings();
$map_type              = $settings['map'];
$embed_iframe          = $settings['em_iframe'];
$lat                   = strval( $settings['lat'] );
$long                  = strval( $settings['long'] );
$map_zoom              = strval( $settings['map_zoom']['size'] );
$map_height            = strval( $settings['map_height']['size'] );
$map_width             = strval( $settings['map_width']['size'] );
$gesture_handling      = $settings['gestureHandling'];
$map_layer             = $settings['map_layer'];
$map_style             = $settings['map_style'];
$map_marker            = $settings['map_marker'];
$address_list          = $settings['address_list'];
$animate_marker        = ( ! empty($settings['animate_marker']) ) ? 'animation:google.maps.Animation.BOUNCE,' : '';
$map_marker_image      = $settings['map_marker_image']['url'];
$zoom_controller       = ( ! empty($settings['zoom_controller']) ) ? 'true' : 'false';
$fullscreen_controller = ( ! empty($settings['fullscreen_controller']) ) ? 'true' : 'false';
$streetview_controller = ( ! empty($settings['streetview_controller']) ) ? 'true' : 'false';
$map_type_controller   = ( ! empty($settings['map_type_controller']) ) ? 'true' : 'false';
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}
?>

<?php if ( $map_type == 'map_address' ): ?>
<?php 
  if ( $address_list ) {
    $ml_address = 'true';
  } else {
    $ml_address = 'false';
  }
?>
<div class="kata-plus-google-map">
	<div id="kata-google-map" data-layer="<?php esc_attr_e( $map_layer ) ?>"  data-style="<?php esc_attr_e( $map_style ) ?>" data-icon="<?php esc_attr_e( $map_marker_image ) ?>" data-marker="<?php esc_attr_e( $map_marker )?>" data-adr="<?php esc_attr_e( $ml_address ) ?>"> </div>
		<?php
		if ( $settings['map_template'] ) {
			?>
			<div class="kata-map-template">
				<?php echo Plugin::instance()->frontend->get_builder_content_for_display( get_page_by_title($settings['map_template'], OBJECT, 'elementor_library')->ID ); ?>
			</div>
			<?php
		}
		?>
</div>

<script>
  function initMap() {
    var inmap = document.getElementById('kata-google-map');
    var layer = inmap.getAttribute('data-layer');    
    var icon  =  inmap.getAttribute('data-icon');    
    var mark  =  inmap.getAttribute('data-marker');    
    var style =  inmap.getAttribute('data-style');    
    var adr =  inmap.getAttribute('data-adr');    
    var uluru = {lat: <?php echo $lat ?>, lng: <?php echo $long ?>};

    switch (style) {
      case 'standard':
      var map = new google.maps.Map(
        document.getElementById('kata-google-map'), {
          zoom: <?php echo $map_zoom ?>,
          zoomControl: <?php echo esc_attr( $zoom_controller ); ?>,          
          fullscreenControl: <?php echo esc_attr( $fullscreen_controller ); ?>,
          streetViewControl: <?php echo esc_attr( $streetview_controller ); ?>,
          gestureHandling: '<?php echo esc_attr( $gesture_handling); ?>',
          mapTypeControl: <?php echo esc_attr( $map_type_controller); ?>,
          center: uluru,    
        });
        break;

      case 'silver':
      var map = new google.maps.Map(
        document.getElementById('kata-google-map'), {
          zoom: <?php echo $map_zoom ?>,
          zoomControl: <?php echo esc_attr( $zoom_controller ); ?>,          
          fullscreenControl: <?php echo esc_attr( $fullscreen_controller ); ?>,
          streetViewControl: <?php echo esc_attr( $streetview_controller ); ?>,
          gestureHandling: '<?php echo esc_attr( $gesture_handling); ?>',
          mapTypeControl: <?php echo esc_attr( $map_type_controller); ?>,
          center: uluru, 
          styles: [
          {
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#f5f5f5"
              }
            ]
          },
          {
            "elementType": "labels.icon",
            "stylers": [
              {
                "visibility": "off"
              }
            ]
          },
          {
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#616161"
              }
            ]
          },
          {
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#f5f5f5"
              }
            ]
          },
          {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#bdbdbd"
              }
            ]
          },
          {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#eeeeee"
              }
            ]
          },
          {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#757575"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#e5e5e5"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#9e9e9e"
              }
            ]
          },
          {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#ffffff"
              }
            ]
          },
          {
            "featureType": "road.arterial",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#757575"
              }
            ]
          },
          {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#dadada"
              }
            ]
          },
          {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#616161"
              }
            ]
          },
          {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#9e9e9e"
              }
            ]
          },
          {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#e5e5e5"
              }
            ]
          },
          {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#eeeeee"
              }
            ]
          },
          {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#c9c9c9"
              }
            ]
          },
          {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#9e9e9e"
              }
            ]
          }
          ]           
        });
        break;

      case 'retro':
      var map = new google.maps.Map(
        document.getElementById('kata-google-map'), {
          zoom: <?php echo $map_zoom ?>,
          zoomControl: <?php echo esc_attr( $zoom_controller ); ?>,          
          fullscreenControl: <?php echo esc_attr( $fullscreen_controller ); ?>,
          streetViewControl: <?php echo esc_attr( $streetview_controller ); ?>,
          gestureHandling: '<?php echo esc_attr( $gesture_handling); ?>',
          mapTypeControl: <?php echo esc_attr( $map_type_controller); ?>,
          center: uluru,   
          styles: [
          {
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#ebe3cd"
              }
            ]
          },
          {
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#523735"
              }
            ]
          },
          {
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#f5f1e6"
              }
            ]
          },
          {
            "featureType": "administrative",
            "elementType": "geometry.stroke",
            "stylers": [
              {
                "color": "#c9b2a6"
              }
            ]
          },
          {
            "featureType": "administrative.land_parcel",
            "elementType": "geometry.stroke",
            "stylers": [
              {
                "color": "#dcd2be"
              }
            ]
          },
          {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#ae9e90"
              }
            ]
          },
          {
            "featureType": "landscape.natural",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#dfd2ae"
              }
            ]
          },
          {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#dfd2ae"
              }
            ]
          },
          {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#93817c"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "geometry.fill",
            "stylers": [
              {
                "color": "#a5b076"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#447530"
              }
            ]
          },
          {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#f5f1e6"
              }
            ]
          },
          {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#fdfcf8"
              }
            ]
          },
          {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#f8c967"
              }
            ]
          },
          {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [
              {
                "color": "#e9bc62"
              }
            ]
          },
          {
            "featureType": "road.highway.controlled_access",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#e98d58"
              }
            ]
          },
          {
            "featureType": "road.highway.controlled_access",
            "elementType": "geometry.stroke",
            "stylers": [
              {
                "color": "#db8555"
              }
            ]
          },
          {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#806b63"
              }
            ]
          },
          {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#dfd2ae"
              }
            ]
          },
          {
            "featureType": "transit.line",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#8f7d77"
              }
            ]
          },
          {
            "featureType": "transit.line",
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#ebe3cd"
              }
            ]
          },
          {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#dfd2ae"
              }
            ]
          },
          {
            "featureType": "water",
            "elementType": "geometry.fill",
            "stylers": [
              {
                "color": "#b9d3c2"
              }
            ]
          },
          {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#92998d"
              }
            ]
          }
        ]         
        });
        break;

      case 'dark':
      var map = new google.maps.Map(
        document.getElementById('kata-google-map'), {
          zoom: <?php echo $map_zoom ?>,
          zoomControl: <?php echo esc_attr( $zoom_controller ); ?>,          
          fullscreenControl: <?php echo esc_attr( $fullscreen_controller ); ?>,
          streetViewControl: <?php echo esc_attr( $streetview_controller ); ?>,
          gestureHandling: '<?php echo esc_attr( $gesture_handling); ?>',
          mapTypeControl: <?php echo esc_attr( $map_type_controller); ?>,
          center: uluru,  
          styles: [
          {
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#212121"
              }
            ]
          },
          {
            "elementType": "labels.icon",
            "stylers": [
              {
                "visibility": "off"
              }
            ]
          },
          {
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#757575"
              }
            ]
          },
          {
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#212121"
              }
            ]
          },
          {
            "featureType": "administrative",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#757575"
              }
            ]
          },
          {
            "featureType": "administrative.country",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#9e9e9e"
              }
            ]
          },
          {
            "featureType": "administrative.land_parcel",
            "stylers": [
              {
                "visibility": "off"
              }
            ]
          },
          {
            "featureType": "administrative.locality",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#bdbdbd"
              }
            ]
          },
          {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#757575"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#181818"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#616161"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#1b1b1b"
              }
            ]
          },
          {
            "featureType": "road",
            "elementType": "geometry.fill",
            "stylers": [
              {
                "color": "#2c2c2c"
              }
            ]
          },
          {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#8a8a8a"
              }
            ]
          },
          {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#373737"
              }
            ]
          },
          {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#3c3c3c"
              }
            ]
          },
          {
            "featureType": "road.highway.controlled_access",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#4e4e4e"
              }
            ]
          },
          {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#616161"
              }
            ]
          },
          {
            "featureType": "transit",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#757575"
              }
            ]
          },
          {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#000000"
              }
            ]
          },
          {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#3d3d3d"
              }
            ]
          }
        ]  
        });
        break;

      case 'night':
      var map = new google.maps.Map(
        document.getElementById('kata-google-map'), {
          zoom: <?php echo $map_zoom ?>,
          zoomControl: <?php echo esc_attr( $zoom_controller ); ?>,          
          fullscreenControl: <?php echo esc_attr( $fullscreen_controller ); ?>,
          streetViewControl: <?php echo esc_attr( $streetview_controller ); ?>,
          gestureHandling: '<?php echo esc_attr( $gesture_handling); ?>',
          mapTypeControl: <?php echo esc_attr( $map_type_controller); ?>,
          center: uluru,    
          styles: [
          {
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#242f3e"
              }
            ]
          },
          {
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#746855"
              }
            ]
          },
          {
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#242f3e"
              }
            ]
          },
          {
            "featureType": "administrative.locality",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#d59563"
              }
            ]
          },
          {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#d59563"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#263c3f"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#6b9a76"
              }
            ]
          },
          {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#38414e"
              }
            ]
          },
          {
            "featureType": "road",
            "elementType": "geometry.stroke",
            "stylers": [
              {
                "color": "#212a37"
              }
            ]
          },
          {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#9ca5b3"
              }
            ]
          },
          {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#746855"
              }
            ]
          },
          {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [
              {
                "color": "#1f2835"
              }
            ]
          },
          {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#f3d19c"
              }
            ]
          },
          {
            "featureType": "transit",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#2f3948"
              }
            ]
          },
          {
            "featureType": "transit.station",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#d59563"
              }
            ]
          },
          {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#17263c"
              }
            ]
          },
          {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#515c6d"
              }
            ]
          },
          {
            "featureType": "water",
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#17263c"
              }
            ]
          }
        ]
        });
        break;

      case 'aubergine':
      var map = new google.maps.Map(
        document.getElementById('kata-google-map'), {
          zoom: <?php echo $map_zoom ?>,
          zoomControl: <?php echo esc_attr( $zoom_controller ); ?>,          
          fullscreenControl: <?php echo esc_attr( $fullscreen_controller ); ?>,
          streetViewControl: <?php echo esc_attr( $streetview_controller ); ?>,
          gestureHandling: '<?php echo esc_attr( $gesture_handling); ?>',
          mapTypeControl: <?php echo esc_attr( $map_type_controller); ?>,
          center: uluru, 
          styles: [
          {
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#1d2c4d"
              }
            ]
          },
          {
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#8ec3b9"
              }
            ]
          },
          {
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#1a3646"
              }
            ]
          },
          {
            "featureType": "administrative.country",
            "elementType": "geometry.stroke",
            "stylers": [
              {
                "color": "#4b6878"
              }
            ]
          },
          {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#64779e"
              }
            ]
          },
          {
            "featureType": "administrative.province",
            "elementType": "geometry.stroke",
            "stylers": [
              {
                "color": "#4b6878"
              }
            ]
          },
          {
            "featureType": "landscape.man_made",
            "elementType": "geometry.stroke",
            "stylers": [
              {
                "color": "#334e87"
              }
            ]
          },
          {
            "featureType": "landscape.natural",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#023e58"
              }
            ]
          },
          {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#283d6a"
              }
            ]
          },
          {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#6f9ba5"
              }
            ]
          },
          {
            "featureType": "poi",
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#1d2c4d"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "geometry.fill",
            "stylers": [
              {
                "color": "#023e58"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#3C7680"
              }
            ]
          },
          {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#304a7d"
              }
            ]
          },
          {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#98a5be"
              }
            ]
          },
          {
            "featureType": "road",
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#1d2c4d"
              }
            ]
          },
          {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#2c6675"
              }
            ]
          },
          {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [
              {
                "color": "#255763"
              }
            ]
          },
          {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#b0d5ce"
              }
            ]
          },
          {
            "featureType": "road.highway",
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#023e58"
              }
            ]
          },
          {
            "featureType": "transit",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#98a5be"
              }
            ]
          },
          {
            "featureType": "transit",
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#1d2c4d"
              }
            ]
          },
          {
            "featureType": "transit.line",
            "elementType": "geometry.fill",
            "stylers": [
              {
                "color": "#283d6a"
              }
            ]
          },
          {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#3a4762"
              }
            ]
          },
          {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#0e1626"
              }
            ]
          },
          {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#4e6d70"
              }
            ]
          }
        ]
        });
        break;

      default:
      var map = new google.maps.Map( document.getElementById('kata-google-map'), {
        	zoom: <?php echo $map_zoom ?>,
        	zoomControl: <?php echo esc_attr( $zoom_controller ); ?>,          
        	fullscreenControl: <?php echo esc_attr( $fullscreen_controller ); ?>,
        	streetViewControl: <?php echo esc_attr( $streetview_controller ); ?>,
        	gestureHandling: '<?php echo esc_attr( $gesture_handling); ?>',
        	mapTypeControl: <?php echo esc_attr( $map_type_controller); ?>,
			center: uluru,
		});
        break;
    }

    if ( mark == 'marker_img' ) {
      var marker = new google.maps.Marker({
      position: uluru,
      map: map,
      <?php echo esc_attr( $animate_marker ); ?>   
      icon: icon 
    });
    } else {
      var marker = new google.maps.Marker({
      position: uluru,
      map: map,
      <?php echo esc_attr( $animate_marker ); ?>      
    });
    }

    if ( adr == 'true' ) {
      console.log(icon); 
      var features = [    
      <?php foreach ( $address_list as $address ) : ?>
        {
            position: new google.maps.LatLng(<?php echo $address['address_lat'] ?>, <?php echo $address['address_long']?>),
            icon: icon
        },
      <?php endforeach ;?>
      ];

    for (var i = 0; i < features.length; i++) {
      var marker = new google.maps.Marker({
        position: features[i].position,          
        map: map,
        icon: icon,
      });
     };
    }

    switch (layer) {

      case 'transit':
      var transitLayer = new google.maps.TransitLayer();
      transitLayer.setMap(map);
        break;

      case 'bicycle':
        var bikeLayer = new google.maps.BicyclingLayer();
        bikeLayer.setMap(map);    
        break;

      case 'traffic':        
      var trafficLayer = new google.maps.TrafficLayer();
      trafficLayer.setMap(map);
        break;

      case 'none':
        break;
    
    }

  }
</script>

<?php 
$api = get_theme_mod( 'kata_google_map_api', '' ); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php esc_attr_e( $api ) ?>&callback=initMap" async defer></script>

<?php endif; ?>

<?php if ( $map_type == 'map_embed' ):?>

<?php echo $embed_iframe; ?>

<?php endif;?>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}