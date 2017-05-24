<?php
// vim: foldmethod=marker
/**
 *  Ethna_Plugin.php
 *
 *  @author     ICHII Takashi <ichii386@schweetheart.jp>
 *  @author     Kazuhiro Hosoi <hosoi@gree.co.jp>
 *  @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 *  @package    Ethna
 *  @version    $Id: Ethna_Plugin.php 852 2009-06-04 13:39:47Z maru_cc $
 */

// {{{ Ethna_Plugin
/**
 *  プラグインクラス
 *  
 *  @author     ICHII Takashi <ichii386@schweetheart.jp>
 *  @author     Kazuhiro Hosoi <hosoi@gree.co.jp>
 *  @access     public
 *  @package    Ethna
 */
class Ethna_Plugin
{
    /**#@+
     *  @access private
     */

    /** @var    object  Ethna_Controller    コントローラオブジェクト */
    var $controller;

    /** @var    object  Ethna_Controller    コントローラオブジェクト($controllerの省略形) */
    var $ctl;

    /** @var    object  Ethna_Logger        ログオブジェクト */
    var $logger;

    /** @var    array   プラグインのオブジェクト(インスタンス)を保存する配列 */
    var $obj_registry = array();

    /** @var    array   プラグインのクラス名、ソースファイル名を保存する配列 */
    var $src_registry = array();

    /** @var    array   検索対象ディレクトリを，プラグインの優先順に保存する配列 */
    var $_dirlist = array();

    /**#@-*/

    // {{{ コンストラクタ
    /**
     *  Ethna_Pluginのコンストラクタ
     *
     *  @access public
     *  @param  object  Ethna_Controller    $controller コントローラオブジェクト
     */
    function Ethna_Plugin(&$controller)
    {
        $this->controller =& $controller;
        $this->ctl =& $this->controller;
        $this->logger = null;

        // load dir_registry
        $this->_loadPluginDirList();
    }

    /**
     *  loggerをsetする。
     *
     *  LogWriterはpluginなので、pluginインスタンス作成時点では
     *  loggerに依存しないようにする。
     *
     *  @access public
     *  @param  object  Ethna_Logger    $logger ログオブジェクト
     */
    function setLogger(&$logger)
    {
        if ($this->logger === null && is_object($logger)) {
            $this->logger =& $logger;
        }
    }
    // }}}

    // {{{ プラグイン呼び出しインタフェース
    /**
     *  プラグインのインスタンスを取得
     *
     *  @access public
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     *  @return object  プラグインのインスタンス
     */
    function &getPlugin($type, $name)
    {
        return $this->_getPlugin($type, $name);
    }

    /**
     *  ある種類 ($type) のプラグイン ($name) の全リストを取得
     *
     *  @access public
     *  @param  string  $type   プラグインの種類
     *  @return array   プラグインオブジェクトの配列
     */
    function getPluginList($type)
    {
        $plugin_list = array();

        $this->searchAllPluginSrc($type);
        if (isset($this->src_registry[$type]) == false) {
            return $plugin_list;
        }
        foreach ($this->src_registry[$type] as $name => $value) {
            if (is_null($value)) {
                continue;
            }
            $plugin_list[$name] =& $this->getPlugin($type, $name);
        }
        return $plugin_list;
    }
    // }}}

    // {{{ obj_registry のアクセサ
    /**
     *  プラグインのインスタンスをレジストリから取得
     *
     *  @access private
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     *  @return object  プラグインのインスタンス
     */
    function &_getPlugin($type, $name)
    {
        if (isset($this->obj_registry[$type]) == false) {
            $this->obj_registry[$type] = array();

            // プラグインの親クラスを(存在すれば)読み込み
            list($class, $file) = $this->getPluginNaming($type, null);
            $dir = $this->_searchPluginSrcDir($type, null);
            if (!Ethna::isError($dir)) {
                $this->_includePluginSrc($class, $dir, $file, true);
            }
        }

        // key がないときはプラグインをロードする
        if (array_key_exists($name, $this->obj_registry[$type]) == false) {
            $this->_loadPlugin($type, $name);
        }

        // null のときはロードに失敗している
        if (is_null($this->obj_registry[$type][$name])) {
            return Ethna::raiseWarning('plugin [type=%s, name=%s] is not found',
                E_PLUGIN_NOTFOUND, $type, $name);
        }

        // プラグインのインスタンスを返す
        return $this->obj_registry[$type][$name];
    }

    /**
     *  プラグインをincludeしてnewし，レジストリに登録
     *
     *  @access private
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     */
    function _loadPlugin($type, $name)
    {
        // プラグインのファイル名を取得
        $plugin_src_registry = $this->_getPluginSrc($type, $name);
        if (is_null($plugin_src_registry)) {
            $this->obj_registry[$type][$name] = null;
            return;
        }
        list($plugin_class, $plugin_dir, $plugin_file) = $plugin_src_registry;

        // プラグインのファイルを読み込み
        $r =& $this->_includePluginSrc($plugin_class, $plugin_dir, $plugin_file);
        if (Ethna::isError($r)) {
            $this->obj_registry[$type][$name] = null;
            return;
        }

        // プラグイン作成
        $instance =& new $plugin_class($this->controller, $type, $name);
        if (is_object($instance) == false
            || strcasecmp(get_class($instance), $plugin_class) != 0) {
            $this->logger->log(LOG_WARNING, 'plugin [%s::%s] instantiation failed', $type, $name);
            $this->obj_registry[$type][$name] = null;
            return;
        }
        $this->obj_registry[$type][$name] =& $instance;
    }

    /**
     *  プラグインのインスタンスをレジストリから消す
     *
     *  @access private
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     */
    function _unloadPlugin($type, $name)
    {
        unset($this->obj_registry[$type][$name]);
    }
    // }}}

    /**
     *  プラグインのインスタンスをレジストリから消す
     *
     *  @access private
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     */
    function _loadPluginDirList()
    {
        $this->_dirlist[] = $this->controller->getDirectory('plugin');

        // include_path から検索
        $include_path_list = explode(PATH_SEPARATOR, get_include_path());

        // Communiy based libraries
        $extlib_dir = implode(DIRECTORY_SEPARATOR, array('Ethna', 'extlib', 'Plugin'));
        // Ethna bandle
        $class_dir = implode(DIRECTORY_SEPARATOR, array('Ethna', 'class', 'Plugin'));
        foreach ($include_path_list as $include_path) {
            if (is_dir($include_path . DIRECTORY_SEPARATOR . $extlib_dir)) {
                $this->_dirlist[] = $include_path . DIRECTORY_SEPARATOR . $extlib_dir;
            }
            if (is_dir($include_path . DIRECTORY_SEPARATOR . $class_dir)) {
                $this->_dirlist[] = $include_path . DIRECTORY_SEPARATOR . $class_dir;
            }
        }
    }

    // {{{ src_registry のアクセサ
    /**
     *  プラグインのソースファイル名とクラス名をレジストリから取得
     *
     *  @access private
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     *  @return array   ソースファイル名とクラス名からなる配列
     */
    function _getPluginSrc($type, $name)
    {
        if (isset($this->src_registry[$type]) == false) {
            $this->src_registry[$type] = array();
        }

        // key がないときはプラグインの検索をする
        if (array_key_exists($name, $this->src_registry[$type]) == false) {
            $this->_searchPluginSrc($type, $name);
        }

        // プラグインのソースを返す
        return $this->src_registry[$type][$name];
    }
    // }}}

    // {{{ プラグインファイル検索部分
    /**
     *  プラグインのクラス名、ディレクトリ、ファイル名を決定
     *
     *  @access public
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前 (nullのときは親クラス)
     *  @param  string  $appid  アプリケーションID (廃止予定)
     *  @return array   プラグインのクラス名、ファイル名の配列
     */
    function getPluginNaming($type, $name = null, $appid = 'Ethna')
    {
        $ext = $this->ctl->getExt('php');

        $plugin_class_name = array(
            $appid,
            'Plugin',
            $type,
        );

        if ($name !== null) {
            $plugin_class_name[] = $name;
        }
        else {
            $name = $type;
        }

        $class = implode('_', $plugin_class_name);
        $file  = "{$name}.{$ext}";

        return array($class, $file);
    }

    /**
     *  プラグインのソースを include する
     *
     *  @access private
     *  @param  string  $class  クラス名
     *  @param  string  $dir    ディレクトリ名
     *  @param  string  $file   ファイル名
     *  @param  bool    $parent 親クラスかどうかのフラグ
     *  @return true|Ethna_Error
     */
    function &_includePluginSrc($class, $dir, $file, $parent = false)
    {
        $true = true;
        if (class_exists($class)) {
            return $true;
        }

        $file = $dir . '/' . $file;
        if (file_exists_ex($file) === false) {
            if ($parent === false) {
                return Ethna::raiseWarning('plugin file is not found: [%s]',
                                           E_PLUGIN_NOTFOUND, $file);
            } else {
                return $true;
            }
        }

        include_once $file;

        if (class_exists($class) === false) {
            if ($parent === false) {
                return Ethna::raiseWarning('plugin class [%s] is not defined',
                    E_PLUGIN_NOTFOUND, $class);
            } else {
                return $true;
            }
        }

        if ($parent === false) {
            $this->logger->log(LOG_DEBUG, 'plugin class [%s] is defined', $class);
        }
        return $true;
    }

    /**
     *  プラグインのソースディレクトリを決定する
     *
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前 (nullのときは親クラス)
     *  @retur  string  directory
     */
    function _searchPluginSrcDir($type, $name)
    {
        list(, $file) = $this->getPluginNaming($type, $name);

        $dir_prefix = "";
        if ($name !== null) {
            $dir_prefix = DIRECTORY_SEPARATOR . $type;
        }

        // dirlist にしたがって検索
        foreach ($this->_dirlist as $dir) {
            $dir .= $dir_prefix;

            if (file_exists($dir . DIRECTORY_SEPARATOR . $file)) {
                return $dir;
            }
        }

        return Ethna::raiseWarning('plugin file is not found in search directories: [%s]',
                                   E_PLUGIN_NOTFOUND, $file);
    }

    /**
     *  アプリケーション, extlib, Ethna の順でプラグインのソースを検索する
     *
     *  @access private
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     *  @return array   class, dir, file
     */
    function _searchPluginSrc($type, $name)
    {
        list($class, $file) = $this->getPluginNaming($type, $name);
        if (class_exists($class)) {
            // すでにクラスが存在する場合は特別にスキップ
            if (isset($this->src_registry[$type]) == false) {
                $this->src_registry[$type] = array();
            }
        }

        $dir = $this->_searchPluginSrcDir($type, $name);

        if (Ethna::isError($dir)) {
            $this->src_registry[$type][$name] = null;
            return ;
        }

        if (file_exists("{$dir}/{$file}")) {
            $this->logger->log(LOG_DEBUG, 'plugin file is found in search: [%s/%s]',
                               $dir, $file);
            if (isset($this->src_registry[$type]) == false) {
                $this->src_registry[$type] = array();
            }
            $this->src_registry[$type][$name] = array($class, $dir, $file);
            return;
        }

        // 見つからなかった場合 (nullで記憶しておく)
        $this->logger->log(LOG_WARNING, 'plugin file for [type=%s, name=%s] is not found in search', $type, $name);
        $this->src_registry[$type][$name] = null;
    }

    /**
     *  プラグインの種類 ($type) をすべて検索する
     *
     *  @access public
     *  @return array
     */
    function searchAllPluginType()
    {
        $type_list = array();
        foreach($this->_dirlist as $dir) {
            $type_dir= glob($dir . DIRECTORY_SEPARATOR . "*", GLOB_ONLYDIR);
            if (!$type_dir) {
                continue;
            }
            foreach ($type_dir as $dir) {
                if ($type_dir{0} != '.') {
                    $type_list[basename($dir)] = 0;
                }
            }
        }
        return array_keys($type_list);
    }

    /**
     *  指定された $type のプラグイン (のソース) をすべて検索する
     *
     *  @access public
     *  @param  string  $type   プラグインの種類
     */
    function searchAllPluginSrc($type)
    {
        // 後で見付かったもので上書きするので $this->appid_list の逆順とする
        $name_list = array();
        $ext = $this->ctl->getExt('php');

        foreach($this->_dirlist as $dir) {
            $files = glob($dir . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . "/*." . $ext);
            if (!$files) {
                $this->logger->log(LOG_DEBUG, 'cannot open plugin directory: [%s/%s]', $dir, $type);
                continue;
            }
            $this->logger->log(LOG_DEBUG, 'plugin directory opened: [%s]', $dir);
            foreach ($files as $plugin_file) {
                $plugin_name = substr(basename($plugin_file), 0, - strlen($ext) - 1);
                $name_list[$plugin_name] = 0;
            }
        }

        foreach (array_keys($name_list) as $name) {
            // 冗長だがもう一度探しなおす
            $this->_searchPluginSrc($type, $name);
        }
    }
    // }}}

    // {{{ static な include メソッド
    /**
     *  Ethna 本体付属のプラグインのソースを include する
     *
     *  @access public
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     *  @static
     */
    function includeEthnaPlugin($type, $name)
    {
        Ethna_Plugin::includePlugin($type, $name, 'Ethna');
    }

    /**
     *  プラグインのソースを include する
     *
     *  @access public
     *  @param  string  $type   プラグインの種類
     *  @param  string  $name   プラグインの名前
     *  @param  string  $appid  アプリケーションID
     *  @static
     */
    function includePlugin($type, $name, $appid = null)
    {
        $ctl = Ethna_Controller::getInstance();
        $plugin =& $ctl->getPlugin();

        if ($appid === null) {
            $appid = $ctl->getAppId();
        }

        list($class, $file) = $plugin->getPluginNaming($type, $name);
        $dir = $this->_searchPluginSrcDir($type, $name);
        $plugin->_includePluginSrc($class, $dir, $file);
    }
    // }}}
}
// }}}
?>
