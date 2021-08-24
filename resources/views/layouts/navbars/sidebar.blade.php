<div class="sidebar" data-color="orange">
    <div class="logo">
        <img class="simple-text logo-normal" src="{{asset('material/img/multioillogone.png')}}" width="100%"></img>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="user-info">
                <a class="username text-white text-center" data-toggle="collapse" href="#collapseExample">
                    <span class="font-weight-bold">
                        {{ auth()->user()->name }} {{ auth()->user()->app_name }}
                        {{ auth()->user()->apm_name }}
                    </span>
                </a>
            </div>
        </div>
        <ul class="nav">
            @for ($i = 0; $i < count($menus); $i++)
                @foreach ($menus[$i] as $menu) 
                    <li class="nav-item {{ $activePage == $menu->name_modulo ? 'active wavemenu' : '' }}">
                        @if (auth()->user()->roles->first()->id==2 && $menu->ruta=='getshopping')
                            <a class="nav-link" href="{{ route($menu->ruta,auth()->user()->company_id) }}">
                                <i class="material-icons text-{{$menu->color}}">{{ $menu->icono }}</i>
                                <p>{{ __($menu->name_modulo) }}</p>
                            </a>
                        @elseif (auth()->user()->roles->first()->id==3 && $menu->ruta=='getcommision')
                            <a class="nav-link" href="{{ route($menu->ruta,auth()->user()->id) }}">
                                <i class="material-icons ">{{ $menu->icono }}</i>
                                <p>{{ __($menu->name_modulo) }}</p>
                            </a>
                        @else
                            <a class="nav-link" href="{{ url($menu->ruta) }}">
                                <i class="material-icons ">{{ $menu->icono }}</i>
                                <p>{{ __($menu->name_modulo) }}</p>
                            </a>
                        @endif
                    </li> 
                @endforeach
            @endfor
            <li class="nav-item mt-5">
                <a class="nav-link">
                    <i class="material-icons"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
