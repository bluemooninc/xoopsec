<?php
/** \file OAuth2TokenException.php
 *
 * \brief Token サーバ例外処理クラスを定義しています.
 */

/**
 * \class OAuth2TokenExceptionクラス
 *
 * \brief Token サーバ例外処理クラスです.
 *
 * Token サーバ例外処理クラスです.
 */
class OAuth2TokenException extends Exception
{
    /**
     * \brief エラー概要
     */
    public $error = null;

    /**
     * \brief エラー詳細
     */
    public $error_desc = null;

    /**
     * \brief インスタンス生成
     *
     * @param	$error	エラー概要
     * @param	$error_desc	エラー詳細
     * @param	$code
     */
    public function __construct( $error, $error_desc = "", $code = 0 )
    {
        parent::__construct( $error, $code );

        $this->error      = $error;
        $this->error_desc = $error_desc;
    }

    /**
     * \brief リダイレクトURIエラー確認メソッド
     *
     * @return	true or false
     */
    public function invalidRedirectUri()
    {
        if( preg_match( "/invalid_redirect_uri/", $this->error ) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * \brief クライアント認証URIエラー確認メソッド
     *
     * @return	true or false
     */
    public function invalidClient()
    {
        if( preg_match( "/invalid_client/", $this->error ) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * \brief scopeエラー確認メソッド
     *
     * @return	true or false
     */
    public function invalidScope()
    {
        if( preg_match( "/invalid_scope/", $this->error ) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * \brief Refresh Token有効期限切れ確認メソッド
     *
     * @return	true or false
     */
    public function invalidGrant()
    {
        if( preg_match( "/invalid_grant/", $this->error ) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * \brief Access Token有効期限切れ確認メソッド
     *
     * @return	true or false
     */
    public function tokenExpired()
    {
        if( preg_match( "/invalid_token/", $this->error ) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * \brief 無効なToken確認メソッド
     *
     * @return	true or false
     */
    public function invalidToken()
    {
        if( preg_match( "/invalid_token/", $this->error ) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * \brief パラメータ関連エラー確認メソッド
     *
     * @return	true or false
     */
    public function invalidRequest()
    {
        if( preg_match( "/invalid_request/", $this->error ) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * \brief 認可タイプエラー確認メソッド
     *
     * @return	true or false
     */
    public function unsupportedGrantType()
    {
        if( preg_match( "/unsupported_grant_type/", $this->error ) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * \brief HTTPSエラー確認メソッド
     *
     * @return	true or false
     */
    public function accessDenied()
    {
        if( preg_match( "/access_denied/", $this->error ) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * \brief サーバーエラー確認メソッド
     *
     * @return	true or false
     */
    public function serverError()
    {
        if( preg_match( "/server_error/", $this->error ) ) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString()
    {
        $str = __CLASS__ . " (" . $this->code . ") : " . $this->message . ", ";
        $str .= "error: " . $this->error . ", error_desc: " .$this->error_desc;
    
        return $str;
    }
}

/* vim:ts=4:sw=4:sts=0:tw=0:ft=php:set et: */
