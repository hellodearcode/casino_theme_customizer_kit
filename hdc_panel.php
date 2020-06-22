<?php
/**
 * Plugin Name: Casino Header
 * Plugin URI: http://pmknutsen.no
 * Description: header custom color background change block post meta
 * Version: 1.0
 * Author: Pal Mattias
 * Author URI: http://pmknutsen.no
 * License: GPL2
 */

//Article UTM Link

function hdc_add_script_style() {

    wp_register_style( 'myslick-style', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );
    wp_enqueue_style( 'myslick-style' );

    wp_register_script( 'myslick-script', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',array('jquery') );
    wp_enqueue_script( 'myslick-script');

    wp_register_style( 'datatable-style', '//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css' );
    wp_enqueue_style( 'datatable-style' );

    wp_register_script( 'datatable-script', '//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js',array('jquery') );
    wp_enqueue_script( 'datatable-script');

    wp_enqueue_style( 'mybox-style', plugins_url( '/hdc-slider-custom.css', __FILE__ ), false, time(), 'all' );
    wp_enqueue_style( 'mybox-style' );

}
add_action( 'wp_enqueue_scripts', 'hdc_add_script_style');
add_action( 'load-post.php', 'hdc_casino_header_background_change_panel' );
add_action( 'load-post-new.php', 'hdc_casino_header_background_change_panel' );

function hdc_casino_header_background_change_panel() {
    add_action( 'add_meta_boxes', 'hdc_change_bg_meta_box' );
    add_action( 'save_post', 'hdc_casino_header_bg_color_save', 10, 2 );
    add_action( 'save_post', 'hdc_casino_bet_data_save', 10, 2 );
    add_action( 'save_post', 'hdc_bonus_text_notice_save', 10, 2 );
}

function hdc_change_bg_meta_box() {
    add_meta_box(
        'hdc_casino_header_cover_color',
        'Header Background Color',
        'hdc_casino_header_bg_meta_box',
        'casino',
        'side',
        'high'
    );
    add_meta_box(
        'hdc_bonus_text_notice',
        'Bonus Text Notice',
        'hdc_bonus_text_notice_meta_box',
        'bonus',
        'side',
        'high'
    );
    // -- bet data panel
    add_meta_box(
        'hdc_casino_bet_options_view',
        'Bet Options',
        'hdc_bet_data_meta_box',
        'game',
        'side',
        'high'
    );
}

function hdc_casino_header_bg_meta_box( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'hdc_casino_header_nonce' );?>

    <div class="components-base-control editor-post-excerpt__textarea">
        <div class="components-base-control__field">
            <label class="components-base-control__label" for="hdc_casino_cover_bg">
                Choose Color:
            </label>
            <input type="color" style="width:100%;padding:0px;" name="hdc_casino_cover_bg" id="hdc_casino_cover_bg"  value="<?php echo esc_attr( get_post_meta( $post->ID, 'hdc_casino_cover_bg_key', true ) ); ?>">
        </div>
    </div>
<?php 
}

// -- bonus options html
function hdc_bonus_text_notice_meta_box( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'hdc_bonus_text_notice_nonce' );?>

    <div class="components-base-control editor-post-excerpt__textarea">

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="bonus_text_notice">
                Bonus Text:
            </label>
            <input type="text" style="width:100%;padding:0px;" name="bonus_text_notice" id="bonus_text_notice"  value="<?php echo esc_attr( get_post_meta( $post->ID, 'bonus_text_notice_key', true ) ); ?>">
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="bonus_min_odds">
                Min Odds:
            </label>
            <input type="text" style="width:100%;padding:0px;" name="bonus_min_odds" id="bonus_min_odds"  value="<?php echo esc_attr( get_post_meta( $post->ID, 'bonus_min_odds_key', true ) ); ?>">
        </div>

    </div>
<?php
}

// -- bet options panel
function hdc_bet_data_meta_box( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'hdc_casino_bet_data' );?>

    <div class="components-base-control editor-post-excerpt__textarea">

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="hdc_bet_title">
                Title:
            </label>
            <input type="text" style="width:100%;padding:0px;" name="hdc_bet_title" id="hdc_bet_title"  value="<?php echo esc_attr( get_post_meta( $post->ID, 'hdc_bet_title_key', true ) ); ?>">
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="hdc_bet_units">
                Units:
            </label>
            <input type="text" style="width:100%;padding:0px;" name="hdc_bet_units" id="hdc_bet_units"  value="<?php echo esc_attr( get_post_meta( $post->ID, 'hdc_bet_units_key', true ) ); ?>">
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="hdc_bet_odds">
                Odds:
            </label>
            <input type="number" style="width:100%;padding:0px;" name="hdc_bet_odds" id="hdc_bet_odds"  value="<?php echo esc_attr( get_post_meta( $post->ID, 'hdc_bet_odds_key', true ) ); ?>">
        </div>
<!-- 
        <div class="components-base-control__field">
            <label class="components-base-control__label" for="hdc_bet_stacks">
                Stacks:
            </label>
            <input type="number" style="width:100%;padding:0px;" name="hdc_bet_stacks" id="hdc_bet_stacks"  value="<?php echo esc_attr( get_post_meta( $post->ID, 'hdc_bet_stacks_key', true ) ); ?>">
        </div> -->

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="hdc_bet_kickoff_time">
                KickOff Time:
            </label>
            <input type="time" style="width:100%;padding:0px;" name="hdc_bet_kickoff_time" id="hdc_bet_kickoff_time"  value="<?php echo esc_attr( get_post_meta( $post->ID, 'hdc_bet_kickoff_time_key', true ) ); ?>">
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="hdc_bet_kickoff_date">
                KickOff Date:
            </label>
            <input type="date" style="width:100%;padding:0px;" name="hdc_bet_kickoff_date" id="hdc_bet_kickoff_date"  value="<?php echo esc_attr( get_post_meta( $post->ID, 'hdc_bet_kickoff_date_key', true ) ); ?>">
        </div>

        <div class="components-base-control__field">
            <label class="components-base-control__label" for="hdc_bet_light_status">
                Status:
            </label>
            <select name="hdc_bet_light_status" style="width:100%;padding:0px;" id="hdc_bet_light_status">
                <option value="white" <?php get_post_meta( $post->ID, 'hdc_bet_light_status_key', true ) == 'white' ? print('selected') : ''; ?>>Default</option>
                <option value="green" <?php get_post_meta( $post->ID, 'hdc_bet_light_status_key', true ) == 'green' ? print('selected') : ''; ?>>Won</option>
                <option value="red" <?php get_post_meta( $post->ID, 'hdc_bet_light_status_key', true ) == 'red' ? print('selected') : ''; ?>>Lost</option>
                <option value="lightblue" <?php get_post_meta( $post->ID, 'hdc_bet_light_status_key', true ) == 'lightblue' ? print('selected') : ''; ?>>Void</option>
            </select>
        </div>

    </div>

<?php 
}

function hdc_bonus_text_notice_save( $post_id, $post ) {
    // Verify the nonce before proceeding.
    if ( !isset( $_POST['hdc_bonus_text_notice_nonce'] ) || !wp_verify_nonce( $_POST['hdc_bonus_text_notice_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    // Get the post type object.
    $post_type = get_post_type_object( $post->post_type );

    // Check if the current user has permission to edit the post.
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

        $PDOdata = Array(
            'bonus_text_notice_key' => ( isset( $_POST['bonus_text_notice'] ) ? esc_attr( $_POST['bonus_text_notice'] ) : '' ),
            'bonus_min_odds_key' => ( isset( $_POST['bonus_min_odds'] ) ? esc_attr( $_POST['bonus_min_odds'] ) : '' )
        );
    
        foreach ( $PDOdata as $k => $v ){
    
            if ( get_post_meta( $post_id, $k ) == '' )
                add_post_meta( $post_id, $meta_box, $v, true );
            
            elseif ( $v != get_post_meta( $post_id, $k, true ) )
                update_post_meta( $post_id, $k, $v );
            
            elseif ( $v == '' )
                delete_post_meta( $post_id, $k, get_post_meta( $post_id, $k, true ) );
        
        }
    
}


function hdc_casino_header_bg_color_save( $post_id, $post ) {

   
    // Verify the nonce before proceeding.
    if ( !isset( $_POST['hdc_casino_header_nonce'] ) || !wp_verify_nonce( $_POST['hdc_casino_header_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    // Get the post type object.
    $post_type = get_post_type_object( $post->post_type );

    // Check if the current user has permission to edit the post.
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    $new_meta_value = ( isset( $_POST['hdc_casino_cover_bg'] ) ? esc_attr( $_POST['hdc_casino_cover_bg'] ) : '' );
    $meta_key = 'hdc_casino_cover_bg_key';
    $meta_value = get_post_meta( $post_id, $meta_key, true );

    if ( $new_meta_value && '' == $meta_value )
        add_post_meta( $post_id, $meta_key, $new_meta_value, true );
    elseif ( $new_meta_value && $new_meta_value != $meta_value )
        update_post_meta( $post_id, $meta_key, $new_meta_value );
    elseif ( '' == $new_meta_value && $meta_value )
        delete_post_meta( $post_id, $meta_key, $meta_value );
}


// -- bets option save 

function hdc_casino_bet_data_save( $post_id, $post ) {
   
    // Verify the nonce before proceeding.
    if ( !isset( $_POST['hdc_casino_bet_data'] ) || !wp_verify_nonce( $_POST['hdc_casino_bet_data'], basename( __FILE__ ) ) )
        return $post_id;

    // Get the post type object.
    $post_type = get_post_type_object( $post->post_type );

    // Check if the current user has permission to edit the post.
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;
    
    $PDOdata = Array(
        'hdc_bet_odds_key' => ( isset( $_POST['hdc_bet_odds'] ) ? esc_attr( $_POST['hdc_bet_odds'] ) : '' ),
        'hdc_bet_units_key' => ( isset( $_POST['hdc_bet_units'] ) ? esc_attr( $_POST['hdc_bet_units'] ) : '' ),
        'hdc_bet_title_key' => ( isset( $_POST['hdc_bet_title'] ) ? esc_attr( $_POST['hdc_bet_title'] ) : '' ),
        // 'hdc_bet_stacks_key' => ( isset( $_POST['hdc_bet_stacks'] ) ? esc_attr( $_POST['hdc_bet_stacks'] ) : '' ),
        'hdc_bet_kickoff_time_key' => ( isset( $_POST['hdc_bet_kickoff_time'] ) ? esc_attr( $_POST['hdc_bet_kickoff_time'] ) : '' ),
        'hdc_bet_kickoff_date_key' => ( isset( $_POST['hdc_bet_kickoff_date'] ) ? esc_attr( $_POST['hdc_bet_kickoff_date'] ) : '' ),
        'hdc_bet_light_status_key' => ( isset( $_POST['hdc_bet_light_status'] ) ? esc_attr( $_POST['hdc_bet_light_status'] ) : '' )
    );

    foreach ( $PDOdata as $k => $v ){

        if ( get_post_meta( $post_id, $k ) == '' )
            add_post_meta( $post_id, $meta_box, $v, true );
        
        elseif ( $v != get_post_meta( $post_id, $k, true ) )
            update_post_meta( $post_id, $k, $v );
        
        elseif ( $v == '' )
            delete_post_meta( $post_id, $k, get_post_meta( $post_id, $k, true ) );
    
    }
}


// -- related required files
include_once('bets-sliderhome-shortcode.php');
include_once('shortcode-bets-table.php');
include_once('shortcode-bonus-slider.php');
include_once('shortcode-bonus-sidebar.php');
include_once('shortcode-bonus.php');
include_once('shortcode-articles.php');
include_once('shortcode-spreadsheet.php');
?>