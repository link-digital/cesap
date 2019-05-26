var LFModal = (function(){
  
  var qsu = function(el,qs){
    return (el||document).querySelector(qs);
  },
  addEvent = function(el,ev,cb){
    el.addEventListener(ev,cb,true);
  },
  body = null,
  _my = {},
  _keyListener = function(e){
    if(e.keyCode == 27){
      _my.close();
    }
  },
  _dialog = null,
  _content = null,
  _modal = null;

  function getModal(name){
    if(!_modal){
      _modal = document.createElement('div');
      _modal.id = 'lf-modal';
      _modal.className = 'modal';
      _modal.innerHTML = '<div class="modal-dialog"><div><button data-close-modal="true" class="clean close"><i class="fa fa-times"></i></button></div><div class="modal-content"></div></div>';
      _dialog = qsu(_modal, '.modal-dialog');
      _content = qsu(_modal, '.modal-content');
      var listeners = ["transition", "webkitTransition", "mozTransition"];
      for(var i in listeners){
        // if(document.body.style.hasOwnProperty(listeners[i])){
        if(typeof document.body.style.hasOwnProperty(listeners[i]) !== 'undefined'){
          var ln = listeners[i] == 'transition' ? 'transitionend' : listeners[i] + 'End';
          _dialog.addEventListener(ln, function(e){
            if(e.propertyName == 'opacity' && !e.target.classList.contains('show')){
              _modal.classList.remove('show');
              body.classList.remove('modal-opened');
            }
          }, false);
          break;
        }
      }
      _modal.addEventListener('click', function(e){
        var t=e.target;
        if(t == _modal) {
          _my.close();
          return;
        }
        while(t && t.nodeType == 1){
          if(t.dataset.closeModal){
            _my.close();
            return;
          }
          t=t.parentNode;
        }
      }, false);
      body.appendChild(_modal);
      var bg = document.createElement('div');
      bg.className = 'modal-bg';
      body.appendChild(bg);
    }
    return _modal;
  }

  _my.loading = function(opts){
    _my.content('<div class="loading"></div>');
    _my.show(opts);
  }

  _my.show = function(opts) {
    getModal();
    if(typeof opts !== 'object'){
      opts = {};
    }
    _modal.className = 'modal ' + opts.className||'';
    _modal.classList.add('show');
    setTimeout(function(){
      _dialog.classList.add('show');
    });
    body.classList.add('modal-opened');

    document.addEventListener('keyup', _keyListener, false);
  }

  _my.close = function(){
    if(_modal){
      document.removeEventListener('keyup', _keyListener, false);
      _dialog.classList.remove('show');
      setTimeout(function(){
        _my.content('');
      }, 700);
    }
  }

  _my.content = function(c){
    getModal();
    if(_content){
      if(typeof c == 'string'){
        _content.innerHTML = c;
      } else if(c.nodeType == 1) {
        _content.innerHTML = '';
        _content.appendChild(c);
      }
    }
  }

  document.addEventListener('DOMContentLoaded', function(){
    body = document.body;
  }, false);

  return _my;

})();