<div class="sidebar" data-color="orange">
    <div class="logo">
        <center>
            <img class="simple-text logo-normal" src="{{ asset('material/img/backend-logo.png') }}" width="100%">
            </img>
        </center>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="user-info">
                <a class="username text-center" data-toggle="collapse" href="#collapseExample">
                    <center>
                        <span class="font-weight-bold">
                            {{ auth()->user()->name }} {{ auth()->user()->app_name }}
                            {{ auth()->user()->apm_name }}
                        </span>
                    </center>
                </a>
            </div>
        </div>
        <ul class="nav">
            @for ($i = 0; $i < count($menus); $i++)
                @foreach ($menus[$i] as $menu) <li
                class="nav-item{{ $activePage == $menu->name_modulo ? ' active' : '' }}">
                <a class="nav-link" href="{{ url($menu->ruta) }}">
                <i class="material-icons">{{ $menu->icono }}</i>
                <p>{{ __($menu->name_modulo) }}</p>
                </a>
                </li> @endforeach
            @endfor
            <li class="nav-item mt-5">
                <a class="nav-link">
                    <i class="material-icons"></i>
                </a>
            </li>
        </ul>
    </div>
</div>