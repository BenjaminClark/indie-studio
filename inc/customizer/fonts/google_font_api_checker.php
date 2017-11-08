<?php
class Google_Font_API_Checker_Section extends WP_Customize_Control {
    public function render_content() { ?>
    
    <label>
        <span><b>Please add a Google API key. </b></span><br>
        <span>If you are unsure how to get a Google API Key, follow this link</span><br>
        <a class="button" href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Get Google API</a><br>
        <span>If you have an API key, add it now</span><br>
        <a class="button customizer-edit" title="Add the Google API key" data-control="indie_studio_google_api" href="<?php echo admin_url( '/customize.php?autofocus[section]=indie_studio_google_api' );?>">Add key</a>
    </label>
    
    <?php
    }
}