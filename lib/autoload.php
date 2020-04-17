<?php
/* Cannot access pages directly  */ 
if ( ! defined( 'ABSPATH' ) ) { die; }

// function autoload($class) {
//     $name = explode('_', $class);
//     if (isset($name[1])) {
//         $class_name = strtolower($name[1]);
//         $filename = dirname(__FILE__) . '/class/' . $class_name . '.php';
//         if (file_exists($filename)) {
//             require_once $filename;
//         }
//     }
// }
// spl_autoload_register(array($this, 'autoload'));

/** Autoloader */
// spl_autoload_register(function ($class) {
//     $filename = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
//     if (file_exists($filename)) {
//         require_once $filename;
//     }
// });

/**
 * Returns array of features, also
 * Scans the plugins subfolder "/classes"
 * http://wordpress.stackexchange.com/questions/1403/organizing-code-in-your-wordpress-themes-functions-php-file
 * @since   0.1
 * @return  void
 */
function loadfile($dir,$file) {
    // load all files with the pattern class-*.php from the directory classes
    foreach( glob( $dir . $file ) as $class )
        require_once $class;
}

/**
 * 引入文件
 * function includes files in $dir, if $includeSubDir set to true there no includes in subdirectories 
 * @param dir 文件目录
 * @param no_more 是否扫描子目录
 * @param f_name 文件名（只引入指定文件名文件，支持模糊查询）
 * @example autoload('/../modules/', false, 'init.php');
**/
function autoload( $dir, $includeSubDir = false, $fileName = null ) {    
	$dir_init = $dir;
	// $dir = dirname(__FILE__).$dir;
    $dir = THEME_DIR.$dir; 
    if (!file_exists($dir)) {
        throw new Exception("Folder $dir does not exist");
    }     
    $files = array();     
    if ($handle = opendir( $dir )) {
        while( false !== ($file = @readdir($handle)) ) {        
            if ( !$includeSubDir && is_dir( $dir.$file ) && !preg_match('/^\./', $file) ) {
                autoload($dir_init.$file."/", true, $fileName);
            } else {             
                if( $fileName && $fileName == $file ) {
                    $files[] = $dir.$file;
                }elseif( !$fileName && preg_match('/^[^~]{1}.*\.php$/', $file) ) {
                    $files[] = $dir.$file;
                }            
            }            
        }
        @closedir($handle);
    }  
    sort($files);
    foreach($files as $file) {
        include_once $file;
    }
}

