<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\File\StoreFileRequest;
use App\Http\Requests\Api\v1\File\UpdateFileRequest;
use App\Models\File;

final class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\Response
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request): \Illuminate\Http\Response
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file): \Illuminate\Http\Response
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileRequest $request, File $file): \Illuminate\Http\Response
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file): \Illuminate\Http\Response
    {
    }
}
