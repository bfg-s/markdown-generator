<?php

declare(strict_types=1);

namespace Bfg\MarkdownGenerator\Support;

use Bfg\MarkdownGenerator\AnonymousMarkdownDocument;

class Markdown
{
    /**
     * @var array<string, \Bfg\MarkdownGenerator\AnonymousMarkdownDocument>
     */
    protected static array $documents = [];

    public static function anonymous(): AnonymousMarkdownDocument
    {
        return AnonymousMarkdownDocument::make();
    }

    public static function from(string $name): AnonymousMarkdownDocument
    {
        if (isset(static::$documents[$name])) {
            return static::$documents[$name];
        }

        return static::$documents[$name] = AnonymousMarkdownDocument::make()
            ->setName($name);
    }

    public static function __callStatic(string $name, array $arguments)
    {
        return static::from($name);
    }

    public static function download(string $name, string|null $fileName = null): \Illuminate\Http\Response
    {
        return static::from($name)->download($fileName ?: $name);
    }
}
