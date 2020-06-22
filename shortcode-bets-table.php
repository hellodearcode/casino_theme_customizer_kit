<?php
add_shortcode( 'bets_table', 'hdc_custom_bets_table' );
function hdc_custom_bets_table(){
    ob_start();
    $args = array(
        'post_type' => 'game',
        'post_status' => 'publish'
    );
    $query = new WP_Query( $args );
    if( $query->have_posts() ){
?>
    <table border="1" id="settled-bets">
        <thead style="background: black;color: white;">
            <tr align="center">
                <th class="hide-on-mobile">Time</th>
                <th>Game</th>
                <th>Bet</th>
                <th class="hide-on-mobile">Units</th>
                <th>Odds</th>
                <th>Status</th>
            </td>
        </thead>
        <tbody>
<?php
            while( $query->have_posts() ){
                $query->the_post();
    
                // -- meta box data
                $bet_title = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_title_key', true ) );
                $bet_odds = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_odds_key', true ) );
                $bet_units = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_units_key', true ) );
                $bet_time = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_kickoff_time_key', true ) );
                $bet_date = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_kickoff_date_key', true ) );
                $bet_status = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_light_status_key', true ) );
                
                $date = new DateTime($bet_date.' '.$bet_time);
    
                echo '
                    <tr class="stylish-tr" onclick="window.open(\''.get_the_permalink().'\')">
                        <td class="hide-on-mobile">'.$date->format('d.m.y | H.i').'</td>
                        <td>'.esc_html(get_the_title()).'</td>
                        <td>'.$bet_title.'</td>
                        <td class="hide-on-mobile">'.$bet_units.'/10</td>
                        <td>'.number_format($bet_odds , 2).'</td>
                        <td align="center"><span class="bulletlamp" style="background: '.$bet_status.';"></span></td>
                    </tr>
                ';
            }
        }
        wp_reset_postdata();
?>
            </tbody>
            </table>
            <script>
            jQuery(document).ready( function () {
                jQuery('#settled-bets').DataTable();
            } );
            </script>
<?php
    return ob_get_clean();
}
?>