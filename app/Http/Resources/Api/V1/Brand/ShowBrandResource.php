<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1\Brand;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property string $title
 * @property string $slug
 * @property string $uuid
 * @property string $created_at
 * @property string $update_at
 */
final class ShowBrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable<string, string>|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            "uuid" => $this->uuid,
            "title" => $this->title,
            "slug" => $this->slug,
            "created_at" => $this->created_at,
            "updated_at" => $this->update_at,
        ];
    }
}
