<?php

namespace App\Dtos;

class NewsDto
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $content,
        public readonly ?string $images,
        public readonly ?string $category_id,
        public readonly ?string $user_id,
    )
    {
    }

    public static function fromRequest($data): self
    {
        return new self(
            title: $data?->title,
            content: $data?->content,
            images: $data?->images,
            category_id: $data?->category_id,
            user_id: $data?->user_id,
        );
    }

}
