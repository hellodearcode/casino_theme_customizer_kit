<?php
add_shortcode( 'bonus_grid', 'hdc_custom_bonus_grid' );
function hdc_custom_bonus_grid(){
    ob_start();
        $args = array(
            'post_type' => 'bonus',
            'post_status' => 'publish'
        );
        $query = new WP_Query( $args );
        if( $query->have_posts() ){
?>
<div class="space-casinos-3-archive-item box-100 relative hide-on-mobile">
    <div class="space-casinos-3-archive-item-ins relative" style="background:black;">
        <div class="space-casinos-3-archive-item-logo box-25 relative">
            <div class="space-casinos-3-archive-item-logo-ins box-100 text-center relative">
               <b style="color: white;">Bookmaker</b>
            </div>
        </div>
        <div class="space-casinos-3-archive-item-logo box-50 relative">
            <div class="space-casinos-3-archive-item-logo-ins box-100 text-center relative">
               <b style="color: white;">Bonus</b>
            </div>
        </div>
        <div class="space-casinos-3-archive-item-button box-25 relative">
            <div class="space-casinos-3-archive-item-button-ins box-100 text-center relative">
                <b style="color: white;">Claim</b>
            </div>
        </div>
    </div>
</div>

<?php

            while( $query->have_posts() ){
                $query->the_post();
                $bonus_allowed_html = array(
                    'a' => array(
                        'href' => true,
                        'title' => true,
                        'target' => true,
                        'rel' => true
                    ),
                    'br' => array(),
                    'em' => array(),
                    'strong' => array(),
                    'span' => array(),
                    'p' => array()
                );
                // -- meta box data
                $bonus_text_notice = wp_kses( get_post_meta( get_the_ID(), 'bonus_text_notice_key', true ) , $bonus_allowed_html );
                $bonus_min_odds = wp_kses( get_post_meta( get_the_ID(), 'bonus_min_odds_key', true ) , $bonus_allowed_html );
                $get_bonuslink = esc_url( get_post_meta( get_the_ID(), 'bonus_external_link', true ) );
                if( empty($get_bonuslink) ) {
                    $get_bonuslink = get_the_permalink();
                }
?>
<div class="space-casinos-3-archive-item box-100 relative">
    <div class="space-casinos-3-archive-item-ins relative">
        <div class="space-casinos-3-archive-item-logo box-25 relative">
            <div class="space-casinos-3-archive-item-logo-ins box-100 text-center relative">
                <?php $widget_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'mercury-450-317'); if ($widget_img) { ?>
                        <img src="<?php echo esc_url($widget_img[0]); ?>" alt="<?php the_title_attribute(); ?>"  width="130">
                <?php
                        } 
                ?>
            </div>
        </div>
        <div class="space-casinos-3-archive-item-rating box-50 relative">
            <div class="space-casinos-3-archive-item-rating-ins box-100 text-center relative">
                <u onclick="window.open('<?=get_the_permalink()?>')"><b><?=get_the_title()?></b></u>
                <p class="hide-on-desktop">
                    <u style="font-size: 13px;">
                        Wagering requirement: <?=wp_trim_words( $bonus_text_notice, 3 )?>
                        <br>
                        Min. Odds: <?=number_format($bonus_min_odds,2)?>
                    </u>
                </p>
            </div>
        </div>
        <div class="space-casinos-3-archive-item-button box-25 relative">
            <div class="space-casinos-3-archive-item-button-ins box-100 text-center relative">
                <button class="bonus-btn" onclick="window.open('<?=$get_bonuslink?>')">
                    CLAIM BONUS
                </button>
            </div>
        </div>
    </div>
</div>
<?php
            }
        }
        wp_reset_postdata();
    return ob_get_clean();
}