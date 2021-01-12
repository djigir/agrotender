<?php
?>
asdasd
<div class="content body">
    <div class="links-row"></div>
    <div class="card card-default ">
        <div class="card-heading card-header">
            <form action="http://agrotender.local/admin_dev/download_company_emails" autocomplete="off"
                  class="export-form" style="margin-bottom: 1rem;"><input type="hidden" name="obl_id" value=""
                                                                          class="export-input_obl"> <input type="hidden"
                                                                                                           name="section_id"
                                                                                                           value=""
                                                                                                           class="export-input_section">
                <input type="hidden" name="email_filter" value="" class="export-input_email_filter"> <input
                    type="hidden" name="phone_filter" value="" class="export-input_phone_filter"> <input type="hidden"
                                                                                                         name="name_filter"
                                                                                                         value=""
                                                                                                         class="export-input_name_filter">
                <input type="hidden" name="id_filter" value="" class="export-input_id_filter"> <input type="hidden"
                                                                                                      name="ip_filter"
                                                                                                      value=""
                                                                                                      class="export-input_ip_filter">
                <input type="submit" value="Выгрузить csv" class="export-btn btn btn-warning btn-create export-btn">
            </form>
            <div class="pull-right block-actions"></div>
            <div data-datatables-id="g6et6iKION" data-display="DisplayDatatablesAsync"
                 class="display-filters-top table table-default display-filters">
                <div data-index="0">
                    <div><select type_filter="regions" data-type="select" name=""
                                 class="obl_filter form-control input-select column-filter select2-hidden-accessible"
                                 data-select2-id="1" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="" data-select2-id="3">Все Области</option>
                            <option value="1">АР Крым</option>
                            <option value="2">Винницкая</option>
                            <option value="3">Волынская</option>
                            <option value="4">Днепропетровская</option>
                            <option value="5">Донецкая</option>
                            <option value="6">Житомирская</option>
                            <option value="7">Закарпатская</option>
                            <option value="8">Запорожская</option>
                            <option value="9">Ивано-Франковская</option>
                            <option value="10">Киевская</option>
                            <option value="11">Кировоградская</option>
                            <option value="12">Луганская</option>
                            <option value="13">Львовская</option>
                            <option value="14">Николаевская</option>
                            <option value="15">Одесская</option>
                            <option value="16">Полтавская</option>
                            <option value="17">Ровенская</option>
                            <option value="18">Сумская</option>
                            <option value="19">Тернопольская</option>
                            <option value="20">Харьковская</option>
                            <option value="21">Херсонская</option>
                            <option value="22">Хмельницкая</option>
                            <option value="23">Черкасская</option>
                            <option value="24">Черниговская</option>
                            <option value="25">Черновицкая</option>
                        </select><span class="select2 select2-container select2-container--default" dir="ltr"
                                       data-select2-id="2" style="width: 194px;"><span class="selection"><span
                                    class="select2-selection select2-selection--single" role="combobox"
                                    aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false"
                                    aria-labelledby="select2--8f-container"><span class="select2-selection__rendered"
                                                                                  id="select2--8f-container"
                                                                                  role="textbox" aria-readonly="true"
                                                                                  title="Все Области">Все Области</span><span
                                        class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span
                                class="dropdown-wrapper" aria-hidden="true"></span></span></div>
                </div>
                <div data-index="1">
                    <div><select type_filter="sections" data-type="select" name=""
                                 class="section_filter form-control input-select column-filter select2-hidden-accessible"
                                 data-select2-id="4" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="" data-select2-id="6">Все секции</option>
                            <option value="4">Агрохимия</option>
                            <option value="5">Закупка и реализация</option>
                            <option value="6">Перевозки</option>
                            <option value="2">Переработчики</option>
                            <option value="1">Сельхоз производители</option>
                            <option value="3">Техника и оборудование</option>
                            <option value="7">Услуги</option>
                        </select><span class="select2 select2-container select2-container--default" dir="ltr"
                                       data-select2-id="5" style="width: 1384px;"><span class="selection"><span
                                    class="select2-selection select2-selection--single" role="combobox"
                                    aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false"
                                    aria-labelledby="select2--8f-container"><span class="select2-selection__rendered"
                                                                                  id="select2--8f-container"
                                                                                  role="textbox" aria-readonly="true"
                                                                                  title="Все секции">Все секции</span><span
                                        class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span
                                class="dropdown-wrapper" aria-hidden="true"></span></span></div>
                </div>
            </div>
        </div>
        <div class="panel-table card-body pt-0 pl-0 pr-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="">
                    <div id="DataTables_Table_0_processing" class="dataTables_processing panel panel-default"
                         style="display: none;"><i class="fas fa-spinner fa-5x fa-spin"></i></div>
                </div>
                <table data-id="g6et6iKION" data-order="[[0,&quot;desc&quot;]]"
                       data-attributes="{&quot;pageLength&quot;:25,&quot;language&quot;:{&quot;no-action&quot;:&quot;\u041d\u0435\u0442 \u0434\u0435\u0439\u0441\u0442\u0432\u0438\u044f&quot;,&quot;deleted_all&quot;:&quot;\u0423\u0434\u0430\u043b\u0438\u0442\u044c \u0432\u044b\u0431\u0440\u0430\u043d\u043d\u044b\u0435&quot;,&quot;make-action&quot;:&quot;\u041e\u0442\u043f\u0440\u0430\u0432\u0438\u0442\u044c&quot;,&quot;delete-confirm&quot;:&quot;\u0412\u044b \u0443\u0432\u0435\u0440\u0435\u043d\u044b, \u0447\u0442\u043e \u0445\u043e\u0442\u0438\u0442\u0435 \u0443\u0434\u0430\u043b\u0438\u0442\u044c \u044d\u0442\u0443 \u0437\u0430\u043f\u0438\u0441\u044c?&quot;,&quot;action-confirm&quot;:&quot;\u0412\u044b \u0443\u0432\u0435\u0440\u0435\u043d\u044b, \u0447\u0442\u043e \u0445\u043e\u0442\u0438\u0442\u0435 \u0441\u043e\u0432\u0435\u0440\u0448\u0438\u0442\u044c \u044d\u0442\u043e \u0434\u0435\u0439\u0441\u0442\u0432\u0438\u0435?&quot;,&quot;delete-error&quot;:&quot;\u041d\u0435\u0432\u043e\u0437\u043c\u043e\u0436\u043d\u043e \u0443\u0434\u0430\u043b\u0438\u0442\u044c \u044d\u0442\u0443 \u0437\u0430\u043f\u0438\u0441\u044c. \u041d\u0435\u043e\u0431\u0445\u043e\u0434\u0438\u043c\u043e \u043f\u0440\u0435\u0434\u0432\u0430\u0440\u0438\u0442\u0435\u043b\u044c\u043d\u043e \u0443\u0434\u0430\u043b\u0438\u0442\u044c \u0432\u0441\u0435 \u0441\u0432\u044f\u0437\u0430\u043d\u043d\u044b\u0435 \u0437\u0430\u043f\u0438\u0441\u0438.&quot;,&quot;destroy-confirm&quot;:&quot;\u0412\u044b \u0443\u0432\u0435\u0440\u0435\u043d\u044b, \u0447\u0442\u043e \u0445\u043e\u0442\u0438\u0442\u0435 \u0443\u0434\u0430\u043b\u0438\u0442\u044c \u044d\u0442\u0443 \u0437\u0430\u043f\u0438\u0441\u044c?&quot;,&quot;destroy-error&quot;:&quot;\u041d\u0435\u0432\u043e\u0437\u043c\u043e\u0436\u043d\u043e \u0443\u0434\u0430\u043b\u0438\u0442\u044c \u044d\u0442\u0443 \u0437\u0430\u043f\u0438\u0441\u044c. \u041d\u0435\u043e\u0431\u0445\u043e\u0434\u0438\u043c\u043e \u043f\u0440\u0435\u0434\u0432\u0430\u0440\u0438\u0442\u0435\u043b\u044c\u043d\u043e \u0443\u0434\u0430\u043b\u0438\u0442\u044c \u0432\u0441\u0435 \u0441\u0432\u044f\u0437\u0430\u043d\u043d\u044b\u0435 \u0437\u0430\u043f\u0438\u0441\u0438.&quot;,&quot;error&quot;:&quot;\u0412 \u043f\u0440\u043e\u0446\u0435\u0441\u0441\u0435 \u043e\u0431\u0440\u0430\u0431\u043e\u0442\u043a\u0438 \u0432\u0430\u0448\u0435\u0433\u043e \u0437\u0430\u043f\u0440\u043e\u0441\u0430 \u0432\u043e\u0437\u043d\u0438\u043a\u043b\u0430 \u043e\u0448\u0438\u0431\u043a\u0430&quot;,&quot;filter&quot;:&quot;\u041f\u043e\u043a\u0430\u0437\u0430\u0442\u044c \u043f\u043e\u0434\u043e\u0431\u043d\u044b\u0435 \u0437\u0430\u043f\u0438\u0441\u0438&quot;,&quot;filter-goto&quot;:&quot;\u041f\u043e\u043a\u0430\u0437\u0430\u0442\u044c&quot;,&quot;save&quot;:&quot;\u0421\u043e\u0445\u0440\u0430\u043d\u0438\u0442\u044c&quot;,&quot;all&quot;:&quot;\u0412\u0441\u0435&quot;,&quot;processing&quot;:&quot;<i class=\&quot;fas fa-spinner fa-5x fa-spin\&quot;><\/i>&quot;,&quot;loadingRecords&quot;:&quot;\u0417\u0430\u0433\u0440\u0443\u0437\u043a\u0430...&quot;,&quot;lengthMenu&quot;:&quot;\u041e\u0442\u043e\u0431\u0440\u0430\u0436\u0430\u0442\u044c _MENU_ \u0437\u0430\u043f\u0438\u0441\u0435\u0439&quot;,&quot;zeroRecords&quot;:&quot;\u041d\u0435 \u043d\u0430\u0439\u0434\u0435\u043d\u043e \u043f\u043e\u0434\u0445\u043e\u0434\u044f\u0449\u0438\u0445 \u0437\u0430\u043f\u0438\u0441\u0435\u0439.&quot;,&quot;info&quot;:&quot;\u0417\u0430\u043f\u0438\u0441\u0438 \u0441 _START_ \u043f\u043e _END_ \u0438\u0437 _TOTAL_&quot;,&quot;infoEmpty&quot;:&quot;\u041d\u0435\u0442 \u0437\u0430\u043f\u0438\u0441\u0435\u0439&quot;,&quot;infoFiltered&quot;:&quot;(\u043e\u0442\u0444\u0438\u043b\u044c\u0442\u0440\u043e\u0432\u0430\u043d\u043e \u0438\u0437 _MAX_ \u0437\u0430\u043f\u0438\u0441\u0435\u0439)&quot;,&quot;infoThousands&quot;:&quot;,&quot;,&quot;infoPostFix&quot;:&quot;&quot;,&quot;search&quot;:&quot;\u041f\u043e\u0438\u0441\u043a &quot;,&quot;emptyTable&quot;:&quot;\u041d\u0435\u0442 \u0437\u0430\u043f\u0438\u0441\u0435\u0439 \u0432 \u0442\u0430\u0431\u043b\u0438\u0446\u0435&quot;,&quot;paginate&quot;:{&quot;first&quot;:&quot;\u041f\u0435\u0440\u0432\u0430\u044f&quot;,&quot;previous&quot;:&quot;&amp;larr;&quot;,&quot;next&quot;:&quot;&amp;rarr;&quot;,&quot;last&quot;:&quot;\u041f\u043e\u0441\u043b\u0435\u0434\u043d\u044f\u044f&quot;},&quot;filters&quot;:{&quot;control&quot;:&quot;\u0424\u0438\u043b\u044c\u0442\u0440&quot;}},&quot;columns&quot;:[{&quot;orderable&quot;:true,&quot;visible&quot;:true,&quot;width&quot;:&quot;100px&quot;,&quot;orderDataType&quot;:&quot;Custom&quot;},{&quot;orderable&quot;:false,&quot;visible&quot;:true,&quot;width&quot;:&quot;110px&quot;,&quot;orderDataType&quot;:&quot;Control&quot;}]}"
                       data-url="http://agrotender.local/admin_dev/comp_items/async/firstdatatables?type=email_company"
                       data-payload="[]"
                       class="table-primary table-hover th-center table datatables dataTable no-footer"
                       style="width: 100%;" id="DataTables_Table_0" role="grid"
                       aria-describedby="DataTables_Table_0_info">
                    <colgroup>
                        <col width="100px">
                        <col width="110px">
                    </colgroup>
                    <thead>
                    <tr role="row">
                        <th class="row-header sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                            colspan="1" style="width: 385.32px;" aria-sort="descending"
                            aria-label=": activate to sort column ascending"></th>
                        <th class="row-header sorting_disabled" rowspan="1" colspan="1" style="width: 437.2px;"
                            aria-label=""></th>
                    </tr>
                    </thead>
                    <thead class="table-hover table-hover">
                    <tr></tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6619/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="even">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6618/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6617/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="even">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6616/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6615/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="even">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6614/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6613/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="even">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6612/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6611/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="even">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6610/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6609/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="even">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6608/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6607/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="even">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6606/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6605/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="even">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6604/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6603/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="even">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6602/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6601/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="even">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6600/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6599/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="even">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6598/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6597/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="even">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6596/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1">
                            <div class="row-custom text-center">


                            </div>
                        </td>
                        <td>
                            <div class="table-control-btn">
                                <a href="http://agrotender.local/admin_dev/comp_items/6595/edit"
                                   class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                   data-original-title="Редактировать">
                                    <i class="fas fa-pencil-alt"></i>


                                </a>

                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="">
                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Записи с
                        1 по 25 из 6,144
                    </div>
                    <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                        <ul class="pagination">
                            <li class="paginate_button previous disabled" id="DataTables_Table_0_previous"><a href="#"
                                                                                                              aria-controls="DataTables_Table_0"
                                                                                                              data-dt-idx="0"
                                                                                                              tabindex="0">←</a>
                            </li>
                            <li class="paginate_button active"><a href="#" aria-controls="DataTables_Table_0"
                                                                  data-dt-idx="1" tabindex="0">1</a></li>
                            <li class="paginate_button "><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2"
                                                            tabindex="0">2</a></li>
                            <li class="paginate_button "><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="3"
                                                            tabindex="0">3</a></li>
                            <li class="paginate_button "><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="4"
                                                            tabindex="0">4</a></li>
                            <li class="paginate_button "><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="5"
                                                            tabindex="0">5</a></li>
                            <li class="paginate_button disabled" id="DataTables_Table_0_ellipsis"><a href="#"
                                                                                                     aria-controls="DataTables_Table_0"
                                                                                                     data-dt-idx="6"
                                                                                                     tabindex="0">…</a>
                            </li>
                            <li class="paginate_button "><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="7"
                                                            tabindex="0">246</a></li>
                            <li class="paginate_button next" id="DataTables_Table_0_next"><a href="#"
                                                                                             aria-controls="DataTables_Table_0"
                                                                                             data-dt-idx="8"
                                                                                             tabindex="0">→</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
