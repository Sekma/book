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
                            <!-- Button trigger modal -->
                            <a type="button" class="nav-link active text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">logout</a>
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



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Déconnexion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      Êtes-vous sûr de vouloir vous déconnecter ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
        <a type="button" class="btn btn-danger" href="{{route('logout')}}">Déconnecter</a>
      </div>
    </div>
  </div>
</div>