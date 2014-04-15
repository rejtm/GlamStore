<?php
class ControllerModuleFeaturedarticle extends Controller {
	protected function index($setting) {
		$this->language->load('module/featuredarticle');
		$this->load->model('blog/article');
 
		
		$this->load->model('blog/article');		
		$this->load->model('tool/image');	

		$this->data['articles'] = array();
		
		$articles = explode(',', $this->config->get('featuredarticle'));		

		if (empty($setting['limit'])) {
			$setting['limit'] = 5;
		}
		
		if ($setting['text_limit'] > 0) {
			$text_limit = $setting['text_limit'];
		} else {
			$text_limit = 50;
		}

		if (isset($results)) {
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = false;
			}
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
							
			$this->data['articles'][] = array(
				'article_id' => $result['article_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $text_limit) . '',
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'viewed'      => $result['viewed'],
				'rating'     => $rating,
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('blog/article', 'article_id=' . $result['article_id']),
			);
		}

		if ((file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featuredarticle.tpl'))and (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featuredarticle_middle.tpl')))     {
			$this->template = $this->config->get('config_template') . '/template/module/featuredarticle.tpl';
		} else {
			$this->template = 'default/template/module/featuredarticle.tpl';
		}

		$this->render();
	}
}
?>