<?php
if (!defined('DB_NAME')) {
    die('Error: Plugin "affiliate_tools" does not support standalone calls, damned hacker.');
}

/*
Plugin Name: Affiliate Tools
Plugin URI: https://khuyenmaimuasam.com/
Description: Affiliate Tools plugin for Viet Nam. Currently we supports Accesstrade, Massoffer and Lazada's comming soon.
Version: 0.3.17
Author: leduchuy89vn
Author URI:      https://khuyenmaimuasam.com
Min WP Version: 2.6
Max WP Version: 2.6
*/

include_once(plugin_dir_path(__FILE__) . 'functions/affiliate-tools-base.php');
include_once(plugin_dir_path(__FILE__) . 'widget/affiliate-admin-widget.php');

add_action( 'wp_dashboard_setup', array('AffiliateToolsWidget','init') );
add_action( 'admin_init', 'aff_check_update_stats_options' );

if ( ! function_exists( 'aff_get_chart_labels' ) ) {
    /**
     * Get chart labels
     *
     * @param array $args
     * @return array
     */
    function aff_get_chart_labels($start_date, $end_date, $stats_by, $chart_time_format) {
        $label_content = array();

        $date_idx = $start_date;

        while ($date_idx < $end_date) {
            $date_idx = date('Y-m-d', strtotime($date_idx .' + 1 '.$stats_by."s"));
            $str = date($chart_time_format, strtotime($date_idx .''));
            $label_content[] = $str;
        }

        return json_encode($label_content);
    }
}

if ( ! function_exists( 'aff_get_chart_data' ) ) {
    /**
     * Get chart data
     *
     * @param array $args
     * @return array
     */
    function aff_get_chart_data($start_date, $end_date, $raw_data, $stats_by, $chart_time_format) {
        $chart_data = array();
        $data = array();
        $date_idx = $start_date;

        while ($date_idx < $end_date) {
            $date_idx = date('Y-m-d', strtotime($date_idx .' + 1 '.$stats_by."s"));
            $key = date($chart_time_format, strtotime($date_idx));
            $chart_data[$key] = 0;
        }

        $raw_data_count = sizeof($raw_data);
        $idx = 0;

        while ($idx < $raw_data_count) {
            $key = date($chart_time_format, strtotime($raw_data[$idx]['date']));
            $chart_data[$key] = (int)$raw_data[$idx]['count'];
            $idx++;
        }

        $idx = 0;

        $date_idx = $start_date;

        while ($date_idx < $end_date) {
            $date_idx = date('Y-m-d', strtotime($date_idx .' + 1 '.$stats_by."s"));
            $key = date($chart_time_format, strtotime($date_idx));
            $data[] = $chart_data[$key];
        }

        return '[' . implode(", ", $data) . ']';;
    }
}

if ( ! function_exists( 'aff_statistic_link' ) ) {
    /**
     * Statistic link
     *
     * @param array $args
     * @return array
     */
    function aff_statistic_link () {
        global $wpdb;

        $stats_period = get_option('stats_period', 7);
        $stats_by = get_option('stats_by', 'day');

        $end_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        $start_date = date('Y-m-d', strtotime($end_date .' - '.$stats_period.' '.$stats_by));

        if($stats_by ==='day') {
            $time_strlen = 10;
            $chart_time_format = 'd/m';
        } else if($stats_by ==='month') {
            $time_strlen = 7;
            $chart_time_format = 'M Y';
        } else {
            $time_strlen = 4;
            $chart_time_format = 'Y';
        }

        $sql = 'SELECT SUBSTR(`date`, 1, '.$time_strlen.') AS date, COUNT(id) AS count FROM ' . $wpdb->prefix . 'links_stats WHERE `date` BETWEEN %s AND DATE_ADD(%s, INTERVAL 1 DAY) GROUP BY SUBSTR(`date`, 1, '.$time_strlen.')';
        $sql = $wpdb->prepare($sql, $start_date, $end_date);
        $raw_data = $wpdb->get_results($sql, ARRAY_A);

        if ( is_array($raw_data) && sizeof($raw_data) ) {
            $label_content  = aff_get_chart_labels($start_date, $end_date, $stats_by, $chart_time_format);
            $data_content   = aff_get_chart_data($start_date, $end_date, $raw_data, $stats_by, $chart_time_format);

            echo "<canvas id='overview-chart'></canvas>
        <script type='text/javascript'>
            load_overview_chart(".$label_content.", ".$data_content.");
        </script>";
        } else {
            _e('No statistics for given period.', 'affiliate-tools');
        }
    }
}

if ( ! function_exists( 'aff_top_affiliate_link' ) ) {
    /**
     * Get top afffiliate link
     *
     * @param array $args
     * @return array
     */
    function aff_top_affiliate_link() {
        global $wpdb;

        $stats_period = get_option('stats_period', 7);
        $stats_by = get_option('stats_by', 'day');

        $start_date = date('Y-m-d', strtotime($end_date .' -'.$stats_period.' '.$stats_by));
        $end_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

        $sql = 'select *,count(id) from ' . $wpdb->prefix . 'links_stats where `date` between %s and DATE_ADD(%s,INTERVAL 2 DAY) group by (url) ORDER BY (count(id)) DESC ';
        $sql = $wpdb->prepare($sql, $start_date, $end_date);

        $result = $wpdb->get_results($sql, ARRAY_A);

        if (is_array($result) && sizeof($result)) {

            echo "<table width=100%>
            <tr> <td class='col-md-8'><b>Link</b></td> <td class='col-md-2' style='text-align:right;'><b>View</b></td></tr>
            ";
            if(count($result) <= 10) {

                $i=1;
                foreach ($result as $row)  {
                    echo '<tr ';
                    if($i++%2 === 0) {
                        echo 'style="background: rgb(238, 238, 238);"';
                    }
                    echo'><td class=col-md-10 ><a href="'.$row['url'].'">'.$row['title'].'</a></td> <td class=col-md-2 style="text-align:right;">'. $row['count(id)'].'</td> </tr>';
                }
            } else {
                for ($i=0; $i < 10; $i++) {
                    echo '<tr ';
                    if($i%2 === 0) {
                        echo 'style="background: rgb(238, 238, 238);"';
                    }
                    echo '><td class =col-md-10  ><a href="'.$result[$i]['url'].'">'.$result[$i]['title'].'</a></td> <td class =col-md-2 style="text-align:right;" >'. $result[$i]['count(id)'].'</td> </tr>';
                }

            }
            echo "</table>";

        } else {
            _e('No statistics for given period.', 'affiliate-tools');
        }
    }
}

if ( ! function_exists( 'aff_enqueue_admin_scripts' ) ) {
    /**
     * Get top afffiliate link
     *
     * @param array $args
     * @return array
     */
    function aff_enqueue_admin_scripts() {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'chart', plugins_url( '/js/Chart.min.js', __FILE__), array(), '0.0.1', false );
        wp_enqueue_script( 'init-chart', plugins_url( '/js/init-chart.js', __FILE__), array(), '0.0.1', false );
        wp_enqueue_script( 'aff-select2', plugins_url( '/js/select2.min.js', __FILE__), array(), '4.0.3', false );
        aff_script_params();
    }
}

if ( ! function_exists( 'aff_enqueue_admin_styles' ) ) {
    /**
     * Get top afffiliate link
     *
     * @param array $args
     * @return array
     */
    function aff_enqueue_admin_styles() {
        wp_enqueue_style('aff-select2', plugins_url( '/public/assets/css/select2.min.css', __FILE__) );
        wp_enqueue_style('affiliate-tools', plugins_url( '/public/assets/css/aff-widget.css', __FILE__) );
    }
}

if ( ! function_exists( 'aff_script_params' ) ) {
    /**
     * XXX
     *
     * @param array $args
     * @return array
     */
    function aff_script_params() {
        $aff_script_params = array(
            'stats_period' => get_option('stats_period')
        );
        wp_localize_script( 'init-chart', 'scriptParams', $aff_script_params );
    }
}

if ( ! function_exists( 'aff_check_update_stats_options' ) ) {
    /**
     * Get top afffiliate link
     *
     * @param array $args
     * @return array
     */
    function aff_check_update_stats_options() {

        if (isset($_POST['stats_by'])
            && isset($_POST['stats_period'])
            && (function_exists('wp_verify_nonce'))
        ) {
            if (
                ! isset( $_POST['stats_options_nonce_field'] )
                || ! wp_verify_nonce( $_POST['stats_options_nonce_field'], 'submit_stats_options' )
            ) {
                wp_die( '<h1>Sorry, your account did not verify!</h1>' );
            } else {
                $stats_by = sanitize_text_field( $_POST['stats_by'] );
                update_option('stats_by', $stats_by);

                $stats_period = intval( $_POST['stats_period'] );
                update_option('stats_period', $stats_period);
            }
        }
        aff_script_params();
    }
}

function afftools_action_links( $links, $file ) {

    $settings_link = '<a href="' . admin_url( 'options-general.php?page=affiliate-tools-viet-nam%2Ffunctions%2Faffiliate-tools-admin.php' ) . '">' . esc_html__( 'Settings', 'affiliate-tools' ) . '</a>';

    if ( $file == 'affiliate-tools-viet-nam/affiliate-tools-viet-nam.php' )
        array_unshift( $links, $settings_link );

    return $links;
}

if (is_admin()) {

    include_once(plugin_dir_path(__FILE__) . 'functions/affiliate-tools-admin.php');
    new AffiliateToolsAdmin();
    aff_script_params();
    aff_enqueue_admin_scripts();
    aff_enqueue_admin_styles();

    add_filter( 'plugin_action_links', 'afftools_action_links', 10, 2 );
} else {

    include_once(plugin_dir_path(__FILE__) . 'functions/affiliate-tools-parser.php');
    new AffiliateToolsParser();
}

if ( function_exists('register_uninstall_hook') ) {
    register_activation_hook(__FILE__, array('AffiliateToolsAdmin', 'activate'));
    register_deactivation_hook(__FILE__, array('AffiliateToolsAdmin','deactivate'));
    register_uninstall_hook(__FILE__, array('AffiliateToolsAdmin', 'uninstall'));
}

?>