<div class="container">
  <div class="row node-contact">
    <div class="col sm-6 md-5">
      <?php print render($content['field_article_lead']) ?>
  
      <form class="contact bg-blue-1">
        <div class="field">
          <label class="flex flex-field">
            <div class="label">Nombre *</div>
            <div class="input">
              <input type="text" name="Nombre" required>
            </div>
          </label>
        </div>

        <div class="field">
          <label class="flex flex-field">
            <div class="label">Email *</div>
            <div class="input">
              <input type="text" name="Email" required>
            </div>
          </label>
        </div>

        <div class="field">
          <label class="flex flex-field">
            <div class="label">Cédula *</div>
            <div class="input">
              <input type="text" name="Cédula" required>
            </div>
          </label>
        </div>

        <div class="field">
          <label class="flex flex-field">
            <div class="label">Teléfono *</div>
            <div class="input">
              <input type="text" name="Teléfono" required>
            </div>
          </label>
        </div>

        <div class="field">
          <label class="flex flex-field">
            <div class="label">Asunto</div>
            <div class="input">
              <input type="text" name="Asunto">
            </div>
          </label>
        </div>

        <div class="field field-message">
          <label class="flex flex-field">
            <div class="label">Mensaje *</div>
            <div class="input">
              <textarea name="Mensaje"></textarea>
            </div>
          </label>
        </div>

        <div class="actions">
          <button type="button" class="btn btn-green-1-blue-2">Enviar</button>
        </div>
      </form>
      <div class="pqrs">
        <p>
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Incidunt voluptate mollitia aliquam, similique necessitatibus dolor voluptatibus voluptatem officiis sit quod error cupiditate ad minus asperiores quae ullam temporibus nobis molestiae.
        </p>
        <a href="https://www.policia.gov.co/pqrs" class="btn btn-green-1-blue-1 text-center">Peticiones, Quejas, Reclamos y Solicitudes</a>
      </div>
    </div>

    <div class="col col-2 sm-6 md-7">
      <?php print render($content['body']) ?>
    </div>
  </div>
</div>