<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Enum\Language;
use App\Exception\TranslationException;
use App\Handler\TranslateHandler;
use App\InputFilter\TranslateInputFilter;
use App\Service\TranslationService;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use ValueError;

class TranslateHandlerTest extends TestCase
{
    private readonly TranslationService&MockInterface $translationService;
    private readonly TranslateInputFilter&MockInterface $translateInputFilter;

    private readonly ServerRequestInterface&MockInterface $mockRequest;
    private readonly TranslateHandler $handler;

    protected function setUp(): void
    {
        $this->translationService = Mockery::mock(TranslationService::class);
        $this->translateInputFilter = Mockery::mock(TranslateInputFilter::class);
        $this->mockRequest = Mockery::mock(ServerRequestInterface::class);

        $this->handler = new TranslateHandler(
            translationService: $this->translationService,
            translateInputFilter: $this->translateInputFilter,
        );
    }

    public function testWhenGivenDataIsNotValidThenTheErrorsAreReturned(): void
    {
        // Given
        $bodyData = ['body'];

        $this->mockRequest->expects('getParsedBody')->andReturn($bodyData);
        $this->translateInputFilter->expects('setData')->with($bodyData);
        $this->translateInputFilter->expects('isValid')->andReturnFalse();
        $this->translateInputFilter->expects('getMessages')->andReturn([
            'sourceLanguage' => [
                'required' => 'Required',
            ],
            'targetLanguage' => [
                'required' => 'Required',
            ],
        ]);

        // When
        $response = $this->handler->handle($this->mockRequest);

        // Then
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode([
                'errors' => [
                    'sourceLanguage' => [
                        'required' => 'Required',
                    ],
                    'targetLanguage' => [
                        'required' => 'Required',
                    ],
                ],
            ]),
            actualJson: $response->getBody()->getContents(),
        );
    }

    public function testWhenTranslationFailsWithTranslationExceptionThenAnErrorIsReturned(): void
    {
        // Given
        $bodyData = [
            'sourceLanguage' => Language::HUMAN,
            'targetLanguage' => Language::PARROT,
            'input' => 'Translate me, please!',
        ];

        $this->mockRequest->expects('getParsedBody')->andReturn($bodyData);
        $this->translateInputFilter->expects('setData')->with($bodyData);
        $this->translateInputFilter->expects('isValid')->andReturnTrue();
        $this->translateInputFilter->shouldNotReceive('getMessages');
        $this->translateInputFilter->expects('getValues')->andReturn($bodyData);

        $translationException = TranslationException::becauseCannotTranslateFromOrToThisLanguage(
            Language::HUMAN,
            Language::PARROT,
        );
        $this->translationService->expects('translate')->with(
            Language::HUMAN,
            Language::PARROT,
            'Translate me, please!',
        )->andThrow($translationException);

        // When
        $response = $this->handler->handle($this->mockRequest);

        // Then
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode([
                'error' => $translationException->getMessage(),
            ]),
            actualJson: $response->getBody()->getContents(),
        );
    }

    public function testWhenTranslationFailsWithValueErrorThenAnErrorIsReturned(): void
    {
        // Given
        $bodyData = [
            'sourceLanguage' => Language::HUMAN,
            'targetLanguage' => Language::PARROT,
            'input' => 'Translate me, please!',
        ];

        $this->mockRequest->expects('getParsedBody')->andReturn($bodyData);
        $this->translateInputFilter->expects('setData')->with($bodyData);
        $this->translateInputFilter->expects('isValid')->andReturnTrue();
        $this->translateInputFilter->shouldNotReceive('getMessages');
        $this->translateInputFilter->expects('getValues')->andReturn($bodyData);

        $translationException = new ValueError('Invalid value');
        $this->translationService->expects('translate')->with(
            Language::HUMAN,
            Language::PARROT,
            'Translate me, please!',
        )->andThrow($translationException);

        // When
        $response = $this->handler->handle($this->mockRequest);

        // Then
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode([
                'error' => 'Invalid source/target language.',
            ]),
            actualJson: $response->getBody()->getContents(),
        );
    }

    public function testWhenInputIsTranslatedThenTheOutputIsReturned(): void
    {
        // Given
        $bodyData = [
            'sourceLanguage' => Language::HUMAN,
            'targetLanguage' => Language::PARROT,
            'input' => 'Translate me, please!',
        ];

        $this->mockRequest->expects('getParsedBody')->andReturn($bodyData);
        $this->translateInputFilter->expects('setData')->with($bodyData);
        $this->translateInputFilter->expects('isValid')->andReturnTrue();
        $this->translateInputFilter->shouldNotReceive('getMessages');
        $this->translateInputFilter->expects('getValues')->andReturn($bodyData);

        $translationException = new ValueError('Invalid value');
        $this->translationService->expects('translate')->with(
            Language::HUMAN,
            Language::PARROT,
            'Translate me, please!',
        )->andReturn('Ik praat je na: Translate me, please!');

        // When
        $response = $this->handler->handle($this->mockRequest);

        // Then
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode([
                'sourceLanguage' => 'human',
                'targetLanguage' => 'parrot',
                'input' => 'Translate me, please!',
                'output' => 'Ik praat je na: Translate me, please!',
            ]),
            actualJson: $response->getBody()->getContents(),
        );
    }
}
