<?php
add_shortcode( 'bets_spreadsheet', 'hdc_bet_spreadsheet_page' );
function hdc_bet_spreadsheet_page(){
    ob_start();
    $args = array(
        'post_type' => 'game',
        'post_status' => 'publish'
    );
    $query = new WP_Query( $args );
    if( $query->have_posts() ){
        
        // -- calculation param
        $total_bets = 0.0;
        $won = $lost = array();
        $hitrate = 0.0;
        $units_in = 0.0;
        $units_out = 0.0;
        $profit = 0.0;
        $roi = 0.0;


        // -- total best Count
        $total_bets = $query->found_posts;

        while( $query->have_posts() ){
            $query->the_post();

            // -- meta box data
            $bet_odds = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_odds_key', true ) );
            $bet_stake = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_units_key', true ) );
            $bet_status = esc_html( get_post_meta( get_the_ID(), 'hdc_bet_light_status_key', true ) );
            
            // -- total Bets Won
            if($bet_status == "green"){
                array_push($won,get_the_ID());
                // -- in unit calc
                $units_in += floatval(floatval($bet_odds) * floatval($bet_stake));
            }
            // -- total bet lost
            if($bet_status == "red"){
                array_push($lost,get_the_ID());
            }

            // -- outs unit calc
            $units_out += floatval($bet_stake);

        }

        //-- hit rate counter 
        $hitrate = ( (count($won)/$total_bets) * 100);
        //-- profit
        $profit = floatval(floatval($units_in) - floatval($units_out));
        // -- ROI calc
        if($units_out >= 1){
            $roi = ( ($profit / $units_out) * 100.0 );
        }

        // -- print data
        ?>
        <div class="space-casinos-3-archive-item box-100 relative">
            <div class="space-casinos-3-archive-item-ins relative" style="box-shadow:unset;">
                <div class="space-casinos-3-archive-item-logo box-50 relative">
                    <div class="space-casinos-3-archive-item-logo-ins box-100 text-center relative">
                        <img src="/wp-content/uploads/2020/06/oddsbrother-spreadsheet.jpeg" style="border-radius: 50%;" width="65%">
                    </div>
                </div>
                <div class="space-casinos-3-archive-item-rating box-25 relative">
                    <div class="space-casinos-3-archive-item-rating-ins box-100 text-center relative">
                        <h5 style="color:#4490ba;">Total Bets</h5>
                        <p>Bets: <?=$total_bets?></p>
                        <p>Won: <?=count($won)?></p>
                        <p>Lost: <?=count($lost)?></p>
                        <p style="color: #6fc16f;"><b>Hit Rate: <?=$hitrate?> %</b></p>
                        <div class="hide-on-desktop">
                            <br><hr><br>
                        </div>
                    </div>
                </div>
                <div class="space-casinos-3-archive-item-button box-25 relative">
                    <div class="space-casinos-3-archive-item-button-ins box-100 text-center relative">
                        <h5 style="color:#4490ba;">Results</h5>
                        <p>Units In: <?=$units_in?></p>
                        <p>Units Out: <?=$units_out?></p>
                        <p style="color: #6fc16f;"><b>Profit: <?=$profit?></b></p>
                        <p style="color: #6fc16f;"><b>ROI: <?=$roi?> %</b></p>
                    </div>
                </div>
            </div>
        </div>

        <?php
        // -- result calculations
    }
        wp_reset_postdata();
    return ob_get_clean();
}
?>