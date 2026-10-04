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
    public function captcha()
    {
        $a = rand(1, 9);
        $b = rand(1, 9);

        $captchaId = Str::uuid()->toString();

        Cache::put(
            'contact_captcha_' . $captchaId,
            $a + $b,
            now()->addMinutes(10)
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
            'email' => 'required|email|max:255',
            'no_telp' => 'required|string|max:20',
            'isi' => 'required|string',
            'captcha_id' => 'required|string',
            'captcha_answer' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Retrieve CAPTCHA answer from cache
        $cacheKey = 'contact_captcha_' . $request->captcha_id;
        $correctAnswer = Cache::get($cacheKey);

        if ($correctAnswer === null) {
            return response()->json([
                'success' => false,
                'message' => 'CAPTCHA has expired. Please reload the page.',
            ], 422);
        }

        // Verify answer
        if ((int) $request->captcha_answer !== (int) $correctAnswer) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect CAPTCHA answer.',
            ], 422);
        }

        // CAPTCHA correct -> delete so it cannot be reused
        Cache::forget($cacheKey);

        // Save to database
        $contact = Kontak::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'isi' => $request->isi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully. We will contact you shortly.',
            'data' => $contact,
        ], 201);
    }
}
