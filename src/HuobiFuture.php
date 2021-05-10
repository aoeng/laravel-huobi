<?php


namespace Aoeng\Laravel\Huobi;

/**
 * @group USDT永续合约 HuobiFuture
 * Class HuobiFuture
 * @package Aoeng\Laravel\Huobi
 */
class HuobiFuture extends Huobi
{

    public function __construct()
    {
        parent::__construct();
        $this->host = config('huobi.host.future', 'https://api.hbdm.com');
    }


    public function contractInfo($contract_code = '', $support_margin_mode = false)
    {
        $this->type = 'GET';
        $this->path = '/linear-swap-api/v1/swap_contract_info';

        $this->data = compact('contract_code', 'support_margin_mode');

        return $this->exec();
    }

    /**
     *
     *  (150档数据) step0, step1, step2, step3, step4, step5, step14, step15（合并深度1-5,14-15）；
     *  step0时，不合并深度, (20档数据) step6, step7, step8, step9, step10, step11, step12, step13（合并深度7-13）；
     *  step6时，不合并深度
     * @param $contract_code
     * @param $type
     * @return array|mixed
     */
    public function marketDepth($contract_code, $type)
    {
        $this->type = 'GET';
        $this->path = '/linear-swap-ex/market/depth';

        $this->data = compact('contract_code', 'type');

        return $this->exec();
    }

    public function marketHistoryKline($contract_code, $period, $size = 150, $from = null, $to = null)
    {
        $this->type = 'GET';
        $this->path = '/linear-swap-ex/market/history/kline';
        $this->data = array_filter(compact('contract_code', 'period', 'size', 'from', 'to'));

        return $this->exec();
    }

}
