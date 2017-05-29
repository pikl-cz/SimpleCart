# SimpleCart
Simple AJAX shopping cart

vyžaduje:
inicializace ajax

popis
- data v session 
  - namespace 
    - produkt
      - id, count, cena, custom
- repozitář
  - getList
  - 


Implementace: 
extensions:
    cart: SimpleCart\DI\SimpleCartExtension

...

class BasePresenter extends \App\Presenters\BasePresenter {
  use \SimpleCart\Repository\Handlers;

...

	function startup()
    {
		parent::startup();
		$this->cart = $this->cartRepository->initCartSession();
		$this->template->simpleCartList = $this->cartRepository->getList();
    
    
...
vlastní template - pokud neuvedeno použije se defaultní

...
trait


...
volání v šablonách
{control simpleCart}
<a n:href="addToCart!, namespace => 'product', id => $id, count => $count, priceWithoutVat => $price" title="Přidat do košíku">Přidat do košíku</a>


