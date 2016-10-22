<?php namespace App\Help;

use Illuminate\Support\Facades\Facade;

/*
 @author: Nguyen Ngoc Nam
 */
class Common extends Facade
{

	/*
	<select>
	  <optgroup label="Swedish Cars">
	    <option value="volvo">Volvo</option>
	    <option value="saab">Saab</option>
	  </optgroup>
	  <optgroup label="German Cars">
	    <option value="mercedes">Mercedes</option>
	    <option value="audi">Audi</option>
	  </optgroup>
	</select>
	 */

	static function selectboxCategories(array $categories_a, string $id_column_name, string $value_column_name, array $options = NULL){
		string $html_s;

		$html_s = "<select>";

		$return = array();

		foreach($categories_a as $category_a) {
			// var $
			$html_s .= '<option value="' . $category_a[$id_column_name] . '">' . $category_a[$value_column_name] . '</option>';
		}

		// foreach($return as $val) {
		// 	$html_s .= "<option>".$val."</option>";
		// }
		$html_s .= "</select>";

		return $html_s;
	}

	static public function slug($url)
	{
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		// trim
		$text = trim($text, '-');

		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		// lowercase
		$text = strtolower($text);

		if (empty($text)) {
		return 'n-a';
		}

		return $text;
	}

}
