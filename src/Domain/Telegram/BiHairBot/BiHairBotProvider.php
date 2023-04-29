<?php
namespace App\Domain\Telegram\BiHairBot;

use App\Service\Telegram\BotProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class BiHairBotProvider implements BotProviderInterface
{
    public const BOT_NAME = 'Bihair';

    /**
     * @var string
     */
    private string $token;

    /**
     * @param string $token
     */
    public function __construct(
        #[Autowire('%env(TG_BIHAIR_BOT_TOKEN)%')]
        string $token,
    ) {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::BOT_NAME;
    }
}
