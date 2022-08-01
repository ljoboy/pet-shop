<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\File;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class StoreFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>>
     */
    #[ArrayShape(['file' => "string[]"])]
    public function rules(): array
    {
        return [
            'file' => ['required', 'file']
        ];
    }
}
