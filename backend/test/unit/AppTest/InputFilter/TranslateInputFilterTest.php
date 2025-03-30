<?php

declare(strict_types=1);

namespace AppTest\InputFilter;

use App\InputFilter\TranslateInputFilter;
use PHPUnit\Framework\TestCase;

class TranslateInputFilterTest extends TestCase
{
    private readonly TranslateInputFilter $inputFilter;

    protected function setUp(): void
    {
        $this->inputFilter = new TranslateInputFilter();
        $this->inputFilter->init();
    }

    public function testGivenInvalidInputThenAnErrorIsReturned(): void
    {
        // Given
        $this->inputFilter->setData(['foo' => 'bar']);

        // When
        $isValid = $this->inputFilter->isValid();
        $messages = $this->inputFilter->getMessages();

        // Then
        $this->assertFalse($isValid);
        $this->assertSame(
            expected: [
                'sourceLanguage' => [
                    'isEmpty' => 'Value is required and can\'t be empty',
                ],
                'targetLanguage' => [
                    'isEmpty' => 'Value is required and can\'t be empty',
                ],
                'input' => [
                    'isEmpty' => 'Value is required and can\'t be empty',
                ],
            ],
            actual: $messages,
        );
    }
}
