<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

final class CreateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'first_name' => 'string[]',
        'last_name' => 'string[]',
        'email' => 'string[]',
        'password' => 'string[]',
        'address' => 'string[]',
        'phone_number' => 'string[]',
        'is_marketing' => 'string[]',
        'avatar' => 'string[]',
    ])]
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'password' => ['required', 'confirmed', 'min:8'],
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'is_marketing' => ['nullable', 'boolean'],
            'avatar' => ['required', 'uuid', 'exists:files,uuid'],
        ];
    }
}
