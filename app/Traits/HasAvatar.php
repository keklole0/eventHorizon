<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;

trait HasAvatar
{
    public function processAvatar($file)
    {
        \Log::info('processAvatar called', ['user_id' => $this->id, 'file' => $file ? $file->getClientOriginalName() : null]);
        if (!$file || !$file->isValid()) {
            \Log::warning('processAvatar: file is not valid', ['user_id' => $this->id]);
            return null;
        }

        try {
            // Сохраняем оригинальный файл во временную директорию
            $tempPath = $file->store('temp/avatars', 'public');
            \Log::info('processAvatar: temp file stored', ['user_id' => $this->id, 'tempPath' => $tempPath]);
            // Синхронно обрабатываем и перемещаем аватар
            $this->optimizeAndMoveAvatar($tempPath);
            \Log::info('processAvatar: optimizeAndMoveAvatar called', ['user_id' => $this->id]);
            return $tempPath;
        } catch (\Exception $e) {
            \Log::error('Error processing avatar: ' . $e->getMessage(), ['user_id' => $this->id]);
            return null;
        }
    }

    protected function optimizeAndMoveAvatar($tempPath)
    {
        \Log::info('optimizeAndMoveAvatar called', ['user_id' => $this->id, 'tempPath' => $tempPath]);
        try {
            $fullTempPath = \Storage::disk('public')->path($tempPath);
            $manager = new \Intervention\Image\ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
            $image = $manager->read($fullTempPath)
                ->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->toJpeg(80);
            $filename = 'avatars/' . time() . '_' . uniqid() . '.jpg';
            \Storage::disk('public')->put($filename, (string) $image);
            \Storage::disk('public')->delete($tempPath);
            $this->update(['avatar' => $filename]);
            \Log::info('optimizeAndMoveAvatar: avatar updated', ['user_id' => $this->id, 'avatar' => $filename]);
        } catch (\Exception $e) {
            \Log::error('Error optimizing avatar: ' . $e->getMessage(), ['user_id' => $this->id]);
            \Storage::disk('public')->delete($tempPath);
        }
    }
} 