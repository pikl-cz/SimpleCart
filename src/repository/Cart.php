<?php

namespace SimpleCart\Repository;

/*
 * Basic functions for services of SimpleCart.
 * Data are stored in Nette SessionSection.
 */
final class Cart
{
	CONST COMPONENT_NAME = 'SimpleCart';
	CONST COMPONENT_ERROR_PREFIX = self::COMPONENT_NAME . ': ';

	/** @var \Nette\Http\Session */
	private $session;

	/** @var \Nette\Http\SessionSection */
	private $cart;

	public function __construct(\Nette\Http\Session $session) {
		$this->session = $session;
		$this->cart = $session->getSection(self::COMPONENT_NAME);
	}

	/*
	 * Session exists? No? Init empty array
	 */
	public function initCartSession() {
		$cart = $this->cart;
		$cart->warnOnUndefined = TRUE;
		if (empty($cart->list))
		{
			$cart->list = array();
			$cart->setExpiration(0);

		}
		return $cart;
	}

	/*
	 * Get namespace
	 * @param string $name
	 */
	public function getNamespace($namespace) {
		$list = $this->cart->list;

		if (array_key_exists($namespace, $list))
		{
			return $this->cart->list[$namespace];
		} else {
			return false;
		}
	}

	/*
	 * Find item
	 * @param \SimpleCart\Component\DefaultItem
	 */
	public function get($item) {
		$namespace = $this->getNamespace($item->namespace);
		if (!$namespace)
		{
			return false;
		} else {
			if (array_key_exists($item->id, $namespace))
			{
				return $namespace[$item->id];
			} else {
				return false;
			}
		}
	}

	/*
	 * Add item
	 * @param \SimpleCart\Component\DefaultItem
	 */
	public function add($item) {
		$namespace = $this->getNamespace($item->namespace);
		if ($namespace && $this->get($item))
		{
			$old = $namespace[$item->id];
			$newCount = (int) $old->count + (int) $item->count;
			$old->count = $newCount;
			/*
			 * Variants
			 */
			if (!empty($item->variant))
			{
				$variants = $this->cart->list[$item->namespace][$item->id]->variant;
				foreach ($item->variant as $variant => $count)
				{
					if(array_key_exists($variant, $variants))
					{
						$this->cart->list[$item->namespace][$item->id]->variant[$variant] = $this->cart->list[$item->namespace][$item->id]->variant[$variant] + $item->count;
					} else {
						$this->cart->list[$item->namespace][$item->id]->variant[$variant] = (int) $item->count;
					}
				}
			}

		} else {
			$this->cart->list[$item->namespace][$item->id] = $item;
		}

		return true;
	}

	/*
	* Remove item
	* @param \SimpleCart\Component\DefaultItem
	*/
	public function remove($item, $variant)
	{
		$item = $this->get($item);
//		dump($this->cart->list['product']);
//		dump($item);
//		dump($variant);
//		exit;
		if ($item)
		{
			$namespace = $item->namespace;
			
			unset($this->cart->list[$item->namespace][$item->id]->variant[$variant]);
			if (count($this->cart->list[$item->namespace][$item->id]->variant) == 0)
			{
				unset($this->cart->list[$item->namespace][$item->id]);
				if (count($this->cart->list[$namespace]) == 0)
				{
					unset($this->cart->list[$item->namespace]);
				}
			}
			return true;
		} else {
			return false;
		}
	}

	/*
	 * Remove all items and namespaces
	 */
	public function emptyCart()
	{
		$this->cart->list = array();
		return true;
	}

	/*
	 * Get array of products from session
	 * @return false | int $totalPrice
	 */
	public function getList() {
		return $this->cart->list;
	}
}
