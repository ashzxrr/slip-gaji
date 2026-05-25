<?php

namespace App\Http\Controllers;

use App\Services\FlowkirimService;
use Illuminate\Http\Request;

class FlowkirimController extends Controller
{
    protected $flowkirim;

    public function __construct(FlowkirimService $flowkirim)
    {
        $this->flowkirim = $flowkirim;
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'number' => 'required|string',
            'message' => 'required|string',
        ]);

        $result = $this->flowkirim->sendMessage($data['number'], $data['message']);

        return response()->json(array_merge(['ok' => $result['ok']], $result['body'] ?? []), $result['status'] ?? 200);
    }
}
