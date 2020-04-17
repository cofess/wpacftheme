<?php

namespace Lib\Core;
use Lib\Core\Meta;
use Lib\Util\Check;

class User{

  	/**
	 * user_id
	 *
	 * @var int
	 */
	protected $user_id;

	/**
	 * user
	 *
	 * @var \WP_User
	 */
	protected $user;
  
  	/**
	 * constructor.
	 *
	 * @param null|int $user_id
	 */
	public function __construct( $user_id = null ) {
		if( null === $user_id ){
			$user_id = get_current_user_id();
		}
		$this->user_id = $user_id;
  	}
  
	public function get_user_id(){
		return $this->user_id;
	}
  
  	public function get_user() {
		if( null === $this->user ){
			$this->user = get_user_by( 'id', $this->user_id );
		}

		return $this->user;
	}

  	public static function get_name(){
		$current_user = wp_get_current_user();
		if(!empty($current_user->user_firstname)){
			return $current_user->user_firstname;
		}
		if(!empty($current_user->display_name)){
			return $current_user->display_name;
		}
		return $current_user->user_login;
	}

	// Return a user's full name or display name
	public static function get_full_name( $user_object = false ) {

		if ( ! $user_object ) {
			$user_object = wp_get_current_user();
		}

		// Return
		if ( $user_object->first_name && $user_object->last_name ) {
			return $user_object->first_name . ' ' . $user_object->last_name;
		}
		else if ( $user_object->first_name || $user_object->last_name ) {
			return $user_object->first_name . $user_object->last_name;
		}
		else {
			return $user_object->display_name;
		}

	}
	
	// 只能含有中文汉字、英文字母、数字、下划线、中划线和点。
	public static function get_validated_nickname($nickname){

		// $nickname	= remove_accents( $nickname );
		// $nickname	= preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '', $nickname);	// Kill octets
		// $nickname	= preg_replace('/&.+?;/', '', $nickname); // Kill entities
		
		//限制不能使用特殊的中文
		$nickname	= preg_replace('/[^A-Za-z0-9_.\-\x{4e00}-\x{9fa5}]/u', '', $nickname);
		
		$nickname	= trim($nickname);
		// Consolidate contiguous whitespace
		$nickname	= preg_replace('|\s+|', ' ', $nickname);
		
		return $nickname;
	}

	// 检测用户名是否重复
	public static function is_duplicate_nickname($nickname, $user_id=0){
		$users	= get_users(array('blog_id'=>0,'meta_key'=>'nickname', 'meta_value'=>$nickname));
		if(count($users) > 1){
			return true;
		}elseif($users && $user_id != $users[0]->ID){
			return true;
		}

		$users	= get_users(array('blog_id'=>0,'login'=>$nickname));
		if(count($users) > 1){
			return true;
		}elseif($users && $user_id != $users[0]->ID){
			return true;
		}

		return false;
	}

	// 检测用户名是合法标准
	public static function check_nickname($nickname, $user_id=0 ){
		if(!$nickname)
			return new WP_Error('empty', $nickname.' 为空');

		if(mb_strwidth($nickname)>20)
			return new WP_Error('too_long', $nickname.' 超过20个字符。');

		if(Check::blacklist_check($nickname))
			return new WP_Error('illegal', $nickname. '含有非法字符。');
		

		if($nickname != self::get_validated_nickname($nickname))
			return new WP_Error('invalid', $nickname.' 非法，只能含有中文汉字、英文字母、数字、下划线、中划线和点。');

		if(self::is_duplicate_nickname($nickname,$user_id)){
			return new WP_Error('duplicate', $nickname.' 已被人使用！');
		}

		return true;
	}

  	/**
	 *
	 * @param string $key
	 * @param mixed $default
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function get_meta( string $key, $default = null ) {
		$value =  Meta::instance()->get_meta( $this->user_id, $key, 'user' );
		if( null !== $default && empty( $value ) ){
			return $default;
		}
		return $value;
	}

	/**
	 *
	 * @param int $user_id
	 *
	 * @static
	 *
	 * @return static
	 */
	public static function factory( $user_id ) {
		return new static( $user_id );
	}
  
}
