<?php namespace App\Models\Values;

class Html extends Value {

	public function limit($limit){
		return str_limit($this->getValue(), $limit);
	}

	public function text(){
		$text = preg_replace('#<style>.*</style>#s', '', $this->getValue());
		$text = strip_tags($text);
		return new static($text);
	}

	public function getValue()
	{
		$value = parent::getValue();
		$value = $this->formatCodeTags($value);
		return $value;
	}

	public function formatCodeTags($html){
		$html = preg_replace_callback('#<code>(.*?)</code>#s', function($m){
			$m[1] = str_replace('&#39;', "'", $m[1]);
			return '<pre class="brush: php">'.htmlspecialchars($m[1]).'</pre>';
		}, $html);
		return $html;
	}
}