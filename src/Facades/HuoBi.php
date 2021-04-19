<?php

namespace Aoeng\Laravel\Huobi\Facades;

use Illuminate\Support\Facades\Facade as LaravelFacade;

/**
 * @method static \Aoeng\Laravel\Huobi\Huobi  keySecret($key, $secret)
 * @method static array commonSymbols()
 * @method static array commonCurrencies()
 * @method static array marketHistoryKline($symbol, $period, $size = 150)
 * @method static array marketTickers()
 * @method static array marketDepth($symbol, $depth = 20, $type = 0)
 */
class HuoBi extends LaravelFacade
{
    protected static function getFacadeAccessor()
    {
        return 'huobi';
    }
}
