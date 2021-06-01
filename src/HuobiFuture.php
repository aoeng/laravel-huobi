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


    public function accountInfo($contract_code = null)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_account_info';

        $this->data = array_filter(compact('contract_code'));
        return $this->exec();
    }


    public function positionInfo($contract_code = null)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_position_info';

        $this->data = array_filter(compact('contract_code'));
        return $this->exec();
    }

    public function accountPositionInfo($contract_code)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_account_position_info';

        $this->data = array_filter(compact('contract_code'));
        return $this->exec();
    }

    public function availableLevelRate($contract_code = null)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_available_level_rate';

        $this->data = array_filter(compact('contract_code'));
        return $this->exec();
    }

    public function orderPlace(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_order';

        $this->data = $data;
        return $this->exec();
    }

    public function tpsOrderPlace(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_tpsl_order';

        $this->data = $data;
        return $this->exec();
    }

    public function tpsOrderCancel($contract_code, $direction = null)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_tpsl_cancelall';

        $this->data = array_filter(compact('contract_code', 'direction'));
        return $this->exec();
    }

    public function orderCancel($contract_code, $order_id = 0, $client_order_id = 0)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_cancel';

        $this->data = array_filter(compact('contract_code', 'order_id', 'client_order_id'));
        return $this->exec();
    }

    public function orderSearch($contract_code, $order_id = 0, $client_order_id = 0)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_order_info';

        $this->data = array_filter(compact('contract_code', 'order_id', 'client_order_id'));
        return $this->exec();
    }

    public function switchLeverRate($contract_code, $lever_rate)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_switch_lever_rate';

        $this->data = compact('contract_code', 'lever_rate');
        return $this->exec();
    }

    /**
     * 未成交订单  openOrders
     * @bodyParam page int required page
     * @param array $data
     * @return array|mixed
     */
    public function openOrders(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_openorders';

        $this->data = $data;
        return $this->exec();
    }

    /**
     * 历史委托订单  historyOrders
     * @bodyParam page int required page
     * @param array $data
     * @return array|mixed
     */
    public function historyOrders(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_hisorders';

        $this->data = $data;
        return $this->exec();
    }

    /**
     * 成交记录  matchResults
     * @bodyParam page int required page
     * @param array $data
     * @return array|mixed
     */
    public function matchResults(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_matchresults';

        $this->data = $data;
        return $this->exec();
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
