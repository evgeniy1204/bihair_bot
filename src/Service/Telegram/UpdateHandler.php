<?php

namespace App\Service\Telegram;

use LogicException;

class UpdateHandler
{

    /**
     * @param string $json
     * @return UpdateDto[]
     */
    public static function processUpdates(string $json): array
    {
        $updates = json_decode($json, true);
        if (!$updates['ok']) {
            return [];
        }
        $results = $updates['result'];
        $updatesDto = [];
        foreach ($results as $result) {
            $updatesDto[] = self::processUpdate($result);
        }

        return $updatesDto;
    }

    /**
     * @param array $result
     * @return UpdateDto
     */
    public static function processUpdate(array $result): UpdateDto
    {
        $callbackData = null;
        if ($result['callback_query'] ?? null) {
            $callbackData = $result['callback_query']['data'];

            return new UpdateDto(
                $result['update_id'], $result['callback_query']['message']['chat']['id'], $callbackData
            );
        }
        $chatId = $result['message']['chat']['id'] ?? null;
        $key = $callbackData ?? $result['message']['text'] ?? null;
        $id = $result['update_id'] ?? null;

        if ($id && $chatId && $key) {
            return new UpdateDto($id, $chatId, $key);
        }
        throw new LogicException();
    }


}