<?php

namespace App\Service\Telegram;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: self::BOT_PROVIDER)]
interface BotProviderInterface
{
    public const BOT_PROVIDER = 'bot_provider';

    /**
     * @return string
     */
    public function getToken(): string;

    /**
     * @return string
     */
    public function getName(): string;
}