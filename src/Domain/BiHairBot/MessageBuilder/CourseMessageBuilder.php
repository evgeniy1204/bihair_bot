<?php
namespace App\Domain\BiHairBot\MessageBuilder;

use App\Domain\BiHairBot\BiHairBotEvents;
use App\Domain\BiHairBot\BiHairBotProvider;
use App\Service\Telegram\ButtonDto;
use App\Service\Telegram\MessageBuilderInterface;
use App\Service\Telegram\MessageDto;

class CourseMessageBuilder implements MessageBuilderInterface
{
    private const MESSAGE_TEXT = 'На курсе только самая нужная и работающая, информация по уходу за волосами и кожей головы. 
Один курс - полное понимание что делать с волосами в любой ситуации: 
✅ Никакого тупняка в магазине перед полками - сразу видите работающие банки.
✅ Не будет неудачных стрижек и окрашиваний - я научу понимать, что подойдет вашим волосам, а что покалечит
✅ Со мной вылечим перхоть, остановим выпадение волос, отрастим длину
🗓Готовый список проверенных средств для волос под любые запросы и инструментов от расчески до фена

🎁 Гайд-конспект краткой информации с курса для вашего удобства - остается с вами навсегда
🎁 Обратная связь после каждого урока в удобном для каждой ученицы формате -видео созвон, голосовые смс, переписка.

Формат: онлайн вебинары 
Доступ к курсу: 3 месяца (можно продлить)

Всю актуальную информацию о стоимости курса можно узнать в канале с бесплатным пробным уроком. Переходи по ссылке!
';
    /**
     * @param string $chatId
     *
     * @return MessageDto[]|\Generator
     */
    public function build(string $chatId): \Generator
    {
        yield new MessageDto(
            $chatId,
            self::MESSAGE_TEXT,
            [
                new ButtonDto('Оплатить', 'pay'),
                new ButtonDto('Бесплатный пробный урок', url: 'https://t.me/+bO_WDt_T-bxhY2Ji')
            ],
        );
    }

    /**
     * @param string $type
     * @param string $botName
     *
     * @return bool
     */
    public function supports(string $type, string $botName): bool
    {
        return $type === BiHairBotEvents::COURSE && $botName === BiHairBotProvider::BOT_NAME;
    }
}
