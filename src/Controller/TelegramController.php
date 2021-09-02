<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\UnicodeString;
use TgBotApi\BotApiBase\BotApiInterface;
use TgBotApi\BotApiBase\Method\SendMessageMethod;
use TgBotApi\BotApiBase\WebhookFetcherInterface;

class TelegramController extends AbstractController
{
    /**
     * @Route("/webhook", name="telegram_webhook")
     */
    public function webhook(Request $request, WebhookFetcherInterface $webhookFetcher, BotApiInterface $botApi): JsonResponse
    {
        $update = $webhookFetcher->fetch($request->getContent());

        $userText = new UnicodeString($update->message->text);
        $matches = $userText->match("/[\w\s]+#(\w+)+/");

var_dump($matches); die();

        $note = [
            'text' => '',
            'tags' => []
        ];
//        $note = [
//            'text' => '12312312',
//            'tags' => ['работа', 'отдых']
//        ];
        $text = '';

        $method = SendMessageMethod::create($update->message->chat->id, $text);
        $botApi->send($method);

        return new JsonResponse([]);
    }
}