<?php
/**
 * ropstam Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ropstam
 * @since 1.0.0
 */ 

/**
 * Define Constants
 */
define( 'CHILD_THEME_ROPSTAM_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'ropstam-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ROPSTAM_VERSION, 'all' );
	wp_enqueue_script('jquery');
}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

//IP Address Redirect:
add_action('init', 'redirect_when_ip_found');
function redirect_when_ip_found() {
	$user_ip = $_SERVER['REMOTE_ADDR'];
    if (strpos($user_ip, '77.29') === 0) {
		//If IP Matches, lets redirect to Ropstam site
        wp_redirect('https://www.ropstam.com/');
        exit;
    }
}

//Custom Post Type and Taxonomy:
//Register a custom post type called "Projects".
function register_cpt_projects_with_some_default_options() {
    $labels = array(
        'name'                  => _x( 'Projects', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Projects', 'text_domain' ),
        'name_admin_bar'        => __( 'Project', 'text_domain' ),
        'archives'              => __( 'Project Archives', 'text_domain' ),
        'attributes'            => __( 'Project Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Project:', 'text_domain' ),
        'all_items'             => __( 'All Projects', 'text_domain' ),
        'add_new_item'          => __( 'Add New Project', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New Project', 'text_domain' ),
        'edit_item'             => __( 'Edit Project', 'text_domain' ),
        'update_item'           => __( 'Update Project', 'text_domain' ),
        'view_item'             => __( 'View Project', 'text_domain' ),
        'view_items'            => __( 'View Projects', 'text_domain' ),
        'search_items'          => __( 'Search Project', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into project', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this project', 'text_domain' ),
        'items_list'            => __( 'Projects list', 'text_domain' ),
        'items_list_navigation' => __( 'Projects list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter projects list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Project', 'text_domain' ),
        'description'           => __( 'Post Type Description', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'taxonomies'            => array( 'project_type' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 10,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type( 'project', $args );
}
add_action( 'init', 'register_cpt_projects_with_some_default_options', 0 );

// Register a custom taxonomy called "Project Type" associated with the "Projects"
function register_project_type_taxonomy() {

    $labels = array(
        'name'                       => _x( 'Project Types', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'Project Type', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Project Type', 'text_domain' ),
        'all_items'                  => __( 'All Project Types', 'text_domain' ),
        'parent_item'                => __( 'Parent Project Type', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Project Type:', 'text_domain' ),
        'new_item_name'              => __( 'New Project Type Name', 'text_domain' ),
        'add_new_item'               => __( 'Add New Project Type', 'text_domain' ),
        'edit_item'                  => __( 'Edit Project Type', 'text_domain' ),
        'update_item'                => __( 'Update Project Type', 'text_domain' ),
        'view_item'                  => __( 'View Project Type', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate project types with commas', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove project types', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
        'popular_items'              => __( 'Popular Project Types', 'text_domain' ),
        'search_items'               => __( 'Search Project Types', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
        'no_terms'                   => __( 'No project types', 'text_domain' ),
        'items_list'                 => __( 'Project types list', 'text_domain' ),
        'items_list_navigation'      => __( 'Project types list navigation', 'text_domain' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'project_type', array( 'project' ), $args );

}
add_action( 'init', 'register_project_type_taxonomy', 0 );

//Archive Page:
// Create a WordPress archive page that displays six &quot;Projects&quot; per page with simple pagination (next, prev buttons).

// My Response: Template named as archive-projects.php created to display listing/archive page of post type Projects


//Ajax Endpoint:
// Create an Ajax endpoint that outputs the last three published "Projects belonging to the "Project Type" called "Architecture" if the user is not logged in.
// If the user is logged in, return the last six published "Projects" in the "Architecture" project type.
// The results should be returned in JSON format: {success: true, data: [{id, title, link}, {id, title, link}, {id, title, link}, ...]}.

add_action( 'wp_ajax_get_dk_architecture', 'retrieve_architecture_posts_cb' );
add_action( 'wp_ajax_nopriv_get_dk_architecture', 'retrieve_architecture_posts_cb' );

function retrieve_architecture_posts_cb() {
	$post_to_show = 3;
	//Show 3 Posts By Default if not logged in and show if logged in
	if(is_user_logged_in()){
		$post_to_show = 6;
	}
    $args = array(
        'post_type'      => 'project',
        'posts_per_page' => $post_to_show, 
        'tax_query'      => array(
            array(
                'taxonomy' => 'project_type',
                'field'    => 'slug',
                'terms'    => 'architecture',
            ),
        ),
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    $projects = get_posts( $args );
    $data = array();
    foreach ( $projects as $project ) {
        $data[] = array(
            'id'    => $project->ID,
            'title' => $project->post_title,
            'link'  => get_permalink( $project->ID ),
        );
    }
	if($data){
		wp_send_json_success( $data );
	}
	else{
		wp_send_json_error('Projects Not Found');
	}
}

/*My Response: You can use this JS Code to verify this code*/
// var link = "https://your_site_url/wp-admin/admin-ajax.php";
// jQuery.ajax({
// 			url: link,
// 			data: {
// 				'action': 'get_dk_architecture',
// 				'data': 'test'
// 			},
// 			type:'post',
// 			success: function(result){
//                          console.log(result);
//             }
// })
/*End of My Test JS Code*/

//Random Coffee API Integration:
// Use the WordPress HTTP API to create a function called hs_give_me_coffee() that returns a direct link to a cup of coffee using the Random Coffee API.

function hs_give_me_coffee() {
	
    $api_url = 'https://coffee.alexflipnote.dev/random.json';
    $response = wp_remote_get( $api_url );

    // Show error and return if error exist
    if ( is_wp_error( $response ) ) {
        return 'Not Responding';
    }

    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body );
	
	if(!$data){
		return 'Not found';
	}
    // Return the coffee URL
	return $data->file;
}

//Kanye Quotes Page:
// Use the Kanye Rest API to display five quotes on a WordPress page.
function request_quotes_from_api() {
    for ( $i = 0; $i < 5; $i++ ) {
		$api_url = 'https://api.kanye.rest/';
		$response = wp_remote_get( $api_url );

		// Show error and return if error exist
		if ( is_wp_error( $response ) ) {
			echo 'Not Responding';
			return;
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body );
    	echo '<p>' . esc_html( $data->quote ) . '</p>';
    }
}

// Add this Shortcode anywhere on site to retrieve Quotes and run the coffee function output
function show_the_quotes() {
    ob_start();
	$ret = hs_give_me_coffee();
    print_r($ret);
	request_quotes_from_api();
    return ob_get_clean();
}
add_shortcode( 'Show_Quotes_Shortcode', 'show_the_quotes' );
 
