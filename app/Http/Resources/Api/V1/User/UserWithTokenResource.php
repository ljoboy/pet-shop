<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1\User;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use PHPOpenSourceSaver\JWTAuth\Claims\JwtId;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTFactory;
use PHPOpenSourceSaver\JWTAuth\JWT;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;
use PHPOpenSourceSaver\JWTAuth\Token;

/**
 * @property mixed $id
 * @property mixed $uuid
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $email
 * @property mixed $address
 * @property mixed $phone_number
 * @property mixed $updated_at
 * @property mixed $created_at
 */
final class UserWithTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable<string, mixed>|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            "uuid" => $this->uuid,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "address" => $this->address,
            "phone_number" => $this->phone_number,
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
            "token" => auth()->attempt($request->only(['email', 'password']))
        ];
    }
}
