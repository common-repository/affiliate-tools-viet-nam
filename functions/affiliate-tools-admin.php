<?php
if (!defined('DB_NAME'))
    die('Error: Plugin "affiliate-tools" does not support standalone calls, damned hacker.');

include_once(plugin_dir_path(__FILE__) . 'options.php');
include_once(plugin_dir_path(__FILE__) . 'option-layouts.php');
include_once(plugin_dir_path(__FILE__) . 'affiliate-tools-base.php');

class AffiliateToolsAdmin extends AffiliateToolsBase {

    function AffiliateToolsAdmin() {

        $this->init_lang();
        $this->load_options();
        add_action('save_post', array($this, 'save_postdata'));
        add_action('do_meta_boxes', array($this, 'add_custom_box'), 15, 2);
        add_action('admin_menu', array($this, 'modify_menu'));
    }

    
    public static function activate() {
        parent::activate();
    }

    public static function deactivate() {
        parent::deactivate();
    }

    public static function uninstall() {
        parent::uninstall();
    }

    function save_postdata($post_id) {

        if (!wp_verify_nonce($_REQUEST['wp_noextrenallinks_noncename'], plugin_basename(__FILE__))) {
            return $post_id;
        }

        if ('page' == $_REQUEST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
        }
        update_post_meta($post_id, 'wp_noextrenallinks_mask_links', $_REQUEST['wp_noextrenallinks_mask_links']);
    }

    function add_custom_box($page, $context) {

        add_meta_box('wp_noextrenallinks_sectionid1', __('Link masking for this post', 'affiliate-tools'),
                    array($this, 'inner_custom_box1'),
                    'post', 'advanced');

        add_meta_box('wp_noextrenallinks_sectionid1', __('Link masking for this post', 'affiliate-tools'),
                    array($this, 'inner_custom_box1'),
                    'page', 'advanced');
    }

    function inner_custom_box1() {

        global $post;
        echo '<input type="hidden" name="wp_noextrenallinks_noncename" id="wp_noextrenallinks_noncename" value="' .
            wp_create_nonce(plugin_basename(__FILE__)) . '" />';
        $mask = get_post_meta($post->ID, 'wp_noextrenallinks_mask_links', true);
        if ($mask === '')
            $mask = 0;
        echo '<input type="radio" name="wp_noextrenallinks_mask_links" value="0"';
        if ($mask == 0) echo ' checked';
        echo '>' . __('Use default policy from plugin settings', 'affiliate-tools') . '<br><input type="radio" name="wp_noextrenallinks_mask_links" value="2"';
        if ($mask == 2) echo ' checked';
        echo '>' . __('Don`t mask links', 'affiliate-tools');
    }
    
    function update() {
        
        if ( isset($_REQUEST['options']) ) {
            if (
                ! isset( $_POST['aff_tools_nonce_field'] )
                || ! wp_verify_nonce( $_POST['aff_tools_nonce_field'], 'submit_aff_tools_options' ) 
            ) {
               wp_die( '<h1>Sorry, your account did not verify!</h1>' );
            } else {
                $this->options = $_REQUEST['options'];
                $this->update_options(); 
                echo '<div class="updated">' . __('Options updated.', 'affiliate-tools') . '</div>';
                $this->load_options();
            }
        }
    }


    function modify_menu() {

        add_options_page(
            'Affiliate Tools',
            'Affiliate Tools',
            'manage_options',
            __FILE__,
            array($this, 'admin_options')
        );
    }

    function show_navi() {

        if (isset($_REQUEST['action']) == 'stats') {
            ?>
            <a href="?page=<?php echo $_REQUEST['page']; ?>"
               class="button-primary"><?php _e('View options', 'affiliate-tools'); ?></a>
        <?php } else { ?>
            <a href="?page=<?php echo $_REQUEST['page']; ?>&action=stats"
               class="button-primary"><?php _e('View Stats', 'affiliate-tools'); ?></a>
        <?php } ?>
        <a href="https://www.google.com.vn/search?q=affiliate+tools+for+Việt+Nam"
           class="button-primary"><?php _e('Feedback', 'affiliate-tools'); ?></a>
        <?php
    }

    function view_stats() {
        global $wpdb;
        ?>
        <form method="post" action="">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>">
        <?php wp_nonce_field('update-options');
        $this->show_navi(); ?><br><br>
        <?php

        if (!$this->options['aff_stats']) {
            _e('Statistic for plugin is disabled! Please, go to options page and enable it via checkbox "Log all outgoing clicks".', 'affiliate-tools');
            echo '</form>';
        } else {
            if ($_REQUEST['date1'])
                $date1 = $_REQUEST['date1'];
            else
                $date1 = date('Y-m-d');
            if ($_REQUEST['date2'])
                $date2 = $_REQUEST['date2'];
            else
                $date2 = date('Y-m-d');
            _e('View stats from', 'affiliate-tools');
            ?>
            <input type="text" name="date1" value="<?php echo $date1; ?>"> <?php _e('to', 'affiliate-tools'); ?>
            <input type="text" name="date2" value="<?php echo $date2; ?>"><input type="submit"
                                                                                 value="<?php _e('View', 'affiliate-tools'); ?>"
                                                                                 class="button-primary">
            </form><br>
            <style>.urlul {
                    padding: 5px 0px 0px 25px;
                }</style>
            <?php
            
            $sql = 'select * from ' . $wpdb->prefix . 'links_stats where `date` between %s and DATE_ADD(%s,INTERVAL 1 DAY)';
            $sql = $wpdb->prepare($sql, $date1, $date2);

            $result = $wpdb->get_results($sql, ARRAY_A);

            if (is_array($result) && sizeof($result)) {
                $out = array();
                foreach ($result as $row) {

                    $nfo = parse_url($row['url']);

                    if ($row['url'] && $nfo['host'])
                        $out[$nfo['host']][$row['url']]++;
                }
                foreach ($out as $host => $arr) {
                    echo '<br>' . $host . '<ul class="urlul">';
                    foreach ($arr as $url => $outs)
                        echo '<li><a href="' . $url . '">' . $url . '</a> (' . $outs . ')</li>';
                    echo '</ul>';
                }
            } else
                _e('No statistics for given period.', 'affiliate-tools');
        }

    }


    function option_page() {

        ?>
        <form method="post" action="">
            <?php wp_nonce_field('update-options');
            $this->show_navi();?>
            <br>
            <?php echo '<h2>' . __('Global links masking settings', 'affiliate-tools') . '</h2>' . '(' . __('You can also disable plugin on per-post basis', 'affiliate-tools') . ')'; ?>
            <br><br>
            <?php

            $opt = get_default_options();

            echo '<h3>' . __('Affiliate Link', 'affiliate-tools') . '</h3><p>' . __('Config plugin with your affiliate (AccessTrade, MasOffer) account.', 'affiliate-tools') . '</p>';
            $this->show_option_group($opt, 'aff_platform');
            
            // Masking type
            echo '<h3>' . __('Choose masking type', 'affiliate-tools') . '</h3><p>' . __('Default masking type is via 302 redirects. Please choose one of the following mods if you do not like it:', 'affiliate-tools') . '</p>';
            $this->show_option_group($opt, 'type');

            // What mask
            echo '<h3>' . __('What to mask', 'affiliate-tools') . '</h3>';
            $this->show_option_group($opt, 'what');

            echo '<h3>' . __('What to exclude from masking', 'affiliate-tools') . '</h3>';
            $this->show_option_group($opt, 'exclude');

            echo '<h3>' . __('Common configuration', 'affiliate-tools') . '</h3>';
            $this->show_option_group($opt, 'common');

            echo '<h3>' . __('Link encoding', 'affiliate-tools') . '</h3><p>' . __('Those options are not secure enough if you want to protect your data from someone but are quite enough to make link not human-readable. Please choose one of them:', 'affiliate-tools') . '</p>';
            $this->show_option_group($opt, 'encode');

            echo '<h3>' . __('Configuration for javascript redirects (if enabled)', 'affiliate-tools') . '</h3>';
            $this->show_option_group($opt, 'java');
            
            ?>
            
            <input type="submit" name="submit" value="<?php _e('Save Changes', 'affiliate-tools') ?>"
                     class="button-primary"/>
            <?php echo wp_nonce_field( 'submit_aff_tools_options', 'aff_tools_nonce_field' ); ?>
        </form>
    <?php
    }

    function show_option_group($opt, $name) {

        foreach ($opt as $arr) {
            if ($arr['grp'] === $name) {
                $this->show_option($arr);
                echo '<br>';
            }
        }
    }

    function show_option($opt) {

        switch($opt['type']) {
            case 'chk'          : $layout = get_chk_option($this->options, $opt);               break;
            case 'txt'          : $layout = get_txt_option($this->options, $opt);               break;
            case 'text'         : $layout = get_text_option($this->options, $opt);              break;
            case 'slt'          : $layout = get_slt_option($this->options, $opt);               break;
            case 'site_slt'     : $layout = get_custom_site_slt_option($this->options, $opt);   break;
            case 'aff_plat_key' : $layout = get_aff_plat_key_option($this->options, $opt);      break;
        }
        echo $layout;
    }
 
    function admin_options() {

        echo '<div class="wrap"><h2>Affiliate Tools Settings</h2>';
        
        if (isset($_REQUEST['submit'])){
            $this->update();
        }
        
        if (isset($_REQUEST['action']) == 'stats') {
            $this->view_stats();
        } else {
            $this->option_page();
        }
        
        echo '</div>';
    }
}

?>