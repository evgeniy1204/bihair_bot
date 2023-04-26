<?php
namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotEvents;
use App\Domain\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\ButtonDto;
use App\Service\Telegram\MessageBuilderInterface;
use App\Service\Telegram\MessageDto;

class ServiceMessageBuilder implements MessageBuilderInterface
{
    /**
     * @param string $chatId
     *
     * @return \Generator|MessageDto[]
     */
    public function build(string $chatId): \Generator
    {
        yield new MessageDto(
            $chatId,
            'Кератин 
💫 Кератин - процедура выпрямления завитков, кудрей, волнистых волос и формирования защитной пленки вокруг волоса для блеска, утяжеления и идеальной гладкости

💫 Ботокс - процедура дисциплинирования волос, сглаживания пушистости для идеально гладких блестящих волос',
            photoId: 'AgACAgQAAxkDAAPYZEjgCBsBqgryiQVbS44G3-1HKJEAApSvMRsVDE1SG-giPZ36he8BAAMCAANzAAMvBA'
        );
        yield new MessageDto(
            $chatId,
            'Холодное восстановление
💫 Холодное восстановление нужно самым хрупким, ломким, обесцвеченным, поврежденным волосам. Без использования утюжка. Не имеет ярко выраженных визуальных эффектов',
            photoId: 'AgACAgQAAxkDAAPXZEjf4C2S0Ej85xVbt14HOv7aGdAAAtSvMRtOKExSFLHfZKOzegIBAAMCAANzAAMvBA'
        );
        yield new MessageDto(
            $chatId,
            'Трихология',
            [new ButtonDto('Подробноее о трихологии', url: 'https://www.instagram.com/s/aGlnaGxpZ2h0OjE4MDUwOTY3Nzc1Mzk3NTc3?story_media_id=3057605334607647085&igshid=YmMyMTA2M2Y=')]
        );
    }

    /**
     * @param string $type
     * @param string $botName
     *
     * @return bool
     */
    public function supports(string $type, string $botName): bool
    {
        return $type === BiHairBotEvents::SERVICE && $botName === BiHairBotProvider::BOT_NAME;
    }
}
