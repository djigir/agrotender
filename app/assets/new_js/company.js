(() => {
  // Menu
  const $openCompanyMenu = document.querySelector('.open_company_menu')

  if ($openCompanyMenu) {
    const $darkBg = document.querySelector('.bg_filters_spoiler')
    const $openCompanyMenuBtn = $openCompanyMenu.querySelector('button')
    const listener = e => {
      if (!e.target.classList.contains('spoiler')) {
        $openCompanyMenu.classList.remove('active')
        $darkBg.classList.remove('active')
        window.removeEventListener('click', listener)
      }
    }
    $openCompanyMenuBtn.addEventListener('click', () => {
      if (!$openCompanyMenu.classList.contains('active')) {
        setTimeout(() => {
          window.addEventListener('click', listener)
        }, 0)
      }
      $darkBg.classList.toggle('active')
      $openCompanyMenu.classList.toggle('active')
    })
  }

  // Companies header
  function companiesPage() {
    const $button = document.querySelector('#findCompany')

    $button.addEventListener('click', () => {
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
    })
  }

  if (document.querySelector('#findCompany')) {
    companiesPage()
  }

})()
