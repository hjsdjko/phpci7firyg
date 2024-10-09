<?php

namespace AlibabaCloud\Tea\Rpc\Tests;

use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Rpc\Rpc;
use AlibabaCloud\Tea\Tea;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class RpcTest extends TestCase
{
    public function testDoRequestWithUnsetException()
    {
        // throws an exception when `config` is null
        $this->expectException(TeaError::class);
        $this->expectExceptionMessage("'config' can not be unset");
        new Rpc(null);
    }

    public function testDoRequestWithParameterUnsetException()
    {
        // Throws an exception when the value of accessKeyId｜accessKeySecret｜credential is not set.
        $this->expectException(TeaError::class);
        $this->expectExceptionMessage("'accessKeyId' and 'accessKeySecret' or 'credential' can not be unset");
        new Rpc(new Rpc\Config([]));
    }

    public function testDoRequestWithInvalidRegionID()
    {
        $config = new Rpc\Config([
            'accessKeyId'     => 'accesskey_id',
            'accessKeySecret' => 'accesskey_secret',
            'type'            => 'access_key',
            'regionId'        => '域名',
        ]);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('regionId is not match ^[a-zA-Z0-9_-]+$');
        new Rpc($config);
    }

    public function testDoRequest()
    {
        $config       = new Rpc\Config([
            'accessKeyId'     => 'accesskey_id',
            'accessKeySecret' => 'accesskey_secret',
            'type'            => 'access_key',
            'regionId'        => 'cn-hangzhou',
        ]);
        $mock         = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], json_encode([
                'foo' => 'bar',
            ])),
        ]);
        $handlerStack = HandlerStack::create($mock);
        Tea::config(['handler' => $handlerStack]);

        $rpc = new Rpc($config);
        /** @var Response $res */
        $res = $rpc->doRequest(
            'testApi',
            'HTTP',
            'GET',
            '2019-12-12',
            'AK',
            null,
            null,
            new RuntimeOptions()
        );
        $this->assertEquals(['foo' => 'bar'], $res);
    }

    public function testDefaultAny()
    {
        $this->assertEquals('foo', Rpc::defaultAny('foo', 'bar'));
        $this->assertEquals('bar', Rpc::defaultAny(null, 'bar'));
    }
}
