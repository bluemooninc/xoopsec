<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
define('_USE_XOOPSMAILER', false);

abstract class AbstractAction
{
    protected $isError = false;
    protected $errMsg = "";
    protected $root;
    protected $url = 'index';
    protected $unamelink = array();
    protected $method;

    public function __construct()
    {
        $this->root = XCube_Root::getSingleton();
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    protected function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    protected function setErr($msg)
    {
        $this->isError = true;
        $this->errMsg = $msg;
    }

    public function getisError()
    {
        return $this->isError;
    }

    public function geterrMsg()
    {
        return $this->errMsg;
    }

    protected function getMailer()
    {
        $classname = 'XoopsMailer';
        if (_USE_XOOPSMAILER == true) {
            require_once XOOPS_ROOT_PATH . '/class/xoopsmailer.php';
            if (is_file(XOOPS_ROOT_PATH . '/language/' . $this->root->mLanguageManager->mLanguageName . '/xoopsmailerlocal.php')) {
                require_once XOOPS_ROOT_PATH . '/language/' . $this->root->mLanguageManager->mLanguageName . '/xoopsmailerlocal.php';
                if (XC_CLASS_EXISTS('XoopsMailerLocal')) {
                    $classname = 'XoopsMailerLocal';
                }
            }
        } else {
            require_once XOOPS_ROOT_PATH . '/class/mail/phpmailer/class.phpmailer.php';
            require_once _MY_MODULE_PATH . 'class/MyMailer.class.php';
            $classname = 'My_Mailer';
        }
        return new $classname();
    }
    //abstract public function execute();
    abstract public function executeView(&$render);

}

?>
