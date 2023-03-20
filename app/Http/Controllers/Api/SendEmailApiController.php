<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;

class SendEmailApiController extends Controller
{
    public function send(Request $request)
    {
        // Dispatch the job to send the email
        SendEmailJob::dispatch($request->all());

        return response()->json(['message' => 'Result sent successfully!']);
    }
}
