<?php
$route_name = \Route::getCurrentRoute()->getName();
$prefix = substr($route_name, 0, strpos($route_name, '.')).'.';

if($regions->count() > 0 && !$isMobile){
    $temp = $regions[25];
    $regions[25] = $regions[0];
    $regions[0] = $temp;
}
?>

    <div class="bg_filters"></div>
    <div class="new_fitlers_container">
    <button class="new_filters_btn" id="cultures_btn">{{$culture_name}}</button>
    <button class="new_filters_btn" id="regions_btn">{{$region_port_name}}</button>

    <div class="new_filters_dropdown" id="cultures_dropdown">
      <div class="new_filters_dropdown_column culures_first js_first">
        <ul>
          @foreach($rubricsGroup as $group => $item)
              <?php
                  $class = '';

                  if($item['index_group'] == $group_id){
                      $class = 'active';
                  }

                  if(!$group_id && $item['index_group'] == 1){
                      $class = 'active';
                  }
              ?>
              <li class="{{$class}}" group="{{$group+1}}">
                  <a href="#" data-id="{{$group+1}}">{{$item['groups']['name']}}</a>
              </li>
          @endforeach
        </ul>
      </div>
      <div class="new_filters_dropdown_column content">
          @foreach($rubricsGroup as $group => $item)
              <?php
                  $class = '';

                  if($item['index_group'] == $group_id){
                      $class = 'active';
                  }

                  if(!$group_id && $item['index_group'] == 1){
                      $class = 'active';
                  }
              ?>
              <div class="new_filters_dropdown_column_tab {{$class}} js_content" group="{{$group+1}}" data-id="{{$group+1}}">
                @foreach($rubricsGroup[$group]['groups']["products"]->chunk(6) as $chunk)
                      <div class="new_filters_dropdown_column_item">
                          <ul>
                              @foreach($chunk as $item)
                                  <li>
                                      @if(!empty($region))
                                          <a href="{{route($prefix.'region_culture', [$region, $item['url']])}}">
                                              {{ $item['traders_product_lang'][0]['name']}}
                                              @if($item['count_item'] > 0)
                                                  ({{$item['count_item']}})
                                              @endif
                                          </a>
                                      @endif
                                      @if(!empty($port))
                                          <a href="{{route($prefix.'port_culture', [$port, $item['url']])}}">
                                              {{ $item['traders_product_lang'][0]['name']}}
                                              @if($item['count_item'] > 0)
                                                  ({{$item['count_item']}})
                                              @endif
                                          </a>
                                      @endif
                                  </li>
                              @endforeach
                          </ul>
                      </div>
                @endforeach
              </div>
          @endforeach
      </div>
    </div>

    <div class="new_filters_dropdown" id="cultures_dropdown">
      <div class="new_filters_dropdown_column culures_first js_first">
        <ul>
          <li class="{{!empty($region) ? 'active' : ''}}">
            <a href="#" data-id="1">Области</a>
          </li>
          <li class="{{!empty($port) ? 'active' : ''}}">
            <a href="#" data-id="1">Порты</a>
          </li>
        </ul>
      </div>
      <div class="new_filters_dropdown_column content">
        <div class="new_filters_dropdown_column_tab {{!empty($region) ? 'active' : ''}}">
            @foreach($regions->chunk(9) as $chunk)
                <div class="new_filters_dropdown_column_item">
                    <ul>
                        @foreach($chunk as $region)
                            <li>
                                @if(!empty($culture) && !empty($region))
                                    <a data-id="1" data-url="{{$region['translit']}}" href="{{route($prefix.'region_culture', [$region['translit'], $culture_translit])}}">
                                        {{$region['name']}}
                                    </a>
                                @else
                                    @if(!empty($culture_translit))
                                        <a data-id="1" data-url="{{$region['translit']}}" href="{{route($prefix.'region_culture', [$region['translit'], $culture_translit])}}">
                                            {{$region['name']}}
                                        </a>
                                    @else
                                        <a data-id="1" data-url="{{$region['translit']}}" href="{{route($prefix.'region', $region['translit'])}}">
                                            {{$region['name']}}
                                        </a>
                                    @endif
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="new_filters_dropdown_column_tab {{!empty($port) ? 'active' : ''}}">
            @foreach($onlyPorts->chunk(5) as $chunk)
                <div class="new_filters_dropdown_column_item">
                    <ul>
                        @foreach($chunk as $port)
                            <li>
                                @if(!empty($culture) && !empty($port))
                                    <a data-id="1" href="{{route($prefix.'port_culture', [$port['url'], $culture_translit])}}">
                                        {{$port['lang']['portname']}}
                                    </a>
                                @else
                                    @if(!empty($culture_translit))
                                        <a data-id="1" href="{{route($prefix.'port_culture', [$port['url'], $culture_translit])}}">
                                            {{$port['lang']['portname']}}
                                        </a>
                                    @else
                                        <a data-id="1" href="{{route($prefix.'port', $port['url'])}}">
                                            {{$port['lang']['portname']}}
                                        </a>
                                    @endif
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
      </div>
    </div>
  </div>

<style>
    .btn-remove{
        border: none;
        background: none;
        margin-top: 10px;
        margin-right: -10px;
        outline: 0 !important;
    }
</style>
