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
    }

    public function keySecret($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;

        return $this;
    }

    function setOptions(array $options = [])
    {
        $this->options = $options;
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
     * @param $param
     * @return array
     */
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
            return json_decode($this->send(), true);
        } catch (RequestException $e) {
            info('ERROR:', [$e->getMessage()]);
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
