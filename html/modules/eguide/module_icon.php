<?php
# import from GIJOE's pico
# $Id: module_icon.php,v 1.2 2008-02-03 15:28:51 nobu Exp $

define('ICON_ASIS',  'module_icon.png');
define('ICON_IMAGE', 'images/eguide_slogo2.png');

$mydirpath = dirname(__FILE__);
$mydirname = basename($mydirpath);
$icon_cache_limit = 3600 ; // default 3600sec == 1hour

session_cache_limiter('public');
header("Expires: ".date('r',intval(time()/$icon_cache_limit)*$icon_cache_limit+$icon_cache_limit));

header("Cache-Control: public, max-age=$icon_cache_limit");
header("Last-Modified: ".date('r',intval(time()/$icon_cache_limit)*$icon_cache_limit));
header("Content-type: image/png");

if( file_exists( $mydirpath.'/module_icon.png' ) ) {
	$use_custom_icon = true ;
	$icon_fullpath = $mydirpath.'/'.ICON_TEMPLATE;
} else {
	$use_custom_icon = false ;
	$icon_fullpath = $mydirpath.'/'.ICON_IMAGE;
}

if( ! $use_custom_icon && function_exists( 'imagecreatefrompng' ) && function_exists( 'imagecolorallocate' ) && function_exists( 'imagestring' ) && function_exists( 'imagepng' ) ) {
	$im = imagecreatefrompng( $icon_fullpath ) ;

	$color = imagecolorallocate( $im , 0 , 0 , 0 ) ; // black
	$px = ( 92 - 6 * strlen( $mydirname ) ) / 2 ;
	$bg = imagecolorat($im, $px, 34) ;
	imagefilledrectangle( $im, 3, 34, 84, 47, $bg );
	imagestring( $im , 3 , $px , 34 , $mydirname , $color ) ;
	imagepng( $im ) ;
	imagedestroy( $im ) ;

} else {

	readfile( $icon_fullpath ) ;

}

?>