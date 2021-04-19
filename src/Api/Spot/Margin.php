<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Aoeng\Laravel\HuoBi\Api\Spot;


use Aoeng\Laravel\HuoBi\HuoBi;

class Margin extends Huobi
{
    /**
     *POST /v1/dw/transfer-in/margin
     * */
    public function postTransferIn(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/v1/dw/transfer-in/margin';
        $this->data = $data;
        return $this->exec();
    }

    /**
     *POST /v1/dw/transfer-out/margin
     * */
    public function postTransferOut(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/v1/dw/transfer-out/margin';
        $this->data = $data;
        return $this->exec();
    }

    /**
     *GET /v1/margin/loan-info
     * */
    public function getLoanInfo(array $data = [])
    {
        $this->type = 'GET';
        $this->path = '/v1/margin/loan-info';
        $this->data = $data;
        return $this->exec();
    }

    /**
     *POST /v1/margin/orders
     * */
    public function postOrders(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/v1/margin/orders';
        $this->data = $data;
        return $this->exec();
    }

    /**
     *POST /v1/margin/orders/{order-id}/repay
     * */
    public function postOrdersRepay(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/v1/margin/orders/' . $data['order_id'] . '/repay';
        $this->data = $data;
        return $this->exec();
    }

    /**
     *GET /v1/margin/loan-orders
     * */
    public function getLoanOrders(array $data = [])
    {
        $this->type = 'GET';
        $this->path = '/v1/margin/loan-orders';
        $this->data = $data;
        return $this->exec();
    }

    /**
     *GET /v1/margin/accounts/balance
     * */
    public function getAccountsBalance(array $data = [])
    {
        $this->type = 'GET';
        $this->path = '/v1/margin/accounts/balance';
        $this->data = $data;
        return $this->exec();
    }
}
