<?php
namespace Eleme\Thrift\Provider\Silex;

use Pimple;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Thrift\Transport\TSocket;
use Thrift\Transport\TBufferedTransport;
use Thrift\Protocol\TBinaryProtocolAccelerated;

class ThriftServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['thrift.options'] = array();

        $app['thrift.default_option'] = array(
            'persist' => false,
            'receive_timeout' => 3000,
            'send_timeout' => 1000,
            'read_buf_size' => 1024,
            'write_buf_size' => 1024,
        );

        $app['thrift.clients'] = $app->share(function ($app) {
            $clients = new Pimple();
            foreach ($app['thrift.options'] as $service => $option) {
                $config = array_merge($app['thrift.default_option'], $option);

                $clients[$service] = $clients->share(function () use ($config) {
                    $socket = new TSocket($config['server'], $config['port'], $config['persist']);
                    $socket->setRecvTimeout($config['receive_timeout']);
                    $socket->setSendTimeout($config['send_timeout']);

                    $transport = new TBufferedTransport($socket, $config['read_buf_size'], $config['write_buf_size']);
                    $transport->open();
                    if (!$config['persist']) {
                        register_shutdown_function(array($transport, "close"));
                    }

                    $protocol = new TBinaryProtocolAccelerated($transport);

                    return new $config['client']($protocol);
                });
            }
            return $clients;
        });
    }

    public function boot(Application $app)
    {
    }
}
