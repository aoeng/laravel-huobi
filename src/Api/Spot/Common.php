<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Aoeng\Laravel\HuoBi\Api\Spot;


use Aoeng\Laravel\HuoBi\HuoBi;

class Common extends Huobi
{
    /**
     *
     * */
    public function getSymbols(array $data = [])
    {
        $this->type = 'GET';
        $this->path = '/v1/common/symbols';
        $this->data = $data;
        return $this->exec();
    }

    /**
     *
     * */
    public function getCurrencys(array $data = [])
    {
        $this->type = 'GET';
        $this->path = '/v1/common/currencys';
        $this->data = $data;
        return $this->exec();
    }

    /**
     *GET /v1/common/timestamp
     * */
    public function getTimestamp(array $data = [])
    {
        $this->type = 'GET';
        $this->path = '/v1/common/timestamp';
        $this->data = $data;
        return $this->exec();
    }
}
