<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class ArticleGeneratorController extends Controller
{
    // app/Http/Controllers/ArticleGenerator.php

    public function index(Request $input)
    {
        if ($input->title == null) {
            return;
        }

        $title = $input->title;
        $apiToken = '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';
        $client = OpenAI::client($apiToken);

        $result = $client->completions()->create([
            "model" => "text-davinci-003",
            "temperature" => 0.7,
            "top_p" => 1,
            "frequency_penalty" => 0,
            "presence_penalty" => 0,
            'max_tokens' => 600,
            'prompt' => sprintf('Write article about: %s', $title),
        ]);

        $content = trim($result['choices'][0]['text']);


        return view('write', compact('title', 'content'));
    }
}
