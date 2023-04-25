<?php
namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotEvents;
use App\Domain\BiHairBot\MessageDto;

class StartMessageBuilder implements MessageBuilderInterface
{
    /**
     * @return MessageDto
     */
    public function build(): MessageDto
    {
        return new MessageDto('hello');
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool
    {
        return $type === BiHairBotEvents::START;
    }
}
