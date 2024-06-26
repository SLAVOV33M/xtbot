<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Bot;
use App\Models\Minrank;
use App\Models\Command;
use Illuminate\Support\Facades\DB;


class MinrankController extends Controller
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

    public function showMinrankForm()
    {
        $minranks = Minrank::pluck('name', 'level')->toArray();
        $bcms = DB::table('commands')
            ->leftJoin('bot_command_minrank', function ($leftjoin) {
                $leftjoin->on('bot_command_minrank.command_id', '=', 'commands.id')
                    ->on('bot_command_minrank.bot_id', '=', DB::raw(Session('onBotEdit')));
            })
            ->leftjoin('minranks', 'bot_command_minrank.minrank_id', '=', 'minranks.id')
            ->orderBy('commands.name', 'ASC')
            ->select(
                'bot_command_minrank.id',
                'minranks.level',
                'commands.name',
                'commands.default_level',
                'commands.id as command_id'
            )->get();

        return view('bot.minrank')
            ->with('minranks', $minranks)
            ->with('bcms', $bcms);
    }

    public function editMinrank(Request $request)
    {
        $data = $request->all();

        if ($data['bcm_id'] == null) {
            $rules = [
                'level' => 'integer|required',
                'command_id' => 'integer|required',
            ];

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'You are trying to cheat!'
                    ]
                );
            }

            $bot = Bot::find(Session('onBotEdit'));
            $minrank = DB::table('minranks')
                ->where('level', $data['level'])
                ->get()[0];

            $command = Command::find($data['command_id']);
            $bot->commands()->save($command, ['minrank_id' => $minrank->id]);

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Minrank updated!'
                ]
            );
        } else {
            $rules = [
                'bcm_id' => 'integer|required',
                'level' => 'integer|required',
                'command_id' => 'integer|required',
            ];

            $validator = Validator::make($data, $rules);

            $validator->after(
                function ($validator) use ($data) {
                    if (!empty($data['bcm_id'])) {
                        if (!$data['bcm_id']) {
                            $res = DB::table('bot_command_minrank')
                                ->where('bot_id', Session('onBotEdit'))
                                ->where('id', $data['bcm_id'])
                                ->select('id')
                                ->get();

                            if (empty($res)) {
                                $validator->errors()->add('bcm_id', 'Cheater!');
                            }
                        }
                    }
                }
            );

            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'You are trying to cheat!'
                    ]
                );
            }

            $bot = Bot::find(Session('onBotEdit'));
            $minrank = DB::table('minranks')
                ->where('level', $data['level'])
                ->get()[0];

            $bot->commands()->updateExistingPivot($data['command_id'], ['minrank_id' => $minrank->id]);

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Minrank updated!'
                ]
            );
        }
    }
}
