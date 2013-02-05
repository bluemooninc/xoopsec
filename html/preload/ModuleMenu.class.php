<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class moduleMenu extends XCube_ActionFilter
{
    function preBlockFilter()
    {
        $this->mRoot->mDelegateManager->add(
            'Legacy_RenderSystem.SetupXoopsTpl',
            array(&$this, 'moduleMenuSmartyAssign')
        );
    }

    function makeSubLinks($dirname,$sublinks)
    {
        $i = 0;
        $ret = NULL;
        foreach ($sublinks as $sublink) {
            if (preg_match("/&nbsp;/", $sublink['name'])) {
                $i--;
                $ret[$i]['dropdown'][] = array(
                    'name' => $sublink['name'],
                    'url' => XOOPS_URL ."/modules/". $dirname  ."/". $sublink['url']
                );
            } else {
                $ret[$i] = array(
                    'name' => $sublink['name'],
                    'url' => XOOPS_URL ."/modules/".  $dirname  ."/". $sublink['url']
                );
            }
            $i++;
        }
        return $ret;
    }

    function moduleMenuSmartyAssign(&$xoopsTpl)
    {
        $moduleHandler = xoops_gethandler('module');
        $criteria = new CriteriaCompo(new Criteria('hasmain', 1));
        $criteria->add(new Criteria('isactive', 1));
        $criteria->add(new Criteria('weight', 0, '>'));
        $modules = $moduleHandler->getObjects($criteria);
        $curModId = isset($GLOBALS['xoopsModule']) && $GLOBALS['xoopsModule']->getVar('mid') ? $GLOBALS['xoopsModule']->getVar('mid') : NULL;
        $modlist = array();
        foreach ($modules as $module) {
            $sublinks = $this->makeSubLinks($module->get('dirname'),$module->subLink());
            if ($curModId == $module->mid()) {
                $modlist[] = array(
                    'directory' => $module->get('dirname'),
                    'name' => $module->get('name'),
                    'sublinks' => $sublinks
                );
            }
        }
        $xoopsTpl->assign('moduleMenu', $modlist);
    }
}
