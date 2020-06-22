<?php

add_shortcode( 'bets_slider', 'hdc_custom_bets_new' );
function hdc_custom_bets_new(){
    ob_start();
   ?>
<div id="featured-scroller">

<?php
        $args = array(
            'post_type' => 'game',
            'post_status' => 'publish',
            'meta_query'      => array(
                array(
                  'key'     => 'hdc_bet_light_status_key',
                  'value'   => 'white',
                  'compare' => 'like',
                )
            )
        );
        $query = new WP_Query( $args );
        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();
    
                // -- meta box data
                $bet_title = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_title_key', true ) );
                $bet_odds = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_odds_key', true ) );
                $bet_time = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_kickoff_time_key', true ) );
                $bet_date = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_kickoff_date_key', true ) );
                $bet_units = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_units_key', true ) );
                
                $date = new DateTime($bet_date.' '.$bet_time);
    
                echo '
                    <div class="new-bet-card slick-slide">
                    <a href="'.get_the_permalink().'">
                        <p class="blue-text">MATCH</p>
                        <strong>'.wp_trim_words( get_the_title(), 3 ).'</strong>
                        <br>
                        <small class="bet-timestamp">Time: '.$date->format('d.m.y | H.i').'</small>
                        ';
                        
                        $widget_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'mercury-450-317'); if ($widget_img) { ?>
                        <img src="<?php echo esc_url($widget_img[0]); ?>" alt="<?php the_title_attribute(); ?>">
                <?php
                        }   
                echo '  <p class="blue-text">Bet</p>
                        <p class="bet-timestamp" style="margin-top:: 8px !important;">Units: '.$bet_units.'/10</p>
                        Odds<br>
                        <p class="odds-value">'.number_format($bet_odds , 2).'</p>
                        <button class="button-joinbet">JOIN BET</button>
                    </a>
                    </div>
                ';
            }
        }
        wp_reset_postdata();
?>

</div>

<script>
jQuery('#featured-scroller').slick({
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