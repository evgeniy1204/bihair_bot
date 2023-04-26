<?php
namespace App\Domain\BiHairBot;

readonly class UpdateDto
{
    /**
     * @param int    $updateId
     * @param string $chatId
     * @param string $key
     */
    public function __construct(
        private int $updateId,
        private string $chatId,
        private string $key,
    ) {
    }

    /**
     * @return string
     */
    public function getChatId(): string
    {
        return $this->chatId;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return int
     */
    public function getUpdateId(): int
    {
        return $this->updateId;
    }
}
