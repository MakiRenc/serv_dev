<?php

class Cat
{
	private $name;
	private $color;

	public function __construct(string $name, string $color)
	{
		$this->name = $name;
		$this->color = $color;
	}

	public function sayHello()
	{
		echo 'Привет! Меня зовут ' . $this->name . '.' . '<BR>' . 'Мой цвет - ' . $this->color . '.<BR>';
	}

	public function setName(string $name)
	{
		$this->name = $name;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setColor(string $color)
	{
		$this->color = $color;
	}

	public function getColor(): string
	{
		return $this->color;
	}
}

$blackcat = new Cat('Дымка', 'черный');
$greycat = new Cat('Ершик', 'серый');

echo $blackcat->sayHello();
echo $greycat->sayHello();
