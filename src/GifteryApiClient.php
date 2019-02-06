<?php

namespace Giftery;

use Giftery\classes\data\PushSmsData;
use Giftery\classes\GifteryApiBase;
use Giftery\classes\response\PushSmsResponse;

/**
 * Class GifteryApiClient
 * @package Giftery
 */
class GifteryApiClient extends GifteryApiBase
{
    /**
     * @var array
     */
    protected $allowedMethods = [
        'pushSms',
    ];

    /**
     * @param \Giftery\classes\data\PushSmsData $data
     * @return \Giftery\classes\response\ApiResponse|\Giftery\classes\response\PushSmsResponse
     * @throws \Giftery\classes\exception\HttpException
     */
    public function callPushSms(PushSmsData $data)
    {
        return $this->call('pushSms', PushSmsResponse::class, $data);
    }
}
