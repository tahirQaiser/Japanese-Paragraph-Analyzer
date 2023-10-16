<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Home');
    }

    public function jishoApi($keyword): JsonResponse
    {
        $response = file_get_contents(env('JISHO_API_BASE_URL') . "/search/words?keyword=" . urlencode($keyword));
        return response()->json(['success' => true, 'data' => $response]);
    }

    public function processWords(Request $request): JsonResponse
    {
        $this->validate($request, [
            'words' => ['required', 'array']
        ]);

        $processed_words = [];
        $vocabulary_words = Vocabulary::query()->whereIn('word', $request->words)->get();
        foreach ($request->words as $word) {
            $response = file_get_contents(env('JISHO_API_BASE_URL') . "/search/words?keyword=" . urlencode($word));
            $response = json_decode($response, true);
            if ($response['meta']['status'] === 200) {
                $processed_words[] = [
                    'word' => $word,
                    'meaning' => $response['data'][0]['senses'][0]['english_definitions'],
                    'vocabulary' => $vocabulary_words->where('word', $word)->first()?->id ?? 0
                ];
            }
        }

        return response()->json(['success' => true, 'processed_words' => $processed_words]);
    }
}
