<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\File\StoreFileRequest;
use App\Http\Resources\Api\V1\File\FileResource;
use App\Models\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Str;

final class FileApiController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request): FileResource
    {
        $uploadedFile = $request->file;
        $path = $uploadedFile->store('public/pet-shop');
        $file = File::create([
            'name' => Str::random(),
            'path' => $path,
            'size' => $uploadedFile->getSize(),
            'type' => $uploadedFile->getMimeType(),
        ]);

        return new FileResource($file);
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file): Response
    {
        return response(Storage::get($file->path), 200)->header('Content-Type', $file->type);
    }

}