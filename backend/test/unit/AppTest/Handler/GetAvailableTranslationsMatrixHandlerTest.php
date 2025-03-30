<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Enum\Language;
use App\Handler\GetAvailableTranslationsMatrixHandler;
use App\Service\TranslationService;
use Laminas\Diactoros\Response\JsonResponse;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class GetAvailableTranslationsMatrixHandlerTest extends TestCase
{
    private readonly TranslationService&MockInterface $translationService;

    private readonly ServerRequestInterface&MockInterface $mockRequest;
    private readonly GetAvailableTranslationsMatrixHandler $handler;

    protected function setUp(): void
    {
        $this->translationService = Mockery::mock(TranslationService::class);
        $this->mockRequest = Mockery::mock(ServerRequestInterface::class);
        $this->handler = new GetAvailableTranslationsMatrixHandler(
            translationService: $this->translationService,
        );
    }

    public function testWhenHandlerIsCalledThenTheMatrixIsReturned(): void
    {
        // Given
        $this->translationService->expects('canTranslate')->andReturnUsing(
            function (Language $source, Language $target): bool {
                return $source !== $target
                    && (
                        $source === Language::HUMAN
                        || $target === Language::PARROT
                        || ($source === Language::PARROT && $target === Language::HUMAN)
                    );
            },
        );

        // When
        $response = $this->handler->handle($this->mockRequest);

        // Then
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode(
                [
                    'matrix' => [
                        [
                            'source' => 'human',
                            'targets' => ['labrador', 'poodle', 'parrot', 'parakeet'],
                        ],
                        [
                            'source' => 'labrador',
                            'targets' => ['parrot'],
                        ],
                        [
                            'source' => 'poodle',
                            'targets' => ['parrot'],
                        ],
                        [
                            'source' => 'parrot',
                            'targets' => ['human'],
                        ],
                        [
                            'source' => 'parakeet',
                            'targets' => ['parrot'],
                        ],
                    ],
                ],
            ),
            actualJson: $response->getBody()->getContents(),
        );
    }
}
