<?php

namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\MessageDto;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: self::TAG)]
interface MessageBuilderInterface
{
    public const TAG = 'message.builder.tag';

    /**
     * @return MessageDto
     */
    public function build(): MessageDto;

    /**
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool;
}