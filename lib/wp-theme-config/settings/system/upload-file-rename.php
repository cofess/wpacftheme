<?php

/**
 * 让主题支持wordpress上传文件自动重命名
 * 参考：http://www.boke8.net/wordpress-auto-rename-file.html
 * Plugin URI: http://www.aips.me/wordpress-upload-pictures-renamed.html
 * @link http://stackoverflow.com/a/3261107/247223
 */
return function($fileType) 
{
    /**
     * @param $filename [当前上传文件信息]
     * @param $md5Mode [是否以md5方式重命名文件]
     * @param $zhNameFiles [是否仅对中文文件名文件重命名]
     */
    function upload_file_rename( $filename, $md5Mode = false, $zhNameFiles = false ){
        // 当前上传文件相关信息
        $info = pathinfo( $filename ); // 上传文件信息
        $ext  = empty( $info['extension'] ) ? '' : '.' . $info['extension']; // 文件扩展名
        $name = basename( $filename, $ext ); // 文件名

        $time=date("YmdHis");//获取当前时间
        $cpattern = '/[\x7f-\xff]/';//中文正则表达式

        if( $zhNameFiles ){
            if( preg_match( $cpattern, $name ) ){
                if ( $md5Mode ){
                    //命名方式：随机数字（MD5加密文件名）
                    $filename = substr(md5($name), 0, 20) . $ext;
                } else {
                    //命名方式：时间戳+随机数字（MD5加密文件名）
                    $filename = $time . substr(md5($name), 0, 16) . $ext;
                }
            }
        } else {
            if ( $md5Mode ){
                //命名方式：随机数字（MD5加密文件名）
                $filename = substr(md5($name), 0, 20) . $ext;
            } else {
                //命名方式：时间戳+随机数字（MD5加密文件名）
                $filename = $time . substr(md5($name), 0, 16) . $ext;
            }
        }

        return $filename;
    }

    $rename_mode = $this->config['system.file-rename-mode'];
    // 对所有上传文件进行重命名
    if ( $fileType == '1' ){
        if ( $rename_mode == '1' ){
            //命名方式：时间戳+随机数字（MD5加密文件名）
            add_filter( 'sanitize_file_name', function( $filename ){
                return upload_file_rename( $filename, false, false );
            }, 10 );
        } else {
            //命名方式：随机数字（MD5加密文件名）
            add_filter( 'sanitize_file_name', function( $filename ){
                return upload_file_rename( $filename, true, false );
            }, 10 );
        }
    }

    // 仅对中文文件名文件进行重命名
    if ( $fileType == '2'){
        if ( $rename_mode == '1' ){
            //命名方式：时间戳+随机数字（MD5加密文件名）
            add_filter( 'sanitize_file_name', function( $filename ){
                return upload_file_rename( $filename, false, true );
            }, 10 );
        } else {
            //命名方式：随机数字（MD5加密文件名）
            add_filter( 'sanitize_file_name', function( $filename ){
                return upload_file_rename( $filename, true, true );
            }, 10 );
        }
    }
};