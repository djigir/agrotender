var entityMap = {
  '&': '&amp;',
  '<': '&lt;',
  '>': '&gt;',
  '"': '&quot;',
  "'": '&#39;',
  '/': '&#x2F;',
  '`': '&#x60;',
  '=': '&#x3D;'
};
$.fn.equalHeights = function(){
  var max_height = 0;
  $(this).each(function(){
    if ($(this).height() > max_height) {
      max_height = $(this).height();
    }
  });
  console.log(max_height);
  $(this).each(function(){
    $(this).height(max_height);
  });
};

function escapeHtml(string) {
  return String(string).replace(/[&<>"'`=\/]/g, function (s) {
    return entityMap[s];
  });
}
function truncate(text, limit, userParams) {
    var options = {
            ending: '...'  // что дописать после обрыва
          , trim: true     // обрезать пробелы в начале/конце?
          , words: true    // уважать ли целостность слов? 
        }
      , prop
      , lastSpace
      , processed = false
    ;

    //  проверить limit, без него целого положительного никак
    if( limit !== parseInt(limit)  ||  limit <= 0) return this;

    // применить userParams
    if( typeof userParams == 'object') {
        for (prop in userParams) {
            if (userParams.hasOwnProperty.call(userParams, prop)) {
                options[prop] = userParams[prop];
            }
        }
    }

    // убрать пробелы в начале /конце
    if( options.trim) text = text.trim();

    if( text.length <= limit) return text;    // по длине вписываемся и так

    text = text.slice( 0, limit); // тупо отрезать по лимиту
    lastSpace = text.lastIndexOf(" ");
    if( options.words  &&  lastSpace > 0) {  // урезать ещё до границы целого слова
        text = text.substr(0, lastSpace);
    }
    return text + options.ending;
}
var agrotender = new(function () {

  var app = {};
  var files = [];
  var currentPage = $('body').attr('page');

  app.model = {};

  app.core = {
    isPage: function (src) {
      var url = document.URL;
      if (src == 'all') {
        return true;
      } else {
        return url.indexOf(src) != -1;
      }
    },

    addslashes: function (str) {
      return str.replace('/(\"(?: |))/g', "'");
    },

    equalHeight: function (container) {
      var highestBox = 0;
      $(container).each(function () {
        if ($(this).height() > highestBox) {
          highestBox = $(this).height();
        }
      });

      $(container).height(highestBox);
    },

    loadModules: function () {
      for (var x in app.controller) {
        if (currentPage == x || x == 'all') {
          for (var y in app.controller[x].modules) {
            app.model[app.controller[x].modules[y]]();
          }
        }
      }
    },

    init: function () {
      $(function () {
      	// $.jGrowl.defaults.position = 'bottom-left';
       // $.jGrowl.closerTemplate = "Закрыть все";
       Noty.overrideDefaults({
        layout: 'topRight',
          theme: 'nest',
          layout: 'bottomLeft',
          timeout: '4000',
          progressBar: true,
          closeWith: ['click'],
          killer: true
        });
        $('#loading').hide();
        app.core.loadModules();
      });
    } 
  };

  app.utils = {
    updateQueryStringParameter: function(uri, key, value) {
      var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
      var separator = uri.indexOf('?') !== -1 ? "&" : "?";
      if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
      } else {
        return uri + separator + key + "=" + value;
      }
    },
    serializeArrayChange: function(data, key, value) {
      $.each(data, function (i, item) {
        if (item.name == key) {
          item.value = value;
        }
      });
      return data;
    }
  };

  app.controller = {
    'all': {
      modules: ['global', 'offer', 'notifications']
    },
    'main/home': {
      modules: ['home']
    },
    'main/companies': {
      modules: ['rubrics', 'companies']
    },
    'main/companies-r': {
      modules: ['rubrics', 'companies']
    },
    'main/companies-s': {
      modules: ['rubrics', 'companies']
    },
    'board/index': {
      modules: ['advertRubrics', 'advertFilters', 'advertSearch']
    },
    'board/advert': {
      modules: ['advertPhotos', 'complain', 'advertFilters']
    },
    'main/traders': {
      modules: ['rubrics', 'tradersFilters']
    },
    'main/traders-s': {
      modules: ['rubrics', 'tradersFilters']
    }, 
    'main/traders_analitic': {
      modules: ['rubrics', 'tradersFilters', 'analitic']
    }, 
    'main/traders_analitic-s': {
      modules: ['rubrics', 'tradersFilters', 'analitic']
    }, 
    'main/elev': {
      modules: ['elev-regions', 'elevs']
    },
    'main/signup': {
      modules: ['sign-up']
    },
    'main/signin': {
      modules: ['sign-in']
    },
    'main/restore': {
      modules: ['restore']
    },
    'board/add': {
      modules: ['add-advert', 'advertForm-utils', 'change-phone']
    },
    'board/edit': {
      modules: ['edit-advert', 'advertForm-utils', 'change-phone']
    },
    'board/success': {
      modules: ['paid-services']
    },
    'user/upgrade': {
      modules: ['paid-services']
    },
    'user/payBalance': {
      modules: ['balance-form']
    },
    'user/prices': {
      modules: ['prices']
    },
    'user/pricesContacts': {
      modules: ['trader-contacts']
    },
    'user/limits': {
      modules: ['up-limits']
    },
    'user/home': {
      modules: ['personal']
    },
    'user/contacts': {
      modules: ['contacts', 'change-phone']
    },
    'user/notify': {
      modules: ['notify']
    },
    'user/company': {
      modules: ['company']
    },
    'user/vacancy': {
      modules: ['vacancy']
    },
    'user/news': {
      modules: ['news']
    },
    'company/adverts': {
      modules: ['advTypes']
    },
    'company/home': {
      modules: ['prices', 'hide-contacts']
    },
    'company/prices': {
      modules: ['prices']
    },
    'company/reviews': {
      modules: ['company-reviews']
    },
    'user/ads': {
      modules: ['user-adverts']
    },
    'user/proposeds': {
      modules: ['proposeds']
    },
    'main/addTrader': {
      modules: ['addTrader']
    }
  };

  app.model['addTrader'] = function() {
    var swiper = new Swiper('.swiper-container', {
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      }
    });
    $('input[name="phone"]').mask("0(xx) xx-xx-xxx", {
      placeholder: "Номер телефона",
      translation: {
        0: {pattern: /[0*]/},
        'x': {pattern: /(\d+)/}
      }
    });
    $('.btn-trader').on('click', function(e) {
      e.preventDefault();
      $('html,body').animate({scrollTop:0},0); 
    });
    $('.selectDate button').on('click', function(e) {
      e.preventDefault();
      var price = $(this).attr('price');
      $(this).parent().prev().find('b').text(price);
      $(this).parent().find('button').attr('selected', false);
      $(this).attr('selected', true);
    });
    $('#send').validate({
      rules: {
        company: {
          required: true
        },
        name: {
          required: true
        },
        phone: {
          required: true
        },
        email: {
          required: true
        }
      },
      messages: {
        company: {
          required: 'Введите название компании.'
        },
        name: {
          required: 'Введите Вашe имя.'
        },
        phone: {
          required: 'Введите номер телефона.'
        },
        email: {
          required: 'Введите email.'
        }
      },
      errorElement: 'span',
      errorPlacement: function ( error, element ) {
        $(error).addClass('error-text');
        $(element).after(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('error-input');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('error-input');
      },
      submitHandler: function(form) {
        // $offer.find('.send-offer').prop('disabled', true);
        var formData = $(form).serializeArray();
            formData[formData.length] = {name: 'action', value: 'send'};
        var phone    = '38' + $('input[name="phone"]').cleanVal();
            formData = app.utils.serializeArrayChange(formData, 'phone', phone);
        // send data to server
        app.ajax(location.href, formData, function(data) {
          if (data.code == 0) {
            new Noty({
              type: 'error',
              text: data.text
            }).show();
            return false;
          } else {
            new Noty({
              type: 'success',
              text: data.text
            }).show();
          }
        });
      }
    });
  };

  app.model['hide-contacts'] = function() {
    if ($('.contact').length > 3) {
      $('.contact').each(function(i) {
        if (i >= 3) {
          $(this).hide();
        }
      });
      $('.trader-contact').each(function() {
        if (!$(this).find('.contact').is(':visible')) {
          $(this).hide();
        }
      });
    }
    $('.trader-contact:visible:last').append('<div class="text-center mt-4"> <a class="btn btn-block showAll add-contact px-5" href="#">Показать все</a> </div>');
    $('.showAll').on('click', function(e) {
      e.preventDefault();
      $(this).parent().remove();
      $('.contact').show();
      $('.trader-contact').show();
    });
  };

  app.model['company-reviews'] = function() {
    $('.send-review').on('click', function(e) {
      e.preventDefault();
      var rate = $('.starrr').attr('data-rate');
      var formData = $(this).parents('.form').serializeArray();
          formData[formData.length] = {name: 'rate', value: rate};
          formData[formData.length] = {name: 'action', value: 'addReview'};
      app.ajax(location.href, formData, function(data) {
        if (data.code == 1) {
          location.reload();
        } else {
          new Noty({
            type: 'error',
            text: data.text
          }).show();
        }
      });
    });
    var $modal = $('#reviewModal');
    $('.addReview').on('click', function(e) {
      e.preventDefault();
      if (!$modal.length) {
        new Noty({
          type: 'error',
          text: 'Нужно авторизоваться.'
        }).show();
        return false;
      } 
      $modal.modal('show');
    });
    $('.starrr > span').on('click', function() {
      $(this).attr('class', 'fas fa-star');
      $(this).prevAll('span').attr('class', 'fas fa-star');
      $(this).nextAll('span').attr('class', 'far fa-star');

      $(this).parent().attr('data-rate', $(this).attr('data-num'));
    });
  };

  app.model['proposeds'] = function() {
    $('.cancelProposed').on('click', function(e) {
      e.preventDefault();
      app.ajax(location.href, {action: 'cancel', proposed: $(this).attr('data-id')}, function(data) {
        if (data.code == 1) {
          location.reload();
        } else {
          new Noty({
            type: 'error',
            text: data.text
          }).show();
        }
      });
    });
    $('.showTraders').on('click', function(e) {
      e.preventDefault();
      app.ajax(location.href, {action: 'getCompanies', proposed: $(this).attr('data-id')}, function(data) {
        var html = '';
        var html = '';
        for (var x in data.companies) {
          html += '<div class="col-6 py-2"><a href="/kompanii/comp-'+data.companies[x].company_id+'.html" target="_blank"><b>'+data.companies[x].company+'</b></a> - '+data.companies[x].status+'</div>'
        }
        $('#tradersModal .row').html(html);
        $('#tradersModal').modal('show');
      });
    });
    $('.getProposedTraders').on('click', function(e) {
      e.preventDefault();
      var proposed = $(this).attr('data-id');
      app.ajax(location.href, {action: 'getCompanies', proposed: proposed}, function(data) {
        var html = '';
        for (var x in data.companies) {
          html += '<div class="col-4 py-2"><span><input class="custom-control-input rubric-input" type="checkbox" value="'+data.companies[x].company_id+'" name="companies[]" id="company'+data.companies[x].company_id+'" checked=""> <label class="custom-control-label" for="company'+data.companies[x].company_id+'"> '+data.companies[x].company+' </label></span></div>'
        }
        $('#acceptModal .row').html(html);
        $('#acceptModal').modal('show');
        var formData = $('#acceptModal').find('form').serializeArray();
            formData[formData.length] = {name: 'action', value: 'accept'};
            formData[formData.length] = {name: 'proposed', value: proposed};
        $('.accept-proposed').on('click', function(e) {
          e.preventDefault();
          app.ajax(location.href, formData, function(data) {
            if (data.code == 1) {
              location.reload();
            } else {
              new Noty({
                type: 'error',
                text: data.text
              }).show();
            }
          });
        });
      });
    });
    $('.removeProposed').on('click', function(e) {
      e.preventDefault();
      var proposed = $(this).attr('data-id');
      app.ajax(location.href, {action: 'remove', proposed: proposed}, function(data) {
        if (data.code == 1) {
          location.reload();
        } else {
          new Noty({
            type: 'error',
            text: data.text
          }).show();
        }
      });
    });
  };

  app.model['notifications'] = function() {
      app.ajax('/', {action: 'getNotifications'}, function(data) {
        if (data.code == 1) {
          if (data.proposeds >= 1) {
            $('.notification-badge').text(data.proposeds).css('display', 'inline-block');
          } 
          if (data.modal != null) {
            if (currentPage == 'main/home') {
              $('.notification-modal .link-button').attr('href', data.modal['urlgo']).text(data.modal['btntext']);
              $('.notification-modal .notification-text').html(data.modal['content']);
              $('.notification-modal .notification-title').text(data.modal['title']);
              $('.notification-modal').modal('show');
              app.ajax('/', {action: 'viewedModal', modalId: data.modal['id']});
            }
          }
        } 
      });
  };

  app.model['change-phone'] = function() {
    $('input.code').mask("0-0-0-0", {placeholder: "x-x-x-x"});
    $('.send-phone').on('click', function(e) {
      e.preventDefault();
      var $this = $(this);
      $this.prop('disabled', true);
      var phone = '38' + $('.newPhone').cleanVal();
      app.ajax('/u/contacts', {action: 'change-phone', phone: phone}, function(data) {
        $this.prop('disabled', false);
        if (data.code == 0) {
          new Noty({
            type: 'error',
            text: data.text
          }).show();
          return false;
        } else {
          // show confirm code modal
          $('#changePhone').modal('hide');
          $('.codeModal .phone').text('+' + phone);
          $('.codeModal').modal('show');
          // repeat sms confirm code
          $('.repeat-code').on('click', function(e) {
            e.preventDefault();
            app.ajax('/u/contacts', {action: 'repeat-code', phone: phone}, function(data) {
              new Noty({
                type: 'info',
                text: data.text
              }).show();
            });
          });
          // register process
          $('.send-code').on('click', function(e) {
            var $this = $(this);
            $this.prop('disabled', true);
            e.preventDefault();
            var code     = $('input.code').cleanVal();
            // send data to server
            app.ajax('/u/contacts', {action: 'check-code', code: code}, function(data) {
              $this.prop('disabled', false);
              if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else {
                location.reload();
              }
            });
          });
        }
      });
    });
  };

  app.model['user-adverts'] = function() {
    $('.action-btn').on('click', function(e) {
      e.preventDefault();
      var ids = [];
      $('input:checked').each(function() {
        ids[ids.length] = $(this).val();
      });
      var action = $(this).prev().val();
      if (ids.length == 0) {
        new Noty({
          type: 'warning',
          text: 'Вы не выбрали ни одного объявления.'
        }).show();
        return false;
      }
      if (action == null) {
        new Noty({
          type: 'warning',
          text: 'Выберите действие.'
        }).show();
        return false;
      }
      app.ajax(location.href, {action: 'callAction', action_id: action, ids: ids}, function(data) {
        if (data.code == 0) {
          new Noty({
            type: 'error',
            text: data.text
          }).show();
          return false;
        } else {
          location.reload();
        }
      });
    });
    $('.setArchive').on('click', function(e) {
      e.preventDefault();
      var archive = $(this).attr('archive');
      var advert = $(this).attr('post');
      app.ajax(location.href, {action: 'setArchive', archive: archive, advert: advert}, function(data) {
        if (data.code == 0) {
          new Noty({
            type: 'error',
            text: data.text
          }).show();
          return false;
        } else if(data.code == 2) {
          location.href = '/u/ads';
        } else {
          location.reload();
        }
      });
    });
    $('.btn-up').on('click', function(e) {
      e.preventDefault();
      var advId = $(this).attr('post');
      var $_this = $(this);
      var cost = $(this).attr('cost');
      app.ajax('/u/ads/upgrade', {action: 'upgradeAdv', advId: advId, packs: [13]}, function(data) {
        if (data.code == 0) {
          new Noty({
            type: 'error',
            text: data.text
          }).show();
          return false;
        } else if (data.code == 1) {
          $_this.css('pointer-events', 'none').text('Готово!');
          var balance = parseInt($('.balance-box b').text());
          $('.balance-box b').text(balance - cost);
        } else if (data.code == 2) {
          location.href = '/u/balance/pay?payAdv='+data.payAdv+'&payPacks='+data.payPacks+'&payAmount='+data.payAmount+'';
        }
      });
    });
  };

  app.model['advTypes'] = function() {
    $('select[name="typeAdverts"]').on('change', function(e) {
      e.preventDefault();

      var type = $(this).val();
      if (type == null) {
        location.href = window.location.pathname;
      } else {
        location.href = window.location.pathname + "?type=" + type;
      }
    });
  };

  app.model['vacancy'] = function() {
    $('.select-image').on('click', function() {
      $(this).next().click();
    });
    $('input[name="image"]').on('change', function() {
      var file = this.files[0];
      console.log(file);
       if(file.size > 20000){
           new Noty({
          type: 'warning',
          text: 'Загружать можно изображения не больше 20кб'
        }).show();
        return false;
      }
      if ($.inArray(file.type.split('/')[1], ['jpeg', 'jpg', 'png', 'gif']) != -1) {
        var src = URL.createObjectURL(file);
        $(this).parent().find('.logo').attr('src', src);
      } else {
        new Noty({
            type: 'warning',
            text: 'Загружать можно только изображения.'
          }).show();
        return false;
      }
    });
    $('.add-vacancy').on('click', function(e) {
      e.preventDefault();
      var form = $(this).parents('.form')[0];
      var formData = new FormData(form);
          formData.append('action', 'addVacancy');
      app.ajax(location.href, formData, function(data) {
        if (data.code == 0) {
          new Noty({
            type: 'error',
            text: data.text
          }).show();
          return false;
        } else{
          location.reload();
        }
      }, false, true);
    });
    $('.edit').on('click', function(e) {
      e.preventDefault();
      var vacancyId = $(this).attr('vacancyid');
      app.ajax(location.href, {action: 'getVacancyItem', vacancyId: vacancyId}, function(data) {
        if (data != null) {
          $('#editVacancy').find('input[name="title"]').val(data.title);
          $('#editVacancy').find('textarea[name="description"]').val(data.content);
          if (data.pic_src != '') {
            $('#editVacancy').find('.logo').attr('src', '/' + data.pic_src);
          }
          $('#editVacancy').modal('show');
          $('.edit-vacancy').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('.form')[0];
            var formData = new FormData(form);
                formData.append('vacancyId', vacancyId);
                formData.append('action', 'editVacancy');
            app.ajax(location.href, formData, function(data) {
              if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else{
                location.reload();
              }
            }, false, true);
          });
        }
      });
    });
    $('.remove').on('click', function(e) {
      e.preventDefault();
      var vacancyId = $(this).attr('vacancyid');
      app.ajax(location.href, {action: 'removeVacancy', vacancyId: vacancyId}, function(data) {
        if (data.code == 0) {
          new Noty({
            type: 'error',
            text: data.text
          }).show();
          return false;
        } else{
          location.reload();
        }
      });
    });
  };

  app.model['news'] = function() {
    $('.select-image').on('click', function() {
      $(this).next().click();
    });
    $('input[name="image"]').on('change', function() {
      var file = this.files[0];
      if ($.inArray(file.type.split('/')[1], ['jpeg', 'jpg', 'png', 'gif']) != -1) {
        var src = URL.createObjectURL(file);
        $(this).parent().find('.logo').attr('src', src);
      } else {
        new Noty({
          type: 'warning',
          text: 'Загружать можно только изображения.'
        }).show();
        return false;
      }
    });
    $('.add-news').on('click', function(e) {
      e.preventDefault();
      var form = $(this).parents('.form')[0];
      var formData = new FormData(form);
          formData.append('action', 'addNews');
      app.ajax(location.href, formData, function(data) {
        if (data.code == 0) {
          new Noty({
            type: 'error',
            text: data.text
          }).show();
          return false;
        } else{
          location.reload();
        }
      }, false, true);
    });
    $('.edit').on('click', function(e) {
      e.preventDefault();
      var newsId = $(this).attr('newsId');
      app.ajax(location.href, {action: 'getNewsItem', newsId: $(this).attr('newsId')}, function(data) {
        if (data != null) {
          $('#editNews').find('input[name="title"]').val(data.title);
          $('#editNews').find('textarea[name="description"]').val(data.content);
          if (data.pic_src != '') {
            $('#editNews').find('.logo').attr('src', '/' + data.pic_src);
          }
          $('#editNews').modal('show');
          $('.edit-news').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('.form')[0];
            var formData = new FormData(form);
                formData.append('newsId', newsId);
                formData.append('action', 'editNews');
            app.ajax(location.href, formData, function(data) {
              if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else{
                location.reload();
              }
            }, false, true);
          });
        }
      });
    });
    $('.remove').on('click', function(e) {
      e.preventDefault();
      var newsId = $(this).attr('newsId');
      app.ajax(location.href, {action: 'removeNews', newsId: newsId}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else{
          location.reload();
        }
      });
    });
  };

  app.model['offer'] = function() {
    var $offer = $('#offer');
    $('.offer-btn').on('click', function(e) {
      e.preventDefault();
      if (!$offer.length) {
        new Noty({
          type: 'warning',
          text: 'Необходимо авторизоваться.'
        }).show();
        return false;
      } else {
        $('input[name="phone"]').mask("0(xx) xx-xx-xxx", {
      placeholder: "Номер телефона",
      translation: {
        0: {pattern: /[0*]/},
        'x': {pattern: /(\d+)/}
      }
    });
        $offer.modal('show');
      }
    });
    if (!$offer.length) {
      return false;
    }
    $offer.find('select[name="rubric"]').on('change', function() {
      var rubric = $(this).val();
      var region = $offer.find('select[name="region"]').val();
      if (rubric != null) {
        app.ajax('/traders.html', {action: 'getTraders', rubric: rubric, region: region}, function(data) {
          if (data.code == 1 && data.list.length > 0) {
            var html = '';
            for (var x in data.list) {
              html += '<span><input class="custom-control-input rubric-input" type="checkbox" value="'+data.list[x].id+'" name="companies[]" id="company'+data.list[x].id+'" checked=""> <label class="custom-control-label" for="company'+data.list[x].id+'"> '+data.list[x].title+' </label></span>'
            }
            $offer.find('.list-items').html(html);
            $offer.find('.list').show();
          } else {
            $offer.find('.list-items').html('<div class"text-center">Нет компаний, удовлетворяющих Ваш поиск.</div>');
            $offer.find('.list').show();
          }
        });
      }
    });
    $offer.find('select[name="region"]').on('change', function() {
      var region = $(this).val();
      var rubric = $offer.find('select[name="rubric"]').val();
      if (rubric != null) {
        app.ajax('/traders.html', {action: 'getTraders', rubric: rubric, region: region}, function(data) {
          if (data.code == 1 && data.list.length > 0) {
            var html = '';
            for (var x in data.list) {
              html += '<span><input class="custom-control-input rubric-input" type="checkbox" value="'+data.list[x].id+'" name="companies[]" id="company'+data.list[x].id+'" checked=""> <label class="custom-control-label" for="company'+data.list[x].id+'"> '+data.list[x].title+' </label></span>'
            }
            $offer.find('.list-items').html(html);
            $offer.find('.list').show();
          } else {
            $offer.find('.list-items').html('<div class"text-center">Нет компаний, удовлетворяющих Ваш поиск.</div>');
            $offer.find('.list').show();
          }
        });
      }
    });
    $offer.find('.send-offer').on('click', function(e) {
      e.preventDefault();
      $offer.find('form').submit();
    });
    $offer.find('form').validate({
      rules: {
        company: {
          required: true
        },
        name: {
          required: true
        },
        phone: {
          required: true
        },
        email: {
          required: true
        },
        bulk: {
          required: true
        },
        price: {
          required: true
        },
        rubric: {
          required: true
        }
      },
      messages: {
        company: {
          required: 'Введите название компании.'
        },
        name: {
          required: 'Введите Ваши Ф.И.О.'
        },
        phone: {
          required: 'Введите номер телефона.'
        },
        email: {
          required: 'Введите email.'
        },
        bulk: {
          required: 'Укажите объем.'
        },
        price: {
          required: 'Укажите цену.'
        },
        rubric: {
          required: 'Выберите рубрику.'
        }
      },
      errorElement: 'span',
      errorPlacement: function ( error, element ) {
        $(error).addClass('error-text');
        $(element).parents('.col-sm-5').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('error-input');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('error-input');
      },
      submitHandler: function(form) {
        if (!$('.list-items .custom-control-input.rubric-input:checked').length) {
          new Noty({
            type: 'warning',
            text: 'Нужно выбрать минимум 1 компанию.'
          }).show();
          return false;
        }
        // $offer.find('.send-offer').prop('disabled', true);
        var formData = $(form).serializeArray();
            formData[formData.length] = {name: 'action', value: 'send-proposed'};
        var phone    = '38' + $offer.find('input[name="phone"]').cleanVal();
            formData = app.utils.serializeArrayChange(formData, 'phone', phone);
        // send data to server
        app.ajax('/traders.html', formData, function(data) {
          $offer.find('.send-offer').prop('disabled', false);
          new Noty({
            type: 'info',
            text: data.text
          }).show();
          $offer.modal('hide');
        });
      }
    });
  };

  app.model['complain'] = function() {
    $('.send-complain').on('click', function(e) {
      e.preventDefault();
      var text = $(this).parents('form').find('textarea').val();
      if (text.length < 20) {
        new Noty({
          type: 'warning',
          text: 'Текст жалобы не может быть менее 20 символов.'
        }).show();
        return false;
      }
      app.ajax(location.href, {action: 'complain', text: text}, function(data) {
        if (data.code == 1) {
          $('#complain').modal('hide');
        }
        new Noty({
          type: 'info',
          text: data.text
        }).show();
      });
    });
  };

  app.model['company'] = function() {
    $('.select-image').on('click', function() {
      $(this).next().click();
    });
    $('input[name="logo"]').on('change', function() {
      var file = this.files[0];
      if ($.inArray(file.type.split('/')[1], ['jpeg', 'jpg', 'png', 'gif']) != -1) {
        var src = URL.createObjectURL(file);
        $('.logo').attr('src', src);
      } else {
        new Noty({
          type: 'warning',
          text: 'Загружать можно только изображения.'
        }).show();
        return false;
      }
    });
    $('.save-comp').on('click', function(e) {
      e.preventDefault();
      $('.company-form').submit();
    });
    $('.company-form').validate({
      rules: {
        title: {
          required: true
        },
        content: {
          required: true
        }
      },
      messages: {
        name: {
          required: 'Введите название.'
        },
        name: {
          required: 'Введите описание.'
        }
      },
      errorElement: 'span',
      errorPlacement: function ( error, element ) {
        $(error).addClass('error-text');
        $(element).parents('.col-sm-5').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('error-input');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('error-input');
      },
      submitHandler: function(form) {
        $('.save-comp').prop('disabled', true);
        var formData = new FormData(form);
            formData.append('action', 'save-company');
        // send data to server
        app.ajax(location.href, formData, function(data) {
          $('.save-comp').prop('disabled', false);
          if (data.code == 0) {
            new Noty({
              type: 'error',
              text: data.text
            }).show();
            return false;
          } else {
            new Noty({
              type: 'success',
              text: 'Компания успешно создана.'
            }).show();
          }
        }, false, true);
      }
    });
    $('.rubric-input').on('change', function() {
      if ($(this).prop('checked') == true) {
        var count = $('.rubric-input:checked').length;
        if (count > 5) {
          $(this).prop('checked', false);
          new Noty({
            type: 'warning',
            text: 'Вы не можете выбрать более 5 видов деятельности для компании.'
          }).show();
          return false;
        }
      }
    });
    $('.setVisible').on('click', function(e) {
      e.preventDefault();
      var visible = $(this).attr('visible');
      app.ajax(location.href, {action: 'setVisible', visible: visible}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else {
          location.reload();
        }
      });
    });
  };

  app.model['notify'] = function() {
    $('.advSub').on('change', function() {
      var formData = $(this).parents('form').serializeArray();
          formData[formData.length] = {name: 'action', value: 'saveAdvSub'};
      app.ajax(location.href, formData, function(data) {
        new Noty({
            type: 'info',
            text: data.text
          }).show();
      }); 
    });
    $('.save').on('click', function(e) {
      e.preventDefault();
      var rubric = $('select[name="rubric"]').val();
      var period = $('input[name="period"]:checked').val();
      app.ajax(location.href, {action: 'addPriceSub', rubric: rubric, period: period}, function(data) {
        location.reload();
      }); 
    });
    $('.removeSub').on('click', function(e) {
      e.preventDefault();
      var subId = $(this).attr('subId');
      app.ajax(location.href, {action: 'removeSub', subId: subId}, function(data) {
        location.reload();
      });
    });
    $('.upSub').on('click', function(e) {
      e.preventDefault();
      var subId = $(this).attr('subId');
      app.ajax(location.href, {action: 'upSub', subId: subId}, function(data) {
        location.reload();
      });
    });
  };

  app.model['contacts'] = function() {
    // phone mask
    $('input[name^="phone"], .newPhone').mask("0(xx) xx-xx-xxx", {
      placeholder: "Номер телефона",
      translation: {
        0: {pattern: /[0*]/},
        'x': {pattern: /(\d+)/}
      }
    });
    $('.save').on('click', function(e) {
      e.preventDefault();
      $('.main-dep').submit();
    });
    // main office
    $('.main-dep').validate({
      rules: {
        name: {
          required: true
        }
      },
      messages: {
        name: {
          required: 'Поле должно быть заполнено'
        }
      },
      errorElement: 'span',
      errorPlacement: function ( error, element ) {
        $(error).addClass('error-text');
        $(element).parents('.col-sm-5').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('error-input');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('error-input');
      },
      submitHandler: function(form) {
        $(form).find('button[type="submit"]').prop('disabled', true);
        var formData = $(form).serializeArray();
            formData[formData.length] = {name: 'action', value: 'main-dep'};
        var phone    = '38' + $('.main-dep input[name="phone"]').cleanVal();
              formData = app.utils.serializeArrayChange(formData, 'phone', phone);
        var phone2   = '38' + $('.main-dep input[name="phone2"]').cleanVal();
              formData = app.utils.serializeArrayChange(formData, 'phone2', phone2);
        var phone3   = '38' + $('.main-dep input[name="phone3"]').cleanVal();
              formData = app.utils.serializeArrayChange(formData, 'phone3', phone3);
        // send data to server
        app.ajax(location.href, formData, function(data) {
          $(form).find('button[type="submit"]').prop('disabled', false);
          new Noty({
            type: 'info',
            text: data.text
          }).show();
        });
      }
    });
    // remove contact
    $('.remove-contact').on('click', function(e) {
      e.preventDefault();
      var contact = $(this).attr('contact'); 
      app.ajax(location.href, {action: 'removeContact', contact: contact}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else {
          location.reload();
        }
      });
    });
    $('.contact-form').validate({
      rules: {
        post: {
          required: true
        },
        name: {
          required: true
        },
        phone: {
          required: true
        },
        email: {
          required: true,
          email: true
        }
      },
      messages: {
        post: {
          required: 'Необходимо указать должность.'
        },
        name: {
          required: 'Укажите контактное лицо.'
        },
        phone: {
          required: 'Введите номер телефона.'
        },
        email: {
          required: 'Укажите Email.',
          email: 'Email указан с ошибками.'
        }
      },
      errorElement: 'span',
      errorPlacement: function ( error, element ) {
        $(error).addClass('error-text');
        $(element).parents('div[class^="col-sm-"]').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('error-input');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('error-input');
      },
      submitHandler: function(form, e) {
        e.preventDefault();
        var formData = $(form).serializeArray();
            formData[formData.length] = {name: 'action', value: 'addContact'};
        var phone    = '38' + $('.contact-form input[name="phone"]').cleanVal();
            formData = app.utils.serializeArrayChange(formData, 'phone', phone);
        app.ajax(location.href, formData, function(data) {
          if (data.code == 0) {
            new Noty({
              type: 'error',
              text: data.text
            }).show();
            return false;
          } else {
            location.reload();
          }
        });
      }
    });
    $('.edit-contact').on('click', function(e) {
      e.preventDefault();
      var contact = $(this).attr('contact');
      var $contact = $(this).parents('.contact');
      $('#editContact').modal('show');
      $('.edit-contact-form input[name="post"]').val($contact.find('.post').text());
      $('.edit-contact-form input[name="name"]').val($contact.find('.name').text());
      $('.edit-contact-form input[name="phone"]').val($contact.find('.phone').text()).trigger('input');
      $('.edit-contact-form input[name="email"]').val($contact.find('.email').text());
      // validate act form
      $('.edit-contact-form').validate({
        rules: {
          post: {
            required: true
          },
          name: {
            required: true
          },
          phone: {
            required: true
          },
          email: {
            required: true,
            email: true
          }
        },
        messages: {
          post: {
            required: 'Необходимо указать должность.',
            email: 'Email указан с ошибками.',
          },
          name: {
            required: 'Укажите контактное лицо.'
          },
          phone: {
            required: 'Введите номер телефона.'
          },
          email: {
            required: 'Укажите Email.'
          }
        },
        errorElement: 'span',
        errorPlacement: function ( error, element ) {
          $(error).addClass('error-text');
          $(element).parents('div[class^="col-sm-"]').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('error-input');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('error-input');
        },
        submitHandler: function(form, e) {
          e.preventDefault();
          var formData = $(form).serializeArray();
              formData[formData.length] = {name: 'contact', value: contact};
              formData[formData.length] = {name: 'action', value: 'editContact'};
          var phone    = '38' + $('.edit-contact-form input[name="phone"]').cleanVal();
              formData = app.utils.serializeArrayChange(formData, 'phone', phone);
          app.ajax(location.href, formData, function(data) {
            if (data.code == 0) {
            new Noty({
              type: 'error',
              text: data.text
            }).show();
            return false;
          } else {
              location.reload();
            }
          });
        }
      });
    });
  };

  app.model['personal'] = function() {
    $('.show-password').hover(function() {
      $('.password').attr("type", "text");
    }, function() {
      $('.password').attr("type", "password");
    });
    $('.change-password').validate({
      rules: {
        oldPassword: {
          required: true
        },
        password: {
          required: true,
          rangelength: [6, 20]
        }
      },
      messages: {
        oldPassword: {
          required: "Введите старый пароль."
        },
        password: {
          required: "Введите новый пароль.",
          rangelength: "Пароль должен быть от 6 до 20 символов."
        }
      },
      errorElement: 'span',
      errorPlacement: function ( error, element ) {
        $(error).addClass('error-text');
        $(element).parents('.col-sm-5').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('error-input');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('error-input');
      },
      submitHandler: function(form) {
        $(form).find('button[type="submit"]').prop('disabled', true);
        var formData = $(form).serializeArray();
            formData[formData.length] = {name: 'action', value: 'change-password'};

        // send data to server
        app.ajax(location.href, formData, function(data) {
          $(form).find('button[type="submit"]').prop('disabled', false);
          new Noty({
            type: 'info',
            text: data.text
          }).show();
        });
      }
    });
    $('.change-login').validate({
      rules: {
        email: {
          required: true,
          email: true
        }
      },
      messages: {
        email: {
          required: 'Укажите Email.',
          email: 'Email указан с ошибками.'
        }
      },
      errorElement: 'span',
      errorPlacement: function ( error, element ) {
        $(error).addClass('error-text');
        $(element).parents('.col-sm-5').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('error-input');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('error-input');
      },
      submitHandler: function(form) {
        $(form).find('button[type="submit"]').prop('disabled', true);
        var formData = $(form).serializeArray();
            formData[formData.length] = {name: 'action', value: 'change-login'};

        // send data to server
        app.ajax(location.href, formData, function(data) {
          $(form).find('button[type="submit"]').prop('disabled', false);
          if (data.code == 0) {
            new Noty({
              type: 'error',
              text: data.text
            }).show();
            return false;
          } else {
            location.href = '/success';
          }
        });
      }
    });
  };

  app.model['up-limits'] = function() {
    $('.pack-block').on('click', function(e) {
      $('.pack-block').removeClass('active');
      $(this).addClass('active');
      var total = 0;
      $('.totalPrice .cost').text($(this).find('.cost').text());
    });
    $('.payBtn').on('click', function(e) {
      e.preventDefault();
      var advId = $(this).attr('post-id');
      var packs = [$('.pack-block.active').attr('pack-id')];
      app.ajax('/u/ads/limits', {action: 'upLimits', packs: packs}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else if (data.code == 1) {
          location.href = '/u/ads/limits'
        } else if (data.code == 2) {
          location.href = '/u/balance/pay?payPacks='+data.payPacks+'&payAmount='+data.payAmount+'';
        }
      });
    });
  };

  app.model['trader-contacts'] = function() {
    // add place
    $('.add-place').on('click', function(e) {
      e.preventDefault();
      var place = $(this).parents('#placeModal').find('.place').val();
      if (place.length == 0) {
        new Noty({
          type: 'warning',
          text: 'Необходимо указать место.'
        }).show();
        return false;
      }
      app.ajax(location.href, {action: 'addContactPlace', place: place}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else {
          location.reload();
        }
      });
    });
    // phone mask
    $('input[name="phone"]').mask("0(xx) xx-xx-xxx", {
      placeholder: "Номер телефона",
      translation: {
        0: {pattern: /[0*]/},
        'x': {pattern: /(\d+)/}
      }
    });
    // add contact 
    $('.add-contact').on('click', function(e) {
      e.preventDefault();
      var place = $(this).attr('place');
      $('.contact-form')[0].reset();
      $('#contact').modal('show');
      // validate act form
      $('.contact-form').validate({
        rules: {
          post: {
            required: true
          },
          name: {
            required: true
          },
          phone: {
            required: true
          },
          email: {
            required: true,
            email: true
          }
        },
        messages: {
          post: {
            required: 'Необходимо указать должность.'
          },
          name: {
            required: 'Укажите контактное лицо.'
          },
          phone: {
            required: 'Введите номер телефона.'
          },
          email: {
            required: 'Укажите Email.',
            email: 'Email указан с ошибками.'
          }
        },
        errorElement: 'span',
        errorPlacement: function ( error, element ) {
          $(error).addClass('error-text');
          $(element).parents('div[class^="col-sm-"]').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('error-input');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('error-input');
        },
        submitHandler: function(form, e) {
          e.preventDefault();
          var formData = $(form).serializeArray();
              formData[formData.length] = {name: 'place', value: place};
              formData[formData.length] = {name: 'action', value: 'addContact'};
          var phone    = '38' + $('.contact-form input[name="phone"]').cleanVal();
              formData = app.utils.serializeArrayChange(formData, 'phone', phone);
          app.ajax(location.href, formData, function(data) {
            if (data.code == 0) {
              new Noty({
                type: 'error',
                text: data.text
              }).show();
              return false;
            } else {
              location.reload();
            }
          });
        }
      });
    });
    $('.edit-contact').on('click', function(e) {
      e.preventDefault();
      var contact = $(this).attr('contact');
      var $contact = $(this).parents('.contact');
      $('#editContact').modal('show');
      $('.edit-contact-form input[name="post"]').val($contact.find('.post').text());
      $('.edit-contact-form input[name="name"]').val($contact.find('.name').text());
      $('.edit-contact-form input[name="phone"]').val($contact.find('.phone').text().split('38')[1]).trigger('input');
      $('.edit-contact-form input[name="email"]').val($contact.find('.email').text());
      // validate act form
      $('.edit-contact-form').validate({
        rules: {
          post: {
            required: true
          },
          name: {
            required: true
          },
          phone: {
            required: true
          },
          email: {
            required: true,
            email: true
          }
        },
        messages: {
          post: {
            required: 'Необходимо указать должность.',
            email: 'Email указан с ошибками.',
          },
          name: {
            required: 'Укажите контактное лицо.'
          },
          phone: {
            required: 'Введите номер телефона.'
          },
          email: {
            required: 'Укажите Email.'
          }
        },
        errorElement: 'span',
        errorPlacement: function ( error, element ) {
          $(error).addClass('error-text');
          $(element).parents('div[class^="col-sm-"]').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('error-input');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('error-input');
        },
        submitHandler: function(form, e) {
          e.preventDefault();
          var formData = $(form).serializeArray();
              formData[formData.length] = {name: 'contact', value: contact};
              formData[formData.length] = {name: 'action', value: 'editContact'};
          var phone    = '38' + $('.edit-contact-form input[name="phone"]').cleanVal();
              formData = app.utils.serializeArrayChange(formData, 'phone', phone);
          app.ajax(location.href, formData, function(data) {
            if (data.code == 0) {
            new Noty({
          type: 'error',
          text: data.text
        }).show();
            return false;
          } else {
              location.reload();
            }
          });
        }
      });
    });
    // edit place
    $('.edit-place').on('click', function(e) {
      e.preventDefault();
      var placeId = $(this).attr('place');
      var title = $(this).prev().text();
      $('#editPlaceModal').find('input.place').val(title);
      $('#editPlaceModal').modal('show');
      $('.save-place').on('click', function(e) {
        e.preventDefault();
        var place = $(this).parents('#editPlaceModal').find('.place').val();
        if (place.length == 0) {
          new Noty({
            type: 'warning',
            text: 'Необходимо указать место.'
          }).show();
          return false;
        }
        app.ajax(location.href, {action: 'editContactPlace', placeId: placeId, place: place}, function(data) {
          if (data.code == 0) {
            new Noty({
          type: 'error',
          text: data.text
        }).show();
            return false;
          } else {
            location.reload();
          }
        });
      });
    });
    // remove place
    $('.remove-place').on('click', function(e) {
      e.preventDefault();
      var place = $(this).attr('place'); 
      app.ajax(location.href, {action: 'removeContactPlace', place: place}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else {
          location.reload();
        }
      });
    });
    // remove contact
    $('.remove-contact').on('click', function(e) {
      e.preventDefault();
      var place   = $(this).attr('place'); 
      var contact = $(this).attr('contact'); 
      app.ajax(location.href, {action: 'removeContact', place: place, contact: contact}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else {
          location.reload();
        }
      });
    });
  };

  app.model['prices'] = function() {
    $('.price-table tr').each(function(){
      $(this).find('.currency-0').eq(0).css('box-shadow', 'inset 18px -1px 18px -18px rgba(167, 167, 167, 0.62)');
    });
    $('.price-table tr').each(function(){
      $(this).find('.currency-1').eq(0).css('box-shadow', 'inset 18px -1px 18px -18px rgba(167, 167, 167, 0.62)');
    });
    $('.table-tabs a').on('click', function(e) {
      e.preventDefault();
      var $table = $(this).parent().next();
      var currency = $(this).attr('currency');
      $(this).parent().find('a').removeClass('active');
      $(this).addClass('active');
      $table.find('td[class^="currency-"]').hide();
      $table.find('td.currency-'+currency).css('display', 'table-cell');
    });
    // delte price rubric
    $('.delete-rubric').on('click', function(e) {
      var rubric = $(this).parents('th').attr('rubric');
      app.ajax(location.href, {action: 'deleteRubric', rubric: rubric}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else {
          location.reload();
        }
      });
    });
    // add price rubric
    $('.add-rubric').on('click', function(e) {
      var rubric    = $(this).prev().val();
      var placeType = $(this).attr('placeType');
      app.ajax(location.href, {action: 'addRubric', rubric: rubric, placeType: placeType}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else {
          location.reload();
        }
      });
    });
    // add place
    $('.add-place').on('click', function(e) {
      var region = $(this).prev().prev().val();
      var place  = $(this).prev().val();
      app.ajax(location.href, {action: 'addPlace', region: region, place: place}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else {
          location.reload();
        }
      });
    });
    // delte place
    $('.delete-place').on('click', function(e) {
      var place = $(this).parents('td').attr('place');
      app.ajax(location.href, {action: 'deletePlace', placeId: place}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else {
          location.reload();
        }
      });
    });
    // visible table
    $('.setVisible').on('click', function(e) {
      var visible = $(this).attr('visible');
      app.ajax(location.href, {action: 'setVisible', visible: visible}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else {
          location.reload();
        }
      });
    });
    // edit place
    $('.edit-comment').on('click', function(e) {
      var place = $(this).parents('td').attr('place');
      var comment = $(this).parents('td').find('.place-comment').text();
      $('.modal-comment').val(comment);
      $('.editModal').modal('show');
      $('.update-place').on('click', function(e) {
        e.preventDefault();
        var comment = $('.modal-comment').val();
        app.ajax(location.href, {action: 'updatePlace', place: comment, placeId: place}, function(data) {
          if (data.code == 0) {
            new Noty({
          type: 'error',
          text: data.text
        }).show();
            return false;
          } else {
            location.reload();
          }
        });
      });
    });
    // save prices
    $('.save-prices').on('click', function(e) {
      e.preventDefault();
      var prices = [];
      $('.price-table').find('td[class^="currency"]').each(function() {
        var place = $(this).attr('place');
        var rubric = $(this).attr('rubric');
        var currency = $(this).attr('currency');
        var cost = parseInt($(this).find('.price-cost').val());
        var cost = isNaN(cost) ? null : cost;
        var comment = $(this).find('.price-comment').val();
        prices[prices.length] = {
          place: place,
          rubric: rubric,
          currency: currency,
          cost: cost,
          comment: comment
        };
      });
      app.ajax(location.href, {action: 'savePrices', prices: prices}, function(data) {
        if (data.code == 1) {
          location.reload();
        }
      });
    });
  };

  app.model['balance-form'] = function() {
    $('.amountInput').on('change paste keydown keyup keypress', function(e) {
      if(!((e.keyCode > 95 && e.keyCode < 106) || (e.keyCode > 47 && e.keyCode < 58) || e.keyCode == 8)) {
        return false;
      }
      if ($(this).val().length > 5) {
        $(this).val($(this).val().slice(0, 5));
      }
      var amount = ($(this).val().length == 0) ? '0' : $(this).val();
      $('.way .price .cost, .pay-alert .amount').text(amount);
    });
    // phone mask
    $('#phone').mask("0(xx) xx-xx-xxx", {
      placeholder: "Номер телефона",
      translation: {
        0: {pattern: /[0*]/},
        'x': {pattern: /(\d+)/}
      }
    });
    $('#docAddrCheck').change(function() {
      if (this.checked) {
        $('.docs').addClass('docs-visible');
      } else {
        $('.docs').removeClass('docs-visible');
      }
    });
    // toggle payer type
    $('.pay-act .title .who a').on('click', function(e) {
      e.preventDefault();
      var who = $(this).attr('data-who');
      if (who == 'individual') {
        $('.docs').removeClass('docs-visible');
      } else if (who == 'entity') {
        if ($('#docAddrCheck').prop('checked') == true) {
          $('.docs').addClass('docs-visible');
        }
      }
      $('.pay-act .title .who a').removeClass('active');
      $(this).addClass('active');
      $('.act-form .who').hide();
      $('.act-form .who.'+who).css('display', 'flex');
    });
    // selecy pay method 
    $('.pay-block .way').on('click', function(e) {
      var amount = parseInt($('.amountInput').val());
      if ($('.pay-act').length) {
        if (!amount || amount < 50) {
          new Noty({
            type: 'warning',
            text: 'Сумма пополнения не может быть меньше 50 гривен.'
          }).show();
          return false;
        }
      } 
      var type = $(this).attr('type');
      if (type == 'act') {
        $('.pay-act').show();
        $(this).addClass('active');
      } else {
        app.ajax(location.href, {action: 'getPayForm', type: type, amount: amount}, function(data) {
          if (data.code == 0) {
            new Noty({
              type: 'error',
              text: data.text
            }).show();
            return false;
          } else {
            $(data.form).hide().appendTo('body').submit();
          }
        });
      }
    });
    // submit form on btn click
    $('.payBtn').on('click', function(e) {
      e.preventDefault();
      $('.act-form').submit();
    });
    // validate act form
    $('.act-form').validate({
      rules: {
        company: {
          required: true
        },
        name: {
          required: true
        },
        phone: {
          required: true
        },
        entityAddr: {
          required: true
        },
        code: {
          required: true
        },
        inn: {
          required: true
        },
        city: {
          required: true
        },
        zip: {
          required: true
        },
        addr: {
          required: true
        }
      },
      messages: {
        company: {
          required: 'Введите название компании'
        },
        name: {
          required: 'Укажите Ваши Ф.И.О.'
        },
        phone: {
          required: 'Введите Ваш номер'
        },
        entityAddr: {
          required: 'Укажите адрес'
        },
        code: {
          required: 'Введите код'
        },
        inn: {
          required: 'Укажите номер'
        },
        city: {
          required: 'Укажите населённый пункт'
        },
        zip: {
          required: 'Укажите индекс'
        },
        addr: {
          required: 'Укажите адрес'
        }
      },
      errorElement: 'span',
      errorPlacement: function ( error, element ) {
        $(error).addClass('error-text');
        $(element).parents('div[class^="col-sm-"]').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('error-input');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('error-input');
      },
      submitHandler: function(form, e) {
        e.preventDefault();
        $('.error-text').remove();
        $('.error-input').removeClass('error-input');

        var amount = parseInt($('.amountInput').val());
        if (amount < 50) {
          new Noty({
            type: 'warning',
            text: 'Сумма пополнения не может быть меньше 50 гривен.'
          }).show();
          return false;
        }

        $('.pay-act').find('button[type="submit"]').prop('disabled', true);
     
        var formData = $(form).serializeArray();
            formData[formData.length] = {name: 'amount', value: amount};
            formData[formData.length] = {name: 'action', value: 'makeInvoice'};

        var phone = '38' + $('#phone').cleanVal();
        formData = app.utils.serializeArrayChange(formData, 'phone', phone);

        app.ajax(location.href, formData, function(data) {
          if (data.code == 0) {
            new Noty({
              type: 'error',
              text: data.text
            }).show();
            return false;
          } else {
            $('.submenu').next().html('<div class="content-block pay-block mt-5 p-5 text-center">' + 
                                        '<h4>Счет сформирован, Вы можете скачать и распечатать его.</h4>' +
                                        '<p class="mt-4">Для ускорения зачисления средств на Ваш счет рекомендуем Вам дополнительно отправить сканкопию платежки по этому адресу <b><a href="mailto:pay@agrotender.com.ua">pay@agrotender.com.ua</a></b>. В течении суток после оплаты деньги будут зачислены на ваш личный счет на сайте. Суббота и воскресенье выходные дни. В случае возникновения проблем пишите в техпожжрежку <b><a href="mailto:pay@agrotender.com.ua">pay@agrotender.com.ua</a></b> или звоните по нашему контактному номеру <b>(057) 716-06-38</b>.</p>' +
                                        '<a class="btn payBtn mt-4 px-5" href="/'+data.file+'" target="_blank">Посмотреть счёт #'+data.id+'</a>' +
                                      '</div>');
          }
        })
      }
    });
  };

  app.model['paid-services'] = function() {
    $('.pack-block').on('click', function(e) {
      if (!$(e.target).hasClass('selectNum')) {
        $(this).toggleClass('active');
      }
      var total = 0;
      $('.pack-block.active').each(function() {
        total += parseInt($(this).find('.cost').text());
      });
      $('.totalPrice .cost').text(total);
    });
    $('.selectNum').on('change', function(e) {
      e.preventDefault();
      var cost = parseInt($(this).find('option:selected').attr('cost'));
      $(this).next().find('.cost').text(cost);
    });
    $('.payBtn').on('click', function(e) {
      e.preventDefault();
      var advId = $(this).attr('post-id');
      var packs = [];
      $('.pack-block.active').each(function() {
        if ($(this).hasClass('pack-1')) {
          packs[packs.length] = $(this).find('select').val();
        } else {
          packs[packs.length] = $(this).attr('pack-id');
        }
      });
      app.ajax('/u/ads/upgrade', {action: 'upgradeAdv', advId: advId, packs: packs}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else if (data.code == 1) {
          location.href = '/u/ads/upgrade';
        } else if (data.code == 2) {
          location.href = '/u/balance/pay?payAdv='+data.payAdv+'&payPacks='+data.payPacks+'&payAmount='+data.payAmount+'';
        }
      });
    });
  };

  app.model['advertForm-utils'] = function() {
    $('#title').keyup(function () {
      var max = 70;
      var len = $(this).val().length;
      if (len >= max) {
        $('.titleCounter b').text('0');
        $(this).val($(this).val().substring(0, max));
      } else {
        var char = max - len;
        $('.titleCounter b').text(char);
      }
    });
    // phone mask
    $('input.newPhone').mask("0(xx) xx-xx-xxx", {
      placeholder: "Номер телефона",
      translation: {
        0: {pattern: /[0*]/},
        'x': {pattern: /(\d+)/}
      }
    });
    $('input.code').mask("0-0-0-0", {placeholder: "x-x-x-x"});
    if ($('#confirmPhone').length) {
      $('#confirmPhone').modal({backdrop: 'static', keyboard: false});
    }
    // rubric modal
    $('.form-group').on('mousedown', '.select-rubric, .btn-change',  function(e) {
      e.preventDefault();
      $('a[class*="group-"], a[class*="subgroup-"], .backToRubric').hide();
      $('.getRubricGroup').show();
      $('.backToRubric').removeClass('b2');
      // get proposeds 
      app.ajax(location.href, {action: 'getProposed', title: $('#title').val()}, function(data) {
        if (data.code == 1) {
          var html = '';
          for (x in data.proposed) {
            html += '<span class="proposed" rubric-id="'+data['proposed'][x].id+'">'+data['proposed'][x].parenttitle+' > <span>'+data['proposed'][x].title+'</span></span>';
          }
          $('.proposeds').html(html);
          $('.if-empty-rubric').hide();
          $('.if-not-empty-rubric').show();
        } else {
          $('.if-empty-rubric').show();
          $('.if-not-empty-rubric').hide();
        }
      });
      $('.rubricModal').modal('show');
      $('.proposeds').unbind('click').on('click', '.proposed',  function(e) {
        e.preventDefault();
        var rubric = $(this).attr('rubric-id');
        var rubricText = $(this).text();
        $('.select-rubric').parent().removeClass('col-sm-5').addClass('col-sm-8').html('<input type="hidden" class="rubric" name="rubric" value="'+rubric+'"><span class="rubric-text">'+rubricText+'</span> <button class="btn btn-change select-rubric ml-3">Изменить</button>');
        $('.select-rubric-img').remove();
        $('a[class*="group-"], a[class*="subgroup-"], .backToRubric').hide();
        $('.getRubricGroup').show();
        $('.rubricModal').modal('hide');
        $('.backToRubric').removeClass('b2');
      });
    });
    // default rubric list select
    $('.getRubricGroup').on('click', function(e) {
      e.preventDefault();
      var group = $(this).attr('group');
      $('.getRubricGroup').hide();
      $('a[class*="group-"], a[class*="subgroup-"]').hide();
      $('.backToRubric, .group-' + group).show();
    });

    $('a[class*="group-"]').on('click', function(e) {
      e.preventDefault();
      var subgroup = $(this).attr('subgroup');
      var group    = $(this).attr('class').split('group-')[1].split(' ')[0];
      $('.backToRubric').addClass('b2').attr('group', group);
      $('a[class*="group-"], a[class*="subgroup-"]').hide();
      $('.subgroup-' + subgroup).show();
    });

    $('a[class*="subgroup-"]').on('click', function(e) {
      e.preventDefault();
      var rubric = $(this).attr('group');
      var subgroup = $('.btn.section[subgroup="'+$(this).attr('class').split('subgroup-')[1]+'"]');
      var group    = $('.getRubricGroup[group="'+subgroup.attr('class').split('group-')[1]+'"]');
      var r3 = $(this).find('span:last').text(); // rubric name
      var r2 = subgroup.find('span:last').text(); // subgroup
      var r1 = group.find('span:last').text(); // main group
      var rubricText = r2 + ' > ' + r3;
      $('.select-rubric').parent().removeClass('col-sm-5').addClass('col-sm-8').html('<input type="hidden" class="rubric" name="rubric" value="'+rubric+'"><span class="rubric-text">'+rubricText+'</span> <button class="btn btn-change select-rubric ml-3">Изменить</button>');
      $('.select-rubric-img').remove();
      $('a[class*="group-"], a[class*="subgroup-"], .backToRubric').hide();
      $('.getRubricGroup').show();
      $('.rubricModal').modal('hide');
      $('.backToRubric').removeClass('b2');
    });

    $('.backToRubric').on('click', function(e) {
      e.preventDefault();
      if ($(this).hasClass('b2')) {
        var group = $(this).attr('group');
        $('a[class*="group-"], a[class*="subgroup-"]').hide();
        $('.group-' + group).show();
        $(this).removeClass('b2');
      } else {
        $('.getRubricGroup').show();
        $('a[class*="group-"], a[class*="subgroup-"], .backToRubric').hide();
      }
    });
    // select cove
    $('.images-box').on('click', '.image-block:not(.empty) img', function(e) {
      e.preventDefault();
      $('.image-block').removeClass('selected');
      $(this).parent().addClass('selected');
      $('.cover').val($(this).attr('img-id'));
    });
    // select images on click to empty image box
    $('.images-box').on('click', '.image-block.empty', function(e) {
      e.preventDefault();
      $('.images-input').click();
    });
    // select iamges
    $('.images-input').on('change', function(e) {
      e.preventDefault();
      $.each(this.files, function(index, file) {
        if ($.inArray(file.type.split('/')[1], ['jpeg', 'jpg', 'png', 'gif']) != -1) {
          var imgId = Math.random().toString(36).substring(7);
          files[imgId] = file;
          var emptyBlock = $('.images-box').find('.empty');
          if (emptyBlock.length > 0) {
            $('.images-box').find('.empty:first').removeClass('empty').find('img').attr({'src': URL.createObjectURL(file), 'img-id': imgId});
          }
        } else {
          new Noty({
            type: 'warning',
            text: 'Загружать можно только изображения.'
          }).show();
          return false;
        }
      });
      $('.cover').val($('.image-block.selected img').attr('img-id'));
    });
    // remove local images
    $('.images-box').on('click', '.image-block .remove:not(.server)', function(e) {
      e.preventDefault();
      var imgBlock = $(this).parent();
      imgBlock.addClass('empty');
      $('.image-block').insertBefore($('.empty:first'));
      var img = $(this).prev();
      var id  = img.attr('img-id');
      img.parent().addClass('empty');
      img.attr({'src': '/app/assets/img/add-photo.png', 'img-id': ''});
      delete files[id];
      if (imgBlock.hasClass('selected')) {
        imgBlock.removeClass('selected');
        $('.image-block').eq(0).addClass('selected');
        $('.cover').val($('.image-block.selected img').attr('img-id'));
      }
    });
    // remove local images
    $('.images-box').on('click', '.image-block .remove.server', function(e) {
      e.preventDefault();
      if (confirm('Вы действительно хотите удалить изображение?')) {
        var imgBlock = $(this).parent();
        var img = $(this).prev();
        var id  = img.attr('img-id');
        app.ajax(location.href, {action: 'removeImage', image_id: id}, function(data) {
          if (data.code == 0) {
            new Noty({
          type: 'error',
          text: data.text
        }).show();
            return false;
          } else {
            imgBlock.addClass('empty');
            $('.image-block').insertBefore($('.empty:first'));
            img.parent().addClass('empty');
            img.attr({'src': '/app/assets/img/add-photo.png', 'img-id': ''});
            if (imgBlock.hasClass('selected')) {
              imgBlock.removeClass('selected');
              $('.image-block').eq(0).addClass('selected');
              $('.cover').val($('.image-block.selected img').attr('img-id'));
            }
          }
        });
      }
    });
  }

  app.model['edit-advert'] = function() {
    var typeValue = $('#type').val();
    var regionsValue = $('.regionsList').val().split(',');
    if (typeValue == 1) {
      $('#regions').removeClass('form-control').multipleSelect();
      $('#regions').multipleSelect('setSelects', regionsValue);
    }
    var typeSelect = $('#type');
    typeSelect.on('change', function() {
      var type = $(this).val();
      if (type == 1) {
        $('#regions').removeClass('form-control').multipleSelect();
        $('#regions').multipleSelect('setSelects', regionsValue);
      } else {
        $('#regions').multipleSelect('destroy').addClass('form-control').show();
      }
    });
    $('.form-advert').validate({
      rules: {
        title: {
          required: true
        },
        rubric: {
          required: true
        },
        type: {
          required: true
        },
        description: {
          required: true
        },
        region: {
          required: true
        },
        city: {
          required: true
        }
      },
      messages: {
        title: {
          required: 'Введите заголовок.'
        },
        rubric: {
          required: 'Выберите рубрику.'
        },
        type: {
          required: 'Выберите тип'
        },
        description: {
          required: 'Введите описание'
        },
        region: {
          required: 'Выбериет регион'
        },
        city: {
          required: 'Укажите населённый пункт'
        }
      },
      errorElement: 'span',
      errorPlacement: function ( error, element ) {
        $(error).addClass('error-text');
        $(element).parents('div[class^="col-sm-"]').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('error-input');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('error-input');
      },
      submitHandler: function(form, e) {
        e.preventDefault();
        $('.error-text').remove();
        $('.error-input').removeClass('error-input');
        $(form).find('button[type="submit"]').prop('disabled', true).find('.btn-text').hide().next().show();
        // check if rubric select
        var rubric = $('.rubric').val();
        if (rubric.length == 0) {
          $('.select-rubric').after('<span id="title-error" class="error error-text">Выберите рубрику.</span>');
        }
        // advert cover
        if ($('.cover').val().length == 0 && Object.keys(files).length > 0) {
          $('.cover').val($('.image-block.selected img').attr('img-id'));
        }
        var formData = new FormData(form);
        $.each(files, function(key, file) {
          formData.append(key, file);
        });
        for (x in files) {
          formData.append('images['+x+']', files[x]);
        }
        if ($('.ms-choice').length) {
          formData.set('regions', $('#regions').multipleSelect('getSelects'));
        }
        formData.append('action', 'editPost');
        // send data to server
        app.ajax(location.href, formData, function(data) {
          if (data.code == 0) {
            new Noty({
          type: 'error',
          text: data.text
        }).show();
            return false;
          } else {
            location.href = '/u/ads';
          }
        }, false, true);
      }
    });
  };

  app.model['add-advert'] = function() {
    var typeSelect = $('#type');
    typeSelect.on('change', function() {
      var type = $(this).val();
      if (type == 1) {
        $('#regions').removeClass('form-control').multipleSelect();
      } else {
        $('#regions').multipleSelect('destroy').addClass('form-control').show();
      }
    });
    $('.form-advert').validate({
      rules: {
        title: {
          required: true
        },
        rubric: {
          required: true
        },
        type: {
          required: true
        },
        description: {
          required: true
        },
        region: {
          required: true
        },
        city: {
          required: true
        }
      },
      messages: {
        title: {
          required: 'Введите заголовок.'
        },
        rubric: {
          required: 'Выберите рубрику.'
        },
        type: {
          required: 'Выберите тип'
        },
        description: {
          required: 'Введите описание'
        },
        region: {
          required: 'Выбериет регион'
        },
        city: {
          required: 'Укажите населённый пункт'
        }
      },
      errorElement: 'span',
      errorPlacement: function ( error, element ) {
        $(error).addClass('error-text');
        $(element).parents('div[class^="col-sm-"]').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('error-input');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('error-input');
      },
      submitHandler: function(form, e) {
        e.preventDefault();
        $('.error-text').remove();
        $('.error-input').removeClass('error-input');
        // check if rubric select
        var rubric = $('.rubric').val();
        if (rubric.length == 0) {
          $('.select-rubric').after('<span id="title-error" class="error error-text">Выберите рубрику.</span>');
          new Noty({
            type: 'error',
            text: 'Выберите рубрику.'
          }).show();
          return false;
        }
        $(form).find('button[type="submit"]').prop('disabled', true);
        // advert cover
        if ($('.cover').val().length == 0 && Object.keys(files).length > 0) {
          $('.cover').val($('.image-block.selected img').attr('img-id'));
        }
        var formData = new FormData(form);
        $.each(files, function(key, file) {
          formData.append(key, file);
        });
        for (x in files) {
          formData.append('images['+x+']', files[x]);
        }
        if ($('.ms-choice').length) {
          formData.set('regions', $('#regions').multipleSelect('getSelects'));
        }
        formData.append('action', 'addPost');
        // send data to server
        app.ajax(location.href, formData, function(data) {
          if (data.code == 0) {
            new Noty({
              type: 'error',
              text: data.text
            }).show();
            $(form).find('button[type="submit"]').prop('disabled', false);
            return false;
          } else {
            location.href = '/board/success';
          }
        }, false, true);
      }
    });
  };

  app.model['restore'] = function() {
    // login process
    $('.restore').validate({
      rules: {
        email: {
          required: true,
          email: true
        }
      },
      messages: {
        email: {
          required: 'Вы не указали свой email-адрес.',
          email: 'Email указан с ошибками.'
        }
      },
      errorElement: 'span',
      errorPlacement: function ( error, element ) {
        $(error).addClass('error-text');
        $(element).parents('.col-sm-6').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('error-input');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('error-input');
      },
      submitHandler: function(form) {
        $(form).find('button[type="submit"]').prop('disabled', true);
        var formData = $(form).serializeArray();
            formData[formData.length] = {name: 'action', value: 'restore'};
        // send data to server
        app.ajax(location.href, formData, function(data) {
          if (data.code == 0) {
            new Noty({
              type: 'error',
              text: data.text
            }).show();
            $(form).find('button[type="submit"]').prop('disabled', false);
            return false;
          } else {
            location.href = '/success';
          }
        });
      }
    });
  };

  app.model['sign-in'] = function() {
    // login process
    $('.sign-in').validate({
      rules: {
        email: {
          required: true,
          email: true
        },
        password: {
          required: true,
          rangelength: [6, 20]
        }
      },
      messages: {
        email: {
          required: 'Вы не указали свой email-адрес.',
          email: 'Email указан с ошибками.'
        },
        password: {
          required: "Введите пароль.",
          rangelength: "Пароль должен быть от 6 до 20 символов."
        }
      },
      errorElement: 'span',
      errorPlacement: function ( error, element ) {
        $(error).addClass('error-text');
        $(element).parents('.col-sm-6').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('error-input');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('error-input');
      },
      submitHandler: function(form) {
        $(form).find('button[type="submit"]').prop('disabled', true);
        var formData = $(form).serializeArray();
            formData[formData.length] = {name: 'action', value: 'sign-in'};

        // send data to server
        app.ajax(location.href, formData, function(data) {
          if (data.code == 0) {
            $(form).find('button[type="submit"]').prop('disabled', false);
            new Noty({
              type: 'error',
              text: data.text
            }).show();
            return false;
          } else {
            location.href = '/';
          }
        });
      }
    });
  };

  app.model['sign-up'] = function() {
    // show/hide password on hover eye icon
    $('.show-password').hover(function() {
      $('.password').attr("type", "text");
    }, function() {
      $('.password').attr("type", "password");
    });
    // tips on focus input
    $('.form input').on('focus', function() {
      $(this).parents('[class^="col-"]').addClass('tip');
    });
    $('.form input').on('blur', function() {
      $(this).parents('[class^="col-"]').removeClass('tip');
    });
    // phone mask
    $('input.phone').mask("0(xx) xx-xx-xxx", {
      placeholder: "Номер телефона",
      translation: {
        0: {pattern: /[0*]/},
        'x': {pattern: /(\d+)/}
      }
    });
    // code mask
    $('input.code').mask("0-0-0-0", {placeholder: "x-x-x-x"});
    // register process
    $('.sign-up').validate({
      rules: {
        email: {
          required: true,
          email: true,
          remote: {
            url: location.href,
            type: 'post',
            data: {
              action: 'check-email'
            }
          }
        },
        password: {
          required: true,
          rangelength: [6, 20]
        },
        rePassword: {
          required: true,
          equalTo: "#password"
        },
        name: {
          required: true,
          minlength: 2
        },
        phone: {
          required: true,
          remote: {
            url: location.href,
            type: 'post',
            data: {
              phone: function() {
                return '38' + $('input.phone').cleanVal();
              },
              action: 'check-phone'
            }
          }
        },
        region: {
          required: true
        }
      },
      messages: {
        email: {
          required: 'Вы не указали свой email-адрес.',
          email: 'Email указан с ошибками.',
          remote: 'Данный email уже используется.'
        },
        password: {
          required: "Введите пароль.",
          rangelength: "Пароль должен быть от 6 до 20 символов."
        },
        rePassword: {
          required: "Повторите пароль.",
          equalTo: "Пароли не совпадают."
        },
        name: {
          required: 'Укажите контактное лицо.',
          minlength: 'Минимальная длина поля - 2 символа.'
        },
        phone: {
          required: 'Введите Ваш номер телефона.',
          remote: 'Такой номер телефона уже используется.'
        },
        region: {
          required: 'Выберите Вашу область.'
        }
      },
      errorElement: 'span',
      errorPlacement: function ( error, element ) {
        $(error).addClass('error-text');
        $(element).parents('.col-sm-5').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('error-input');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('error-input');
      },
      submitHandler: function(form) {
        $(form).find('button[type="submit"]').prop('disabled', true);
        var phone = '38' + $('input.phone').cleanVal();
        app.ajax(location.href, {action: 'send-code', phone: phone}, function(data) {
          if (data.code == 0) {
            new Noty({
              type: 'error',
              text: data.text
            }).show();
            return false;
          } else {
            $(form).find('button[type="submit"]').prop('disabled', false);
            // show confirm code modal
            $('.codeModal .phone').text('+' + phone);
            $('.codeModal').modal('show');
            // repeat sms confirm code
            $('.repeat-code').on('click', function(e) {
              e.preventDefault();
              app.ajax(location.href, {action: 'repeat-code', phone: phone}, function(data) {
                new Noty({
              type: 'info',
              text: data.text
            }).show();
              });
            });
            // register process
            $('.send-code').on('click', function(e) {
              e.preventDefault();
              // serialize data from send to server
              var formData = $(form).serializeArray();
              var code     = $('input.code').cleanVal();
              formData = app.utils.serializeArrayChange(formData, 'phone', phone);
              formData[formData.length] = {name: 'action', value: 'sign-up'};
              formData[formData.length] = {name: 'code', value: code};
              // send data to server
              app.ajax(location.href, formData, function(data) {
                if (data.code == 0) {
                  new Noty({
                    type: 'error',
                    text: data.text
                  }).show();
                  return false;
                } else {
                  location.href = '/thankyou';
                }
              });
            });
          }
        });
      }
    });
    /*
    $('.sign-up').on('submit', function(e) {
      e.preventDefault();
      $.each($(this).find('input'), function(i, input) {
        
      });
      var phone = $('input.phone').cleanVal();
      var formData = $(this).serializeArray();
      formData = app.utils.serializeArrayChange(formData, 'phone', phone);
      formData[formData.length] = {name: 'action', value: 'sign-up'};
      app.ajax(location.href, {action: 'send-code', phone: phone}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
              } else {
          $('.codeModal .phone').text('+380' + phone);
          $('.codeModal').modal('show');
          $('.send-code').on('click', function(e) {
            e.preventDefault();
            var code = $('input.code').cleanVal();
            formData[formData.length] = {name: 'code', value: code};
            app.ajax(location.href, formData, function(data) {
              if (data.code == 0) {
                $('.code-error').show();
              } else {
                location.href = '/thankyou';
              }
            });
          });
        }
      });
    }); */
  };

  app.model['analitic'] = function() {
    $('.input-date').datepicker({
      format: 'dd.mm.yyyy',
      startDate: new Date(2015,2,1),
      endDate: '-0d',
      language: "ru",
      autoclose: true,
      todayHighlight: true
    });
    $('.input-date').on('changeDate', function(e) {
      $(this).addClass('current');
      var dot = ($(this).attr('id') == 'from') ? 'Start' : 'End';
      $('.input-date:not(.current)').datepicker('set'+dot+'Date', e.format());
    });
    $(".tr-graph-tab a").bind("click", function(e){   
      e.preventDefault();
      $(".tr-graph-tab a").removeClass('active');
      $(this).addClass('active');
      $("#from").datepicker('setDate', $(this).attr("start"));
      $("#to").datepicker('setDate', $(this).attr("end"));
    
      $("#dtstepval").val($(this).attr("data-frid"));
    });

    app.ajax(location.href, {action: 'getAnalitic'}, function(data) {
      console.log(data.graph);
      Highcharts.chart('trpricechart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Аналитика закупочных цен '
        },
        subtitle: {
            text: 'Источник: Цены трейдеров на Agrotender.com.ua'
        },
        xAxis: {
          categories: data.categories,
          crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Цена'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: data.graph
      });
    });
  };

  app.model['select-row'] = function() {
    if (screen.width < 767) {
      $(".sortTable").parents(".container").removeClass("container");
      $(".sortTable tbody tr").on("touchstart", function() {
        $(".sortTable tbody tr").removeClass('touched');
        $(this).addClass('touched');
      });
    }
  };

  app.model['elevs'] = function() {
    var start = 24;
    var inProgress = false;
    $(window).on('scroll', function() {
      if ($(window).scrollTop() + $(window).height() > ($('.elev').height() - 200) && !inProgress) {
        inProgress = true;
        app.ajax(location.href, {action: 'getElevs', start: start}, function(data) {
          if (data.more == false) return false;
          var html = '';
          $.each(data.elev, function(index, group) {
            html += '<div class="row mb-0 mb-sm-5 mx-0">';
            $.each(group, function(i, elev) {
              var name    = (elev.name.length > 35) ? truncate(elev.name, 35, {ending: '..', trim: true, words: false}) : elev.name;
              var tooltip = (elev.name.length > 35) ? ' data-toggle="tooltip" data-placement="top" title="'+escapeHtml(elev.name)+'"' : '';
              var right   = (i == 0) ? ' mr-0 mr-sm-4' : '';
              var pr      = (i == 0) ? ' pr-0 pr-sm-3' : ''; // padding-right
              html += '<div class="col-12 col-sm-6'+pr+'">'+
                        '<a href="/elev/'+elev.url+'.html" class="row d-flex content-block p-2'+right+'">'+
                          '<div class="col-auto px-2 d-none d-sm-block">'+
                            '<img src="/app/assets/img/granary-4.png" class="icon">'+
                          '</div>'+
                          '<div class="col pl-1 text-left d-flex align-items-center">'+
                            '<div>'+
                              '<span class="d-block title"'+tooltip+'>'+name+'</span>'+
                              '<span class="d-block geo">'+elev.region+' область / '+elev.ray+' р-н</span>'+
                            '</div>'+
                          '</div>'+
                          '<div class="col-auto px-2 d-flex align-items-center">'+
                            '<i class="far fa-angle-right icon-right"></i>'+
                          '</div>'+
                        '</a>'+
                      '</div>';
            });
            html += '</div>';
          });
          $('.elev').append(html);
          start += 24;
          inProgress = false;
        });
      }
    });
  };

  app.model['elev-regions'] = function() {
    var click = 0;
    $(".select-link").on("click", function(e) {
      e.preventDefault();
      if (click == 0) {
        $(".dropdown").show();
        click = 1;
      } else {
        $(".dropdown").hide();
        click = 0;
      }
    });
  };

  app.model['advertPhotos'] = function() {
    var swiper = new Swiper('.swiper-container', {
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      }
    });
    
    $('img[data-imagelightbox="g"]').imageLightbox({
        activity: true,
        arrows: true,
        button: true,
        caption: true,
        navigation: true,
        overlay: true,
        quitOnDocClick: false,
        selector: 'img[data-imagelightbox="f"]'
    });

  };

  app.model['advertSearch'] = function() {
    $('.searchIcon').on('click', function(e) {
      e.preventDefault();
      $(this).parents('form').submit();
    });
    $('.searchForm').on('submit', function(e) {
      e.preventDefault();
      const query = $('.searchInput').val();

      if (query.length < 1) {
        $('.searchDiv').addClass('tip');
      } else {
        var path = window.location.pathname; 
        path = path.replace(/\/s\/(.*?)\//gi, '/');
        var searchUrl = path.replace('/board', '/s/'+query+'/board');
        location.href = searchUrl;
      }
    });
    $('.searchDiv').parent().on('mouseleave', function (e) {
      e.preventDefault();
      $(this).find('.tip').removeClass('tip');
    });
  };

  app.model['tradersFilters'] = function() {
    function getRank(name) {
       var date = name.split('Последнее обновление цен: ')[1].split(' в')[0].split('.');
       return date[2]+date[1]+date[0];
         
     }
  
  
jQuery.fn.dataTableExt.oSort["rank-desc"] = function (x, y) {
   x = getRank(x);
y = getRank(y);
return ((x < y) ? 1 : ((x > y) ? -1 : 0));
};
      
jQuery.fn.dataTableExt.oSort["rank-asc"] = function (x, y) {
  x = getRank(x);
y = getRank(y);
return ((x < y) ? -1 : ((x > y) ? 1 : 0))
};
    $('.sortTable').DataTable({
    "aaSorting": [],
    paging: false,
    searching: false,
    info: false,
    columnDefs: [
       { type: 'rank', targets: 3 }
    ]
});
    $('.filtersIcon').on('click', function() {
      $('html,body').animate({scrollTop:0},0);
      if ($('.filters').is(':visible')) {
        $('.filters').hide();
        $('.filters [class^="step-"').hide();
        $('.filters .step-1').show();
        $('body').removeClass('open');
      } else {
        $('.filters').show();
        $('.filters [class^="step-"').hide();
        $('.filters .step-1').show();
        $('body').addClass('open');
      }
    });
    $('.filter-type').on('click', function(e) {
      e.preventDefault();
      $('.filters [class^="step-"').hide();
      $('.filters .step-2').show();
      $('body').addClass('open');
    });
    $('.filter-rubric').on('click', function(e) {
      e.preventDefault();
      $('.filters [class^="step-"').hide();
      $('.filters .step-3').show();
      $('body').addClass('open');
    });
    $('.filter-region').on('click', function(e) {
      e.preventDefault();
      $('.filters [class^="step-"').hide();
      $('.filters .step-4').show();
      $('body').addClass('open');
    });
    $('.filters .back').on('click', function(e) {
      e.preventDefault();
      var step = $(this).attr('step');
      $('.filters [class^="step-"').hide();
      $('.filters .step-' + step).show();
    });
    $('.filters .step-3 .rubric').on('click', function(e) {
      e.preventDefault();
      var group = $(this).attr('group');
      $('.filters [class^="step-"').hide();
      $('.filters .step-3-1 .rubric').removeClass('d-flex').addClass('d-none');
      $('.filters .step-3-1 .rubric.group-' + group).removeClass('d-none').addClass('d-flex');
      $('.filters .step-3-1').show();
    });
    $('.filters .step-3-1 .rubric').on('click', function(e) {
      e.preventDefault();
      var group = $(this).attr('group');
      $('.filter-rubric').attr('rubric', $(this).attr('group')).find('span:first').text($(this).text());
      $('.filters [class^="step-"').hide();
      $('.filters .step-1').show();
    });
    $('.filters .step-4 .region').on('click', function(e) {
      e.preventDefault();
      if ($(this).attr('port') != null) {
        $('.filter-region').attr('port', $(this).attr('port')).find('span:first').text($(this).text());
        $('.filter-region').attr('region', 0);
      } else if ($(this).attr('region') != null) {
        $('.filter-region').attr('region', $(this).attr('region')).find('span:first').text($(this).text());
        $('.filter-region').attr('port', 0);
      }
      $('.filters [class^="step-"').hide();
      $('.filters .step-1').show();
    });
    $('.filters .show').on('click', function(e) {
      e.preventDefault();

      $('.filter-rubric').removeClass('error');
      $('.filters .error-text').hide();


      var type   = $('.filter-type').attr('type');
      var rubric = $('.filter-rubric').attr('rubric');
      var region = $('.filter-region').attr('region');
      var port   = $('.filter-region').attr('port');
      var viewmod = $('.filter-viewmod').find('.btn-radio.active input').val();
      var currency = $('.filter-currency').find('.btn-radio.active input').val();
   
      var rubricUrl = (rubric != 0) ? '/' + rubric : '';
      var regionUrl = (region != 0) ? '/region_' + region  : '';
      var portUrl = (port != 0) ? '/tport_' + port  : '';

      var pageSplit = currentPage.split('/')[1].split('-')[0];

      var url = '/'+ pageSplit + type + regionUrl + portUrl + rubricUrl + '.html';

      if (rubricUrl == '' && regionUrl == '' && portUrl == '') {
        url = location.href;
      }

      if (viewmod != '' && pageSplit != 'traders_analitic') {
        url = app.utils.updateQueryStringParameter(url, 'viewmod', 'tbl');
      }

      if (currency != '') {
        url = app.utils.updateQueryStringParameter(url, 'currency', currency);
      }
      

      if (viewmod == 'tbl' && rubric == 0) {
        $('.filter-rubric').addClass('error');
        $('.filters .error-text').show();
        return false;
      }
      location.href = url;
    });
  };

  app.model['advertFilters'] = function() {
    $('.filtersIcon').on('click', function() {
      $('html,body').animate({scrollTop:0},0);
      if ($('.filters').is(':visible')) {
        $('.filters').hide();
        $('.filters [class^="step-"').hide();
        $('.filters .step-1').show();
        $('body').removeClass('open');
      } else {
        $('.filters').show();
        $('.filters [class^="step-"').hide();
        $('.filters .step-1').show();
        $('body').addClass('open');
      }
    });
    $('.filter-type').on('click', function(e) {
      e.preventDefault();
      $('.filters [class^="step-"').hide();
      $('.filters .step-2').show();
    });
    $('.filter-rubric').on('click', function(e) {
      e.preventDefault();
      $('.filters [class^="step-"').hide();
      $('.filters .step-3').show();
      $('body').addClass('open');
    });
    $('.filter-region').on('click', function(e) {
      e.preventDefault();
      $('.filters [class^="step-"').hide();
      $('.filters .step-4').show();
      $('body').addClass('open');
    });
    $('.filters .back').on('click', function(e) {
      e.preventDefault();
      var step = $(this).attr('step');
      $('.filters [class^="step-"').hide();
      $('.filters .step-' + step).show();
    });
    $('.filters .type').on('click', function(e) {
      e.preventDefault();
      $('.filter-type').attr('type', $(this).attr('type')).find('span:first').text($(this).text());
      $('.filters [class^="step-"').hide();
      $('.filters .step-1').show();
    });
    $('.filters .step-3 .rubric').on('click', function(e) {
      e.preventDefault();
      var group = $(this).attr('group');
      $('.filters [class^="step-"').hide();
      $('.filters .step-3-1 .rubric').removeClass('d-flex').addClass('d-none');
      $('.filters .step-3-1 .rubric.group-' + group).removeClass('d-none').addClass('d-flex');
      $('.filters .step-3-1').show();
    });
    $('.filters .step-3-1 .rubric').on('click', function(e) {
      e.preventDefault();
      var group = $(this).attr('group');
      $('.filters [class^="step-"').hide();
      $('.filters .step-3-2 .rubric:first span:first').text($(this).text()).attr('group', group);
      $('.filters .step-3-2 .rubric:not(:first)').removeClass('d-flex').addClass('d-none');
      $('.filters .step-3-2 .rubric[group="'+group+'"]').removeClass('d-none').addClass('d-flex');
      $('.filters .step-3-2').show();
    });
    $('.filters .step-3-2 .rubric').on('click', function(e) {
      e.preventDefault();
      $('.filter-rubric').attr('rubric', $(this).attr('rubricId')).find('span:first').text($(this).text());
      $('.filters [class^="step-"').hide();
      $('.filters .step-1').show();
    });
    $('.filters .step-4 .region').on('click', function(e) {
      e.preventDefault();
      $('.filter-region').attr('region', $(this).attr('region')).find('span:first').text($(this).text());
      $('.filters [class^="step-"').hide();
      $('.filters .step-1').show();
    });
    $('.showAdverts').on('click', function(e) {
      e.preventDefault();
      var type   = $('.filter-type').attr('type').trim();
      var rubric = $('.filter-rubric').attr('rubric').trim();
      var region = $('.filter-region').attr('region').trim();
      var query  = $('.filter-search').val().trim();
   
      var typeUrl   = (type != 0) ? type : 'all';
      var rubricUrl = (rubric != 0) ? '_t' + rubric : '';
      var regionUrl = (region != 0) ? 'region_' + region + '/' : '';
      var queryUrl  = (query.length > 0) ? '/s/' + query : '';

      var url = queryUrl + '/board/' + regionUrl + typeUrl + rubricUrl + '.html';
      location.href = url;
    });
  };

  app.model['advertRubrics'] = function() {
    $('.getRubricGroup').on('click', function(e) {
      e.preventDefault();

      var group = $(this).attr('group');

      $('.selectRubric').attr('href', '#').hide();
      $('a[class*="group-"], a[class*="subgroup-"], .rubricDrop .dropdown').hide().removeClass('arrow-t');
      $('.group-' + group).show();
      $('.rubricGroup .dropdown').addClass('arrow-t').show();

    });

    $('a[class*="group-"]:not([class*="subgroup-"])').on('click', function(e) {
      e.preventDefault();

      var subgroup = $(this).attr('subgroup');
      var group    = $(this).attr('class').split('group-')[1].split(' ')[0];

      $('.backToRubric').addClass('b2').attr('group', group);

      $('.selectRubric').attr('href', $(this).attr('href')).show();
      $('a[class*="group-"], a[class*="subgroup-"]').hide();
      $('.subgroup-' + subgroup).show();

    });

    $('.backToRubric').on('click', function(e) {
      e.preventDefault();
      if ($(this).hasClass('b2')) {
      var group = $(this).attr('group');
      $('.selectRubric').attr('href', '#').hide();
      $('a[class*="group-"], a[class*="subgroup-"]').hide();
      $('.group-' + group).show();
        $(this).removeClass('b2');
      } else {
        $('.rubricDrop .dropdown').show().addClass('arrow-t');
        $('.rubricGroup .dropdown').hide().removeClass('arrow-t');
      }
    });

  };

  app.model['companies'] = function() {
    $('.searchIcon').on('click', function(e) {
      e.preventDefault();
      const query = $('.searchInput').val();
      if (query.length < 1) {
        $('.searchDiv').addClass('tip');
      } else {
        location.href = '/kompanii/s/' + encodeURI(query);
      }
    });
    $('.searchDiv').parent().on('mouseleave', function (e) {
      e.preventDefault();
      $(this).find('.tip').removeClass('tip');
    });
    $('.filtersIcon').on('click', function() {
      $('html,body').animate({scrollTop:0},0);
      if ($('.filters').is(':visible')) {
        $('.filters').hide();
        $('.filters [class^="step-"').hide();
        $('.filters .step-1').show();
        $('body').removeClass('open');
      } else {
        $('.filters').show();
        $('.filters [class^="step-"').hide();
        $('.filters .step-1').show();
        $('body').addClass('open');
      }
    });
    $('.filter-type').on('click', function(e) {
      e.preventDefault();
      $('.filters [class^="step-"').hide();
      $('.filters .step-2').show();
    });
    $('.filter-rubric').on('click', function(e) {
      e.preventDefault();
      $('.filters [class^="step-"').hide();
      $('.filters .step-3').show();
      $('body').addClass('open');
    });
    $('.filter-region').on('click', function(e) {
      e.preventDefault();
      $('.filters [class^="step-"').hide();
      $('.filters .step-4').show();
      $('body').addClass('open');
    });
    $('.filters .back').on('click', function(e) {
      e.preventDefault();
      var step = $(this).attr('step');
      $('.filters [class^="step-"').hide();
      $('.filters .step-' + step).show();
    });
    $('.filters .type').on('click', function(e) {
      e.preventDefault();
      $('.filter-type').attr('type', $(this).attr('type')).find('span:first').text($(this).text());
      $('.filters [class^="step-"').hide();
      $('.filters .step-1').show();
    });
    $('.filters .step-3 .rubric').on('click', function(e) {
      e.preventDefault();
      var group = $(this).attr('group');
      $('.filters [class^="step-"').hide();
      $('.filters .step-3-1 .rubric').removeClass('d-flex').addClass('d-none');
      $('.filters .step-3-1 .rubric.group-' + group).removeClass('d-none').addClass('d-flex');
      $('.filters .step-3-1').show();
    });
    $('.filters .step-3-1 .rubric').on('click', function(e) {
      e.preventDefault();
      $('.filter-rubric').attr('rubric', $(this).attr('rubricId')).find('span:first').text($(this).text());
      $('.filters [class^="step-"').hide();
      $('.filters .step-1').show();
    });
    $('.filters .step-4 .region').on('click', function(e) {
      e.preventDefault();
      $('.filter-region').attr('region', $(this).attr('region')).find('span:first').text($(this).text());
      $('.filters [class^="step-"').hide();
      $('.filters .step-1').show();
    });
    $('.showCompanies').on('click', function(e) {
      e.preventDefault();
      var rubric = $('.filter-rubric').attr('rubric').trim();
      var region = $('.filter-region').attr('region').trim();
      var query  = $('.filter-search').val().trim();
   
      var rubricUrl = (rubric != 0) ? 't' + rubric : '';
      var regionUrl = (region != 0) ? 'region_' + region + '/' : '';
      var queryUrl  = (query.length > 0) ? 's/' + query + '/' : '';

      var url = '/kompanii/' + queryUrl + regionUrl  + rubricUrl + '.html';
      location.href = url;
    });
  };

  app.model['rubrics'] = function() {
    $('.getRubricGroup').on('click', function(e) {
      e.preventDefault();
      var group = $(this).attr('group');
      $('div[class*="group-"]').hide();
      $('.group-' + group).show();
    });
  };

  app.model['global'] = function() {
    // init tooltip
    $("body").tooltip({
      selector: '[data-toggle="tooltip"]'
    });
    $('[data-toggle="popover"]').popover();
    // mobile menu
    $(".burger").click(function() {
      $(".overlay, .mobileMenu").addClass('open');
      $("body").css('overflow','hidden');
    });
    $(".overlay").click(function() {
      $(".overlay, .mobileMenu").removeClass('open');
      $("body").css('overflow-y','auto');
    });
    // dropdown
    $(document).on('click', function (e) {
      if ($(e.target).closest(".dropdown, .drop-btn, .select-link").length === 0) {
        $(".dropdown").hide().parent().prev().removeClass('arrow-t');
        $(".drop-btn").prop("disabled", false);
      }
    });
    $(".drop-btn").on("click", function(e) {
      e.preventDefault();
      $(".dropdown").hide().parent().prev().removeClass('arrow-t');
      $(".drop-btn").prop("disabled", false);
      $(this).prop("disabled", true).parent().addClass('arrow-t').next().find(".dropdown").show();
    });
    // profile mobile menu 
    $('.userIcon').on('click', function() {
      $('.userMobileMenu').show();
      $('.userMobileMenu .first').show();
      $('div[section]').hide();
      if (!$('.userMobileMenu .back').hasClass('main')) {
        $('.userMobileMenu .back').addClass('main');
      }
      $("body").css('overflow','hidden');
    });
    $('.userMobileMenu .first a').on('click', function(e) {
      e.preventDefault();
      var section = $(this).attr('href');
      $('.userMobileMenu .first').hide();
      $('div[section]').hide();
      $('div[section="'+section+'"]').show();
      if ($('.userMobileMenu .back').hasClass('main')) {
        $('.userMobileMenu .back').removeClass('main');
      }
    });
    $('.userMobileMenu').on('click', '.back', function(e) {
      e.preventDefault();
      if ($(this).hasClass('main')) {
        $('.userMobileMenu').hide();
        $("body").css('overflow-y','auto');
        $(this).removeClass('main');
      } else {
        $(this).addClass('main');
        $('.userMobileMenu .first').show();
        $('div[section]').hide();
      }
    });

    if ($('.userMobileMenu').length) {
       // Get current page URL
       var url = window.location.href;
       // remove # from URL
       url = url.split('.io')[1];
       // Loop all menu items
       $('.userMobileMenu div[section] a').each(function(){
        // select href
        var href = $(this).attr('href');
        // Check filename
        if(url == href){
         // Add active class
          $(this).addClass('active');
        }
       });
    }

  };

  app.model['home'] = function() {
    $('.category-block').each(function() {
      $(this).find('.priceRow:visible:last').css('border', 'none');
      $(this).find('.priceRow:last').css('border', 'none');
    });
    $('.currency a').on('click', function(e) {
      e.preventDefault();
      var currency = $(this).attr('currency');
      $(this).parent().find('a').removeClass('active');
      $(this).addClass('active');
      $(this).parents('.category-block').find('.priceRow').hide();
      $(this).parents('.category-block').find('.priceRow[currency="'+currency+'"]').css('display', 'flex');
    });
  	$('a.production').on('click', function (e) {
  	  e.preventDefault();
  	  $('.dropdown .section').html('<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>');
  	  const group = $(this).attr('group');
  	  app.ajax('/', {
  	  	action: 'getTraders',
  	  	group: group
  	  }, function(res) {
        var html = '';
        $.each(res, function( i, trader ) {
          html += '<a href="/traders/'+trader['url']+'.html" class="flex-fill btn section">'+trader['product']+' (' + trader.count + ')</a>';
        });
        $(".dropdown .section").html(html);
        $('.dropdown').show();
  	  }, true);
    });

    new Swiper('.traders-swipe .swiper-container', {
      // Navigation arrows

      navigation: {
        nextEl: '.traders-swipe .swiper-button-next',
        prevEl: '.traders-swipe .swiper-button-prev',
      },
      // Optional parameters
      slidesPerView: 2,
      centeredSlides: false,
      spaceBetween: 20,
      loop:false,
      simulateTouch: false,
      breakpoints: {
        675: {
          slidesPerView: 1
        }
      }
    });
    new Swiper('.trust-swipe .swiper-container', {
      // Navigation arrows
      navigation: {
        nextEl: '.trust-swipe .swiper-button-next',
        prevEl: '.trust-swipe .swiper-button-prev',
      },
      // Optional parameters
      slidesPerView: 8,
      centeredSlides: false,
      spaceBetween: 20,
      loop:false,
      simulateTouch: false,
      breakpoints: {
        675: {
          slidesPerView: 3
        }
      }
    });
    $('.row.priceRow .col').equalHeights();
  };
  
  app.ajax = function(url, data, callback, cache, f, a) {

    // default params | hello safari :()
    if (f === undefined) f = false;
    if (a === undefined) a = true;
    if (cache === undefined) cache = false;

    // func code
    var obj = {
      url: url,
      type: "POST",
      data: data,
      dataType: "json",
      cache: cache,
      async: a
    };

    if (f == true) {
      obj.processData = false;
      obj.contentType = false;
    }

    $.ajax(obj).done(function (res) {
      if (res.console) console.log(res.console);
      if (callback !== undefined) {
        callback(res);
      }
    });
  };

  this.init = function() {
    app.core.init();
  };
});

agrotender.init();