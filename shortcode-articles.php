<?php
add_shortcode( 'articles_grid', 'rander_articles_grid' );
function rander_articles_grid(){
    ob_start();
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish'
        );
        $query = new WP_Query( $args );
        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();
                echo '
                    <div class="new-bet-card hdc-responsive-card" style="max-width: 22%;">
                        <a href="'.get_the_permalink().'" style="text-decoration: none;">';
                        $widget_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'mercury-450-317'); if ($widget_img) { ?>
                            <img src="<?php echo esc_url($widget_img[0]); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php
                            } 
                        echo '<h3>'.get_the_title().'</h3>
                            <p class="std-text-size">'.get_the_excerpt() .'</p>
                        </a>
                    </div>
                ';
            }
        }else{
            echo "<i><big>No Article Posted Yet</big></i>";
        }
        wp_reset_postdata();
    return ob_get_clean();
}