<?php

namespace App\Http\Controllers;

use App\Utils\AppAnalyser;
use Illuminate\Http\Request;

class MapSiteController extends Controller
{
    public function launchScan(Request $request)
    {
        $url = $request->get('urlToScan');
        $analyser = new AppAnalyser($url);
        $analyser->start_analyse();
        return view('welcome', [
            'fromUrl' => $url,
            'scan' => $analyser->getExternalDependencies()
        ]);
    }

    public function debugView()
    {
        return view('welcome', [
            'scan' => ['dada' => [], 'dodo' => ['dudu', 'dada']],
            'fromUrl' => 'tuconnais'
        ]);
    }
}
