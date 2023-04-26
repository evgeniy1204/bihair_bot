<?php
namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotEvents;
use App\Domain\BiHairBot\ButtonDto;
use App\Domain\BiHairBot\MessageDto;

class SpecialistsChatMessageBuilder implements MessageBuilderInterface
{
    private const MESSAGE_TEXT = 'Наш чат:';
    /**
     * @param string $chantId
     *
     * @return MessageDto[]|\Generator
     */
    public function build(string $chantId): \Generator
    {
        yield new MessageDto(
            $chantId,
            self::MESSAGE_TEXT,
            [new ButtonDto('Курим, парим и хуярим', url: 'https://t.me/+0_uO4FSSSp8zZWVi')]
        );
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool
    {
        return $type === BiHairBotEvents::SPECIALISTS_CHAT;
    }
}
