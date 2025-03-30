<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Adapter\TranslationAdapterInterface;

readonly class TranslationAdaptersCollection
{
    /**
     * @param TranslationAdapterInterface[] $translationAdapters
     */
    public function __construct(
        public array $translationAdapters,
    ) {
    }
}
