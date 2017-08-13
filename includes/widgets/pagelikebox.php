<?php

/**
 * Class IMFBW_Widget_Facebook_Pagelikebox
 */
class IMFBW_Widget_Facebook_Pagelikebox extends WP_Widget {

  /**
   * IMFBW_Widget_Facebook_Pagelikebox constructor.
   */
  function __construct() {
    parent::__construct(
      'imfbw_widget_facebook_pagelikebox',
      __('IM Facebook Page Plugin', IMFBW_PLUGIN_NAME),
      array(
          'description' => __('Widget for Facebook fanpage like, share, timeline, events, messages and more options.', IMFBW_PLUGIN_NAME),
      )
    );
  }

  /**
   * Widget for frontend
   *
   * @param $args
   * @param $instance
   */
  public function widget($args, $instance) {

    extract($args);

    $title = apply_filters('widget_title', $instance['title']);
    $appid = !empty($instance['appid']) ? absint($instance['appid']) : '100105656749740';
    $url = !empty($instance['url']) ? esc_attr($instance['url']) : 'https://www.facebook.com/AS.Trencin/?fref=ts';
    $tabs = !empty($instance['tabs']) ? esc_attr($instance['tabs']) : '';
    $width = !empty($instance['width']) ? absint($instance['width']) : '340';
    $height = !empty($instance['height']) ? absint($instance['height']) : '500';
    $current_language = !empty($instance['language']) ? esc_attr($instance['language']) : 'en_US';
    $hide_cover = ($instance['hide_cover'] == 1) ? 'true' : 'false';
    $show_facepile = ($instance['show_facepile'] == 1) ? 'true' : 'false';
    $hide_cta = ($instance['hide_cta'] == 1) ? 'true' : 'false';
    $small_header = ($instance['small_header'] == 1) ? 'true' : 'false';
    $adapt_container_width = ($instance['adapt_container_width'] == 1) ? 'true' : 'false';

    wp_localize_script(
        'imfbw',
        'imfbw_var',
        array(
            'language'  => $current_language,
            'appid'     => $appid
        )
    );
    wp_enqueue_script('imfbw');

		echo $before_widget;

    ?>
    <div class="imfbw-box">
    	<?php
      if ($title) {
        echo $before_title . $title . $after_title;
      }
      ?>
      <div id="fb-root"></div>
			<div class="fb-page"
           data-href="<?php echo $url; ?>"
           data-tabs="<?php echo $tabs; ?>"
           data-width="<?php echo $width; ?>"
           data-height="<?php echo $height; ?>"
           data-small-header="<?php echo $small_header; ?>"
           data-adapt-container-width="<?php echo $adapt_container_width; ?>"
           data-hide-cta="<?php echo $hide_cta; ?>"
           data-hide-cover="<?php echo $hide_cover; ?>"
           data-show-facepile="<?php echo $show_facepile; ?>">
      </div>
		</div>
    <?php

		echo $after_widget;

  }

  /**
   * Widget form for backend
   *
   * @param $instance
   */
  public function form($instance) {

    $title = !empty($instance['title']) ? esc_attr($instance['title']) : '';
    $appid = !empty($instance['appid']) ? absint($instance['appid']) : '100105656749740';
    $url = !empty($instance['url']) ? esc_attr($instance['url']) : 'https://www.facebook.com/AS.Trencin/?fref=ts';
    $tabs = !empty($instance['tabs']) ? esc_attr($instance['tabs']) : '';
    $width = !empty($instance['width']) ? absint($instance['width']) : '340';
    $height = !empty($instance['height']) ? absint($instance['height']) : '500';
    $current_language = !empty($instance['language']) ? esc_attr($instance['language']) : 'en_US';
    $hide_cover = isset($instance['hide_cover']) ? (bool) $instance['hide_cover'] : false;
    $show_facepile = isset($instance['show_facepile']) ? (bool) $instance['show_facepile'] : true;
    $hide_cta = isset($instance['hide_cta']) ? (bool) $instance['hide_cta'] : false;
    $small_header = isset($instance['small_header']) ? (bool) $instance['small_header'] : false;
    $adapt_container_width = isset($instance['adapt_container_width']) ? (bool) $instance['adapt_container_width'] : true;

    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', IMFBW_PLUGIN_NAME); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
      <span class="description"><?php _e('Widget name.', IMFBW_PLUGIN_NAME); ?></span>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('appid'); ?>"><?php _e('App ID:', IMFBW_PLUGIN_NAME); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('appid'); ?>" name="<?php echo $this->get_field_name('appid'); ?>" type="text" value="<?php echo esc_attr($appid); ?>">
      <span class="description"><?php _e('Set App ID.', IMFBW_PLUGIN_NAME); ?> (<a href="https://developers.facebook.com/apps/" target="_blank">https://developers.facebook.com/apps/</a>)</span>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('URL:', IMFBW_PLUGIN_NAME); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>">
      <span class="description"><?php _e('Facebook page URL.', IMFBW_PLUGIN_NAME ); ?></span>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('tabs'); ?>"><?php _e('Tabs:', IMFBW_PLUGIN_NAME); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('tabs'); ?>" name="<?php echo $this->get_field_name('tabs'); ?>" type="text" value="<?php echo esc_attr($tabs); ?>">
      <span class="description"><?php _e('Tabs to render i.e. timeline, events, messages. Use a comma-separated list to add multiple tabs, i.e. timeline, events. (To hide posts set empty field value)', IMFBW_PLUGIN_NAME); ?></span>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:', IMFBW_PLUGIN_NAME); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($width); ?>">
      <span class="description"><?php _e('The pixel width of the widget. Minimum is 180 and maximum is 500. (default: 340)', IMFBW_PLUGIN_NAME); ?></span>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:', IMFBW_PLUGIN_NAME); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>">
      <span class="description"><?php _e('The pixel height of the widget. Minimum is 70. (default: 500)', IMFBW_PLUGIN_NAME); ?></span>
    </p>
    <?php

    $availableFacebookLanguage = get_transient('imfbw_availableLanguage');

    if ($availableFacebookLanguage['status'] === true) {

      $xmlAFB = simplexml_load_string($availableFacebookLanguage['body']);

      echo '<p><label for="' . $this->get_field_id('language') . '">' . __('Language:', IMFBW_PLUGIN_NAME) . '</label><select class="widefat" id="' . $this->get_field_id('language') . '" name="' . $this->get_field_name('language') . '">';
      foreach ($xmlAFB->locale as $key => $locale) {
        echo '<option value="' . $locale->codes->code->standard->representation . '"' . selected($locale->codes->code->standard->representation, $current_language, false) . '>' . $locale->englishName . '</option>';
      }
      echo '</select><span class="description">' . __('Set Facebook Language.', IMFBW_PLUGIN_NAME) .'</span></p>';

    }

    ?>
    <p>
      <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hide_cover'); ?>" name="<?php echo $this->get_field_name('hide_cover'); ?>"<?php checked($hide_cover); ?> />
	    <label for="<?php echo $this->get_field_id('hide_cover'); ?>"><?php _e('Hide Cover Photo. (default: no)', IMFBW_PLUGIN_NAME); ?></label>
      <br />
      <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_facepile'); ?>" name="<?php echo $this->get_field_name('show_facepile') ?>"<?php checked($show_facepile); ?> />
	    <label for="<?php echo $this->get_field_id('show_facepile'); ?>"><?php _e('Show Friend\'s Faces. (default: yes)', IMFBW_PLUGIN_NAME); ?></label>
      <br />
      <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hide_cta'); ?>" name="<?php echo $this->get_field_name('hide_cta') ?>"<?php checked($hide_cta); ?> />
	    <label for="<?php echo $this->get_field_id('hide_cta'); ?>"><?php _e('Hide the custom call to action button (if available). (default: no)', IMFBW_PLUGIN_NAME); ?></label>
      <br />
      <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('small_header'); ?>" name="<?php echo $this->get_field_name('small_header'); ?>"<?php checked($small_header); ?> />
	    <label for="<?php echo $this->get_field_id('small_header'); ?>"><?php _e('Use Small Header. (default: no)', IMFBW_PLUGIN_NAME); ?></label>
      <br />
      <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('adapt_container_width'); ?>" name="<?php echo $this->get_field_name('adapt_container_width'); ?>"<?php checked($adapt_container_width); ?> />
	    <label for="<?php echo $this->get_field_id('adapt_container_width'); ?>"><?php _e('Adapt to widget container width. (default: yes)', IMFBW_PLUGIN_NAME); ?></label>
    </p>
    <?php

  }

  /**
   * Update data from widget
   *
   * @param $new_instance
   * @param $old_instance
   * @return mixed
   */
  public function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
    $instance['appid'] = !empty($new_instance['appid']) ? (int) $new_instance['appid'] : '100105656749740';
    $instance['url']  = !empty($new_instance['url']) ? sanitize_text_field($new_instance['url']) : 'https://www.facebook.com/AS.Trencin/?fref=ts';
    $instance['tabs']  = !empty($new_instance['tabs']) ? sanitize_text_field($new_instance['tabs']) : '';
    $instance['width'] = !empty($new_instance['width']) ? (int) $new_instance['width'] : '340';
    $instance['height'] = !empty($new_instance['height']) ? (int) $new_instance['height'] : '500';
    $instance['language'] = !empty($new_instance['language']) ? sanitize_text_field($new_instance['language']) : 'en_US';
		$instance['hide_cover'] = (bool) $new_instance['hide_cover'];
    $instance['show_facepile'] = (bool) $new_instance['show_facepile'];
    $instance['hide_cta'] = (bool) $new_instance['hide_cta'];
    $instance['small_header'] = (bool) $new_instance['small_header'];
    $instance['adapt_container_width'] = (bool) $new_instance['adapt_container_width'];

    return $instance;

  }

}
