<?php

/*
|--------------------------------------------------------------------------
| Custom Helpers made by self
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| List of Country
|--------------------------------------------------------------------------
*/
if ( ! function_exists('country_list'))
{
	function country_list($selected = '')
	{
		$_country_list = config('country.list');

		if(isset($selected) && is_array($selected))
		{
			foreach($selected as $key => $val)
			{
				if($_country_list[$val])
				{
					$_countries[$val] = $_country_list[$val];
				}
			}

			return $_countries;
		}

		return $_country_list;
	}
}

/*
|--------------------------------------------------------------------------
| Convert timezone
|--------------------------------------------------------------------------
*/
if ( ! function_exists('convert_tz'))
{
	function convert_tz($original = '', $format = 'Y-m-d H:i:s', $tz = 'UTC')
	{
        $original = $original?:date('Y-m-d H:i:s');
        $format = $format == 'timezone' ? 'Y-m-d\TH:i:sP' : $format;
		$tz = session('timezone') && $tz == 'UTC' ? session('timezone') : $tz;

		$date = new DateTime(date('Y-m-d\TH:i:sP', strtotime($original)));
		$date->setTimezone(new DateTimeZone($tz));

		return $date->format($format);
	}
}

/*
|--------------------------------------------------------------------------
| Floor with number format
|--------------------------------------------------------------------------
*/
if ( ! function_exists('number_floor'))
{
	function number_floor($number = '')
	{
		return floor($number * 100) / 100;
	}
}

/*
|--------------------------------------------------------------------------
| Convert timezone
|--------------------------------------------------------------------------
*/
if ( ! function_exists('convert_value'))
{
    function convert_value($value)
    {
        $k = pow(10,3);
        $mil = pow(10,6);
        $bil = pow(10,9);

        $format = '';
        $count_player =  $value;
        if ($value >= $bil){
            $count_player =  ($value / $bil);
            $format = "B";
        }
        else if ($value >= $mil){
            $count_player =  ($value / $mil);
            $format = "M";
        }
        else if ($value >= $k){
            $count_player =  ($value / $k);
            $format = "K";
        }

        return number_format( $count_player, strlen($count_player)<=3?0:2, '.', ''). $format;
    }
}

/*
|--------------------------------------------------------------------------
| Array merge for Attendance Data
|--------------------------------------------------------------------------
*/
if( ! function_exists('array_merge_attd'))
{
    function array_merge_attd(array &$array1, array &$array2)
    {
        $merged = $array1;
        $attendance = $array2;
        foreach ($attendance as $key => $value)
        {
            $a = array_search($value['date'], array_column($merged, 'date'));
            $prev_day = date('Y-m-d', strtotime($value['date'].' -1 days'));
            $ap = array_search($prev_day, array_column($attendance, 'date'));
            $p = array_search($prev_day, array_column($merged, 'date'));
            $next_day = date('Y-m-d', strtotime($value['date'].' +1 days'));
            $an = array_search($next_day, array_column($attendance, 'date'));
            $n = array_search($next_day, array_column($merged, 'date'));

            if($a >= 0)
            {
                if(!is_numeric($ap) && $p)
                {
                    $attd[] = $merged[$p];
                }
                $attd[] = $value;
                if(!is_numeric($an) && $n)
                {
                    $attd[] = $merged[$n];
                }
            }
            else
            {
                $attd[] = $merged[$n];
            }
        }

        $attd = array_map("unserialize", array_unique(array_map("serialize", $attd)));
        /**
         * Sorting ID
         */
        usort($attd,function($a,$b){
            return strtotime($a['date']) - strtotime($b['date']);
        });
        foreach($attd as $k => $v)
        {
            $_arr[] = [
                'id' => ++$k
            ];
        }
        // dd($aaa,$attd,$merged);

        $attd = array_replace_recursive($attd, $_arr);
        return $attd;
    }
}

/*
|--------------------------------------------------------------------------
| Date format
|--------------------------------------------------------------------------
*/
if( ! function_exists('format_date'))
{
    function format_date($date = '', $format = 'default')
    {
        $date = is_numeric($date)?date('Y-m-d H:i:s', $date):$date;
        $date = $date?:date('Y-m-d H:i:s');
        $date = convert_tz($date);

        switch($format)
        {
            case 'date':
                $format = date('M d, Y', strtotime($date));
            break;
            case 'time':
                $format = date('H:i', strtotime($date));
            break;
            case 'fulldate':
                $format = date('D, M d, Y', strtotime($date));
            break;
            case 'fulldatetime':
                $format = date('D, M d, Y - H:i:s', strtotime($date));
            break;
            case 'fulldt_timezone':
                $format = date('D, M d, Y - H:i:s P', strtotime($date));
            break;
            case 'timezone':
                $format = date('T', strtotime($date));
            break;
            case 'datetime':
                $format = date('M d, Y - H:i', strtotime($date));
            break;
            case 'general_date':
                $format = date('Y-m-d', strtotime($date));
            break;
            case 'general':
                $format = date('Y-m-d H:i:s', strtotime($date));
            break;
            case 'timestamp':
                $format = strtotime($date);
            break;
            default:
                $format = date('D, M d, Y - H:i', strtotime($date));
        }

        return $format;
    }
}

/*
|--------------------------------------------------------------------------
| Date different interval
|--------------------------------------------------------------------------
*/
if( ! function_exists('date_interval'))
{
    function date_interval($start, $end)
    {
        $date1 = new DateTime($start);
        $date2 = new DateTime($end);
        return $date1->diff($date2);
    }
}

/*
|--------------------------------------------------------------------------
| Custom Number Format
|--------------------------------------------------------------------------
*/
if( ! function_exists('custom_numfor'))
{
    function custom_numfor($n, $precision = 0, $ds = ',', $ts = '.')
    {
        if ($n < 1000) {
            // Anything less than a million
            $n_format = number_format($n, $precision, $ds, $ts);
        } else if ($n < 1000000) {
                // Anything less than a million
                $n_format = number_format($n / 1000, $precision, $ds, $ts) . 'k';
        } else if ($n < 1000000000) {
            // Anything less than a billion
            $n_format = number_format($n / 1000000, $precision, $ds, $ts) . 'M';
        } else {
            // At least a billion
            $n_format = number_format($n / 1000000000, $precision, $ds, $ts) . 'B';
        }

        return $n_format;
    }
}

/*
|--------------------------------------------------------------------------
| Get country by IP
|--------------------------------------------------------------------------
*/
if ( ! function_exists('get_country_by_ip'))
{
	function get_country_by_ip($ip_address = '')
	{
		$ipdata = json_decode(file_get_contents('http://ip-api.com/json/'.$ip_address));

		if(is_object($ipdata))
		{
			return $ipdata;
		}
		else
		{
			return (object) ['timezone' => NULL];
		}
	}
}

/*
|--------------------------------------------------------------------------
| Print for required fields
|--------------------------------------------------------------------------
*/
if( ! function_exists('required_field'))
{
	function required_field($message)
	{
		return '<div class="invalid-feedback">'.$message.'</div>';
	}
}

/*
|--------------------------------------------------------------------------
| Print out variable
|--------------------------------------------------------------------------
*/
if ( ! function_exists('debug'))
{
   function debug($str = '')
   {
		array_map(function($x) {
			echo '<pre>';
			print_r($x);
			echo '</pre>';
		}, func_get_args());
   }
}

/*
|--------------------------------------------------------------------------
| Simple Number Format
|--------------------------------------------------------------------------
*/
if ( ! function_exists('is_number'))
{
   function is_number($number = '', $decimals = 0, $points = '.', $thousands_sep = ',')
   {
       return number_format((is_numeric($number) ? $number : 0), $decimals, $points, $thousands_sep);
   }
}

/*
|--------------------------------------------------------------------------
| Convert expires of access token to date
|--------------------------------------------------------------------------
*/
if ( ! function_exists('expires_token'))
{
   function expires_token(Int $expires)
   {
       return date('Y-m-d H:i:s') <= date('Y-m-d H:i:s', $expires) ? TRUE : FALSE;
   }
}

/*
|--------------------------------------------------------------------------
| Push to Multidimensional Array
|--------------------------------------------------------------------------
*/
if(!function_exists('array_push_multidimension'))
{
	function array_push_multidimension($array_data = array(), $array_push = array(), $position = 'last')
	{
		$array = array();
		if(is_array($array_data))
		{
			if($position == 'last')
			{
				$position_key = @end(array_keys($array_data));
			}
			else
			{
				$position_key = $position;
			}

			foreach($array_data as $key => $val)
			{
				if($position != 'first'){$array[$key] = $val;}

				if($key == $position_key || $position == 'first')
				{
					foreach($array_push as $push_key => $push_val)
					{
						if(is_numeric($push_key) && $key == 0)
						{
							++$push_key;
						}

						$array[$push_key] = $push_val;
						if(is_array($push_key))
						{
							return array_push_multidimension($array, $push_key, $position);
						}
					}
				}

				if($position == 'first'){$array[$key] = $val;}
			}
		}
		else
		{
			foreach($array_push as $push_key => $push_val)
			{
				$array[$push_key] = $push_val;
				if(is_array($push_key))
				{
					return array_push_multidimension($array, $push_key);
				}
			}
		}

		return ($array);
	}
}


/*
|--------------------------------------------------------------------------
| Random String from CodeIgniter
|--------------------------------------------------------------------------
*/
if ( ! function_exists('random_string'))
{
	/**
	 * Create a "Random" String
	 *
	 * @param	string	type of random string.  basic, alpha, alnum, numeric, nozero, unique, md5, encrypt and sha1
	 * @param	int	number of characters
	 * @return	string
	 */
	function random_string($type = 'alnum', $len = 8)
	{
		switch ($type)
		{
			case 'basic':
				return mt_rand();
			case 'alnum':
			case 'numeric':
			case 'nozero':
			case 'alpha':
				switch ($type)
				{
					case 'alpha':
						$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						break;
					case 'alnum':
						$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						break;
					case 'numeric':
						$pool = '0123456789';
						break;
					case 'nozero':
						$pool = '123456789';
						break;
				}
				return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
			case 'unique': // todo: remove in 3.1+
			case 'md5':
				return md5(uniqid(mt_rand()));
			case 'encrypt': // todo: remove in 3.1+
			case 'sha1':
				return sha1(uniqid(mt_rand(), TRUE));
		}
	}
}



/*
|--------------------------------------------------------------------------
| Get Browser Details
|--------------------------------------------------------------------------
*/
if ( ! function_exists('getBrowser'))
{
	function getBrowser()
	{
	    $u_agent = $_SERVER['HTTP_USER_AGENT'];
	    $bname = 'Unknown';
	    $platform = 'Unknown';
	    $version= "";

	    //First get the platform?
	    if (preg_match('/linux/i', $u_agent)) {
	        $platform = 'linux';
	    }
	    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
	        $platform = 'mac';
	    }
	    elseif (preg_match('/windows|win32/i', $u_agent)) {
	        $platform = 'windows';
	    }

	    // Next get the name of the useragent yes seperately and for good reason
	    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
	    {
	        $bname = 'Internet Explorer';
	        $ub = "MSIE";
	    }
	    elseif(preg_match('/Firefox/i',$u_agent))
	    {
	        $bname = 'Mozilla Firefox';
	        $ub = "Firefox";
	    }
	    elseif(preg_match('/OPR/i',$u_agent))
	    {
	        $bname = 'Opera';
	        $ub = "Opera";
	    }
	    elseif(preg_match('/Chrome/i',$u_agent))
	    {
	        $bname = 'Google Chrome';
	        $ub = "Chrome";
	    }
	    elseif(preg_match('/Safari/i',$u_agent))
	    {
	        $bname = 'Apple Safari';
	        $ub = "Safari";
	    }
	    elseif(preg_match('/Netscape/i',$u_agent))
	    {
	        $bname = 'Netscape';
	        $ub = "Netscape";
	    }
	    else
	    {
	        $bname = 'Other';
	        $ub = "Other";
	    }

	    // finally get the correct version number
	    $known = array('Version', $ub, 'other');
	    $pattern = '#(?<browser>' . join('|', $known) .
	    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	    if (!preg_match_all($pattern, $u_agent, $matches)) {
	        // we have no matching number just continue
	    }

	    // see how many we have
		$i = count($matches['browser']);

		if(is_array($matches['version']) && count($matches['version']) > 0)
		{
			if ($i != 1) {
				//we will have two since we are not using 'other' argument yet
				//see if version is before or after the name
				if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
					$version= $matches['version'][0];
				}
				else {
					$version= $matches['version'][1];
				}
			}
			else {
				$version= $matches['version'][0];
			}
		}

	    // check if we have a number
	    if ($version==null || $version=="") {$version="?";}

	    return array(
	        'userAgent' => $u_agent,
	        'name'      => $bname,
	        'version'   => $version,
	        'platform'  => $platform,
	        'pattern'    => $pattern,
	        'alias' 	=> strtolower(str_replace(' ', '-', $ub).'-'.$version.'-'.$platform)
	    );
	}
}


/*
|--------------------------------------------------------------------------
| Format the Number
|--------------------------------------------------------------------------
*/
if ( ! function_exists('num_format'))
{
	function num_format($num = 0, $decimal = 0, $filesize = FALSE, $complex = FALSE)
	{
        $title = '';
		if($complex == FALSE)
		{
			if($num >= 1000000000)
			{
				$num = ($num/1000000000);
				(!is_float($num)) ? $decimal = 0 : $decimal = 2;
				$title = 'B';

				if($filesize)
				{
					$title = 'GB';
				}
			}
			if($num >= 1000000)
			{
				$num = ($num/1000000);
				(!is_float($num)) ? $decimal = 0 : $decimal = 2;
				$title = 'M';

				if($filesize)
				{
					$title = 'MB';
				}
			}
			if($num >= 1000)
			{
				$num = ($num/1000);
				(!is_float($num)) ? $decimal = 0 : $decimal = 2;
				$title = 'K';

				if($filesize)
				{
					$title = 'KB';
				}
			}
		}

		$num = number_format($num, $decimal, '.', ',');

		return $num.$title;
	}
}

/*
|--------------------------------------------------------------------------
| dateDiff
|--------------------------------------------------------------------------
*/
if ( ! function_exists('dateDiff'))
{
	function dateDiff($start_date = '', $end_date = '')
	{
		$date1 = new DateTime($start_date);
		$date2 = new DateTime($end_date);
		$interval = $date1->diff($date2);

		return $interval;
	}
}


/*
|--------------------------------------------------------------------------
| playerType
|--------------------------------------------------------------------------
*/
if ( ! function_exists('player_type'))
{
	function player_type()
	{

		$data = array(
			'A' => 'A',
			'B' => 'B',
			'C' => 'C',
        );

		return $data;
	}
}

/*
|--------------------------------------------------------------------------
| bet_limit
|--------------------------------------------------------------------------
*/
if ( ! function_exists('bet_limit'))
{
	function bet_limit()
	{

		$data = array(
			'IDR' => ['t_min' => '1000', 't_max' => '1000000', 't_lipat' => '1000', 't_globalsolo' => '10000000', 't_globalall' => '100000000', 't_min50' => '5000', 't_max50' => '5000000', 't_lipat50' => '1000', 't_globalsolo50' => '50000000', 't_globalall50' => '500000000'],
			'USD' => ['t_min' => '1', 't_max' => '500', 't_lipat' => '1', 't_globalsolo' => '10000', 't_globalall' => '10000', 't_min50' => '5', 't_max50' => '5000', 't_lipat50' => '1', 't_globalsolo50' => '50000', 't_globalall50' => '500000'],
			'PHP' => ['t_min' => '5', 't_max' => '5000', 't_lipat' => '5', 't_globalsolo' => '50000', 't_globalall' => '500000', 't_min50' => '10', 't_max50' => '100000', 't_lipat50' => '10', 't_globalsolo50' => '100000', 't_globalall50' => '1000000'],
			'VND' => ['t_min' => '1000', 't_max' => '1000000', 't_lipat' => '1000', 't_globalsolo' => '10000000', 't_globalall' => '100000000', 't_min50' => '5000', 't_max50' => '5000000', 't_lipat50' => '1000', 't_globalsolo50' => '50000000', 't_globalall50' => '500000000'],
			'THB' => ['t_min' => '10', 't_max' => '10000', 't_lipat' => '10', 't_globalsolo' => '100000', 't_globalall' => '1000000', 't_min50' => '50', 't_max50' => '5000', 't_lipat50' => '10', 't_globalsolo50' => '500000', 't_globalall50' => '5000000'],
			'MYR' => ['t_min' => '1', 't_max' => '500', 't_lipat' => '1', 't_globalsolo' => '1000', 't_globalall' => '10000', 't_min50' => '5', 't_max50' => '5000', 't_lipat50' => '1', 't_globalsolo50' => '50000', 't_globalall50' => '500000'],
			'RMB' => ['t_min' => '1', 't_max' => '500', 't_lipat' => '1', 't_globalsolo' => '10000', 't_globalall' => '10000', 't_min50' => '5', 't_max50' => '5000', 't_lipat50' => '1', 't_globalsolo50' => '50000', 't_globalall50' => '500000'],

        );

		return $data;
	}
}

/*
|--------------------------------------------------------------------------
| games
|--------------------------------------------------------------------------
*/
if ( ! function_exists('games'))
{
	function games()
	{

		$data = array(
			'p7' => [
				'code' => 'RL',
				'name' => 'Roulette',
			],
			'p6' => [
				'code' => '24D',
				'name' => '24D',
			],
			'p9' => [
				'code' => '12D',
				'name' => '12D',
			],
			'm13' => [
				'code' => 'BL',
				'name' => 'Billiards',
			],
			'm14' => [
				'code' => 'PD',
				'name' => 'Poker Dice',
			],
			'p12' => [
				'code' => 'SD',
				'name' => 'Sicbo[Dice]',
			],
			'm7' => [
				'code' => 'OG',
				'name' => 'Oglok',
			],
			'm8' => [
				'code' => 'D6',
				'name' => 'Dice 6',
			],
			'm10' => [
				'code' => 'HNT',
				'name' => 'Head Tail',
			],
			'm11' => [
				'code' => 'RW',
				'name' => 'Red White',
			],
			'm6' => [
				'code' => '24DSPIN',
				'name' => '24Dspin',
			],
			'm16' => [
				'code' => 'GB',
				'name' => 'Gong Ball',
			],
			'm19' => [
				'code' => 'SW',
				'name' => 'Suwit',
			],
			'm20' => [
				'code' => 'MP',
				'name' => 'Monopoly',
			],
			'm21' => [
				'code' => 'MPW',
				'name' => 'Monopoly Word Cup',
			],
			'm22' => [
				'code' => 'BC',
				'name' => 'Baccarat',
			],
			'm22b' => [
				'code' => 'BCB',
				'name' => 'Baccarat B',
			],
			'm22c' => [
				'code' => 'BCC',
				'name' => 'Baccarat C',
			],
			'm23' => [
				'code' => 'DT',
				'name' => 'Dragon Tiger',
			]
        );

		return $data;
	}
}


if ( ! function_exists('show_error'))
{
	/**
	 * Error Handler
	 *
	 * This function lets us invoke the exception class and
	 * display errors using the standard error template located
	 * in application/views/errors/error_general.php
	 * This function will send the error page directly to the
	 * browser and exit.
	 *
	 * @param	string
	 * @param	int
	 * @param	string
	 * @return	void
	 */
	function show_error($message, $status_code = 500, $heading = 'An Error Was Encountered')
	{
		$status_code = abs($status_code);
		if ($status_code < 100)
		{
			$exit_status = $status_code + 9; // 9 is EXIT__AUTO_MIN
			$status_code = 500;
		}
		else
		{
			$exit_status = 1; // EXIT_ERROR
		}

		$_error =& load_class('Exceptions', 'core');
		echo $_error->show_error($heading, $message, 'error_general', $status_code);
		exit($exit_status);
	}
}


if ( ! function_exists('set_status_header'))
{
	/**
	 * Set HTTP Status Header
	 *
	 * @param	int	the status code
	 * @param	string
	 * @return	void
	 */
	function set_status_header($code = 200, $text = '', $get_code_text = FALSE)
	{
		if (empty($code) OR ! is_numeric($code))
		{
			show_error('Status codes must be numeric', 500);
		}

		if (empty($text))
		{
			is_int($code) OR $code = (int) $code;
			$stati = array(
				100	=> 'Continue',
				101	=> 'Switching Protocols',

				200	=> 'OK',
				201	=> 'Created',
				202	=> 'Accepted',
				203	=> 'Non-Authoritative Information',
				204	=> 'No Content',
				205	=> 'Reset Content',
				206	=> 'Partial Content',

				300	=> 'Multiple Choices',
				301	=> 'Moved Permanently',
				302	=> 'Found',
				303	=> 'See Other',
				304	=> 'Not Modified',
				305	=> 'Use Proxy',
				307	=> 'Temporary Redirect',

				400	=> 'Bad Request',
				401	=> 'Unauthorized',
				402	=> 'Payment Required',
				403	=> 'Forbidden',
				404	=> 'Not Found',
				405	=> 'Method Not Allowed',
				406	=> 'Not Acceptable',
				407	=> 'Proxy Authentication Required',
				408	=> 'Request Timeout',
				409	=> 'Conflict',
				410	=> 'Gone',
				411	=> 'Length Required',
				412	=> 'Precondition Failed',
				413	=> 'Request Entity Too Large',
				414	=> 'Request-URI Too Long',
				415	=> 'Unsupported Media Type',
				416	=> 'Requested Range Not Satisfiable',
				417	=> 'Expectation Failed',
				422	=> 'Unprocessable Entity',
				426	=> 'Upgrade Required',
				428	=> 'Precondition Required',
				429	=> 'Too Many Requests',
				431	=> 'Request Header Fields Too Large',

				500	=> 'Internal Server Error',
				501	=> 'Not Implemented',
				502	=> 'Bad Gateway',
				503	=> 'Service Unavailable',
				504	=> 'Gateway Timeout',
				505	=> 'HTTP Version Not Supported',
				511	=> 'Network Authentication Required',
			);

			if (isset($stati[$code]))
			{
				$text = $stati[$code];
			}
			else
			{
				show_error('No status text available. Please check your status code number or supply your own message text.', 500);
			}

			if($get_code_text == TRUE)
			{
				return $text;
			}
		}

		if (strpos(PHP_SAPI, 'cgi') === 0)
		{
			header('Status: '.$code.' '.$text, TRUE);
			return;
		}

		$server_protocol = (isset($_SERVER['SERVER_PROTOCOL']) && in_array($_SERVER['SERVER_PROTOCOL'], array('HTTP/1.0', 'HTTP/1.1', 'HTTP/2'), TRUE))
			? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
		header($server_protocol.' '.$code.' '.$text, TRUE, $code);
	}
}

/*
|--------------------------------------------------------------------------
| label_boolean
|--------------------------------------------------------------------------
*/
if( ! function_exists('label_boolean'))
{
	function label_boolean($status = FALSE)
	{
		if($status == TRUE)
		{
			$template = '<span class="label font-weight-bold label-inline label-success"><i class="fa fa-check" style="font-size: inherit; margin-right: 5px;"></i>Yes</span>';
		}
		else
		{
			$template = '<span class="label font-weight-bold label-inline label-danger"><i class="la la-remove" style="font-size: inherit; margin-right: 5px;"></i>No</span>';
		}

		return $template;
	}
}

/*
|--------------------------------------------------------------------------
| current_url
|--------------------------------------------------------------------------
*/
if( ! function_exists('current_url')){
	function current_url()
	{
		return URL::current();
		// $CI =& get_instance();
		// return $CI->config->site_url($CI->uri->uri_string());
	}
}

/*
|--------------------------------------------------------------------------
| url_title
|--------------------------------------------------------------------------
*/


if( ! function_exists('url_title')) {
	function url_title($str, $separator = '-', $lowercase = FALSE)
	{
		if ($separator === 'dash')
		{
			$separator = '-';
		}
		elseif ($separator === 'underscore')
		{
			$separator = '_';
		}

		$q_separator = preg_quote($separator);

		$trans = array(
			'&.+?;'			=> '',
			'[^\w\d _-]'		=> '',
			'\s+'			=> $separator,
			'('.$q_separator.')+'	=> $separator
		);

		$str = strip_tags($str);
		foreach ($trans as $key => $val)
		{
			$str = preg_replace('#'.$key.'#i', $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}

		return trim(trim($str, $separator));
	}

}

/*
|--------------------------------------------------------------------------
| url_title
|--------------------------------------------------------------------------
*/

if ( ! function_exists('br'))
{
	function br($count = 1)
	{
		return str_repeat('<br />', $count);
	}
}
/*
|--------------------------------------------------------------------------
| isJson
|--------------------------------------------------------------------------
*/
if ( ! function_exists('isJson'))
{
	function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}
}
/*
|--------------------------------------------------------------------------
| str_random
|--------------------------------------------------------------------------
*/
if (! function_exists('str_random')) {
    function str_random(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; $i++) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }

        return implode('', $pieces);
    }
}
/*
|--------------------------------------------------------------------------
| setPromotionStatus
|--------------------------------------------------------------------------
*/

if(!function_exists('setPromotionStatus')){
	function setPromotionStatus($status=0){
			switch($status){
				case 0 : $statz = "<span class='label font-weight-bold label-inline text-white label-info'>Moderation</span>";break;
				case 1 : $statz = "<span class='label font-weight-bold label-inline text-white label-success'>Active</span>";break;
				case 2 : $statz = "<span class='label font-weight-bold label-inline text-white label-danger'>Deleted</span>";break;
				case 3 : $statz = "<span class='label font-weight-bold label-inline text-white label-primary'>re_Draft</span>";break;
				case 4 : $statz = "<span class='label font-weight-bold label-inline text-white label-default'>Staff Followup</span>";break;
				case 5 : $statz = "<span class='label font-weight-bold label-inline text-white label-info'>Request Approved</span>";break;
				case 6 : $statz = "<span class='label font-weight-bold label-inline text-white label-warning'>on Hold</span>";break;
				case 7 : $statz = "<span class='label font-weight-bold label-inline text-white label-danger'>on Rejected</span>";break;
				case 8 : $statz = "<span class='label font-weight-bold label-inline text-white label-default'>Draft</span>";break;
				default : $statz = "<span>Unknown</span>";break;
			}
			return $statz;
	}

}

/*
|--------------------------------------------------------------------------
| setCatalogueStatusLabel
|--------------------------------------------------------------------------
*/
if(!function_exists('setCatalogueStatusLabel')){
	function setCatalogueStatusLabel($status=0){
			switch($status){
				case 0 : $statz = "<span class='label label-info font-weight-bold label-inline text-white'>Draft</span>";break;
				case 1 : $statz = "<span class='label label-success font-weight-bold label-inline text-white'>Publish</span>";break;
				case 2 : $statz = "<span class='label label-danger font-weight-bold label-inline text-white '>Deleted</span>";break;
				case 3 : $statz = "<span class='label label-danger font-weight-bold label-inline text-white'>re_Draft</span>";break;
				case 4 : $statz = "<span class='label label-danger font-weight-bold label-inline text-white'>Staff Followup</span>";break;
				default : $statz = "<span>Draft</span>";break;
			}
			return $statz;
	}
}
/*
|--------------------------------------------------------------------------
| setMissionStatus
|--------------------------------------------------------------------------
*/
if(!function_exists('setMissionStatus')){
	function setMissionStatus($status=0){
			switch($status){
				case 0 : $statz = "<span class='label font-weight-bold label-inline text-white label-info '>Draft</span>";break;
				case 1 : $statz = "<span class='label font-weight-bold label-inline text-white label-success '>Active</span>";break;
				case 2 : $statz = "<span class='label font-weight-bold label-inline text-white label-danger '>Deleted</span>";break;
				case 3 : $statz = "<span class='label font-weight-bold label-inline text-white label-default '>reDraft</span>";break;
				case 4 : $statz = "<span class='label font-weight-bold label-inline text-white label-primary '>Staff Followup</span>";break;
				default : $statz = "<span>Unknown</span>";break;
			}
			return $statz;
	}

}
/*
|--------------------------------------------------------------------------
| setMissionListStatus
|--------------------------------------------------------------------------
*/
if(!function_exists('setMissionListStatus')){
	function setMissionListStatus($status=0){
			switch($status){
				case 1 : $statz = "<span class='label label-info'>Activity</span>";break;
				case 2 : $statz = "<span class='label label-success'>Transaction</span>";break;
				default : $statz = "<span>Unknown</span>";break;
			}
			return $statz;
	}

}