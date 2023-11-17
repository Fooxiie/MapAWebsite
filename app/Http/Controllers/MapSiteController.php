<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyseAddress;
use Illuminate\Http\Request;

class MapSiteController extends Controller
{
    public function launchScan(Request $request) {
        $url = $request->get('urlToScan');
        AnalyseAddress::dispatch($url);
        dd($url);
        return response()->json(['message' => 'Requete Ajax traité']);
    }
}
