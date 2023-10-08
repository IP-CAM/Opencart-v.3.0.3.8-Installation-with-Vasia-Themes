<?php
class ModelPlazaMinify extends Model
{
    const SAMPLE_STRING = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz_';
    const SAMPLE_LENGTH = 10;

    public function createCacheFolder() {
        if($this->cache->get('cache_folder')) {
            $cache_folder = $this->cache->get('cache_folder');
        } else {
            $cache_folder = $this->getRandomString();
            $this->cache->set('cache_folder', $cache_folder);
        }

        if (!file_exists('_cached' . '/' . $this->cache->get('cache_folder'))) {
            mkdir('_cached/' . $this->cache->get('cache_folder'), 0777, true);
        }
    }

    public function createFile($filename) {
        if (!file_exists($filename)) {
            $handle = fopen($filename, 'w');

            fflush($handle);

            fclose($handle);
        }
    }

    public function getFilePath($type) {
        if (!file_exists('_cached')) {
            mkdir('_cached', 0777, true);
        }

        $this->createCacheFolder();

        $folder = '_cached/' . $this->cache->get('cache_folder') . '/';

        if($type == 'css') {
            $theme_directory = $this->config->get('theme_' . $this->config->get('config_theme') . '_directory');

            if (!file_exists($folder . $theme_directory)) {
                mkdir($folder . $theme_directory, 0777, true);
            }

            if($this->cache->get('cache_mini_css_file_path' . $theme_directory) && file_exists($this->cache->get('cache_mini_css_file_path' . $theme_directory))) {
                $cache_file = $this->cache->get('cache_mini_css_file_path' . $theme_directory);
            } else {
                $cache_file = $folder . $theme_directory . '/' . $this->getRandomString() . '.css';
                $this->cache->set('cache_mini_css_file_path' . $theme_directory, $cache_file);
            }
        }

        if($type == 'js') {
            if($this->cache->get('cache_mini_js_file_path')) {
                $cache_file = $this->cache->get('cache_mini_js_file_path');
            } else {
                $cache_file = $folder . $this->getRandomString() . '.js';
                $this->cache->set('cache_mini_js_file_path', $cache_file);
            }
        }

        if($type == 'html') {
            if($this->cache->get('cache_mini_html_file_path')) {
                $cache_file = $this->cache->get('cache_mini_html_file_path');
            } else {
                $cache_file = $folder . $this->getRandomString() . '.html';
                $this->cache->set('cache_mini_html_file_path', $cache_file);
            }
        }

        $this->createFile($cache_file);

        return $cache_file;
    }

    public function getRandomString() {
        $chars = self::SAMPLE_STRING;
        $size = strlen(self::SAMPLE_STRING);
        $str = '';
        for ($i = 0; $i < self::SAMPLE_LENGTH; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }

        return $str;
    }
}
