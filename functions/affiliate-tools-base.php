<?php
if (!defined('DB_NAME'))
    die('Error: Plugin "affiliate-tools" does not support standalone calls, damned hacker.');

const AFF_OPTIONS_KEY = 'AffiliateToolsBase';

include_once(plugin_dir_path(__FILE__) . 'options.php');

class AffiliateToolsBase {

    var $options; /*all plugin options*/

    function init_lang() {

        $plugin_dir = basename(dirname(__FILE__));
        load_plugin_textdomain('affiliate-tools', false, $plugin_dir . '/lang');
    }

    public static function activate() {

        global $wpdb;
        $sql1 = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . 'links_stats(`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,`url` VARCHAR(255), `date` DATETIME, `title` NVARCHAR(50), PRIMARY KEY (`id`))';
        $res = $wpdb->query($sql1);
        
        $sql2 = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . 'masklinks(`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,`url` VARCHAR(255),  PRIMARY KEY (`id`))';
        $res = $wpdb->query($sql2);
    }

    public static function deactivate() {
        
    }
    
    public static function uninstall() {

        global $wpdb;
        
        $sql1 = 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'links_stats';
        $res = $wpdb->query($sql1);
        
        $sql2 = 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'masklinks';
        $res = $wpdb->query($sql2);
        
        delete_option(AFF_OPTIONS_KEY);
    }

    function update_options() {

        $opt = get_default_options();
        foreach ($opt as $key => $arr) {
            $name = $arr['new_name'];
            if (!isset($this->options[$name])) {
                $this->options[$name] = '0';
            }
        }

        foreach ($this->options as $i => $val){
            $this->options[$i] = stripslashes($val);
        }

        $r = update_option('AffiliateToolsBase', $this->options);
        if (!$r) {
            if (serialize($this->options) != serialize(get_option(AFF_OPTIONS_KEY))) {
                init_lang();
                echo '<div class="error">' . __('Failed to update options!', 'affiliate-tools') . '</div>';
            }
        }

    }

    function load_options() {

        global $wpdb;
        $opt = get_default_options();
        $update = false;
        
        $this->options = get_option(AFF_OPTIONS_KEY);

        if (!$this->options) {
            $this->options = array();
        }

        /*check if options are fine*/
        foreach ($opt as $key => $arr) {

            $name = $arr['new_name'];
            if (!isset($this->options[$name]) && $arr['def_value']) /* no option value, but it should be*/ {
                /*try to get old version*/
                if ($arr['old_name']) {
                    $val = get_option($arr['old_name'], 'omg');
                    /*set default value. we can't use default false return because user value could be set to false*/
                    if ($val === 'omg')
                        $val = $arr['def_value'];
                } else {
                    $val = $arr['def_value'];
                }

                $this->options[$name] = $val;
                $update = true;
            }
        }

        /*upgrade or just some kind of shit*/
        if ($update) {

            /*if we're going back from old version - let's check for excludes...*/
            if (!$this->options['aff_exclude_links']) {
                $val = get_option('affiliatetools_exclude_links');
                if ($val)
                    $this->options['aff_exclude_links'] = $val;
            }
            $this->update_options();
        }

        /*add values to exclude*/
        $exclude_links = array();
        $site = get_option('home');
        if (!$site)
            $site = get_option('siteurl');
        $this->options['site'] = $site;
        $site=str_replace(array("http://","https://"),'',$site);
        $p = strpos($site,'/');
        
        if ($p!==FALSE) {
            $site = substr($site, 0, $p);/*site root is excluded from masking, not only blog url*/
        }

        $exclude_links[] = "http://".$site;
        $exclude_links[] = "https://".$site;
        $exclude_links[] = 'javascript';
        $exclude_links[] = 'mailto';
        $exclude_links[] = 'skype';
        $exclude_links[] = '/'; /* for relative links */
        $exclude_links[] = '#'; /* for internal links */

        $a = @explode("\n", isset($this->options['exclude_links']));
        for ($i = 0; $i < sizeof($a); $i++) {
            $a[$i] = trim($a[$i]);
        }

        $this->options['exclude_links_'] = @array_merge($exclude_links, $a);
        
        /* Statistic
        if ($this->options['aff_stats']) {
            $flush = get_option('AffiliateToolsBase_flush');
            // Flush every 24 hours
            if (!$flush || $flush < time() - 3600 * 24 * 62 ) {
                $sql = 'DELETE FROM ' . $wpdb->prefix . 'links_stats WHERE `date`<DATE_SUB(curdate(), INTERVAL %d DAY)';
                $wpdb->query($wpdb->prepare($sql, $this->options['aff_keep_stats']));
                update_option('AffiliateToolsBase_flush', time());
            }
        }
        */
        
    }
}

?>