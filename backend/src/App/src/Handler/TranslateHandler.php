<?php

declare(strict_types=1);

namespace App\Handler;

use App\Exception\TranslationException;
use App\InputFilter\TranslateInputFilter;
use App\Service\TranslationService;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ValueError;

class TranslateHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly TranslationService $translationService,
        private readonly TranslateInputFilter $translateInputFilter,
    ) {
    }

    public function handle(ServerRequestInterface $request): JsonResponse
    {
        $this->translateInputFilter->setData($request->getParsedBody());

        if (! $this->translateInputFilter->isValid()) {
            return new JsonResponse(
                ['errors' => $this->translateInputFilter->getMessages()],
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY,
            );
        }

        $data = $this->translateInputFilter->getValues();

        try {
            $translated = $this->translationService->translate(
                $data['sourceLanguage'] === 'auto' ? null : $data['sourceLanguage'],
                $data['targetLanguage'],
                $data['input'],
            );
        } catch (TranslationException $translationException) {
            return new JsonResponse(
                ['error' => $translationException->getMessage()],
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY,
            );
        } catch (ValueError) {
            return new JsonResponse(
                ['error' => 'Invalid source/target language.'],
                StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY,
            );
        }

        return new JsonResponse([
            'sourceLanguage' => $data['sourceLanguage'],
            'targetLanguage' => $data['targetLanguage'],
            'input' => $data['input'],
            'output' => $translated,
        ]);
    }
}
