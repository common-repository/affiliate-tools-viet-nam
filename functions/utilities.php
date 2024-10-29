<?php
if (!defined('DB_NAME')) {
    die('Error: Plugin "affiliate-tools" does not support standalone calls, damned hacker.');
}

function format_str($str, $vars, $char = '%')
{
  $tmp = array();
  foreach($vars as $key => $value)
  {
      $tmp[$char . $key . $char] = $value;
  }
  return str_replace(array_keys($tmp), array_values($tmp), $str);
}

function extract_domain($url)
{
	$domain = "";

	$domain = parse_url($url, PHP_URL_HOST);
	$domain = str_replace("www.", "", $domain);
	$domain = str_replace("deal.", "", $domain);
	$domain = str_replace("deals.", "", $domain);

	return $domain;
}

function str_replace_first($from, $to, $subject)
{
  $from = '/'.preg_quote($from, '/').'/';
  return preg_replace($from, $to, $subject, 1);
}

?>