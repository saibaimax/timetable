@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="margin-bottom:10px">
                <div class="panel-heading">学科選択</div>

                <div class="panel-body">
                    
                    <div class="form-group{{ $errors->has('school') ? ' has-error' : '' }}">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                <p>{{ session('error') }}</p>
                            </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                            </div>
                        @endif 
                        <div class="col-md-6">
                            @if (session('error'))
                            <p class="alert alert-danger">{{ session('error') }}</p>
                            @endif
                            <form action="{{ route('register') }}" method="GET">
                                <select name="subject_id" class="form-control">
                                    @foreach ($classes as $class => $value)
                                    <option value="{{$class}}">{{$value}}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary btn-block" type="submit">
                                    次へ
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