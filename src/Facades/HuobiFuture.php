<?php

namespace Aoeng\Laravel\Huobi\Facades;

use Illuminate\Support\Facades\Facade as LaravelFacade;

/**
 * @method static \Aoeng\Laravel\Huobi\Huobi  keySecret($key, $secret)
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
