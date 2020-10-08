@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-success">{{session('error')}}</div>
            @endif
            <input id="lefile" type="file" style="display:none">
            <div class="panel panel-primary">
                <div class="panel-heading" style="text-align:center">
                    {{ config($pref_id . '.' . $university_id .'.name') }}の全体掲示板
                </div>
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="list-group" style="text-align:center;">
                            <a class="list-group-item" href="{{ route('threads.show', ['id' => $i]) }}">
                                <p class="list-group-item-heading" style="font-size:16px">{{ config('thread.' . $i . '.name') }}</p>
                                <p style="font-size:11px">{{ config('thread.' . $i . '.detail') }}</p>
                            </a>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
@endsection