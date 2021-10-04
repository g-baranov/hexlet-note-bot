<?php

namespace App\Controller;

use App\Service\NoteService;
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
    public function webhook(Request $request, WebhookFetcherInterface $webhookFetcher, NoteService $noteService): JsonResponse
    {
        $update = $webhookFetcher->fetch($request->getContent());

        $noteService->add($update->message->chat->id, $update->message->text);

        return new JsonResponse([]);
    }
}