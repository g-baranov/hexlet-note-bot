<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
        $update = $webhookFetcher->fetch($request);


        $method = SendMessageMethod::create($update->message->chat->id, 'TEST');
        $botApi->send($method);
        dd($update);
    }
}