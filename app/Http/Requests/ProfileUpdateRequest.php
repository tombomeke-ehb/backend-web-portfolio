<?php

namespace App\Http\Requests;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $maxKb = 2048;
        $allowedMimes = ['jpg', 'jpeg', 'png', 'webp'];

        // If site_settings exists, allow overriding upload rules from Admin > Site Settings
        if (Schema::hasTable('site_settings')) {
            $maxKb = (int) SiteSetting::get('max_avatar_upload_kb', $maxKb);

            $raw = (string) SiteSetting::get('allowed_avatar_mimes', implode(',', $allowedMimes));
            $allowedMimes = array_values(array_filter(array_map('trim', explode(',', $raw))));
            if (empty($allowedMimes)) {
                $allowedMimes = ['jpg', 'jpeg', 'png', 'webp'];
            }
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'birthday' => ['nullable', 'date'],
            'about' => ['nullable', 'string', 'max:2000'],

            // Avatar upload: keep it simple and predictable.
            // - Max size: configurable (default 2MB)
            // - Allowed types: configurable (default jpg/jpeg/png/webp)
            // NOTE: We don't enforce pixel dimensions, but the UI should communicate file-size limits.
            'profile_photo' => ['nullable', 'image', 'max:' . $maxKb, 'mimes:' . implode(',', $allowedMimes)],
        ];
    }
}
