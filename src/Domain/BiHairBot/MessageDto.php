<?php
namespace App\Domain\BiHairBot;

readonly class MessageDto
{
    public function __construct(
        private string $text,
    ) {
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
