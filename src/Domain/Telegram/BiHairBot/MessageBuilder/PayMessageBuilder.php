<?php
namespace App\Domain\Telegram\BiHairBot\MessageBuilder;

use App\Domain\Telegram\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\ButtonDto;
use App\Service\Telegram\MessageBuilderInterface;
use App\Service\Telegram\MessageDto;
use App\Service\Telegram\UpdateDto;

class PayMessageBuilder implements MessageBuilderInterface
{
    public const EVENT = '/pay';

    private const MESSAGE_TEXT = 'Оплатить курс можно двумя способами:
ЕРИП: 
ЕРИП → “Банковские, финансовые услуги” → “Банки и НКФО” → “Приорбанк” → “Пополнение счета” → BY10PJCB30140010095253346933

Перевод на карту:
4916989691008956
NASTASSIA BILALOVA
06/26

Для записи на курс отправьте скрин чека в директ
';

    /**
     * @param UpdateDto $update
     * @return MessageDto[]|\Generator
     */
    public function build(UpdateDto $update): \Generator
    {
        yield new MessageDto(
            $update->getChatId(),
            self::MESSAGE_TEXT,
            [new ButtonDto('Директ Instagram', url: 'https://www.instagram.com/bihair__')]
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
        return $type === self::EVENT && $botName === BiHairBotProvider::BOT_NAME;
    }
}
