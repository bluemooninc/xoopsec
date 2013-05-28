<?php
// $Id: main.php,v 1.1.1.1 2005/08/10 12:14:04 yoshis Exp $
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


if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'BMSURVEY_MB_LOADED' ) ) {

define( 'BMSURVEY_MB_LOADED' , 1 ) ;

define('_MB_ORDER', '並び順');
define('_MB_TILDE', 'から');
define('_MB_NUMBERSTRING', '件');
define('_MB_ALL', '全');
define('_MB_GO_UP', '上へ');
define('_MB_GO_DOWN', '下へ');
define('_MB_FILTER', '絞り込条件');
define('_MB_FILTER_ON', '絞り込む');
define('_MB_FILTER_OFF', '絞込条件をクリア');
define('_MB_STATUS_EDIT',    0x00);
define('_MB_STATUS_ACTIVE',  0x01);
define('_MB_STATUS_DONE',    0x02);
define('_MB_STATUS_DELETED', 0x04);
define('_MB_STATUS_TEST',    0x08);
define('_MB_ORDER_NEW', '新着順');
define('_MB_LIST_CHECKED', '済');
define('_MD_BMSURVEY_DETAIL', '詳細');
define('_MB_From_Option','差出人アドレス');
define('_MD_FROM_OPTION','回答結果を送信する時の差出人アドレス（アンケートのアドレスはモジュール管理の一般設定で設定します）');
define('_MD_FROM_OPTION_0','アンケートのアドレス');
define('_MD_FROM_OPTION_1','登録ユーザのアドレス');
define('_MD_FROM_OPTION_2',"アンケート中の'email'欄");
define('_MB_Default_Response','回答の初期値');
define('_MD_FROM_DEFRES',"入力初期値のレスポンスID（初期値不要の場合は空欄にします）");
define('_MB_LIST_UNAME', '作成者');
define('_MB_LIST_DATE', '登録日付');
define('_MD_BMSURVEY_THANKS_ENTRY', 'アンケートへの記入ありがとうございました。');
define('_MD_BMSURVEY_CAN_WRITE_USER_ONLY', 'ゲストユーザはアンケートを編集することはできません。');
define('_MD_BMSURVEY_YOU_DONT_HAVE_A_PERMISSION', 'この機能を利用する権限がありません。');
define('_MD_ASTERISK_REQUIRED', 'アスタリスク（<font color="#FF0000">＊</font>）付の項目は入力必須項目です。');
define('_MD_MAIL_TITLE', '入力アンケート：');
define('_MD_DENYRESULT','この投稿を無効にする');
define('_MD_DENYRESULTSURE','この投稿を無効にします。よろしいですか？');
define('_MD_DENYRESULTDONE','この投稿を無効にしました。');
define('_MD_DEFAULTRESULT','この投稿を入力初期値にセットする');
define('_MD_EDITRESULT','この投稿を編集する');
define('_MD_DEFAULTRESULTDONE','回答の初期値をセットしました。');
define('_MD_RESPONDENT','投稿者名');
define('_MD_QUESTION_OTHER','その他');
define('_MD_BMSURVEY_FORMATERR', ' は正しく入力されていません');
define('_MD_BMSURVEY_DIGITERR', ' は半角で数字を入力してください');
define('_MD_BMSURVEY_MAXOVER', 'は、%u項目以上チェックできません');
define('_MD_BMSURVEY_CHECKANY', '（複数選択可）');
define('_MD_BMSURVEY_CHECKLIMIT', '（%uつまで選択可）');
define('_MD_BMSURVEY_CHECKRESET', '選択解除');
define('_MD_SUBMIT_FORM', '送信');
define('_MD_NEXT_PAGE', '次ページ');
define('_MD_BMSURVEY_COPY_TITLE_PREFIX', 'コピー %s〜 ');
define("_MD_FORM_LIST","公開中一覧");

define('_MD_POP_KEY_M','メンバー');
define('_MD_POP_KEY_U','使い方');
define('_MD_POP_KEY_Q','アンケート');
define('_MD_POP_KEY_ERR','POP-Key Error');
define('_MD_POP_CMD_NEW','新規登録');
define('_MD_POP_CMD_INP','回答');
define('_MD_POP_CMD_DEL','削除');
define('_MD_POP_MNEW_ENTRY','ログイン名 %s でユーザ登録しました。');
define('_MD_POP_MNEW_AREADY','そのログイン名は既に登録されています。別の名前で登録してください。');
define('_MD_POP_QINP_HEADER','返信メールを作成し、[]または()の中に入力して送信下さい。
1行に複数ある[]()はチェック項目です。[]は複数、()は1つだけ任意の1文字を入力ください。
1行に1つだけの[]はテキスト入力項目です。文字列を入力下さい。
----

');
define('_MD_POP_QINP_FAILEDLOGIN','ユーザ名か認証コードが違います。');
define('_MD_POP_QINP_SUCCEEDED','%s さんの回答を登録しました。');
define('_MD_POP_QINP_DELETEIT','このアンケートは既に回答済みです。このメールに返信すると消去できます。');
define('_MD_POP_QDEL_SUCCEEDED','%s さんの回答を削除しました。');

define('_AM_BMSURVEY_MANAGE','アンケート管理');
define('_AM_BMSURVEY_SEEARESULT','個別の回答を見る');
define('_AM_BMSURVEY_COPYQUESTION','アンケートから質問をコピー');
define('_AM_BMSURVEY_SELECTSTATUS','状態を選択');
define('_AM_BMSURVEY_RATECOUNT','カウント表示');
define('_AM_BMSURVEY_NORESPONSE','無回答');
define('_AM_BMSURVEY_TOTAL','合計');
define('_AM_BMSURVEY_QUESTIONNUMBER','設問<BR>番号');
define('_AM_BMSURVEY_ARCHIVED','保管中');
define('_AM_BMSURVEY_TEST','テスト');
define('_AM_BMSURVEY_EXPIRATION','終了');
define('_AM_BMSURVEY_ACTIVE','アクティブ');
define('_AM_BMSURVEY_EDIT','編集');
define('_AM_BMSURVEY_PURGE','破棄');
define('_AM_BMSURVEY_VALUE','選択肢');
define('_AM_BMSURVEY_COUNT','回答数');
define('_AM_BMSURVEY_NA','無回答');

//
// From /locale/messages.po
//
define("_MB_Unable_to_open_include_file","設定ファイルが開けませんでした。INIファイルの設定を確認してください。中断します。");
define("_MB_Service_Unavailable","サービスを利用できません");
define("_MB_Your_progress_has_been_saved","あなたの入力中のデータを保存しました。 あなたはいつでも、戻って、この調査を終了できます。そうするには、以下のリンクをブックマークに追加してください。また、再開するにはログインする必要があります。");
define("_MB_Resume_form","アンケートの再開");
define("_MB_Invalid_argument","不正な引数です");
define("_MB_Error_opening_form","アンケートが開けませんでした");
define("_MB_Error_opening_forms","１つ以上のアンケートは開けません。現在の編集を「設定終了」で閉じて下さい！");
define("_MB_No_responses_found","No responses found.");
define("_MB_TOTAL","合計");
define("_MB_No_questions_found","設問が1つもありません");
define("_MB_Page_d_of_d","ページ %d / %d");
define("_MB_Yes","はい");
define("_MB_No","いいえ");
define("_MB_1","1");
define("_MB_2","2");
define("_MB_3","3");
define("_MB_4","4");
define("_MB_5","5");
define("_MB_NA","無回答");
define("_MB_AVERAGE","平均値");
define("_MB_SUBJECT","選択肢");
define("_MB_MAX","最大値");
define("_MB_MIN","最小値");
define("_MB_MEDIAN","中央値");
define("_MB_SUM","合計");
define("_MB_Page","ページ");
define("_MB_of","の");
define("_MB_Error_system_table_corrupt","不正なシステムテーブルです");
define("_MB_Table","テーブル");
define("_MB_Report_for","レポート");
define("_MB_ID","ID");
define("_MB_Num","#");
define("_MB_Req_d","必須");
define("_MB_Public","パブリック");
define("_MB_Content","コンテンツ");
define("_MB_Previous","前へ");
define("_MB_Next","次へ");
define("_MB_Navigate_Individual_Respondent_Submissions","調査結果の一件別表示");
define("_MB_Error_cross_analyzing_Question_not_valid_type","質問は有効な形ではありません");
define("_MB_Cross_analysis_on_QID","クロス分析 QID:");
define("_MB_Sorry_please_fill_out_the_name","実行前に必須項目を埋めてください。");
define("_MB_Sorry_name_already_in_use","すでにその名前は使われています。他の名前を使ってください。");
define("_MB_Sorry_that_name_is_already_in_use","すでにその名前は使われています。");
define("_MB_Warning_error_encountered","エラーが発生しました。");
define("_MB_Please_enter_text","質問を作成するにあたり必要な情報を入力してください");
define("_MB_Sorry_you_must_select_a_type_for_this_question","この設問事項に対する方を選択しなければなりません。");
define("_MB_New_Field","新しいフィールド");
define("_MB_enter_error","の指定に誤りがあります"); //要望 #1061対応 CNC@Tei 2012/06/13 Add
define("_MB_Sorry_you_cannot_change_between_those_types_of_question","ご指定のアンケートタイプには変更できません。新しい設問を作成してください。");
define("_MB_Sorry_you_need_at_least_one_answer_option_for_this_question_type","すみません、あなたは少なくとも1つの答えオプションをこの質問タイプに必要とします。");
define("_MB_Error_cross_tabulating","クロスタブ・エラーです。");
define("_MB_Error_same_question","行と列の選択に同じ質問を選択していないか確認してください。");
define("_MB_Error_column_and_row","行と列の両方を選択しているか確認してください。");
define("_MB_Error_analyse_and_tabulate","解析とクロスタブを同時に実行することは出来ません。");
define("_MB_Error_processing_form_Security_violation","エラー：セキュリティ違反");
define("_MB_Unable_to_execute_query_for_access","アクセス用のクエリを実行できません。");
define("_MB_Unable_to_execute_query_respondents","回答者用のクエリを実行できません。");
define("_MB_Unauthorized","未認証");
define("_MB_Incorrect_User_ID_or_Password","ユーザーIDとパスワードが間違っていまるか、アカウントが使用不可か期限切れになっています");
define("_MB_Your_account_has_been_disabled","あなたのアカウントが無効にされたか、またはあなたは既にこの調査を終了しました。");
define("_MB_Unable_to_load_ACL","ACLをロードすることができません");
define("_MB_Management_Interface","管理画面");
define("_MB_This_account_does_not_have_permission","権限が許可されておりません。");
define("_MB_Go_back_to_Management_Interface","管理画面に戻る");
define("_MB_Submit","送信");
define("_MB_Rank","ランク");
define("_MB_Response","レスポンス");
define("_MB_Average_rank","平均ランク");
define("_MB_You_are_missing_the_following_required_questions","以下の項目が記入されていません。");
define("_MB_Form_Design_Completed","アンケートデザイン完成");
define("_MB_You_have_completed_this_form_design","アンケートデザインが完成しました");
define("_MB_To_insert_this_form_into_your_web_page","このアンケートをPHPソースに挿入するには、下のテキストをコピーし貼り付けてください。");
define("_MB_Once_activated_you_can_also_access_the_form_directly_from_the_following_URL","一度アクティブにした後は、以下のURLからアンケートに直接アクセスできます。");
define("_MB_You_must_activate_this_form","アンケートを使用するにはステータスを「アクティブ」にする必要があります。ステータスの変更は“アンケートの状態を変更する”ページより行って下さい。「アクティブ」にした後は一切の変更が不可能になります。");
define("_MB_The_information_on_this_tab_applies_to_the_whole_form","このタブで設定した情報はアンケート全体に反映されます。このタブを設定した後、各タブで個々設定を行ってください。");
define("_MB_Name","名前");
define("_MB_Required","必須項目");
define("_MB_Form_filename","ファイルネーム");
define("_MB_This_is_used_for_all_further_access_to_this_form","このアンケートのファイルネーム。");
define("_MB_no_spaces","スペース使用不可");
define("_MB_alpha_numeric_only","半角英数字のみ");
define("_MB_Owner","編集権限");
define("_MB_User_and_Group_that_owns_this_form","このアンケートの入力結果を閲覧する事ができるグループを選択");
define("_MB_Respondents","回答グループ");
define("_MB_User_and_Group_that_input_this_form","このアンケートに回答できるグループを選択");
define("_MB_Title","タイトル");
define("_MB_Title_of_this_form","アンケートのタイトル");
define("_MB_This_appears_at","アンケートページのトップに常に表示されます");
define("_MB_free_form_including_spaces","空白を含む文字列可");
define("_MB_Subtitle","サブタイトル");
define("_MB_Subtitle_of_this_form","アンケートのサブタイトル");
define("_MB_Appears_below_the_title","タイトルの下に表示されます");
define("_MB_Additional_Info","付加情報");
define("_MB_Text_to_be_displayed_on_this_form_before_any_fields","入力項目の前に表示される文章（説明文章等HTML可）");
define("_MB_Confirmation_Page","確認ページ");
define("_MB_URL","(URL)");
define("_MB_The_URL_to_which_a_user_is_redirected_after_completing_this_form","このアンケートを完了した後にリダイレクトさせるURLを設定");
define("_MB_OR","もしくは");
define("_MB_heading_text","ヘッダ文字列");
define("_MB_body_text","本文");
define("_MB_Heading_in_bold","アンケート完成後に表示される「確認」ページ用です。これは太字で表示されます。");
define("_MB_URL_if_present","URLを記入した場合は、確認のテキスト文字の上に表示されます。");
define("_MB_Email","電子メール");
define("_MB_Sends_a_copy","回答結果を送信するメールアドレス（空欄の場合は送信無し）");
define("_MB_Theme","テーマ");
define("_MB_Select_a_theme","このアンケートで使用するテーマ（CSS）を選択してください");
define("_MB_Options","オプション");
define("_MB_Allow_to_save","回答者への保存・再開の許可(ログインが必要)");
define("_MB_Allow_to_forward","回答者へアンケート区切りを移動する許可");
define("_MB_Change_the_order","リストの番号を変更することにより、質問の順番を並び替えることができます。");
define("_MB_Section_Break","-----空きセクション-----");
define("_MB_Remove","削除");
define("_MB_Edit","編集");
define("_MB_Add_Section_Break","空きセクションの追加");
define("_MB_This_is_a_preview","アンケートのプレビューです。変更のない場合は設定終了タブより編集を終了し、管理画面に戻ってください。");
define("_MB_Section","セクション");
define("_MB_Previous_Page","前のページ");
define("_MB_SaveAsDefault","入力値を回答例として保存");
define("_MB_Save","保存する");
define("_MB_Next_Page","次のページ");
define("_MB_Submit_Form","投稿する");
define("_MB_Edit_this_field","このフィールドを編集するか、編集したいフィールドの番号をクリックしてください：");
define("_MB_Field","フィールド");
define("_MB_Field_Name","フィールドネーム");
define("_MB_Type","タイプ");
define("_MB_Length","入力文字数");
define("_MB_Precision","入力文字制限");
define("_MB_Enter_the_possible_answers","選択肢の最後に自由回答欄を作成するには %s を入れます。");
define("_MB_Add_another_answer_line","選択項目の追加");
define("_MB_Please_select_a_group","グループを選んでください");
define("_MB_Private","プライベート");
define("_MB_Form_Access","アンケートアクセス");
define("_MB_This_lets_you_control","アンケートへのアクセスの設定を行えます。「パブリック」は誰でもアクセスが可能です。「プライベート」は設定したグループしかアクセスできません。");
define("_MB_Note","ノート");
define("_MB_You_must_use","プライベートアンケートでは %s を使用しなければなりません。");
define("_MB_Group","グループ");
define("_MB_Max_Responses","最大レスポンス");
define("_MB_Save_Restore","保存／再開");
define("_MB_Back_Forward","戻る／進む");
define("_MB_Add","追加");
define("_MB_Make_Public","パブリックに変更");
define("_MB_Make_Private","プライベートに変更");
define("_MB_to_access_this_group","このグループにアクセスする");
define("_MB_Cannot_delete_account","アカウントを削除できません");
define("_MB_uid_are_required.","ユーザーネーム、パスワード、およびグループが必要です");
define("_MB_Error_adding_account","アカウント追加エラー");
define("_MB_Cannot_change_account_data","アカウントデータを変更できません");
define("_MB_Account_not_found","アカウントが見つかりませんでした");
define("_MB_Designer_Account_Administration","デザイナーアカウント管理");
define("_MB_uid","ユーザーネーム");
define("_MB_Password","パスワード");
define("_MB_First_Name","名");
define("_MB_Last_Name","姓");
define("_MB_Expiration","終了");
define("_MB_year","年");
define("_MB_month","月");
define("_MB_day","日");
define("_MB_count","回答数");
define("_MB_Disabled","使用不可");
define("_MB_Update","アップデート");
define("_MB_Cancel","キャンセル");
define("_MB_Delete","削除");
define("_MB_Design_Forms","デザインアンケート");
define("_MB_Change_Form_Status","状態の変更");
define("_MB_Activate_End","活性化／終了");
define("_MB_Export_Form_Data","アンケートデータをエクスポート");
define("_MB_Group_Editor","グループエディタ");
define("_MB_may_edit","指定した場合、グループでの編集が可能になります。");
define("_MB_Administer_Group_Members","グループメンバーを管理");
define("_MB_Administer_Group_Respondents","グループ回答者を管理");
define("_MB_Respondent_Account_Administration","回答者アカウントの管理");
define("_MB_to_access_this_form","このアンケートへのアクセス");
define("_MB_Error_copying_form","アンケートのコピーエラー");
define("_MB_Copy_Form","コピーアンケート");
define("_MB_Choose_a_form","コピーを作りたいアンケートを選んでください。コピーしたアンケートは編集可能です。使用前には動作確認を行ってください。");
define("_MB_Status","状態");
define("_MB_Archived","保管中");
define("_MB_Ended","停止中");
define("_MB_Active","公開中");
define("_MB_Testing","テスト中");
define("_MB_Editing","編集中");
define("_MB_You_are_attempting","解析とクロスタブ表示を一度に実行する事はできません。");
define("_MB_Only_superusers_allowed","スーパーユーザーのみ利用可能です。");
define("_MB_No_form_specified","アンケートが指定されていません");
define("_MB_Manage_Web_Form_Designer_Accounts","アンケートデザイナーの管理");
define("_MB_Click_on_a_uid_to_edit","ユーザ名をクリックして編集するか、以下に新しいユーザー追加します。");
define("_MB_disabled","使用不可");
define("_MB_Add_a_new_Designer","新しいデザイナーを追加してください");
define("_MB_Bulk_Upload_Designers","アカウントとグループ情報のアップロード");
define("_MB_Invalid_form_ID","無効のアンケートIDです");
define("_MB_DBF_download_not_yet_implemented","DBFダウンロードは未開発です。");
define("_MB_The_PHP_dBase_Extension_is_not_installed","dBase拡張はインストールされてません");
define("_MB_Edit_a_Form","アンケート編集");
define("_MB_Pick_Form_to_Edit","編集したいアンケートを選択");
define("_MB_Export_Data","エクスポートデータ");
define("_MB_Format","フォーマット");
define("_MB_CSV","CSV");
define("_MB_download","ダウンロード");
define("_MB_DBF","DBF");
define("_MB_HTML","HTML");
define("_MB_Testing_Form","テストアンケート…");
define("_MB_SID","SID");
define("_MB_Form_exported_as","アンケートのエクスポート：");
define("_MB_Error_exporting_form_as:","アンケートのエクスポートに失敗しました。");
define("_MB_Error_adding_group","グループの追加エラー");
define("_MB_Error_deleting_group","グループの削除エラー");
define("_MB_Group_is_not_empty","グループは空ではありません。");
define("_MB_Manage_Groups","グループ管理");
define("_MB_Description","説明");
define("_MB_Members","メンバー");
define("_MB_Users_guide_not_found","ユーザーズ・ガイドは見つかりませんでした");
define("_MB_Log_back_in","ログ・バック");
define("_MB_Superuser","スーパーユーザー");
define("_MB_Choose_a_function","機能を選んでください");
define("_MB_Create_a_New_Form","新しいアンケートを作る");
define("_MB_Edit_an_Existing_Form","アンケートを編集する");
define("_MB_Test_a_Form","アンケートをテストする");
define("_MB_Copy_an_Existing_Form","既存のアンケートをコピーする");
define("_MB_Change_the_Status_of_a_Form","アンケートの状態を変更する");
define("_MB_active_end_delete","(アクティブ/終了/保管)");
define("_MB_Change_Access_To_a_Form","アンケートのアクセス権を変更する");
define("_MB_Limit_Respondents","回答者制限");
define("_MB_View_Results_from_a_Form","アンケートの結果を見る");
define("_MB_Cross_Tabulate_Form_Results","アンケート結果のクロスタブ表示");
define("_MB_View_a_Form_Report","アンケートの内容をみる");
define("_MB_Export_Data_to_CSV","CSVデータを見る");
define("_MB_Change_Your_Password","あなたのパスワードを変更してください");
define("_MB_Manage_Designer_Accounts","デザイナーアカウントの管理");
define("_MB_Manage_Respondent_Accounts","回答者アカウントの管理");
define("_MB_View_the_list_of_things_still_to_do","まだしていることのリストを見てください。");
define("_MB_development_goals","（開発のゴール）");
define("_MB_View_the_User_Administrator_Guide","ユーザー&管理者ガイドを見る");
define("_MB_Log_out","ログアウト");
define("_MB_SIDS","SIDS");
define("_MB_Error!","エラー！");
define("_MB_You_need_to_select_at_least_two_forms!","最低2つのアンケートを選んでください！");
define("_MB_Merge_Form_Results","アンケート結果のマージ");
define("_MB_Pick_Forms_to_Merge","マージするために、アンケートを選んでください");
define("_MB_List_of_Forms","アンケートのリスト");
define("_MB_Forms_to_Merge","マージするアンケート");
define("_MB_Change_Password","パスワードの変更");
define("_MB_Your_password_has_been_successfully_changed","あなたのパスワードは変更されました");
define("_MB_Password_not_set","パスワードはセットされません。今までのパスワードを確認下さい。");
define("_MB_New_passwords_do_not_match_or_are_blank","新しいパスワードは正しくないか空白です。");
define("_MB_Old_Password","ふるいのん");
define("_MB_New_Password","あたらしいのん");
define("_MB_Confirm_New_Password","もっかい");
define("_MB_Purge_Forms","アンケートの消去");
define("_MB_This_page_is_not_directly","このページは危険なのでメインメニューから直接呼び出すことは出来ません。ここで消去した場合、調査結果を含めデータベースから完全に消去されます。確信の無い場合はこの画面では何も操作しないでください。消去ボタンを押した場合、再確認無く実行され復旧の手段はありません。");
define("_MB_Qs","# 質問の");
define("_MB_Clear_Checkboxes","チェックボックスをクリア");
define("_MB_README_not_found","READMEが見つかりません");
define("_MB_Go_back_to_Report_Menu","リポートメニューに戻って下さい");
define("_MB_View_Form_Report","アンケートの内容を見る");
define("_MB_Pick_Form_to_View","内容を見たいアンケートを選択");
define("_MB_Add_a_new_Respondent","新しい回答者を追加してください");
define("_MB_Bulk_Upload_Respondents","新しい回答者を追加してください");
define("_MB_Cross_Tabulation","クロスタブ");
define("_MB_Test_Form","テストアンケート");
define("_MB_Reset","リセット");
define("_MB_Cross_Tabulate","クロス・タブ");
define("_MB_View_Form_Results","アンケート結果を見る");
define("_MB_Pick_Form_to_Cross_Tabulate","クロスタブに表示するアンケートを選択");
define("_MB_Respondent","回答者");
define("_MB_Resp","レスポンス");
define("_MB_Can_not_set_form_status","アンケートステータスを設定できません。");
define("_MB_Form_Status","アンケートステータス");
define("_MB_Test_transitions","<b>「テスト」</b>…テストモードです。アンケートのテストや結果の表示が可能です。テストモード時はアンケートを編集することができません。");
define("_MB_Activate_transitions","<b>「アクティブ」</b>…アクティブモードです。このモード実行中はアンケートが実際に稼動しています。テストモード時のアンケート結果は反映されません。アクティブモード実行後、アンケートの編集は一切できません。");
define("_MB_End_transitions","<b>「終了」</b>…稼動中のアンケートを終了します。このモード実行後はアンケートを取ることができません。結果は管理メニューから表示可能です。");
define("_MB_Archive_removes","<b>「保管」</b>…アンケートを削除します。データはデータベースに残りますが、以後一切の操作が不可能になります。また、アーカイブされたアンケートの結果は見ることができません。");
define("_MB_Test","テスト");
define("_MB_Activate","公開");
define("_MB_End","停止");
define("_MB_Archive","保管");
define("_MB_No_tabs_defined_Please_check_your_INI_settings","無効なタブ。INI設定をチェックしてください");
define("_MB_Help","ヘルプ");
define("_MB_General","アンケート設定");
define("_MB_Questions","質問作成");
define("_MB_Order","質問順序");
define("_MB_Preview","プレビュー");
define("_MB_Finish","設定終了");
define("_MB_Click_cancel_to_cancel","このアンケートをキャンセルする場合は「Cancel」をクリックしてください。隣のタブに進む場合は「Continue」をクリックしてください。");
define("_MB_The_form_title_and_other","アンケートタイトルおよび他の一般情報のフィールドは、<b>「アンケート設定」</b>タブにあります。 <b>「質問作成」</b>タブより質問の追加、修正をすることができます。 <b>「質問順序」</b>タブからは質問の編集、削除を行えます。<b>「プレビュー」</b>タブは作成したアンケートのプレビューを行えます。変更のない場合は<b>「設定終了」</b>タブより編集を終了し、管理画面に戻ってください。");
define("_MB_Click_here_to_open_the_Help_window","ヘルプウィンドウを開く");
define("_MB_View_Results","結果を見る");
define("_MB_Pick_Form_to_Test","テストするアンケートを選択");
define("_MB_Export","エクスポート");
define("_MB_Results","結果");
define("_MB_Todo_list_not_found","Todoリストは見つかりませんでした");
define("_MB_An_error_Rows_that_failed_are_listed_below","以下リストのアップロードエラーです。");
define("_MB_An_error_Please_check_the_format_of_your_text_file","アップロード中にエラーが発生しました。テキストファイルのフォーマットを確認してください。");
define("_MB_An_error_Please_complete_all_form_fields","アップロード中にエラーが発生しました。全てのアンケートフィールドに記入ください。");
define("_MB_Upload_Account_Information","アカウント情報をアップロードしました。");
define("_MB_All_fields_are_required","マークの質問は必須項目です。");
define("_MB_File_Type","ファイルタイプ");
define("_MB_Tab_Delimited","タブ区切り");
define("_MB_File_to_upload","アップロードファイル");
define("_MB_Thank_You_For_Completing_This_Form","ご記入ありがとうございました。");
define("_MB_Please_do_not_use_the_back_button","ブラウザの戻るボタンを押さないで下さい");
define("_MB_Unable_to_find_the_phpESP_%s_directory_\t\t\tPlease_check_%s_to_ensure_that_all_paths_are_set_correctly","");
define("_MB_Gettext_Test_Failed","GetTextのエラーです");
define("_MB_Form_not_specified","フォームの指定が無効です");
define("_MB_Form_not_published","注意：このアンケートはまだ公開されていません");
define("_MB_Form_expired","受付を終了しました");
define("_MB_Form_is_not_active","注意：このアンケートはまだ公開されていません");

define("_MB_Sorry_the_account_request_form_is_disabled","アカウント処理は現在禁止されています。");
define("_MB_Please_complete_all_required_fields","全ての必須入力の項目に回答下さい。");
define("_MB_Passwords_do_not_match","パスワードが違います");
define("_MB_Request_failed,_please_choose_a_different_uid","リクエスト失敗。違うユーザーを選択下さい。");
define("_MB_Your_account_has_been_created","あなたのアカウントは作成されました。");
define("_MB_Account_Request_Form","アカウント要求アンケート");
define("_MB_Please_complete_the_following","以下の用紙に記入して、アカウントを要求してください。 %s でマークされた項目は必須です。");
define("_MB_Email_Address","電子メールアドレス");
define("_MB_Confirm_Password","パスワードの再確認");


define('BMSURVEY_INDEX_PAGETITLE', 'アンケート一覧');
define('_MB_LIST_TITLE', 'タイトル');
define('_MB_LIST_SUBTITLE', 'サブタイトル');
define('_MB_LIST_NAME', 'アンケート名');
define('_MB_LIST_OWNER', '作成者');
define('_MB_LIST_UPDATE', '更新日時');
define('_MB_FORM_PUBLISHED', '公開開始日時');
define('_MB_FORM_EXPIRED', '公開終了日時');
define('_MB_FORM_PUBLISHED_DESC', '(記述例：2012-06-03 09:30)');
define('_MB_FORM_EXPIRED_DESC', '(記述例：2012-07-04 12:00)');
define('_MB_LIST_SUBMITTED', '回答済み');
define('_MB_LIST_SUBMITTED_DESC', 'このアンケートはすでに回答しています。');
define('_MB_LIST_COL_DATA', 'アンケート情報');
define('_MB_LIST_COL_RESULTS', '結果');
define('_MB_LIST_COL_RESULTS_RESPONDENTS', '回答者数');
define('_MB_LIST_COL_RESULTS_ANALYZE', '分析');
define('_MB_LIST_COL_RESULTS_SPREADSHEET', '集計表');
define('_MB_LIST_COL_RESULTS_CROSS', 'クロス集計・クロス分析');
define('_MB_LIST_COL_RESULTS_DOWNLOAD', 'ダウンロード');
define('_MB_LIST_COL_CONTROL', '管理');
define('_MB_LIST_COL_CONTROL_MODIFY', '変更');
define('_MB_LIST_COL_CONTROL_STATUS', '状態の管理');
define('_MB_LIST_COL_CONTROL_ACCESS', '公開');
define('_MB_LIST_COL_CONTROL_ACCESS_PUBLIC', '一般公開');
define('_MB_LIST_COL_CONTROL_ACCESS_LIMITED', '限定公開');
define('_MB_LIST_COL_CONTROL_ACCESS_2PUBLIC', '一般公開');
define('_MB_LIST_COL_CONTROL_ACCESS_2LIMITED', '限定公開');
define('_MB_LIST_COL_CONTROL_ACCESS_SETPERM', 'アクセス権設定');
define('_MB_LIST_COL_CONTROL_COPY', 'コピー');
define('_MB_LIST_COL_CONTROL_EDIT', '編集');
define('BMSURVEY_TABS_QUESTIONS_QUESTION_CONTENT', '質問文');
define('BMSURVEY_TABS_QUESTIONS_FIELD_NUM', 'フィールド番号');
define('BMSURVEY_TABS_QUESTIONS_FIELD_CONTROL', 'フィールド操作');
define('BMSURVEY_TABS_QUESTIONS_QUESTION_INFOS', '質問の設定');
define('BMSURVEY_TABS_QUESTIONS_CHOICES_INFOS', '選択項目の編集');
define('BMSURVEY_TABS_QUESTIONS_CHOICES_DESC', '選択肢の最後に自由回答欄を作成するには !other を入れます');
define('BMSURVEY_TABS_ORDER_COL_NAME_TYPE', 'フィールド名・フィールドタイプ');
define('BMSURVEY_TABS_ORDER_COL_MOVE', '順序変更');
define('BMSURVEY_TABS_ORDER_COL_EDIT', '編集');
define('BMSURVEY_TABS_ORDER_COL_REMOVE', '削除');

define('BMSURVEY_QTYPE_1','はい/いいえ');
define('BMSURVEY_QTYPE_2','テキスト・ボックス');
define('BMSURVEY_QTYPE_3','テキスト・エリア');
define('BMSURVEY_QTYPE_4','単一項目の選択');
define('BMSURVEY_QTYPE_5','複数項目の選択');
define('BMSURVEY_QTYPE_6','ドロップダウン・リストから１つ選択');
define('BMSURVEY_QTYPE_7','Rating');
define('BMSURVEY_QTYPE_8','５段階評価から１つ選択');
define('BMSURVEY_QTYPE_9','日付入力');
define('BMSURVEY_QTYPE_10','数字入力');
define('BMSURVEY_QTYPE_40','添付ファイル');
define('BMSURVEY_QTYPE_99','改ページ');
define('BMSURVEY_QTYPE_100','見出しタイトル');

}

?>