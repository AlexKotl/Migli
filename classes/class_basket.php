<?
class CBasket {
	private $items = array();
	
	function __construct() {
		$this->items = unserialize($_COOKIE[cbasket_items]);
	}
	
	public function save() {
		setcookie('cbasket_items', serialize($this->items), time() + 60*60*24*30, '/');
	}
	
	public function addItem($item) {
		$this->items[] = $item;
	}
	
	public function getItems() {
		return $this->items;
	}
	
	public function removeItem($id) {
		foreach ($this->items as $k => $v) {
			if ($v[id]==$id) unset($this->items[$k]);
		}
	}
	
	public function getItem($id) {
		foreach ($this->items as $k => $v) {
			if ($v[id]==$id) return $v;
		}
		return false;
	}
	
	public function getItemsCount() {
		return count($this->items);
	}
	
	public function clearBasket() {
		$this->items = array();
	}
}
?>