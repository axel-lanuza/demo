<?php
namespace MetzWeb\Instagram;

class Instagram
{
    /**
     * The API base URL.
     */
    const API_URL = 'https://api.instagram.com/v1/';
    /**
     * The API OAuth URL.
     */
    const API_OAUTH_URL = 'https://api.instagram.com/oauth/authorize';
    /**
     * The OAuth token URL.
     */
    const API_OAUTH_TOKEN_URL = 'https://api.instagram.com/oauth/access_token';
    /**
     * The Instagram API Key.
     *
     * @var string
     */
    private $_apikey;
    /**
     * The Instagram OAuth API secret.
     *
     * @var string
     */
    private $_apisecret;
    /**
     * The callback URL.
     *
     * @var string
     */
    private $_callbackurl;
    /**
     * The user access token.
     *
     * @var string
     */
    private $_accesstoken;
    /**
     * Whether a signed header should be used.
     *
     * @var bool
     */
    private $_signedheader = false;
    /**
     * Available scopes.
     *
     * @var string[]
     */
    private $_scopes = array('basic', 'likes', 'comments', 'relationships');
    /**
     * Available actions.
     *
     * @var string[]
     */
    private $_actions = array('follow', 'unfollow', 'block', 'unblock', 'approve', 'deny');
    /**
     * Rate limit.
     *
     * @var int
     */
  
    /**
     * Default constructor.
     *
     * @param array|string $config Instagram configuration data
     *
     * @return void
     *
     * @throws \MetzWeb\Instagram\InstagramException
     */
    public function __construct($config)
    {
        if (is_array($config)) {
            // if you want to access user data
            $this->setApiKey($config['apiKey']);
            $this->setApiSecret($config['apiSecret']);
            $this->setApiCallback($config['apiCallback']);
        } elseif (is_string($config)) {
            // if you only want to access public data
            $this->setApiKey($config);
        } else {
            throw new InstagramException('Error: __construct() - Configuration data is missing.');
        }
    }
    /**
     * Generates the OAuth login URL.
     *
     * @param string[] $scopes Requesting additional permissions
     *
     * @return string Instagram OAuth login URL
     *
     * @throws \MetzWeb\Instagram\InstagramException
     */
    public function getLoginUrl($scopes = array('basic'))
    {
        if (is_array($scopes) && count(array_intersect($scopes, $this->_scopes)) === count($scopes)) {
            return self::API_OAUTH_URL . '?client_id=' . $this->getApiKey() . '&redirect_uri=' . urlencode($this->getApiCallback()) . '&scope=' . implode('+',
                $scopes) . '&response_type=code';
        }
        throw new InstagramException("Error: getLoginUrl() - The parameter isn't an array or invalid scope permissions used.");
    }
    /**
     * Search for a user.
     *
     * @param string $name Instagram username
     * @param int $limit Limit of returned results
     *
     * @return mixed
     */
    // public function searchUser($name, $limit = 0)
    // {
    //     $params = array();
    //     $params['q'] = $name;
    //     if ($limit > 0) {
    //         $params['count'] = $limit;
    //     }
    //     return $this->_makeCall('users/search', false, $params);
    // }
    /**
     * Get user info.
     *
     * @param int $id Instagram user ID
     *
     * @return mixed
     */
    public function getUser($id = 0)
    {
        $auth = false;
        if ($id === 0 && isset($this->_accesstoken)) {
            $id = 'self';
            $auth = true;
        }
        return $this->_makeCall('users/' . $id, $auth);
    }
  
    public function getUserMedia($id = 'self', $limit = 0)
    {
        $params = array();
        if ($limit > 0) {
            $params['count'] = $limit;
        }
        return $this->_makeCall('users/' . $id . '/media/recent', strlen($this->getAccessToken()), $params);
    }
  
    public function getOAuthToken($code, $token = false)
    {
        $apiData = array(
            'grant_type' => 'authorization_code',
            'client_id' => $this->getApiKey(),
            'client_secret' => $this->getApiSecret(),
            'redirect_uri' => $this->getApiCallback(),
            'code' => $code
        );
        $result = $this->_makeOAuthCall($apiData);
        return !$token ? $result : $result->access_token;
    }
    
    protected function _makeCall($function, $auth = false, $params = null, $method = 'GET')
    {
        if (!$auth) {
            // if the call doesn't requires authentication
            $authMethod = '?client_id=' . $this->getApiKey();
        } else {
            // if the call needs an authenticated user
            if (!isset($this->_accesstoken)) {
                throw new InstagramException("Error: _makeCall() | $function - This method requires an authenticated users access token.");
            }
            $authMethod = '?access_token=' . $this->getAccessToken();
        }
        $paramString = null;
        if (isset($params) && is_array($params)) {
            $paramString = '&' . http_build_query($params);
        }
        $apiCall = self::API_URL . $function . $authMethod . (('GET' === $method) ? $paramString : null);
        // we want JSON
        $headerData = array('Accept: application/json');
        if ($this->_signedheader) {
            $apiCall .= (strstr($apiCall, '?') ? '&' : '?') . 'sig=' . $this->_signHeader($function, $authMethod, $params);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiCall);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, count($params));
                curl_setopt($ch, CURLOPT_POSTFIELDS, ltrim($paramString, '&'));
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        $jsonData = curl_exec($ch);
        list($headerContent, $jsonData) = explode("\r\n\r\n", $jsonData, 2);
        curl_close($ch);
        return json_decode($jsonData);
    }
   
    private function _makeOAuthCall($apiData)
    {
        $apiHost = self::API_OAUTH_TOKEN_URL;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiHost);
        curl_setopt($ch, CURLOPT_POST, count($apiData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        $jsonData = curl_exec($ch);
        if (!$jsonData) {
            throw new InstagramException('Error: _makeOAuthCall() - cURL error: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($jsonData);
    }
   
    public function setAccessToken($data)
    {
        $token = is_object($data) ? $data->access_token : $data;
        $this->_accesstoken = $token;
    }
    /**
     * Access Token Getter.
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->_accesstoken;
    }
    /**
     * API-key Setter
     *
     * @param string $apiKey
     *
     * @return void
     */
    public function setApiKey($apiKey)
    {
        $this->_apikey = $apiKey;
    }
    /**
     * API Key Getter
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->_apikey;
    }
    /**
     * API Secret Setter
     *
     * @param string $apiSecret
     *
     * @return void
     */
    public function setApiSecret($apiSecret)
    {
        $this->_apisecret = $apiSecret;
    }
    /**
     * API Secret Getter.
     *
     * @return string
     */
    public function getApiSecret()
    {
        return $this->_apisecret;
    }
    /**
     * API Callback URL Setter.
     *
     * @param string $apiCallback
     *
     * @return void
     */
    public function setApiCallback($apiCallback)
    {
        $this->_callbackurl = $apiCallback;
    }
    /**
     * API Callback URL Getter.
     *
     * @return string
     */
    public function getApiCallback()
    {
        return $this->_callbackurl;
    }
    /**
     * Enforce Signed Header.
     *
     * @param bool $signedHeader
     *
     * @return void
     */
    public function setSignedHeader($signedHeader)
    {
        $this->_signedheader = $signedHeader;
    }
}