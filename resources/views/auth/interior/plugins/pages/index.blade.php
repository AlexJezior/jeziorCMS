@extends('auth.layouts.app')

@section('content')
<div id="adminContent">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Pages <a class="btn btn-sm btn-success pull-right" href="/{{$segments[0]}}/{{$segments[1]}}/modify">&plus;Add New Page</a><a class="btn btn-sm btn-info pull-right" href="/{{$segments[0]}}">&raquo;Back</a></h3>
        </div>

        <div class="panel-body">
            <div class="panel-heading text-center">
                Pages manageable through Jezior CMS.
            </div>

            <div class="col-xs-12">
                @if(session('messages'))
                    @foreach(session('messages') as $message)
                        <span class="col-xs-12 {{ session('status') == "error" ? 'alert-danger': 'alert-success' }}">{{ $message }}</span>
                    @endforeach
                @endif
            </div>

            <div class="modal-header row">
                <div class="col-sm-5">
                    <span>Page Title</span>

                </div>
                <div class="col-sm-5">
                    <span>Permalink</span>
                </div>
                <div class="col-sm-2">
                    <span>Modify</span>
                </div>
            </div>
            <div class="modal-body">
                @if(isset($pages) && !empty($pages[0]))
                    @foreach($pages as $page)
                        <div class="col-sm-5">
                            {{ $page->title }}
                        </div>
                        <div class="col-sm-5">
                            <a href="/{{ $page->permalink }}" target="_blank">/{{ $page->permalink }}</a>
                        </div>
                        <div class="col-sm-2">
                            <a href="/{{$segments[0]}}/{{$segments[1]}}/modify/{{ $page->id }}" title="Edit">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="/{{$segments[0]}}/{{$segments[1]}}/delete/{{ $page->id }}" title="Delete">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="col-sm-12">
                        <span>No pages exist yet.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection