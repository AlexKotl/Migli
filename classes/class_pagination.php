<?
	class CPagination {
		private $total, $on_page;
		private $max_buttons = 10; // settings 
		
		function CPagination($total, $on_page) {
			$this->total = $total;
			$this->on_page = $on_page;
			return true;
		}
		
		function getList($page) {
			$page_count = ceil($this->total / $this->on_page);
			$page_start = $page+1 - floor($this->max_buttons/2); 
			$page_end =  $page+1 + floor($this->max_buttons/2)-1;
			if ($page_start<1) {
				$page_start = 1;
				if ($page_count>=$this->max_buttons) $page_end = $this->max_buttons;
				else $page_end = $page_count;
			}
			if ($page_end>$page_count) {
				$page_end = $page_count;
				if ($page_count>=$this->max_buttons) $page_start = $page_count - $this->max_buttons;
				else $page_start = 1;
			}
			
			$r = array();
			if ($page>1) $r[] = 'prev';
			for ($i=$page_start; $i<=$page_end; $i++) {
				$r[] = $i;
			}
			if ($page<$page_count) $r[] = 'next';
			return $r;
		}
	}
?>