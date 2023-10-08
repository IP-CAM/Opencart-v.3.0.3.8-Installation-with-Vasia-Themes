<?php
class ControllerExtensionModulePtinstagram extends Controller
{
    public function index($setting) {
        $this->load->language('plaza/module/ptinstagram');

        $data = array();

        $data['text_copyright'] = sprintf($this->language->get('text_copyright'), $this->config->get('config_name'));

        if (empty($setting['limit'])) {
            $setting['limit'] = 10;
        }

        $data['error_connect']	= true;

        $access_token = $setting['access_token'];
        $url = 'https://graph.instagram.com/me/media?fields=caption,media_type,media_url,username,timestamp,permalink,like_count,comments_count&access_token=' . $access_token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $json = curl_exec($ch);
        curl_close($ch);

        $instagram_json_arrays =  json_decode($json, true);
        if(!empty($instagram_json_arrays)) {
            $instagram_arrays = $instagram_json_arrays['data'];

            foreach($instagram_arrays as $key =>  $instagram_array) {
                $like_count = 0;
                if(isset($instagram_array['like_count'])) $like_count = (int) $instagram_array['like_count'];

                $comments_count = 0;
                if(isset($instagram_array['comments_count'])) $comments_count = (int) $instagram_array['comments_count'];

                $instagrams[]= array(
                    'likes' => $like_count,
                    'thumbnail' => $instagram_array['media_url'],
                    'image' => $instagram_array['media_url'],
                    'link'  => $instagram_array['permalink'],
                    'created_time' => $instagram_array['timestamp'],
                    'comment' => $comments_count
                );

                if ($key == $setting['limit'] - 1) break;
            }

            $data['instagrams'] = $instagrams;

            $data['slider'] = array(
                'items' => $setting['item'],
                'auto' => $setting['auto'],
                'navigation' => $setting['navigation'],
                'pagination' => $setting['pagination'],
                'speed' => $setting['speed'],
                'rows' => $setting['rows'],
                'view_mode' => $setting['view_mode']
            );
        } else {
            $data['error_connect']	= false;
        }

        $store_id = $this->config->get('config_store_id');

        if (!empty($_SERVER['HTTPS'])) {
            // SSL connection
            $common_url = str_replace('http://', 'https://', $this->config->get('config_url'));
        } else {
            $common_url = $this->config->get('config_url');
        }

        if(isset($this->config->get('module_ptcontrolpanel_loader_img')[$store_id])) {
            $data['loader_img'] = $common_url . 'image/' . $this->config->get('module_ptcontrolpanel_loader_img')[$store_id];
        } else {
            $data['loader_img'] = $common_url . 'image/plaza/ajax-loader.gif';;
        }

        $data['lazy_load'] = (int) $this->config->get('module_ptcontrolpanel_lazy_load')[$store_id];

        // $this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
        // $this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');

        return $this->load->view('plaza/module/ptinstagram', $data);
    }
}
