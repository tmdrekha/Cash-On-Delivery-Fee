<?php
namespace Opencart\Admin\Controller\Extension\Tmdcashondelivery\Total;
// Lib Include 
require_once(DIR_EXTENSION.'/tmdcashondelivery/system/library/tmd/system.php');
// Lib Include 
class TmdcodFee extends \Opencart\System\Engine\Controller {
	public function install(){
		$this->load->model('user/user_group');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdcashondelivery/total/codfee');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdcashondelivery/total/codfee');

		$this->load->model('setting/event');
		$this->model_setting_event->deleteEventByCode('tmd_codfee_onfront');

		if(VERSION>='4.0.2.0')
		{
			$eventaction='extension/tmdcashondelivery/tmd/codfee.codCheck';
			$eventtrigger='catalog/model/extension/opencart/payment/cod/getMethods/after';
		}
		else{
			$eventaction='extension/tmdcashondelivery/tmd/codfee|codCheck';
			$eventtrigger='catalog/model/extension/opencart/payment/cod/getMethod/after';
		}
		
		$eventrequest=[
					'code'=>'tmd_codfee_onfront',
					'description'=>'TMD Cash on delivery Module',
					'trigger'=>$eventtrigger,
					'action'=>$eventaction,
					'status'=>'1',
					'sort_order'=>'1',
				];
		if(VERSION=='4.0.0.0')
		{
			$this->model_setting_event->addEvent('tmd_codfee_onfront', 'TMD Cash on delivery Module', 'catalog/model/extension/opencart/payment/cod/getMethod/after','extension/tmdcashondelivery/tmd/codfee|codCheck', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
	}
public function index(): void {
	
	$this->registry->set('tmd', new  \Tmdcashondelivery\System\Library\Tmd\System($this->registry));
		$keydata=array(
		'code'=>'tmdkey_codfee',
		'eid'=>'MzcwMzk=',
		'route'=>'extension/tmdcashondelivery/total/tmdcodfee',
		);
		$tmdcodfee=$this->tmd->getkey($keydata['code']);
		$data['getkeyform']=$this->tmd->loadkeyform($keydata);
		$this->load->language('extension/tmdcashondelivery/total/tmdcodfee');
		
		$this->document->setTitle($this->language->get('heading_title1'));

		$this->load->model('setting/setting');
		$this->load->model('setting/extension');
		$this->load->model('customer/customer_group');
		
		$data['breadcrumbs'] = [];
		
		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];
		
		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=total')
		];
		
		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdcashondelivery/total/tmdcodfee', 'user_token=' . $this->session->data['user_token'])
		];
		
		$data['save'] = $this->url->link('extension/tmdcashondelivery/total/tmdcodfee|save', 'user_token=' . $this->session->data['user_token']);
		
		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=total');

		$data['total_tmdcodfee_status']     = $this->config->get('total_tmdcodfee_status');
		$data['total_tmdcodfee_title'] = $this->config->get('total_tmdcodfee_title');
		$data['total_tmdcodfee_taxclass'] = $this->config->get('total_tmdcodfee_taxclass');
		$data['total_tmdcodfee_sort_order'] = $this->config->get('total_tmdcodfee_sort_order');
		$data['total_tmdcodfee_geo_zone_id'] = $this->config->get('total_tmdcodfee_geo_zone_id');
		$data['total_tmdcodfee_tax_class_id'] = $this->config->get('total_tmdcodfee_tax_class_id');
		$data['total_tmdcodfee_delivery'] = $this->config->get('total_tmdcodfee_delivery');
		$data['total_tmdcodfee_delivery_fee'] = $this->config->get('total_tmdcodfee_delivery_fee');
		
		$data['tmdcodfee_priceinfos'] = $this->config->get('total_tmdcodfee_priceinfo');
		
		// language
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

        // zones
        $this->load->model('localisation/geo_zone');
		$data['geo_zones']   = $this->model_localisation_geo_zone->getGeoZones();
        $this->load->model('customer/customer_group');
		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		//shippings
			
		
		$results = $this->model_setting_extension->getPaths('%/admin/controller/shipping/%.php');

		if ($results) {
			foreach ($results as $result) {
				$extension = substr($result['path'], 0, strpos($result['path'], '/'));

				$code = basename($result['path'], '.php');

				$this->load->language('extension/' . $extension . '/shipping/' . $code, $code);
				$status=$this->config->get('shipping_' . $code . '_status');
				if($status==1){
											
				$data['extensions'][] = [
					'name'       => $this->language->get($code . '_heading_title'),
					'status'     => $this->config->get('shipping_' . $extension . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
					'code'       => $code.'.'.$code
					];
				}	
			}
		}
	
		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$data['header']      = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']      = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdcashondelivery/total/tmdcodfee', $data));
	}
	
	public function save(): void {
		$this->load->language('extension/tmdcashondelivery/total/tmdcodfee');
		$json = [];
		if (!$this->user->hasPermission('modify', 'extension/tmdcashondelivery/total/tmdcodfee')) {
			$json['error'] = $this->language->get('error_permission');
		}
		
		$tmdcodfee=$this->config->get('tmdkey_codfee');
		if (empty(trim($tmdcodfee))) {			
		$json['error'] ='Module will Work after add License key!';
		}
		
		if (!$json) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('total_tmdcodfee', $this->request->post);

			$json['success'] = $this->language->get('text_success');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function keysubmit() {
		$json = array(); 
		
      	if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$keydata=array(
			'code'=>'tmdkey_codfee',
			'eid'=>'MzcwMzk=',
			'route'=>'extension/tmdcashondelivery/total/tmdcodfee',
			'moduledata_key'=>$this->request->post['moduledata_key'],
			);
			$this->registry->set('tmd', new  \Tmdcashondelivery\System\Library\Tmd\System($this->registry));
		
            $json=$this->tmd->matchkey($keydata);       
		} 
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}