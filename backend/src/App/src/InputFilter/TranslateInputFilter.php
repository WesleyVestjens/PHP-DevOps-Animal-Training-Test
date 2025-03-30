<?php

declare(strict_types=1);

namespace App\InputFilter;

use App\Enum\Language;
use App\Filter\EnumFilter;
use App\Validator\EnumValidator;
use App\Validator\SourceLanguageValidator;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;

class TranslateInputFilter extends InputFilter
{
    public function init(): void
    {
        $sourceLanguage = new Input(name: 'sourceLanguage');
        $sourceLanguage->setRequired(true)->setAllowEmpty(false);
        $sourceLanguage->getFilterChain()->attach(new EnumFilter(['enum' => Language::class]));
        $sourceLanguage->getValidatorChain()->attach(new SourceLanguageValidator());
        $this->add($sourceLanguage);

        $targetLanguage = new Input(name: 'targetLanguage');
        $targetLanguage->setRequired(true)->setAllowEmpty(false);
        $targetLanguage->getFilterChain()->attach(new EnumFilter(['enum' => Language::class]));
        $targetLanguage->getValidatorChain()->attach(new EnumValidator(['enum' => Language::class]));
        $this->add($targetLanguage);

        $input = new Input(name: 'input');
        $input->setRequired(true)->setAllowEmpty(false);
        /**
         * Validator chain with string length = 1 is not necessary, because string will evaluate to empty and fail
         * validation.
         */
        $this->add($input);
    }
}
