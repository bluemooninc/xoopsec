<?php
// $Id: admin.php,v 1.2 2007/07/24 10:17:04 yoshis Exp $
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
// Permition Check
define('_AM_BMSURVEY_ERROR01', '書き込み権限がありません。');

// Admin Top Menu
define('_AM_PREFERENCES','一般設定');
define('_AM_BMSURVEY_GOMOD','モジュール画面へ');
define('_AM_BMSURVEY_FAQ','FAQ');
define('_AM_BMSURVEY_SUPPORTSITE','サポート・サイト');
// Admin Tag menu
define('_AM_BMSURVEY_MANAGE','アンケート管理');
define('_AM_BMSURVEY_RESPONDENT','回答者の編集');
define('_AM_BMSURVEY_CASTFORM','アンケート送信');
define('_AM_BMSURVEY_CHECKRESPONSE','アンケート受信');
define('_AM_BMSURVEY_RESISTER','登録メール送信');
define('_AM_BMSURVEY_STATUS','ステータス・チェック');
// Document link
define('_AM_BMSURVEY_DOC_UPDATEINFO','アップデート情報');
define('_AM_BMSURVEY_DOC_POPNUPBLOG','PopnupBlogとの連動について');
define('_AM_BMSURVEY_DOC_MAILTO','mailtoオプションとデフォルト入力値の設定について');

//
define('_AM_BMSURVEY_RESPONDENTS','メール回答者一覧');
define('_AM_BMSURVEY_RESPONDENT_USAGE','*印欄はプログラムが使用しますので、入力・設定は不要です。<br>
チケット番号はアンケート送信の度に乱数で更新され古いものは無効となります。');
define('_AM_BMSURVEY_uid','ユーザ名');
define('_AM_BMSURVEY_PASSWORD','チケット番号');
define('_AM_BMSURVEY_FNAME','名');
define('_AM_BMSURVEY_LNAME','姓');
define('_AM_BMSURVEY_EMAIL','メールアドレス');
define('_AM_BMSURVEY_DISABLED','送信停止');
define('_AM_BMSURVEY_FORMID','アンケートID');
define('_AM_BMSURVEY_RESPONSEID','回答ID');
define('_AM_BMSURVEY_CHANGED','更新日付');
define('_AM_BMSURVEY_EXPIRE','利用期限');
define('_AM_BMSURVEY_INVITATION','アンケート回答者へ登録用紙を送信');
define('_AM_BMSURVEY_SUBJECT','件名');
define('_AM_BMSURVEY_SUBJECT_NEW','アンケート回答者登録のご案内');
define('_AM_BMSURVEY_MESSAGE','本文');
define('_AM_BMSURVEY_MESSAGE_NEW','
これからお送りするアンケートに回答頂く為には、ユーザ登録が必要です。
[]の中に入力して返信ください。
----
u:[]任意のユーザ名を入力してください。
f:[]名（ファーストネーム）を入力してください。
l:[]姓（ラストネーム）を入力してください。
s:[]回答頂くアンケート番号です。
d:[]アンケートに回答頂く最終日を設定ください。
');

define('_AM_BMSURVEY_CHOSEFORM','送信するアンケートの選択');
define('_AM_BMSURVEY_SENDQUESTION','アンケートの送信');
define('_AM_BMSURVEY_CONFIRM','回答者の確認');
define('_AM_BMSURVEY_SENDQUESTIONNOW','ここをクリックすると対象者全員にアンケートを送信します');
define('_AM_BMSURVEY_SENDQUESTIONUSAGE','（新しいアンケートを送信するとチケット番号が更新され、古いアンケートは回収不能となります。）
<p>Wgetとスケジューラで以下URLを呼び出せば自動化できます。<p>%s<p>&hide=1をURLに追加指定すると質問文を省略します');
define('_AM_BMSURVEY_CHECKRESPONSENOW','ここをクリックするとアンケートを受信用のメールボックスをチェックします');
define('_AM_BMSURVEY_CHECKRESPONSEUSAGE','Wgetとスケジューラで以下URLを呼び出せば自動化できます。
<p>%s');
define('_AM_BMSURVEY_SEEARESULT','回答を見る');
define('_AM_BMSURVEY_COPYQUESTION','アンケートから質問をコピー');
define('_AM_BMSURVEY_SELECTSTATUS','状態を選択');
define('_AM_BMSURVEY_RATECOUNT','カウント表示');
define('_AM_BMSURVEY_NORESPONSE','無回答');
define('_AM_BMSURVEY_TOTAL','合計');
define('_AM_BMSURVEY_QUESTIONNUMBER','設問<BR>番号');
define('_AM_BMSURVEY_FILEDNAME_DESC','<small><BR>※半角英数</small>');
define('_AM_BMSURVEY_ARCHIVED','保管中');
define('_AM_BMSURVEY_TEST','テスト');
define('_AM_BMSURVEY_EXPIRATION','終了');
define('_AM_BMSURVEY_ACTIVE','アクティブ');
define('_AM_BMSURVEY_EDIT','編集');

?>
