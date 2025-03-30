<?php

declare(strict_types=1);

namespace App\Handler;

use App\Enum\Language;
use App\Service\TranslationService;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function array_column;
use function array_filter;
use function array_map;

class GetAvailableTranslationsMatrixHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly TranslationService $translationService,
    ) {
    }

    public function handle(ServerRequestInterface $request): JsonResponse
    {
        return new JsonResponse(['matrix' => $this->buildTranslationMatrix()]);
    }

    private function buildTranslationMatrix(): array
    {
        return array_map(
            function (Language $sourceLanguage): array {
                return [
                    'source'  => $sourceLanguage->value,
                    'targets' => array_column(
                        array_filter(
                            Language::cases(),
                            fn(Language $targetLanguage) => $this->translationService->canTranslate(
                                $sourceLanguage,
                                $targetLanguage,
                            ),
                        ),
                        'value',
                    ),
                ];
            },
            Language::cases(),
        );
    }
}
