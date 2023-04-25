<?php

 namespace App\Service\Telegram;

 readonly class UpdateDto
{
    private int $updateId;
    private int $userId;
    private string|null $text;

    /**
     * @param int $updateId
     * @param int $userId
     * @param string|null $text
     */
    public function __construct(int $updateId, int $userId, ?string $text)
    {
        $this->updateId = $updateId;
        $this->userId = $userId;
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }


}