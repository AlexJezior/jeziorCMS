@extends('auth.layouts.app')

@section('content')
    <div id="adminContent">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>
                    {{ isset($item) && !empty($item) ? 'Edit' : 'Add' }} Page
                    <a class="btn btn-sm btn-warning pull-right" href="/{{$segments[0]}}/{{$segments[1]}}">&laquo;Back</a>
                </h3>
            </div>

            <div class="panel-body">
                <div class="panel-heading">
                    <p class="well">This is a form for modifying pages throughout your site. Here you can alter
                                    the page title, permalink, meta data, content, and layout!</p>
                </div>
                <div class="col-xs-12">
                    @if(isset($messages) && !empty($messages))
                        @foreach($messages as $message)
                            <span class="col-xs-12 {{ $status == "error" ? 'alert-danger': 'alert-success' }}">{{ $message }}</span>
                        @endforeach
                    @endif
                </div>

                <form class="col-sm-12 pages__form" method="POST" action="{{ $_SERVER['REQUEST_URI'] }}" data-item-id="{{ isset($item) && !empty($item) ? $item['id'] : 0 }}">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <input type="submit" class="btn btn-default pull-right" value="Save"/>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="title">Page Title *</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ toggle_value((isset($_POST['title']) ? $_POST['title'] : ''),(isset($item['title']) ? $item['title'] : '')) }}" required/>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="permalink">Page Permalink *</label>
                            <a href="#" class="pull-right" data-toggle="tooltip" title="Permalinks are hyphenated words describing a page.&#013; (ex: http://YourSite.com/the-page-permalink)"><span class="glyphicon glyphicon-info-sign"></span></a>
                            <input type="text" class="form-control" name="permalink" id="permalink" value="{{ toggle_value((isset($_POST['permalink']) ? $_POST['permalink'] : ''),(isset($item['permalink']) ? $item['permalink'] : '')) }}" required/>
                        </div>
                    </div>

                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="collapsible" data-toggle="collapse" href="#meta_data">
                                    <h4 class="panel-title">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                        Meta Information
                                        <span class="glyphicon glyphicon-cloud pull-right"></span>
                                    </h4>
                                </a>
                            </div>
                            <div id="meta_data" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="form-group col-sm-6">
                                        <label for="meta_title">Meta Title</label>
                                        <a href="#" class="pull-right" data-toggle="tooltip" title="Controls the title tag of a page.&#013; Altering the title in the browsers tab, &#013; to the title of the page in search result."><span class="glyphicon glyphicon-info-sign"></span></a>
                                        <input type="text" class="col-sm-12 form-control" name="meta_title" id="meta_title" value="{{ toggle_value((isset($_POST['meta_title']) ? $_POST['meta_title'] : ''),(isset($item['meta_title']) ? $item['meta_title'] : '')) }}"/>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="meta_keywords">Meta Keywords</label>
                                        <a href="#" class="pull-right" data-toggle="tooltip" title="The keywords this page will rank for in search engines."><span class="glyphicon glyphicon-info-sign"></span></a>
                                        <input type="text" class="col-sm-12 form-control" name="meta_keywords" id="meta_keywords" value="{{ toggle_value((isset($_POST['meta_keywords']) ? $_POST['meta_keywords'] : ''),(isset($item['meta_keywords']) ? $item['meta_keywords'] : '')) }}"/>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="meta_description">Meta Description</label>
                                        <a href="#" class="pull-right" data-toggle="tooltip" title="The description of the page displayed to search engines."><span class="glyphicon glyphicon-info-sign"></span></a>
                                        <textarea class="col-sm-12 form-control" name="meta_description" id="meta_description" rows="3">{{ toggle_value((isset($_POST['meta_description']) ? $_POST['meta_description'] : ''),(isset($item['meta_description']) ? $item['meta_description'] : '')) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-heading">
                                <a class="collapsible" data-toggle="collapse" href="#page_settings">
                                    <h4 class="panel-title">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                        Settings
                                        <span class="glyphicon glyphicon-cog pull-right"></span>
                                    </h4>
                                </a>
                            </div>
                            <div id="page_settings" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="form-group col-sm-3">
                                        <h5><strong style="text-decoration: underline;">Page Type</strong></h5>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" style="" name="type" id="type" value="master" {{ toggle_selected((isset($_POST['type']) ? $_POST['type'] : ''),(isset($item['type']) ? $item['type'] : ''), "master", TRUE, "checked") }} />
                                                Master
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="type" id="type" value="orphan" {{ toggle_selected((isset($_POST['type']) ? $_POST['type'] : ''),(isset($item['type']) ? $item['type'] : ''), "orphan", FALSE, "checked") }} />
                                                Orphan
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-9">
                                        <label for="parent_id">Page Belongs To</label>
                                        <select class="form-control" name="parent_id" id="parent_id">
                                            <option value="0" {{ toggle_selected((isset($_POST['parent_id']) ? $_POST['parent_id'] : ''),(isset($item['parent_id']) ? $item['parent_id'] : ''), "0", TRUE) }}>
                                                MAIN NAVIGATION
                                            </option>
                                            @foreach($pages as $page)
                                                <option value="{{ $page['id'] }}" {{ toggle_selected((isset($_POST['parent_id']) ? $_POST['parent_id'] : ''),(isset($item['parent_id']) ? $item['parent_id'] : ''), $page['id']) }}>{{ $page['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="content">Page Content *</label>
                        <!--Hidden uploader required for the TinyMCE image uploads-->
                        <input name="image" type="file" id="upload" class="hidden" onchange="">
                        <textarea class="col-sm-12 wysiwyg" name="content" id="content" rows="10">
                            {{ toggle_value((isset($_POST['content']) ? $_POST['content'] : ''),(isset($item['content']) ? $item['content'] : '')) }}
                        </textarea>
                    </div>

                    <div class="form-group col-sm-12">
                        <input type="submit" class="btn btn-default" value="Save"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@section('extra_script')
    <script>
	    $(function(){

	    	if( $('.pages__form').length > 0 ){

                var permalinkInput = $('input[name="permalink"]');
                 if(permalinkInput.val() === ""){

                 	$('input[name="title"]').on('change', function(){

	                    if(permalinkInput.val() === ""){
	                        var newPermalink = $(this).val();
	                        newPermalink = newPermalink.replace(/[^0-9a-z ]/gi, '');
	                        var re = new RegExp(' ', 'g');
	                        newPermalink = newPermalink.replace(re, '-');
	                        permalinkInput.val(newPermalink.toLowerCase());
                        }

                    });

                 }

		       var collapsible = $('.collapsible');
		       if (collapsible.length > 0){
			       collapsible.on('click', function(){
				       var gIcon = $('.glyphicon:first-of-type', this);
				       gIcon.toggleClass('glyphicon-chevron-right').toggleClass('glyphicon-chevron-down');
			       });
		       }

		       var page_type = $('input[name="type"]');
		       if (page_type.length > 0){
			       //Selector we will be modifying
			       var selector = $('select#parent_id');

			       //Check defaults
			       if ($('input[value="orphan"]').is(':checked')){
				       //Disable parent selector.
				       selector.addClass('disabled').attr("disabled", true);
			       }

			       //On radio button change
			       page_type.on('change', function(){
				       var newValue = $(this).val();
				       if (newValue == "orphan"){
					       //Disable parent selector.
					       selector.addClass('disabled').val('0').attr("disabled", true);
				       } else {
					       //Enable Parent Selector
					       selector.removeClass('disabled').attr("disabled", false);
				       }
			       });
		       }

            }

	    });
    </script>
@endsection