<?php
class Functions
{
	public static $divisions = array(
		1=>"Iron",
		2=>"Bronze",
		3=>"Silver",
		4=>"Gold",
		5=>"Platyna",
		6=>"Diament",
		7=>"Master+",
	);
	public static $divisionsPower = array(
		1=>1,
		2=>1,
		3=>3,
		4=>4,
		5=>6,
		6=>8,
		7=>13,
	);
	public static $positions = array(
		1=>"Top",
		2=>"Jungle",
		3=>"Mid",
		4=>"ADCarry",
		5=>"Support",
	);
	public static $positionsvisible = array(
		1=>"Top",
		2=>"Jungle",
		3=>"Mid",
		4=>"ADCarry",
		5=>"Support",
		6=>"Fill",
	);
	public static $days = array(
		1=>"Poniedziałek",
		2=>"Wtorek",
		3=>"Środa",
		4=>"Czwartek",
		5=>"Piątek",
		6=>"Sobota",
		7=>"Niedziela",
	);
	public static $maxteampower = 25;
	public static $results_per_page = 15;
	public static function isValidFolderName($string)
	{
		return (strspn($string, "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789_-") == strlen($string));
	}
	
	public static function isValidName($string)
	{
		return (strspn($string, "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789_-., {}[]|/:()*=><!&;") == strlen($string));
	}
	
	public static function isValidNameString($string)
	{
		return (strspn($string, "qwertyuiopasdfghjklzxcvbnmąśćżźńłóęQWERTYUIOPASDFGHJKLZXCVBNM0123456789_-., {}[]|/:()*=><!&;") == strlen($string));
	}
	public static function isValidMail($email)
	{
		return (filter_var($email, FILTER_VALIDATE_EMAIL) != false);
	}

	public function limitTextLength($text, $length_limit)
	{
		if(strlen($text) > $length_limit)
			return substr($text, 0, strrpos(substr($text, 0, $length_limit), " ")).'...';
		else
			return $text;
	}
	
	public static function replaceBBcodes($text) {
		$text = strip_tags($text);
		// BBcode array
		$find = array(
			'~\[b\](.*?)\[/b\]~s',
			'~\[i\](.*?)\[/i\]~s',
			'~\[u\](.*?)\[/u\]~s',
			'~\[quote\]([^"><]*?)\[/quote\]~s',
			'~\[size=([^"><]*?)\](.*?)\[/size\]~s',
			'~\[color=([^"><]*?)\](.*?)\[/color\]~s',
			'~\[url\]((?:ftp|https?)://[^"><]*?)\[/url\]~s',
			'~\[code\](.*?)\[/code\]~s',
		);
		// HTML tags to replace BBcode
		$replace = array(
			'<b>$1</b>',
			'<i>$1</i>',
			'<span style="text-decoration:underline;">$1</span>',
			'<pre>$1</'.'pre>',
			'<span style="font-size:$1px;">$2</span>',
			'<span style="color:$1;">$2</span>',
			'<a href="$1">$1</a>',
			'<div class="bbCodeBlock bbCodeBlock--screenLimited bbCodeBlock--code"><div class="bbCodeBlock-title">Code:</div><div class="bbCodeBlock-content" dir="ltr"><pre class="bbCodeCode" dir="ltr" data-xf-init="code-block" data-lang=""><code>$1</code></pre></div></div>'
		);
		// Replacing the BBcodes with corresponding HTML tags
		return preg_replace($find, $replace, $text);
	}
	
	public static function idToDivision($id) {
		if( !self::$divisions[strval($id)] ) return $id;
		else return str_replace(' ', '&nbsp', (self::$divisions[strval($id)]));
	}
	
	public static function idToDivisionPower($id) {
		if( !self::$divisionsPower[strval($id)] ) return $id;
		else return str_replace(' ', '&nbsp', (self::$divisionsPower[strval($id)]));
	}
	
	public static function idToPosition($id) {
		if( !self::$positionsvisible[strval($id)] ) return $id;
		else return str_replace(' ', '&nbsp', (self::$positionsvisible[strval($id)]));
	}
	
	public static function idToDay($id) {
		if( !self::$days[strval($id)] ) return $id;
		else return str_replace(' ', '&nbsp', (self::$days[strval($id)]));
	}
}

class Website
{
	public static function getFileContents($path)
	{
		$file = file_get_contents($path);

		if($file === false)
			new Error_Critic('', __METHOD__ . ' - Cannot read from file: <b>' . htmlspecialchars($path) . '</b>');

		return $file;
	}
	
	public static function getDBHandle() {
		return 1;
	}

	public static function putFileContents($path, $data, $append = false)
	{
		if($append)
			$status = file_put_contents($path, $data, FILE_APPEND);
		else
			$status = file_put_contents($path, $data);

		if($status === false)
			new Error_Critic('', __METHOD__ . ' - Cannot write to: <b>' . htmlspecialchars($path) . '</b>');

		return $status;
	}

	public static function deleteFile($path)
	{
		unlink($path);
	}

	public static function fileExists($path)
	{
		return file_exists($path);
	}
}
