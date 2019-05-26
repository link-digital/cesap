<div class="container-login bg-login">
  <div class="text-center">
    <div class="logo">
      <?php print _chipcha_helper_render_theme_image('logo-policia.png') ?>
    </div>
    <div class=" color-white">
      <div class="font-roboto-cnd font-size-xxl font-bold">CESAP</div>
      <div class="font-roboto-cnd font-size-l font-bold uppercase">Centro social de agentes patrulleros</div>
      <div class="font-roboto-cnd font-size-n font-bold uppercase">Policía Nacional de Colombia | Dirección de bienestar social</div>
      <h1  class="font-roboto-cnd font-size-xxxl font-bold uppercase">Recuperar contraseña</h1>

      <div class="user-login-inputs">
        <?php 
            // $form['name']['#title_display'] = 'invisible';
            // $form['name']['#description'] = '';
            $form['name']['#attributes']['placeholder'] = $form['name']['#title'];
            $form['actions']['submit']['#value'] = 'Nueva contraseña';
            $form['actions']['submit']['#attributes']['class'][] = 'btn btn-green-1-blue-2';
             ?>
        <div class="flex flex-middle flex-input">
          <div class="icon">
            <?php print _chipcha_helper_render_theme_image('ico/user.png') ?>
          </div>
          <?php print render($form['name']) ?>
        </div>

        <div class="actions">
          <?php print render($form['actions']) ?>
        </div>

        <div class="links clean-a">
          <a href="<?php print url('user') ?>">Ya tengo contraseña</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php print drupal_render_children($form) ?>