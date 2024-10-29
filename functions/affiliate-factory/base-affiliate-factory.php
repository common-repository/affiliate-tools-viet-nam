<?php
if (!defined('DB_NAME')) {
    die('Error: Plugin "affiliate-tools" does not support standalone calls, damned hacker.');
}

/**
* Base class for affiliate url factory.
*/

include_once(plugin_dir_path(__FILE__) . '../lib/Mobile_Detect.php');

class BaseAffiliateURLFactory {

	public static $factory_id 	= "base";

	public static $URL_TEMP 	= "";
	
	public static $ALLOW_DOMAINS = array(
										'lazada.vn',
										'adayroi.com',
									 	'tiki.vn',
									 	'mytour.vn',
									 	'vienthonga.vn',
									 	'lingo.vn',
									 	'cdiscount.vn',
									 	'zalora.vn',
									 	'zanado.com',
									 	'juno.vn',
									 	'nguyenkim.com',
									 	'vatgia.com',
									 	'ebay.vn',
									 	'hcenter.com.vn',
									 	'bookin.vn',
									 	'dyoss.com',
									 	'divui.com',
									 	'travel.com.vn',
									 	'atadi.vn',
									 	'bookin.vn',
									 	'gotadi.com',
									 	'flight.gotadi.com',
									 	'fptshop.com.vn',
									 	'a1.fptplay.tv',
									 	'yes24.vn',
									 	'topmot.vn',
									 	'vntrip.vn',
									 	'vnfiba.com',
									 	'talaha.vn',
									 	'vpbank.com.vn',
									 	'leflair.vn',
									 	'lotte.vn',
									 	'kangaroogroup.vn',
									 	'ferosh.vn',
									 	'at1.wefit.vn',
									 	'cfyc.com.vn',
									 	'robins.vn',
									 	'canifa.com',
									 	'kyna.vn',
										'booking.com',
										'agoda.com',
										'travel.com.vn',
										'aeoneshop.com',
										'nama.vn',
										'eropi.com',
										'thefaceshop.com.vn',
										'daithanhgroup.vn',
										'luxstay.net',
										'book.rio.vn',
										'vemaybay.alotrip.vn',
										'dichungtaxi.com',
										'klook.com',);

	public static $OFFER_KEY 	= array('adayroi.com'=> 'adayroi',
										'lazada.vn'=> 'lazada',
									 	'tiki.vn'=> 'tiki',
									 	'lotte.vn' => 'lotte',
									 	'mytour.vn'=> 'mytour',
									 	'vienthonga.vn'=> 'vienthonga',
									 	'lingo.vn'=> 'lingo',
									 	'cdiscount.vn'=> 'cdiscount',
									 	'zalora.vn'=> 'zalora',
									 	'zanado.com'=> 'zanado',
									 	'juno.vn'=> 'juno',
									 	'nguyenkim.com'=> 'nguyenkim',
									 	'vatgia.com'=> 'vatgia',
									 	'ebay.vn'=> 'ebayvn',
									 	'fado.vn'=> 'fado',
									 	'vntrip.vn'=> 'vntrip',
									 	'atadi.vn'=> 'atadi',
									 	'bookin.vn'=> 'bookin',
									 	'dealtoday.vn'=> 'dealtoday',
									 	'shoptretho.com'=> 'shoptretho',
									 	'fptshop.com.vn'=> 'fptshop',
									 	'kyna.vn'=> 'kyna',
									 	'abay.vn'=> 'abay',
									 	'bigmua.com'=> 'bigmua',
									 	'kay.vn'=> 'kay',
									 	'scj.vn'=> 'scj',
									 	'kovictravel.com'=> 'kovictravel',
									 	'beem.vn'=> 'beem',
									 	'thammyhongkong.vn'=> 'thammyhongkong',
									 	'jupviec.vn'=> 'jupviec',
									 	'edumall.vn'=> 'edumall',
									 	'cfyc.com.vn'=> 'cfyc.com.vn',
									 	'sendo.vn'=> 'sendo.vn',
									 	'canifa.com'=> 'canifa.com',
										'booking.com'=> 'booking-global',
										'robins.vn'=> 'robins',
										'travel.com.vn'=> 'vietravel',
										'aeoneshop.com'=> 'aeoneshop',
										'nama.vn'=> 'nama',
										'eropi.com'=> 'eropi',
										'thefaceshop.com.vn' => 'thefaceshop',
										'daithanhgroup.vn' => 'tadt',
										'luxstay.net' => 'luxstay',
										'book.rio.vn' => 'rio',
										'vemaybay.alotrip.vn' => 'alotrip',
										'dichungtaxi.com' => 'dichungtaxi',
										'klook.com' => 'klook',);

	public static $PUB_KEYS 	= array('accesstrade'=> 'XXX',
										'masoffer'=> 'kepgiay');

	public static $UTM_PARAMS 	= array('utm_source'=> 'AffiliateTools',
										'utm_medium'=> 'affiliate',
										'utm_campaign'=> 'review_posts',
										'utm_content'=> 'post');

	function affiliate_url($url) {
		return $url;
	}

	function secret_key() {
		return aff_get_aff_option('');
	}
	
	public function allow_domain($domain = '') {
		
		foreach(BaseAffiliateURLFactory::$ALLOW_DOMAINS as $allow_domain) {
			
			if(strcmp($allow_domain, $domain) == 0) {
				return true;
			}
		}
		return false;
	}

	function repair_affiliate_url($url = "") {
		if ($url == "") {
			return $url;
		}

		$mo_utm_source = "%26utm_source%3Dmasoffer";
		$count = substr_count($url, $mo_utm_source);
		$v0_pos = strpos($url, "http://go.masoffer.net/v0");
		$v1_pos = strpos($url, "http://go.masoffer.net/v1");
		if (($count > 0 && $v0_pos !== false)
						|| ($count > 1 && $v1_pos !== false)) {
			$url = str_replace_first($mo_utm_source, "", $url);
		}
		
		// Remove double utm_source parametter
		$mo_utm_source = "%3Futm_source%3Dmasoffer";
		$pos = strpos($url, $mo_utm_source);
		if ($pos !== false && $v0_pos !== false) {
			$url = str_replace_first($mo_utm_source, "", $url);
		}
		return $url;
	}
}

?>