<?php

declare(strict_types=1);

namespace Bfg\MarkdownGenerator;

use Bfg\MarkdownGenerator\Traits\MarkdownDocumentTrait;

/**
 * Class MarkdownDocument
 *
 * This class provides a base for creating markdown documents.
 * It uses the MarkdownDocumentTrait to access the MarkdownService.
 *
 * @package Bfg\MarkdownGenerator
 * @mixin \Bfg\MarkdownGenerator\Services\MarkdownService
 */
abstract class MarkdownDocument
{
    use MarkdownDocumentTrait;

    public function __call(string $name, array $arguments)
    {
        if (method_exists($this->md(), $name)) {
            return $this->md()->{$name}(...$arguments);
        }

        throw new \BadMethodCallException("Method {$name} does not exist in MarkdownService.");
    }

    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }
}
