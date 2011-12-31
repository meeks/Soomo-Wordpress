<?php

$thesis_header = new thesis_header_image;

class thesis_header_image {
	function get_header() {
		$saved_header = maybe_unserialize(get_option('thesis_header')); #wp
		if (!empty($saved_header) && is_array($saved_header))
			$this->header = $saved_header;
	}

	function process() {
		if (isset($_POST['upload'])) {
			check_admin_referer('thesis-header-upload', '_wpnonce-thesis-header-upload');
			$overrides = array('test_form' => false);
			$file = wp_handle_upload($_FILES['import'], $overrides); #wp

			if (isset($file['error']))
				wp_die($file['error'], __('Image Upload Error', 'thesis')); #wp

			$this->url = $file['url'];
			$image = $file['file'];

			list($this->width, $this->height) = getimagesize($image);

			if ($this->width <= $this->optimal_width)
				$this->save($image);
			elseif ($this->width > $this->optimal_width) {
				if (apply_filters('thesis_crop_header', true)) {
					$this->ratio = $this->width / $this->optimal_width;
					$cropped = wp_crop_image($image, 0, 0, $this->width, $this->height, $this->optimal_width, $this->height / $this->ratio, false, str_replace(basename($image), 'cropped-' . basename($image), $image)); #wp
					if (is_wp_error($cropped)) #wp
						wp_die(__('Your image could not be processed. Please go back and try again.', 'thesis'), __('Image Processing Error', 'thesis')); #wp

					$this->url = str_replace(basename($this->url), basename($cropped), $this->url);
					$this->width = round($this->width / $this->ratio);
					$this->height = round($this->height / $this->ratio);
					$this->save($cropped);
					@unlink($image);
				}
				else
					$this->save($image);
			}
		}
		elseif ($_GET['remove']) {
			global $thesis_design;
			$this->get_header();
			delete_option('thesis_header'); #wp
			unset($this->header);
			if (!$thesis_design->display['header']['tagline'] && apply_filters('thesis_header_auto_tagline', true)) { #filter
				$thesis_design->display['header']['tagline'] = true;
				update_option('thesis_design_options', $thesis_design); #wp
			}
			thesis_generate_css();
			$this->removed = true;
		}
		else
			$this->get_header();
	}

	function save($image) {
		if (!$image) return;
		global $thesis_design;
		update_option('thesis_header', array('url' => esc_url($this->url), 'width' => $this->width, 'height' => $this->height));
		if ($thesis_design->display['header']['tagline'] && apply_filters('thesis_header_auto_tagline', true)) { #filter
			$thesis_design->display['header']['tagline'] = false;
			update_option('thesis_design_options', $thesis_design); #wp
		}
		thesis_generate_css();
		$this->updated = true;
	}

	function options_page() {
		$css = new Thesis_CSS;
		$css->baselines();
		$css->widths();
		$this->optimal_width = $css->widths['container'] - ($css->base['page_padding'] * 2);
		$this->process();

		global $thesis_site;
		$rtl = (get_bloginfo('text_direction') == 'rtl') ? ' rtl' : ''; #wp
		echo "<div id=\"thesis_options\" class=\"wrap$rtl\">\n";
		thesis_version_indicator();
		thesis_options_title(__('Thesis Header Image', 'thesis'), false);
		thesis_options_nav();

		if (version_compare($thesis_site->version, thesis_version()) < 0) {
?>
	<form id="upgrade_needed" action="<?php echo admin_url('admin-post.php?action=thesis_upgrade'); ?>" method="post">
		<h3><?php _e('Oooh, Exciting!', 'thesis'); ?></h3>
		<p><?php _e('It&#8217;s time to upgrade your Thesis, which means there&#8217;s new awesomeness in your immediate future. Click the button below to fast-track your way to the awesomeness!', 'thesis'); ?></p>
		<p><input type="submit" class="upgrade_button" id="teh_upgrade" name="upgrade" value="<?php _e('Upgrade Thesis', 'thesis'); ?>" /></p>
	</form>
<?php
		}
		else {
			if ($this->updated)
				echo "<div id=\"updated\" class=\"updated fade\">\n\t<p>" . __('Header image updated!', 'thesis') . ' <a href="' . get_bloginfo('url') . '/">' . __('Check out your site &rarr;', 'thesis') . "</a></p>\n</div>\n";
			elseif ($this->removed)
				echo "<div id=\"updated\" class=\"updated fade\">\n\t<p>" . __('Header image removed!', 'thesis') . ' <a href="' . get_bloginfo('url') . '/">' . __('Check out your site &rarr;', 'thesis') . "</a></p>\n</div>\n";

			if ($this->header)
				echo "<div id=\"header_preview\">\n\t<img src=\"{$this->header['url']}\" width=\"{$this->header['width']}\" height=\"{$this->header['height']}\" alt=\"header image preview\" title=\"header image preview\" />\n\t<a href=\"" . admin_url('admin.php?page=thesis-header-image&remove=true') . "\" title=\"" . __('Click here to remove this header image', 'thesis') . "\">" . __('Remove Image', 'thesis') . "</a>\n</div>\n";
?>
	<div class="one_col">
		<div class="control_area">
			<p><?php printf(__('Based on your <a href="%1$s">current layout settings</a>, the optimal header image width is <strong>%2$d pixels</strong>. If your image is wider than this, don&#8217;t worry&#8212;Thesis will automatically crop it for you!', 'thesis'), admin_url('admin.php?page=thesis-design-options#layout-constructor'), $this->optimal_width); ?></p>
			<form enctype="multipart/form-data" id="upload-form" method="post" action="<?php echo admin_url('admin.php?page=thesis-header-image'); ?>">
				<p class="remove_bottom_margin">
					<label for="upload"><?php _e('Choose an image from your computer:', 'thesis'); ?></label>
					<input type="file" class="text" id="upload" name="import" />
					<?php wp_nonce_field('thesis-header-upload', '_wpnonce-thesis-header-upload') ?>
					<input type="submit" class="ui_button positive" name="upload" value="<?php esc_attr_e('Upload', 'thesis'); ?>" />
				</p>
			</form>
		</div>
	</div>
<?php
		}
	}
}