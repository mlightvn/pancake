<?php namespace App\Http\Requests;

use Illuminate\Support\Facades\Request;

class FormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public static function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public static function rules($id, $model_name)
	{
		$arr = array();

		switch ($model_name) {
			case 'admin.login':
				$arr = [
					'email'			=> ['required', 'email'],
					'password'		=> ['required', 'between:8,100', 'regex:/[A-Za-z0-9]{8,100}/'],
				];

				break;

			case 'member':
				$arr = [
					'email'			=> ['required', 'email', 'unique:members,email' . ($id ? (',' . $id) : "")],
					'password'		=> ['between:8,100', 'regex:/[A-Za-z0-9]{8,100}/', 'confirmed'],
					'password_confirmation'		=> ['between:8,100', 'regex:/[A-Za-z0-9]{8,100}/'],

					// 'birthday'		=> ['date_format:yyyy/MM/dd'],
				];

				if($id == NULL){
					$arr['password'] = array_merge(['required'], $arr['password']);
					$arr['password_confirmation'] = array_merge(['required'], $arr['password_confirmation']);
				}
				break;

			case 'company':
				if($id == NULL){
					$arr = [
						'email'			=> ['required', 'email', 'unique:companies,email,' . ($id ? $id : "NULL")],
						// 'password'		=> ['required', 'between:8,100', 'regex:/[A-Za-z0-9]{8,100}/', 'confirmed'],
						// 'password_confirmation'		=> ['required', 'between:8,100', 'regex:/[A-Za-z0-9]{8,100}/'],

						// 'birthday'		=> ['date_format:yyyy/MM/dd'],
					];
				}else{
					$arr = [
						'email'			=> ['required', 'email', 'unique:members,email,' . ($id ? $id : "NULL")],
						// 'password'		=> ['between:8,100', 'regex:/[A-Za-z0-9]{8,100}/', 'confirmed'],
						// 'password_confirmation'		=> ['between:8,100', 'regex:/[A-Za-z0-9]{8,100}/'],

						// 'birthday'		=> ['date_format:yyyy/MM/dd'],
					];
				}
				break;

			case 'company.image':
					$arr = [
						'logo'			=> ['image', 'mimes:jpg,jpeg,gif,png'],
					];
				break;

			case 'image':
					$arr = [
						'logo'			=> ['image', 'mimes:jpg,jpeg,gif,png'],
					];
				break;

			case 'video':
					$arr = [
						'path'			=> ['required', 'max:1280M'],
						'mime'			=> ['required', 'mimes:asf,wmv,wmx,wvx,avi,mp4,ogg,mov,flv,m3u8'],
					];
				break;

			case 'support':
				$arr = [
					'email'			=> ['required', 'email'],
					'content'		=> ['required', 'between:20,2000'],
				];
				break;

			default:
				$arr = array();
				break;
		}

		return $arr;
	}

}
