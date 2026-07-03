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

        $ok = $this->flowkirim->sendText($data['number'], $data['message']);

        return response()->json(['ok' => $ok], $ok ? 200 : 500);
    }
}
