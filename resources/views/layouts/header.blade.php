<header id="header" class="header fixed-top">
    <div class="container ml-0 mr-0 md:mr-auto md:ml-auto d-flex justify-content-between">
        <a href="{{ route('index') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('img/forms-icon.png') }}" alt="">
            <span>Forms</span>
        </a>

        <nav id="navbar" class="navbar">
            <ul>
                @auth
                    @if (@$layout_header_simplified == false)
                        <li><a href="{{ route('home') }}" class="nav-link @if (Route::is('home')) active @endif" >Minhas criações</a></li>
                        <li class="dropdown ml-3">
                            <a href="{{ route('form.create') }}">
                                <div tabindex="0" class="btn btn-primary color-background-form">
                                    Criar
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </a>
                        </li>                    
                    @endif

                    @admin
                        <li class="dropdown ml-3">
                            <div tabindex="1" class="btn btn-primary btn-outline">Admin <i class="bi bi-chevron-down"></i></div>
                            <ul class="shadow menu dropdown-content bg-base-100 rounded-box w-52">
                                <li><a href="{{ route('admin.user') }}">Usuários</a></li> 
                                <li><a href="{{ route('admin.subscriber') }}">Newsletter</a></li>
                            </ul>
                        </li>
                    @endadmin

                    
                    <li class="ml-8 mr-2 text-right d-flex align-items-center">
                        <div class="d-none d-md-block h-full">
                            <p class="font-semibold">{{ auth()->user()->first_name }}</p>
                            <p class="text-xs font-extralight -mt-1 text-gray-400">{{ auth()->user()->username }}</p>
                        </div>
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
                    @if (@$layout_header_simplified == false)
                        <li><a href="{{ route('form.create') }}" class="nav-link @if (Route::is('form.create')) active @endif">Criar</a></li>
                    @endif
                    
                    <li><a style="background-color: #264653" href="{{ route('login') }}" class="getstarted">Entrar <i class="bi bi-box-arrow-in-right"></i></a></li>
                @endguest
            </ul>
        </nav>

        <nav class="lg:invisible absolute w-full bg-white pb-4 pt-4">
            <div class="d-flex justify-content-between">
                <div class="float-left">
                    <a href="{{ route('index') }}" class="logo d-flex align-items-center">
                        <img src="{{ asset('img/forms-icon.png') }}" alt="">
                        <span>Forms</span>
                    </a>
                </div>
                <li class="dropdown mr-5">
                    <div style="background-color: #264653" tabindex="0" class="btn btn-primary"><i class="bi bi-chevron-down"></i></div>
                    <ul class="shadow menu dropdown-content bg-base-100 rounded-box w-52 float-right right-0 mt-2">
                        
                        @auth
                            @if (@$layout_header_simplified == false)
                                <li><a href="{{ route('home') }}" class="nav-link @if (Route::is('home')) active @endif" >Minhas criações ({{auth()->user()->username}})</a></li>
                                <li><a href="{{ route('form.create') }}" class="nav-link @if (Route::is('form.create')) active @endif" >Criar</a></li>                  
                            @endif

                            @admin
                                <li><a href="{{ route('admin.user') }}" class="nav-link @if (Route::is('admin.user')) active @endif" >Usuários</a></li>   
                                <li><a href="{{ route('admin.subscriber') }}" class="nav-link @if (Route::is('admin.subscriber')) active @endif" >Newsletter</a></li>   
                            @endadmin

                            <li>
                                <a href="{{ route('logout') }}">Sair</a>
                            </li>
                        @endauth
                        
                        @guest
                            @if (@$layout_header_simplified == false)
                                <li><a href="{{ route('form.create') }}" class="nav-link @if (Route::is('form.create')) active @endif">Criar</a></li>
                            @endif
                            
                            <li><a href="{{ route('login') }}" class="getstarted">Entrar </a></li>
                        @endguest
                    </ul>
                </li>
            </div>
        </nav>
    </div>
    @yield('ProgressBar')
</header>