<?php
namespace App\Service\Telegram;

readonly class ButtonDto
{
    /**
     * @param string      $text
     * @param string|null $callbackData
     * @param string|null $url
     */
    public function __construct(
        private string $text,
        private ?string $callbackData = null,
        private ?string $url = null,
    ) {
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string|null
     */
    public function getCallbackData(): ?string
    {
        return $this->callbackData;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }
}
