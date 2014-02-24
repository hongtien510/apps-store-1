<?php
class Ishali_Api {
	
//	function getMyconfig()
//	{
//		$bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');		
//		$options = $bootstrap->getOptions();	
//		return $options;			
//	}
	
	public static function parentRedirect($url)
	{
		echo "<script language='javascript'>top.location.href='" . $url . "'</script>";
//		echo "<script language='javascript'>alert('$url');top.location.href='" . $url . "'</script>";
		exit(0);
	}
	
	public static function parentRedirect2($url)
	{
		echo "<script language='javascript'>location.href='" . $url . "'</script>";
		exit(0);
	}
	
	public static function redirect($url)
	{
		header("Location: $url");
		exit(0);
	}
	
	
	function parse_signed_request($signed_request, $secret) {
	    list($encoded_sig, $payload) = explode('.', $signed_request, 2);
	 
	    // decode the data
	    @$sig = Ishali_Api::base64_url_decode($encoded_sig);
	    @$data = json_decode(Ishali_Api::base64_url_decode($payload), true);
	 
	    if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
	        error_log('Unknown algorithm. Expected HMAC-SHA256');
	        return null;
	    }
	 
	    // check sig
	    $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
	    if ($sig !== $expected_sig) {
	        error_log('Bad Signed JSON signature!');
	        return null;
	    }
	 
	    return $data;
	}
	 
	function base64_url_decode($input) {
	    return base64_decode(strtr($input, '-_', '+/'));
	}
	
	
}