<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function handle(Request $request)
    {
        $message = strtolower($request->input('message', ''));

        // Rule-based redirection
        $redirectRules = [
            ['keywords' => ['car', 'cars', 'vehicle', 'auto'], 'page' => 'cars', 'route' => 'car.cars'],
            ['keywords' => ['contact', 'help', 'support'], 'page' => 'contact', 'route' => 'contact.form'],
            ['keywords' => ['register', 'sign up'], 'page' => 'register', 'route' => 'register'],
            ['keywords' => ['login', 'sign in'], 'page' => 'login', 'route' => 'login'],
            ['keywords' => ['home', 'main', 'start'], 'page' => 'home', 'route' => 'car.acceuil'],
        ];

        foreach ($redirectRules as $rule) {
            foreach ($rule['keywords'] as $keyword) {
                if (str_contains($message, $keyword)) {
                    return response()->json([
                        'message' => 'Sure! Taking you to the ' . $rule['page'] . ' page...',
                        'action' => 'redirect',
                        'url' => route($rule['route']),
                    ]);
                }
            }
        }

        // Rule-based greetings
        $greetingKeywords = ['hello', 'hi', 'hey'];
        foreach ($greetingKeywords as $keyword) {
            if (str_contains($message, $keyword)) {
                return response()->json(['message' => 'Hello! How can I help you today?']);
            }
        }

        // Default fallback response
        return response()->json(['message' => "I'm sorry, I don't quite understand. You can ask me to take you to pages like 'cars', 'contact', 'login', or 'register'."]);
    }
}

