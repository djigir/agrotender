<?php
$tgroups = \App\Models\ADV\AdvTorgTgroups::orderBy('sort_num')->get();
$topics = \App\Models\ADV\AdvTorgTopic::orderBy('sort_num')->orderBy('title')->get();
?>

<div class="card-heading card-header">
    <a href="{{Request::url().'/create'}}" class="btn btn-primary btn-create">
        <i class="fas fa-plus"></i> Новая запись
    </a>
    <div class="pull-right block-actions"></div>
</div>
@foreach($tgroups as $tgroup)
    <div class="content body">
        <div class="card form-elements w-100">
            <div class="card-body">
                <div class="form-elements w-100">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                            {{$tgroup->title}}
                            <div style="margin-top: 15px;">
                                @foreach($topics->where('menu_group_id', $tgroup->id)->where('parent_id', 0) as $topic)
                                    <div style="margin-left: 50px; margin-bottom: 50px" class="form-elements">
                                        <span>{{$topic->title}}
                                            <div class="table-control-btn" style="margin-top: -25px; margin-right: 15px;">
                                                <a href="{{Request::url().'/'.$topic->id.'/edit'}}" class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                                   data-original-title="Редактировать">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </div>
                                        </span>
                                    </div>
                                    <div style="margin-bottom: 30px;">
                                        @foreach($topics->where('menu_group_id', $tgroup->id)->where('parent_id', $topic->id) as $topic_cult)
                                            <div style="margin-left: 120px; margin-bottom: 10px" class="form-elements">
                                                <span>{{$topic_cult->title}} ({{\App\Models\ADV\AdvTorgPost::where(['topic_id' => $topic_cult->id, 'archive' => 0, 'active' => 1])->count()}})</span>
                                            </div>
                                            <div class="table-control-btn" style="margin-top: 4px">
                                                <a href="{{Request::url().'/'.$topic_cult->id.'/edit'}}" class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                                   data-original-title="Редактировать">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-6">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
