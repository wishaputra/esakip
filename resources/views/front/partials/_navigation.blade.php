@php
use App\Models\Menu;
    $menus = Menu::with(['sub_menus.sub_menus2'])->orderBy('no_urut')->get();
@endphp
<!-- Navigation -->
<nav class="navbar navbar-expand-sm navbar-dark navbar-custom fixed-top">
    <!-- Text Logo - Use this if you don't have a graphic logo -->
    <!-- <a class="navbar-brand logo-text page-scroll" href="index.html">Evolo</a> -->

    <!-- Image Logo -->
    <a class="navbar-brand " href="{{URL::to('/')}}"><img style="width:4rem;" src="{{ $logo->getImage(1) }}" alt="alternative"></a>

    <!-- Mobile Menu Toggle Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
        aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-awesome fas fa-bars"></span>
        <span class="navbar-toggler-awesome fas fa-times"></span>
    </button>
    <!-- end of mobile menu toggle button -->

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav ml-auto">
            @foreach ($menus as $menu)
                @if ($menu->sub_menus->count() == 0)
                    <li class="nav-item">
                        <a class="nav-link page-scroll"
                            href="{{ substr($menu->route,0,1) == "#" ? URL::to('/').'/'.$menu->route : URL::to($menu->route)  }}">{{ $menu->nama }}
                            <span class="sr-only">(current)</span></a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle page-scroll" href="{{ substr($menu->route,0,1) == "#" ? URL::to('/').'/'.$menu->route : URL::to($menu->route)  }}" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $menu->nama }}</a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @foreach ($menu->sub_menus as $sub_menu)
                                @if ($sub_menu->sub_menus2->count() == 0)
                                    <a class="dropdown-item" href="{{ substr($sub_menu->route,0,1) == "#" ? $sub_menu->route : URL::to($sub_menu->route)  }}">
                                        <span class="item-text">{{$sub_menu->nama}}</span>
                                    </a>
                                    <div class="dropdown-items-divide-hr"></div>
                                @else
                                    <div class="submenu-item">
                                        <a class="dropdown-item dropdown-toggle dropright" href="{{ substr($sub_menu->route,0,1) == "#" ? $sub_menu->route : URL::to($sub_menu->route)  }}" id="navbarDropdownSubMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="item-text">{{$sub_menu->nama}}</span>
                                        </a>
                                        <div class="dropdown-items-divide-hr"></div>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownSubMenuLink">
                                            @foreach ($sub_menu->sub_menus2 as $sub_menus2)
                                                <a class="dropdown-item" href="{{ substr($sub_menus2->route,0,1) == "#" ? $sub_menus2->route : URL::to($sub_menus2->route)  }}">
                                                    <span class="item-text">{{$sub_menus2->nama}}</span>
                                                </a>
                                                <div class="dropdown-items-divide-hr"></div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </li>
                @endif
            @endforeach
            <!-- Search form -->
            <li class="nav-item">
                <form method="POST" action="{{ route('search') }}" autocomplete="off">
                    @csrf
                    <input type="text" name="search" placeholder="Search" aria-label="Search" autocomplete="off">
                    <button type="submit" class="btn-info"><i class="fas fa-search" aria-hidden="true"></i></button>
                </form>
            </li>


            {{-- <li class="nav-item">
                <a class="nav-link page-scroll" href="#header">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link page-scroll" href="#services">Services</a>
            </li>
            <li class="nav-item">
                <a class="nav-link page-scroll" href="#pricing">Pricing</a>
            </li>
            <li class="nav-item">
                <a class="nav-link page-scroll" href="#request">Request</a>
            </li> --}}

            <!-- Dropdown Menu -->
            {{-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle page-scroll" href="#about" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">About</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="terms-conditions.html"><span class="item-text">Terms Conditions</span></a>
                    <div class="dropdown-items-divide-hr"></div>
                    <a class="dropdown-item" href="privacy-policy.html"><span class="item-text">Privacy Policy</span></a>
                </div>
            </li> --}}
            <!-- end of dropdown menu -->

            {{-- <li class="nav-item">
                <a class="nav-link page-scroll" href="#contact">Contact</a>
            </li> --}}
        </ul>
        {{-- <span class="nav-item social-icons">
            <span class="fa-stack">
                <a href="#your-link">
                    <i class="fas fa-circle fa-stack-2x facebook"></i>
                    <i class="fab fa-facebook-f fa-stack-1x"></i>
                </a>
            </span>
            <span class="fa-stack">
                <a href="#your-link">
                    <i class="fas fa-circle fa-stack-2x twitter"></i>
                    <i class="fab fa-twitter fa-stack-1x"></i>
                </a>
            </span>
        </span> --}}
    </div>
</nav> <!-- end of navbar -->
<!-- end of navigation -->
