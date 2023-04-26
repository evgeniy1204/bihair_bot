<?php
namespace App\Service\Telegram;

readonly class MessageDto
{
    /**
     * @param string      $chatId
     * @param string      $text
     * @param array       $inlineButtons
     * @param array       $keyboardButtons
     * @param string|null $photoId
     */
    public function __construct(
        private string $chatId,
        private string $text,
        private array $inlineButtons = [],
        private array $keyboardButtons = [],
        private ?string $photoId = null,
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
     * @return string
     */
    public function getChatId(): string
    {
        return $this->chatId;
    }

    /**
     * @return ButtonDto[]
     */
    public function getInlineButtons(): array
    {
        return $this->inlineButtons;
    }

    /**
     * @return array
     */
    public function buildInlineButtons(): array
    {
        $buttons = [];
        foreach ($this->getInlineButtons() as $button) {
            $buttonData = [
                'text' => $button->getText(),
                'callback_data' => $button->getCallbackData(),
            ];
            if ($button->getUrl()) {
                $buttonData['url'] = $button->getUrl();
            }
            $buttons[] = $buttonData;
        }

        return [$buttons];
    }

    /**
     * @return array[]
     */
    private function buildKeyboardButton(): array
    {
        $buttons = [];
        foreach ($this->getKeyboardButtons() as $button) {
            $buttons[] = [
                'text' => $button->getText(),
            ];
        }

        return [$buttons];
    }

    /**
     * @return array
     */
    public function buildMarkUp(): array
    {
        $markUp = [
            'inline_keyboard' => $this->buildInlineButtons(),
            'is_persistent' => true,
            'resize_keyboard' => true,
        ];
        if ($this->getKeyboardButtons()) {
            $markUp['keyboard'] = $this->buildKeyboardButton();
        }

        return $markUp;
    }

    /**
     * @return array
     */
    public function getKeyboardButtons(): array
    {
        return $this->keyboardButtons;
    }

    /**
     * @return string|null
     */
    public function getPhotoId(): ?string
    {
        return $this->photoId;
    }
}
