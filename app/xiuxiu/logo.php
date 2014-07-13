<?php
/**
 * Created by PhpStorm.
 * User: Ultra
 * Date: 14-7-14
 * Time: 上午12:08
 */

include_once("../../lib/mysql.class.php");
include_once("../oauth/oauth2.php");

$post_input = 'php://input';
$save_path = dirname( __FILE__ ) . '/../../uploads/';
$postdata = file_get_contents( $post_input );

$id = $_GET['id'];
//print_r($_GET);

if (!file_exists($save_path)) mkdir($save_path);
if (!file_exists($save_path . 'logo')) mkdir($save_path . 'logo');

if ( isset( $postdata ) && strlen( $postdata ) > 0 ) {
    $filename = $save_path . 'logo/' . $id . '.jpg';
    $handle = fopen( $filename, 'w+' );
    fwrite( $handle, $postdata );
    fclose( $handle );
    if ( is_file( $filename ) ) {
        echo '保存成功！';
        exit ();
    }else {
        die ( '保存失败，请稍后再试！' );
    }
}else {
    die ( '图片数据不存在，请联系站长！' );
}