<?php
/* $Id: defines.lib.php,v 1.1.1.1 2005/08/07 03:49:45 yoshis Exp $ */

/**
 * DEFINES VARIABLES & CONSTANTS
 * Overview:
 *    PMA_VERSION              (string) - phpMyAdmin version string
 *    PMA_PHP_INT_VERSION      (int)    - eg: 30017 instead of 3.0.17 or
 *                                        40006 instead of 4.0.6RC3
 *    PMA_IS_WINDOWS           (bool)   - mark if phpMyAdmin running on windows
 *                                        server
 *    PMA_MYSQL_INT_VERSION    (int)    - eg: 32339 instead of 3.23.39
 *    PMA_USR_OS               (string) - the plateform (os) of the user
 *    PMA_USR_BROWSER_AGENT    (string) - the browser of the user
 *    PMA_USR_BROWSER_VER      (double) - the version of this browser
 */
// phpMyAdmin release
if (!defined('PMA_VERSION')) {
    define('PMA_VERSION', '2.2.6');
}

// php version
if (!defined('PMA_PHP_INT_VERSION')) {
    if (!preg_match('|^([0-9]+\.)+([0-9]+\.)+[0-9]|', phpversion(), $match)) {
        $result = preg_match('|^([0-9]+\.)+[0-9]|', phpversion(), $match);
    }
    if (isset($match) && !empty($match[1])) {
        if (!isset($match[2])) {
            $match[2] = 0;
        }
        if (!isset($match[3])) {
            $match[3] = 0;
        }
        define('PMA_PHP_INT_VERSION', (int)sprintf('%d%02d%02d', $match[1], $match[2], $match[3]));
        unset($match);
    } else {
        define('PMA_PHP_INT_VERSION', 0);
    }
}

// Whether the os php is running on is windows or not
if (!defined('PMA_IS_WINDOWS')) {
    if (defined('PHP_OS') && preg_match('/win/', PHP_OS)) {
        define('PMA_IS_WINDOWS', 1);
    } else {
        define('PMA_IS_WINDOWS', 0);
    }
}

// MySQL Version
if (!defined('PMA_MYSQL_INT_VERSION')) {
    if (!empty($server)) {
        $result = mysql_query('SELECT VERSION() AS version');
        if ($result != FALSE && @mysql_num_rows($result) > 0) {
            $row   = mysql_fetch_array($result);
            $match = explode('.', $row['version']);
        } else {
            $result = @mysql_query('SHOW VARIABLES LIKE \'version\'');
            if ($result != FALSE && @mysql_num_rows($result) > 0){
                $row   = mysql_fetch_row($result);
                $match = explode('.', $row[1]);
            }
        }
    } // end server id is defined case

    if (!isset($match) || !isset($match[0])) {
        $match[0] = 3;
    }
    if (!isset($match[1])) {
        $match[1] = 21;
    }
    if (!isset($match[2])) {
        $match[2] = 0;
    }

    define('PMA_MYSQL_INT_VERSION', (int)sprintf('%d%02d%02d', $match[0], $match[1], intval($match[2])));
    unset($match);
}


// Determines platform (OS), browser and version of the user
// Based on a phpBuilder article:
//   see http://www.phpbuilder.net/columns/tim20000821.php
if (!defined('PMA_USR_OS')) {
    // loic1 - 2001/25/11: use the new globals arrays defined with
    // php 4.1+
    if (!empty($_SERVER['HTTP_USER_AGENT'])) {
        $HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
    } else if (!empty($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) {
        $HTTP_USER_AGENT = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
    } else if (!isset($HTTP_USER_AGENT)) {
        $HTTP_USER_AGENT = '';
    }

    // 1. Platform
    if (strstr($HTTP_USER_AGENT, 'Win')) {
        define('PMA_USR_OS', 'Win');
    } else if (strstr($HTTP_USER_AGENT, 'Mac')) {
        define('PMA_USR_OS', 'Mac');
    } else if (strstr($HTTP_USER_AGENT, 'Linux')) {
        define('PMA_USR_OS', 'Linux');
    } else if (strstr($HTTP_USER_AGENT, 'Unix')) {
        define('PMA_USR_OS', 'Unix');
    } else if (strstr($HTTP_USER_AGENT, 'OS/2')) {
        define('PMA_USR_OS', 'OS/2');
    } else {
        define('PMA_USR_OS', 'Other');
    }


    // 2. browser and version
    // (must check everything else before Mozilla)

    if (preg_match(
        '@Opera(/| )([0-9].[0-9]{1,2})@',
        $HTTP_USER_AGENT,
        $log_version
    )) {
        define('PMA_USR_BROWSER_VER', $log_version[2]);
        define('PMA_USR_BROWSER_AGENT', 'OPERA');
    } elseif (preg_match(
        '@MSIE ([0-9].[0-9]{1,2})@',
        $HTTP_USER_AGENT,
        $log_version
    )) {
        define('PMA_USR_BROWSER_VER', $log_version[1]);
        define('PMA_USR_BROWSER_AGENT', 'IE');
    } elseif (preg_match(
        '@OmniWeb/([0-9].[0-9]{1,2})@',
        $HTTP_USER_AGENT,
        $log_version
    )) {
        define('PMA_USR_BROWSER_VER', $log_version[1]);
        define('PMA_USR_BROWSER_AGENT', 'OMNIWEB');
        // Konqueror 2.2.2 says Konqueror/2.2.2
        // Konqueror 3.0.3 says Konqueror/3
    } elseif (preg_match(
        '@(Konqueror/)(.*)(;)@',
        $HTTP_USER_AGENT,
        $log_version
    )) {
        define('PMA_USR_BROWSER_VER', $log_version[2]);
        define('PMA_USR_BROWSER_AGENT', 'KONQUEROR');
    } elseif (preg_match(
        '@Mozilla/([0-9].[0-9]{1,2})@',
        $HTTP_USER_AGENT,
        $log_version)
        && preg_match('@Safari/([0-9]*)@', $HTTP_USER_AGENT, $log_version2)
    ) {
        define('PMA_USR_BROWSER_VER', $log_version[1] . '.' . $log_version2[1]);
        define('PMA_USR_BROWSER_AGENT', 'SAFARI');
    } elseif (preg_match('@rv:1.9(.*)Gecko@', $HTTP_USER_AGENT)) {
        define('PMA_USR_BROWSER_VER', '1.9');
        define('PMA_USR_BROWSER_AGENT', 'GECKO');
    } elseif (
        preg_match('@Mozilla/([0-9].[0-9]{1,2})@',
            $HTTP_USER_AGENT,
            $log_version
        )) {
        define('PMA_USR_BROWSER_VER', $log_version[1]);
        define('PMA_USR_BROWSER_AGENT', 'MOZILLA');
    } else {
        define('PMA_USR_BROWSER_VER', 0);
        define('PMA_USR_BROWSER_AGENT', 'OTHER');
    }
} // $__PMA_DEFINES_LIB__
