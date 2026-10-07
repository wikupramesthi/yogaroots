<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    private const CAPTCHA_TTL_MINUTES = 10;
    private const CAPTCHA_MAX_ATTEMPTS = 3;

    public function captcha()
    {
        $a = random_int(1, 20);
        $b = random_int(1, 20);

        $captchaId = Str::uuid()->toString();

        Cache::put(
            'contact_captcha_' . $captchaId,
            ['answer' => $a + $b, 'attempts' => 0],
            now()->addMinutes(self::CAPTCHA_TTL_MINUTES)
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'captcha_id' => $captchaId,
                'question' => "How much is the result of {$a} + {$b}?"
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email:rfc|max:255',
            'no_telp' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{6,20}$/'],
            'isi' => 'required|string|max:5000',
            'captcha_id' => 'required|uuid',
            'captcha_answer' => 'required|integer|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $cacheKey = 'contact_captcha_' . $request->input('captcha_id');
        $captcha = Cache::get($cacheKey);

        if (! is_array($captcha) || ! isset($captcha['answer'])) {
            return response()->json([
                'success' => false,
                'message' => 'CAPTCHA has expired. Please reload the page.',
            ], 422);
        }

        if ((int) $request->input('captcha_answer') !== (int) $captcha['answer']) {
            $captcha['attempts'] = ($captcha['attempts'] ?? 0) + 1;

            if ($captcha['attempts'] >= self::CAPTCHA_MAX_ATTEMPTS) {
                Cache::forget($cacheKey);
            } else {
                Cache::put($cacheKey, $captcha, now()->addMinutes(self::CAPTCHA_TTL_MINUTES));
            }

            return response()->json([
                'success' => false,
                'message' => 'Incorrect CAPTCHA answer.',
            ], 422);
        }

        Cache::forget($cacheKey);

        Kontak::create([
            'nama' => strip_tags((string) $request->input('nama')),
            'email' => (string) $request->input('email'),
            'no_telp' => (string) $request->input('no_telp'),
            'isi' => strip_tags((string) $request->input('isi')),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully. We will contact you shortly.',
        ], 201);
    }
}
