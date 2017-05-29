<?php

namespace SimpleCart\Component;

final class Control extends \Nette\Application\UI\Control
{
	/** @var string */
	protected $templateFile = __DIR__ . '/default.latte';

	/** @var array */
	protected $items = array();

	/** @var \Nette\Http\SessionSection */
	private $cart;

	/*
	 * @param \Nette\Http\SessionSection $cart
	 */
	public function __construct(\Nette\Http\SessionSection $cart)
    {
		parent::__construct();
		$this->cart = $cart;
	}

	/**
	 * @param string $fileName
	 * @return $this
	 */
	public function setTemplateFile($fileName)
    {
		$this->templateFile = $fileName;
		return $this;
	}

	/**
	 * @param string $filePath
	 * @return $this
	 */
	public function setCustomTemplate($filePath)
	{
		if (file_exists($filePath))
		{
			$this->templateFile = $filePath;
		} else {
			throw new \Exception('Custom template doesn´t exist.');
		}

		return $this;
	}

	public function render()
    {
    	$this->template->namespaces = $this->cart->list;
		$this->template->setFile($this->templateFile);
		$this->template->render();
	}

}
