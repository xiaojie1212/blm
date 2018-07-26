<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">小杰</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            @auth
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/">首页 <span class="sr-only">(current)</span></a></li>

                    <li><a href="{{route('user.index')}}">店铺详情管理</a></li>
                    <li><a href="{{route('menucate.index')}}">菜品分类管理</a></li>
                    <li><a href="{{route('menu.index')}}">菜品管理</a></li>
                    <li><a href="{{route('user.act')}}">正在进行的活动</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">别点 <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">其他</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{\Illuminate\Support\Facades\Auth::user()->name}} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('user.logout')}}">注销</a></li>
                        </ul>
                    </li>
                </ul>
            @endauth

            @guest
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{route('user.login')}}">登录</a></li>
                </ul>
            @endguest


        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>