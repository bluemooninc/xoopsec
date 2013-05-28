<?php
# $Id: signup.php,v 1.1.1.1 2005/08/10 12:14:04 yoshis Exp $

// Written by James E Flemer
// <jflemer@alum.rpi.edu>

/* This is a script to let users sign-up for respondent accounts.
 * It will ask for the following information:
 *   o uid (*)
 *   o Email Address (*)
 *   o First Name
 *   o Last Name
 *   o Password (*)
 * and create a new respondent in the group $FMXCONFIG['signup_realm'].
 */

  if (!defined('ESP_BASE'))
    define('ESP_BASE', dirname(dirname(__FILE__)) .'/');

  require_once(ESP_BASE . '/admin/phpESP.ini.php');
  
//  esp_init_db();

  $fields = array(
      'uid',
      'password',
      'email',
      'fname',
      'lname',
    );
  
  $rqd_fields = array(
      'uid',
      'password',
      'password2',
      'email',
    );
  
  /* Set this value to override value from phpESP.ini. */
  $signup_realm = null;
  
  /* Make this false to generate full HTML, rather than embedable. */
  $embed = true;

  $post =& $GLOBALS['_POST'];
  unset($msg);
  
  /* sanity check the signup_realm */
  if ($signup_realm == null || empty($signup_realm))
    $signup_realm = $GLOBALS['FMXCONFIG']['signup_realm'];
  if ($signup_realm == null || empty($signup_realm)) {
    echo $formRender->mkerror(_MB_Sorry_the_account_request_form_is_disabled);
    return;
  }
  
  /* process form values */
  do if (isset($post['submit'])) {
    /* check for required fields */
    foreach ($rqd_fields as $f) {
      if (!isset($post[$f]) || empty($post[$f])) {
        $msg = '<font color="red">'. _MB_Please_complete_all_required_fields . '</font>';
        break;
      }
    }
    if (isset($msg))
      break;
    
    /* make sure passwords match */
    if ($post['password'] != $post['password2']) {
      $msg = '<font color="red">'. _MB_Passwords_do_not_match . '</font>';
      break;
    }
    
    /* prepare sql statement */
    $sqlf = array();
    $sqlv = array();
    
    foreach ($fields as $f) {
      if (isset($post[$f]) && !empty($post[$f])) {
        array_push($sqlf, $f);
        if ($f == 'password')
          array_push($sqlv, "PASSWORD('" . addslashes($post[$f]) . "')");
        else
          array_push($sqlv, "'" . addslashes($post[$f]) . "'");
      }
    }
    array_push($sqlf, 'realm');
    array_push($sqlv, "'" . addslashes($signup_realm) ."'");

    $sqlf = implode(',', $sqlf);
    $sqlv = implode(',', $sqlv);
    
    $sql = "INSERT INTO ".TABLE_RESPONDENT." ($sqlf) VALUES ($sqlv)";
    
    /* execute statement */
    $res = $xoopsDB->query($sql);
    if (!$res) {
      $msg = '<font color="red">'. _MB_Request_failed .'</font>';
      if ($GLOBALS['FMXCONFIG']['DEBUG'])
        $msg .= $formRender->mkerror($xoopsDB->errno() . ': ' . $xoopsDB->error());
      break;
    }
    
    $msg = '<font color="blue">'. 
        sprintf( _MB_Your_account_has_been_created , htmlspecialchars($post['uid'])) . '</font>';

    foreach ($fields as $f) {
      $post[$f] = null;
      unset($post[$f]);
    }
  } while(0);
  
  $rqd = '<font color="red">*</font>';
?>
<?php if (!$embed) { ?>
<html>
<head>
<!-- $Id: signup.php,v 1.1.1.1 2005/08/10 12:14:04 yoshis Exp $ -->
<title><?php echo _MB_Account_Request_Form; ?></title>
</head>
<body>
<?php } // !$embed ?>
<form method="post">
  <p><?php printf( 
   _MB_Please_complete_the_following, $rqd); ?></p>
<?php if (isset($msg) && !empty($msg)) echo "<p>$msg</p>\n"; ?>
  <table border="0"><tbody align="left">
  <tr>
    <td>&nbsp;</td>
    <th><?php echo _MB_First_Name; ?>:</th>
    <td><?php echo mktext('fname', 16, 16); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <th><?php echo _MB_Last_Name; ?>:</th>
    <td><?php echo mktext('lname', 24, 24); ?></td>
  </tr>
  <tr>
    <td><?php echo $rqd; ?></td>
    <th><?php echo _MB_Email_Address; ?>:</th>
    <td><?php echo mktext('email', 30, 64); ?></td>
  </tr>
  <tr>
    <td><?php echo $rqd; ?></td>
    <th><?php echo _MB_uid; ?>:</th>
    <td><?php echo mktext('uid', 16, 16); ?></td>
  </tr>
  <tr>
    <td><?php echo $rqd; ?></td>
    <th><?php echo _MB_Password; ?>:</th>
    <td><?php echo mkpass('password'); ?></td>
  </tr>
  <tr>
    <td><?php echo $rqd; ?></td>
    <th><?php echo _MB_Confirm_Password; ?>:</th>
    <td><?php echo mkpass('password2'); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo mksubmit('submit'); ?></td>
  </tr>
  </tbody></table>
</form>
<?php if (!$embed) { ?>
</body>
</html>
<?php } // !$embed ?>