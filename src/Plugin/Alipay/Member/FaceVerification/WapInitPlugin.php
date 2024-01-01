<?php

declare(strict_types=1);

namespace Yansongda\Pay\Plugin\Alipay\Member\FaceVerification;

use Closure;
use Yansongda\Pay\Contract\PluginInterface;
use Yansongda\Pay\Logger;
use Yansongda\Pay\Rocket;

/**
 * @see https://opendocs.alipay.com/open/02zloa?pathHash=b0b7fece&ref=api&scene=common
 */
class WapInitPlugin implements PluginInterface
{
    public function assembly(Rocket $rocket, Closure $next): Rocket
    {
        Logger::debug('[Alipay][Member][FaceVerification][WapInitPlugin] 插件开始装载', ['rocket' => $rocket]);

        $rocket->mergePayload([
            'method' => 'datadigital.fincloud.generalsaas.face.certify.initialize',
            'biz_content' => array_merge(
                [
                    'biz_code' => 'FUTURE_TECH_BIZ_FACE_SDK',
                ],
                $rocket->getParams(),
            ),
        ]);

        Logger::info('[Alipay][Member][FaceVerification][WapInitPlugin] 插件装载完毕', ['rocket' => $rocket]);

        return $next($rocket);
    }
}