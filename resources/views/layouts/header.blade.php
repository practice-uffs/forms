<header id="header" class="header fixed-top">
    <div class="container-lg d-flex align-items-center justify-content-between">
        <a href="{{ route('index') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('img/logo-practice.png') }}" alt="">
            <span>Forms</span>
        </a>

        <nav id="navbar" class="navbar">
            <ul>
                @auth
                    <li><a href="{{ route('home') }}" class="nav-link @if (Route::is('home')) active @endif" >Minhas criações</a></li>
                    <li class="dropdown ml-3">
                        <a href="{{ route('form.create') }}"><div tabindex="0" class="btn btn-primary btn-outline">Nova enquete</div></a>
                    </li>                    

                    @admin
                        <li class="dropdown ml-3">
                            <div tabindex="1" class="btn btn-primary btn-outline">Admin <i class="bi bi-chevron-down"></i></div>
                            <ul class="shadow menu dropdown-content bg-base-100 rounded-box w-52">
                                <li><a href="{{ route('admin.user') }}">Usuários</a></li> 
                                <li><a href="{{ route('admin.subscriber') }}">Newsletter</a></li>
                            </ul>
                        </li>
                    @endadmin

                    <li class="ml-8 mr-2 text-right">
                        <p class="font-semibold">{{ auth()->user()->first_name }}</p>
                        <p class="text-xs font-extralight -mt-1 text-gray-400">{{ auth()->user()->username }}</p>
                    </li>

                    <li class="flex-none">
                        <div class="avatar">
                            <div class="rounded-full w-10 h-10 m-1">
                                <img src="https://cc.uffs.edu.br/avatar/iduffs/{{ auth()->user()->uid }}" />
                            </div>
                        </div>
                    </li>

                    <li>
                        <a href="{{ route('logout') }}">Sair</a>
                    </li>
                @endauth
                
                @guest
                    <li><a href="{{ route('form.create') }}" class="nav-link @if (Route::is('form.create')) active @endif">Nova enquete</a></li>
                    <li><a href="{{ route('login') }}" class="getstarted">Entrar <i class="bi bi-box-arrow-in-right"></i></a></li>
                @endguest
            </ul>
        </nav>

    </div>
</header>