<?php
namespace App\Domain\BiHairBot;

readonly class MessageDto
{
    /**
     * @param string $text
     */
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
