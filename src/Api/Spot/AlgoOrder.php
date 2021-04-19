<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Aoeng\Laravel\HuoBi\Api\Spot;


use Aoeng\Laravel\HuoBi\HuoBi;

class AlgoOrder extends Huobi
{

    /**
     * POST /v2/algo-orders
     * */
    public function post(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/v2/algo-orders';
        $this->data = $data;
        return $this->exec();
    }

    /**
     * POST /v2/algo-orders/cancellation
     * */
    public function postCancellation(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/v2/algo-orders/cancellation';
        $this->data = $data;
        return $this->exec();
    }

    /**
     * GET /v2/algo-orders/opening
     * */
    public function getOpening(array $data = [])
    {
        $this->type = 'GET';
        $this->path = '/v2/algo-orders/opening';
        $this->data = $data;
        return $this->exec();
    }

    /**
     * GET /v2/algo-orders/history
     * */
    public function getHistory(array $data = [])
    {
        $this->type = 'GET';
        $this->path = '/v2/algo-orders/history';
        $this->data = $data;
        return $this->exec();
    }
}
