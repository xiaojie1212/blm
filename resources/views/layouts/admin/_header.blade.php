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

                @auth('admin')
                <ul class="nav navbar-nav">

                    <li><a href="{{route('admin.index')}}">平台用户管理</a></li>
                    <li><a href="{{route('shop.index')}}">商户信息管理</a></li>
                    <li><a href="{{route('admin.userIndex')}}">商户账号管理</a></li>
                    <li><a href="{{route('activity.index')}}">活动管理</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">订单管理<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('orders.index')}}">所有订单</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('orders.day')}}">每日订单</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('orders.month')}}">每月订单</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">菜品订单管理<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('orders.menuDay')}}">菜品每日订单</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('orders.menuMonth')}}">菜品每月订单</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{\Illuminate\Support\Facades\Auth::guard('admin')->user()->name}} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('admin.logout')}}">注销</a></li>
                        </ul>
                    </li>
                </ul>

                @endauth

                @guest('admin')
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{route('admin.login')}}">登录</a></li>
                    </ul>
                @endguest



        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>