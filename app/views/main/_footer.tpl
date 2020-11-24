
      </main>
<!--        <footer class="new_footer">
    <div class="new_container">
      <div class="footer-wrap">
        <div class="footer__col first">
          <div class="footer__col-title">Компания</div>
          <ul class="footer__list">
            <li class="footer__list__item">
              <a href="https://agrotender.com.ua/info/orfeta">Пользовательское соглашение</a>
            </li>
            <li>
              <a href="https://agrotender.com.ua/info/limit_adv">Правила размещения объявлений</a>
            </li>
            <li>
              <a href="#">Политика конфиденциальности</a>
            </li>
            <li>
              <a href="#">Про Agrotender.com.ua</a>
            </li>
          </ul>
        </div>
        <div class="footer__col second">
          <div class="footer__col-title">Услуги</div>
          <ul class="footer__list">
            <li>
              <a href="https://agrotender.com.ua/reklama">Реклама на сайте</a>
            </li>
            <li>
              <a href="https://agrotender.com.ua/reklama">Реклама в месенджерах</a>
            </li>
            <li>
              <a href="https://agrotender.com.ua/tarif20.html" class="footer__addCompany">+ Разместить компанию</a>
            </li>
          </ul>
        </div>
        <div class="footer__col">
          <div class="footer__col-title">Контакты</div>
          <ul class="footer__list">
            <li>
              <a href="mailto:info@agrotender.com.ua">email: <span class="white">info@agrotender.com.ua</span></a>
            </li>
            <li  class="footer__telephone">
              <a href="#tel:0504018477">050 401 84 77</a>
              <p>Звонить по будням с 10:00 до 17:00</p>
            </li>
            <li>
              <a href="/">
                <img src="https://agrotender.com.ua/app/assets/img/logo_white.svg" alt="">                
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="footer_copyright">Все права  защищены “Агротендер”  уже 9 лет ;)</div>
    </div>
  </footer> -->
      <footer class="footer">
        <div class="container">
          <div class="row mx-0">
            <div class="d-none d-sm-block col-sm-3">
              <img alt="" src="/app/assets/img/logo-grey.png" alt="Аграрный сайт Украины №1">
              <br>
              <span class="extra-small">© «АгротендерTM» 2011–{'Y'|date}</span>
              <br>
              <span>info@agrotender.com.ua</span>
            </div>
            <div class="col-12 col-sm-4">
              <ol class="footer-links m-0 p-0">
                <li><a href="/info/orfeta">Пользовательское соглашение</a></li>
                <li><a href="/info/limit_adv">Правила размещения объявлений</a></li>
                <li><a href="/tarif20.html">Как попасть в Цены трейдеров</a></li>
              </ol>
            </div>
            <div class="col-12 col-sm-2">
              <ol class="footer-links m-0 p-0">
                <li><a href="/info/contacts">Контакты</a></li>
                <li><a href="/reklama">Реклама</a></li>
                <li><a href="/news">Новости</a></li>
              </ol>
            </div>
            <div class="d-none d-sm-block col-12 col-sm-2">
              <ol class="footer-links m-0 p-0">
                <li><a href="/faq">Библиотека</a></li>
                <li><a href="/faq/12/index">ГОСТы</a></li>
                <li><a href="/sitemap">Карта сайта</a></li>
              </ol> 
            </div>
            <div class="col-12 col-sm-1 d-flex align-items-center pt-1 p-sm-0">
              <a href="https://www.facebook.com/agrotender.com.ua/"><img alt="" src="/app/assets/img/fb-icon.png" alt="Агротендер на Facebook"></a>
            </div>
          </div>
        </div>
        <div class="d-flex d-md-none align-items-center justify-content-center mt-2">
          <span class="tm small">© «АгротендерTM» 2011–{'Y'|date}</span>
        </div>
      </footer>
      {if $user->auth}
      <div class="modal fade" id="offer" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <form class="form modal-content offer">
            <div class="modal-header">
              <h5 class="modal-title ml-3">Предложить объем трейдерам</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body mt-2">
              <div class="row m-0">
                <div class="col-12 col-sm-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Компания:</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" placeholder="Название компании" name="company"{if $user->company neq null} value="{$user->company['title']}"{/if}>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Рубрика:</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="rubric">
                        {foreach $user->getRubrics() as $group}
                          <option value="" selected>Выбрать культуру</option>
                          <optgroup label="{$group['name']}">
                            {foreach $group['rubrics'] as $rubric}
                            <option value="{$rubric['id']}">{$rubric['name']}</option>
                            {/foreach}
                          </optgroup>
                        {/foreach}
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row m-0">
                <div class="col-12 col-sm-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Ф.И.О:</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" placeholder="Фамилия Имя Отчество" name="name" value="{$user->name}">
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Регион:</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="region">
                        {foreach $user->getRegions() as $region}
                        <option value="{$region['id']}"{if $user->region eq $region['id']} selected{/if}>{$region['name']}{if $region['id'] neq 1} область{/if}</option>
                        {/foreach}
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row m-0">
                <div class="col-12 col-sm-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон:</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="phone" value="{$user->phone|ltrim:'38'}">
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Цена:</label>
                    <div class="col-9 col-sm-5 pr-2">
                      <input type="text" class="form-control" name="price" placeholder="Цена">
                    </div>
                    <div class="col-3 col-sm-3 pl-0">
                      <select class="form-control" name="currency">
                        <option value="Грн.">Грн.</option>
                        <option value="USD">USD</option>
                        <option value="EUR">eur</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row m-0">
                <div class="col-12 col-sm-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Email:</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" placeholder="Email для связи" name="email" value="{$user->email}">
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Объем:</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="bulk" placeholder="Объем">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row m-0">
                <div class="col-12">
                  <div class="form-group">
                    <label class="col-form-label">Описание:</label>
                      <textarea class="form-control" name="description"></textarea>
                  </div>
                </div>
              </div>
              <div class="row m-0 list">
                <div class="col-12">
                  <span class="list-title d-block">Перечень доступных трейдеров</span>
                  <div class="list-items"></div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-center pt-2">
              <button type="button" class="btn btn-block btn-primary px-5 send-offer">Отправить предложение</button>
            </div>
          </form>
        </div>
      </div>
      {/if}
    <!--[if lt IE 9]>
    <script src="/app/assets/js/es5-shim.min.js"></script>
    <script src="/app/assets/js/html5shiv.min.js"></script>
    <script src="/app/assets/js/html5shiv-printshiv.min.js"></script>
    <script src="/app/assets/js/respond.min.js"></script>
    <![endif]-->
    <!-- Required JavaScript -->
    {$footer}
    <!--Start of PopMechanic script-->
    <script id="popmechanic-script" src="https://static.popmechanic.ru/service/loader.js?c=24840"></script>
    <!--End of PopMechanic script-->
  </body>
</html>