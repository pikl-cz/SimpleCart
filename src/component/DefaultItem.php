<?php

namespace SimpleCart\Component;

class DefaultItem
{
	/** @var string */
	public $namespace;

	/** @var int */
	public $id;

	/** @var int */
	public $count;

	/** @var float */
	public $price;

	/** @var array */
	public $custom = array();

	/**
	 * @param string $namespace
	 * @param int $id
	 * @param int $count
	 * @param float $price
	 */
	public function __construct($namespace, $id, $count = null, $price = null)
    {
		$this->namespace = $namespace;
    	$this->id = $id;
		$this->count = $count;
		$this->price = $price;
	}

	public function setNamespace($val)
	{
		$this->namespace = $val;
	}

	public function setId($val)
	{
		$this->id = $val;
	}

	public function setCount($val)
	{
		$this->count = $val;
	}

	public function setPrice($val)
	{
		$this->price = $val;
	}

	public function setCustom($val)
	{
		if (is_array($val))
		{
			$this->custom = $val;
		} else {
			throw new \Exception('Item structure must be array type.');
		}
	}
}
