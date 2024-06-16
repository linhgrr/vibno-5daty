<header>
    <nav>
      <div class="logo">
        <a href="#">Viabno</a>
      </div>
      <ul>
        <li><a
          class="{{ request()->is('/') ? 'active' : ''}}"
          href="/">Home
        </a></li>
        <li><a
          class="{{ request()->is('/about') ? 'active' : ''}}"
          href="/about">About
        </a></li>
        <li><a
          class="{{ request()->is('/posts') ? 'active' : ''}}"
          href="/posts">Posts
        </a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </nav>
  </header>