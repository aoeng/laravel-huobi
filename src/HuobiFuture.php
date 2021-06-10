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

    public function state($contract_code = null)
    {
        $this->type = 'GET';
        $this->path = '/linear-swap-api/v1/swap_api_state';

        $this->data = array_filter(compact('contract_code'));
        return $this->exec();
    }


    public function parentAccountInfo($contract_code = null)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_sub_account_list';

        $this->data = array_filter(compact('contract_code'));
        return $this->exec();
    }

    public function parentTransfer($sub_uid, $from_margin_account, $to_margin_account, $amount, $type = 'master_to_sub', $asset = 'USDT', $client_order_id = null)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_master_sub_transfer';

        $this->data = array_filter(compact('sub_uid', 'from_margin_account', 'to_margin_account', 'amount', 'type', 'asset', 'client_order_id'));
        return $this->exec();
    }

    public function innerTransfer($from_margin_account, $to_margin_account, $amount, $asset = 'USDT', $client_order_id = null)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_transfer_inner';

        $this->data = array_filter(compact('from_margin_account', 'to_margin_account', 'amount', 'asset', 'client_order_id'));
        return $this->exec();
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

//    合约订单

    public function orderPlace(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_order';

        $this->data = $data;
        return $this->exec();
    }

    public function orderCancel($contract_code, $order_id = 0, $client_order_id = 0)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_cancel';

        $this->data = array_filter(compact('contract_code', 'order_id', 'client_order_id'));
        return $this->exec();
    }


    public function orderCancelAll($contract_code, $direction = null, $offset = null)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_cancelall';

        $this->data = array_filter(compact('contract_code', 'direction', 'offset'));
        return $this->exec();
    }

    public function orderSearch($contract_code, $order_id = 0, $client_order_id = 0)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_order_info';

        $this->data = array_filter(compact('contract_code', 'order_id', 'client_order_id'));
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
     * @param $contract_code
     * @param int $trade_type
     * @param int $type
     * @param int $status
     * @param int $create_date
     * @param null $page_index
     * @param null $page_size
     * @param null $sort_by
     * @return array|mixed
     */
    public function historyOrders($contract_code, $trade_type = 0, $type = 1, $status = 0, $create_date = 90, $page_index = null, $page_size = null, $sort_by = null)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_hisorders';

        $this->data = array_merge(
            compact('contract_code', 'trade_type', 'type', 'status', 'create_date'),
            array_filter(compact('page_index', 'page_size', 'sort_by')));
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

//  止盈止损订单
    public function tpslOrderPlace(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_tpsl_order';

        $this->data = $data;
        return $this->exec();
    }


    public function tpslOrderCancel($contract_code, $order_id)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_tpsl_cancel';

        $this->data = array_filter(compact('contract_code', 'order_id'));
        return $this->exec();
    }

    public function tpslOrderCancelAll($contract_code, $direction = null)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_tpsl_cancelall';

        $this->data = array_filter(compact('contract_code', 'direction'));
        return $this->exec();
    }


    public function tpslOrderSearch($contract_code, $order_id = 0)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_relation_tpsl_order';

        $this->data = array_filter(compact('contract_code', 'order_id'));
        return $this->exec();
    }

    public function historyTpslOrders($contract_code, $status = 0, $create_date = 90, $page_index = null, $page_size = null, $sort_by = null)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_tpsl_hisorders';

        $this->data = array_merge(
            compact('contract_code', 'status', 'create_date'),
            array_filter(compact('page_index', 'page_size', 'sort_by')));
        return $this->exec();
    }

// 追踪委托
    public function trackOrderPlace(array $data = [])
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_track_order';

        $this->data = $data;
        return $this->exec();
    }


    public function trackOrderCancel($contract_code, $order_id)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_track_cancel';

        $this->data = array_filter(compact('contract_code', 'order_id'));
        return $this->exec();
    }

    public function trackOrderCancelAll($contract_code, $direction = null, $offset = null)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_track_cancelall';

        $this->data = array_filter(compact('contract_code', 'direction', 'offset'));
        return $this->exec();
    }


    public function historyTrackOrders($contract_code, $status = 0, $trade_type = 0, $create_date = 90, $page_index = null, $page_size = null, $sort_by = null)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_track_hisorders';

        $this->data =
            array_merge(
                compact('contract_code', 'status', 'trade_type', 'create_date'),
                array_filter(compact('page_index', 'page_size', 'sort_by'))
            );
        return $this->exec();
    }

    public function switchLeverRate($contract_code, $lever_rate)
    {
        $this->type = 'POST';
        $this->path = '/linear-swap-api/v1/swap_switch_lever_rate';

        $this->data = compact('contract_code', 'lever_rate');
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
