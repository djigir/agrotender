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
<?php
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

?>

<form method="GET">
    <div class="display-filters-top table table-default display-filters">
        <div data-index="0">
            <select data-type="select" name="paginate" class="form-control input-select column-filter">
                <option @if(request('paginate') == 0) selected="selected" @endif value="0">Показать по</option>
                <option @if(request('paginate') == 25) selected="selected" @endif value="25">25</option>
                <option @if(request('paginate') == 50) selected="selected" @endif value="50">50</option>
                <option @if(request('paginate') == 100) selected="selected" @endif value="100">100</option>
            </select>
        </div>

        <div data-index="1">
            <select style="width:200px;" data-type="select" name="region" class="form-control input-select column-filter " data-select2-id="1" tabindex="-1" aria-hidden="true">
                <option {{!request('region')?'selected="selected"':''}}   value="" >Все области</option>
                @foreach($regions as $key => $region)
                    <option value="{{$key}}" {{request('region') == $key?'selected="selected"':''}}   >{{$region}}</option>
                @endforeach
            </select>
        </div>

        <div data-index="2">
            <select  data-type="select" name="ad" class="form-control input-select column-filter">
                <option {{!request('ad')?'selected="selected"':''}}   value="" >Все типы</option>
                @foreach($ad_types as $key => $value)
                    <option value="{{$key}}" {{request('ad') == $key?'selected="selected"':''}}   >{{$value}}</option>
                @endforeach
            </select>
        </div>

        <div data-index="3">
            <select style="width: 180px" data-type="select" name="group" class="form-control input-select column-filter " onchange="showSubCategoies(this.value)">
                <option {{!request('group')?'selected="selected"':''}}   value="" >Все разделы</option>
                @foreach($groupFilter as $key => $value)
                    <option value="{{$key}}" {{request('group') == $key?'selected="selected"':''}} >@if($key<10000)&nbsp;&nbsp;&nbsp;@endif  {{$value}}</option>
                @endforeach
            </select>
        </div>

        <div data-index="4">
            <select data-type="select" name="active" class="form-control input-select column-filter">
                @foreach($active as $key => $value)
                    <option value="{{$key}}" {{request('active') == $key ||(!request('active')&&$loop->index == 0 )?'selected="selected"':''}}>{{$value}}</option>
                @endforeach
            </select>
        </div>

        <div data-index="5">
            <select  data-type="select" name="improvements" class="form-control input-select column-filter">
                <option {{!request('improvements')?'selected="selected"':''}}  value="" >Любые</option>
                @foreach($improvements as $key => $value)
                    <option value="{{$key}}" {{request('improvements') == $key?'selected="selected"':''}}>{{$value}}</option>
                @endforeach
            </select>
        </div>

        <div data-index="6">
            <input type="text" data-type="text" value="{{request('email')}}" name="email" placeholder="Email" class="form-control column-filter">
        </div>

        <div data-index="7">
            <input type="text" data-type="text" value="{{request('number')}}" name="number" placeholder="Телефону" class="form-control column-filter">
        </div>

        <div data-index="8">
            <input type="text" data-type="text" value="{{request('author')}}" name="author" placeholder="Автор" class="form-control column-filter">
        </div>

        <div data-index="9">
            <input type="text" style="width: 90px" data-type="text" value="{{request('id')}}" name="id" placeholder="ID" class="form-control column-filter">
        </div>

        <div data-index="10">
            <input type="text" data-type="text" value="{{request('title')}}" name="title" placeholder="Название" class="form-control column-filter">
        </div>

        <div data-index="11">
            <div class="btn-group">
                <button  id="bntSub" data-type="control" class="btn btn-sm btn-primary column-filter" onclick="localStorage.clear()">
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


