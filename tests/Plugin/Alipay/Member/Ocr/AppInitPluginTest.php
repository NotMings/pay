<?php

namespace Yansongda\Pay\Tests\Plugin\Alipay\Member\Ocr;

use Yansongda\Pay\Direction\ResponseDirection;
use Yansongda\Pay\Plugin\Alipay\Member\Ocr\AppInitPlugin;
use Yansongda\Pay\Rocket;
use Yansongda\Pay\Tests\TestCase;

class AppInitPluginTest extends TestCase
{
    protected AppInitPlugin $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new AppInitPlugin();
    }

    public function testNormal()
    {
        $rocket = (new Rocket())
            ->setParams([]);

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertNotEquals(ResponseDirection::class, $result->getDirection());
        self::assertStringContainsString('datadigital.fincloud.generalsaas.ocr.mobile.initialize', $result->getPayload()->toJson());
        self::assertStringContainsString('DATA_DIGITAL_BIZ_CODE_OCR', $result->getPayload()->toJson());
    }
}