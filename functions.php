<?php
/**
 * jeep functions and definitions
 *
 * @package jeep
 * @since jeep 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since jeep 1.0
 */

if ( ! function_exists( 'jeep_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since jeep 1.0
 */
function jeep_setup() {

	require( get_template_directory() . '/inc/shortcodes.php' );

	register_nav_menus( array(
		'primary_header' => __( 'Primary Header Menu', 'ivip' )
	) );

	add_editor_style('css/editor-styles.css');
	
}
endif; // jeep_setup
add_action( 'after_setup_theme', 'jeep_setup' );

add_action('tiny_mce_before_init', 'custom_tinymce_options');
if ( ! function_exists( 'custom_tinymce_options' )) {
	function custom_tinymce_options($init){
		$init['apply_source_formatting'] = true;
		return $init;
	}
}

add_image_size( 'header_image', 630, 323, true);

add_action("gform_field_standard_settings", "custom_gform_standard_settings", 10, 2);
function custom_gform_standard_settings($position, $form_id){
    if($position == 25){
    	?>
        <li style="display: list-item; ">
            <label for="field_placeholder">Placeholder Text</label>
            <input type="text" id="field_placeholder" size="35" onkeyup="SetFieldProperty('placeholder', this.value);">
        </li>
        <?php
    }
}

add_action('gform_enqueue_scripts',"custom_gform_enqueue_scripts", 10, 2);
function custom_gform_enqueue_scripts($form, $is_ajax=false){
    ?>
<script>
    jQuery(function(){
        <?php
        foreach($form['fields'] as $i=>$field){
            if(isset($field['placeholder']) && !empty($field['placeholder'])){
                ?>
                jQuery('#input_<?php echo $form['id']?>_<?php echo $field['id']?>').attr('placeholder','<?php echo $field['placeholder']?>');
                <?php
            }
        }
        ?>
    });
    </script>
    <?php
}

add_action('gform_after_submission', 'generate_xml', 10, 2);
function generate_xml($entry, $form) {

	$xml_string = '<?xml version="1.0" encoding="UTF-8"?>
	<TestDriveBookingsjeep>
		<TestDriveBookingjeep>
			<UniqueFormID>'.$entry['id'].'</UniqueFormID>
			<Title>'.$entry['2'].'</Title>
			<FirstName>'.$entry['3'].'</FirstName>
			<LastName>'.$entry['4'].'</LastName>
			<Address1>'.$entry['26'].'</Address1>
			<Address2>'.$entry['27'].'</Address2>
			<Address3>'.$entry['28'].'</Address3>
			<Address4>'.$entry['29'].'</Address4>						
			<PostCode>'.$entry['11'].'</PostCode>
			<EmailAddress>'.$entry['23'].'</EmailAddress>
			<TelephoneNumber>'.$entry['13'].'</TelephoneNumber>
			<MobileNumber>'.$entry['14'].'</MobileNumber>
			<PreferredDate>'.$entry['22'].'</PreferredDate>
			<Model>'.$entry['24'].'</Model>
			<CurrentCarRegistrationNumber>'.$entry['18'].'</CurrentCarRegistrationNumber>
			<UseOfDataPost>'.$entry['25.1'].'</UseOfDataPost>
			<UseOfDataTelephone>'.$entry['25.2'].'</UseOfDataTelephone>
			<UseOfDataEmail>'.$entry['25.3'].'</UseOfDataEmail>
			<UseOfDataSMS>'.$entry['25.4'].'</UseOfDataSMS>
		</TestDriveBookingjeep>
	</TestDriveBookingsjeep>
	';
	// return $xml;
	$uploads = wp_upload_dir();
	$location = $uploads['basedir'].'/bookings/entry_'.$entry['id'].'.xml';
	$xml = new SimpleXMLElement($xml_string);
	$xml->asXml($location);

	$xml_file = fopen($location, 'r');
	
	$curl = curl_init();
 	curl_setopt($curl, CURLOPT_URL, 'ftp://Fiat:34Solution@176.35.225.193/WebEnquiry/jeep_entry_'.$entry['id'].'.xml');
 	curl_setopt($curl, CURLOPT_UPLOAD, 1);
 	curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml")); 
 	curl_setopt($curl, CURLOPT_PUT, 1);
 	curl_setopt($curl, CURLOPT_INFILESIZE, filesize($location));
 	curl_setopt($curl, CURLOPT_INFILE, $xml_file);

 	$result = curl_exec($curl);
 	$error_no = curl_errno($curl);
 	curl_close($curl);
}