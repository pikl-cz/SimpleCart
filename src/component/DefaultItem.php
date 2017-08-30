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
	public $variant = array();

	/** @var array */
	public $custom = array();

	/**
	 * @param string $namespace
	 * @param int $id
	 * @param int $count
	 * @param float $price
	 */
	public function __construct($namespace, $id, $count = null, $price = null, $variant = null)
    {
		$this->namespace = $namespace;
    	$this->id = $id;
		$this->count = $count;
		$this->price = $price;
		if(!empty($variant))
		{
			$this->variant[$variant] = $count;
		} else {
			$this->variant['default'] = $count;
		}
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

	public function setVariant($val, $count)
	{
		$this->variant[$val] = (int) $count;
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
