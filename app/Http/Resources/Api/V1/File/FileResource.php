<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1\File;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

/**
 * @property string $uuid
 * @property string $name
 * @property string $path
 * @property string $type
 * @property int $size
 * @property string $created_at
 * @property string $updated_at
 */
final class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable<string, string|int>|JsonSerializable
     */
    #[ArrayShape([
        'uuid' => "string",
        'name' => "string",
        'path' => "string",
        'type' => "string",
        'size' => "int",
        'created_at' => "string",
        'updated_at' => "string"
    ])]
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'path' => $this->path,
            'type' => $this->type,
            'size' => $this->size,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
