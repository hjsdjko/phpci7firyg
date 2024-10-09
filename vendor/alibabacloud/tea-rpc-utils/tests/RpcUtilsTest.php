<?php

namespace AlibabaCloud\Tea\Tests\RpcUtils;

use AlibabaCloud\Tea\Model;
use AlibabaCloud\Tea\Request;
use AlibabaCloud\Tea\RpcUtils\RpcUtils;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class RpcUtilsTest extends TestCase
{
    public function testGetEndpoint()
    {
        $endpoint      = 'ecs.cn-hangzhou.aliyun.cs.com';
        $useAccelerate = false;
        $endpointType  = 'public';

        $this->assertEquals('ecs.cn-hangzhou.aliyun.cs.com', RpcUtils::getEndpoint($endpoint, $useAccelerate, $endpointType));

        $endpointType = 'internal';
        $this->assertEquals('ecs-internal.cn-hangzhou.aliyun.cs.com', RpcUtils::getEndpoint($endpoint, $useAccelerate, $endpointType));

        $useAccelerate = true;
        $endpointType  = 'accelerate';
        $this->assertEquals('oss-accelerate.aliyuncs.com', RpcUtils::getEndpoint($endpoint, $useAccelerate, $endpointType));
    }

    public function testGetHost()
    {
        $serviceCode = 'ecs';
        $regionId    = 'cn-hangzhou';
        $endpoint    = 'fake.aliyuncs.com';

        $this->assertEquals('ecs.cn-hangzhou.aliyuncs.com', RpcUtils::getHost($serviceCode, $regionId, ''));
        $this->assertEquals('fake.aliyuncs.com', RpcUtils::getHost($serviceCode, $regionId, $endpoint));
    }

    public function testGetSignature()
    {
        $request        = new Request();
        $request->query = [
            'query' => 'test',
            'body'  => 'test',
        ];
        $this->assertEquals('XlUyV4sXjOuX5FnjUz9IF9tm5rU=', RpcUtils::getSignature($request, 'secret'));
    }

    public function testGetStrToSign()
    {
        $this->assertEquals('GET&%2F&complex%3DFF%253D3iP2yN79-ED6%2529FU%253BR%2528F%252CmpP%252F4f8%252CUY%255B.3.g%252Br%2528806x%257B5%252A%2525%252F%253D%2529O8%25404%2526%255B%255D%2524%255Erp%26empty%3D%26foo%3Dbar%26number%3D0',
        RpcUtils::getStrToSign('GET', [
            'foo'      => 'bar',
            'empty'    => '',
            'null'     => null,
            'number'   => 0,
            'complex'  => 'FF=3iP2yN79-ED6)FU;R(F,mpP/4f8,UY[.3.g+r(806x{5*%/=)O8@4&[]$^rp',
        ]));
    }

    public function testGetSignatureV1()
    {
        $query   = [
            'test' => 'ok',
        ];
        $this->assertEquals('jHx/oHoHNrbVfhncHEvPdHXZwHU=', RpcUtils::getSignatureV1($query, '', 'accessKeySecret'));
    }

    public function testHasError()
    {
        $this->assertTrue(RpcUtils::hasError(null));
        $this->assertFalse(RpcUtils::hasError([]));

        $dict['Code'] = 'SomeError';
        $this->assertTrue(RpcUtils::hasError($dict));

        $dict['Code'] = 'Success';
        $this->assertFalse(RpcUtils::hasError($dict));
    }

    public function testGetTimestamp()
    {
        $date = RpcUtils::getTimestamp();
        $this->assertEquals(20, \strlen($date));
    }

    public function testConvert()
    {
        $model    = new MockModel();
        $model->a = 'foo';

        $output = new MockModel();
        RpcUtils::convert($model, $output);
        $this->assertEquals($model->a, $output->a);
    }

    public function testQuery()
    {
        $array = [
            'a'  => 'a',
            'b1' => [
                'a' => 'a',
            ],
            'b2' => [
                'a' => 'a',
            ],
            'c'=> ['x', 'y', 'z'],
        ];
        $this->assertEquals([
            'a'    => 'a',
            'b1.a' => 'a',
            'b2.a' => 'a',
            'c.1'  => 'x',
            'c.2'  => 'y',
            'c.3'  => 'z',
        ], RpcUtils::query($array));
    }

    public function testGetOpenPlatFormEndpoint()
    {
        $endpoint = 'fake.domain.com';
        $regionId = '';

        // regionId is empty
        $this->assertEquals('fake.domain.com', RpcUtils::getOpenPlatFormEndpoint($endpoint, $regionId));
        // regionId is invalid
        $regionId = 'invalid-regionId';
        $this->assertEquals('fake.domain.com', RpcUtils::getOpenPlatFormEndpoint($endpoint, $regionId));
        // regionId is valid but have upper character
        $regionId = 'cn-Hongkong';
        $this->assertEquals('fake.cn-hongkong.domain.com', RpcUtils::getOpenPlatFormEndpoint($endpoint, $regionId));
        // valid regionId
        $regionId = 'cn-hongkong';
        $this->assertEquals('fake.cn-hongkong.domain.com', RpcUtils::getOpenPlatFormEndpoint($endpoint, $regionId));
    }
}

class MockModel extends Model
{
    public $a = 'A';

    public $b = '';

    public $c = '';

    public function __construct()
    {
        $this->_name['a']     = 'A';
        $this->_required['c'] = true;
    }
}
