<?php
	/**
	 * Hide my wp core class
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 19.02.2018, Webcraftic
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( !class_exists('WDN_Plugin') ) {
		
		if( !class_exists('WDN_PluginFactory') ) {
			if( defined('LOADING_DISABLE_ADMIN_NOTICES_AS_ADDON') ) {
				class WDN_PluginFactory {
					
				}
			} else {
				class WDN_PluginFactory extends Wbcr_Factory400_Plugin {
					
				}
			}
		}
		
		class WDN_Plugin extends WDN_PluginFactory {
			
			/**
			 * @var Wbcr_Factory400_Plugin
			 */
			private static $app;
			
			/**
			 * @var bool
			 */
			private $as_addon;
			
			/**
			 * @param string $plugin_path
			 * @param array $data
			 * @throws Exception
			 */
			public function __construct($plugin_path, $data)
			{
				$this->as_addon = isset($data['as_addon']);
				
				if( $this->as_addon ) {
					$plugin_parent = isset($data['plugin_parent'])
						? $data['plugin_parent']
						: null;
					
					if( !($plugin_parent instanceof Wbcr_Factory400_Plugin) ) {
						throw new Exception('An invalid instance of the class was passed.');
					}
					
					self::$app = $plugin_parent;
				} else {
					self::$app = $this;
				}
				
				if( !$this->as_addon ) {
					parent::__construct($plugin_path, $data);
				}

				$this->setTextDomain();
				$this->setModules();
				
				$this->globalScripts();
				
			}
			
			/**
			 * @return Wbcr_Factory400_Plugin
			 */
			public static function app()
			{
				return self::$app;
			}

			protected function setTextDomain()
			{
				// Localization plugin
				load_plugin_textdomain('disable-admin-notices', false, dirname(WDN_PLUGIN_BASE) . '/languages/');
			}
			
			protected function setModules()
			{
				if( !$this->as_addon ) {
					self::app()->load(array(
						array('libs/factory/clearfy', 'factory_clearfy_200', 'all')
					));
				}
			}
			
			private function globalScripts()
			{
				require(WDN_PLUGIN_DIR . '/includes/classes/class.configurate-notices.php');
				new WDN_ConfigHideNotices(self::$app);
			}
		}
	}