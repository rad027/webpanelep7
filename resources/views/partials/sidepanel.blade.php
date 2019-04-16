        @if(Auth::guest())
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">LOGIN :</h3>
            </div>
            <div class="box-body">
                <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                    {!! csrf_field() !!}

                    <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                               placeholder="Enter your username.">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                        <input type="password" name="password" class="form-control"
                               placeholder="{{ trans('adminlte::adminlte.password') }}">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="remember"> {{ trans('adminlte::adminlte.remember_me') }}
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <button type="submit"
                                    class="btn btn-primary btn-block btn-flat">{{ trans('adminlte::adminlte.sign_in') }}</button>
                        </div>
                        <!-- /.col -->
                        <div class="auth-links col-md-12">
                            <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}"
                               class="text-center"
                            >{{ trans('adminlte::adminlte.i_forgot_my_password') }}</a>
                            <br>
                            @if (config('adminlte.register_url', 'register'))
                                <a href="{{ url(config('adminlte.register_url', 'register')) }}"
                                   class="text-center"
                                >{{ trans('adminlte::adminlte.register_a_new_membership') }}</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @else
        <div class="box">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="@if (Auth::user()->profile()->count() && Auth::user()->profile()->first()->avatar_status == True) {{ Auth::user()->profile()->first()->avatar }} @else {{ Gravatar::get(Auth::user()->email) }} @endif" alt="User profile picture">

                <h3 class="profile-username text-center">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}[{{ Auth::user()->name }}]</h3>

                <p class="text-muted text-center">{{ Auth::user()->roles()->first()->name }}</p>

                <ul class="list-group list-group-unbordered">
                    @if(Auth::user()->isUser())
                    <li class="list-group-item">
                        <b>Vote Points</b> <a class="pull-right">{{ number_format(Auth::user()->points()->first()->Vpoints,2) }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>E-Points</b> <a class="pull-right">{{ number_format(Auth::user()->points()->first()->points,2) }}</a>
                    </li>
                    @endif
                    <li class="list-group-item">
                        <b>Email</b> <a class="pull-right">{{ Auth::user()->email }}</a>
                    </li>
                </ul>
                @if(Auth::user()->isUnverified())
                <a class="btn btn-primary btn-block disabled"><b>NEED ACTIVATION!</b></a>
                @else
                <a href="{{ url('home') }}" class="btn btn-primary btn-block"><b>DASHBOARD</b></a>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        @endif
        @if(\Request::route()->getName() == "shop" || \Request::route()->getName() == "shop2")
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">CATEGORY</h3>
            </div>
            <div class="box-body" style="padding: 0px">
                <ul class="nav nav-pills nav-stacked">
                  <li @if(Request::is('shop')) class="active" @endif><a href="{{ url('shop') }}">ALL</a></li>
                  <li @if(Request::is('shop/category/1')) class="active" @endif ><a href="{{ url('shop/category/1') }}">Weapons</a></li>
                  <li @if(Request::is('shop/category/2')) class="active" @endif ><a href="{{ url('shop/category/2') }}">Accessories</a></li>
                  <li @if(Request::is('shop/category/3')) class="active" @endif ><a href="{{ url('shop/category/3') }}">Costumes</a></li>
                  <li @if(Request::is('shop/category/4')) class="active" @endif ><a href="{{ url('shop/category/4') }}">Pet System</a></li>
                  <li @if(Request::is('shop/category/5')) class="active" @endif ><a href="{{ url('shop/category/5') }}">EXP</a></li>
                  <li @if(Request::is('shop/category/6')) class="active" @endif ><a href="{{ url('shop/category/6') }}">Cards</a></li>
                  <li @if(Request::is('shop/category/7')) class="active" @endif ><a href="{{ url('shop/category/7') }}">Enhancements</a></li>
                </ul>
            </div>
        </div>
        @endif

        @if(\Request::route()->getName() != "ranking")
        {{-- TOP KILLER --}}
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">TOP KILLER</h3>
            </div>
            <div class="box-body">
                @if($char->count())
                    <table class="table" cellpadding="0" style="padding: 0px">
                        @php
                            $i=0;
                        @endphp
                        @foreach($char->with('info')->orderBy('ChaPkWin','desc')->orderBy('ChaPkLoss','asc')->take(20)->get() as $top)
                            @if($i==5)
                                @php
                                    break;
                                @endphp
                            @else
                                @if($top->info->count() && $top->info->first()->UserType == 1)
                                    <tr class="bg-gray">
                                        <td style="vertical-align:middle;text-align: left;">
                                            <div class="icon c{{ $top->ChaClass }}"></div>
                                        </td>
                                        <td style="vertical-align:middle;text-align: left;">
                                            <span><b>{{ $top->ChaName }}</b></span><br>
                                            <span class="label label-warning">LEVEL : {{ $top->ChaLevel }}</span>&nbsp;
                                            <span class="label label-primary">KILLS : {{ $top->ChaPkWin }}</span>&nbsp;
                                            <span class="label label-danger">
                                                @if($top->ChaSchool == 0)
                                                Sacred Gate
                                                @elseif($top->ChaSchool == 1)
                                                Mystic Peak
                                                @else
                                                Phoenix
                                                @endif      </span>
                                            {{--<span class="label label-danger">DEATH : {{ $top->ChaPKLoss }}</span>--}}
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endif
                            @endif
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
        @endif