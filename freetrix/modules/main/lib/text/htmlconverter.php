<?php
namespace Freetrix\Main\Text;

class HtmlConverter
	extends Converter
{
	public function encode($text, $textType = "")
	{
		if (is_object($text))
			return $text;

		$textType = Converter::initTextType($textType);

		if ($textType == Converter::HTML)
			return $text;

		return String::htmlEncode($text);
	}

	public function decode($text, $textType = "")
	{
		if (is_object($text))
			return $text;

		$textType = Converter::initTextType($textType);

		if ($textType == Converter::HTML)
			return $text;

		return String::htmlDecode($text);
	}
}
