<?php
if (!defined('DB_NAME')) {
    die('Error: Plugin "affiliate-tools" does not support standalone calls, damned hacker.');
}

include_once(plugin_dir_path(__FILE__) . 'accesstrade-affiliate-factory.php');
include_once(plugin_dir_path(__FILE__) . 'masoffer-affiliate-factory.php');
include_once(plugin_dir_path(__FILE__) . '../utilities.php');

if ( ! function_exists( 'aff_affiliate_factory' ) ) {
/**
 * XXX
 *
 * @param array $args
 * @return array
 */
function aff_affiliate_factory($key = BaseAffiliateURLFactory::factory_id) {

	$base = new BaseAffiliateURLFactory;
	$mo = new MasofferAffiliateURLFactory;
	$at = new AccesstradeAffiliateURLFactory;
	$AFFILIATE_FACTORIES = array($base, $mo, $at);

	foreach ($AFFILIATE_FACTORIES as $factory) {
		if ($factory::$factory_id == $key) {
			return $factory;
		}
	}
	return $AFFILIATE_FACTORIES[0];
}
}

if ( ! function_exists( 'aff_get_aff_option' ) ) {
/**
 * XXX
 *
 * @param array $args
 * @return array
 */
function aff_get_aff_option($name) {
	$setting = new AffiliateToolsBase;
	$setting->load_options();
	return $setting->options[$name];
}
}

if ( ! function_exists( 'aff_get_affiliate_url' ) ) {
/**
 * XXX
 *
 * @param array $args
 * @return array
 */
function aff_get_affiliate_url($url = "") {
	
	$domain = extract_domain($url);

	$platform = aff_get_aff_option('platform');

    $cs_at_platform = explode(",", aff_get_aff_option('cs_at_platform'));
    $cs_mo_platform = explode(",", aff_get_aff_option('cs_mo_platform'));

    // If destination site has manual-fixed platform by admin
    if (in_array($domain, $cs_at_platform)) {
        $platform = "accesstrade";
    }
    if (in_array($domain, $cs_mo_platform)) {
        $platform = "masoffer";
    }

    $factory = aff_affiliate_factory($platform);
	$affiliate_url = $url;
	
	if ($factory->allow_domain($domain)) {
		$affiliate_url = $factory->affiliate_url($url);
	}
	return $affiliate_url;
}
}

if ( ! function_exists( 'aff_affiliate_url_action' ) ) {
/**
 * XXX
 *
 * @param array $args
 * @return array
 */
function aff_affiliate_url_action($transport = '') {
	$aff_url = aff_get_affiliate_url($transport->param1);
	$transport->return = $aff_url;
}
}

add_action( 'affiliate_url', 'aff_affiliate_url_action', 10, 1 );

?>