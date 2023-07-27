<?php
//lib
require_once(DIR_SYSTEM.'library/tmd/system.php');
//lib
class ControllerExtensionTotalTmdcodfee extends Controller {
	private $error = array();

	public function index() {
		$this->registry->set('tmd', new TMD($this->registry));
		$keydata=array(
		'code'=>'tmdkey_codfee',
		'eid'=>'MzcwMzk=',
		'route'=>'extension/total/tmdcodfee',
		);
		$tmdcodfee=$this->tmd->getkey($keydata['code']);
		$data['getkeyform']=$this->tmd->loadkeyform($keydata);
		$this->load->language('extension/total/tmdcodfee');

		$this->document->setTitle($this->language->get('heading_title1'));

		$this->load->model('setting/setting');
		$this->load->model('customer/customer_group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('tmdcodfee', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			
			if(isset($this->request->get['status'])){
			$this->response->redirect($this->url->link('extension/total/tmdcodfee', 'token=' . $this->session->data['token'] . '&type=module', true));
			}
			else{
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', true));
			}
		}

		$data['heading_title1'] = $this->language->get('heading_title1');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_fixed'] = $this->language->get('text_fixed');
		$data['text_percentage'] = $this->language->get('text_percentage');
		$data['text_flatrate'] = $this->language->get('text_flatrate');
		$data['text_min'] = $this->language->get('text_min');
		$data['text_max'] = $this->language->get('text_max');
		$data['text_Restrict_cod'] = $this->language->get('text_Restrict_cod');
		$data['text_Restrict_codfee'] = $this->language->get('text_Restrict_codfee');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_add'] = $this->language->get('button_add');

		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_range'] = $this->language->get('entry_range');
		$data['entry_feetype'] = $this->language->get('entry_feetype');
		$data['entry_codfee'] = $this->language->get('entry_codfee');
		$data['entry_customcss'] = $this->language->get('entry_customcss');
		$data['help_Restrict_cod'] = $this->language->get('help_Restrict_cod');
		$data['flatrate'] = $this->language->get('flatrate');
		$data['help_Restrict_codfee'] = $this->language->get('help_Restrict_codfee');
	
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_fee'] = $this->language->get('tab_fee');
		$data['tab_custom'] = $this->language->get('tab_custom');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_savestay'] = $this->language->get('button_savestay');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/total/tmdcodfee', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/total/tmdcodfee', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', true);

		$data['staysave'] = $this->url->link('extension/total/tmdcodfee', '&status=1&token=' . $this->session->data['token'], true);

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		if (isset($this->request->post['tmdcodfee_status'])) {
			$data['tmdcodfee_status'] = $this->request->post['tmdcodfee_status'];
		} else {
			$data['tmdcodfee_status'] = $this->config->get('tmdcodfee_status');
		}
		
	
		if (isset($this->request->post['tmdcodfee_geo_zone_id'])) {
			$data['tmdcodfee_geo_zone_id'] = $this->request->post['tmdcodfee_geo_zone_id'];
		} else {
			$data['tmdcodfee_geo_zone_id'] = $this->config->get('tmdcodfee_geo_zone_id');
		}

		if (isset($this->request->post['tmdcodfee_title'])) {
			$data['tmdcodfee_title'] = $this->request->post['tmdcodfee_title'];
		} else {
			$data['tmdcodfee_title'] = $this->config->get('tmdcodfee_title');
		}


		if (isset($this->request->post['tmdcodfee_taxclass'])) {
			$data['tmdcodfee_taxclass'] = $this->request->post['tmdcodfee_taxclass'];
		} else {
			$data['tmdcodfee_taxclass'] = $this->config->get('tmdcodfee_taxclass');
		}

	
		if (isset($this->request->post['tmdcodfee_priceinfo'])) {
			$data['tmdcodfee_priceinfos'] = $this->request->post['tmdcodfee_priceinfo'];
		} elseif(!empty($this->config->get('tmdcodfee_priceinfo'))) {
			$data['tmdcodfee_priceinfos'] = $this->config->get('tmdcodfee_priceinfo');
		}else{
			$data['tmdcodfee_priceinfos']=array();
		}


		if (isset($this->request->post['tmdcodfee_sort_order'])) {
			$data['tmdcodfee_sort_order'] = $this->request->post['tmdcodfee_sort_order'];
		} else {
			$data['tmdcodfee_sort_order'] = $this->config->get('tmdcodfee_sort_order');
		}
		if (isset($this->request->post['tmdcodfee_customcss'])) {
			$data['tmdcodfee_customcss'] = $this->request->post['tmdcodfee_customcss'];
		} else {
			$data['tmdcodfee_customcss'] = $this->config->get('tmdcodfee_customcss');
		}
		
		if (isset($this->request->post['tmdcodfee_delivery'])) {
			$data['tmdcodfee_delivery'] = $this->request->post['tmdcodfee_delivery'];
		} elseif(!empty($this->config->get('tmdcodfee_delivery'))) {
			$data['tmdcodfee_delivery'] = $this->config->get('tmdcodfee_delivery');
		}else{
			$data['tmdcodfee_delivery']=array();
		}
		if (isset($this->request->post['tmdcodfee_delivery_fee'])) {
			$data['tmdcodfee_delivery_fee'] = $this->request->post['tmdcodfee_delivery_fee'];
		} elseif(!empty($this->config->get('tmdcodfee_delivery_fee'))) {
			$data['tmdcodfee_delivery_fee'] = $this->config->get('tmdcodfee_delivery_fee');
		}else{
			$data['tmdcodfee_delivery_fee']=array();
		}
		

		//shippings
		$this->load->model('extension/extension');

		$extensions = $this->model_extension_extension->getInstalled('shipping');

		foreach ($extensions as $key => $value) {
			if (!is_file(DIR_APPLICATION . 'controller/extension/shipping/' . $value . '.php') && !is_file(DIR_APPLICATION . 'controller/shipping/' . $value . '.php')) {
				$this->model_extension_extension->uninstall('shipping', $value);

				unset($extensions[$key]);
			}
		}

		$data['extensions'] = array();

		// Compatibility code for old extension folders
		$files = glob(DIR_APPLICATION . 'controller/{extension/shipping,shipping}/*.php', GLOB_BRACE);

		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');

				$this->load->language('extension/shipping/' . $extension);

					if($this->config->get($extension . '_status')==1){
											

				$data['extensions'][] = array(
					'name'       => $this->language->get('heading_title'),
					'status'     => $this->config->get($extension . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
					'code'     => $extension.'.'.$extension
				);
				}	

			}
		}


		$this->load->model('localisation/geo_zone');
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
			
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/total/tmdcodfee', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/total/tmdcodfee')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$tmdcodfee=$this->config->get('tmdkey_codfee');
		if (empty(trim($tmdcodfee))) {			
		$this->error['warning'] ='Module will Work after add License key!';
		}

		return !$this->error;
	}
	
	public function keysubmit() {
		$json = array(); 
		
      	if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$keydata=array(
			'code'=>'tmdkey_codfee',
			'eid'=>'MzcwMzk=',
			'route'=>'extension/total/tmdcodfee',
			'moduledata_key'=>$this->request->post['moduledata_key'],
			);
			$this->registry->set('tmd', new TMD($this->registry));
            $json=$this->tmd->matchkey($keydata);       
		} 
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}