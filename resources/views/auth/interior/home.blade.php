@extends('auth.layouts.app')

@section('content')
<div id="adminContent">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Dashboard</h3>
        </div>

        <div class="panel-body">
            <h3>Manage Plugins: </h3>
            <ul>
                @if(isset($plugins) && !empty($plugins[0]))
                    @foreach($plugins as $plugin)
                    <li><a href="/{{$segments[0]}}/{{$plugin->cms_permalink}}">{{$plugin->title}}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>

</div>
@endsection
