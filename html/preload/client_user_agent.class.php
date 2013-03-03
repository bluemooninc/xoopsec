<?php

class client_user_agent extends XCube_ActionFilter
{
	function postFilter()
	{
		global $xoopsTpl;

		if(strpos($_SERVER['HTTP_USER_AGENT'],"iPhone")){
			$xoopsTpl->assign('smartphone',true);
		} elseif(strpos($_SERVER['HTTP_USER_AGENT'],"Android")){
			$xoopsTpl->assign('smartphone',true);
		} elseif(strpos($_SERVER['HTTP_USER_AGENT'],"Windows Mobile")){
			$xoopsTpl->assign('smartphone',true);
		}else{
			$xoopsTpl->assign('smartphone',false);
		}
/*
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'ISIOS:TRUE') === false) {
			$xoopsTpl->assign('wakdoki_ios',false);
		} else {
			$xoopsTpl->assign('wakdoki_ios',true);
		}
*/
	}
}