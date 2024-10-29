<?php
if (!defined('DB_NAME')) {
    die('Error: Plugin "affiliate-tools" does not support standalone calls, damned hacker.');
}

include_once(plugin_dir_path(__FILE__) . 'base-affiliate-factory.php');
include_once(plugin_dir_path(__FILE__) . '../utilities.php');

class MasofferAffiliateURLFactory extends BaseAffiliateURLFactory {

	public static $factory_id 	= "masoffer";
	public static $URL_TEMP 	= "http://go.masoffer.net/v0/%offer_key%/%pub_key%/?aff_sub1=%utm_source%&aff_sub2=%utm_medium%&aff_sub3=%utm_campaign%&aff_sub4=%utm_content%s&go=%go%";

	function secret_key() {
		return aff_get_aff_option('mo_sec_key');
	}

	function affiliate_url($url) {
		
		$detect = new Mobile_Detect;
		
		$domain = extract_domain($url);
		$offer_key = BaseAffiliateURLFactory::$OFFER_KEY[$domain];
		if (!$offer_key) { // Doesn't support
			return BaseAffiliateURLFactory::repair_affiliate_url($url);;
		}
		
		$url_params = BaseAffiliateURLFactory::$UTM_PARAMS;
		$url_params['offer_key'] = $offer_key;
		$url_params['pub_key'] = $this->secret_key();
		$url_params['go'] = urlencode($url);
		
		$forceMobile = aff_get_aff_option('aff_force_mobile');
		$isMobile = $detect->isMobile() || $detect->isTablet();
		
		if ($forceMobile && $isMobile && $url_params['offer_key'] == 'lazada') {
			$url_params['offer_key'] = 'lazada-mobile';
		}
		
		$affiliate_url = format_str($this::$URL_TEMP, $url_params);

		return $affiliate_url;
	}
	
	public function allow_domain ($domain = '') {
		return parent::allow_domain($domain);
	}

}

?>