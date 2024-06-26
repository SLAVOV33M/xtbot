<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Utilities\Xat;
use Illuminate\Http\Request;
use App\Models\Bot;
use App\Utilities\Powers;


class TakenController extends Controller
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

    public function show()
    {
        return view('bot.taken');
    }

    public function check(Request $request)
    {
        $data = $request->all();

        $rules = [
            'chatname' => 'max:255|required',
            'chatpw' => 'max:255|required'
        ];

        $validator = Validator::make($data, $rules);

        $data['chatname'] = str_replace([' ', 'xat.com/', 'https://', 'http://'], ['_', '', '', ''], $data['chatname']);
        $data['chatid'] = Xat::isChatExist($data['chatname']);
        $validator->after(
            function ($validator) use ($data) {
                if (!empty($data['chatname'])) {
                    if (!$data['chatid']) {
                        $validator->errors()->add('chatname', 'This chat does not exist!');
                    }
                }
            }
        );

        if ($validator->fails()) {
            return redirect()
                ->route('panel')
                ->withErrors($validator)
                ->withInput();
        }

        $getmain = Xat::getMain($data['chatname'], $data['chatpw']);
        if (is_numeric($getmain)) {
            $bot = Bot::where('chatid', $data['chatid'])->first();

            if (empty($bot)) {
                return redirect()
                    ->route('panel')
                    ->withError('This chat does not have a bot yet. You can create it!');
            }

            $bot->creator_user_id = Auth::user()->id;
            $bot->users()->detach();
            $bot->users()->attach(Auth::user()->id);
            $bot->save();
            return redirect()
                ->route('panel')
                ->withSuccess('This bot is now moved to your account!');
        } else {
            return redirect()
                ->route('panel')
                ->withErrors($getmain);
        }
    }
}
