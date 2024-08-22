<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;
use Illuminate\Support\Facades\Storage;

class SettingRepository
{
    public function __construct(
        protected Setting $setting
    ) {}

    public function get()
    {
        return $this->setting->first();
    }

    public function createOrUpdate(array $data)
    {
        $photo = $data['receipt_logo'];
        if (!is_null($photo) && !($photo instanceof UploadedFile)) {
            throw new InvalidArgumentException('Photo must be an uploaded file');
        }

        $path = null;
        if (!is_null($photo)) {
            unset($data['receipt_logo']);
            $fileName = uniqid('logo_') . '.' . $photo->getClientOriginalExtension();
            $path = Storage::putFileAs('public/setting', $photo, $fileName);
        }


        $setting = $this->setting->first();

        if ($setting) {
            return $setting->update([...$data, 'receipt_logo' => $path]);
        }

        return $this->setting->create([...$data, 'receipt_logo' => $path]);
    }
}
