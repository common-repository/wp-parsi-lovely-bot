<?php
/*
Plugin Name: WP-Parsi Lovely Bots
Plugin URI: http://forum.wp-parsi.com
Description: Show Password Required Post Content For Search Engine Bot
Version: 1.0
Author: Parsa Kafi
Author URI: http://parsa.ws
*/

function the_content_bot_wpp($more=""){
	if ( post_password_required() && (is_this_a_valid_web_crawler_wpp(getRealIpAddr_wpp()) || detect_searchbot_spider_wpp()) ){	
		global $post;
		$post_ID = $post->ID;
		$content_post = get_post($post_ID);
		$content = $content_post->post_content;
		$content = apply_filters('the_content', $content);
		echo $content;
	}else{
		the_content($more);
	}
}


function is_this_a_real_msnbot_wpp($remote_host_ip) {
	// http://blogs.msdn.com/livesearch/archive/2006/11/29/search-robots-in-disguise.aspx
	// http://en.wikipedia.org/wiki/Forward_Confirmed_reverse_DNS
	$the_host_should_be="livebot-";
	$the_host_should_be.=str_replace(".", "-", $remote_host_ip);
	$the_host_should_be.=".search.live.com";
	if ($the_host_should_be==gethostbyaddr($remote_host_ip)) { //If reverse DNS lookup looks good then proceed to
	foreach (gethostbynamel(gethostbyaddr($remote_host_ip)) as $realip) { ///Forward Confirmed reverse DNS
	if ($realip==$remote_host_ip) {return TRUE;}
	}
	} else {return FALSE;}
}
function is_this_a_real_YahooSlurp_wpp($remote_host_ip) {
	// http://www.seroundtable.com/archives/013781.html
	// http://en.wikipedia.org/wiki/Forward_Confirmed_reverse_DNS
	$the_host_should_be=".crawl.yahoo.net";
	if ($the_host_should_be==substr(gethostbyaddr($remote_host_ip), -16)) { //If reverse DNS lookup looks good then proceed to
	foreach (gethostbynamel(gethostbyaddr($remote_host_ip)) as $realip) { ///Forward Confirmed reverse DNS
	if ($realip==$remote_host_ip) {return TRUE;}
	}
	} else {return FALSE;}
}
function is_this_a_real_GoogleBot_wpp($remote_host_ip) {
	// http://googlewebmastercentral.blogspot.com/2006/09/how-to-verify-googlebot.html
	// http://en.wikipedia.org/wiki/Forward_Confirmed_reverse_DNS
	$the_host_should_be=".googlebot.com";
	if ($the_host_should_be==substr(gethostbyaddr($remote_host_ip), -14)) { //If reverse DNS lookup looks good then proceed to
	foreach (gethostbynamel(gethostbyaddr($remote_host_ip)) as $realip) { ///Forward Confirmed reverse DNS
	if ($realip==$remote_host_ip) {return TRUE;}
	}
	} else {return FALSE;}
}
function is_this_a_real_Alexa_ia_archiver_wpp($remote_host_ip) {
	$the_host_should_be=".alexa.com";
	if ($the_host_should_be==substr(gethostbyaddr($remote_host_ip), -10)) { //If reverse DNS lookup looks good then proceed to
	foreach (gethostbynamel(gethostbyaddr($remote_host_ip)) as $realip) { ///Forward Confirmed reverse DNS
	if ($realip==$remote_host_ip) {return TRUE;}
	}
	} else {return FALSE;}
}
function is_this_a_real_ArchiveORG_ia_archiver_wpp($remote_host_ip) {
	$the_host_should_be=".archive.org";
	if ($the_host_should_be==substr(gethostbyaddr($remote_host_ip), -12)) { //If reverse DNS lookup looks good then proceed to
	foreach (gethostbynamel(gethostbyaddr($remote_host_ip)) as $realip) { ///Forward Confirmed reverse DNS
	if ($realip==$remote_host_ip) {return TRUE;}
	}
	} else {return FALSE;}
}
function is_this_a_valid_web_crawler_wpp($remote_host_ip) { 
	//This function should return TRUE as soon as possible since it's testing to see if an IP address belongs to a vaild web crawler.
	if (is_this_a_real_msnbot_wpp($remote_host_ip)) {return TRUE;}
	elseif (is_this_a_real_GoogleBot_wpp($remote_host_ip)) {return TRUE;}
	elseif (is_this_a_real_Alexa_ia_archiver_wpp($remote_host_ip)) {return TRUE;}
	elseif (is_this_a_real_ArchiveORG_ia_archiver_wpp($remote_host_ip)) {return TRUE;}
	else {return FALSE;}
}

function detect_searchbot_spider_wpp(){
	$botarray = array(   
                "Teoma",                   
                "alexa",
                "froogle",
                "inktomi",
                "looksmart",
                "URL_Spider_SQL",
                "Firefly",
                "NationalDirectory",
                "Ask Jeeves",
                "TECNOSEEK",
                "InfoSeek",
                "WebFindBot",
                "girafabot",
                "crawler",
                "Googlebot",
                "Scooter",
                "Slurp",
                "appie",
                "FAST",
                "WebBug",
                "Spade",
                "ZyBorg",
				"Baiduspider",
				"ia_archiver",
				"R6_FeedFetcher",
				"NetcraftSurveyAgent",
				"Sogou web spider",
				"bingbot",
				"Yahoo! Slurp",
				"facebookexternalhit",
				"PrintfulBot",
				"Twitterbot",
				"UnwindFetchor",
				"urlresolver",
				"Butterfly",
				"TweetmemeBot"
				);

	foreach($botarray as $botname) {
		if(ereg($botname, $_SERVER['HTTP_USER_AGENT'])) {
			return TRUE;
		}else{
			
		}
	}
	
	return FALSE;
}

function getRealIpAddr_wpp()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
	  $ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
	  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
	  $ip=$_SERVER['REMOTE_ADDR'];
	}
	
	return  $ip;
}
?>
