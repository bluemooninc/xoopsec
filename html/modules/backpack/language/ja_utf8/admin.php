<?php
// $Id: admin.php,v 1.2 2005/08/08 07:03:18 yoshis Exp $
define("_AM_TITLE", "バックパック");
define("_AM_BACKUPTITLE","データベース・バックアップ");
define("_AM_MODULEBACKUP","モジュール・バックアップ");
define("_AM_SELECTTABLES","テーブル・バックアップ");
define("_AM_RESTORE","リストア");
define("_AM_OPTIMIZE","最適化");
define("_AM_DETAILSTOBACKUP","バックアップ内容の設定");
define("_AM_SELECTMODULE","モジュールの選択");
define("_AM_COMPRESSION","圧縮方法の設定");
define("_AM_OTHER","その他");
define("_AM_SELECTAFILE","アップロード・ファイルの選択");
define("_AM_DETAILSTORESTORE","リストア内容の設定");
define("_AM_TABLESTRUCTURE","テーブル構造");
define("_AM_TABLEDATA","テーブル・データ");
define("_AM_BACKUP","バックアップ");
define("_AM_RESET","リセット");
define("_AM_RESTORETITLE","リストア (Prefix は自動的に'" . XOOPS_DB_PREFIX . "'に置換されます)");
define("_AM_BACKUPNOTICE","バックアップをクリックすると選択したテーブルがバックアップされダウンロード画面が開きます。");
define("_AM_SELECTTABLE","バックアップしたいテーブルを選択してください。");
define("_AM_CHECKALL","全てを選択");
define("_AM_RETURNTOSTART","最初の画面に戻る");
define("_AM_OPT_WARNING","警告: 最適化中はデータベースにアクセスできなくなります。");
define("_AM_OPT_STARTING","データベース %s の最適化を %s 秒後に開始します。");
define("_AM_BACKPACK_SITE","サポート・サイト");
// After V0.86
define("_AM_RESTORETITLE1","アップロードとリストア");
define("_AM_RESTORETITLE2","%s フォルダにあるファイルのリストア");
define("_AM_SELECTAFILE_DESC",'最大サイズ: %s%s');
define("_AM_UPLOADEDFILENAME","アップロード済みファイル名入力");
define("_AM_UPLOADEDFILENAME_DESC",'&nbsp;事前にアップロードして下さい。ファイルはリストア後自動削除されます。');
// After V0.88
define("_AM_DOWNLOAD_LIST","ダウンロード・リスト");
define("_AM_PURGE_FILES","ダウンロード・ファイルを全て削除");
define("_AM_PURGED_ALLFILES","ダウンロード・ファイルは全て削除されました。");
define("_AM_READY_TO_DOWNLOAD","ダウンロード・ファイルの準備が出来ました。");
// After V0.90
define('_AM_IFNOTRELOAD','ダウンロードが自動的に始まらない場合は<a href="%s">ここ</a>をクリックしてください');
// After V0.97
define('_AM_REPLACEURL','置換元URL(http://は省略)');
define('_AM_REPLACEURL_DESC','\''.XOOPS_URL.'\'に置き換えたいURLを記入します。');

?>