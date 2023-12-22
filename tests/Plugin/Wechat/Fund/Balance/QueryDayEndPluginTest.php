<?php

namespace Yansongda\Pay\Tests\Plugin\Wechat\Fund\Balance;

use GuzzleHttp\Psr7\Uri;
use Yansongda\Pay\Exception\Exception;
use Yansongda\Pay\Exception\InvalidParamsException;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Plugin\Wechat\Fund\Balance\QueryDayEndPlugin;
use Yansongda\Pay\Provider\Wechat;
use Yansongda\Pay\Rocket;
use Yansongda\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class QueryDayEndPluginTest extends TestCase
{
    /**
     * @var \Yansongda\Pay\Plugin\Wechat\Fund\Balance\QueryDayEndPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new QueryDayEndPlugin();
    }

    public function testNormal()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['account_type' => '123', 'date' => '2021-10-23']));

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        $radar = $result->getRadar();

        self::assertEquals(new Uri(Wechat::URL[Pay::MODE_NORMAL].'v3/merchant/fund/dayendbalance/123?date=2021-10-23'), $radar->getUri());
        self::assertEquals('GET', $radar->getMethod());
    }

    public function testNormalNoAccountType()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['date' => '2021-10-23']));

        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::NECESSARY_PARAMS_MISSING);

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }

    public function testNormalNoDate()
    {
        $rocket = new Rocket();
        $rocket->setParams([])->setPayload(new Collection(['account_type' => '123']));

        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::NECESSARY_PARAMS_MISSING);

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }
}
