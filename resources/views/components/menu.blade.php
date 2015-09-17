@if(Auth::user())
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Project <strong>Leave</strong></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    @if(Auth::user()->is_admin)
                        <li><a href="{{ route('users.index') }}">Users</a></li>
                    @endif
                    <li><a href="{{ route('leaves.index') }}">Leaves</a></li>
                    @if(Auth::user()->is_admin)
                        <li><a href="{{ route('leave-types.index') }}">Leave types</a></li>
                    @endif
                </ul>
                @if(Auth::user())
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                Hello, {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('auth.logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                @endif
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>
@endif
