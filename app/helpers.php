<?php
require_once (__DIR__.'/../vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php');

if (! function_exists('current_user')) {
    function current_user()
    {
        return auth()->user();
    }
}

if (! function_exists('zerosatleft')) {
    function zerosatleft($value, $qty = 1)
    {
        return str_pad($value, $qty, '0', STR_PAD_LEFT);
    }
}

if (! function_exists('activitylog')) {
    function activitylog($section, $action, $original_data, $data)
    {
    	if (env('LOG_ENABLED')) {
    		if ($action == 'update' && !array_diff($original_data, $data)) {
	    		//No guardar si no se ha modificado el contenido
	    		return;
	    	}
	    	$user = current_user();

	    	if ($user) {
				$detect = new Mobile_Detect;
		    	if ($detect->isMobile()) {
		    		$device = "mobile";
		    	} else if ($detect->isTablet()) {
		    		$device = "tablet";
		    	} else {
		    		$device = "desktop";
		    	}

	    		$log = new App\Models\Log();
		    	$ip = $_SERVER['REMOTE_ADDR'];
		    	$os = php_uname();
		    	//$device = php_uname('s');

		    	$log->user_id = $user->id;
		        $log->section = $section;
		        $log->action = $action;
		        $log->feedback = 'self';
		        $log->original_data = $original_data ? json_encode($original_data) : null;
		        $log->data = $data ? json_encode($data) : null;
		        $log->ip = $ip;
		        $log->device = $device;
		        $log->system = $os;
		        $log->save();
		        //return $ip. ' | '.$os. ' | '.$device;
	    	}

    	}
    }
}