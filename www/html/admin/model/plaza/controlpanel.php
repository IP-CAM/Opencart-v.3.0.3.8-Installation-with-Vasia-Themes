<?php
class ModelPlazaControlpanel extends Model
{
    public function setupData() {
        $this->setupBlogData();
        $this->setupSliderData();
        $this->setupTestimonialData();
        $this->setupMenuData();
        $this->setupFeaturedCategories();
        $this->setupNewsletter();
        $this->setupRotateImage();
        $this->setupColorSwatches();
    }

    public function setupBlogData() {
        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptpost` (
			    `post_id` INT(11) NOT NULL AUTO_INCREMENT,
	            `status` TINYINT(1) NOT NULL DEFAULT '0',
	            `sort_order` INT(11) NOT NULL DEFAULT '0',
	            `image` varchar(255) DEFAULT NULL,
	            `author` varchar(100) DEFAULT NULL,
	            `date_added` DATETIME NOT NULL,
	            `date_modified` DATETIME NOT NULL,
	        PRIMARY KEY (`post_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptpost_description` (
			    `post_id` INT(11) NOT NULL,
                `language_id` INT(11) NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                `description` TEXT NOT NULL,
                `intro_text` TEXT NOT NULL,
                `meta_title` VARCHAR(255) NOT NULL,
                `meta_description` VARCHAR(255) NOT NULL,
                `meta_keyword` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`post_id`, `language_id`),
	        INDEX `name` (`name`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptpost_comment` (
			    `comment_id` INT(11) NOT NULL AUTO_INCREMENT,
                `post_id` INT(11) NOT NULL,
                `reply_comment_id` INT(11) DEFAULT NULL,
                `author` VARCHAR(255) NOT NULL,
                `comment` TEXT NOT NULL,
                `date_submitted` DATETIME NOT NULL,
                `approved` TINYINT(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`comment_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptpost_list` (
			    `post_list_id` INT(11) NOT NULL AUTO_INCREMENT,
                `status` TINYINT(1) NOT NULL DEFAULT '0',
                `sort_order` INT(11) NOT NULL DEFAULT '0',
            PRIMARY KEY (`post_list_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptpost_list_description` (
			    `post_list_id` INT(11) NOT NULL,
                `language_id` INT(11) NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                `description` TEXT NOT NULL,
                `meta_title` VARCHAR(255) NOT NULL,
                `meta_description` VARCHAR(255) NOT NULL,
                `meta_keyword` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`post_list_id`, `language_id`),
	        INDEX `name` (`name`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptpost_to_list` (
			    `post_list_id` INT(11) NOT NULL,
                `post_id` INT(11) NOT NULL
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptpost_to_store` (
			    `post_id` INT(11) NOT NULL,
                `store_id` INT(11) NOT NULL
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptpost_list_to_store` (
			    `post_list_id` INT(11) NOT NULL,
                `store_id` INT(11) NOT NULL
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptpost_related_post` (
			    `post_id` INT(11) NOT NULL,
                `related_post_id` INT(11) NOT NULL
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->load->model('user/user_group');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'plaza/blog');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'plaza/blog');

        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'plaza/blog/post');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'plaza/blog/post');

        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'plaza/blog/list');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'plaza/blog/list');
        
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'plaza/blog/setting');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'plaza/blog/setting');
    }

    public function setupSliderData() {
        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptslider` (
                `ptslider_id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(64) NOT NULL,
                `status` tinyint(1) NOT NULL,
                `auto` tinyint(1) DEFAULT NULL,
                `delay` int(11) DEFAULT NULL,
                `hover` tinyint(1) DEFAULT NULL,
                `nextback` tinyint(1) DEFAULT NULL,
                `contrl` tinyint(1) DEFAULT NULL,
                `effect` varchar(64) NOT NULL,
                PRIMARY KEY (`ptslider_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptslider_image` (
                `ptslider_image_id` int(11) NOT NULL AUTO_INCREMENT,
                `ptslider_id` int(11) NOT NULL,
                `link` varchar(255) NOT NULL,
                `type` int(11) NOT NULL,
                `slider_store` varchar(110) DEFAULT '0',
                `image` varchar(255) NOT NULL,
                `secondary_image` varchar(255) DEFAULT NULL,
                PRIMARY KEY (`ptslider_image_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptslider_image_description` (
                `ptslider_image_id` int(11) NOT NULL,
                `ptslider_id` int(11) NOT NULL,
                `language_id` int(11) NOT NULL,
                `title` varchar(64) NOT NULL,
                `sub_title` varchar(64) DEFAULT NULL,
                `description` text,
                PRIMARY KEY (`ptslider_image_id`,`language_id`)
		) DEFAULT COLLATE=utf8_general_ci;");
        
        $this->load->model('user/user_group');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'plaza/slider');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'plaza/slider');
    }

    public function setupTestimonialData() {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pttestimonial` (
                `pttestimonial_id` int(11) NOT NULL AUTO_INCREMENT,
                `status` int(1) NOT NULL DEFAULT '0',
                `sort_order` int(11) NOT NULL DEFAULT '0',
            PRIMARY KEY (`pttestimonial_id`)
        ) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pttestimonial_description`(
                `pttestimonial_id` int(11) unsigned NOT NULL,
                `language_id` int(11) NOT NULL,
                `image` varchar(255) NOT NULL,
                `customer_name` varchar(255) NOT NULL,
                `content` text,
                PRIMARY KEY (`pttestimonial_id`,`language_id`)
            ) DEFAULT COLLATE=utf8_general_ci;");

        $this->load->model('user/user_group');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'plaza/testimonial');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'plaza/testimonial');
    }

    public function setupMenuData() {
        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptmegamenu` (
			    `menu_id` INT(11) NOT NULL AUTO_INCREMENT,
	            `status` TINYINT(1) NOT NULL DEFAULT '0',
	            `name` VARCHAR(255) NOT NULL,
	            `menu_type` VARCHAR(255) NOT NULL,
	        PRIMARY KEY (`menu_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptmegamenu_top_item` (
			    `menu_item_id` INT(11) NOT NULL AUTO_INCREMENT,
			    `menu_id` INT(11) NOT NULL,
	            `status` TINYINT(1) NOT NULL DEFAULT '0',
	            `has_title` TINYINT(1) NOT NULL DEFAULT '0',
	            `has_link` TINYINT(1) NOT NULL DEFAULT '0',
	            `has_child` TINYINT(1) NOT NULL DEFAULT '0',
                `category_id` INT(11),
                `position` INT(11) NOT NULL DEFAULT '0',
	            `name` VARCHAR(255) NOT NULL,
	            `link` VARCHAR(255),
	            `icon` VARCHAR(255),
	            `item_align` VARCHAR(255) NOT NULL,
	            `sub_menu_type` VARCHAR(255) NOT NULL,
	            `sub_menu_content_type` VARCHAR(255) NOT NULL,
	            `sub_menu_content_columns` INT(11),
	            `sub_menu_content_width` VARCHAR(100),
	            `sub_menu_content` text,
	        PRIMARY KEY (`menu_item_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptmegamenu_top_item_description` (
			    `menu_item_id` INT(11) NOT NULL,
			    `language_id` int(11) NOT NULL,
	            `title` VARCHAR(255) NOT NULL,
	            PRIMARY KEY (`menu_item_id`,`language_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptmegamenu_sub_item` (
			    `sub_menu_item_id` INT(11) NOT NULL AUTO_INCREMENT,
			    `parent_menu_item_id` INT(11) NOT NULL,
			    `level` INT(11) NOT NULL,
	            `status` TINYINT(1) NOT NULL DEFAULT '0',
	            `name` VARCHAR(255) NOT NULL,
	            `position` INT(11) NOT NULL,
	            `link` VARCHAR(255),
	        PRIMARY KEY (`sub_menu_item_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptmegamenu_sub_item_description` (
			    `sub_menu_item_id` INT(11) NOT NULL,
			    `language_id` int(11) NOT NULL,
	            `title` VARCHAR(255) NOT NULL,
	            PRIMARY KEY (`sub_menu_item_id`,`language_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->load->model('user/user_group');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'plaza/ultimatemenu');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'plaza/ultimatemenu');
    }

    public function setupFeaturedCategories() {
        $this->load->model('user/user_group');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'plaza/featuredcate');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'plaza/featuredcate');

        $this->load->model('plaza/featuredcate');
        $this->model_plaza_featuredcate->createFeaturedCate();
    }

    public function setupNewsletter() {
        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ptnewsletter_email` (
			    `newsletter_id` INT(11) NOT NULL AUTO_INCREMENT,
			    `subscribe` TINYINT(1) NOT NULL DEFAULT '1',
	            `mail` varchar(255) NOT NULL,
	        PRIMARY KEY (`newsletter_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

        $this->load->model('user/user_group');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'plaza/newsletter');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'plaza/newsletter');
    }

    public function setupRotateImage() {
        $query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_image` LIKE 'is_rotate'");
        if($query->rows) {
            return;
        } else {
            $sql = "ALTER TABLE `" . DB_PREFIX . "product_image` ADD `is_rotate` tinyint(1) DEFAULT 0";
            $this->db->query($sql);
            return;
        }
    }

    public function setupColorSwatches() {
        $query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_image` LIKE 'product_option_value_id'");
        if($query->rows) {
            return;
        } else {
            $sql = "ALTER TABLE `" . DB_PREFIX . "product_image` ADD `product_option_value_id` INT(11) NULL";
            $this->db->query($sql);
            return;
        }
    }

    public function refreshModifications() {
        $this->load->model('setting/modification');

        if ($this->validateRefreshModifications()) {
            // Just before files are deleted, if config settings say maintenance mode is off then turn it on
            $maintenance = $this->config->get('config_maintenance');

            $this->load->model('setting/setting');

            $this->model_setting_setting->editSettingValue('config', 'config_maintenance', true);

            //Log
            $log = array();

            // Clear all modification files
            $files = array();

            // Make path into an array
            $path = array(DIR_MODIFICATION . '*');

            // While the path array is still populated keep looping through
            while (count($path) != 0) {
                $next = array_shift($path);

                foreach (glob($next) as $file) {
                    // If directory add to path array
                    if (is_dir($file)) {
                        $path[] = $file . '/*';
                    }

                    // Add the file to the files to be deleted array
                    $files[] = $file;
                }
            }

            // Reverse sort the file array
            rsort($files);

            // Clear all modification files
            foreach ($files as $file) {
                if ($file != DIR_MODIFICATION . 'index.html') {
                    // If file just delete
                    if (is_file($file)) {
                        unlink($file);

                        // If directory use the remove directory function
                    } elseif (is_dir($file)) {
                        rmdir($file);
                    }
                }
            }

            // Begin
            $xml = array();

            // Load the default modification XML
            $xml[] = file_get_contents(DIR_SYSTEM . 'modification.xml');

            // This is purly for developers so they can run mods directly and have them run without upload after each change.
            $files = glob(DIR_SYSTEM . '*.ocmod.xml');

            if ($files) {
                foreach ($files as $file) {
                    $xml[] = file_get_contents($file);
                }
            }

            // Get the default modification file
            $results = $this->model_setting_modification->getModifications();

            foreach ($results as $result) {
                if ($result['status']) {
                    $xml[] = $result['xml'];
                }
            }

            $modification = array();

            foreach ($xml as $xml) {
                if (empty($xml)){
                    continue;
                }

                $dom = new DOMDocument('1.0', 'UTF-8');
                $dom->preserveWhiteSpace = false;
                $dom->loadXml($xml);

                // Log
                $log[] = 'MOD: ' . $dom->getElementsByTagName('name')->item(0)->textContent;

                // Wipe the past modification store in the backup array
                $recovery = array();

                // Set the a recovery of the modification code in case we need to use it if an abort attribute is used.
                if (isset($modification)) {
                    $recovery = $modification;
                }

                $files = $dom->getElementsByTagName('modification')->item(0)->getElementsByTagName('file');

                foreach ($files as $file) {
                    $operations = $file->getElementsByTagName('operation');

                    $files = explode('|', $file->getAttribute('path'));

                    foreach ($files as $file) {
                        $path = '';

                        // Get the full path of the files that are going to be used for modification
                        if ((substr($file, 0, 7) == 'catalog')) {
                            $path = DIR_CATALOG . substr($file, 8);
                        }

                        if ((substr($file, 0, 5) == 'admin')) {
                            $path = DIR_APPLICATION . substr($file, 6);
                        }

                        if ((substr($file, 0, 6) == 'system')) {
                            $path = DIR_SYSTEM . substr($file, 7);
                        }

                        if ($path) {
                            $files = glob($path, GLOB_BRACE);

                            if ($files) {
                                foreach ($files as $file) {
                                    // Get the key to be used for the modification cache filename.
                                    if (substr($file, 0, strlen(DIR_CATALOG)) == DIR_CATALOG) {
                                        $key = 'catalog/' . substr($file, strlen(DIR_CATALOG));
                                    }

                                    if (substr($file, 0, strlen(DIR_APPLICATION)) == DIR_APPLICATION) {
                                        $key = 'admin/' . substr($file, strlen(DIR_APPLICATION));
                                    }

                                    if (substr($file, 0, strlen(DIR_SYSTEM)) == DIR_SYSTEM) {
                                        $key = 'system/' . substr($file, strlen(DIR_SYSTEM));
                                    }

                                    // If file contents is not already in the modification array we need to load it.
                                    if (!isset($modification[$key])) {
                                        $content = file_get_contents($file);

                                        $modification[$key] = preg_replace('~\r?\n~', "\n", $content);
                                        $original[$key] = preg_replace('~\r?\n~', "\n", $content);

                                        // Log
                                        $log[] = PHP_EOL . 'FILE: ' . $key;
                                    }

                                    foreach ($operations as $operation) {
                                        $error = $operation->getAttribute('error');

                                        // Ignoreif
                                        $ignoreif = $operation->getElementsByTagName('ignoreif')->item(0);

                                        if ($ignoreif) {
                                            if ($ignoreif->getAttribute('regex') != 'true') {
                                                if (strpos($modification[$key], $ignoreif->textContent) !== false) {
                                                    continue;
                                                }
                                            } else {
                                                if (preg_match($ignoreif->textContent, $modification[$key])) {
                                                    continue;
                                                }
                                            }
                                        }

                                        $status = false;

                                        // Search and replace
                                        if ($operation->getElementsByTagName('search')->item(0)->getAttribute('regex') != 'true') {
                                            // Search
                                            $search = $operation->getElementsByTagName('search')->item(0)->textContent;
                                            $trim = $operation->getElementsByTagName('search')->item(0)->getAttribute('trim');
                                            $index = $operation->getElementsByTagName('search')->item(0)->getAttribute('index');

                                            // Trim line if no trim attribute is set or is set to true.
                                            if (!$trim || $trim == 'true') {
                                                $search = trim($search);
                                            }

                                            // Add
                                            $add = $operation->getElementsByTagName('add')->item(0)->textContent;
                                            $trim = $operation->getElementsByTagName('add')->item(0)->getAttribute('trim');
                                            $position = $operation->getElementsByTagName('add')->item(0)->getAttribute('position');
                                            $offset = $operation->getElementsByTagName('add')->item(0)->getAttribute('offset');

                                            if ($offset == '') {
                                                $offset = 0;
                                            }

                                            // Trim line if is set to true.
                                            if ($trim == 'true') {
                                                $add = trim($add);
                                            }

                                            // Log
                                            $log[] = 'CODE: ' . $search;

                                            // Check if using indexes
                                            if ($index !== '') {
                                                $indexes = explode(',', $index);
                                            } else {
                                                $indexes = array();
                                            }

                                            // Get all the matches
                                            $i = 0;

                                            $lines = explode("\n", $modification[$key]);

                                            for ($line_id = 0; $line_id < count($lines); $line_id++) {
                                                $line = $lines[$line_id];

                                                // Status
                                                $match = false;

                                                // Check to see if the line matches the search code.
                                                if (stripos($line, $search) !== false) {
                                                    // If indexes are not used then just set the found status to true.
                                                    if (!$indexes) {
                                                        $match = true;
                                                    } elseif (in_array($i, $indexes)) {
                                                        $match = true;
                                                    }

                                                    $i++;
                                                }

                                                // Now for replacing or adding to the matched elements
                                                if ($match) {
                                                    switch ($position) {
                                                        default:
                                                        case 'replace':
                                                            $new_lines = explode("\n", $add);

                                                            if ($offset < 0) {
                                                                array_splice($lines, $line_id + $offset, abs($offset) + 1, array(str_replace($search, $add, $line)));

                                                                $line_id -= $offset;
                                                            } else {
                                                                array_splice($lines, $line_id, $offset + 1, array(str_replace($search, $add, $line)));
                                                            }
                                                            break;
                                                        case 'before':
                                                            $new_lines = explode("\n", $add);

                                                            array_splice($lines, $line_id - $offset, 0, $new_lines);

                                                            $line_id += count($new_lines);
                                                            break;
                                                        case 'after':
                                                            $new_lines = explode("\n", $add);

                                                            array_splice($lines, ($line_id + 1) + $offset, 0, $new_lines);

                                                            $line_id += count($new_lines);
                                                            break;
                                                    }

                                                    // Log
                                                    $log[] = 'LINE: ' . $line_id;

                                                    $status = true;
                                                }
                                            }

                                            $modification[$key] = implode("\n", $lines);
                                        } else {
                                            $search = trim($operation->getElementsByTagName('search')->item(0)->textContent);
                                            $limit = $operation->getElementsByTagName('search')->item(0)->getAttribute('limit');
                                            $replace = trim($operation->getElementsByTagName('add')->item(0)->textContent);

                                            // Limit
                                            if (!$limit) {
                                                $limit = -1;
                                            }

                                            // Log
                                            $match = array();

                                            preg_match_all($search, $modification[$key], $match, PREG_OFFSET_CAPTURE);

                                            // Remove part of the the result if a limit is set.
                                            if ($limit > 0) {
                                                $match[0] = array_slice($match[0], 0, $limit);
                                            }

                                            if ($match[0]) {
                                                $log[] = 'REGEX: ' . $search;

                                                for ($i = 0; $i < count($match[0]); $i++) {
                                                    $log[] = 'LINE: ' . (substr_count(substr($modification[$key], 0, $match[0][$i][1]), "\n") + 1);
                                                }

                                                $status = true;
                                            }

                                            // Make the modification
                                            $modification[$key] = preg_replace($search, $replace, $modification[$key], $limit);
                                        }

                                        if (!$status) {
                                            // Abort applying this modification completely.
                                            if ($error == 'abort') {
                                                $modification = $recovery;
                                                // Log
                                                $log[] = 'NOT FOUND - ABORTING!';
                                                break 5;
                                            }
                                            // Skip current operation or break
                                            elseif ($error == 'skip') {
                                                // Log
                                                $log[] = 'NOT FOUND - OPERATION SKIPPED!';
                                                continue;
                                            }
                                            // Break current operations
                                            else {
                                                // Log
                                                $log[] = 'NOT FOUND - OPERATIONS ABORTED!';
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // Log
                $log[] = '----------------------------------------------------------------';
            }

            // Log
            $ocmod = new Log('ocmod.log');
            $ocmod->write(implode("\n", $log));

            // Write all modification files
            foreach ($modification as $key => $value) {
                // Only create a file if there are changes
                if ($original[$key] != $value) {
                    $path = '';

                    $directories = explode('/', dirname($key));

                    foreach ($directories as $directory) {
                        $path = $path . '/' . $directory;

                        if (!is_dir(DIR_MODIFICATION . $path)) {
                            @mkdir(DIR_MODIFICATION . $path, 0777);
                        }
                    }

                    $handle = fopen(DIR_MODIFICATION . $key, 'w');

                    fwrite($handle, $value);

                    fclose($handle);
                }
            }

            // Maintance mode back to original settings
            $this->model_setting_setting->editSettingValue('config', 'config_maintenance', $maintenance);
        }
    }

    public function validateRefreshModifications() {
        if (!$this->user->hasPermission('modify', 'marketplace/modification')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}