<style>
    #section:focus{
        box-shadow: 0 0 0 12px red!important; ;

    }
    #section{
        width: 900px;
    }
    .form-control:focus{
        border-color: red;
    }

</style>
@php
    use App\Models\ADV\AdvTorgTgroups;
    use App\Models\ADV\AdvTorgTopic;
    use App\Models\Regions\Regions;
    //**Filters data**
    //region
    $regions = Regions::query()->pluck('name','id');
    //ad
    $ad_types = [
        1 =>'Куплю',
                 2 => 'Продам',
                 3 => 'Услуги'
                 ];
    //group
    $groups = AdvTorgTgroups::query()->select(['id', 'title'])->pluck('title', 'id')->toArray();
    $subgroups = AdvTorgTopic::query()->where('parent_id', '0')->select('id', 'title', 'menu_group_id')->get()->groupBy('menu_group_id')->toArray();
    $groupFilter = [];
        foreach ($groups as $key => $value) {
            $groupFilter[$key + 10000] = $value;
            foreach ($subgroups[$key] as $key2 => $value2)
                $groupFilter[$value2['id']] = $value2['title'];
        }
     //sections
  //   $sections = AdvTorgTopic::query()->where('parent_id', request()->get('group'))->pluck('title','id')->toArray();
     $sections = AdvTorgTopic::query()->where('parent_id','<>',0)->select('id','parent_id','title')->with('subTopic:id,menu_group_id') ->get()->sortBy('parent_id')->toArray();
    //period
    $period =[1 => 'Сегодня',
              2 => 'За 7 дней'];
    //session dont ready
    $session = [
         1 => 'Нет',
         2 => 'Да'
        ];
    //active
    $active = [ 1 => 'Активные не арх.', 2 => 'Активные арх.', 3 => 'Все' ];
    //improvements
    $improvements = [1 => 'Объявления в топе.',
                     2 => 'Выделенные цветом'];
    //moderation
    $moderation =[1 =>'На модерации',
                  2 =>'Допущенные'];
    //words_ban
    $wordsBan =[1 =>'Заблокированые',
                  2 =>'Допущенные'];

     //**End filters data**

@endphp
        <form method="GET">
        <div class="display-filters-top table table-default display-filters">

                <div style="">
                    <span style="display: inline-block; padding: 2px">Область:
                        <select style="width:200px;" data-type="select" name="region" class="form-control input-select column-filter " data-select2-id="1" tabindex="-1" aria-hidden="true">
                            <option {{!request('region')?'selected="selected"':''}}   value="" >Все области</option>
                                @foreach($regions as $key => $region)
                                    <option value="{{$key}}" {{request('region') == $key?'selected="selected"':''}}   >{{$region}}</option>
                                @endforeach
                        </select>
                    </span>
                    <span style="display: inline-block;padding: 2px">Тип объявления:
                        <select style="width:120px;" data-type="select" name="ad" class="form-control input-select column-filter ">
                        <option {{!request('ad')?'selected="selected"':''}}   value="" >Все типы</option>
                        @foreach($ad_types as $key => $value)
                            <option value="{{$key}}" {{request('ad') == $key?'selected="selected"':''}}   >{{$value}}</option>
                        @endforeach
                    </select>
                    </span>
                    <span style="display: inline-block;padding: 2px">Раздел:
                        <select style="width:300px;" data-type="select" name="group" class="form-control input-select column-filter " onchange="showSubCategoies(this.value)">
                        <option {{!request('group')?'selected="selected"':''}}   value="" >Все разделы</option>
                        @foreach($groupFilter as $key => $value)
                            <option value="{{$key}}" {{request('group') == $key?'selected="selected"':''}} >@if($key<10000)&nbsp;&nbsp;&nbsp;@endif  {{$value}}</option>
                        @endforeach
                    </select>
                    </span>
                    <span style="display: inline-block;padding: 2px">Секция:
                        <select style="width:300px;" data-type="select" name="section" class="form-control  column-filter" id ='section'>
                        <option {{!request('section')?'selected="selected"':''}}   value="" >Все секции</option>
                        @foreach($sections as $key => $value)
                            <option data-main="{{$value['sub_topic']['menu_group_id']}}" data-parent="{{$value['parent_id']}}" value="{{$value['id']}}" {{request('section') == $value['id']?'selected="selected"':''}}>{{$value['title']}}</option>
                        @endforeach
                    </select>
                    </span>

                    <span style="display: inline-block;padding: 2px">За:
                        <select style="width:150px;" data-type="select" name="period" class="form-control input-select column-filter ">
                        <option {{!request('group')?'selected="selected"':''}}   value="" >Не Указан</option>
                        @foreach($period as $key => $value)
                            <option value="{{$key}}" {{request('period') == $key?'selected="selected"':''}}>{{$value}}</option>
                        @endforeach
                    </select>
                    </span>
                    <span style="display: inline-block;padding: 2px">Сесии:
                        <select style="width:60px;" data-type="select" name="session" class="form-control input-select column-filter ">
                        @foreach($session as $key => $value)
                            <option value="{{$key}}" {{request('session') == $key ||(!request('session')&&$loop->index == 0 )?'selected="selected"':''}}>{{$value}}</option>
                        @endforeach
                    </select>
                    </span>
                    <span style="display: inline-block;padding: 2px">Актив:
                        <select style="width:150px;" data-type="select" name="active" class="form-control input-select column-filter ">
                        @foreach($active as $key => $value)
                            <option value="{{$key}}" {{request('active') == $key ||(!request('active')&&$loop->index == 0 )?'selected="selected"':''}}>{{$value}}</option>
                        @endforeach
                    </select>
                    </span>
                    <span style="display: inline-block;padding: 2px">Улучшения:
                        <select style="width:200px;" data-type="select" name="improvements" class="form-control input-select column-filter ">
                        <option {{!request('improvements')?'selected="selected"':''}}   value="" >Любые объявления</option>
                        @foreach($improvements as $key => $value)
                            <option value="{{$key}}" {{request('improvements') == $key?'selected="selected"':''}}>{{$value}}</option>
                        @endforeach
                    </select>
                    </span>
                    <span style="display: inline-block;padding: 2px">Модерация:
                        <select style="width:170px;" data-type="select" name="moderation" class="form-control input-select column-filter ">
                        <option {{!request('moderation')?'selected="selected"':''}}   value="" >Все</option>
                        @foreach($moderation as $key => $value)
                            <option value="{{$key}}" {{request('moderation') == $key?'selected="selected"':''}}>{{$value}}</option>
                        @endforeach
                    </select>
                    </span>
                    <span style="display: inline-block;padding: 2px">Бан по словам:
                        <select style="width:190px;" data-type="select" name="words_ban" class="form-control input-select column-filter ">
                        <option {{!request('words_ban')?'selected="selected"':''}}   value="" >Все</option>
                        @foreach($wordsBan as $key => $value)
                            <option value="{{$key}}" {{request('words_ban') == $key?'selected="selected"':''}}>{{$value}}</option>
                        @endforeach
                    </select>
                    </span>

                </div>
                <div style="">
                    <input style="width: 200px;display: inline-block; margin-bottom: 4px" type="text" data-type="text" value="{{request('email')}}" name="email" placeholder="По Email" class="email_search form-control column-filter">
                    <input style="width: 200px;display: inline-block; margin-bottom: 4px" type="text" data-type="text" value="{{request('number')}}" name="number" placeholder="По Телефону" class="email_search form-control column-filter">
                    <input style="width: 200px;display: inline-block; margin-bottom: 4px" type="text" data-type="text" id="sesid" value="{{request('session_id')}}" name="session_id" placeholder="По SES" class="email_search form-control column-filter">
                    <input style="width: 200px;display: inline-block; margin-bottom: 4px" type="text" data-type="text" value="{{request('name')}}" name="name" placeholder="По Имени" class="email_search form-control column-filter">
                    <input style="width: 200px;display: inline-block; margin-bottom: 4px" type="text" data-type="text" value="{{request('ip')}}" name="ip" placeholder="По IP" class="email_search form-control column-filter">
                    <input style="width: 200px;display: inline-block; margin-bottom: 4px" type="text" data-type="text" value="{{request('id')}}" name="id" placeholder="По ID" class="email_search form-control column-filter">
                    <input style="width: 200px;display: inline-block; margin-bottom: 4px" type="text" data-type="text" value="{{request('text')}}" name="text" placeholder="По Тексту" class="email_search form-control column-filter">
                    <input style="width: 200px;display: inline-block; margin-bottom: 4px" type="text" data-type="text" value="{{request('user_id')}}" name="user_id" placeholder="По ID пользователя" class="email_search form-control column-filter">
                </div>

            <div data-index="7">
                <div class="btn-group">
                    <button  id="bntSub" data-type="control" id="filters-exec" class="btn btn-sm btn-primary column-filter">
                        Фильтр
                    </button>
                    <a href="{{url()->current()}}"  class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>


                </div>
            </div>
        </div>
        </form>


<script>
  function  setSesID(id)
    {
        event.preventDefault()
       document.getElementById('sesid').value = id;
       document.getElementById('bntSub').click();

    }

    function showSubCategoies(id) {
      if (!id)
      {
          $('select[data-type="select"] option').show()
          return true
      }

        $('select[data-type="select"] option').hide()
        $('#section').show()
       if (id<10000) {
          $('select[data-type=\"select\"] option[ data-parent=' + id + ']').show()

      }
      else {
          id = id-10000
          $('select[data-type=\"select\"] option[ data-main=' + id + ']').show()
      }

    }

</script>


