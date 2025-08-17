<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ Auth::user()->name }}
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('preferences.show') }}">Paramètres</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
                        <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                    Déconnexion
                </a>
            </form>
        </li>
    </ul>
</li>
