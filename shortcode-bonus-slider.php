<?php
add_shortcode( 'bonus_slider', 'hdc_custom_bonus' );
function hdc_custom_bonus(){
    ob_start();
   ?>

<div id="bonus-slider">

<?php
        $args = array(
            'post_type' => 'bonus',
            'post_status' => 'publish'
        );
        $query = new WP_Query( $args );
        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();
                
                // -- meta box data
                $bonus_short_desc = strip_tags( get_post_meta( get_the_ID(), 'bonus_short_desc', true ));
                $get_bonuslink = esc_url( get_post_meta( get_the_ID(), 'bonus_external_link', true ) );
                if( empty($get_bonuslink) ) {
                    $get_bonuslink = get_the_permalink();
                }
    
                echo '
                    <div class="new-bet-card slick-slide">';
                    
                    $widget_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'mercury-450-317'); if ($widget_img) { ?>
                        <img src="<?php echo esc_url($widget_img[0]); ?>" alt="<?php the_title_attribute(); ?>">
                <?php
                        } 
                echo '  <p class="std-text-size">'.substr( $bonus_short_desc, 0, 40 ) .'....</p>
                        <a href="'.$get_bonuslink.'" target="_blank" class="button-joinbet">CLAIM BONUS</a>
                    </div>
                ';
            }
        }
        wp_reset_postdata();
?>

</div>

<script>
jQuery('#bonus-slider').slick({
 slidesToShow: 4,
 slidesToScroll: 1,
arrows: true,
autoplay: true,
infinite: true,
nextArrow: '<span class="chevron right"></span>',
 prevArrow: '<span class="chevron left"></span>',
draggable: true,
responsive: [
 {
 breakpoint: 1024,
 settings: {
 slidesToShow: 3,
 slidesToScroll: 3,
 infinite: true,
arrows: true,
dots: false
 }
 },
 {
 breakpoint: 600,
 settings: {
 slidesToShow: 2,
 slidesToScroll: 2,
arrows: true,
dots: false
 }
 },
 {
 breakpoint: 480,
 settings: {
 slidesToShow: 1,
 slidesToScroll: 1,
arrows: true,
dots: false
 }
 }
 ]
});
</script>
   <?php
    return ob_get_clean();
}