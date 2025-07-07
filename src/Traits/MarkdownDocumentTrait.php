<?php

declare(strict_types=1);

namespace Bfg\MarkdownGenerator\Traits;

use Bfg\MarkdownGenerator\Services\MarkdownService;

trait MarkdownDocumentTrait
{
    private MarkdownService $markdown;

    public function md(): MarkdownService
    {
        if (! isset($this->markdown)) {
            $this->markdown = app(MarkdownService::class);
        }

        return $this->markdown;
    }
}
