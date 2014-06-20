<?php
namespace Eleme\Thrift\Tests\Provider\Silex;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit_Framework_TestCase;
use Eleme\Thrift\Provider\Silex\ThriftServiceProvider;

class ThriftServiceProviderTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->getMock(
            'Thrift\Transport\TBufferedTransport',
            array('open'),
            array(),
            'MockTBufferedTransport'
        );
        set_new_overload(array($this, 'callbackNew'));
    }

    public function tearDown()
    {
        unset_new_overload();
    }

    public function callbackNew($name)
    {
        switch ($name) {
            case 'Thrift\Transport\TBufferedTransport':
                return 'MockTBufferedTransport';
            default:
                return $name;
        }
    }

    public function testRegister()
    {
        $app = new Application();
        $app->register(new ThriftServiceProvider);
        $app['thrift.options'] = array(
            'foo' => array(
                'server' => 'test_host',
                'port' => 10000,
                'client' => 'Eleme\Thrift\Tests\Provider\Silex\Foo',
            ),
            'bar' => array(
                'server' => 'test_host',
                'port' => 10001,
                'client' => 'Eleme\Thrift\Tests\Provider\Silex\Bar',
            )
        );

        $app->get('/', function () {
        });
        $request = Request::create('/');
        $app->handle($request);

        $this->assertInstanceOf('Pimple', $app['thrift.clients']);
        $this->assertInstanceOf('Eleme\Thrift\Tests\Provider\Silex\Foo', $app['thrift.clients']['foo']);
        $this->assertInstanceOf('Eleme\Thrift\Tests\Provider\Silex\Bar', $app['thrift.clients']['bar']);
    }
}
