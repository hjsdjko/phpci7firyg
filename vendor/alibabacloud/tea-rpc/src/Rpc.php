<?php

// This file is auto-generated, don't edit it. Thanks.

namespace AlibabaCloud\Tea\Rpc;

use AlibabaCloud\Credentials\Credential;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use AlibabaCloud\Tea\Request;
use AlibabaCloud\Tea\Rpc\Rpc\Config;
use AlibabaCloud\Tea\RpcUtils\RpcUtils;
use AlibabaCloud\Tea\Tea;
use AlibabaCloud\Tea\Utils\Utils;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use Exception;

/**
 * This is for RPC SDK.
 */
class Rpc
{
    protected $_endpoint;

    protected $_regionId;

    protected $_protocol;

    protected $_userAgent;

    protected $_endpointRule;

    protected $_endpointMap;

    protected $_suffix;

    protected $_readTimeout;

    protected $_connectTimeout;

    protected $_httpProxy;

    protected $_httpsProxy;

    protected $_socks5Proxy;

    protected $_socks5NetWork;

    protected $_noProxy;

    protected $_network;

    protected $_productId;

    protected $_maxIdleConns;

    protected $_endpointType;

    protected $_openPlatformEndpoint;

    protected $_credential;

    /**
     * Init client with Config.
     *
     * @param config config contains the necessary information to create a client
     * @param mixed $config
     */
    public function __construct($config)
    {
        if (Utils::isUnset($config)) {
            throw new TeaError([
                'code'    => 'ParameterMissing',
                'message' => "'config' can not be unset",
            ]);
        }
        Utils::validateModel($config);
        if (!Utils::empty_($config->accessKeyId) && !Utils::empty_($config->accessKeySecret)) {
            if (!Utils::empty_($config->securityToken)) {
                $config->type = 'sts';
            } else {
                $config->type = 'access_key';
            }
            $credentialConfig = new \AlibabaCloud\Credentials\Credential\Config([
                'accessKeyId'     => $config->accessKeyId,
                'type'            => $config->type,
                'accessKeySecret' => $config->accessKeySecret,
                'securityToken'   => $config->securityToken,
            ]);
            $this->_credential = new Credential($credentialConfig);
        } elseif (!Utils::isUnset($config->credential)) {
            $this->_credential = $config->credential;
        } else {
            throw new TeaError([
                'code'    => 'ParameterMissing',
                'message' => "'accessKeyId' and 'accessKeySecret' or 'credential' can not be unset",
            ]);
        }
        $this->_network              = $config->network;
        $this->_suffix               = $config->suffix;
        $this->_endpoint             = $config->endpoint;
        $this->_protocol             = $config->protocol;
        $this->_regionId             = $config->regionId;
        $this->_userAgent            = $config->userAgent;
        $this->_readTimeout          = $config->readTimeout;
        $this->_connectTimeout       = $config->connectTimeout;
        $this->_httpProxy            = $config->httpProxy;
        $this->_httpsProxy           = $config->httpsProxy;
        $this->_noProxy              = $config->noProxy;
        $this->_socks5Proxy          = $config->socks5Proxy;
        $this->_socks5NetWork        = $config->socks5NetWork;
        $this->_maxIdleConns         = $config->maxIdleConns;
        $this->_endpointType         = $config->endpointType;
        $this->_openPlatformEndpoint = $config->openPlatformEndpoint;
    }

    /**
     * Encapsulate the request and invoke the network.
     *
     * @param string         $action   api name
     * @param string         $protocol http or https
     * @param string         $method   e.g. GET
     * @param string         $version  product version
     * @param string         $authType when authType is Anonymous, the signature will not be calculate
     * @param mixed[]        $query    which contains request params
     * @param mixed[]        $body     content of request
     * @param RuntimeOptions $runtime  which controls some details of call api, such as retry times
     *
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     *
     * @return array the response
     */
    public function doRequest($action, $protocol, $method, $version, $authType, $query, $body, $runtime)
    {
        $runtime->validate();
        $_runtime = [
            'timeouted'      => 'retry',
            'readTimeout'    => Utils::defaultNumber($runtime->readTimeout, $this->_readTimeout),
            'connectTimeout' => Utils::defaultNumber($runtime->connectTimeout, $this->_connectTimeout),
            'httpProxy'      => Utils::defaultString($runtime->httpProxy, $this->_httpProxy),
            'httpsProxy'     => Utils::defaultString($runtime->httpsProxy, $this->_httpsProxy),
            'noProxy'        => Utils::defaultString($runtime->noProxy, $this->_noProxy),
            'maxIdleConns'   => Utils::defaultNumber($runtime->maxIdleConns, $this->_maxIdleConns),
            'retry'          => [
                'retryable'   => $runtime->autoretry,
                'maxAttempts' => Utils::defaultNumber($runtime->maxAttempts, 3),
            ],
            'backoff' => [
                'policy' => Utils::defaultString($runtime->backoffPolicy, 'no'),
                'period' => Utils::defaultNumber($runtime->backoffPeriod, 1),
            ],
            'ignoreSSL' => $runtime->ignoreSSL,
        ];
        $_lastRequest   = null;
        $_lastException = null;
        $_now           = time();
        $_retryTimes    = 0;
        while (Tea::allowRetry(@$_runtime['retry'], $_retryTimes, $_now)) {
            if ($_retryTimes > 0) {
                $_backoffTime = Tea::getBackoffTime(@$_runtime['backoff'], $_retryTimes);
                if ($_backoffTime > 0) {
                    Tea::sleep($_backoffTime);
                }
            }
            $_retryTimes = $_retryTimes + 1;

            try {
                $_request           = new Request();
                $_request->protocol = Utils::defaultString($this->_protocol, $protocol);
                $_request->method   = $method;
                $_request->pathname = '/';
                $_request->query    = RpcUtils::query(Tea::merge([
                    'Action'         => $action,
                    'Format'         => 'json',
                    'Timestamp'      => RpcUtils::getTimestamp(),
                    'Version'        => $version,
                    'SignatureNonce' => Utils::getNonce(),
                ], $query));
                // endpoint is setted in product client
                $_request->headers = [
                    'x-acs-version' => $version,
                    'x-acs-action'  => $action,
                    'host'          => $this->_endpoint,
                    'user-agent'    => $this->getUserAgent(),
                ];
                if (!Utils::isUnset($body)) {
                    $tmp                               = Utils::anyifyMapValue(RpcUtils::query($body));
                    $_request->body                    = Utils::toFormString($tmp);
                    $_request->headers['content-type'] = 'application/x-www-form-urlencoded';
                }
                if (!Utils::equalString($authType, 'Anonymous')) {
                    $accessKeyId     = $this->getAccessKeyId();
                    $accessKeySecret = $this->getAccessKeySecret();
                    $securityToken   = $this->getSecurityToken();
                    if (!Utils::empty_($securityToken)) {
                        $_request->query['SecurityToken'] = $securityToken;
                    }
                    $_request->query['SignatureMethod']  = 'HMAC-SHA1';
                    $_request->query['SignatureVersion'] = '1.0';
                    $_request->query['AccessKeyId']      = $accessKeyId;
                    $signedParam                         = Tea::merge($_request->query, RpcUtils::query($body));
                    $_request->query['Signature']        = RpcUtils::getSignatureV1($signedParam, $_request->method, $accessKeySecret);
                }
                $_lastRequest = $_request;
                $_response    = Tea::send($_request, $_runtime);
                $obj          = Utils::readAsJSON($_response->body);
                $res          = Utils::assertAsMap($obj);
                if (Utils::is4xx($_response->statusCode) || Utils::is5xx($_response->statusCode)) {
                    throw new TeaError([
                        'code'    => '' . (string) (self::defaultAny(@$res['Code'], @$res['code'])) . '',
                        'message' => 'code: ' . (string) ($_response->statusCode) . ', ' . (string) (self::defaultAny(@$res['Message'], @$res['message'])) . ' request id: ' . (string) (self::defaultAny(@$res['RequestId'], @$res['requestId'])) . '',
                        'data'    => $res,
                    ]);
                }

                return $res;
            } catch (Exception $e) {
                if (!($e instanceof TeaError)) {
                    $e = new TeaError([], $e->getMessage(), $e->getCode(), $e);
                }
                if (Tea::isRetryable($e)) {
                    $_lastException = $e;

                    continue;
                }

                throw $e;
            }
        }

        throw new TeaUnableRetryError($_lastRequest, $_lastException);
    }

    /**
     * Get user agent.
     *
     * @return string user agent
     */
    public function getUserAgent()
    {
        return Utils::getUserAgent($this->_userAgent);
    }

    /**
     * Get accesskey id by using credential.
     *
     * @return string accesskey id
     */
    public function getAccessKeyId()
    {
        if (Utils::isUnset($this->_credential)) {
            return '';
        }

        return $this->_credential->getAccessKeyId();
    }

    /**
     * Get accesskey secret by using credential.
     *
     * @return string accesskey secret
     */
    public function getAccessKeySecret()
    {
        if (Utils::isUnset($this->_credential)) {
            return '';
        }

        return $this->_credential->getAccessKeySecret();
    }

    /**
     * Get security token by using credential.
     *
     * @return string security token
     */
    public function getSecurityToken()
    {
        if (Utils::isUnset($this->_credential)) {
            return '';
        }

        return $this->_credential->getSecurityToken();
    }

    /**
     * If the endpointRule and config.endpoint are empty, throw error.
     *
     * @param Config $config config contains the necessary information to create a client
     *
     * @throws TeaError
     */
    public function checkConfig($config)
    {
        if (Utils::empty_($this->_endpointRule) && Utils::empty_($config->endpoint)) {
            throw new TeaError([
                'code'    => 'ParameterMissing',
                'message' => "'config.endpoint' can not be empty",
            ]);
        }
    }

    /**
     * If inputValue is not null, return it or return defaultValue.
     *
     * @param mixed $inputValue   users input value
     * @param mixed $defaultValue default value
     *
     * @return any the final result
     */
    public static function defaultAny($inputValue, $defaultValue)
    {
        if (Utils::isUnset($inputValue)) {
            return $defaultValue;
        }

        return $inputValue;
    }
}
