<?php

if (!defined('XOOPS_ROOT_PATH')) {
    die("XOOPS root path not defined");
}

define("MYSHOP_STATE_NOINFORMATION", 0);
define("MYSHOP_STATE_VALIDATED", 1);
define("MYSHOP_STATE_PENDING", 2);
define("MYSHOP_STATE_FAILED", 3);
define("MYSHOP_STATE_CANCELED", 4);
define("MYSHOP_STATE_FRAUD", 5);

include_once XOOPS_ROOT_PATH . '/class/xoopsobject.php';
if (!class_exists('Myshop_XoopsPersistableObjectHandler')) {
    include_once XOOPS_ROOT_PATH . '/modules/myshop/class/PersistableObjectHandler.php';
}

class myshop_commands extends Myshop_Object
{
    function __construct()
    {
        $this->initVar('cmd_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cmd_uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cmd_date', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('cmd_state', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cmd_ip', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('cmd_lastname', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('cmd_firstname', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('cmd_adress', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('cmd_zip', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('cmd_town', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('cmd_country', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('cmd_telephone', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('cmd_email', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('cmd_articles_count', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cmd_total', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('cmd_shipping', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('cmd_bill', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cmd_password', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('cmd_text', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('cmd_cancel', XOBJ_DTYPE_TXTBOX, null, false);
    }


    /**
     * Retourne les �l�ments du produits format�s pour affichage
     *
     * @param string $format
     * @return array
     */
    function toArray($format = 's')
    {
        $ret = array();
        $ret = parent::toArray($format);
        include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
        $countries = array();
        $countries = XoopsLists::getCountryList();
        $myshop_Currency = myshop_Currency::getInstance();
        $ret['cmd_total_fordisplay'] = $myshop_Currency->amountForDisplay($this->getVar('cmd_total')); // Montant TTC de la commande
        $ret['cmd_shipping_fordisplay'] = $myshop_Currency->amountForDisplay($this->getVar('cmd_shipping')); // Montant TTC des frais de port
        $ret['cmd_text_fordisplay'] = nl2br($this->getVar('cmd_text')); // Liste des r�ductions accord�es
        if (isset($countries[$this->getVar('cmd_country')])) { // Libell� du pays de l'acheteur
            $ret['cmd_country_label'] = $countries[$this->getVar('cmd_country')];
        }
        return $ret;
    }
}


class MyshopMyshop_commandsHandler extends Myshop_XoopsPersistableObjectHandler
{
    function __construct($db)
    { //						Table					Classe			 Id
        parent::__construct($db, 'myshop_commands', 'myshop_commands', 'cmd_id');
    }

    /**
     * Indique si c'est la premi�re commande d'un client
     *
     * @param integer $uid Identifiant de l'utilisateur
     * @return boolean Indique si c'est le cas ou pas
     */
    function isFirstCommand($uid = 0)
    {
        if ($uid == 0) {
            $uid = myshop_utils::getCurrentUserID();
        }
        $critere = new Criteria('cmd_uid', intval($uid), '=');
        if ($this->getCount($critere) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Indique si un produit a d�aj� �t� achet� par un utilisateur
     *
     * @param integer $uid Identifiant de l'utilisateur
     * @param integer $productId Identifiant du produit
     * @return boolean Indique si c'est le cas ou pas
     */
    function productAlreadyBought($uid = 0, $productId = 0)
    {
        if ($uid == 0) {
            $uid = myshop_utils::getCurrentUserID();
        }
        $sql = 'SELECT Count(*) as cpt FROM ' . $this->db->prefix('myshop_caddy') . ' c, ' . $this->db->prefix('myshop_commands') . ' f WHERE c.caddy_product_id = ' . intval($productId) . ' AND c.caddy_cmd_id = f.cmd_id AND f.cmd_uid = ' . intval($uid);
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        list($count) = $this->db->fetchRow($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Update Stock
     * @param integer $cmd_id
     * @return void
     */
    function updateStocks($order)
    {
        global $h_myshop_caddy, $h_myshop_products, $h_myshop_persistent_cart;
        $orderId = $order->getVar('cmd_id');
        // Recherche de tous les produits du caddy
        $caddy = $h_myshop_caddy->getCaddyFromCommand($orderId);
        $tblTmp = $tblProducts = array();
        foreach ($caddy as $item) {
            $tblTmp[] = $item->getVar('caddy_product_id');
        }
        // Chargement de tous les produits
        $critere = new Criteria('product_id', '(' . implode(',', $tblTmp) . ')', 'IN');
        $tblProducts = $h_myshop_products->getObjects($critere, true);
        // Boucle sur le caddy pour mettre � jour les quantit�s
        foreach ($caddy as $item) {
            if (isset($tblProducts[$item->getVar('caddy_product_id')])) {
                $product = $tblProducts[$item->getVar('caddy_product_id')];
                $h_myshop_products->decreaseStock($product, $item->getVar('caddy_qte'));
                $h_myshop_products->verifyLowStock($product); // V�rification du stock d'alerte
                $h_myshop_persistent_cart->deleteUserProduct($item->getVar('caddy_product_id'), $order->getVar('cmd_uid'));
            }
        }
        return true;
    }

    /**
     * Retourne la liste des URLs de t�l�chargement li�s � une commande
     *
     * @param object $order    La commande en question
     * @return array    Les URL
     */
    function getOrderUrls(myshop_commands $order)
    {
        global $h_myshop_caddy, $h_myshop_products;
        $retval = array();
        // Recherche des produits du caddy associ�s � cette commande
        $carts = $productsList = $products = array();
        $carts = $h_myshop_caddy->getObjects(new Criteria('caddy_cmd_id', $order->getVar('cmd_id'), '='));
        foreach ($carts as $item) {
            $productsList[] = $item->getVar('caddy_product_id');
        }
        if (count($productsList) > 0) {
            $products = $h_myshop_products->getObjects(new Criteria('product_id', '(' . implode(',', $productsList) . ')', 'IN'), true);
            if (count($products) > 0) {
                foreach ($carts as $item) {
                    $produit = null;
                    if (isset($products[$item->getVar('caddy_product_id')])) {
                        $produit = $products[$item->getVar('caddy_product_id')];
                        if (xoops_trim($produit->getVar('product_download_url')) != '') {
                            $retval[] = MYSHOP_URL . 'download.php?download_id=' . $item->getVar('caddy_pass');
                        }
                    }
                }
            }
        }
        return $retval;
    }

    /**
     * Envoi du mail charg� de pr�venir le client et le magasin qu'une commande est valid�e
     *
     * @param object $order La commande en question
     * @return void
     */
    function notifyOrderValidated(myshop_commands $order)
    {
        global $xoopsConfig;
        $msg = array();
        $Urls = array();
        $Urls = $this->getOrderUrls($order); // On r�cup�re les URL des fichiers � t�l�charger
        $msg['ADDITIONAL_CONTENT'] = '';
        $msg['NUM_COMMANDE'] = $order->getVar('cmd_id');
        if (count($Urls) > 0) {
            $msg['ADDITIONAL_CONTENT'] = _MYSHOP_YOU_CAN_DOWNLOAD . "\n" . implode("\n", $Urls);
        }
        myshop_utils::sendEmailFromTpl('command_shop_verified.tpl', myshop_utils::getEmailsFromGroup(myshop_utils::getModuleOption('grp_sold')), _MYSHOP_PAYPAL_VALIDATED, $msg);
        myshop_utils::sendEmailFromTpl('command_client_verified.tpl', $order->getVar('cmd_email'), sprintf(_MYSHOP_PAYPAL_VALIDATED, $xoopsConfig['sitename']), $msg);
    }


    /**
     * Validation d'une commande et mise � jour des stocks
     *
     * @param object $order        La commande � traiter
     * @return boolean Indique si la validation de la commande s'est bien faite ou pas
     */
    function validateOrder(myshop_commands $order)
    {
        $retval = false;
        $order->setVar('cmd_state', MYSHOP_STATE_VALIDATED);
        $retval = $this->insert($order, true);
        if ($retval) {
            $this->updateStocks($order);
            $this->notifyOrderValidated($order);
        }
        return $retval;
    }

    /**
     * Informe le propri�taire du site qu'une commande est frauduleuse
     *
     * @param object $order La commande en question
     * @return void
     */
    function notifyOrderFraudulent(myshop_commands $order)
    {
        $msg = array();
        $msg['NUM_COMMANDE'] = $order->getVar('cmd_id');
        myshop_utils::sendEmailFromTpl('command_shop_fraud.tpl', myshop_utils::getEmailsFromGroup(myshop_utils::getModuleOption('grp_sold')), _MYSHOP_PAYPAL_FRAUD, $msg);
    }

    /**
     * Applique le statut de commande frauduleuse � une commande
     *
     * @param obejct $order        La commande � traiter
     * @return void
     */
    function setFraudulentOrder(myshop_commands $order)
    {
        $order->setVar('cmd_state', MYSHOP_STATE_FRAUD);
        $this->insert($order, true);
        $this->notifyOrderFraudulent($order);
    }

    /**
     * Informe le propri�taire du site qu'une commande est en attente
     *
     * @param object $order La commande en question
     * @return void
     */
    function notifyOrderPending(myshop_commands $order)
    {
        $msg = array();
        $msg['NUM_COMMANDE'] = $order->getVar('cmd_id');
        myshop_utils::sendEmailFromTpl('command_shop_pending.tpl', myshop_utils::getEmailsFromGroup(myshop_utils::getModuleOption('grp_sold')), _MYSHOP_PAYPAL_PENDING, $msg);
    }

    /**
     * Applique le statut de commande en attente � une commande
     *
     * @param object $order    La commande � traiter
     * @return void
     */
    function setOrderPending(myshop_commands $order)
    {
        $order->setVar('cmd_state', MYSHOP_STATE_PENDING); // En attente
        $this->insert($order, true);
        $this->notifyOrderPending($order);
    }

    /**
     * Informe le propri�taire du site qu'une commande � �chou� (le paiement)
     *
     * @param object $order La commande en question
     * @return void
     */
    function notifyOrderFailed(myshop_commands $order)
    {
        $msg = array();
        $msg['NUM_COMMANDE'] = $order->getVar('cmd_id');
        myshop_utils::sendEmailFromTpl('command_shop_failed.tpl', myshop_utils::getEmailsFromGroup(myshop_utils::getModuleOption('grp_sold')), _MYSHOP_PAYPAL_FAILED, $msg);
    }

    /**
     * Applique le statut de commande �chou�e � une commande
     *
     * @param object $order    La commande � traiter
     * @return void
     */
    function setOrderFailed(myshop_commands $order)
    {
        $order->setVar('cmd_state', MYSHOP_STATE_FAILED); // Echec
        $this->insert($order, true);
        $this->notifyOrderFailed($order);
    }


    /**
     * Informe le propri�taire du site qu'une commande � �chou� (le paiement)
     *
     * @param object $order La commande en question
     * @return void
     */
    function notifyOrderCanceled(myshop_commands $order)
    {
        $msg = array();
        $msg['NUM_COMMANDE'] = $order->getVar('cmd_id');
        myshop_utils::sendEmailFromTpl('command_shop_cancel.tpl', myshop_utils::getEmailsFromGroup(myshop_utils::getModuleOption('grp_sold')), _MYSHOP_ORDER_CANCELED, $msg);
        myshop_utils::sendEmailFromTpl('command_client_cancel.tpl', $order->getVar('cmd_email'), _MYSHOP_ORDER_CANCELED, $msg);
    }


    /**
     * Applique le statut de commande annul�e � une commande
     *
     * @param object $order    La commande � traiter
     * @return void
     */
    function setOrderCanceled(myshop_commands $order)
    {
        $order->setVar('cmd_state', MYSHOP_STATE_CANCELED); // Annul�e
        $this->insert($order, true);
        $this->notifyOrderCanceled($order);
    }

    /**
     * Retourne une commande � partir de son mot de passe d'annulation
     *
     * @param string $cmd_cancel    Le mot de passe d'annulation
     * @return mixed    Soit un objet soit null
     */
    function getOrderFromCancelPassword($cmd_cancel)
    {
        $critere = new Criteria('cmd_cancel', $cmd_cancel, '=');
        if ($this->getCount($critere) > 0) {
            $tblCmd = array();
            $tblCmd = $this->getObjects($critere);
            if (count($tblCmd) > 0) {
                return $tblCmd[0];
            }
        }
        return null;
    }

    /**
     * Retourne la derni�re commande d'un utilisateur (si elle existe)
     *
     * @param integer $uid    Identifiant de la commande
     */
    function getLastUserOrder($uid, $limit = 1)
    {
        $order = null;
        $criteria = new Criteria('cmd_uid', $uid, '=');
        $criteria->setSort('cmd_id');
        $criteria->setOrder('DESC');
        $criteria->setLimit($limit);
        $orders = $this->getObjects($criteria, false);
        if ($limit == 1 && count($orders) > 0) {
            $order = $orders[0];
            return $order;
        }else{
            return $orders;
        }
    }
}
