@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="margin-bottom:10px">
                <div class="panel-heading">学部選択</div>

                <div class="panel-body">
                    <div class="form-group{{ $errors->has('school') ? ' has-error' : '' }}">
                        <div class="col-md-6">
                            @if (session('error'))
                            <p class="alert alert-danger">{{ session('error') }}</p>
                            @endif
                            <form action="{{ route('select.class') }}" method="get">
                                <select name="fuculty_id" class="form-control">
                                    @foreach ($fuculties['fuculty'] as $fuculty => $value)
                                    <option value="{{$fuculty}}">{{$value}}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary btn-block" type="submit">
                                    学科選択に進む
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="{{ route('login') }}">
                    ログインはこちら
                </a>
            </div>
        </div>
    </div>
</div>
@endsection