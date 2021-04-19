<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Aoeng\Laravel\Huobi\Api\Spot;


use Aoeng\Laravel\Huobi\Huobi;

class Account extends Huobi
{
    /**
     *
     * */
    public function get()
    {
        $this->type = 'GET';
        $this->path = '/v1/account/accounts';
        return $this->exec();
    }

    /**
     * /v1/account/accounts/{account-id}/balance
     * */
    public function getBalance(array $data = [])
    {
        $this->type = 'GET';
        $this->path = '/v1/account/accounts/' . $data['account-id'] . '/balance';
        $this->data = $data;
        return $this->exec();
    }


    /**
     *POST /v1/account/transfer
     * */
    public function postTransfer(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/v1/account/transfer';
        return $this->exec();
    }

    /**
     *GET /v1/account/history
     * */
    public function getHistory(array $data = [])
    {
        $this->type = 'GET';
        $this->path = '/v1/account/history';
        return $this->exec();
    }

    /**
     *GET /v2/account/ledger
     * */
    public function getLedger(array $data = [])
    {
        $this->type = 'GET';
        $this->path = '/v2/account/ledger';
        return $this->exec();
    }

    /**
     *POST /v1/futures/transfer
     * */
    public function postFuturesTransfer(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/v1/futures/transfer';
        return $this->exec();
    }
}
