<?php
if (!defined('DB_NAME')) {
    die('Error: Plugin "affiliate-tools" does not support standalone calls, damned hacker.');
}

include_once(plugin_dir_path(__FILE__) . 'base-affiliate-factory.php');
include_once(plugin_dir_path(__FILE__) . '../utilities.php');

/*
	************************************************************
	Here's accesstrade sample:
	************************************************************
	- Full format 	: https://pub.accesstrade.vn/deep_link/<site_key>?url=<encoded_url>&utm_source=<utm_source>&utm_medium=<utm_medium>&utm_campaign=<utm_campaign>&utm_content=<utm_content>
	- Sample 		: https://pub.accesstrade.vn/deep_link/4348613376218277542?url=http%3A%2F%2Ftiki.vn%2Fthiet-bi-kts-phu-kien-so%2Fc1975&utm_source=facebook
	- Docs 			: https://pub.accesstrade.vn/tools/deep_link
	************************************************************
*/

class AccesstradeAffiliateURLFactory extends BaseAffiliateURLFactory {	
	
	public static $factory_id 	= "accesstrade";
	public static $URL_TEMP 	= "https://pub.accesstrade.vn/deep_link/%secret_key%?url=%encoded_url%&utm_source=%utm_source%&utm_medium=%utm_medium%&utm_campaign=%utm_campaign%&utm_content=%utm_content%";

	function secret_key() {
		return aff_get_aff_option('at_sec_key');
	}

	function affiliate_url($url) {
		
		$domain = extract_domain($url);
		
		$detect = new Mobile_Detect;
		
		$url_params = BaseAffiliateURLFactory::$UTM_PARAMS;
		$url_params['secret_key'] = $this->secret_key();
		
		$encoded_url = $url . "";
		
		$forceMobile = aff_get_aff_option('aff_force_mobile');
		$isMobile = $detect->isMobile() || $detect->isTablet();

		if ($forceMobile && $isMobile && $domain == 'lazada.vn') {
            if (strpos($encoded_url, '?') !== false) {
                    $encoded_url .= '&';
            } else {
                    $encoded_url .= '?';
            }
            $encoded_url .= "referer=accesstrade-app";
        }
        
        $url_params['encoded_url'] = urlencode($encoded_url);

        $affiliate_url = format_str($this::$URL_TEMP, $url_params);

		return $affiliate_url;
	}
	
	public function allow_domain ($domain = '') {
		return parent::allow_domain($domain);
	}
}

?>