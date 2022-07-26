<?php

use App\Models\dashboard\admins\admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;


if (!function_exists('aurl')) {
    function aurl($url = null)
    {
        return url('admin/' . $url);
    }
}




if (!function_exists('CheckPermission')) {
    function CheckPermission($RolePermissions, $module_id, $item_check)
    {

        $key = array_keys($item_check)[0];


        if (count($RolePermissions->where('module_id', $module_id)->where($key, $item_check[$key])) > 0) {

            return 'checked';
        } else {
            return null;
        }
    }
}



if (!function_exists('Title')) {
    function Title()
    {
        return 'title_' . session()->get('lang');
    }
}


if (!function_exists('GetSidModule')) {
    function GetSidModule()
    {
        return  App\Models\dashboard\Modules\modules::get();
    }
}

if (!function_exists('languages')) {
    function languages()
    {
        $langs = json_decode(DB::table('settings')->get()[14]->value);
        if ($langs != null and count($langs) > 0) {
            return $langs;
        }

        return ["en"];
    }
}

if (!function_exists('filePermissions')) {
    function filePermissions($file_id, $user_id)
    {
        $exist = DB::table('user_file_permissions')->where('file_id', $file_id)->where('user_id', $user_id)->get();

        if (count($exist) > 0) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('requestedBefore')) {
    function requestedBefore($file_id, $user_id)
    {
        $exist = DB::table('access_requests')->where('file_id', $file_id)->where('user_id', $user_id)->get();

        if (count($exist) > 0) {
            return true;
        } else {
            return false;
        }
    }
}




if (!function_exists('logCreated')) {
    function logCreated($user_type, $user_id, $module, $content, $data)
    {
        $add = DB::table('created_log')->insert([
            'user_type' => $user_type,
            'user_id' => $user_id,
            'module' => $module,
            'content' => $content,
            'data' => $data,
            'time' => time(),
        ]);
    }
}



if (!function_exists('logDeleted')) {
    function logDeleted($user_type, $user_id, $module, $content, $data)
    {
        $add = DB::table('deleted_log')->insert([
            'user_type' => $user_type,
            'user_id' => $user_id,
            'module' => $module,
            'content' => $content,
            'data' => $data,
            'time' => time(),
        ]);
    }
}


if (!function_exists('updated_log')) {
    function logUpdated($user_type, $user_id, $module, $content, $data, $old_data)
    {
        $add = DB::table('update_log')->insert([
            'user_type' => $user_type,
            'user_id' => $user_id,
            'module' => $module,
            'content' => $content,
            'data' => $data,
            'old_data' => $old_data,
            'time' => time(),
        ]);
    }
}


if (!function_exists('loggers')) {
    function loggers($user_type, $user_id, $ip, $action_type)
    {
        /**
         * Action types:
         * 1 => login
         * 2 => logout
         * 3 => Signup
         */

        # Fetch Ip data . . .
        $ipData = Location::get('101.167.187.255');

        $ipDataArr = (array)$ipData;


        return DB::table('logs')->insert([
            'user_type' => $user_type,
            'user_id' => $user_id,
            'ip' => $ip,
            'action_type' => $action_type,
            'time' => time(),
            'country' => $ipData->countryName,
            'ipdata'  => json_encode($ipDataArr)
        ]);
    }
}



# get Admins Token That Have roles To Use Chat Module   CHAT MODULE ID = 9 . . . .
if (!function_exists('getAdminsToken')) {
    function getAdminsToken()
    {
        $roles =   DB::table('modulespermissions')->where('module_id', 9)->pluck('role_id')->toArray();

        $tokens = admin::whereIn('role_id', $roles)->pluck('fcm_token')->toArray();

        return $tokens;
    }
}


// if (!function_exists('active_menu')) {
// 	function active_menu($link) {
// 		if (preg_match('/'.$link.'/i', Request::segment(2))) {
// 			return ['menu-open', 'display:block'];
// 		} else {
// 			return ['', ''];
// 		}
// 	}
// }


// if (!function_exists('setting')) {
// 	function setting() {
// 		return \App\Setting::orderBy('id', 'desc')->first();
// 	}
// }


// /*
//  * ** Ecommerce functions ..................
// */

// // doc data
// if (!function_exists('Modules')) {
// 	function  Modules() {
// 		return \App\module::where([['order','>',0]])->orderBy('order','asc')->get();
// 	}
// }





// if (!function_exists('up')) {
// 	function up() {
// 		return new \App\Http\Controllers\Upload;
// 	}
// }

// if (!function_exists('v_image')) {
// 	function v_image($ext = null) {
// 		if ($ext === null) {
// 			return 'image|mimes:jpg,jpeg,png,gif,bmp,ico';
// 		} else {
// 			return 'image|mimes:'.$ext;
// 		}
// 	}
// }



// if (!function_exists('load_dep')) {
// 	function load_dep($select = null, $dep_hide = null) {
// 		$departments = \App\departments::selectRaw('dep_name_'.app()->getLocale() .' as text')
// 			->selectRaw('id as id')
// 			->selectRaw('parent as parent')
// 			->get(['text', 'parent', 'id']);
// 		$dep_arr = [];
// 		foreach ($departments as $department) {
// 			$list_arr             = [];
// 			$list_arr['icon']     = '';
// 			$list_arr['li_attr']  = '';
// 			$list_arr['a_attr']   = '';
// 			$list_arr['children'] = [];
// 			if ($select !== null and $select == $department->id) {
// 				$list_arr['state'] = [
// 					'opened'   => true,
// 					'selected' => true,
// 					'disabled' => false,
// 				];
// 			}
// 			if ($dep_hide !== null and $dep_hide == $department->id) {
// 				$list_arr['state'] = [
// 					'opened'   => false,
// 					'selected' => false,
// 					'disabled' => true,
// 					'hidden'   => true,
// 				];
// 			}
// 			$list_arr['id']     = $department->id;
// 			$list_arr['parent'] = $department->parent > 0?$department->parent:'#';
// 			$list_arr['text']   = $department->text;
// 			array_push($dep_arr, $list_arr);
// 		}
// 		return json_encode($dep_arr, JSON_UNESCAPED_UNICODE);
// 	}















// if (!function_exists('load_dep_client')) {
// 	function load_dep_client($select = null, $dep_hide = null) {
// 		$departments = \App\clients_departments::selectRaw('dep_name_'.app()->getLocale() .' as text')
// 			->selectRaw('id as id')
// 			->selectRaw('parent as parent')
// 			->get(['text', 'parent', 'id']);
// 		$dep_arr = [];
// 		foreach ($departments as $department) {
// 			$list_arr             = [];
// 			$list_arr['icon']     = '';
// 			$list_arr['li_attr']  = '';
// 			$list_arr['a_attr']   = '';
// 			$list_arr['children'] = [];
// 			if ($select !== null and $select == $department->id) {
// 				$list_arr['state'] = [
// 					'opened'   => true,
// 					'selected' => true,
// 					'disabled' => false,
// 				];
// 			}
// 			if ($dep_hide !== null and $dep_hide == $department->id) {
// 				$list_arr['state'] = [
// 					'opened'   => false,
// 					'selected' => false,
// 					'disabled' => true,
// 					'hidden'   => true,
// 				];
// 			}
// 			$list_arr['id']     = $department->id;
// 			$list_arr['parent'] = $department->parent > 0?$department->parent:'#';
// 			$list_arr['text']   = $department->text;
// 			array_push($dep_arr, $list_arr);
// 		}
// 		return json_encode($dep_arr, JSON_UNESCAPED_UNICODE);
// 	}

// }








// 	// governoment





// if (!function_exists('governorate')) {
// 	function governorate() {
// 	  		return \App\governorates::orderby('id','desc')->get();

// 	}
// }





// if (!function_exists('cities')) {
// 	function cities() {
// 	  		return \App\cities::orderby('id','desc')->get();
// 	}
// }




// if (!function_exists('governorate_get')) {
// 	function governorate_get($id) {
// 	  		return \App\governorates::find($id);

// 	}
// }





// if (!function_exists('cities_get')) {
// 	function cities_get($id) {
// 	  		return \App\cities::find($id);
// 	}
// }



// // get specialize  .......
// if (!function_exists('specialize_get')) {
// 	function specialize_get($id){
// 		return \App\Advantages::find($id);
// 	}
// }



// // This function will return a random
// // string of specified length
// function random_strings($length) {

//     // md5 the timestamps and returns substring
//     // of specified length
//     return substr(md5(time()), 0, $length);
// }



// // resize image .......
//  if (!function_exists('image_resize')) {

//   function image_resize($imagePath, $new_width, $new_height)
//  {
//      $fileName = pathinfo($imagePath, PATHINFO_FILENAME);
//      $fullPath = pathinfo($imagePath, PATHINFO_DIRNAME) . "/" . $fileName . "_small.png";
//      if (file_exists($fullPath)) {
//          return $fullPath;
//      }
//      $image = openImage($imagePath);
//      if ($image == false) {
//          return null;
//      }
//      $width = imagesx($image);
//      $height = imagesy($image);
//      $imageResized = imagecreatetruecolor($width, $height);
//      if ($imageResized == false) {
//          return null;
//      }
//      $image = imagecreatetruecolor($width, $height);
//      $imageResized = imagescale($image, $new_width, $new_heigh);
//      touch($fullPath);
//      $write = imagepng($imageResized, $fullPath);
//      if (!$write) {
//          imagedestroy($imageResized);
//          return null;
//      }
//      imagedestroy($imageResized);
//      return $fullPath;
//  }


// }


// }
