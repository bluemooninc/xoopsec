<?php
// $Id: modinfo.php,v 1.1.1.1 2005/08/10 12:14:04 yoshis Exp $
//  ------------------------------------------------------------------------ //
//                Bluemoon.Multi-Form                                      //
//                    Copyright (c) 2005 Yoshi.Sakai @ Bluemoon inc.         //
//                       <http://www.bluemooninc.biz/>                       //
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
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'BMSURVEY_MI_LOADED' ) ) {

define( 'BMSURVEY_MI_LOADED' , 1 ) ;


// The name of this module
define("_MI_BMSURVEY_NAME","ウェブアンケート");
define("_MI_BMSURVEY_LIST","公開中一覧");
define("_MI_BMSURVEY_NEW","新規作成");
define("_MI_BMSURVEY_MANAGE","管理画面");
// A brief description of this module
define("_MI_BMSURVEY_BNAME1","入力アンケート");
define("_MI_BMSURVEY_DESC","Bluemoon.Multi-Form");

// Names of blocks for this module
define('_MI_BMSURVEY_RESPONDENT','回答者の編集');
define('_MI_BMSURVEY_CASTFORM','アンケート送信');
define('_MI_BMSURVEY_RECIEVECHECK','アンケート受信');
define('_MI_BMSURVEY_RESISTER','登録メール送信');
define('_MI_BMSURVEY_STATUS','ステータス・チェック');
define('_MI_BMSURVEY_FILECHARSET', '添付ファイル名称コード');
define('_MI_BMSURVEY_FILECHARSET_DESC', 'サーバ保存時のファイル名に使う文字コードを設定します(SJIS,UTF-8,EUC-JP等)');
define('_MI_BMSURVEY_CSVCHARSET', 'CSVファイル名称コード');
define('_MI_BMSURVEY_CSVCHARSET_DESC', 'CSVダウンロード時にコンバートする文字コードを設定します(SJIS,UTF-8,EUC-JP等)');
define('_MI_BMSURVEY_CSVADDNUM', 'CSV出力のフィールド名欄番号標記');
define('_MI_BMSURVEY_CSVADDNUM_DESC', 'CSV出力のフィールド名欄に通し番号を振ります。');
define('_MI_BMSURVEY_CHOICEOPT','CSV出力の選択項目タイプ');
define('_MI_BMSURVEY_CHOICEOPT_DESC','選択項目の出力を文字列か番号（並び順）で行うかを選択します。');
define('_MI_BMSURVEY_CSVOTHERF','CSV出力時の!otherフォーマット');
define('_MI_BMSURVEY_CSVOTHERF_DESC','選択項目その他で入力された値を出力する時のフォーマットを指定します。');
define('_MI_BMSURVEY_MAILSERVER', 'メール・サーバ');
define('_MI_BMSURVEY_MAILSERVER_DESC', '受信用メールのPOP3サーバを設定します');
define('_MI_BMSURVEY_MAILUSER', 'メール・ユーザー');
define('_MI_BMSURVEY_MAILUSER_DESC', 'アンケート用メールアドレスのユーザー名を設定します');
define('_MI_BMSURVEY_MAILPWD', 'メール・パスワード');
define('_MI_BMSURVEY_MAILPWD_DESC', 'アンケート用メールアドレスのパスワードを設定します');
define('_MI_BMSURVEY_MAILADDR', 'メール・アドレス');
define('_MI_BMSURVEY_MAILADDR_DESC', 'アンケート用メールアドレスを設定します');
define('_MI_BMSURVEY_CASTKEY', '質問配信用認証コード');
define('_MI_BMSURVEY_CASTKEY_DESC', 'cast.php を実行するときのkey文字列を設定します');
define('_MI_BMSURVEY_MANAGEGROUP', '管理メニュー利用グループ');
define('_MI_BMSURVEY_MANAGEGROUP_DESC', '管理メニューを利用できるグループを設定します');
define('_MI_BMSURVEY_MGPSTATUS', '管理グループの権限');
define('_MI_BMSURVEY_MGPSTATUS_DESC', '管理グループによる編集・アクティベート・終了を許可します');
define('_MI_BMSURVEY_BLOCKLIST', 'ブロックリスト数');
define('_MI_BMSURVEY_BLOCKLIST_DESC', 'ブロック中に表示するアンケートの数を設定します');
define('_MI_BMSURVEY_ADDINFO', '回答に付加情報を付加');
define('_MI_BMSURVEY_ADDINFO_DESC', '回答に付加情報を含めてメール送信します');
define('_MI_BMSURVEY_ADDUSAGE', '質問に使い方を付加');
define('_MI_BMSURVEY_ADDUSAGE_DESC', '質問メールに使い方情報を含めてメール送信します');
define('_MI_BMSURVEY_ONERESPONSE', '回答を1回に限定');
define('_MI_BMSURVEY_ONERESPONSE_DESC', '１つの質問メールに対し１回だけ回答できるようにします');
define('_MI_BMSURVEY_RESETRADIOBUTTON', 'ラジオボタンの選択解除');
define('_MI_BMSURVEY_RESETRADIOBUTTON_DESC', 'ラジオボタンを選択解除できるようにします');
define('_MI_BMSURVEY_RESULTRANK', '結果表示画面におけるレート表示方法');
define('_MI_BMSURVEY_RESULTRANK_DESC', '平均グラフかカウント表示かを選択します');
define('_MI_BMSURVEY_UNSETGROUP', '設定除外グループ');
define('_MI_BMSURVEY_UNSETGROUP_DESC', '|で区切って複数指定可能');
define('_MI_BMSURVEY_GROBALGROUP', '相互コピー可能対象外グループ');
define('_MI_BMSURVEY_GROBALGROUP_DESC', '|で区切ってgidを複数指定可能');
define('_MI_BMSURVEY_SUBMITJUMPURI', '回答後ジャンプ先URI');
define('_MI_BMSURVEY_SUBMITJUMPURI_DESC', 'アンケート回答後に統一したジャンプ先を指定したい場合に設定します');
define('_MI_BMSURVEY_INVALIDJUMPURI', '無効ジャンプ先URI');
define('_MI_BMSURVEY_INVALIDJUMPURI_DESC', '無効なフォームをリクエストした場合のジャンプ先を指定します');
define('_MI_SHOW_PUBLIC_TO_OTHERGROUP','所属グループ以外への表示');
define('_MI_SHOW_PUBLIC_TO_OTHERGROUP_DESC','公開の場合自分の所属するグループ以外にもリスト表示する');
}
?>