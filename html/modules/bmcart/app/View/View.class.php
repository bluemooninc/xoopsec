<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 12/07/27
 * Time: 19:09
 * To change this template use File | Settings | File Templates.
 */
class view {
    public function forge(&$render,$viewTemplate,$data){
        $render->setTemplateName($viewTemplate);
        foreach($data as $key=>$val){
            $render->setAttribute($key,$val);
        }
    }
}
