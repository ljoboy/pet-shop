<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1\User;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property string $uuid
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $address
 * @property string $phone_number
 * @property bool $is_marketing
 * @property string $created_at
 * @property string $updated_at
 * @property string $avatar
 */
final class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable<string, string|bool>|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'uuid' => $this->uuid,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'is_marketing' => $this->is_marketing,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'avatar' => $this->avatar,
        ];
    }
}
