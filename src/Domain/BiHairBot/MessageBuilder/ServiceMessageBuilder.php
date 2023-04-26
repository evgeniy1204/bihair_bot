<?php
namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotEvents;
use App\Domain\BiHairBot\ButtonDto;
use App\Domain\BiHairBot\MessageDto;

class ServiceMessageBuilder implements MessageBuilderInterface
{
    /**
     * @param string $chantId
     *
     * @return \Generator|MessageDto[]
     */
    public function build(string $chantId): \Generator
    {
        yield new MessageDto(
            $chantId,
            'Кератин 
💫 Кератин - процедура выпрямления завитков, кудрей, волнистых волос и формирования защитной пленки вокруг волоса для блеска, утяжеления и идеальной гладкости

💫 Ботокс - процедура дисциплинирования волос, сглаживания пушистости для идеально гладких блестящих волос',
            photoId: 'AgACAgQAAxkDAAPYZEjgCBsBqgryiQVbS44G3-1HKJEAApSvMRsVDE1SG-giPZ36he8BAAMCAANzAAMvBA'
        );
        yield new MessageDto(
            $chantId,
            'Холодное восстановление
💫 Холодное восстановление нужно самым хрупким, ломким, обесцвеченным, поврежденным волосам. Без использования утюжка. Не имеет ярко выраженных визуальных эффектов',
            photoId: 'AgACAgQAAxkDAAPXZEjf4C2S0Ej85xVbt14HOv7aGdAAAtSvMRtOKExSFLHfZKOzegIBAAMCAANzAAMvBA'
        );
        yield new MessageDto(
            $chantId,
            'Трихология',
            [new ButtonDto('Подробноее о трихологии', url: 'https://www.instagram.com/s/aGlnaGxpZ2h0OjE4MDUwOTY3Nzc1Mzk3NTc3?story_media_id=3057605334607647085&igshid=YmMyMTA2M2Y=')]
        );
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool
    {
        return $type === BiHairBotEvents::SERVICE;
    }
}
