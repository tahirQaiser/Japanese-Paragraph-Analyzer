<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\VocabularyRequest;
use Inertia\Inertia;

class VocabularyController extends Controller
{
    public function index()
    {
        $vocabularies = Vocabulary::all();
        return Inertia::render('Vocabularies', ['vocabularies' => $vocabularies]);
    }

    public function myVocabulary()
    {
        $vocabularies = [];
        if (Vocabulary::count() >= 4) {
            $vocabularies = Vocabulary::query()->inRandomOrder()->take(4)->get();
        }
        return Inertia::render('MyVocabulary', ['vocabularies' => $vocabularies]);
    }

    public function store(VocabularyRequest $vocabularyRequest): JsonResponse
    {
        $vocabulary = Vocabulary::query()->create($vocabularyRequest->only(['word', 'meaning']));
        if ($vocabulary) {
            return response()->json(['success' => true, 'vocabulary' => $vocabulary->id]);
        }
        return response()->json(['success' => false]);
    }

    public function destroy(Vocabulary $vocabulary): JsonResponse
    {
        if ($vocabulary->delete()) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
