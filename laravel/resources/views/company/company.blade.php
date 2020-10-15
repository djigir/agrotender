@extends('layout.layout')

@section('content')
    @include('company.company-header', ['id' => $id, 'company_name' => $company_name])

    <div class="container company mb-5">
        <h2 class="d-inline-block mt-4">Цены трейдера</h2>
        <div class="d-inline-block content-block px-3 py-1 mt-3 mb-4 mb-sm-0 ml-0 ml-sm-3">
            <b>Обновлено 12.10.2020</b>
        </div>

        <div class="ports-tabs table-tabs mt-3">
            <a href="#" currency="0" class="active">Закупки UAH</a>      </div>
        <div class="content-block prices-block mb-5" style="position: relative">
            <div class="price-table-wrap ports scroll-x d-none d-sm-block">
                <div class="tableFirst" style="position: relative; z-index: 1;overflow: hidden;">
                    <table class="sortTable price-table ports-table">
                        <thead>
                        <tr><th>Порты / Переходы</th>
                            <th rubric="14">Кукуруза</th>
                            <th rubric="24">Подсолнечник</th>
                            <th rubric="8">Пшеница 2 кл.</th>
                            <th rubric="9">Пшеница 3 кл.</th>
                            <th rubric="10">Пшеница 4 кл.</th>
                            <th rubric="13">Ячмень</th>
                        </tr></thead>
                        <tbody>
                        <tr>
                            <td place="6603" class="py-1">
                                <span class="place-title">Черноморский МП</span>
                                <span class="place-comment">УЧИ, ТБТ (авто)</span>
                            </td>

                            <td place="6603" rubric="14" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 250</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС-5583</span>                      </td>

                            <td place="6603" rubric="14" currency="1" class="currency-1">
                            </td>

                            <td place="6603" rubric="24" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 500</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 11667</span>                      </td>

                            <td place="6603" rubric="24" currency="1" class="currency-1">
                            </td>

                            <td place="6603" rubric="8" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 6417</span>                      </td>

                            <td place="6603" rubric="8" currency="1" class="currency-1">
                            </td>

                            <td place="6603" rubric="9" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 6417</span>                      </td>

                            <td place="6603" rubric="9" currency="1" class="currency-1">
                            </td>

                            <td place="6603" rubric="10" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7600</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 6333</span>                      </td>

                            <td place="6603" rubric="10" currency="1" class="currency-1">
                            </td>

                            <td place="6603" rubric="13" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6750</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС- 5625</span>                      </td>

                            <td place="6603" rubric="13" currency="1" class="currency-1">
                            </td>
                        </tr>
                        <tr>
                            <td place="6608" class="py-1">
                                <span class="place-title">Черноморский МП</span>
                                <span class="place-comment">УЧИ, ТБТ (ж/д)</span>
                            </td>

                            <td place="6608" rubric="14" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 250</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС-5583</span>                      </td>

                            <td place="6608" rubric="14" currency="1" class="currency-1">
                            </td>

                            <td place="6608" rubric="24" currency="0" class="currency-0">
                            </td>

                            <td place="6608" rubric="24" currency="1" class="currency-1">
                            </td>

                            <td place="6608" rubric="8" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 6417</span>                      </td>

                            <td place="6608" rubric="8" currency="1" class="currency-1">
                            </td>

                            <td place="6608" rubric="9" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 6417</span>                      </td>

                            <td place="6608" rubric="9" currency="1" class="currency-1">
                            </td>

                            <td place="6608" rubric="10" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7600</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 6333</span>                      </td>

                            <td place="6608" rubric="10" currency="1" class="currency-1">
                            </td>

                            <td place="6608" rubric="13" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6750</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС-5625</span>                      </td>

                            <td place="6608" rubric="13" currency="1" class="currency-1">
                            </td>
                        </tr>
                        <tr>
                            <td place="6605" class="py-1">
                                <span class="place-title">Южный МП</span>
                                <span class="place-comment">ТИС (авто)</span>
                            </td>

                            <td place="6605" rubric="14" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 250</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС-5583</span>                      </td>

                            <td place="6605" rubric="14" currency="1" class="currency-1">
                            </td>

                            <td place="6605" rubric="24" currency="0" class="currency-0">
                            </td>

                            <td place="6605" rubric="24" currency="1" class="currency-1">
                            </td>

                            <td place="6605" rubric="8" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС-6417</span>                      </td>

                            <td place="6605" rubric="8" currency="1" class="currency-1">
                            </td>

                            <td place="6605" rubric="9" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС- 6417</span>                      </td>

                            <td place="6605" rubric="9" currency="1" class="currency-1">
                            </td>

                            <td place="6605" rubric="10" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7600</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС- 6333</span>                      </td>

                            <td place="6605" rubric="10" currency="1" class="currency-1">
                            </td>

                            <td place="6605" rubric="13" currency="0" class="currency-0">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6750</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС-5625</span>                      </td>

                            <td place="6605" rubric="13" currency="1" class="currency-1">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tableSecond">
                    <div class="tableScroll blue">
                        <table class="sortTable price-table ports-table" style="left: -240px; width: calc(100% + 240px)">
                            <thead>
                            <tr><th>Порты / Переходы</th>
                                <th rubric="14">Кукуруза</th>
                                <th rubric="24">Подсолнечник</th>
                                <th rubric="8">Пшеница 2 кл.</th>
                                <th rubric="9">Пшеница 3 кл.</th>
                                <th rubric="10">Пшеница 4 кл.</th>
                                <th rubric="13">Ячмень</th>
                            </tr></thead>
                            <tbody>
                            <tr>
                                <td place="6603" class="py-1">
                                    <span class="place-title">Черноморский МП</span>
                                    <span class="place-comment">УЧИ, ТБТ (авто)</span>
                                </td>

                                <td place="6603" rubric="14" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 250</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-5583</span>                              </td>

                                <td place="6603" rubric="14" currency="1" class="currency-1">
                                </td>

                                <td place="6603" rubric="24" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 500</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС 11667</span>                              </td>

                                <td place="6603" rubric="24" currency="1" class="currency-1">
                                </td>

                                <td place="6603" rubric="8" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС 6417</span>                              </td>

                                <td place="6603" rubric="8" currency="1" class="currency-1">
                                </td>

                                <td place="6603" rubric="9" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС 6417</span>                              </td>

                                <td place="6603" rubric="9" currency="1" class="currency-1">
                                </td>

                                <td place="6603" rubric="10" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7600</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС 6333</span>                              </td>

                                <td place="6603" rubric="10" currency="1" class="currency-1">
                                </td>

                                <td place="6603" rubric="13" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6750</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС- 5625</span>                              </td>

                                <td place="6603" rubric="13" currency="1" class="currency-1">
                                </td>
                            </tr>
                            <tr>
                                <td place="6608" class="py-1">
                                    <span class="place-title">Черноморский МП</span>
                                    <span class="place-comment">УЧИ, ТБТ (ж/д)</span>
                                </td>

                                <td place="6608" rubric="14" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 250</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-5583</span>                              </td>

                                <td place="6608" rubric="14" currency="1" class="currency-1">
                                </td>

                                <td place="6608" rubric="24" currency="0" class="currency-0">
                                </td>

                                <td place="6608" rubric="24" currency="1" class="currency-1">
                                </td>

                                <td place="6608" rubric="8" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС 6417</span>                              </td>

                                <td place="6608" rubric="8" currency="1" class="currency-1">
                                </td>

                                <td place="6608" rubric="9" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС 6417</span>                              </td>

                                <td place="6608" rubric="9" currency="1" class="currency-1">
                                </td>

                                <td place="6608" rubric="10" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7600</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС 6333</span>                              </td>

                                <td place="6608" rubric="10" currency="1" class="currency-1">
                                </td>

                                <td place="6608" rubric="13" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6750</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-5625</span>                              </td>

                                <td place="6608" rubric="13" currency="1" class="currency-1">
                                </td>
                            </tr>
                            <tr>
                                <td place="6605" class="py-1">
                                    <span class="place-title">Южный МП</span>
                                    <span class="place-comment">ТИС (авто)</span>
                                </td>

                                <td place="6605" rubric="14" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 250</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-5583</span>                              </td>

                                <td place="6605" rubric="14" currency="1" class="currency-1">
                                </td>

                                <td place="6605" rubric="24" currency="0" class="currency-0">
                                </td>

                                <td place="6605" rubric="24" currency="1" class="currency-1">
                                </td>

                                <td place="6605" rubric="8" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-6417</span>                              </td>

                                <td place="6605" rubric="8" currency="1" class="currency-1">
                                </td>

                                <td place="6605" rubric="9" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС- 6417</span>                              </td>

                                <td place="6605" rubric="9" currency="1" class="currency-1">
                                </td>

                                <td place="6605" rubric="10" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7600</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС- 6333</span>                              </td>

                                <td place="6605" rubric="10" currency="1" class="currency-1">
                                </td>

                                <td place="6605" rubric="13" currency="0" class="currency-0">
                                    <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6750</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-5625</span>                              </td>

                                <td place="6605" rubric="13" currency="1" class="currency-1">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-sm-none price-table-wrap ports scroll-x">
                <table class="sortTable price-table ports-table">
                    <thead>
                    <tr><th>Порты / Переходы</th>
                        <th rubric="14">Кукуруза</th>
                        <th rubric="24">Подсолнечник</th>
                        <th rubric="8">Пшеница 2 кл.</th>
                        <th rubric="9">Пшеница 3 кл.</th>
                        <th rubric="10">Пшеница 4 кл.</th>
                        <th rubric="13">Ячмень</th>
                    </tr></thead>
                    <tbody>
                    <tr>
                        <td place="6603" class="py-1">
                            <span class="place-title">Черноморский МП</span>
                            <span class="place-comment">УЧИ, ТБТ (авто)</span>
                        </td>

                        <td place="6603" rubric="14" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 250</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС-5583</span>                      </td>

                        <td place="6603" rubric="14" currency="1" class="currency-1">
                        </td>

                        <td place="6603" rubric="24" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 500</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 11667</span>                      </td>

                        <td place="6603" rubric="24" currency="1" class="currency-1">
                        </td>

                        <td place="6603" rubric="8" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 6417</span>                      </td>

                        <td place="6603" rubric="8" currency="1" class="currency-1">
                        </td>

                        <td place="6603" rubric="9" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 6417</span>                      </td>

                        <td place="6603" rubric="9" currency="1" class="currency-1">
                        </td>

                        <td place="6603" rubric="10" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7600</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 6333</span>                      </td>

                        <td place="6603" rubric="10" currency="1" class="currency-1">
                        </td>

                        <td place="6603" rubric="13" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6750</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС- 5625</span>                      </td>

                        <td place="6603" rubric="13" currency="1" class="currency-1">
                        </td>
                    </tr>
                    <tr>
                        <td place="6608" class="py-1">
                            <span class="place-title">Черноморский МП</span>
                            <span class="place-comment">УЧИ, ТБТ (ж/д)</span>
                        </td>

                        <td place="6608" rubric="14" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 250</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС-5583</span>                      </td>

                        <td place="6608" rubric="14" currency="1" class="currency-1">
                        </td>

                        <td place="6608" rubric="24" currency="0" class="currency-0">
                        </td>

                        <td place="6608" rubric="24" currency="1" class="currency-1">
                        </td>

                        <td place="6608" rubric="8" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 6417</span>                      </td>

                        <td place="6608" rubric="8" currency="1" class="currency-1">
                        </td>

                        <td place="6608" rubric="9" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 6417</span>                      </td>

                        <td place="6608" rubric="9" currency="1" class="currency-1">
                        </td>

                        <td place="6608" rubric="10" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7600</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС 6333</span>                      </td>

                        <td place="6608" rubric="10" currency="1" class="currency-1">
                        </td>

                        <td place="6608" rubric="13" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6750</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС-5625</span>                      </td>

                        <td place="6608" rubric="13" currency="1" class="currency-1">
                        </td>
                    </tr>
                    <tr>
                        <td place="6605" class="py-1">
                            <span class="place-title">Южный МП</span>
                            <span class="place-comment">ТИС (авто)</span>
                        </td>

                        <td place="6605" rubric="14" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 250</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС-5583</span>                      </td>

                        <td place="6605" rubric="14" currency="1" class="currency-1">
                        </td>

                        <td place="6605" rubric="24" currency="0" class="currency-0">
                        </td>

                        <td place="6605" rubric="24" currency="1" class="currency-1">
                        </td>

                        <td place="6605" rubric="8" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС-6417</span>                      </td>

                        <td place="6605" rubric="8" currency="1" class="currency-1">
                        </td>

                        <td place="6605" rubric="9" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС- 6417</span>                      </td>

                        <td place="6605" rubric="9" currency="1" class="currency-1">
                        </td>

                        <td place="6605" rubric="10" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">7600</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС- 6333</span>                      </td>

                        <td place="6605" rubric="10" currency="1" class="currency-1">
                        </td>

                        <td place="6605" rubric="13" currency="0" class="currency-0">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">6750</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 50</span></div>            <span class="d-block lh-1 pb-1 extra-small">без НДС-5625</span>                      </td>

                        <td place="6605" rubric="13" currency="1" class="currency-1">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="regions-tabs table-tabs mt-5">
            <a href="#" currency="0" class="active">Закупки UAH</a>      </div>
        <div class="content-block prices-block  d-none d-sm-block" style="position: relative ">
            <div class="tableFirst" style="position: relative; z-index: 1;overflow: hidden;">
                <table class="sortTable price-table regions-table">
                    <thead>
                    <tr><th>Регионы / Элеваторы</th>
                        <th rubric="24">Подсолнечник</th>
                        <th rubric="169">Подсолнечник высокоолеин.</th>
                    </tr></thead>
                    <tbody>
                    <tr>
                        <td place="6614" class="py-1">
                            <span class="place-title">Кировоградская обл.</span>
                            <span class="place-comment">Придніпровський ОЕЗ</span>
                        </td>
                        <td place="6614" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>              <span class="d-block lh-1 pb-1 extra-small">без НДС-11667</span>                          </td>
                        <td place="6614" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="6614" rubric="169" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>              <span class="d-block lh-1 pb-1 extra-small">без НДС-11667</span>                          </td>
                        <td place="6614" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    <tr>
                        <td place="6612" class="py-1">
                            <span class="place-title">Кировоградская обл.</span>
                            <span class="place-comment">Кропивницький ОЕЗ (авто)</span>
                        </td>
                        <td place="6612" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>              <span class="d-block lh-1 pb-1 extra-small">без НДС-11667</span>                          </td>
                        <td place="6612" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="6612" rubric="169" currency="0" class="currency-0 ">
                        </td>
                        <td place="6612" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    <tr>
                        <td place="6610" class="py-1">
                            <span class="place-title">Николаевская обл.</span>
                            <span class="place-comment">Бандурський ОЕЗ</span>
                        </td>
                        <td place="6610" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 600</span></div>              <span class="d-block lh-1 pb-1 extra-small">без НДС-11667</span>                          </td>
                        <td place="6610" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="6610" rubric="169" currency="0" class="currency-0 ">
                        </td>
                        <td place="6610" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    <tr>
                        <td place="6613" class="py-1">
                            <span class="place-title">Полтавская обл.</span>
                            <span class="place-comment">Полтавський ОЕЗ (авто)</span>
                        </td>
                        <td place="6613" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">13700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 500</span></div>              <span class="d-block lh-1 pb-1 extra-small">без НДС-11417</span>                          </td>
                        <td place="6613" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="6613" rubric="169" currency="0" class="currency-0 ">
                        </td>
                        <td place="6613" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    <tr>
                        <td place="6615" class="py-1">
                            <span class="place-title">Харьковская обл.</span>
                            <span class="place-comment">Приколотнянський ОЕЗ (авто)</span>
                        </td>
                        <td place="6615" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">13700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>              <span class="d-block lh-1 pb-1 extra-small">без НДС-11417</span>                          </td>
                        <td place="6615" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="6615" rubric="169" currency="0" class="currency-0 ">
                        </td>
                        <td place="6615" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    <tr>
                        <td place="8410" class="py-1">
                            <span class="place-title">Харьковская обл.</span>
                            <span class="place-comment">Агросинергія</span>
                        </td>
                        <td place="8410" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">13700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>              <span class="d-block lh-1 pb-1 extra-small">без НДС-11417</span>                          </td>
                        <td place="8410" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="8410" rubric="169" currency="0" class="currency-0 ">
                        </td>
                        <td place="8410" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    <tr>
                        <td place="6611" class="py-1">
                            <span class="place-title">Харьковская обл.</span>
                            <span class="place-comment">Вовчанський ОЕЗ (авто)</span>
                        </td>
                        <td place="6611" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">13700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>              <span class="d-block lh-1 pb-1 extra-small">без НДС-11417</span>                          </td>
                        <td place="6611" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="6611" rubric="169" currency="0" class="currency-0 ">
                        </td>
                        <td place="6611" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tableSecond ">
                <div class="tableScroll orange">
                    <table class="sortTable orange price-table regions-table" style="left: -240px; width: calc(100% + 240px)">
                        <thead>
                        <tr><th>Регионы / Элеваторы</th>
                            <th rubric="24">Подсолнечник</th>
                            <th rubric="169">Подсолнечник высокоолеин.</th>
                        </tr></thead>
                        <tbody>
                        <tr>
                            <td place="6614" class="py-1">
                                <span class="place-title">Кировоградская обл.</span>
                                <span class="place-comment">Придніпровський ОЕЗ</span>
                            </td>
                            <td place="6614" rubric="24" currency="0" class="currency-0 ">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-11667</span>                              </td>
                            <td place="6614" rubric="24" currency="1" class="currency-1 ">
                            </td>
                            <td place="6614" rubric="169" currency="0" class="currency-0 ">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-11667</span>                              </td>
                            <td place="6614" rubric="169" currency="1" class="currency-1 ">
                            </td>
                        </tr>
                        <tr>
                            <td place="6612" class="py-1">
                                <span class="place-title">Кировоградская обл.</span>
                                <span class="place-comment">Кропивницький ОЕЗ (авто)</span>
                            </td>
                            <td place="6612" rubric="24" currency="0" class="currency-0 ">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-11667</span>                              </td>
                            <td place="6612" rubric="24" currency="1" class="currency-1 ">
                            </td>
                            <td place="6612" rubric="169" currency="0" class="currency-0 ">
                            </td>
                            <td place="6612" rubric="169" currency="1" class="currency-1 ">
                            </td>
                        </tr>
                        <tr>
                            <td place="6610" class="py-1">
                                <span class="place-title">Николаевская обл.</span>
                                <span class="place-comment">Бандурський ОЕЗ</span>
                            </td>
                            <td place="6610" rubric="24" currency="0" class="currency-0 ">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 600</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-11667</span>                              </td>
                            <td place="6610" rubric="24" currency="1" class="currency-1 ">
                            </td>
                            <td place="6610" rubric="169" currency="0" class="currency-0 ">
                            </td>
                            <td place="6610" rubric="169" currency="1" class="currency-1 ">
                            </td>
                        </tr>
                        <tr>
                            <td place="6613" class="py-1">
                                <span class="place-title">Полтавская обл.</span>
                                <span class="place-comment">Полтавський ОЕЗ (авто)</span>
                            </td>
                            <td place="6613" rubric="24" currency="0" class="currency-0 ">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">13700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 500</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-11417</span>                              </td>
                            <td place="6613" rubric="24" currency="1" class="currency-1 ">
                            </td>
                            <td place="6613" rubric="169" currency="0" class="currency-0 ">
                            </td>
                            <td place="6613" rubric="169" currency="1" class="currency-1 ">
                            </td>
                        </tr>
                        <tr>
                            <td place="6615" class="py-1">
                                <span class="place-title">Харьковская обл.</span>
                                <span class="place-comment">Приколотнянський ОЕЗ (авто)</span>
                            </td>
                            <td place="6615" rubric="24" currency="0" class="currency-0 ">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">13700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-11417</span>                              </td>
                            <td place="6615" rubric="24" currency="1" class="currency-1 ">
                            </td>
                            <td place="6615" rubric="169" currency="0" class="currency-0 ">
                            </td>
                            <td place="6615" rubric="169" currency="1" class="currency-1 ">
                            </td>
                        </tr>
                        <tr>
                            <td place="8410" class="py-1">
                                <span class="place-title">Харьковская обл.</span>
                                <span class="place-comment">Агросинергія</span>
                            </td>
                            <td place="8410" rubric="24" currency="0" class="currency-0 ">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">13700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-11417</span>                              </td>
                            <td place="8410" rubric="24" currency="1" class="currency-1 ">
                            </td>
                            <td place="8410" rubric="169" currency="0" class="currency-0 ">
                            </td>
                            <td place="8410" rubric="169" currency="1" class="currency-1 ">
                            </td>
                        </tr>
                        <tr>
                            <td place="6611" class="py-1">
                                <span class="place-title">Харьковская обл.</span>
                                <span class="place-comment">Вовчанський ОЕЗ (авто)</span>
                            </td>
                            <td place="6611" rubric="24" currency="0" class="currency-0 ">
                                <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">13700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>                <span class="d-block lh-1 pb-1 extra-small">без НДС-11417</span>                              </td>
                            <td place="6611" rubric="24" currency="1" class="currency-1 ">
                            </td>
                            <td place="6611" rubric="169" currency="0" class="currency-0 ">
                            </td>
                            <td place="6611" rubric="169" currency="1" class="currency-1 ">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="price-table-wrap ports scroll-x  d-sm-none">
            <div class="content-block prices-block" style="position: relative">
                <table class="sortTable price-table regions-table">
                    <thead>
                    <tr><th>Регионы / Элеваторы</th>
                        <th rubric="24">Подсолнечник</th>
                        <th rubric="169">Подсолнечник высокоолеин.</th>
                    </tr></thead>
                    <tbody>
                    <tr>
                        <td place="6614" class="py-1">
                            <span class="place-title">Кировоградская обл.</span>
                            <span class="place-comment">Придніпровський ОЕЗ</span>
                        </td>
                        <td place="6614" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>          <span class="d-block lh-1 pb-1 extra-small">без НДС-11667</span>                  </td>
                        <td place="6614" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="6614" rubric="169" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>          <span class="d-block lh-1 pb-1 extra-small">без НДС-11667</span>                  </td>
                        <td place="6614" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    <tr>
                        <td place="6612" class="py-1">
                            <span class="place-title">Кировоградская обл.</span>
                            <span class="place-comment">Кропивницький ОЕЗ (авто)</span>
                        </td>
                        <td place="6612" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>          <span class="d-block lh-1 pb-1 extra-small">без НДС-11667</span>                  </td>
                        <td place="6612" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="6612" rubric="169" currency="0" class="currency-0 ">
                        </td>
                        <td place="6612" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    <tr>
                        <td place="6610" class="py-1">
                            <span class="place-title">Николаевская обл.</span>
                            <span class="place-comment">Бандурський ОЕЗ</span>
                        </td>
                        <td place="6610" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">14000</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 600</span></div>          <span class="d-block lh-1 pb-1 extra-small">без НДС-11667</span>                  </td>
                        <td place="6610" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="6610" rubric="169" currency="0" class="currency-0 ">
                        </td>
                        <td place="6610" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    <tr>
                        <td place="6613" class="py-1">
                            <span class="place-title">Полтавская обл.</span>
                            <span class="place-comment">Полтавський ОЕЗ (авто)</span>
                        </td>
                        <td place="6613" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">13700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 500</span></div>          <span class="d-block lh-1 pb-1 extra-small">без НДС-11417</span>                  </td>
                        <td place="6613" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="6613" rubric="169" currency="0" class="currency-0 ">
                        </td>
                        <td place="6613" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    <tr>
                        <td place="6615" class="py-1">
                            <span class="place-title">Харьковская обл.</span>
                            <span class="place-comment">Приколотнянський ОЕЗ (авто)</span>
                        </td>
                        <td place="6615" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">13700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>          <span class="d-block lh-1 pb-1 extra-small">без НДС-11417</span>                  </td>
                        <td place="6615" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="6615" rubric="169" currency="0" class="currency-0 ">
                        </td>
                        <td place="6615" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    <tr>
                        <td place="8410" class="py-1">
                            <span class="place-title">Харьковская обл.</span>
                            <span class="place-comment">Агросинергія</span>
                        </td>
                        <td place="8410" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">13700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>          <span class="d-block lh-1 pb-1 extra-small">без НДС-11417</span>                  </td>
                        <td place="8410" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="8410" rubric="169" currency="0" class="currency-0 ">
                        </td>
                        <td place="8410" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    <tr>
                        <td place="6611" class="py-1">
                            <span class="place-title">Харьковская обл.</span>
                            <span class="place-comment">Вовчанський ОЕЗ (авто)</span>
                        </td>
                        <td place="6611" rubric="24" currency="0" class="currency-0 ">
                            <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">13700</span> &nbsp;<img src="/app/assets/img/price-up.svg">&nbsp; <span class="price-up"> 700</span></div>          <span class="d-block lh-1 pb-1 extra-small">без НДС-11417</span>                  </td>
                        <td place="6611" rubric="24" currency="1" class="currency-1 ">
                        </td>
                        <td place="6611" rubric="169" currency="0" class="currency-0 ">
                        </td>
                        <td place="6611" rubric="169" currency="1" class="currency-1 ">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h2 class="mt-4">О компании</h2>
        <div class="about mt-3">
            {!! $company->content !!}
        </div>
    </div>
@endsection
