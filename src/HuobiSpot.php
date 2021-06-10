<?php


namespace Aoeng\Laravel\Huobi;


/**
 * @group 现货 HuobiSpot
 * Class HuobiSpot
 * @package Aoeng\Laravel\Huobi
 */
class HuobiSpot extends Huobi
{

    public function __construct()
    {
        parent::__construct();

        $this->host = config('huobi.host.spot', 'https://api.huobi.pro');
    }

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

    public function accountTransfer($data = [])
    {
        $this->type = 'POST';
        $this->path = '/v1/account/transfer';
        $this->data = $data;
        return $this->exec();
    }

    public function transfer($margin_account, $amount, $from = 'spot', $to = 'linear-swap', $currency = 'USDT')
    {
        $this->type = 'POST';
        $this->path = '/v2/account/transfer';
        $this->data = array_merge(['margin-account' => $margin_account], compact('from', 'amount', 'to', 'currency'));
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

}
