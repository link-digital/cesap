<div class="container-login bg-login">
  <div class="text-center">
    <div class="logo">
      <?php print _chipcha_helper_render_theme_image('logo-policia.png') ?>
    </div>
    <div class=" color-white">
      <div class="font-roboto-cnd font-size-xxl font-bold">CESAP</div>
      <div class="font-roboto-cnd font-size-l font-bold uppercase">Centro social de agentes patrulleros</div>
      <div class="font-roboto-cnd font-size-n font-bold uppercase">Policía Nacional de Colombia | Dirección de bienestar social</div>
      <h1  class="font-roboto-cnd font-size-xxxl font-bold uppercase">Registro</h1>

      <div class="user-login-inputs">
        <?php 
            $form['account']['name']['#title_display'] = 'invisible';
            $form['account']['name']['#description'] = '';
            $form['account']['name']['#attributes']['placeholder'] = 'Nº de documento';
            
            $form['account']['mail']['#description'] = '';
            $form['account']['mail']['#attributes']['placeholder'] = 'Correo electrónico';
            // $form['pass']['#title_display'] = 'invisible';
            // $form['pass']['#description'] = '';
            // $form['pass']['#attributes']['placeholder'] = 'Contraseña';
            // $form['actions']['submit']['#value'] = 'Ingresar';
            // $form['actions']['submit']['#attributes']['class'][] = 'btn btn-green-1-blue-2';
             ?>
        <div class="flex flex-middle flex-input">
          <div class="icon">
            <?php print _chipcha_helper_render_theme_image('ico/user.png') ?>
          </div>
          <?php print render($form['account']['name']) ?>
        </div>
        <div class="flex flex-middle flex-input">
          <div class="icon">
            <?php print _chipcha_helper_render_theme_image('ico/at.png') ?>
          </div>
          <?php print render($form['account']['mail']) ?>
        </div>

        <div class="actions">
          <?php print render($form['actions']) ?>
        </div>

        <div class="links clean-a">
          <a href="<?php print url('user') ?>">Ya tengo cuenta</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php print drupal_render_children($form) ?>
