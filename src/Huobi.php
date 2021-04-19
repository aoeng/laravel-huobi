<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Aoeng\Laravel\Huobi;

use GuzzleHttp\Exception\RequestException;
use Exception;

class Huobi
{
    protected $key = '';

    protected $secret = '';

    protected $host = '';

    protected $account_id = '';


    protected $nonce = '';

    protected $signature = '';

    protected $headers = [];

    protected $type = '';

    protected $path = '';

    protected $data = [];

    protected $options = [];

    public function __construct()
    {
        $this->key = config('huobi.key', '');
        $this->secret = config('huobi.secret', '');
        $this->host = config('huobi.host', 'https://api.huobi.pro');

        $this->options = $data['options'] ?? [];
    }

    public function keySecret($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;

        return $this;
    }

    // ===================基本数据==================
    public function commonSymbols()
    {
        $this->type = 'GET';
        $this->path = '/v1/common/symbols';
        return $this->exec();
    }

    public function commonCurrencies()
    {
        $this->type = 'GET';
        $this->path = '/v1/common/currencys';
        return $this->exec();
    }

    // ====================账户数据===============
    public function accounts()
    {
        $this->type = 'GET';
        $this->path = '/v1/account/accounts';
        return $this->exec();
    }

    public function accountBalance($accountId)
    {
        $this->type = 'GET';
        $this->path = '/v1/account/accounts/' . $accountId . '/balance';
        $this->data = ['account-id' => $accountId];
        return $this->exec();
    }

    public function accountTransfer()
    {
        $this->type = 'POST';
        $this->path = '/v1/account/transfer';
        return $this->exec();
    }

    public function accountHistory()
    {
        $this->type = 'POST';
        $this->path = '/v1/account/history';
        return $this->exec();
    }

    //=======================行情数据==================
    public function marketHistoryKline($symbol, $period, $size = 150)
    {
        $this->type = 'GET';
        $this->path = '/market/history/kline';
        $this->data = compact('symbol', 'period', 'size');
        return $this->exec();
    }

    public function marketTickers()
    {
        $this->type = 'GET';
        $this->path = '/market/tickers';
        return $this->exec();
    }

    public function marketDepth($symbol, $depth = 20, $type = 0)
    {
        $this->type = 'GET';
        $this->path = '/market/depth';

        $type = 'step' . (string)$type;

        $this->data = compact('symbol', 'depth', 'type');
        return $this->exec();
    }

    //========================现货交易==================
    public function orderPlace(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/v1/order/orders/place';
        $this->data = $data;
        return $this->exec();
    }

    public function orderCancel($orderId)
    {
        $this->type = 'POST';
        $this->path = '/v1/order/orders/' . $orderId . '/submitcancel';
        $this->data = ['order-id' => $orderId];
        return $this->exec();
    }

    public function orderSearch($orderId)
    {
        $this->type = 'GET';
        $this->path = '/v1/order/orders/' . $orderId;
        $this->data = ['order-id' => $orderId];
        return $this->exec();
    }

    public function orderHistory(array $data = [])
    {
        $this->type = 'GET';
        $this->path = '/v1/order/history';
        $this->data = $data;
        return $this->exec();
    }

    /**
     * 认证
     * */
    protected function auth()
    {
        $this->nonce();

        $this->signature();

        $this->headers();

        $this->options();
    }

    /**
     * 过期时间
     * */
    protected function nonce()
    {
        $this->nonce = gmdate('Y-m-d\TH:i:s');
    }

    /**
     * 签名
     * */
    protected function signature()
    {
        if (empty($this->key)) return;

        $param = [
            'AccessKeyId'      => $this->key,
            'SignatureMethod'  => 'HmacSHA256',
            'SignatureVersion' => 2,
            'Timestamp'        => $this->nonce,
        ];

        if (!empty($this->data)) {
            $param = array_merge($param, $this->data);
        }

        $param = $this->sort($param);

        $host_tmp = explode('https://', $this->host);
        if (isset($host_tmp[1])) $temp = $this->type . "\n" . $host_tmp[1] . "\n" . $this->path . "\n" . implode('&', $param);
        $signature = base64_encode(hash_hmac('sha256', $temp ?? '', $this->secret, true));

        $param[] = "Signature=" . urlencode($signature);

        $this->signature = implode('&', $param);
    }

    /**
     * 根据huobi规则排序
     * */
    protected function sort($param)
    {
        $u = [];
        $sort_rank = [];
        foreach ($param as $k => $v) {
            if (is_array($v)) $v = json_encode($v);
            $u[] = $k . "=" . urlencode($v);
            $sort_rank[] = ord($k);
        }
        asort($u);

        return $u;
    }

    /**
     * 默认头部信息
     * */
    protected function headers()
    {
        $this->headers = [
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * 请求设置
     * */
    protected function options()
    {
        if (isset($this->options['headers'])) $this->headers = array_merge($this->headers, $this->options['headers']);

        $this->options['headers'] = $this->headers;
        $this->options['timeout'] = $this->options['timeout'] ?? 60;

        if (isset($this->options['proxy']) && $this->options['proxy'] === true) {
            $this->options['proxy'] = [
                'http'  => 'http://127.0.0.1:12333',
                'https' => 'http://127.0.0.1:12333',
                'no'    => ['.cn']
            ];
        }
    }

    /**
     * 发送http
     * */
    protected function send()
    {
        $client = new \GuzzleHttp\Client();

        if (!empty($this->data)) {
            $this->options['body'] = json_encode($this->data);
        }

        if ($this->type == 'GET' && empty($this->key)) {
            $this->signature = empty($this->data) ? '' : http_build_query($this->data);
        }

        $response = $client->request($this->type, $this->host . $this->path . '?' . $this->signature, $this->options);

        return $response->getBody()->getContents();
    }

    /*
     * 执行流程
     * */
    protected function exec()
    {
        $this->auth();

        //可以记录日志
        try {
            $temp = json_decode($this->send(), true);
//            if (isset($temp['status']) && $temp['status'] == 'error') {
//                $temp['_method'] = $this->type;
//                $temp['_url'] = $this->host . $this->path;
//                $temp['_httpcode'] = 200;
//                throw new Exception(json_encode($temp));
//            }

            return $temp;
        } catch (RequestException $e) {
            if (method_exists($e->getResponse(), 'getBody')) {
                $contents = $e->getResponse()->getBody()->getContents();

                $temp = empty($contents) ? [] : json_decode($contents, true);

                if (!empty($temp)) {
                    $temp['_method'] = $this->type;
                    $temp['_url'] = $this->host . $this->path;
                } else {
                    $temp['_message'] = $e->getMessage();
                }
            } else {
                $temp['_message'] = $e->getMessage();
            }

            $temp['_httpcode'] = $e->getCode();

            //TODO  该流程可以记录各种日志
            throw new Exception(json_encode($temp));
        }
    }
}