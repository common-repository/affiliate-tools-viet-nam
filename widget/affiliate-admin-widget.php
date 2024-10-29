<?php
if (!defined('DB_NAME'))
    die('Error: Plugin "affiliate_tools" does not support standalone calls, damned hacker.');

class AffiliateToolsWidget {

    var $opt ;

    const wid = 'affiliate_tools_widget';
    
    public static function init() {
        wp_add_dashboard_widget(
            "id_chart_line",                                //A unique slug/ID
            __( 'Affiliate Statistic', 'nouveau' ),   //Visible name for the widget
            array('AffiliateToolsWidget', 'chart_content'),    //Callback for the main widget content
            array('AffiliateToolsWidget', 'dashboard_widget_config_handle')    //Callback for the main widget content
        );
    }
    
    public static function stats_dashboard_widget_control() {
        echo AffiliateToolsWidget::chart_content();
    }
    
    public static function dashboard_widget_config_handle() {
        
        $seleVal = get_option('stats_by');
       
        echo "<div class='config-containter'  >
        <div class='config-container'>
            <span class='config-title'>Chart stats by: </span>
                <select id='select_time' onchange='onChangeTime()' name='stats_by' value='".$seleVal."' onload='onChangeTime()' style='width: 130px;'>
                    <option value='day' "; if ($seleVal === 'day') echo "selected = 'selected'"; echo ">Day</option>
                    <option value='month' "; if ($seleVal === 'month') echo "selected = 'selected'"; echo ">Month</option>
                    <option value='year' "; if ($seleVal === 'year') echo "selected = 'selected'"; echo ">Year</option>
                </select>
            <div id='time_period_container'></div>
        </div></div>";
        echo wp_nonce_field( 'submit_stats_options', 'stats_options_nonce_field' );
        echo "<script>
            jQuery(window).load(function() {
                onChangeTime();
            });
        </script>";
    }
    
    public static function chart_content() {
        
        $seleVal = get_option('stats_by');
       
        echo "
        <div class='tab-container'>
            <input type='button' onclick='onClickBtnT(true)' id='btn_stats'  value='Top Links' class='toggleBtn' style=' position :relative ; ' />
            <input type='button' onclick='onClickBtnT(false)' id='btn_top'  value='Overview' class='toggleBtn' style=' position :initial; background : #f2f2f2;' /> 
        </div>
        <div id='stats_container'><div id='stats_panel' >";

        aff_statistic_link();

        echo "</div>
        
        <div id='top10_panel' style='display: none;' >";
        aff_top_affiliate_link();
        echo "</div></div>";
    }
   

    /**
     * Gets the options for a widget of the specified name.
     *
     * @param string $widget_id Optional. If provided, will only get options for the specified widget.
     * @return array An associative array containing the widget's options and values. False if no opts.
     */
    public static function get_dashboard_widget_options( $widget_id='' )
    {
        //Fetch ALL dashboard widget options from the db...
        $opts = get_option( 'dashboard_widget_options' );

        //If no widget is specified, return everything
        if ( empty( $widget_id ) )
            return $opts;

        //If we request a widget and it exists, return it
        if ( isset( $opts[$widget_id] ) )
            return $opts[$widget_id];

        //Something went wrong...
        return false;
    }

    /**
     * Gets one specific option for the specified widget.
     * @param $widget_id
     * @param $option
     * @param null $default
     *
     * @return string
     */
    public static function get_dashboard_widget_option( $widget_id, $option, $default=NULL ) {

        $opts = self::get_dashboard_widget_options($widget_id);

        //If widget opts dont exist, return false
        if ( ! $opts )
            return false;

        //Otherwise fetch the option or use default
        if ( isset( $opts[$option] ) && ! empty($opts[$option]) )
            return $opts[$option];
        else
            return ( isset($default) ) ? $default : false;

    }

    /**
     * Saves an array of options for a single dashboard widget to the database.
     * Can also be used to define default values for a widget.
     *
     * @param string $widget_id The name of the widget being updated
     * @param array $args An associative array of options being saved.
     * @param bool $add_only If true, options will not be added if widget options already exist
     */
    public static function update_dashboard_widget_options( $widget_id , $args=array(), $add_only=false )
    {
        $opts = get_option( 'dashboard_widget_options' );

        //Get just our widget's options, or set empty array
        $w_opts = ( isset( $opts[$widget_id] ) ) ? $opts[$widget_id] : array();

        if ( $add_only ) {
            //Flesh out any missing options (existing ones overwrite new ones)
            $opts[$widget_id] = array_merge($args,$w_opts);
        }
        else {
            //Merge new options with existing ones, and add it back to the widgets array
            $opts[$widget_id] = array_merge($w_opts,$args);
        }

        //Save the entire widgets array back to the db
        return update_option('dashboard_widget_options', $opts);
    }
}

?>