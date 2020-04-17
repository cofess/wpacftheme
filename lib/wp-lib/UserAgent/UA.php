<?php

namespace Lib\UserAgent;

use Lib\UserAgent\IP;


class UA{

	public $os_array = array(
		'/windows nt 10/i'      =>  'Windows 10',
		'/windows phone 10/i'   =>  'Windows Phone 10',
		'/windows phone 8.1/i'  =>  'Windows Phone 8.1',
		'/windows phone 8/i'    =>  'Windows Phone 8',
		'/windows nt 6.3/i'     =>  'Windows 8.1',
		'/windows nt 6.2/i'     =>  'Windows 8',
		'/windows nt 6.1/i'     =>  'Windows 7',
		'/windows nt 6.0/i'     =>  'Windows Vista',
		'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'     =>  'Windows XP',
		'/windows xp/i'         =>  'Windows XP',
		'/windows nt 5.0/i'     =>  'Windows 2000',
		'/windows me/i'         =>  'Windows ME',
		'/win98/i'              =>  'Windows 98',
		'/win95/i'              =>  'Windows 95',
		'/win16/i'              =>  'Windows 3.11',
		'/macintosh|mac os x/i' =>  'Mac OS X',
		'/mac_powerpc/i'        =>  'Mac OS 9',
		'/iphone/i'             =>  'iPhone',
		'/ipod/i'               =>  'iPod',
		'/ipad/i'               =>  'iPad',
		'/android/i'            =>  'Android',
		'/linux/i'              =>  'Linux',
		'/ubuntu/i'             =>  'Ubuntu',
		'/blackberry/i'         =>  'BlackBerry',
		'/webos/i'              =>  'Mobile'
	);

 	public $browser_array = array(
		'/mobile/i'     =>  'Handheld Browser',
		'/msie/i'       =>  'Internet Explorer',
		'/firefox/i'    =>  'Firefox',
		'/safari/i'     =>  'Safari',
		'/chrome/i'     =>  'Chrome',
		'/edge/i'       =>  'Edge',
		'/opera/i'      =>  'Opera',
		'/netscape/i'   =>  'Netscape',
		'/maxthon/i'    =>  'Maxthon',
		'/konqueror/i'  =>  'Konqueror'
	);

 	public $isps = array(
		'/virgin media/i'			=>  'Virgin Media',
		'/bt|british telecom|britishtelecom/i'	=>  'BT', // confirmed
		'/talktalk/i'    			=>  'TalkTalk',
		'/skybroadband|sky/i'			=>  'Sky Broadband', // confirmed
		'/plusnet/i'				=>  'Plusnet',
		'/three/i'				=>  'Three',
		'/ee/i'					=>  'EE',
		'/nowtv| now tv/i'			=>  'Now TV',
		'/xlnbroadband|xln broadband/i'		=>  'XLN Broadband',
		'/vodafone/i'				=>  'Vodafone',
		'/sse/i'				=>  'SSE',
		'/postoffice|post office/i'		=>  'Post Office',
		'/vondage/i'				=>  'Vondage',
		'/johnlewis|john lewis/i'		=>  'John Lewis',
		'/tmobile|t mobile|t-mobile/i'		=>  'T-Mobile',
		'/orange/i'				=>  'Orange',
		'/tesco/i'				=>  'Tesco',
		'/tiscali/i'				=>  'Tiscali',
		'/aol/i'				=>  'AOL',
		'/tentel/i'				=>  'TenTel',
		'/myvzw/i'				=>  'Verizon Trademark Services LLC',
		'/verizon/i'				=>  'Verizon'
	);

	public $os_platform = "OS Platform not Detected.";
	public $browser = "Browser not Detected.";
	public $isp = "ISP Not Detected.";
	private $user_agent = NULL;

	// static $user_agent;
	static $referer;

	public function __construct(){
		$this->user_agent = $_SERVER['HTTP_USER_AGENT'];
		//$this->browser = get_browser(NULL, true);
	}

	public function user_agent(){
		return $this->user_agent;
	}

	public static function IP(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			return $_SERVER['REMOTE_ADDR'];
		}
	}

	public static function parse_ip($ip=''){
		$ip	= ($ip)?:self::IP();

		if($ip == 'unknown'){
			return false;
		}

		$ipdata		= IP::find($ip);

		return array(
			'ip'		=> $ip,
			'country'	=> isset($ipdata['0'])?$ipdata['0']:'',
			'region'	=> isset($ipdata['1'])?$ipdata['1']:'',
			'city'		=> isset($ipdata['2'])?$ipdata['2']:'',
			'isp'		=> '',
		);
	}

	public function OS() {
		foreach ($this->os_array as $regex => $value) { 
			if (preg_match($regex, $this->user_agent) ) {
				return $value;
			}
		}   
		return $this->os_platform;
	}

	public function Browser() {
		$browser="";
		foreach ($this->browser_array as $regex => $value) { 
			if (preg_match($regex, $this->user_agent ) ) {
				$browser    =   $value;
			}
		}
		return $browser == "" ? $this->browser : $browser;
	}

	public function BrowserVersion(){
		$detected = $this->Browser();
		$d = array_search($detected, $this->browser_array);
		$browser = str_replace(array("/i","/"), "", $d);
		$regex = "/(?<browser>version|{$browser})[\/]+(?<version>[0-9.|a-zA-Z.]*)/i";
		if (preg_match_all($regex, $this->user_agent, $matches)) {
			$found = array_search($browser, $matches["browser"]);
			return $matches["version"][$found];
		}
		return "";
	}

	public static function Hostname(){
		return gethostbyaddr(self::IP());
	}

	public function ISP(){
		$longisp = $this->Hostname();
		$isp = explode('.', $longisp);
		$isp = array_reverse($isp);
		$tmp = $isp[0];
		if (preg_match("/\<(org?|com?|net?|uk)\>/i", $tmp)) {
			$myisp = $isp[2].'.'.$isp[1].'.'.$isp[0];
		} else {
			$myisp = $isp[1].'.'.$isp[0];
			foreach ($this->isps as $regex => $value) { 
				if (preg_match($regex, $myisp) ) {
					return $value;
				}
			}   
		}
		if (preg_match("/[0-9]{1,3}\.[0-9]{1,3}/", $myisp)){
			return $this->isp;
		}
		return $myisp;
	}

	public static function get_ios_version($user_agent){
		if(preg_match('/OS (.*?) like Mac OS X[\)]{1}/i', $user_agent, $matches)){
			return trim($matches[1]);
		}else{
			return '';
		}
	}

	public static function get_ios_build($user_agent){
		if(preg_match('/Mobile\/(.*?)\s/i', $user_agent, $matches)){
			return trim($matches[1]);
		}else{
			return '';
		}
	}

	public static function get_referer(){
		if (!isset(self::$referer)){
			self::$referer = ($_SERVER['HTTP_REFERER'])??'';
		}

		return self::$referer;
	}

	public function isMobile(){
		if (preg_match('/mobile|phone|ipod/i', $this->user_agent) ) {
			return true;
		}else{
			return false;
		}
	}

	public function isTablet(){
		if (preg_match('/tablet|ipad/i', $this->user_agent) ) {
			return true;
		}else{
			return false;
		}
	}

	public function isDesktop(){
		if (!$this->isMobile() && !$this->isTablet() ) {
			return true;
		}else{
			return false;
		}
	}

	public function isBot(){
		if (preg_match('/bot/i', $this->user_agent) ) {
			return true;
		}else{
			return false;
		}
	}

	public static function is_iphone(){
		if (preg_match('/iphone/i', $this->user_agent) ) {
			return true;
		}else{
			return false;
		}
	}

	public static function is_ipod(){
		if (preg_match('/ipod/i', $this->user_agent) ) {
			return true;
		}else{
			return false;
		}
	}

	public static function is_ipad(){	
		if (preg_match('/ipad/i', $this->user_agent) ) {
			return true;
		}else{
			return false;
		}
	}

	public static function is_ios(){
		return self::is_iphone() || self::is_ipod() || self::is_ipad();
	}

	public static function is_mac(){
		if (preg_match('/macintosh|mac os x|mac_powerpc/i', $this->user_agent) ) {
			return true;
		}else{
			return false;
		}
	}

	public static function is_android(){
		if (preg_match('/android/i', $this->user_agent) ) {
			return true;
		}else{
			return false;
		}
	}

	public static function is_weixin(){
		if (!preg_match('/miniprogram/i', $this->user_agent) && preg_match('/micromessenger/i', $this->user_agent) ) {
			return true;
		}else{
			return false;
		}
	}

	public static function is_weapp(){
		if (preg_match('/miniprogram/i', $this->user_agent) && preg_match('/micromessenger/i', $this->user_agent) ) {
			return true;
		}else{
			return false;
		}
	}
  
}
