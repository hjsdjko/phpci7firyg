<?php

namespace AlibabaCloud\Tea\RpcUtils;

use AlibabaCloud\Tea\Model;
use AlibabaCloud\Tea\Request;
use Psr\Http\Message\StreamInterface;

class RpcUtils
{
    public static $supportedRegionId = ['ap-southeast-1', 'ap-northeast-1', 'eu-central-1', 'cn-hongkong', 'ap-south-1'];

    public static function getEndpoint($endpoint, $useAccelerate, $endpointType = 'public')
    {
        if ('internal' == $endpointType) {
            $tmp      = explode('.', $endpoint);
            $tmp[0] .= '-internal';
            $endpoint = implode('.', $tmp);
        }
        if ($useAccelerate && 'accelerate' == $endpointType) {
            return 'oss-accelerate.aliyuncs.com';
        }

        return $endpoint;
    }

    public static function getHost($serviceCode, $regionId, $endpoint)
    {
        if (null === $endpoint || empty($endpoint)) {
            return strtolower($serviceCode) . '.' .
                strtolower($regionId) . '.' .
                'aliyuncs.com';
        }

        return $endpoint;
    }

    /**
     * @param Request $request
     * @param string  $secret
     *
     * @return string
     */
    public static function getSignature($request, $secret)
    {
        $secret .= '&';
        $strToSign = self::getStrToSign($request->method, $request->query);

        $signMethod = isset($request->query['SignatureMethod']) ? $request->query['SignatureMethod'] : 'HMAC-SHA1';

        return self::encode($signMethod, $strToSign, $secret);
    }

    /**
     * @param array  $signedParams
     * @param string $method
     * @param string $secret
     *
     * @return string
     */
    public static function getSignatureV1($signedParams, $method, $secret)
    {
        $secret .= '&';
        $strToSign = self::getStrToSign($method, $signedParams);

        return self::encode('', $strToSign, $secret);
    }

    public static function hasError($dict)
    {
        if (null === $dict) {
            return true;
        }
        if (!isset($dict['Code'])) {
            return false;
        }

        return 'Success' != $dict['Code'];
    }

    public static function getTimestamp()
    {
        return gmdate('Y-m-d\\TH:i:s\\Z');
    }

    /**
     * @param Model $input
     * @param Model $output
     *
     * @throws \ReflectionException
     */
    public static function convert($input, &$output)
    {
        $class = new \ReflectionClass($input);
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->getName();
            if (!$property->isStatic()) {
                $value = $property->getValue($input);
                if ($value instanceof StreamInterface) {
                    continue;
                }
                $output->{$name} = $value;
            }
        }
    }

    public static function query($dict)
    {
        if (null === $dict) {
            return [];
        }
        if ($dict instanceof Model) {
            $dict = $dict->toMap();
        }
        $tmp = [];
        foreach ($dict as $k => $v) {
            if (0 !== strpos($k, '_')) {
                $tmp[$k] = $v;
            }
        }

        return self::flatten($tmp);
    }

    public static function getOpenPlatFormEndpoint($endpoint, $regionId)
    {
        $regionId = strtolower($regionId);
        if (!empty($regionId) && \in_array($regionId, self::$supportedRegionId)) {
            $tmp    = explode('.', $endpoint);
            $tmp[0] .= '.' . strtolower($regionId);

            return implode('.', $tmp);
        }

        return $endpoint;
    }

    private static function flatten($items = [], $delimiter = '.', $prepend = '')
    {
        $flatten = [];

        foreach ($items as $key => $value) {
            $pos = \is_int($key) ? $key + 1 : $key;
            if (\is_array($value) && !empty($value)) {
                $flatten = array_merge(
                    $flatten,
                    self::flatten($value, $delimiter, $prepend . $pos . $delimiter)
                );
            } else {
                $flatten[$prepend . $pos] = $value;
            }
        }

        return $flatten;
    }

    public static function getStrToSign($method, $query)
    {
        ksort($query);

        $params = [];
        foreach ($query as $k => $v) {
            if (null === $v) {
                continue;
            }
            $str = rawurlencode($k);
            if ('' !== $v) {
                $str .= '=' . rawurlencode($v);
            } else {
                $str .= '=';
            }
            array_push($params, $str);
        }
        $str = implode('&', $params);

        return $method . '&' . rawurlencode('/') . '&' . rawurlencode($str);
    }

    private static function encode($signMethod, $strToSign, $secret)
    {
        switch ($signMethod) {
            case 'HMAC-SHA256':
                return base64_encode(hash_hmac('sha256', $strToSign, $secret, true));
            default:
                return base64_encode(hash_hmac('sha1', $strToSign, $secret, true));
        }
    }
}
