<?php

eval( '
function bmcart_global_search( $keywords , $andor , $limit , $offset , $uid )
{
	return bmcart_global_search_base( "bmcart" , $keywords , $andor , $limit , $offset ) ;
}
' ) ;


if( ! function_exists( 'bmcart_global_search_base' ) ) {

function bmcart_global_search_base( $mydirname , $keywords , $andor , $limit , $offset )
{
	$criteria = new CriteriaCompo();
	// where by keywords
	if( is_array( $keywords ) && count( $keywords ) > 0 ) {
		switch( strtolower( $andor ) ) {
			case "and" :
				foreach( $keywords as $keyword ) {
					$criteria->add(new Criteria('item_name', '%'.$keyword.'%', 'LIKE','AND'));
				}
				break ;
			case "or" :
				foreach( $keywords as $keyword ) {
					$criteria->add(new Criteria('item_name', '%'.$keyword.'%', 'LIKE','OR'));
				}
				break ;
			default :
				$criteria->add(new Criteria('item_name', '%'.$keywords[0].'%', 'LIKE'));
				break ;
		}
	}
	$handler = xoops_getmodulehandler('item','bmcart');
	$objects = $handler->getobjects($criteria);

	$ret = array() ;
	foreach( $objects as $object ) {
		$imageHandler = xoops_getmodulehandler('itemImages','bmcart');
		$criteria = new Criteria('item_id',$object->getVar('item_id'));
		$imageObjects = $imageHandler->getobjects($criteria);
		$imageLink = "";
		if ($imageObjects){
			$imageLink = "s_".$imageObjects[0]->getVar('image_filename');
		}
		$title = sprintf("%s (&yen;%s-)",$object->getVar('item_name'), number_format($object->getVar('price')));
		$ret[] = array(
			'image' => $imageLink,
			'link' =>  'itemList/itemDetail/'.$object->getVar('item_id') ,
			'title' => $title,
			'time' => $object->getVar('last_update')
		) ;
	}

	return $ret ;
}

}


?>