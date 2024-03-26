<ul class="sidebar-menu">

    <li class="header"><strong>MAIN NAVIGATIONN</strong></li>
    {{-- <li>
        <a href="{{ route('admin') }}">
            <i class="icon icon-sailing-boat-water purple-text s-18"></i> <span>Dashboard</span>
        </a>
    </li> --}}





    {{-- @role('admin') --}}


    {{-- <li class="treeview ">
        <a href="#" target="">
            <i class="icon icon-gears text-blue s-18"></i> <span>Setup Aplikasi</span>
            <i class="icon icon-angle-left s-18 pull-right"></i> </a>

        <ul class="treeview-menu ">

            <li>
                <a href="{{ route('setup.pengguna.index') }}">
    <i class="icon icon-book"></i> <span>Pengguna</span>
    </a>

    </li>
    <li>
        <a href="{{ route('setup.jnspencairan.index') }}">
            <i class="icon icon-book"></i> <span>Jenis Pencairan</span>
        </a>

    </li>
    <li>
        <a href="{{ route('setup.persyaratan.index') }}">
            <i class="icon icon-book"></i> <span>Persyaratan</span>
        </a>

    </li>

    <li>

</ul>
</li> --}}
<li class="treeview active">
    <a  target="">
        <i class="icon icon-layers text-blue s-18"></i> <span>Layer</span>
        <i class="icon icon-angle-left s-18 pull-right"></i> </a>

    <ul class="treeview-menu  ">

        @foreach ($menu_navigasi as $i)
        <li class="treeview " id="treeview_{{$i->id}}">
            <a href="#" target="">
                <i class="icon icon-caret-right"></i> <span>{{ $i->nama }}
                    @foreach ($i->sub_menus as $icon)
                    <span class="icon-power-off text-success pl-1" id="ic_{{$icon->id}}" style="display: none" ></span>
                    @endforeach
                </span>
                
                <i class="icon icon-angle-left s-18 pull-right"></i> </a>
            </a>
            @if ($i->sub_menus)
            <ul class="treeview-menu " id="treeviewmenu_{{$i->id}}">
                @foreach ($i->sub_menus as $ii)
                
                    <li>
                        <a href="#">
                            <i class="icon icon-minus"></i> <span>{{ $ii->nama }}</span>
                            <div class="material-switch float-right" style="padding-right: 10px;
                                padding-top: 4px;">
                                <input id="{{$ii->slug}}" name="{{$ii->slug}}" type="checkbox" onchange="loadLayer({{$ii->id}})">
                                <label for="{{$ii->slug}}" class="bg-primary"></label>
                            </div>
                        </a>
    
                    </li>
                
                @endforeach
            </ul>
            
            @endif
            

        </li>
        @endforeach

        

        


    </ul>
</li>

{{-- @endrole --}}















</ul>