<?php

namespace App\Dtos;

class NewsCommentDto
{
    public function __construct(
        public readonly string $content,
        public readonly string $userName,
        public readonly string $slug,
    ) {
    }

    public static function fromRequest(string $content, string $slug, string $userName): self
    {
        return new self(
            content: $content,
            userName: $userName,
            slug: $slug,
        );
    }


}
