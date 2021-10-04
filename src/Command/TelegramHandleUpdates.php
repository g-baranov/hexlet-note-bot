<?php

namespace App\Command;

use App\Service\NoteService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TgBotApi\BotApiBase\BotApiInterface;
use TgBotApi\BotApiBase\Method\GetUpdatesMethod;

class TelegramHandleUpdates extends Command
{
    private $botApi;
    private NoteService $noteService;

    public function __construct(BotApiInterface  $botApi, NoteService $noteService, string $name = null)
    {
        parent::__construct($name);
        $this->botApi = $botApi;
        $this->noteService = $noteService;
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'telegram:handle-updates';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
//        $this->botApi->delete(DeleteWebhookMethod::create());

        $storageFilePath = __DIR__ . '/../../lastUpdateId.txt';
        $lastUpdateId = file_get_contents($storageFilePath);

        $method = GetUpdatesMethod::create(['offset' => $lastUpdateId + 1]);
        $updates = $this->botApi->getUpdates($method);
        $updatesCount = count($updates);

        foreach ($updates as $update) {
            $this->noteService->add($update->message->chat->id, $update->message->text);

            file_put_contents($storageFilePath, $update->updateId);
        }

        $output->writeln("Обработано: {$updatesCount}");
        return Command::SUCCESS;
    }
}