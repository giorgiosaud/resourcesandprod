<?php
class MySettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
    	add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
    	add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
    	add_theme_page('Zonapro Options', 'Zonapro Child Theme Option', 'edit_theme_options', 'child_theme_option',
        // add_options_page(
            // 'Settings Admin', 
            // 'My Settings', 
            // 'manage_options', 
            // 'my-setting-admin', 
    		array( $this, 'create_admin_page' )
    		);
    	if(function_exists( 'wp_enqueue_media' )&& isset($_GET['page'])&&($_GET['page'] ==='child_theme_option')){
    		wp_enqueue_media();
    	}else{
    		wp_enqueue_style('thickbox');
    		wp_enqueue_script('media-upload');
    		wp_enqueue_script('thickbox');
    	}

    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
    	$this->options = get_option( 'child_theme' );
    	?>
    	<div class="wrap">
    		<h1>My Settings</h1>
    		<form method="post" action="options.php">
    			<?php
                // This prints out all hidden setting fields
    			settings_fields( 'child_theme_group' );
    			do_settings_sections( 'child_theme_option' );
    			submit_button();
    			?>
    		</form>
    	</div>
    	<script>
    		jQuery(document).ready(function($) {
    			$('.imagen_upload').click(function(e) {
    				e.preventDefault();
    				var	este=$(this),
    				input=este.data('input-selector'),
    				image=este.data('image-selector');
    				var custom_uploader = wp.media({
    					title: 'Custom Image',
    					button: {
    						text: 'Upload Image'
    					},
                multiple: false  // Set this to true to allow multiple files to be selected
            })
    				.on('select', function() {
    					var attachment = custom_uploader.state().get('selection').first().toJSON();
    					$(image).attr('src', attachment.url);
    					$(input).val(attachment.id);

    				})
    				.open();
    			});
    		});
    	</script>
    	<?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
    	register_setting(
            'child_theme_group', // Option group
            'child_theme', // Option name
            array( $this, 'sanitize' ) // Sanitize
            );

    	add_settings_section(
            'header_options', // ID
            'My Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'child_theme_option' // Page
            );  

    	add_settings_field(
            'imagen_top_id', // ID
            'Imagen Top', // Title 
            array( $this, 'imagen_top_callback' ), // Callback
            'child_theme_option', // Page
            'header_options' // Section           
            );
    	add_settings_field(
            'imagen_on_scroll_id', // ID
            'Imagen On Scroll', // Title 
            array( $this, 'imagen_on_scroll_callback' ), // Callback
            'child_theme_option', // Page
            'header_options' // Section           
            );
        // add_settings_field(
        //     'id_number', // ID
        //     'ID Number', // Title 
        //     array( $this, 'id_number_callback' ), // Callback
        //     'my-setting-admin', // Page
        //     'setting_section_id' // Section           
        // );      

        // add_settings_field(
        //     'title', 
        //     'Title', 
        //     array( $this, 'title_callback' ), 
        //     'my-setting-admin', 
        //     'setting_section_id'
        // );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
    	$new_input = array();
        // if( isset( $input['id_number'] ) )
        //     $new_input['id_number'] = absint( $input['id_number'] );

        // if( isset( $input['title'] ) )
        //     $new_input['title'] = sanitize_text_field( $input['title'] );
    	if( isset( $input['imagen_top_id'] ) )
    		$new_input['imagen_top_id'] =  absint($input['imagen_top_id']);
    	if( isset( $input['imagen_on_scroll_id'] ) )
    		$new_input['imagen_on_scroll_id'] =  absint($input['imagen_on_scroll_id']);

    	return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
    	print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function imagen_top_callback(){
    	$imagenTopId=isset( $this->options['imagen_top_id'] ) ? esc_attr( $this->options['imagen_top_id']) : '';
    	$imagen=wp_get_attachment_image( $imagenTopId ,null,true,array("class"=>"imagen_top"));
    	// echo '<p><strong>Header Logo Image URL:</strong><br />';
    	echo $imagen;
    	if($imagen='')
    		echo '<img class="imagen_element imagen_top" src="" />';
    	printf('<input class="imagen_top_url" type="text" name="child_theme[imagen_top_id]" value="%s">', $imagenTopId);
    	echo '<a href="#" class="imagen_upload" data-input-selector=".imagen_top_url" data-image-selector=".imagen_top">Upload</a>';
    	// echo '</p>';

    }

    public function imagen_on_scroll_callback(){
    	$imagenOnScroll=isset( $this->options['imagen_on_scroll_id'] ) ? esc_attr( $this->options['imagen_on_scroll_id']) : '';
    	$imagen=wp_get_attachment_image( $imagenOnScroll ,null,true,array("class"=>"imagen_on_scroll"));
    	// echo '<p><strong>Header Logo Image URL:</strong><br />';
    	echo $imagen;
    	if($imagen='')
    		echo '<img class="imagen_element imagen_on_scroll" src="" />';
    	printf('<input class="imagen_on_scroll_url" type="text" name="child_theme[imagen_on_scroll_id]" value="%s">', $imagenOnScroll);
    	echo '<a href="#" class="imagen_upload" data-input-selector=".imagen_on_scroll_url" data-image-selector=".imagen_on_scroll">Upload</a>';
    	// echo '</p>';

    }
    // public function id_number_callback()
    // {
    //     printf(
    //         '<input type="text" id="id_number" name="child_theme[id_number]" value="%s" />',
    //         isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
    //     );
    // }

    /** 
     * Get the settings option array and print one of its values
     */
    // public function title_callback()
    // {
    //     printf(
    //         '<input type="text" id="title" name="child_theme[title]" value="%s" />',
    //         isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
    //     );
    // }
}

if( is_admin() )
	$my_settings_page = new MySettingsPage();