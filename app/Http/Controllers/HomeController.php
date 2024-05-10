<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Math_BigInteger;
use phpseclib3\Crypt\RSA;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::where('id', auth()->id())->select([
            'id', 'name', 'email',
        ])->first();

        return view('home', [
            'user' => $user,
        ]);
    }

    public function messages(): JsonResponse
    {
        $messages = Message::with('user')->get()->append('time');
        Log::info($messages);
        foreach ($messages as $key => $value) {
            $value->text = RSAController::decRSA($value->text);
        }

        return response()->json($messages);
    }

    public function message(Request $request): JsonResponse
    {
        $text = $request->get('text');
        $textSave = RSAController::ecRSA($text);
        
        $message = Message::create([
            'user_id' => auth()->id(),
            'text' => $textSave,
        ]);

        SendMessage::dispatch($message);

        return response()->json([
            'success' => true,
            'message' => "Message created and job dispatched.",
        ]);
    }
}
