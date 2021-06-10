<?php

namespace Aoeng\Laravel\Huobi\Facades;

use Illuminate\Support\Facades\Facade as LaravelFacade;

/**
 * @method static \Aoeng\Laravel\Huobi\HuobiFuture  keySecret($key, $secret)
 * @method static array state($contract_code = null)
 * @method static array accountPositionInfo($contract_code)
 * @method static array parentAccountInfo($contract_code = null)
 * @method static array parentTransfer($sub_uid, $from_margin_account, $to_margin_account, $amount, $type = 'master_to_sub', $asset = 'USDT', $client_order_id = null)
 * @method static array innerTransfer($from_margin_account, $to_margin_account, $amount, $asset = 'USDT', $client_order_id = null)
 * @method static array transfer($margin_account, $amount, $from = 'spot', $to = 'linear-swap', $currency = 'USDT')
 * @method static array positionInfo($contract_code = null)
 * @method static array accountInfo($contract_code = null)
 * @method static array availableLevelRate($contract_code = null)
 * @method static array orderPlace(array $data = [])
 * @method static array tpsOrderPlace(array $data = [])
 * @method static array tpsOrderCancel($contract_code, $direction = null)
 * @method static array orderCancel($contract_code, $order_id = 0, $client_order_id = 0)
 * @method static array orderSearch($contract_code, $order_id = 0, $client_order_id = 0)
 * @method static array switchLeverRate($contract_code, $lever_rate)
 * @method static array openOrders(array $data = [])
 * @method static array historyOrders(array $data = [])
 * @method static array matchResults(array $data = [])
 * @method static array contractInfo($contract_code = '', $support_margin_mode = false)
 * @method static array marketDepth($contract_code, $type)
 * @method static array marketHistoryKline($contract_code, $period, $size = 150, $from = null, $to = null)
 */
class HuobiFuture extends LaravelFacade
{
    protected static function getFacadeAccessor()
    {
        return 'huobiFuture';
    }
}
