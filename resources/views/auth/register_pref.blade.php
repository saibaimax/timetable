@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="margin-bottom:10px">
                <div class="panel-heading">大学所在地</div>

                <div class="panel-body">
                    <div class="form-group{{ $errors->has('pref') ? ' has-error' : '' }}">
                        <div class="col-md-6">
                            @if (session('error'))
                                <p class="alert alert-danger">{{ session('error') }}</p>
                            @endif
                            <form action="{{ route('select.university') }}">
                                <select name="pref_id" class="form-control">
                                    @foreach ($prefs as $key => $pref)
                                    <option value="{{$key}}">{{$pref}}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary btn-block" type="submit">
                                    大学選択に進む
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