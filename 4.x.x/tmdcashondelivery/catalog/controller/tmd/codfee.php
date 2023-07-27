<?php
namespace Opencart\Catalog\Controller\Extension\Tmdcashondelivery\Tmd;
class Codfee extends \Opencart\System\Engine\Controller {
	public function codCheck(string &$route, array &$args, mixed &$output): void {	

		if(VERSION>='4.0.2.0'){
			if (isset($this->session->data['shipping_method'])) {
				$shipping_method = $this->session->data['shipping_method']['code'];
			} else {
				$shipping_method = '';
			}
		}else{
			if (isset($this->session->data['shipping_method'])) {
				$shipping_method = $this->session->data['shipping_method'];
			} else {
				$shipping_method = '';
			}
		}
			
			if(!empty($this->config->get('total_tmdcodfee_delivery'))){
				$restrict_delivery=$this->config->get('total_tmdcodfee_delivery');
			}else{
				$restrict_delivery=[];
			}	

				
			if(in_array($shipping_method, $restrict_delivery)){
			$output = false;
			}else{
			$output = $output;
			}
		
	}

}