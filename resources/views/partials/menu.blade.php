<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid shadow-sm p-3 mb-2 bg-body-tertiary rounded">
           
                <a class="navbar-brand fw-bold" href="#">Books - {{config('app.name')}} </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
               
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item mx-5"><a class="nav-link active text-info-emphasis" aria-current="page" href="{{route('home')}}">Aucceil</a></li>
                        
                        @if(Route::is('book.*') == false)
                            @forelse($genres as $id => $name)
                            <li class="nav-item mx-2"><a class="nav-link active text-primary-emphasis" aria-current="page" href="{{route('genre', $id)}}">{{$name}}</a></li>
                            @empty 
                            <li>Aucun genre pour l'instant</li>
                            @endforelse
                        @endif

                    </ul>
            @if(Auth::check())
                    <ul class="navbar-nav ml-auto mb-2 mb-lg-0 d-flex align-items-center">
                        
                        <li class="nav-item mx-3"><a class="nav-link active text-primary-emphasis" href="{{route('dashboard')}}"><i class="fa fa-user"></i>
                        {{Auth::user()->name}}</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link active text-danger" href="{{route('logout')}}">logout</a>
                        </li>
                    </ul>
                @else    
                        <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                            <li class="nav-item mx-3">
                                <a class="nav-link active text-primary" href="{{route('login')}}"><i class="fa fa-user"></i> Login</a>
                        </li>
                    </ul>
                @endif        
                    
           
                 </div>
              
</nav>