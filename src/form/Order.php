<?php

namespace SimpleCart\Form;

use Nette\Application\UI\Form;
use Nette\Forms\Container;

class Order {

    /** @var \Nette\Http\SessionSection */
    protected $userCart;

	public function buildDefaultForm($type)
    {
		$form = new \Nette\Application\UI\Form;
		$form->addProtection('Vypršel limit pro připojení.');

        switch ($type)
        {
            case 'list':
                    $products = $this->userCart;
                    $form->addDynamic('products', function (Container $product) {
                        $product->addText('count', 'počet')
                            ->addRule(Form::INTEGER, 'Musí být číslo')
                            ->addRule(Form::RANGE, 'Minimální počet je %d', array(1, NULL));
                    }, count($products));
                break;
            case 'personalInfo':

                break;
            case 'summary':

                break;
        }

    	$form->addSubmit('submit', 'Odeslat');

		return $form;
	}
}
