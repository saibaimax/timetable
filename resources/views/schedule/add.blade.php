@extends('layouts.app')
@section('content')
<div class="container" style="margin-top: 10px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading" style="text-align: center">
                    {{ config('time.' . $day_id) }} 授業登録
                </div>
                
                <div class="panel-body">
                    <div class="already_classes">
                        <!--<div class="list-group">-->
                        <ul class="list-group">
                            <a class="list-group-item" data-toggle="collapse" href="#new_class">
                                <span class="text-center">
                                    <p>自分の授業がない場合は</p>
                                    <p>こちらをクリックしてください。</p>
                                </span>
                                <i class="fas fa-plus" style="font-size:20px;margin:0% 48%"></i>
                            </a>
                            <div class="collapse" id="new_class">
                                <div class="well">
                                    <span class="text-center">
                                        <p>新しく授業を登録しましょう！</p>
                                        <p>※登録した授業は</p>
                                        <p>他の学生も登録できるようになります。</p>
                                    </span>
                                    <form class="form-horizontal" method="POST" action="{{ route('class.update', ['id' => $day_id]) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}

                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label for="name" class="col-md-4 control-label">授業名</label>

                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control" name="name" required autofocus>

                                                @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('room_number') ? ' has-error' : '' }}">
                                            <label for="room_number" class="col-md-4 control-label">教室</label>

                                            <div class="col-md-6">
                                                <input id="room" type="text" class="form-control" name="room_number" required>

                                                @if ($errors->has('room_number'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('room_number') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('teacher') ? ' has-error' : '' }}">
                                            <label for="teacher" class="col-md-4 control-label">担当教員</label>

                                            <div class="col-md-6">
                                                <input id="teacher" type="text" class="form-control" name="teacher" required>

                                                @if ($errors->has('teacher'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('teacher') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    登録する
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="panel-body" style="text-align: center">
                                @if ($classes->isNotEmpty())
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50%">授業名</th>
                                                <th class="text-center" style="width: 30%">登録者</th>
                                                <th style="width: auto"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($classes as $class)
                                                <tr>
                                                    <th>
                                                        <p class="list-group-item-heading">{{ $class->name }}</p>
                                                        <i class="fas fa-user fa-fw" style="color: skyblue;"></i>{{ $class->teacher }}・
                                                        <i class="fas fa-university fa-fw" style="color: skyblue;"></i>{{ $class->room_number }}
                                                    </th>
                                                    <td>
                                                        {{ $class->count }}人
                                                    </td>
                                                    <td class="text-right">
                                                        <form class="form-horizontal" method="POST" action="{{ route('schedules.store') }}">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" value="{{ $class->id }}" name="id">
                                                            <button class="btn btn-primary" type='submit' style="appearance: none;border:none;">
                                                                <span class="glyphicon glyphicon-plus" style="font-size: 25px" aria-hidden="true"></span>
                                                                選択
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $classes->appends(['id' => $day_id])->links() }}
                                @else
                                    <p>現在登録されている授業はありません。</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection