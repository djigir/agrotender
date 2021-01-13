function tradersPage () {
  function tradersPageScripts() {
  
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
  
  function tradersPageScriptsTruncateAndSlider() {
    const $tradersCardDescText = document.querySelectorAll('.traders__item__content-p-title')
    const $tradersCardTitle = document.querySelectorAll('.traders__item__content-title')
    
    // Truncate
    if ($tradersCardDescText.length) {
      $tradersCardDescText.forEach($el => {
        if ($el.textContent.length > 12) {
          $el.textContent = $el.textContent.split('').filter((_, idx) => idx < 12).join('') + '.'            
        }
      })
    }
    
    // Truncate
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
    
    // Slider
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
  }
  
  function tradersTruncate () {
    const $new_feed_item_title = document.querySelectorAll('.new_feed-item-title')
  
    if ($new_feed_item_title.length) {
      $new_feed_item_title.forEach($el => {
        if ($el.textContent.length >= 25) {
          $el.textContent = $el.textContent.split('').filter((_, idx) => idx <= 22).join('') + '..'
        }
      })
    }
  }
  
  function colorThiefActivate() {
    const tradersImages = $('.new_traders .traders__item .traders__item__image')
    tradersImages.imgcolr((img, color) => {
      img.parentNode.style.backgroundColor = color
    })
  }

  window.addEventListener('load', () => {
    tradersPageScripts()
    tradersTruncate()
    tradersPageScriptsTruncateAndSlider()
    colorThiefActivate()
  })      
}

if (document.querySelector('.new_traders')) {
  tradersPage()
}
