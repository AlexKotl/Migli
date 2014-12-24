<?
class CMail {
	public $to, $subject, $message, $headers;
	
	function CMail($type='text') {
		if ($type=='html') {
			$this->headers .= 'MIME-Version: 1.0' . "\r\n";
			$this->headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		}
		
		$this->headers .= 'From: Figli-Migli <info@figli-migli.net>' . "\r\n";
	}
	
	function send() {
		mail($this->to, $this->subject, $this->message, $this->headers);
	}
}	
?>