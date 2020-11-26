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
  $(this).each(function(){
    $(this).height(max_height);
  });
};
$.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)')
                      .exec(window.location.search);

    return (results !== null) ? results[1] || 0 : false;
}

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
  var currentPage = $('body').attr('data-page');
  var mobileDetect = false;

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
      (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) mobileDetect = true;})(navigator.userAgent||navigator.vendor||window.opera);
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
      modules: ['global', 'offer', 'notifications', 'link']
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
      modules: ['advertRubrics', 'advertFilters', 'advertSearch', 'additionalAdv']
    },
    'board/advert': {
      modules: ['advertPhotos', 'complain', 'advertFilters', 'call-btn', 'additionalAdv']
    },
    'main/traders': {
      modules: ['rubrics', 'tradersFilters', 'tradersRubricsCount', 'tradersHover', 'tradersFeed','traders']
    },
    'main/traders_dev': {
      modules: ['rubrics', 'tradersFilters', 'tradersRubricsCount', 'tradersHover', 'tradersFeed','traders_dev']
    },
    'main/traders-new': {
      modules: ['rubrics', 'tradersFilters', 'tradersRubricsCount', 'tradersHover', 'tradersFeed']
    },
    'main/traders-s': {
      modules: ['rubrics', 'tradersFilters', 'tradersRubricsCount', 'tradersHover', 'tradersFeed']
    },
    'main/traders-f': {
      modules: ['rubrics', 'tradersFilters', 'tradersFeed']
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
      modules: ['prices', 'avgPrices', 'changeColPrices']
    },
    'user/pricesForward': {
      modules: ['forwards', 'avgPrices', 'changeColPrices']
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
    'company/forwards': {
      modules: ['prices']
    },
    'company/reviews': {
      modules: ['company-reviews']
    },
    'user/posts': {
      modules: ['user-adverts']
    },
    'user/proposeds': {
      modules: ['proposeds']
    },
    'main/addTrader': {
      modules: ['addTrader']
    },
    'main/reklama': {
      modules: ['reklama']
    }
  };

  app.model['link'] = function() {
    if (mobileDetect || !$('.sidesLink').length) {
      return false;
    }
    var $img = $('.sidesLink img');
    var $link = $img.parent();
    $link.css('display', 'inline-table');
    var imgWidth = $img.width();
    var imgHeight = $img.height();
    $link.css({'height': imgHeight, 'width': imgWidth / 2});
    var $linkClone = $link.clone();
    $linkClone.insertAfter($link);
    $linkClone.css({'background-position': 'right'});
    /* $('.sidesLink:first img').primaryColor({
      callback: function(color) {
        $('main').html('<div style="width: auto;max-width: 1200px;margin: 0 auto;background:#f8f8f8;height:100%; padding-top: 3px;">'+ $('main').html() +'</div>');
        $('main > div > .container:first').css('margin-top', '0px');
        $('body').css('background-color', 'rgb('+color+')');
      }
    }); */
    $('.sidesLink').each(function(i) {
      var $this = $(this);
      var side = 'right';
      $this.show().wrap('<div></div>').parent().css({'position': 'absolute', 'opacity': '0.0', 'height': '100%'});
      html2canvas($this, {
         useCORS: true,
         onrendered: function (canvas) {
          $this.append(canvas);
          if (i == 1) {
            side = 'left';
          }
          $this.css({'height': '0%'}).parent().css({'opacity': '1'});
          var width = 958;
          if ($(window).width() <= 1440) {
            width += 8;
          }
          $(canvas).css(side, 'calc((100vw - 978px) / 1.92 + '+width+'px)');
          $(canvas).css({'position': 'fixed', 'height': '100%', 'top': 0, 'cursor': 'pointer', 'z-index': 1}).on('click', function() {
            $this.click();
          });
        }
      });
    });
  };

  app.model['link2'] = function() {
    if (mobileDetect || !$('.sidesLink').length) {
      return false;
    }
    var $img = $('.sidesLink img');
    var $link = $img.parent();
    $link.css('display', 'inline-table');
    var imgWidth = $img.width();
    var imgHeight = $img.height();
    $link.css({'height': imgHeight, 'width': imgWidth / 2});
    var $linkClone = $link.clone();
    $linkClone.insertAfter($link);
    $linkClone.css({'background-position': 'right'});
    $('.sidesLink:first img').primaryColor({
      callback: function(color) {
        $('main').html('<div style="width: auto;max-width: 1200px;margin: 0 auto;background:#f8f8f8;height:100%; padding-top: 3px;">'+ $('main').html() +'</div>');
        $('main > div > .container:first').css('margin-top', '0px');
        $('body').css('background-color', 'rgb('+color+')');
      }
    });
    $('.sidesLink').each(function(i) {
      var $this = $(this);
      var side = 'right';
      $this.show().wrap('<div></div>').parent().css({'position': 'absolute', 'opacity': '0.0', 'height': '100%'});
      html2canvas($this, {
         onrendered: function (canvas) {
          $this.append(canvas);
          if (i == 1) {
            side = 'left';
          }
          $this.css({'height': '0%'}).parent().css({'opacity': '1'});
          $(canvas).css(side, 'calc((100vw - 978px) / 1.92 + 958px)');
          $(canvas).css({'position': 'fixed', 'height': '100%', 'top': 0, 'cursor': 'pointer', 'z-index': 1}).on('click', function() {
            $this.click();
          });
        }
      });
    });
  };

  app.model['reklama'] = function() {
    $('.reklama-nav .item').on('click', function(e) {
      e.preventDefault();
      $('.reklama-nav .item').removeClass('active');
      $(this).addClass('active');
      $('.stat-block').removeClass('active');
      $('.stat-block[m="'+$(this).attr('month')+'"]').addClass('active');
    });
    $('input[name="phone"]').mask("+38(xxx) xxx xx xx", {
      placeholder: "+38 000 000 00 00",
      translation: {
        0: {pattern: /[0*]/},
        'x': {pattern: /(\d+)/}
      }
    });
    $('.reklama-form').validate({
      rules: {
        name: {
          required: true
        },
        phone: {
          required: true
        },
        email: {
          email: true,
          required: true
        }
      },
      messages: {
        name: {
          required: 'Введите Вашe имя.'
        },
        phone: {
          required: 'Введите номер телефона.'
        },
        email: {
          required: 'Введите email.',
          email: 'Email указан с ошибками.'
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
        var $pack = $('.pack.active');
        var selected = ($pack.length > 0) ? $pack.find('.pack-head').text() + ' - ' + $pack.find('option:selected').text() : null;
        var formData = $(form).serializeArray();
          formData[formData.length] = {name: 'action', value: 'sendR'};
          formData[formData.length] = {name: 'selected', value: selected};
        var phone    = '38' + $('input[name="phone"]').cleanVal();
          formData = app.utils.serializeArrayChange(formData, 'phone', phone);
        app.ajax('/', formData, function(data) {
          if (data.code == 1) {
            $('.reklama-form')[0].reset();
            new Noty({
              type: 'success',
              text: data.text
            }).show();
          } else {
            new Noty({
              type: 'error',
              text: data.text
            }).show();
          }
          return false;
        });
      }
    });
    $('.select-pack').on('click', function(e) {
      e.preventDefault();
      $('.pack').removeClass('active');
      $(this).parents('.pack').addClass('active');
      $('.reklama-form').addClass('active');
      $('html,body').animate({
        scrollTop: $('.send-text').offset().top
      });
    });
    $('.reklama-send').on('click', function(e) {
      e.preventDefault();
      $('html,body').animate({
        scrollTop: $('.send-text').offset().top
      });
    });
    $('.pack-select').on('change', function(e) {
      var amount = $(this).parent().find('option:selected').attr('amount');
      var one = $(this).parent().find('option:selected').attr('one');
      $(this).parents('.pack').find('.onemonth-pack').html(one + "<br>грн/мес");
      $(this).parents('.pack').find('.amount-pack').html(amount + " <sup>грн</sup>");
    });
    var swiper = new Swiper('.swiper-container.pack-swiper', {
      // Optional parameters
      slidesPerView: 3,
      centeredSlides: false,
      spaceBetween: 20,
      loop:false,
      breakpoints: {
        675: {
          slidesPerView: 1
        }
      }
    });
    $('.select-pack').on('click', function(e) {
      e.preventDefault();
      $('.pack').removeClass('active');
      $(this).parents('.pack').addClass('active');
    });

  };

  app.model['changeColPrices'] = function() {
    $('.changeColPrices').each(function() {
      var $td = $(this).closest('th');
      var $table = $td.closest('table');
      var rubricId = $td.attr('rubric');
      var place_type = $td.attr('place_type');
      var table_type = $table.attr('table-type');
      var currency = $table.attr('currency');
      var date = $table.attr('date') || '';
      var step = currency > 0 ? 1 : 10;
      $(this).popover({
        container: 'body',
        title: 'Изменить цену во всем столбце на',
        html: true,
        placement: 'right',
        sanitize: false,
        content: function () {
          return '<div class="row mx-0 px-1 align-items-center prices-popover"> <div class="col-12 px-1 d-flex align-items-center"> <div class="d-flex position-relative align-items-center"><a class="upNum btn btn-primary px-2 py-2 mr-2" href="#"><i class="fas fa-chevron-up"></i></a><input type="number" class="form-control" placeholder="0" value="" step="'+step+'"><a class="downNum btn btn-primary px-2 py-2 ml-2" href="#"><i class="fas fa-chevron-down"></i></a></div> <button rubric="'+rubricId+'" place_type="'+place_type+'" table_type="'+table_type+'" currency="'+currency+'" date="'+date+'" class="btn prices-btn saveColPrices ml-2"> ОК </button> </div> </div>';
        }
      });
    });
    $('.changeColPrices').on('click', function() {
      var $table = $(this).closest('table');
      var table_type = $table.attr('table-type');
      var currency = $table.attr('currency');
      var date = $table.attr('date') || '';
      $('input[type="number"]:visible').attr('step', currency > 0 ? 1 : 10);
      $('.saveColPrices:visible').attr({ currency: currency, date: date });
    });
    $(document).on('click', '.prices-popover [class*="Num"]', function(e) {
      e.preventDefault();
      var $input = $(this).parent().find('input');
      var value = ($input.val() == '') ? 0 : $input.val();
      var step = $(this).attr('class').split('Num')[0];
      $input.val((step == 'up') ? parseInt(value) + parseInt($input.attr('step')) : parseInt(value) - parseInt($input.attr('step')));
    });
    $(document).on('click', '.saveColPrices', function(e) {
      e.preventDefault();
      var $input     = $(this).prev().find('input');
      var rubric     = $(this).attr('rubric');
      var table_type = $(this).attr('table_type');
      var place_type = $(this).attr('place_type');
      var currency   = $(this).attr('currency');
      var date       = $(this).attr('date');
      var acttype    = $('.submenu').attr('acttype');
      var price      = $input.val();
      if (price == 0) {
        $('[data-original-title]').popover('hide');
        return false;
      }
      app.ajax(location.href, {action: 'saveColPrices', rubric: rubric, place_type: place_type, currency: currency, acttype: acttype, price: price, date: date}, function(data) {
        $('[data-original-title]').popover('hide');
        location.reload();
      });
    });
    $(document).on('click', function (e) {
      $('[data-toggle="popover"],[data-original-title]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false
        }

      });
    });
  };

  app.model['avgPrices'] = function() {
    $('.price-cost').on('focus', function(e) {
      e.preventDefault();
      if ($(this).attr('data-toggle')) {
        //$(this).tooltip('show');
      } else {
        var $this    = $(this);
        var $td      = $(this).parent();
        var region   = $td.attr('region');
        var rubric   = $td.attr('rubric');
        var currency = $td.attr('currency');
        var date     = $td.attr('date') || '';
        app.ajax(location.href, {action: 'getAvgPrices', region: region, rubric: rubric, currency: currency, date: date}, function(data) {
          if (data.code == 1 && data.minPrice != null) {
            $this.attr({'data-toggle': 'tooltip', 'data-html': 'true', 'data-placement': 'right', 'title': 'Мин.: '+data.minPrice+'<br>Макс.: '+data.maxPrice+''}).tooltip('show');
          }
        });
      }
    });
    $('.price-cost').on('blur', function(e) {
      e.preventDefault();
      $('.price-cost').tooltip('hide');
    });
  };

  app.model['tradersFeed'] = function() {
    var swiper = new Swiper('.swiper-container', {
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      // Optional parameters
      slidesPerView: 4,
      centeredSlides: false,
      spaceBetween: 20,
      loop:false,
      breakpoints: {
        675: {
          slidesPerView: 1
        }
      }
    });
  };

  app.model['tradersHover'] = function() {
  	$('.newTraderItem .logo').primaryColor({
      callback: function(color) {
        $(this).parents('.wrap-logo').css('background-color', 'rgb('+color+')');
      }
    });
  	$('.traders__item__image').primaryColor({
      callback: function(color) {
        $(this).parents('.filled').css('background-color', 'rgb('+color+')');
      }
    });
  	if (mobileDetect == false) {
      $('.newTraderItem').hover(function() {
        $(this).addClass('hovered').find('.prices').show();
      }, function() {
        $(this).removeClass('hovered').find('.prices').hide();
      });
  	}
  };

  app.model['tradersRubricsCount'] = function() {
    $('.getRubricGroup').on('click', function() {
      var group = $(this).attr('group');
      var arr = [];
      $('.rubricGroup[class$="group-'+group+'"] > a:visible').each(function() {
        var id = $(this).attr('rid');
        arr[arr.length] = id;
      });
      app.ajax(location.href, {action: 'getTradersCount', rubrics: arr}, function(data) {
        for (var x in data.rubrics) {
          $('a[rid="'+data.rubrics[x].id+'"] span').text($('a[rid="'+data.rubrics[x].id+'"] span').text().split(' (')[0] + ' ('+data.rubrics[x].count+')');
        }
      });
    });
  }

  app.model['additionalAdv'] = function() {
    $('.postItem .title span.a').ellipsis({
      type: 'lines',
      count: 1
    });
    $('.postItem .title a').ellipsis({
      type: 'lines',
      count: 1
    });
    $('.rcount').on('click', function() {
      var arr = [];
      $('.rsection > a:visible').each(function() {
        var id = $(this).attr('rid');
        if ($(this).hasClass('rparent')) {
          id += '.p1';
        }
        arr[arr.length] = id;
      });
      app.ajax(location.href, {action: 'getRCount', rubrics: arr}, function(data) {
        for (var x in data.rubrics) {
          $('a[rid="'+data.rubrics[x].id+'"] .rtitle').text($('a[rid="'+data.rubrics[x].id+'"] .rtitle').text().split(' (')[0] + ' ('+data.rubrics[x].count+')');
        }
      });
    });
  }

  app.model['call-btn'] = function() {
    $('.call-btn').on('click', function() {
      $('.overlay, .post-contacts').show();
    });
    $('.overlay').on('click', function() {
      $('.overlay, .post-contacts').hide();
    });
  };

  app.model['addTrader'] = function() {
    var swiper = new Swiper('.swiper-container', {
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      }
    });
    $('input[name="phone"]').mask("+38(xxx) xxx xx xx", {
      placeholder: "+38 000 000 00 00",
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
            $(form)[0].reset();
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
    if ($('.contact').length > 3) {
      $('.trader-contact:visible:last').append('<div class="text-center mt-4"> <a class="btn btn-block showAll add-contact px-5" href="#">Показать все</a> </div>');
    }
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
    $('.review-comment').on('click', function(e) {
      e.preventDefault();
      $(this).parents('.review').find('.comment-row').slideToggle();
    });
    $('.save-review-comment').on('click', function(e) {
      e.preventDefault();
      var text = $(this).prev().val();
      var review = $(this).parents('.comment-row').attr('review-id');
      app.ajax(location.href, {action: 'reviewComment', text: text, review: review}, function(data) {
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
          html += '<div class="col-6 py-2"><a href="/kompanii/comp-'+data.companies[x].company_id+'" target="_blank"><b>'+data.companies[x].company+'</b></a> - '+data.companies[x].status+'</div>'
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
      var phone = '38' +  $('.newPhone').cleanVal();
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
          location.href = '/u/posts';
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
      app.ajax('/u/posts/upgrade', {action: 'upgradeAdv', advId: advId, packs: [13]}, function(data) {
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
        var logoh =  $('.logo').height();
        var logow = $('.logo').width();
        if(logoh > 200 || logoh > 200){
                     new Noty({
          type: 'warning',
          text: 'Загружать можно изображения 200px / 200 px'
        }).show();
        return false;
        }
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
      $('input[name="phone"]').mask("+38(xxx) xxx xx xx", {
      placeholder: "+38 000 000 00 00",
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
        app.ajax('/traders', {action: 'getTraders', rubric: rubric, region: region}, function(data) {
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
        app.ajax('/traders', {action: 'getTraders', rubric: rubric, region: region}, function(data) {
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
        var phone    = '38' +  $offer.find('input[name="phone"]').cleanVal();
            formData = app.utils.serializeArrayChange(formData, 'phone', phone);
        // send data to server
        app.ajax('/traders', formData, function(data) {
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
       if(file.size > 2500){
           new Noty({
          type: 'warning',
          text: 'Загружать можно изображения не больше 20кб'
        }).show();
        return false;
      }
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
              text: data.text
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
    $('input[name^="phone"], .newPhone').mask("+38(xxx) xxx xx xx", {
      placeholder: "+38 000 000 00 00",
      translation: {
        0: {pattern: /[0*]/},
        'x': {pattern: /(\d+)/}
      }
    });
    $('.save').on('click', function(e) {
      e.preventDefault();
      $('.main-dep').submit();
    });
    $('.save-im').on('click', function(e) {
      e.preventDefault();
      $('.im-dep').submit();
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
        if ($('.main-dep input[name="phone2"]').cleanVal().length != 0) {
          var phone2   = '38' +  $('.main-dep input[name="phone2"]').cleanVal();
              formData = app.utils.serializeArrayChange(formData, 'phone2', phone2);
        }
        if ($('.main-dep input[name="phone3"]').cleanVal().length != 0) {
          var phone3   = '38' +  $('.main-dep input[name="phone3"]').cleanVal();
              formData = app.utils.serializeArrayChange(formData, 'phone3', phone3);
        }
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
    // im
    $('.im-dep').validate({
      rules: {
      },
      messages: {
      },
      errorElement: 'span',
      submitHandler: function(form) {
        $(form).find('button[type="submit"]').prop('disabled', true);
        var formData = $(form).serializeArray();
            formData[formData.length] = {name: 'action', value: 'im-dep'};
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
        name: {
          required: true
        },
        phone: {
          required: true
        },
        email: {
          email: true
        }
      },
      messages: {
        name: {
          required: 'Укажите контактное лицо.'
        },
        phone: {
          required: 'Введите номер телефона.'
        },
        email: {
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
        if ($('.contact-form input[name="phone"]').cleanVal().length != 0) {
          var phone    = '38' +  $('.contact-form input[name="phone"]').cleanVal();
            formData = app.utils.serializeArrayChange(formData, 'phone', phone);
        }
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
      app.ajax('/u/posts/limits', {action: 'upLimits', packs: packs}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else if (data.code == 1) {
          location.href = '/u/posts/limits'
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
    $('input[name="phone"]').mask("+38(xxx) xxx xx xx", {
      placeholder: "+38 000 000 00 00",
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
          name: {
            required: true
          },
          phone: {
            required: true
          },
          email: {
            email: true
          }
        },
        messages: {
          name: {
            required: 'Укажите контактное лицо.'
          },
          phone: {
            required: 'Введите номер телефона.'
          },
          email: {
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
          var phone    = '38' +  $('.contact-form input[name="phone"]').cleanVal();
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
    // $('.price-table tr').each(function(){
    //   $(this).find('.currency-0').eq(0).css('box-shadow', 'inset 18px -1px 18px -18px rgba(167, 167, 167, 0.62)');
    // });
    // $('.price-table tr').each(function(){
    //   $(this).find('.currency-1').eq(0).css('box-shadow', 'inset 18px -1px 18px -18px rgba(167, 167, 167, 0.62)');
    // });
    $('.table-tabs a').on('click', function(e) {
      e.preventDefault();
      var $table = $(this).parent().next();
      var currency = $(this).attr('currency');
      $(this).parent().find('a').removeClass('active');
      $(this).addClass('active');
      $table.find('td[class^="currency-"]').hide();
      $table.find('td.currency-'+currency).css('display', 'table-cell');
      $table.attr('currency', currency);
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
          new Noty({
            type: 'success',
            text: 'Цены сохранены.'
          }).show();
          return false;
        }
      });
    });
  };

  app.model['forwards'] = function() {
    $('.table-tabs a').on('click', function(e) {
      e.preventDefault();
      var $table = $(this).parent().next();
      var date   = $(this).attr('date');
      $(this).addClass('active').siblings().removeClass('active');
      $table.find('.price-cell').each(function(i, el) {
        $(el).toggle($(el).attr('date') == date);
      });
      $table.attr('date', date);
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
      var $cell = $(this).closest('td');
      var place = $cell.attr('place');
      var comment = $cell.find('.place-comment').text();
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
      $('.price-table').find('.price-cell').each(function() {
        var place = $(this).attr('place');
        var rubric = $(this).attr('rubric');
        var currency = $(this).attr('currency');
        var date = $(this).attr('date');
        var cost = parseInt($(this).find('.price-cost').val());
        var comment = $(this).find('.price-comment').val();
        cost = isNaN(cost) ? null : cost;
        // fixme отправлять только заполненные поля
        prices[prices.length] = {
          place: place,
          rubric: rubric,
          currency: currency,
          date: date,
          cost: cost,
          comment: comment
        };
      });
      app.ajax(location.href, {action: 'savePrices', prices: prices}, function(data) {
        if (data.code == 1) {
          new Noty({
            type: 'success',
            text: 'Цены сохранены.'
          }).show();
          return false;
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
    $('#phone').mask("+38(xxx) xxx xx xx", {
      placeholder: "+38 000 000 00 00",
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
        if ($(this).hasClass('pack-1') || $(this).hasClass('pack-3')) {
          packs[packs.length] = $(this).find('select').val();
        } else {
          packs[packs.length] = $(this).attr('pack-id');
        }
      });
      app.ajax('/u/posts/upgrade', {action: 'upgradeAdv', advId: advId, packs: packs}, function(data) {
        if (data.code == 0) {
                new Noty({
                  type: 'error',
                  text: data.text
                }).show();
                return false;
              } else if (data.code == 1) {
          location.href = '/u/posts/upgrade';
        } else if (data.code == 2) {
          location.href = '/u/balance/pay?payAdv='+data.payAdv+'&payPacks='+data.payPacks+'&payAmount='+data.payAmount+'';
        }
      });
    });
  };

  app.model['advertForm-utils'] = function() {
    $('#title').keyup(function () {
      var max = 60;
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
    $('input.newPhone').mask("+38(xxx) xxx xx xx", {
      placeholder: "+38 000 000 00 00",
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
            location.href = '/u/posts';
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
    $('input.phone').mask("+38(xxx) xxx xx xx", {
      placeholder: "+38 000 000 00 00",
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
                return $('input.phone').cleanVal();
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
                        '<a href="/elev/'+elev.url+'" class="row d-flex content-block p-2'+right+'">'+
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
    $(".select-link").on("click", function(e) {
      e.preventDefault();
      if ($(".dropdown").is(':visible')) {
        $(".dropdown").hide();
      } else {
        $(".dropdown").show();
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

  app.model['traders'] = function() {
	var start = 36;
    var inProgress = false;
    $(window).on('scroll', function() {
      if ($(window).scrollTop() + $(window).height() > ($('.traders').height() - 200) && !inProgress) {
        inProgress = true;
        app.ajax(location.href, {action: 'getTradersMore', start: start}, function(data) {
          if (data.more == false) return false;
          var html = '';
          $.each(data.traders, function(index, group) {
            html += '<div class="row mb-0 mb-sm-4 pb-sm-2">';
            $.each(group, function(i, trader) {
              var _top    = (trader.top==1)?' top':'';
			  var q = new Date();
				var m = q.getMonth();
				var d = q.getDate();
				var y = q.getFullYear();

				var date = new Date(y,m,d);
				mydate=new Date(trader.date);
				mydate.setHours(0,0,0,0);
			  var date_for_p = trader.date2;
			  if (date.valueOf()==mydate.valueOf()) {date_for_p ='<span class="today">сегодня</span>';};

              html += '<div class="col-6 col-sm-2 px-3 position-relative">'+
      '<div class="row newTraderItem mx-0'+(_top)+'">'+
        '<div class="col-12 d-flex px-0 justify-content-center wrap-logo">'+
          '<a href="/kompanii/comp-'+(trader.id)+'">'+
            '<img class="logo" src="/'+(trader.logo)+'">'+
          '</a>'+
        '</div>'+
        '<div class="col-12 px-0 date d-flex justify-content-center align-items-center">'+
         '<span class="lh-1">'+date_for_p+'</span>'+
        '</div>'+
        '<div class="col-12 px-0 d-flex justify-content-center align-items-center px-2 py-2 title text-center">'+
          '<a href="/kompanii/comp-'+(trader.id)+'">'+(trader.title)+'</a>'+
        '</div>'+
        '<div class="col-12 prices px-2">';
		 $.each(trader.prices, function(i, price) {
          html += '<div class="d-flex justify-content-between align-items-center ar">'+
            '<span class="rubric">'+(price.title)+'</span>'+
            '<div class="d-flex align-items-center lh-1 priceItem">'+
              '<span class="amount text-right ';
			  if (price.change_price=='') {
				  html += 'price-'+(price.change_price);
				  html += '" data-toggle="tooltip" data-placement="right" title="Старая цена:';
				  if (price.currency == 1) html += '$';
				  html+=(price.old_price)+'">';
			  }
			  else html += '">';

			  if (price.currency == 1) html += '$';
			  html+=(price.price);
			  html+='</span>';
			  
              if (price.change_price!='') html += '<img src="/app/assets/img/price-'+(price.change_price)+'.svg">';
              if (price.change_price == '') html += '<img src="/app/assets/img/price-not-changed.svg">';
            html += '</div>'+
          '</div>';
          });
		  
        html += '</div>'+
        '<div class="col-12 px-0 d-flex justify-content-between align-items-center px-2 pb-2 rating text-center">'+
          '<a class="stars" href="/kompanii/comp-'+(trader.id)+'-reviews">';
            for(i=1;i<5;i++){
				if (i <= trader.review.rating){
				html += '<i class="fas fa-star"></i>';
				}else{
				html += '<i class="far fa-star"></i>';
				}
            }
          html += '</a>'+
          '<a href="/kompanii/comp-'+(trader.id)+'-reviews"><span>'+(trader.review.count)+'</span></a>'+
        '</div>'+
      '</div>'+
   ' </div>';
            });
            html += '</div>';
          });
          $('.traders').append(html);
          start += 18;
          inProgress = false;
		  $('.newTraderItem .logo').primaryColor({
			  callback: function(color) {
				$(this).parents('.wrap-logo').css('background-color', 'rgb('+color+')');
			  }
			});
			if (mobileDetect == false) {
			  $('.newTraderItem').hover(function() {
				$(this).addClass('hovered').find('.prices').show();
			  }, function() {
				$(this).removeClass('hovered').find('.prices').hide();
			  });
			}
        });
      }
    });
  $('.elev').appe    
  };

/*
      <div class="traders__item-wrap">
        
        <a href="/kompanii/comp-{$trader['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}" class="traders__item {if $trader['top'] eq '1'} yellow{/if}">
          <div class="traders__item__header">
            <img class="traders__item__image" src="/{$trader['logo']}" alt="">
          </div>
          <div class="traders__item__content">
            <div href="#" class="traders__item__content-title">
              {$trader['title']}
            </div>
            <div class="traders__item__content-description">
               {foreach from=$trader['prices'] item=price}
              <p class="traders__item__content-p">
                <span class="traders__item__content-p-title">{$price['title']|unescape|truncate:18:"..":true}</span>
                <span class="right">
                  <span class="traders__item__content-p-price">{if $price['currency'] eq 1}${/if}{$price['price']}</span>
                  <span class="traders__item__content-p-icon"></span>
                </span>
              </p>
                {/foreach}
            </div>
            <div class="traders__item__content-date">
              <span class="traders__item__content-date-more">+ ещё {$trader['review']['count']}</span>
              <span class="green">{if $smarty.now|date_format:"%Y-%m-%d" eq $trader['date']}сегодня{else}{$trader['date2']}{/if}</span>
            </div>
          </div>
        </a>
      </div>

*/
  app.model['traders_dev'] = function() {
    var start = 36;
    var inProgress = false;


    $(window).on('scroll', function() {
      if ($(window).scrollTop() + $(window).height() > ($('.traders_dev').height() - 200) && !inProgress) {
        inProgress = true;
        app.ajax(location.href, {action: 'getTradersMore', start: start}, function(data) {
          if (data.more == false) return false;
          var html = '';
          $.each(data.traders, function(index, group) {
            html += '<div class="new_traders ">';
            $.each(group, function(i, trader) {
              var _top    = (trader.top==1)?' yellow':'';
        var q = new Date();
        var m = q.getMonth();
        var d = q.getDate();
        var y = q.getFullYear();

        var date = new Date(y,m,d);
        mydate=new Date(trader.date);
        mydate.setHours(0,0,0,0);
        var date_for_p = trader.date2;
        if (date.valueOf()==mydate.valueOf()) {date_for_p = '<span class="green">сегодня</span>'}
          else if(mydate.getDate() == date.getDate() - 1){date_for_p = '<span style="color: #FF7404;">вчера</span>'}
          else{date_for_p = `<span style="color:#001430;">${trader.date2}</span>`};
        //
        html += ` <div class="traders__item-wrap">
        <a href="/kompanii/comp-${trader.id}" class="traders__item ${_top}">
                    <div class="traders__item__header">
            <img class="traders__item__image" src="/${trader.logo}" alt="">
          </div>
          <div class="traders__item__content">
            <div href="#" class="traders__item__content-title title">
              ${trader.title.replace(/(.{25})..+/, "$1…")}            
              </div>
              <div class="traders__item__content-description">
        `;

     $.each(trader.prices, function(i, price) {
        html += ` <p class="traders__item__content-p">
                <span class="traders__item__content-p-title">${price.title.replace(/(.{14})..+/, "$1…")}</span>
                <span class="right">`;
                html += `<span class="traders__item__content-p-price"`;
                        if (price.change_price != '') {
          html += 'price-'+(price.change_price);
          html += '" data-toggle="tooltip" data-placement="right" title="Старая цена:';
          if (price.currency == 1) html += "$ &nbsp;";
          html+=(price.old_price)+'">';
        }
        else html += '>';
                if (price.currency == 1){
                  html +='$&nbsp;';
              }
              html += `${price.price}</span>`;
              html+= `<span class="traders__item__content-p-icon">`
               if (price.change_price!='') html += '<img src="/app/assets/img/price-'+(price.change_price)+'.svg">';
              if (price.change_price == '') html += '<img src="/app/assets/img/price-not-changed.svg">';
                 html += ` </span>`;
               html+= `</span>
              </p>
            `;
          });

     html += '</div>';
     html += `<div class="traders__item__content-date">
              <span class="traders__item__content-date-more">+ ещё </span>
              ${date_for_p}
            </div>
          </div></a></div>`;
            });
            html += `</div>`;
          });
          $('.traders_dev').append(html);
          start += 18;
          inProgress = false;

        });
        $('.traders__item.yellow .traders__item__image').primaryColor({
          callback: function(color) {
          $(this).parents('.traders__item__header').css('background-color', 'rgb('+color+')');
          }
        });
      }
    });

  };

  app.model['tradersFilters'] = function() {
    function getRank(name) {
      if (name.search('data-date')) {
        var date = name.split('data-date="')[1].split('"')[0];
        return date;
      } else {
        return null;
      }
    }

    jQuery.fn.dataTableExt.oSort["bDate-desc"] = function (x, y) {
      $('.sort-date-icon').attr('class', 'sort-date-icon fas fa-sort-down');
      x = getRank(x);
      y = getRank(y);
      return ((x < y) ? 1 : ((x > y) ? -1 : 0));
    };

    jQuery.fn.dataTableExt.oSort["bDate-asc"] = function (x, y) {
      $('.sort-date-icon').attr('class', 'sort-date-icon fas fa-sort-up');
      x = getRank(x);
      y = getRank(y);
      return ((x < y) ? -1 : ((x > y) ? 1 : 0));

    };

    jQuery.fn.dataTableExt.oSort["price-pre"] = function (str1) {
        var x = String(str1).replace( /<[\s\S]*?>/g, "" );
        return (isNaN(parseFloat(x))) ? "" : parseFloat(x);
    };

    jQuery.fn.dataTableExt.oSort["price-desc"] = function (str1, str2) {
        if(str1 == "")
            return 1;
        if(str2 == "")
            return -1;
        return ((str1 < str2) ? 1 : ((str1 > str2) ? -1 : 0));
    };

    jQuery.fn.dataTableExt.oSort["price-asc"] = function (str1, str2) {
      if(str1 == "")
            return 1;
        if(str2 == "")
            return -1;
        return ((str1 < str2) ? -1 : ((str1 > str2) ? 1 : 0));
    };


    if ($('.dTable').length) {
      if ($('.sortTable thead th').length == 5) {
        var tar = [1, 2];
      } else {
        var tar = 1;
      }
      $('.sortTable').DataTable({
        "aaSorting": [],
        paging: false,
        searching: false,
        info: false,
        columnDefs: [
          { orderSequence: [ "desc", 'asc' ], type: 'bDate', targets: 3 },
          { orderSequence: [ 'desc', 'asc' ], type: 'price', targets: tar }
        ],
        createdRow: function(row, data, dataIndex){
          // If name is "Ashton Cox"
          if($(row).attr('cspan') == '1'){
            // Add COLSPAN attribute
            $('td:eq(0)', row).attr('colspan', 5);

            // Hide required number of columns
            // next to the cell with COLSPAN attribute
            $('td:eq(1)', row).css('display', 'none');
            $('td:eq(2)', row).css('display', 'none');
            $('td:eq(3)', row).css('display', 'none');
            $('td:eq(4)', row).css('display', 'none');

            // Update cell data
            this.api().cell($('td:eq(1)', row)).data('<div class="d-flex align-items-center justify-content-center"> <span class="price">0</span> </div>');
          }
        }
      });
      $('.sth').on('click', function() {
        $('.sth i').attr('class', 'fas fa-sort');
        if ($(this).hasClass('sorting_asc')) {
          $(this).find('i').attr('class', 'fas fa-sort-up');
        }
        if ($(this).hasClass('sorting_desc')) {
          $(this).find('i').attr('class', 'fas fa-sort-down');
        }
        $('.t-sub').insertAfter($('tbody tr:eq(3)'));
      });
    }
    $('.filtersIcon').on('click', function() {
      $('html,body').animate({scrollTop:0},0);
      if ($('.filters-wrap').is(':visible')) {
        $('.filters-wrap').hide();
        $('.filters .stp').hide();
        $('.filters .step-1').show();
        $('body').removeClass('open');
      } else {
        $('.filters-wrap').show();
        $('.filters .stp').hide();
        $('.filters .step-1').show();
        $('body').addClass('open');
      }
    });
    $('.filter-type').on('click', function(e) {
      e.preventDefault();
      $('.filters .stp').hide();
      $('.filters .step-2').show();
      $('body').addClass('open');
    });
    $('.filter-rubric').on('click', function(e) {
      e.preventDefault();
      $('.filters .stp').hide();
      $('.filters .step-3').show();
      $('body').addClass('open');
    });
    $('.filter-region').on('click', function(e) {
      e.preventDefault();
      $('.filters .stp').hide();
      $('.filters .step-4').show();
      $('body').addClass('open');
    });
    $('.filters .back').on('click', function(e) {
      e.preventDefault();
      var step = $(this).attr('step');
      $('.filters .stp').hide();
      $('.filters .step-' + step).show();
    });
    $('.filters .step-3 .rubric').on('click', function(e) {
      e.preventDefault();
      var group = $(this).attr('group');
      $('.filters .stp').hide();
      $('.filters .step-3-1 .rubric').removeClass('d-flex').addClass('d-none');
      $('.filters .step-3-1 .rubric.group-' + group).removeClass('d-none').addClass('d-flex');
      $('.filters .step-3-1').show();
    });
    $('.filters .step-3-1 .rubric').on('click', function(e) {
      e.preventDefault();
      var group = $(this).attr('group');
      $('.filter-rubric').attr('rubric', $(this).attr('group')).find('span:first').text($(this).text());
      $('.filters .stp').hide();
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
      $('.filters .stp').hide();
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

      var url = '/'+ pageSplit + type + regionUrl + portUrl + rubricUrl + '';

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
      if ($('.filters-wrap').is(':visible')) {
        $('.filters-wrap').hide();
        $('.filters .stp').hide();
        $('.filters .step-1').show();
        $('.wrap').css('overflow-y', 'auto').removeClass('open');
      } else {
        $('.filters-wrap').show();
        $('.filters .stp').hide();
        $('.filters .step-1').show();
        $('.wrap').css('overflow', 'hidden').addClass('open');
      }
    });
    $('.filter-type').on('click', function(e) {
      e.preventDefault();
      $('.filters .stp').hide();
      $('.filters .step-2').show();
    });
    $('.filter-rubric').on('click', function(e) {
      e.preventDefault();
      $('.filters .stp').hide();
      $('.filters .step-3').show();
      $('body').addClass('open');
    });
    $('.filter-region').on('click', function(e) {
      e.preventDefault();
      $('.filters .stp').hide();
      $('.filters .step-4').show();
      $('body').addClass('open');
    });
    $('.filters .back').on('click', function(e) {
      e.preventDefault();
      var step = $(this).attr('step');
      $('.filters .stp').hide();
      $('.filters .step-' + step).show();
    });
    $('.filters .type').on('click', function(e) {
      e.preventDefault();
      $('.filter-type').attr('type', $(this).attr('type')).find('span:first').text($(this).text());
      $('.filters .stp').hide();
      $('.filters .step-1').show();
    });
    $('.filters .step-3 .rubric').on('click', function(e) {
      e.preventDefault();
      var group = $(this).attr('group');
      $('.filters .stp').hide();
      $('.filters .step-3-1 .rubric').removeClass('d-flex').addClass('d-none');
      $('.filters .step-3-1 .rubric.group-' + group).removeClass('d-none').addClass('d-flex');
      $('.filters .step-3-1').show();
    });
    $('.filters .step-3-1 .rubric').on('click', function(e) {
      e.preventDefault();
      var group = $(this).attr('group');
      $('.filters .stp').hide();
      $('.filters .step-3-2 .rubric:first span:first').text($(this).text()).parent().attr('rubricid', group);
      $('.filters .step-3-2 .rubric:not(:first)').removeClass('d-flex').addClass('d-none');
      $('.filters .step-3-2 .rubric[group="'+group+'"]').removeClass('d-none').addClass('d-flex');
      $('.filters .step-3-2').show();
    });
    $('.filters .step-3-2 .rubric').on('click', function(e) {
      e.preventDefault();
      $('.filter-rubric').attr('rubric', $(this).attr('rubricId')).find('span:first').text($(this).text());
      $('.filters .stp').hide();
      $('.filters .step-1').show();
    });
    $('.filters .step-4 .region').on('click', function(e) {
      e.preventDefault();
      $('.filter-region').attr('region', $(this).attr('region')).find('span:first').text($(this).text());
      $('.filters .stp').hide();
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

      var url = queryUrl + '/board/' + regionUrl + typeUrl + rubricUrl + '';
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
      $('.rubricGroup').show();
      $('.rubricGroup .dropdown').show();

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
      $('.searchForm').submit();
    });
    $('.searchForm').on('submit', function(e) {
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
      if ($('.filters-wrap').is(':visible')) {
        $('.filters-wrap').hide();
        $('.filters .stp').hide();
        $('.filters .step-1').show();
        $('body').removeClass('open');
        $('.top .filtersIcon, .top .burger').removeClass('z-index-1060');
      } else {
        $('.filters-wrap').show();
        $('.filters .stp').hide();
        $('.filters .step-1').show();
        $('body').addClass('open');
        $('.top .filtersIcon, .top .burger').addClass('z-index-1060');
      }
    });
    $('.filter-type').on('click', function(e) {
      e.preventDefault();
      $('.filters .stp').hide();
      $('.filters .step-2').show();
    });
    $('.filter-rubric').on('click', function(e) {
      e.preventDefault();
      $('.filters .stp').hide();
      $('.filters .step-3').show();
      $('body').addClass('open');
    });
    $('.filter-region').on('click', function(e) {
      e.preventDefault();
      $('.filters .stp').hide();
      $('.filters .step-4').show();
      $('body').addClass('open');
    });
    $('.filters .back').on('click', function(e) {
      e.preventDefault();
      var step = $(this).attr('step');
      $('.filters .stp').hide();
      $('.filters .step-' + step).show();
    });
    $('.filters .type').on('click', function(e) {
      e.preventDefault();
      $('.filter-type').attr('type', $(this).attr('type')).find('span:first').text($(this).text());
      $('.filters .stp').hide();
      $('.filters .step-1').show();
    });
    $('.filters .step-3 .rubric').on('click', function(e) {
      e.preventDefault();
      var group = $(this).attr('group');
      $('.filters .stp').hide();
      $('.filters .step-3-1 .rubric').removeClass('d-flex').addClass('d-none');
      $('.filters .step-3-1 .rubric.group-' + group).removeClass('d-none').addClass('d-flex');
      $('.filters .step-3-1').show();
    });
    $('.filters .step-3-1 .rubric').on('click', function(e) {
      e.preventDefault();
      $('.filter-rubric').attr('rubric', $(this).attr('rubricId')).find('span:first').text($(this).text());
      $('.filters .stp').hide();
      $('.filters .step-1').show();
    });
    $('.filters .step-4 .region').on('click', function(e) {
      e.preventDefault();
      $('.filter-region').attr('region', $(this).attr('region')).find('span:first').text($(this).text());
      $('.filters .stp').hide();
      $('.filters .step-1').show();
    });
    $('.showCompanies').on('click', function(e) {
      e.preventDefault();
      var rubric = $('.filter-rubric').attr('rubric').trim();
      var region = $('.filter-region').attr('region').trim();
      var query  = $('.filter-search').val().trim();

      var rubricUrl = (rubric != 0) ? 't' + rubric : '';
      var regionUrl = (region != 0) ? 'region_' + region + '/' : 'region_ukraine/';
      var queryUrl  = (query.length > 0) ? 's/' + query + '/' : '';
      var url = '/kompanii/' + queryUrl + regionUrl  + rubricUrl;
      if (rubric != 0 || region != 0) {
        url += '';
      }
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
      $('.filters-wrap').hide();
      $(".overlay, .mobileMenu").addClass('open');
      $("body").addClass('open');
    });
    $(".overlay").click(function() {
      $(".overlay, .mobileMenu").removeClass('open');
      $("body").removeClass('open');
    });
    // dropdown
    $(document).on('click', function (e) {
      if ($(e.target).closest(".dropdown, .drop-btn, .select-link").length === 0) {
        $(".dropdown").hide().parent().prev().removeClass('arrow-t');
        $(".drop-btn").removeClass('isopen');
      }
    });
    $(".drop-btn").on("click", function(e) {
      e.preventDefault();
      if ($(this).parent().next().find(".dropdown").is(':visible')) {
        $(".dropdown").hide().parent().prev().removeClass('arrow-t');
        $(".drop-btn").removeClass('isopen');
      } else {
        $(".dropdown").hide().parent().prev().removeClass('arrow-t');
        $(this).parent().addClass('arrow-t').next().find(".dropdown").show();
        $(".drop-btn").removeClass('isopen');
        $(this).addClass('isopen');
      }
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
    $('.homeCompanyTitle').each(function(index, element) {
      $clamp(element, {clamp: '53px'});
    });
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
          html += '<a href="/traders/'+trader['url']+'" class="flex-fill btn section">'+trader['product']+' (' + trader.count + ')</a>';
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

const $tradersCardDescText = document.querySelectorAll('.traders__item__content-p-title')
const $tradersCardTitle = document.querySelectorAll('.traders__item__content-title')

if ($tradersCardDescText.length) {
  $tradersCardDescText.forEach($el => {
    if ($el.textContent.length > 12) {
      $el.textContent = $el.textContent.split('').filter((_, idx) => idx < 12).join('') + '.'            
    }
  })
}

if ( $tradersCardTitle.length && document.documentElement.clientWidth < 480) {
  if (document.documentElement.clientWidth < 400) {
    $tradersCardTitle.forEach($el => {
      if ($el.textContent.length > 20) {
        $el.textContent = $el.textContent.trim().split('').filter((_, idx) => idx <= 20).join('') + '.'            
      }
    }) 
  } else {
    $tradersCardTitle.forEach($el => {
      if ($el.textContent.length > 26) {
        $el.textContent = $el.textContent.trim().split('').filter((_, idx) => idx <= 26).join('') + '.'            
      }
    })
  }
}


if (document.querySelector('.new_feed')) {
  setTimeout(() => new Swiper('.swiper-container', {
    // Optional parameters
    loop: false,
    slidesPerView: 4,
    noSwiping: false,
    // Navigation arrows
    navigation: {
      nextEl: '.new_feed-button.next',
      prevEl: '.new_feed-button.prev',
    },
    breakpoints: {
      480: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
    }
  }), 0)
}

const $new_feed_item_title = document.querySelectorAll('.new_feed-item-title')

if ($new_feed_item_title.length) {
  $new_feed_item_title.forEach($el => {
    if ($el.textContent.length >= 25) {
      $el.textContent = $el.textContent.split('').filter((_, idx) => idx <= 22).join('') + '..'
    }
  })
}


const $headerWrap = document.querySelector('.header__wrap')
const $headerWrap_container = $headerWrap.querySelector('.new_container')

window.onload = () => {
  if ($headerWrap) {
    const headerOffset = $headerWrap.offsetTop
  
    window.addEventListener('scroll', function(e) {
      if (this.scrollY < 100) {
        $headerWrap.classList.add("fixed-item");
        $headerWrap.classList.remove("hidden");
      } else if (this.scrollY < headerOffset) {
        $headerWrap.classList.remove("fixed-item");
        $headerWrap.classList.remove("hidden");
      } else if (this.oldScroll_header < this.scrollY) {
        $headerWrap.classList.add("fixed-item");
        $headerWrap.classList.add("hidden");
      } else {
        $headerWrap.classList.add("fixed-item");
        $headerWrap.classList.remove("hidden");
      }
      this.oldScroll_header = this.scrollY;
    })
    
    const $drawer =  document.querySelector('.new_header .drawer')
    const $drawerOpenBtn = document.querySelector('.header_drawerOpen-btn')
    const $body = document.querySelector('body')

    $drawerOpenBtn.addEventListener('click', () => {
      $drawer.classList.add('open')
      $body.classList.add('body_non_scroll')
    })
    $drawer.addEventListener('click', e => {
      if (e.target === $drawer) {
        $drawer.classList.remove('open')
        $body.classList.remove('body_non_scroll')
      }
    })
  }
  
}

function tradersPageScripts() {
  $('.new_traders.vip .traders__item .traders__item__image').primaryColor({
    callback: function(color) {
      $(this).parents('.traders__item__header.filled').css('background-color', 'rgb('+color+')');
    }
  })

  let prices = document.querySelectorAll('.traders__item__content-p-price')
  prices = Array.prototype.slice.call(prices)

  if (prices.length) {
    prices.forEach(price => {
      price.textContent = price.textContent.replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    })
  }

  
  let pricesTable = document.querySelectorAll('.table_price')
  pricesTable = Array.prototype.slice.call(pricesTable)

  if (pricesTable.length) {
    pricesTable.forEach(price => {
      price.textContent = price.textContent.replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    })
  }

}

tradersPageScripts()

function headerTraderPricesArrow() {
  const tradersDropdown = document.querySelector('#traders_prices_dropdown')
  const tradersDropdownParent = document.querySelector('#traders_prices_dropdown_parent')
  const tradersButton = document.querySelector('.header__tradersPrice-arrow')

  tradersButton.addEventListener('click', () => {
    tradersDropdown.classList.toggle('active')

    const listener = (e) => {
      tradersDropdown.classList.remove('active')
      tradersDropdownParent.removeEventListener('mouseleave', listener)
    }
  
    tradersDropdownParent.addEventListener('mouseleave', listener)
  })
}
headerTraderPricesArrow()

class Filter {
  init() {
    // filter controls
    this.newFiltersButtons = this.findAll('.new_filters_btn')
    this.filtersContentItems = this.findAll('.new_filters_dropdown')
    this.filterBg = document.querySelector('.bg_filters')
    // contols in filter
    this.filtersFirstColumns = this.findAll('.new_filters_dropdown_column.js_first')
    this.filtersContentColumns = this.findAll('.new_filters_dropdown_column.content')

    this.initButtonClick()
    this.initFiltersControls()
  }

  initButtonClick() {
    this.newFiltersButtons.forEach((btn, idx) => {
      btn.addEventListener('click', () => {
        const listener = () => {
          this.filterBg.removeEventListener('click', listener)
          this.closeContentItems()
        }

        // remove previous listener
        // this.filterBg.removeEventListener('click', listener)

        const wasAdded = this.openContentItem(idx)

        // adding event listener
        if (wasAdded) {
          this.filterBg.addEventListener('click', listener)
        }
      })
    })
  }

  openContentItem(idx) {
    if (this.filtersContentItems[idx].classList.contains('active')) {
      this.closeContentItems()
      return false
    } else {
      this.closeContentItems()
      this.filterBg.classList.add('active')
      this.newFiltersButtons[idx].classList.add('active')
      this.filtersContentItems[idx].classList.add('active')
      return true
    }
  }

  closeContentItems() {
    this.filterBg.classList.remove('active')
    this.filtersContentItems.forEach(contentItem => {
      contentItem.classList.remove('active')
    })
    this.newFiltersButtons.forEach(btn => {
      btn.classList.remove('active')
    })
  }
  
  isOpenedFilter() {
    let isOpenedFilter = false

    this.filtersContentItems.forEach(contentItem => {
      if (contentItem.classList.contains('active')) {
        isOpenedFilter = true
      }
    })

    return isOpenedFilter
  }
  
  isOpenedContentItem(idx) {
    return this.filtersContentItems[idx].classList.contains('active')
  }

  // controls
  initFiltersControls() {
    this.filtersFirstColumns.forEach((c, idx) => {
      const firstColumControllers = c.querySelectorAll('li a')
      const columContentItems = this.filtersContentColumns[idx].querySelectorAll('.new_filters_dropdown_column_tab')

      function disableAll() {
        columContentItems.forEach((fcci, idx) => {
          fcci.classList.remove('active')
          firstColumControllers[idx].parentNode.classList.remove('active')
        })
      }

      firstColumControllers.forEach((fcc, idx) => {
        fcc.addEventListener('click', (e) => {
          e.preventDefault()
          disableAll()
          fcc.parentNode.classList.add('active')
          columContentItems[idx].classList.add('active')
        })
      })
    })
  }

  findAll(selector) {
    return document.querySelectorAll(selector)
  }
}

// Mobile filter
class MobileFilter {
  constructor (filter) {
    this.$filter = filter
    this.search_url = {
      base: '',
      region: '',
      currency: '',
      product: ''
    }
    this.init()
  }

  init() {
    this.search_url.product = this.findEl('#product').dataset.product
    this.search_url.region = this.findEl('#region').dataset.region

    this.first_screen = this.findEl('.first')
    this.second_screen = this.findEl('.second')
    this.third_screen = this.findEl('.third')

    this.buttons()

    this.firstScreen()
    this.secondScreen()
    this.thirdScreen()

    this.submitHandler()
    this.search()
  }

  open() {
    this.$filter.parentNode.classList.add('active')
  }

  close() {
    this.$filter.parentNode.classList.remove('active')
  }

  findEl(selector, node) {
    if (node) {
      return node.querySelector(selector)      
    } else {
      return this.$filter.querySelector(selector)      
    }
  }

  openScreen(screen, subInfo) {
    this.first_screen.classList.remove('active')
    this.second_screen.classList.remove('active')
    this.third_screen.classList.remove('active')

    this.button_first.classList.remove('active')
    this.button_second.classList.remove('active')
    this.button_third.classList.remove('active')

    this.$filter.querySelector(`.back.${screen}-btn`).classList.add('active')

    this[`${screen}_screen`].classList.add('active')

    if (subInfo !== null && subInfo !== undefined) {
      const subItem = this[`${screen}_screen`].querySelectorAll('.subItem')
      subItem.forEach(s => s.classList.remove('active'))
      subItem[subInfo].classList.add('active')
    }
  }

  buttons() {
    this.button_first = this.$filter.querySelector('.back.first-btn')
    this.button_second = this.$filter.querySelector('.back.second-btn')
    this.button_third = this.$filter.querySelector('.back.third-btn')

    this.button_first.onclick = () => this.close()
    this.button_second.onclick = () => {
      this.openScreen('first')
    }
    this.button_third.onclick = () => {
      this.openScreen('second')
    }
  }

  firstScreen() {
    const clickableItems = this.first_screen.querySelectorAll('.mobile_filter-content-item')

    clickableItems.forEach((c, idx) => {
      c.addEventListener('click', (e) => {
        this.openScreen('second', idx)
      })
    })
  }

  secondScreen() {
    const clickableItems = this.second_screen.querySelectorAll('.mobile_filter-content-item')

    clickableItems.forEach((c, idx) => {
      c.addEventListener('click', (e) => {
        this.openScreen('third', idx)
      })
    })

    const clickableLinks = this.second_screen.querySelectorAll('a')

    clickableLinks.forEach((a, idx) => {
      a.addEventListener('click', (e) => {
        this.openScreen('first')
        this.changeTextOnFirstScreen(a.dataset.id, a.textContent, a.dataset.url)
      })
    })
  }

  thirdScreen() {
    const clickableItems = this.third_screen.querySelectorAll('a')

    clickableItems.forEach((c, idx) => {
      c.addEventListener('click', (e) => {
        e.preventDefault()
        this.openScreen('first')
        this.changeTextOnFirstScreen(c.dataset.id, c.textContent, c.dataset.product)
      })
    })
  }

  changeTextOnFirstScreen(id, text, content) {
    if (id === '0') {
      this.search_url.product = content
    }
    this.first_screen.querySelectorAll('.mobile_filter-content-item')[id].textContent = text
  }

  submitHandler() {
    const submitBtn = this.findEl('.mobile-filter-footer button')
    submitBtn.addEventListener('click', () => {
      const newUrl = `/${this.search_url.base}/${this.search_url.region}${this.search_url.product ? '/' +  this.search_url.product : ''}${this.search_url.currency ? '?currency=' + this.search_url.currency : ''}`
      window.location = newUrl
    })
  }

  search () {
    const searchs = this.$filter.querySelectorAll('.search_filed')
    searchs.forEach(s => {
      const closeBtn = s.parentNode.querySelector('button')
      const searchLinks = s.parentNode.parentNode.querySelectorAll('ul li a')
      const defaultValuesBlock = s.parentNode.parentNode.querySelector('.default_value')
      const output = s.parentNode.parentNode.querySelector('.output')
      // s.parentNode.parentNode.insertAdjacentHTML('beforeend', '<ul class="mobile_filter-section-list output"></ul>')

      s.addEventListener('keyup', e => {
        const value = e.target.value.toLowerCase()
        let show_result = []

        searchLinks.forEach(l => {
          if (e.target.value && l.textContent.toLowerCase().includes(value)) {
            show_result.push(l)
          }
        })

        if (value.length) {
          defaultValuesBlock.classList.add('hidden')
          output.classList.remove('hidden')
        } else {
          output.classList.add('hidden')
          defaultValuesBlock.classList.remove('hidden')
        }

        if (show_result.length) {
          output.innerHTML = show_result.map(a => `<li>${a.outerHTML}</li>`).join('')
          output.querySelectorAll('li a').forEach(link => {
            link.onclick = () => {
              this.search_url.product = link.dataset.product
              this.openScreen('first')
              this.changeTextOnFirstScreen(link.dataset.id, link.textContent, link.dataset.url)
            }
          })
        } else {
          output.innerHTML = ''
        }
      })

      closeBtn.addEventListener('click', () => {
        s.value = ''
        output.innerHTML = ''
        output.classList.add('hidden')
        defaultValuesBlock.classList.remove('hidden')
      })
    })
  }
}

const $filter = document.querySelector('.mobile_filter')
const isFilter = document.querySelector('.new_fitlers_container')


if (isFilter) {
  const filterExmp = new MobileFilter($filter)
  document.querySelector('.openFilter').onclick = () => filterExmp.open()
  new Filter().init()
}


$(".click_culture").click(function (event) {
  let rubric = event.currentTarget.getAttribute('data-product');
  console.log(rubric);
  $('#input-mobile-rubric').attr('value', rubric);
});


$(".click_region").click(function (event) {
  let region = event.currentTarget.getAttribute('data-url');
  console.log(region);
  $('#input-mobile-region-t').attr('value', region);
});


$(".click_port").click(function (event) {
  let port = event.currentTarget.getAttribute('data-url');
  console.log(port);
  $('#input-mobile-port-t').attr('value', port);
});
