<?php

declare(strict_types=1);

namespace Bfg\MarkdownGenerator\Services;

class MarkdownService
{
    protected string $document = "";

    protected string|null $name = null;

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function h1(string $title): static
    {
        return $this->line(PHP_EOL, "# ", $title);
    }

    public function h2(string $title): static
    {
        return $this->line(PHP_EOL, "## ", $title);
    }

    public function h3(string $title): static
    {
        return $this->line(PHP_EOL, "### ", $title);
    }

    public function h4(string $title): static
    {
        return $this->line(PHP_EOL, "#### ", $title);
    }

    public function h5(string $title): static
    {
        return $this->line(PHP_EOL, "##### ", $title);
    }

    public function h6(string $title): static
    {
        return $this->line(PHP_EOL, "###### ", $title);
    }

    /**
     * Add a code block to the prompt.
     *
     * @param  string  $code
     * @param  string|null  $language
     * @return $this
     */
    public function code(string $code, string|null $language = null): static
    {
        $languagePrefix = $language ? $language . PHP_EOL : '';
        $this->line("```", $languagePrefix, $code, PHP_EOL, "```");
        return $this;
    }

    public function jsonCode(array $array): static
    {
        $code = json_encode($array, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_FORCE_OBJECT);
        return $this->code($code, 'json');
    }

    /**
     * Add a horizontal rule to the prompt.
     *
     * @return $this
     */
    public function hr(): static
    {
        return $this->line("---");
    }

    /**
     * Add a bullet list to the prompt.
     *
     * @param  array  $items
     * @return $this
     */
    public function bulletList(array $items): static
    {
        foreach ($items as $index => $item) {
            $title = is_numeric($index) ? "" : $this->inlineCode($index) . ": ";
            $item = is_array($item) ? json_encode($item, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_FORCE_OBJECT) : $item;
            $item = is_string($item) && ! str_ends_with($item, ".") ? $item . "." : $item;
            $this->line("- ", $title, $item);
        }
        return $this;
    }

    /**
     * Add a numbered list to the prompt.
     *
     * @param  array  $items
     * @return $this
     */
    public function numberedList(array $items): static
    {
        $iteration = 1;
        foreach ($items as $index => $item) {
            $title = is_numeric($index) ? "" : $this->inlineBold($index) . ": ";
            $item = is_array($item) ? json_encode($item, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_FORCE_OBJECT) : $item;
            $item = is_string($item) && ! str_ends_with($item, ".") ? $item . "." : $item;
            $this->line($iteration, ". ", $title, $item);
            $iteration++;
        }
        return $this;
    }

    public function dotList(array $items): static
    {
        foreach ($items as $index => $item) {
            $title = is_numeric($index) ? "" : $this->inlineCode($index) . ": ";
            $item = is_array($item) ? json_encode($item, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_FORCE_OBJECT) : $item;
            $item = is_string($item) && ! str_ends_with($item, ".") ? $item . "." : $item;
            $this->line("* ", $title, $item);
        }
        return $this;
    }

    /**
     * Add a blockquote to the prompt.
     *
     * @param  string  $text
     * @return $this
     */
    public function blockquote(string $text): static
    {
        return $this->line("> ", $text);
    }

    public function alert(string $title, string $text): static
    {
        return $this->blockquote("**$title:** $text");
    }

    public function warning(string $text): static
    {
        return $this->alert('Warning', $text);
    }

    public function error(string $text): static
    {
        return $this->alert('Error', $text);
    }

    public function info(string $text): static
    {
        return $this->alert('Info', $text);
    }

    public function success(string $text): static
    {
        return $this->alert('Success', $text);
    }

    /**
     * Add a link to the prompt.
     *
     * @param  string  $text
     * @param  string  $url
     * @return $this
     */
    public function link(string $text, string $url): static
    {
        return $this->line("[", $text, "](", $url, ")");
    }

    /**
     * Add an image to the prompt.
     *
     * @param  string  $alt
     * @param  string  $url
     * @return $this
     */
    public function image(string $alt, string $url): static
    {
        return $this->line("![", $alt, "](", $url, ")");
    }

    /**
     * Add a table to the prompt.
     *
     * @param  array  $headers
     * @param  array  $rows
     * @return $this
     */
    public function table(array $headers, array $rows): static
    {
        // Add headers
        $this->line("| ", implode(" | ", $headers), " |");

        // Add separator
        $this->line("|", str_repeat(" --- |", count($headers)));

        // Add rows
        foreach ($rows as $row) {
            $this->line("| ", implode(" | ", $row), " |");
        }

        return $this;
    }

    /**
     * Add line to the prompt.
     *
     * @param  mixed  ...$line
     * @return $this
     */
    public function line(...$line): static
    {
        $this->document .= rtrim(implode('', $line), PHP_EOL) . PHP_EOL;
        return $this;
    }

    public function lines(array $lines): static
    {
        foreach ($lines as $index => $line) {
            $title = is_numeric($index) ? "" : $this->inlineBold($index) . ": ";
            $this->line($title, $line);
        }
        return $this;
    }

    /**
     * Add a paragraph to the prompt.
     *
     * @param  string  $text
     * @return $this
     */
    public function paragraph(string $text): static
    {
        return $this->line($text);
    }

    /**
     * Add a bold text to the prompt.
     *
     * @param  string  $text
     * @return $this
     */
    public function bold(string $text): static
    {
        return $this->line($this->inlineBold($text));
    }

    /**
     * Add an italic text to the prompt.
     *
     * @param  string  $text
     * @return $this
     */
    public function italic(string $text): static
    {
        return $this->line($this->inlineItalic($text));
    }

    /**
     * Add a strikethrough text to the prompt.
     *
     * @param  string  $text
     * @return $this
     */
    public function strikethrough(string $text): static
    {
        return $this->line($this->inlineStrikethrough($text));
    }

    public function inlineCode(string $text): string
    {
        return sprintf("`%s`", $text);
    }

    public function inlineBold(string $text): string
    {
        return sprintf("**%s**", $text);
    }

    public function inlineItalic(string $text): string
    {
        return sprintf("*%s*", $text);
    }

    public function inlineStrikethrough(string $text): string
    {
        return sprintf("~~%s~~", $text);
    }

    /**
     * Get the generated Markdown document.
     *
     * @return string
     */
    public function getDocument(): string
    {
        return trim($this->document, PHP_EOL);
    }

    public function __toString(): string
    {
        return $this->getDocument();
    }

    public function download(string|null $fileName = null): \Illuminate\Http\Response
    {
        return response($this->getDocument())
            ->header('Content-Type', 'text/markdown')
            ->header('Content-Disposition', 'attachment; filename="' . $this->fileName($fileName) . '"');
    }

    public function fileName(string|null $fileName = null): string
    {
        $fileName = $fileName ?: (
            $this->name ?: trim(trim(explode("\n", $this->getDocument())[0], "#"))
        );
        return str_ends_with($fileName, '.md') ? $fileName : $fileName . '.md';
    }
}
