(() => {
  class Filter {
    init() {
      // filter controls
      this.newFiltersButtons = this.findAll('.new_filters_btn')
      this.filtersContentItems = this.findAll('.new_filters_dropdown')
      this.filterBg = document.querySelector('.bg_filters')
      // contols in filter
      this.filtersFirstColumns = this.findAll('.new_filters_dropdown_column.js_first')
      this.filtersContentColumns = this.findAll('.new_filters_dropdown_column.content')
      this.type = document.querySelector('.new_fitlers_container').dataset.type

      this.initButtonClick()
      this.initFiltersControls()

      if (this.type === 'companies') {
        this.filter = document.querySelector('.new_fitlers_container')
        this.companyName = this.filter.dataset.companyName
        // this.category = this.filter.dataset.category
        // this.region = this.filter.dataset.region
        this.submitBtn = document.querySelector('.company_filter-item.search_btn')

        // this.initLinksClick()
        this.initSearch()
        this.submitBtn.onclick = e => this.submitHandler(e)
      }
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

    initLinksClick() {
      const categoryLinks =  Array.prototype.slice.call(this.filter.querySelectorAll('.companies_link_category'))
      const companiesLinks = Array.prototype.slice.call(this.filter.querySelectorAll('.companies_link_country'))

      categoryLinks.forEach(link => {
        link.addEventListener('click', (e) => {
          e.preventDefault()
          this.closeContentItems()
          this.newFiltersButtons[0].textContent = link.textContent
          this.category = link.dataset.url
        })
      })

      companiesLinks.forEach(link => {
        link.addEventListener('click', (e) => {
          e.preventDefault()
          this.closeContentItems()
          this.newFiltersButtons[1].textContent = link.textContent
          this.region = link.dataset.url
        })
      })

    }

    initSearch() {
      const search = document.querySelector('.company_filter-item.search_field')
      search.addEventListener('click', () => {
        this.closeContentItems()
      })
      search.addEventListener('input', e => {
        this.closeContentItems()
        this.companyName = e.target.value
      })
    }

    submitHandler(e) {
      e.preventDefault()
      if (this.companyName) {
        window.location = `/kompanii/s/${this.companyName}`
      }
    }
  }

  class MobileFilter {
    constructor (filter, base = '') {
      this.base = base
      this.$filter = filter
      this.searchField = ''
      this.search_url = {
        base,
        region: '',
        currency: '',
        product: ''
      }
      this.init()
    }

    init() {
      this.body = document.querySelector('body')
      this.mobileFilterBg = document.querySelector('.mobile_filter-bg')
      this.companySearchFiled = this.findEl('#companySearchField')
      this.companySearchBtn = this.findEl('#companySearchBtn')
      this.rebootBtn = this.findEl('#filterRebootBtn')

      if (this.findEl('#product')) {
        this.search_url.product = this.findEl('#product').dataset.product
      }
      if (this.findEl('#region')) {
        this.search_url.region = this.findEl('#region').dataset.region
      }

      this.first_screen = this.findEl('.first')
      this.second_screen = this.findEl('.second')
      this.third_screen = this.findEl('.third')

      if (this.companySearchFiled) {
        this.initSearchForCompany()
      }

      this.buttons()

      if (this.first_screen) {
        this.firstScreen()
      }
      if (this.second_screen) {
        this.secondScreen()
      }
      if (this.third_screen) {
        this.thirdScreen()
      }

      if (this.findEl('.mobile-filter-footer button')) {
        this.submitHandler()
      }

      this.search()
      // this.rebootInit()
    }

    open() {
      this.body.classList.add('body_non_scroll')
      this.$filter.parentNode.classList.add('active')

      const listener = (e) => {
        if (e.target === this.mobileFilterBg) {
          this.close()
          this.mobileFilterBg.removeEventListener('click', listener)
        }
      }

      this.mobileFilterBg.addEventListener('click', listener)
    }

    close() {
      this.body.classList.remove('body_non_scroll')
      this.$filter.parentNode.classList.remove('active')
    }

    rebootInit() {
      if (this.rebootBtn) {
        this.rebootBtn.addEventListener('click', (e) => {
          e.preventDefault()
          this.searchField = ''
          this.search_url = {
            base: this.base,
            region: '',
            currency: '',
            product: ''
          }
          if (this.companySearchFiled) {
            this.first_screen.querySelectorAll('.mobile_filter-content-item')[0].textContent = 'Выбрать продукцию'
            this.first_screen.querySelectorAll('.mobile_filter-content-item')[1].textContent = 'Вся Украина'
            this.companySearchFiled.value = ''
          }
        })
      }
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
        console.log(subInfo)
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
        if($('.name_rubric').text() == 'Области' || $('.name_rubric').text() == 'Порты'){
          this.setTitle('Место приема');
        }else if($('.name_rubric').text() != 'Место приема' && $('.name_rubric').text() != 'Культуры' && $('.name_rubric').text() != 'Фильтры' && $('.name_rubric').text() != 'Области' && $('.name_rubric').text() != 'Порты'){
          this.setTitle('Культуры')
        }
        else{
          this.setTitle('Фильтры')
        }
        this.openScreen('first')
      }
      this.button_third.onclick = () => {
        if($('.name_rubric').text() == 'Области' || $('.name_rubric').text() == 'Порты'){
          this.setTitle('Место приема');
        }else if($('.name_rubric').text() != 'Место приема' && $('.name_rubric').text() != 'Культуры' && $('.name_rubric').text() != 'Фильтры' && $('.name_rubric').text() != 'Области' && $('.name_rubric').text() != 'Порты'){
          this.setTitle('Культуры')
        }
        else{
          this.setTitle('Фильтры')
        }
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
        c.addEventListener('click', () => {
          if (c.dataset.url) {
            this.openScreen('first')
            this.changeTextOnFirstScreen(c.dataset.id, c.textContent, c.dataset.url)
          }
          /*
          else if (c.dataset.minusidx) {
            console.log('c.dataset.minusidx', c)
            // this.openScreen('third', idx - 2)
            this.openScreen('third', idx)
          }
          */
          else {
            this.openScreen('third', idx)
            if (c.dataset.title) {
              this.setTitle(c.dataset.title)
            }
          }
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
        let newUrl
        if (this.searchField.trim().length > 0) {
          newUrl = `/kompanii/s/${this.searchField}`
          window.location = newUrl
        } else {
          newUrl = `/${this.search_url.base}/${this.search_url.region}${this.search_url.product ? '/' +  this.search_url.product : ''}${this.search_url.currency ? '?currency=' + this.search_url.currency : ''}`
          window.location = newUrl
        }
        // const newUrl = `/${this.search_url.base}/${this.search_url.region}${this.search_url.product ? '/' +  this.search_url.product : ''}${this.search_url.currency ? '?currency=' + this.search_url.currency : ''}`
      })
    }

    search () {
      const searchs = this.$filter.querySelectorAll('.search_filed')
      searchs.forEach(s => {
        const closeBtn = s.parentNode.querySelector('button')
        const searchLinks = s.parentNode.parentNode.querySelectorAll('ul li a')
        const defaultValuesBlock = s.parentNode.parentNode.querySelector('.default_value')
        const output = s.parentNode.parentNode.querySelector('.output')

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

    initSearchForCompany() {
      this.companySearchBtn.addEventListener('click', e => {
        this.companySearchFiled.value = ''
        this.searchField = ''
      })
      this.companySearchFiled.addEventListener('input', e => {
        this.searchField = e.target.value
      })
    }

    setTitle(text) {
      document.querySelector('.mobile_filter-header span').textContent = text
    }
  }

  const $filter = document.querySelector('.mobile_filter')
  const isFilter = document.querySelector('.new_fitlers_container')

  if (isFilter) {
    new Filter().init()
  }
  if ($filter) {
    const filterExmp = new MobileFilter($filter, 'kompanii')
    document.querySelector('.openFilter').onclick = () => filterExmp.open()
  }


  /* Для записи значение в value input в моб. фильтре компаний */
  $(".click-culture-company").click(function (event) {
    let rubric = event.currentTarget.getAttribute('culture-id');
    $('.name_rubric').text('Фильтры');
    $('#input-mobile-rubric-company').attr('value', rubric);
  });

  $(".click-region-company").click(function (event) {
    let rubric = event.currentTarget.getAttribute('data-url');
    $('.name_rubric').text('Фильтры');
    $('#input-mobile-region-company').attr('value', rubric);
  });


  /* Для записи значение в value input в моб. фильтре трейдеров */
  $(".click_culture").click(function (event) {
    let rubric = event.currentTarget.getAttribute('data-product');
    $('.name_rubric').text('Фильтры');
    $('#new-input-mobile-rubric').attr('value', rubric);
  });


  $(".click_region").click(function (event) {
    let region = event.currentTarget.getAttribute('data-url');
    $('.name_rubric').text('Фильтры');
    $('#new-input-mobile-region-t').attr('value', region);
    $('#new-input-mobile-port-t').attr('value', null);
  });


  $(".click_port").click(function (event) {
    let port = event.currentTarget.getAttribute('data-url');
    $('.name_rubric').text('Фильтры');
    $('#new-input-mobile-port-t').attr('value', port);
    $('#new-input-mobile-region-t').attr('value', null);
  });

  $('.select-region-filter').click(function (event) {
    $('.name_rubric').text('Области');
  });

  $('.select-port-filter').click(function (event) {
    $('.name_rubric').text('Порты');
  });

  $('#region').click(function (event) {
    $('.name_rubric').text('Место приемки');
  });

  $('#product').click(function (event) {
    $('.name_rubric').text('Виды деятельности');
  });
})()
