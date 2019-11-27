    <footer>
      <div class="container color-white">
        <div class="row">
          <div class="col md-6">
            <a href="<?php print base_path() ?>" class="logo-link">
              <?php if(!empty($logo_footer_lg)): ?>
              <img src="<?php print $logo_footer_lg ?>" class="logo-lg" alt="logo">
              <?php else: ?>
              <img src="<?php print $logo ?>" class="logo-lg" alt="logo">
              <?php endif;
                    if(!empty($logo_footer_sm)): ?>
              <img src="<?php print $logo_footer_sm ?>" class="logo-sm" alt="logo">
              <?php endif ?>
            </a>
          </div>
  
          <div class="col col-contact-data sm-6 md-3">
            <div class="uppercase footer-title font-bold m-b-10">Contacto</div>
            <div class="contact-data color-gray-99 font-size-s">
              <?php print variable_get('site_address') ?><br>
              <?php print variable_get('site_phones') ?><br>
              <?php print nl2br(variable_get('site_phones_ext')) ?>
            </div>
          </div>
          
          <div class="col sm-6 md-3">
            <div class="uppercase footer-title font-bold m-b-10">Certificaciones</div>
            <?php 
              if($fid = variable_get('site_certs'))
              {
                print theme('image_style', array('style_name' => 's_1', 'path' => file_load($fid)->uri, 'getsize' => FALSE));
              }
              ?>
          </div>
          
        </div>
      </div>
      
    </footer>
