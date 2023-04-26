<?php
namespace App\Command;

use App\Service\Telegram\TelegramBotManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'bihair:telegram:handle'
)]
class BiHairBotHandleTelegramCommand extends Command
{
    /**
     * @param TelegramBotManager $telegramBotManager
     */
    public function __construct(private readonly TelegramBotManager $telegramBotManager)
    {
        parent::__construct();
    }


    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        while (true) {
            $this->telegramBotManager->handle();
        }

        return Command::SUCCESS;
    }
}
