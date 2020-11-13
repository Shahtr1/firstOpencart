<?php
namespace Opencart\Application\Controller\Extension\Opencart\Report;
class SaleCoupon extends \Opencart\System\Engine\Controller {
	public function index() {
		$this->load->language('extension/opencart/report/sale_coupon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('report_sale_coupon', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=report'));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=report')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/opencart/report/sale_coupon', 'user_token=' . $this->session->data['user_token'])
		];

		$data['action'] = $this->url->link('extension/opencart/report/sale_coupon', 'user_token=' . $this->session->data['user_token']);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=report');

		if (isset($this->request->post['report_sale_coupon_status'])) {
			$data['report_sale_coupon_status'] = $this->request->post['report_sale_coupon_status'];
		} else {
			$data['report_sale_coupon_status'] = $this->config->get('report_sale_coupon_status');
		}

		if (isset($this->request->post['report_sale_coupon_sort_order'])) {
			$data['report_sale_coupon_sort_order'] = $this->request->post['report_sale_coupon_sort_order'];
		} else {
			$data['report_sale_coupon_sort_order'] = $this->config->get('report_sale_coupon_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/opencart/report/sale_coupon_form', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/opencart/report/sale_coupon')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
		
	public function report() {
		$this->load->language('extension/opencart/report/sale_coupon');

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$this->load->model('extension/opencart/report/coupon');

		$data['coupons'] = [];

		$filter_data = [
			'filter_date_start'	=> $filter_date_start,
			'filter_date_end'	=> $filter_date_end,
			'start'             => ($page - 1) * $this->config->get('config_pagination'),
			'limit'             => $this->config->get('config_pagination')
		];

		$coupon_total = $this->model_extension_opencart_report_coupon->getTotalCoupons($filter_data);

		$results = $this->model_extension_opencart_report_coupon->getCoupons($filter_data);

		foreach ($results as $result) {
			$data['coupons'][] = [
				'name'   => $result['name'],
				'code'   => $result['code'],
				'orders' => $result['orders'],
				'total'  => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'edit'   => $this->url->link('marketing/coupon/edit', 'user_token=' . $this->session->data['user_token'] . '&coupon_id=' . $result['coupon_id'])
			];
		}

		$data['user_token'] = $this->session->data['user_token'];

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $coupon_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination'),
			'url'   => $this->url->link('extension/opencart/report/sale_coupon|report', 'user_token=' . $this->session->data['user_token'] . '&code=sale_coupon' . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($coupon_total) ? (($page - 1) * $this->config->get('config_pagination')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination')) > ($coupon_total - $this->config->get('config_pagination'))) ? $coupon_total : ((($page - 1) * $this->config->get('config_pagination')) + $this->config->get('config_pagination')), $coupon_total, ceil($coupon_total / $this->config->get('config_pagination')));

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;

		$this->response->setOutput($this->load->view('extension/opencart/report/sale_coupon', $data));
	}
}