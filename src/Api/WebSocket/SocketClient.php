<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Aoeng\Laravel\Huobi\Api\WebSocket;

use Workerman\Lib\Timer;
use Workerman\Worker;

class SocketClient
{
    use SocketGlobal;
    use SocketFunction;

    private $config = [];
    private $keySecret = [];


    function __construct(array $config = [])
    {
        $this->config = $config;

        $this->client();

        $this->init();
    }

    protected function init()
    {
        //初始化全局变量
        $this->add('global_key', []);//保存全局变量key

        $this->add('all_sub', []);//目前总共订阅的频道

        $this->add('add_sub', []);//正在订阅的频道

        $this->add('del_sub', []);//正在删除的频道

        $this->add('keysecret', []);//目前总共key

        $this->add('debug', []);
    }

    function keysecret(array $keysecret = [])
    {
        $this->keySecret = $keysecret;
        return $this;
    }

    /**
     * @param array $sub
     */
    public function subscribe(array $sub = [])
    {
        // 是否又私有频道订阅
        if (!empty($this->keySecret)) {
            $keysecret = $this->get('keysecret');

            if (!isset($keysecret[$this->keySecret['key']]['connection']))
                $this->keySecretInit($this->keySecret, [
                    'connection' => 0,
                ]);
        }
        //print_r($this->resub($sub));
        $this->save('add_sub', $this->resub($sub));
    }

    /**
     * @param array $sub
     */
    public function unsubscribe(array $sub = [])
    {
        // 是否又私有频道订阅
        /*if(!empty($this->keySecret)) {
            if(!isset($keysecret[$this->keySecret['key']]['connection']))
            $this->keySecretInit($this->keySecret,[
                'connection_close'=>1,
            ]);
        }*/

        $this->save('del_sub', $this->resub($sub));
    }

    /**
     * @param array $sub 默认获取所有public订阅的数据，private数据需要设置keysecret
     * @param null $callback
     * @param bool $daemon
     * @return mixed
     */
    public function getSubscribe(array $sub, $callback = null, $daemon = false)
    {
        if ($daemon) $this->daemon($callback, $sub);

        return $this->getData($this, $callback, $sub);
    }

    /**
     * 返回订阅的所有数据
     * @param null $callback
     * @param bool $daemon
     * @return array
     */
    public function getSubscribes($callback = null, $daemon = false)
    {
        if ($daemon) $this->daemon($callback);

        return $this->getData($this, $callback);
    }

    protected function daemon($callback = null, $sub = [])
    {
        $worker = new Worker();
        $worker->onWorkerStart = function () use ($callback, $sub) {
            $global = $this->client();

            $time = isset($this->config['data_time']) ? $this->config['data_time'] : 0.5;

            Timer::add($time, function () use ($global, $callback, $sub) {
                $this->getData($global, $callback, $sub);
            });
        };
        Worker::runAll();
    }

    /**
     * @param $global
     * @param null $callback
     * @param array $sub 返回规定的频道
     * @return array
     */
    protected function getData($global, $callback = null, $sub = [])
    {
        $all_sub = $global->get('all_sub');
        if (empty($all_sub)) return [];

        $temp = [];

        //默认返回所有数据
        if (empty($sub)) {
            foreach ($all_sub as $k => $v) {
                if (is_array($v)) {
                    if (empty($this->keySecret) || $this->keySecret['key'] != $k) continue;

                    foreach ($v as $vv) {
                        $data = $global->getQueue(strtolower($vv));
                        $temp[strtolower($vv)] = $data;
                    }
                } else {
                    $data = $global->get(strtolower($v));
                    $temp[strtolower($v)] = $data;
                }
            }
        } else {
            //返回规定的数据
            if (!empty($this->keySecret)) {
                //是否有私有数据
                if (isset($all_sub[$this->keySecret['key']])) $sub = array_merge($sub, $all_sub[$this->keySecret['key']]);
            }

            //现货 maket数据key 无法对应。默认返回全部maket？？
            /*if($this->getPlatform()=='spot'){

            }*/

            //print_r($sub);
            foreach ($sub as $k => $v) {
                //判断私有数据是否需要走队列数据
                $temp_v = explode(self::$USER_DELIMITER, $v);
                if (count($temp_v) > 1) {
                    //private
                    $data = $global->getQueue(strtolower($v));
                } else {
                    //public
                    $data = $global->get(strtolower($v));
                }

                if (empty($data)) continue;

                $temp[$v] = $data;
            }
        }

        if ($callback !== null) {
            call_user_func_array($callback, array($temp));
        }

        return $temp;
    }

    function test()
    {
        print_r($this->client->all_sub);
        print_r($this->client->add_sub);
        print_r($this->client->del_sub);
        print_r($this->client->keySecret);
        print_r($this->client->global_key);
    }

    function test2()
    {
        //print_r($this->client->global_key);
        $global_key = $this->client->global_key;
        foreach ($global_key as $k => $v) {
            echo count($this->client->$v) . '----' . $k . PHP_EOL;
            echo json_encode($this->client->$v) . PHP_EOL;
        }
    }

    function test_reconnection()
    {
        $this->client->debug = [
            'public' => ['market' => 'close', 'kline' => 'close'],
        ];
    }

    function test_reconnection2($key)
    {
        $this->client->debug = [
            'private' => [$key => 'close'],
        ];
    }
}
