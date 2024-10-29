<?php
if (!defined('DB_NAME'))
    die('Error: Plugin "affiliate-tools" does not support standalone calls, damned hacker.');

function get_default_options() {

      return array(

            array('new_name' => 'mo_sec_key', 
                  'def_value' => 'mo-xxx',
                  'type' => 'aff_plat_key', 
                  'name' => __('MasOffer secret key', 'affiliate-tools'),
                  'grp' => 'aff_platform'),

            array('new_name' => 'at_sec_key', 
                  'def_value' => 'at-xxx',
                  'type' => 'aff_plat_key',
                  'name' => __('Accesstrade deeplink secret key', 'affiliate-tools'),
                  'grp' => 'aff_platform'),

            array('new_name' => 'platform', 
                  'def_value' => 'accesstrade',
                  'type' => 'slt',
                  'name' => __('Affiliate Platform', 'affiliate-tools'),
                  'grp' => 'aff_platform'),

            array('new_name' => 'cs_at_platform',
                  'def_value' => '',
                  'type' => 'site_slt',
                  'name' => __('Use AccessTrade affiliate for these sites', 'affiliate-tools'),
                  'grp' => 'aff_platform'),

            array('new_name' => 'cs_mo_platform',
                  'def_value' => '',
                  'type' => 'site_slt',
                  'name' => __('Use MassOffer affiliate for these sites', 'affiliate-tools'),
                  'grp' => 'aff_platform'),
                  
            array('new_name' => 'aff_force_mobile',
                  'def_value' => 0,
                  'type' => 'chk',
                  'name' => __('Force your users to use mobile app (Lazada.vn)', 'affiliate-tools'),
                  'grp' => 'aff_platform'),

            array('old_name' => 'old_time_stamp',
                  'new_name' => 'stats_by', 
                  'def_value' => 0,
                  'type' => 'xxx', 
                  'name' => __('statis time stamp', 'affiliate-tools'),
                  'grp' => 'affiliate_tools'),

            array('old_name' => 'affiliatetools_mask_mine',
                  'new_name' => 'aff_mask_mine',
                  'def_value' => 1,
                  'type' => 'chk',
                  'name' => __('Mask links in posts and pages', 'affiliate-tools'),
                  'grp' => 'what'),

            array('old_name' => 'affiliatetools_mask_comment',
                  'new_name' => 'aff_mask_comment',
                  'def_value' => 1, 'type' => 'chk',
                  'name' => __('Mask links in comments', 'affiliate-tools'),
                  'grp' => 'what'),

            array('old_name' => 'affiliatetools_mask_author',
                  'new_name' => 'aff_mask_author',
                  'def_value' => 1, 'type' => 'chk',
                  'name' => __('Mask comments authors`s homepage links', 'affiliate-tools'),
                  'grp' => 'what'),

            array('new_name' => 'aff_mask_rss',
                  'def_value' => 0, 'type' => 'chk',
                  'name' => __('Mask links in your RSS post content', 'affiliate-tools') . ' ' . __('(may result in invalid RSS if used with some masking options)', 'affiliate-tools'),
                  'grp' => 'what'),

            array('new_name' => 'aff_mask_rss_comment',
                  'def_value' => 0, 'type' => 'chk',
                  'name' => __('Mask links in RSS comments', 'affiliate-tools') . ' ' . __('(may result in invalid RSS if used with some masking options)', 'affiliate-tools'),
                  'grp' => 'what'),

            array('old_name' => 'affiliatetools_add_nofollow',
                  'new_name' => 'aff_add_nofollow', 'def_value' => 1,
                  'type' => 'chk', 'name' => __('Add <b>rel=nofollow</b> for masked links (for google)', 'affiliate-tools'),
                  'grp' => 'common'),

            array('old_name' => 'affiliatetools_add_blank',
                  'new_name' => 'aff_add_blank', 'def_value' => 1,
                  'type' => 'chk', 'name' => __('Add <b>target="blank"</b> for all links to other sites (links will open in new window)', 'affiliate-tools'),
                  'grp' => 'common'),

            array('old_name' => 'affiliatetools_put_noindex',
                  'new_name' => 'aff_put_noindex', 'def_value' => 0,
                  'type' => 'chk', 'name' => __('Surround masked links with <b>&lt;noindex&gt;link&lt;/noindex&gt;</b> tag (for yandex search engine)', 'affiliate-tools'),
                  'grp' => 'common'),

            array('new_name' => 'aff_put_noindex_comment',
                  'def_value' => 0, 'type' => 'chk',
                  'name' => __('Surround masked links with comment <b>&lt;!--noindex--&gt;link&lt;!--/noindex--&gt;</b> (for yandex search engine, better then noindex tag because valid)', 'affiliate-tools'),
                  'grp' => 'common'),

            array('old_name' => 'affiliatetools_disable_mask_links',
                  'new_name' => 'aff_disable_mask_links', 'def_value' => 0,
                  'type' => 'chk',
                  'name' => __('No redirect', 'affiliate-tools'),
                  'grp' => 'type'),

            array('old_name' => 'affiliatetools_link_separator',
                  'new_name' => 'aff_LINK_SEP',
                  'def_value' => 'chuyen-den',
                  'type' => 'txt',
                  'name' => __('Link separator for redirects (default="chuyen-den")', 'affiliate-tools'),
                  'grp' => 'common'),

            array('old_name' => 'affiliatetools_exclude_links',
                  'new_name' => 'aff_exclude_links',
                  'def_value' => '',
                  'type' => 'text',
                  'name' => __('Exclude URLs that you don`t want to mask (all urls, beginning with those, won`t be masked). Put one adress on each line, including protocol prefix (for example,', 'affiliate-tools') . ' "<b>http://</b>jehy.ru" ' . __('or', 'affiliate-tools') . ' <b>https://</b>google.com ' . __('or', 'affiliate-tools') . ' <b>ftp://</b>microsoft.com). ' . __('Skype, javascript and mail links are excluded by default. To exclude full protocol, just add line with it`s prefix - for example,', 'affiliate-tools') . ' "<b>ftp://</b>"',
                  'grp' => 'exclude'),

            array('new_name' => 'aff_fullmask',
                  'def_value' => 0,
                  'type' => 'chk',
                  'name' => __('Mask ALL links in document (can slow down your blog and conflict with some cache and other plugins. Not recommended).', 'affiliate-tools'),
                  'grp' => 'what'),

            array('new_name' => 'aff_stats',
                  'def_value' => 1,
                  'type' => 'chk',
                  'name' => __('Log all outgoing clicks.', 'affiliate-tools'),
                  'grp' => 'common'),

            array('new_name' => 'aff_keep_stats',
                  'def_value' => 30,
                  'type' => 'txt',
                  'name' => __('Days to keep clicks stats', 'affiliate-tools'),
                  'grp' => 'common'),

            array('new_name' => 'aff_no302',
                  'def_value' => 0,
                  'type' => 'chk',
                  'name' => __('Use javascript redirect', 'affiliate-tools'),
                  'grp' => 'type'),

            array('new_name' => 'aff_redtime',
                  'def_value' => 3,
                  'type' => 'txt',
                  'name' => __('Redirect time (seconds)', 'affiliate-tools'),
                  'grp' => 'java'),

            array('new_name' => 'aff_redtxt',
                  'def_value' => 'This page demonstrates link redirect with "Affiliate Tools" plugin. You will be redirected in 3 seconds. Otherwise, please click on <a href="LINKURL">this link</a>.',
                  'type' => 'text',
                  'name' => __('Custom redirect text. Use word "LINKURL" where you want to use redirect url. For example, <b>CLICK &lt;a href="LINKURL"&gt;HERE NOW&lt;/a&gt;</b>', 'affiliate-tools'),
                  'grp' => 'java'),

            array('new_name' => 'aff_noforauth',
                  'def_value' => 0,
                  'type' => 'chk',
                  'name' => __('Do not mask links when registered users visit site', 'affiliate-tools'),
                  'grp' => 'exclude'),

            array('new_name' => 'maskurl',
                  'def_value' => 0,
                  'type' => 'chk',
                  'name' => __('Mask url with special numeric code. Be careful, this option may slow down your blog.', 'affiliate-tools'),
                  'grp' => 'encode'),

            array('new_name' => 'aff_remove_links',
                  'def_value' => 0,
                  'type' => 'chk',
                  'name' => __('Completely remove links from your posts. Someone needed it...', 'affiliate-tools'),
                  'grp' => 'common'),

            array('new_name' => 'aff_link2text',
                  'def_value' => 0,
                  'type' => 'chk',
                  'name' => __('Turn all links into text. For perverts.', 'affiliate-tools'),
                  'grp' => 'common'),

            array('new_name' => 'aff_base64',
                  'def_value' => 1,
                  'type' => 'chk',
                  'name' => __('Use base64 encoding for links.', 'affiliate-tools'),
                  'grp' => 'encode'),

            array('new_name' => 'aff_debug',
                  'def_value' => 0,
                  'type' => 'chk',
                  'name' => __('Debug mode (Adds comments lines like "&lt;!--affiliate-tools debug: some info--&gt;" to output. For testing only!)', 'affiliate-tools'),
                  'grp' => 'common'),

            array('new_name' => 'aff_restrict_referer',
                  'def_value' => 1,
                  'type' => 'chk',
                  'name' => __('Check for document referer and restrict redirect if it is not your own web site. Useful against spoofing attacks. User will be redirected to main page of your web site.', 'affiliate-tools'),
                  'grp' => 'common'),

            array('new_name' => 'aff_dont_mask_admin_follow',
                  'def_value' => 0,
                  'type' => 'chk',
                  'name' => __('Do not mask links which have <b>rel="follow"</b> atribute and are posted by admin', 'affiliate-tools'),
                  'grp' => 'exclude'),
      );
}

?>