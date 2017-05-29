<?php

namespace SimpleCart\Repository;

trait Handlers {

	/** @var \Nette\Http\SessionSection */
	public $cart;

	/** @var \SimpleCart\Repository\Cart */
	public $cartRepository;

	public function injectSimpleCart(\SimpleCart\Repository\Cart $cartRepository)
	{
		$this->cartRepository = $cartRepository;
	}

	protected function createComponentSimpleCart()
	{
		$cart = new \SimpleCart\Component\Control($this->cart);
		//$cart->setCustomTemplate(__DIR__ . '/../../components/SimpleCart/cart.latte');
		return $cart;
	}

	/*
	 * @param string $namespace
	 * @param int $id
	 * @param int $count
	 * @param float $priceWithoutVat
	 */
	public function handleAddToCart($namespace, $id, $count, $priceWithoutVat) {
		$item = new \SimpleCart\Component\DefaultItem((string) $namespace, (int) $id, (int) $count, floatval($priceWithoutVat));
		if (!$this->cartRepository->get($item))
		{
			$customAttributes = array();
			$item->setCustom($customAttributes);
		}

		if ($this->cartRepository->add($item))
		{
			$this->flashMessage('Položka je přidána do košíku.', 'success');
		} else {
			throw new \Exception('Položku se nepodařilo přidat do košíku.');
		}

		$this->refreshCartSnippets();
	}

	/*
	 * Remove product with all pieces
	 * @param string $namespace
	 * @param int $id
	 */
	public function handleRemoveFromCart($namespace, $id) {
		$item = new \SimpleCart\Component\DefaultItem((string) $namespace, (int) $id);

		if ($this->cartRepository->remove($item))
		{
			$this->flashMessage('Položka je odebrána z košíku.', 'success');
		}

		$this->refreshCartSnippets();
	}

	/*
	 * Delete all applied items
	 */
	public function handleEmptyCart() {
		if ($this->cartRepository->emptyCart())
		{
			$this->flashMessage('Nákupní košík je prázdný.', 'success');
		}

		$this->refreshCartSnippets();
	}

	/*
	 * Redraw controls
	 */
	private function refreshCartSnippets($noRedir = true)
	{
		if ($this->isAjax())
		{
			$this->getPresenter()->getComponent(lcfirst(\SimpleCart\Repository\Cart::COMPONENT_NAME))->redrawControl('QuickList');
			$this->redrawControl('alerts');
		} else {
			$this->redirect('this');
		}
	}

}
