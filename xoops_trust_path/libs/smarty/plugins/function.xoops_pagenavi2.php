<?php
/**
 *
 * @package Legacy
 * @version $Id: function.xoops_pagenavi.php,v 1.3 2008/09/25 15:12:37 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/>
 * @license http://xoopscube.sourceforge.net/license/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     xoops_pagenavi
 * Version:  1.0
 * Date:     Nov 13, 2005
 * Author:   minahito
 * Purpose:  the place holder for xoops pagenavi.
 * Input:    pagenavi =
 *           offset =
 *
 * Examples: {xoops_pagenavi pagenavi=$pagenavi}
 * -------------------------------------------------------------
 */
function smarty_function_xoops_pagenavi2($params, &$smarty)
{
	$ret = '';

	if (isset($params['pagenavi']) && is_object($params['pagenavi'])) {

		$navi =& $params['pagenavi'];

		$perPage = $navi->getPerpage();

		$total = $navi->getTotalItems();
		$totalPages = $navi->getTotalPages();

		if ($totalPages == 0) {
			return;
		}

		$url = $navi->renderURLForPage();
		$current = $navi->getStart();

		$offset = isset($params['offset']) ? intval($params['offset']) : 2;
		$ret = '<div class="pagination pagination-centered"><ul>';
		//
		// check prev
		//
		if($navi->hasPrivPage()) {
			$ret .= @sprintf("<li><a href='%s'>&laquo;</a></li>", $navi->renderURLForPage($navi->getPrivStart()));
		}

		//
		// counting
		//
		$counter=1;
		$currentPage = $navi->getCurrentPage();
		while($counter<=$totalPages) {
			if($counter==$currentPage) {
				$ret.=@sprintf("<li class='active'><a>%d</a></li>",$counter);
			}
			elseif(($counter>$currentPage-$offset && $counter<$currentPage+$offset) || $counter==1 || $counter==$totalPages) {
				if($counter==$totalPages && $currentPage<$totalPages-$offset) {
					$ret.="<li class='disabled'><a>...</a></li>";
				}
				$ret .= @sprintf("<li><a href='%s'>%d</a></li>",$navi->renderURLForPage(($counter-1)*$perPage),$counter);
				if($counter==1 && $currentPage>1 + $offset) {
					$ret.="<li class='disabled'><a>...</a></li>";
				}
			}
			$counter++;
		}

		//
		// check next
		//
		$next=$current + $perPage;
		if($navi->hasNextPage()) {
			$ret.=@sprintf("<li><a href='%s'>&raquo;</a></li>",$navi->renderURLForPage($navi->getNextStart()));
		}
		$ret .= "</ul></div>";
	}

	print $ret;
}

?>
