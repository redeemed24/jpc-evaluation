<?php

namespace App\Providers;

use Illuminate\Bus\Queueable;
use Storage;

class FileStorageProvider
{

	public static function generatePointsSettingsFile($data = []){

	    $content = [
	        'year' => isset($data['year']) ? $data['year'] : date('Y'),
	        'semester' => isset($data['semester']) ? $data['semester'] : '1st',
	    ];

	    $store = Storage::put('settings/admin_settings.txt', json_encode($content));

	    return $store;

	}

}
