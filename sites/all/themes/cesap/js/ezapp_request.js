function ezapp_request(resource, data, csrfToken){
  var method = data ? 'POST' : 'GET';
  return jQuery.ajax({
    dataType: "json",
    url: Drupal.settings.basePath + 'ezapp/' + resource,
    data: JSON.stringify(data),
    method: method,
    headers: {
      'X-CSRF-Token': csrfToken
    },
    contentType: 'application/json',
  });

  // return jQuery.getJSON(Drupal.settings.basePath + 'ezapp/' + resource, JSON.stringify(data));
}

function events_request(resource, data, csrfToken){
  var method = data ? 'POST' : 'GET';
  return jQuery.ajax({
    dataType: "json",
    url: Drupal.settings.basePath + 'api/v1/otras_reservas/' + resource,
    data: JSON.stringify(data),
    method: method,
    headers: {
      'X-CSRF-Token': csrfToken
    },
    contentType: 'application/json',
  });

  // return jQuery.getJSON(Drupal.settings.basePath + 'ezapp/' + resource, JSON.stringify(data));
}
