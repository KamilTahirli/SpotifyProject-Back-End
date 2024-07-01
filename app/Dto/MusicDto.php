<?php

namespace App\Dto;

use App\Http\Requests\Front\GetMusicDataRequest;
use App\Http\Requests\Front\SaveMusicToDbRequest;

class MusicDto
{
    /**
     * @var string
     */
    private string $musicId;

    /**
     * @var ?string
     */
    private ?string $musicName;

    /**
     * @var ?string
     */
    private ?string $musicUrl;

    /**
     * @var string|null
     */
    private ?string $createdAt;

    /**
     * @param GetMusicDataRequest|SaveMusicToDbRequest $request
     */
    public function __construct(GetMusicDataRequest|SaveMusicToDbRequest $request)
    {
        $this->musicId = $request->music_id;
        $this->musicName = $request->music_name;
        $this->musicUrl = $request?->music_url;
        $this->createdAt = $request->created_at;
    }

    /**
     * @return string
     */
    public function getMusicId(): string
    {
        return $this->musicId;
    }

    /**
     * @return ?string
     */
    public function getMusicUrl(): ?string
    {
        return $this->musicUrl;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return ?string
     */
    public function getMusicName(): ?string
    {
        return $this->musicName;
    }
}