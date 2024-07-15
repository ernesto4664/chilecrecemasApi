<div class="menu-container">
    <div class="menu-toggle" id="menu-toggle">
        ☰
    </div>
    <div class="menu" id="menu">
        <div class="menu-item {{ Request::routeIs('noticias.*') ? 'active' : '' }}">
            <a href="#" class="submenu-toggle">Noticia Generales</a>
            <div class="submenu {{ Request::routeIs('noticias.*') || Request::routeIs('tags.index')  || Request::routeIs('tags.create')  ? 'open' : '' }}">
                <div class="menu-item {{ Request::routeIs('noticias.index') || Request::routeIs('noticias.create') ? 'active' : '' }}">
                    <a href="#" class="submenu-toggle {{ Request::routeIs('noticias.index') || Request::routeIs('noticias.create') ? 'active' : '' }}">Noticias Gobales</a>
                    <div class="submenu {{ Request::routeIs('noticias.index') || Request::routeIs('noticias.create') ? 'open' : '' }}">
                        <a href="{{ route('noticias.create') }}" class="{{ Request::routeIs('noticias.create') ? 'active' : '' }}">Crear</a>
                        <a href="{{ route('noticias.index') }}" class="{{ Request::routeIs('noticias.index') ? 'active' : '' }}">Listar</a>
                    </div>
                </div>
                <div class="menu-item {{ Request::routeIs('tags.index') || Request::routeIs('tags.create') ? 'active' : '' }}">
                    <a href="#" class="submenu-toggle {{ Request::routeIs('tags.index') || Request::routeIs('tags.create') ? 'active' : '' }}">Tags</a>
                    <div class="submenu {{ Request::routeIs('tags.index') || Request::routeIs('tags.create') ? 'open' : '' }}">
                        <a href="{{ route('tags.create') }}" class="{{ Request::routeIs('tags.create') ? 'active' : '' }}">Crear</a>
                        <a href="{{ route('tags.index') }}" class="{{ Request::routeIs('tags.index') ? 'active' : '' }}">Listar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-item {{ Request::routeIs('admin.users_with_families') ? 'active' : '' }}">
            <a href="#" class="submenu-toggle">Usuario</a>
            <div class="submenu">
                <a href="{{ route('admin.users_with_families') }}" class="{{ Request::routeIs('admin.users_with_families') ? 'active' : '' }}">Usuario App</a>
            </div>
        </div>
    </div>
</div>




