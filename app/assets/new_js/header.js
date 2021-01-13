window.onload = (() => {
 const $loader = document.querySelector('.preloader_new')
  if ($loader) {
    $loader.classList.add('hidden')
  }

  const $headerWrap = document.querySelector('.header__wrap')
  
  function initHeader () {
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
  
  function tradersPriceLine() {
    const $line = document.querySelector('.header__tradersPrice-line')
    const $btn = document.querySelector('.header__tradersPrice-arrow')
    const $link = document.querySelector('.header__center__button')
    const $hoverElem = document.querySelector('.header__hoverElem-wrap')
  
    function initItem(item) {
      item.addEventListener('mouseover', () => {
        $line.style.opacity = '0'
      })
      item.addEventListener('mouseout', () => {
        $line.style.opacity = '0.5'
      })
    }
  
    initItem($btn)
    initItem($link)
    initItem($hoverElem)
  
  }
  
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
  tradersPriceLine()
  initHeader()
})()
