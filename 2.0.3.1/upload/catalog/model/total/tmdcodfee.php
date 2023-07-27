<?php
class ModelTotalTmdcodfee extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
	$this->load->language('total/tmdcodfee');
	$sub_total = $this->cart->getSubTotal();
	//title
	$codtitle_info =$this->config->get('tmdcodfee_title');
	 $title   = $codtitle_info[$this->config->get('config_language_id')]['title'];
	

		if(!empty($this->config->get('tmdcodfee_geo_zone_id'))){
			$tmdcodfee_geo_zone_id = $this->config->get('tmdcodfee_geo_zone_id');
		}else{
			$tmdcodfee_geo_zone_id ='';
		}

		if (isset($this->session->data['guest']['customer_group_id'])) {
			$customer_group_guest = $this->session->data['guest']['customer_group_id'];
		} else {
			$customer_group_guest = '';
		}

		
	
 		$codfee_infos =$this->config->get('tmdcodfee_priceinfo');
 		$codfeetotal = '';
		/*if(!empty($codfee_infos)){
			 foreach ($codfee_infos as $codfee_info) {
			$codfee_total =$codfee_info['cod_fee'];
			$min = $codfee_info['min'];
			$max = $codfee_info['max'];
			$fee_type = $codfee_info['fee_type'];
			$customer_group = $codfee_info['customer_group_id'];
			
			if($sub_total>=$min && $sub_total<=$max){
				$codfee_total=$codfee_info['cod_fee'];
			}else{
				$codfee_total='';
			}
			 $codfeetotal .=$codfee_total;
				if($sub_total>=$min && $sub_total<=$max){
					
					//customer_group login
					$customer_info = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . $this->customer->getId() . "' and customer_group_id = '" . $customer_group . "'");
					if(!empty($customer_info->row)){
					$customer_group_id=$customer_info->row['customer_group_id'];
					}else{
					$customer_group_id='';	
					}
					//All
					if($customer_group==0){
						$customer_group_id=true;
					}
					//guest
					$customer_id=$this->customer->getId();
					if($customer_group==1 && empty($customer_id)){
						$customer_group_id=true;
					}

					if($fee_type==1){
						//percentage price
						$fee_percent=$sub_total*$codfeetotal/100;
						 $codfeetotal =$fee_percent;
					}

				}

		   }
		}*/

		if(!empty($codfee_infos)){
			foreach ($codfee_infos as $codfee_info) {
					 	
				$codfee_total   = $codfee_info['cod_fee'];
				$min            = $codfee_info['min'];
				$max            = $codfee_info['max'];
				$fee_type       = $codfee_info['fee_type'];
				$customer_group = $codfee_info['customer_group_id'];

				//customer_group login
				$customer_info = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer  WHERE customer_id = '" . $this->customer->getId() . "' and customer_group_id = '" . $customer_group . "'");
				

				if(!empty($customer_info->row)){
				   $customer_group_id=$customer_info->row['customer_group_id'];
				}else{
				   $customer_group_id=$customer_group_guest;	
				}

				if($customer_group_id==$customer_group){
					if($sub_total>=$min && $sub_total<=$max){

						if($sub_total>=$min && $sub_total<=$max){
							$codfee_total = $codfee_info['cod_fee'];
						}else{
							$codfee_total ='';
						}
				
						 $codfeetotal.=$codfee_total;

						//percentage price
						 if($fee_type==1){
						   	$fee_percent=$sub_total*$codfeetotal/100;
							$codfeetotal =$fee_percent;
						}
					}
				}
		    } 
		}

		
			
		//print_r($codfeetotal);die();
		$codfeetotal = $this->tax->calculate($codfeetotal, $this->config->get('tmdcodfee_taxclass'), $this->config->get('config_tax'));
		
		if (isset($this->session->data['shipping_method']['country_id'])) {
			$country_id = $this->session->data['shipping_method']['country_id'];
		} else {
			$country_id = '';
		}

		if (isset($this->session->data['shipping_method']['zone_id'])) {
			$zone_id = $this->session->data['shipping_method']['zone_id'];
		} else {
			$zone_id = '';
		}


		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$tmdcodfee_geo_zone_id . "' AND country_id = '" . (int)$country_id . "' and zone_id = '" . (int)$zone_id . "' or zone_id = '0'");

		if ($query->num_rows) {
			$status = true;
		 }else {
			$status = false;
		}

		if (isset($this->session->data['shipping_method'])) {
		    $shipping_method = explode('.',$this->session->data['shipping_method']['code']);
		    $shipping_method = $shipping_method[0];
		} else {
			$shipping_method = '';
		}

		if(!empty($this->config->get('tmdcodfee_delivery_fee'))){
			$restrict_deliveryfee = array();
			$restrict_deliveryfee1 = $this->config->get('tmdcodfee_delivery_fee');
			if(isset($restrict_deliveryfee1)){
				foreach($restrict_deliveryfee1 as $restrict){
					
					$restrictname=explode('.',$restrict);
				
					$restrict_deliveryfee[]=$restrictname[0];
				
				}
			}
		}else{
			$restrict_deliveryfee = array();
		}	
	
		if(in_array($shipping_method, $restrict_deliveryfee)){
			$status = false;
		}else{
			$status = true;
		}

		if (isset($this->session->data['payment_method']['code'])) {
			$payment_method = $this->session->data['payment_method']['code'];
		} else {
			$payment_method = '';
		}

	
		if($payment_method=='cod'){	
			if($status) {
				if(!empty($codfeetotal)) {
				$total_data[] = array(
					'code'       => 'tmdcodfee',
					'title'      => $title,
					'value'      => $codfeetotal,
					'sort_order' => $this->config->get('tmdcodfee_sort_order')
				);

					$total += $codfeetotal;
				
				}
			}
		}

	}
}