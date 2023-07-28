
<style>
.sidebar {
    height: 100vh;
    background-color:  rgb(16, 23, 41);
}

.hover{
  color: white;
}

.hover:hover{
  background-color: rgb(54, 54, 54);
  border: 1px solid white;
}

.active{
  background-color: rgb(85, 85, 85);
  border: 1px solid rgb(0, 0, 0) ;
  color:  rgb(73, 108, 173);
}

.button {
    border: none;
}

.title {
  color: rgb(73, 108, 173);
}

.text {
  color: white;
}

.content {
    height: 70vh;
}

.profil[title] {
  position: relative;
  cursor: pointer;
}

.profil[title]:hover:after {
  content: attr(title);
  padding: 5px;
  color: #000000;
  background-color: #000;
  position: absolute;
  z-index: 999;
  left: 50%;
  transform: translateX(-50%);
}

</style>

<div class=" sidebar col-md-2 shadow-lg">

<h3 class="title text-center p-3 mt-2 ">MyNote  
  <i class="fas fa-book-open ms-2"></i></h3>

<div class="content pt-5 ">
<div class="hover {{ Request::is('dashboard') ? 'active' : '' }}">
<a href="http://localhost/laravel_tasknote/public/dashboard" class="text-decoration-none"> <h6 class=" ms-4 py-2 text-light"><i class="fas fa-book me-2"></i> Dashboard</h6></a></div>
<div class="hover {{ Request::is('monitoring') ? 'active' : '' }}">
<a href="http://localhost/laravel_tasknote/public/monitoring" class="text-decoration-none"><h6 class=" ms-4 py-2 text-light "><i class="fas fa-chart-line me-2"></i> Monitoring</h6></a></div>
<div class="hover {{ Request::is('admin') ? 'active' : '' }}">
<a href="http://localhost/laravel_tasknote/public/admin" class="text-decoration-none"><h6 class=" ms-4 py-2 text-light "><i class="fas fa-users me-2"></i> Admin</h6></a></div>
</div>

<div class=" ms-5 mt-5 d-flex">
    @if (empty(($photo)))
    <a><img src="{{ asset('storage/blank_user.png')}}" data-bs-toggle="modal" data-bs-target="#modalfotoblank" alt="Profile Picture" width="40px" class="profil rounded-circle"></a>
@else
<a><img src="{{ asset('storage/'.$photo) }}"  data-bs-toggle="modal" data-bs-target="#modalfoto" alt="Profile Picture" width="40px" class="profil rounded-circle"></a>
    @endif

    <div class="modal fade" id="modalfotoblank" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog rounded-circle">
        <div class="modal-content rounded-circle">
      <img src="{{ asset('storage/blank_user.png') }}" class="rounded-circle">
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalfoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog rounded-circle">
        <div class="modal-content rounded-circle">
          <img src="{{ asset('storage/'.$photo) }}" class="rounded-circle">
        </div>
      </div>
    </div>

  <div class="dropdown mt-1">
    <p class="ms-2 text-light dropdown-toggle fst-italic" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      {{$name}} 
    </p>
  <ul class="dropdown-menu dropdown-menu-dark">
    <li><a class="dropdown-item" href="http://localhost/laravel_tasknote/public/profile/admin">Edit Profile</a></li>
    <li><a href="http://localhost/laravel_tasknote/public/logout" class="dropdown-item text-decoration-none"><h6 class=" fst-italic fwt-light pt-2 ">Logout </h6></a></li>
  </ul>
</div>
</div>
</div>
