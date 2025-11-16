<?php

namespace MyProject\View;

class View
{
	private $templatesPath;


	public function __construct(string $templatesPath)
	{
		$this->templatesPath = $templatesPath;
	}

	public function renderHtml(string $templateName, array $vars = [], string $title = 'Мой блог') //засунули переменную титле в каждый шаблон
	{
		extract($vars);
		$pageTitle = $title;
		include $this->templatesPath . '/' . $templateName;
	}
}
