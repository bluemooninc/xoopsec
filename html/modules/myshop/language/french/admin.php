<?php
//  ------------------------------------------------------------------------ //
//                      MYSHOP - MODULE FOR XOOPS 2                		 	 //
//                  Copyright (c) 2007, 2008 Instant Zero                    //
//                     <http://www.instant-zero.com/>                        //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

define("_AM_MYSHOP_GO_TO_MODULE","Aller au module");
define("_AM_MYSHOP_PREFERENCES","Préférences");
define("_AM_MYSHOP_ADMINISTRATION","Administration");
define("_AM_MYSHOP_CATEGORIES","Catégories");
define("_AM_MYSHOP_CATEG_CONFIG","Configuration des blocs sur les pages des catégories");
define("_AM_MYSHOP_CHUNK","Bloc");
define("_AM_MYSHOP_POSITION","Position & visibilité");
define("_AM_MYSHOP_INVISIBLE","Invisible");
define("_AM_MYSHOP_OK","Ok");
define("_AM_MYSHOP_SAVE_OK","Données enregistrées avec succès");
define("_AM_MYSHOP_SAVE_PB","Problème durant la sauvegarde des données");
define("_AM_MYSHOP_ACTION","Action");
define("_AM_MYSHOP_ADD_ITEM","Ajouter un élément");
define("_AM_MYSHOP_CONF_DELITEM","Voulez vous vraiment supprimer cet élément ?");
define("_AM_MYSHOP_LIST","Liste");
define("_AM_MYSHOP_ID","Id");
define("_AM_MYSHOP_RATE","Taux");

define("_AM_MYSHOP_ADD_VAT","Ajouter une TVA");
define("_AM_MYSHOP_EDIT_VAT","Editer une TVA");

define("_AM_MYSHOP_ADD_CATEG","Ajouter une catégorie");
define("_AM_MYSHOP_EDIT_CATEG","Editer une catégorie");

define("_AM_MYSHOP_ADD_STORE","Ajouter un vendeur");
define("_AM_MYSHOP_EDIT_STORE","Editer un vendeur");

define("_AM_MYSHOP_ADD_MANUFACTURER","Ajouter un fabricant");
define("_AM_MYSHOP_EDIT_MANUFACTURER","Editer un fabricant");


define("_AM_MYSHOP_ADD_PRODUCT","Ajouter un produit (tous les champs ne sont pas obligatoires)");
define("_AM_MYSHOP_EDIT_PRODUCT","Editer un produit (tous les champs ne sont pas obligatoires)");

define("_AM_MYSHOP_ADD_DSICOUNT","Ajouter une promotion");
define("_AM_MYSHOP_EDIT_DISCOUNT","Editer une promotion");

define("_AM_MYSHOP_ERROR_1","Erreur, pas d'identifiant spécifié");
define("_AM_MYSHOP_ERROR_2","Erreur, impossible de supprimer cette TVA, elle est utilisée par des produits");
define("_AM_MYSHOP_ERROR_3","Erreur pendant le téléchargement du fichier ");
define("_AM_MYSHOP_ERROR_4","Erreur, impossible de supprimer cette catégorie, elle est utilisée par des produits");
define("_AM_MYSHOP_ERROR_5","Erreur, impossible de supprimer ce fabricant car  il est utilisée par des produits");
define("_AM_MYSHOP_ERROR_6","Erreur, impossible de supprimer ce vendeur, il est utilisé par un ou plusieurs produits");
define("_AM_MYSHOP_ERROR_7","Erreur, impossible de créer le fichier d'export");
define("_AM_MYSHOP_ERROR_8","Erreur, veuillez créer au moins une catégorie avant de créer un produit");
define("_AM_MYSHOP_NOT_FOUND", "Erreur, élément introuvable");

define("_AM_MYSHOP_MODIFY", "Modifier");
define("_AM_MYSHOP_ADD", "Ajouter");

define("_AM_MYSHOP_PARENT_CATEG", "Catégorie mère");
define("_AM_MYSHOP_CURRENT_PICTURE", "Image courante");
define("_AM_MYSHOP_PICTURE", "Image");
define("_AM_MYSHOP_DESCRIPTION", "Description");

define("_AM_MYSHOP_ALL", "Tous");
define("_AM_MYSHOP_LIMIT_TO", "Filtre");
define("_AM_MYSHOP_FILTER", "Filtrer");
define("_AM_MYSHOP_INDEX_PAGE", "Page d'index");
define("_AM_MYSHOP_RELATED_HELP", "Attention, à ne saisir qu'après avoir saisi tous les produits");
define("_AM_MYSHOP_SUBDATE_HELP", "Entrer la date au format AAAA-MM-JJ");
define("_AM_MYSHOP_IMAGE1_HELP", "Image courante");
define("_AM_MYSHOP_IMAGE2_HELP", "Image courante de la miniature");
define("_AM_MYSHOP_IMAGE1_CHANGE", "Modifier l'image du produit");
define("_AM_MYSHOP_IMAGE2_CHANGE", "Modifier l'image de la miniature");
define("_AM_MYSHOP_ATTACHED_HLP", "");
define("_AM_MYSHOP_CATEG_HLP", "Catégorie du produit");
define("_AM_MYSHOP_CATEG_TITLE", "Titre de la catégorie");
define("_AM_MYSHOP_URL_HLP", "Adresse internet du produit (optionnelle)");
define("_AM_MYSHOP_SELECT_HLP", "Utilisez la touche Ctrl (ou la touche pomme sur Mac) pour choisir plusieurs éléments");
define("_AM_MYSHOP_STOCK_HLP", "Envoi d'un email si le stock atteint le nombre de ...");
define("_AM_MYSHOP_DISCOUNT_HLP", "Prix promotionel (temporaire HT)");
define("_AM_MYSHOP_DISCOUNT_DESCR", "Description de la réduction (pour votre client)");
define("_AM_MYSHOP_DATE", "Date");
define("_AM_MYSHOP_CLIENT", "Client");
define("_AM_MYSHOP_TOTAL_SHIPP", "Total / Frais de ports");
define('_AM_MYSHOP_NEWSLETTER_BETWEEN', "S&eacute;lectionner les produits publi&eacute;s entre le");
define('_AM_MYSHOP_EXPORT_AND', ' et ');
define('_AM_MYSHOP_IN_CATEGORY', 'Dans les catégories suivantes');
define('_AM_MYSHOP_REMOVE_BR',"Convertir les balises html &lt;br /&gt; en un retour à la ligne ?");
define('_AM_MYSHOP_NEWSLETTER_HTML_TAGS', "Supprimer les balises html ?");
define('_AM_MYSHOP_NEWSLETTER_HEADER', "Entête");
define('_AM_MYSHOP_NEWSLETTER_FOOTER', "Pied de page");
define('_AM_MYSHOP_CSV_EXPORT', "Export au format CSV");
define('_AM_MYSHOP_CSV_READY', "Votre fichier CSV est prêt pour téléchargement, cliquez sur ce lien pour l'obtenir");
define('_AM_MYSHOP_NEW_QUANTITY', "Nouvelle quantité");
define('_AM_MYSHOP_UPDATE_QUANTITIES', "Mettre à jour les quantités");
define('_AM_MYSHOP_NEWSLETTER_READY', "Votre newsletter est prête, cliquez sur ce lien pour la récupérer.");
define('_AM_MYSHOP_DUPLICATED', "Dupliqué");

// Added on 14/04/2007 17:11
define('_AM_MYSHOP_SORRY_NOREMOVE', "Désolé mais nous ne pouvons pas supprimer ce produit car il fait partie des commandes suivantes");
define('_AM_MYSHOP_CONF_VALIDATE', "Confirmez vous la validation de cette commande ?");
define('_AM_MYSHOP_LAST_ORDERS', "Dernières commandes");
define('_AM_MYSHOP_LAST_VOTES', "Derniers votes");
define('_AM_MYSHOP_NOTE', "Note");
?>
