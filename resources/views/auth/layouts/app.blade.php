<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JeziorCMS') }}</title>

    <!-- Styles -->
    <link href="/css/cms.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = '<?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>';
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/jezior-cms') }}">
                        {{ config('app.name', 'JeziorCMS') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @if(!Auth::guest())

            <div id="leftAdminMenu" class="{{ Auth::user()->display_menu == 1 ? 'expanded' : 'compressed' }}">
                <ul>
                    <a href="#" id="toggleLeftNavigation"><li><span class="glyphicon {{ Auth::user()->display_menu == 1 ? 'glyphicon-chevron-left' : 'glyphicon-chevron-right' }}"></span> Collapse Menu</li></a>
                    <a href="/{{$segments[0]}}" id="closeNavigation" class="{{empty($segments[1]) ? 'active': ''}}"><li><span class="glyphicon glyphicon-home"></span> Dashboard</li></a>
                    @if(isset($plugins) && !empty($plugins[0]))
                        @foreach($plugins as $plugin)
                            <a href="/{{$segments[0]}}/{{$plugin->cms_permalink}}" id="closeNavigation" class="{{isset($segments[1]) && $segments[1] == $plugin->cms_permalink ? 'active': ''}}"><li><span class="glyphicon glyphicon-{{ $plugin->icon }}"></span> {{ $plugin->title }}</li></a>
                        @endforeach
                    @endif
                </ul>

                <ul id="settings">
                    <a href="#" id="closeNavigation"><li><span class="glyphicon glyphicon-wrench"></span> Settings</li></a>
                    <a href="#" id="closeNavigation"><li><span class="glyphicon glyphicon-user"></span> CMS Users</li></a>
                    <a href="#" id="closeNavigation"><li><span class="glyphicon glyphicon-list-alt"></span> Access Log</li></a>
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ URL::to('js/cms.js') }}"></script>
    <script src="{{ URL::to('js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL::to('js/tinymce/jquery.tinymce.min.js') }}"></script>

    <script>
	    tinymce.init({
		    selector: 'textarea.wysiwyg',
		    height: 500,
		    theme: 'modern',
		    plugins: [
			    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			    'searchreplace wordcount visualblocks visualchars code fullscreen',
			    'insertdatetime media nonbreaking save table contextmenu directionality',
			    'emoticons template paste textcolor colorpicker textpattern imagetools toc'
		    ],
		    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	        file_browser_callback_types: 'image',
	        file_picker_types: 'image',
	        file_picker_callback: function(callback, value, meta) {
		        if (meta.filetype == 'image') {
			        $('#upload').trigger('click');
			        $('#upload').on('change', function() {
				        var file = this.files[0];
				        var reader = new FileReader();
				        reader.onload = function(e) {
					        callback(e.target.result, {
						        alt: ''
					        });
				        };
				        reader.readAsDataURL(file);
			        });
		        }
	        }
	    });
    </script>

    @yield('extra_script')

</body>
</html>
