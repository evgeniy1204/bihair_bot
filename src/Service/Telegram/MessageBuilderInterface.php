<?php

namespace App\Service\Telegram;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: self::TAG)]
interface MessageBuilderInterface
{
    public const TAG = 'message.builder.tag';

    /**
     * @param UpdateDto $update
     *
     * @return MessageDto[]|\Generator
     */
    public function build(UpdateDto $update): \Generator;

    /**
     * @param string $type
     * @param string $botName
     *
     * @return bool
     */
    public function supports(string $type, string $botName): bool;
}