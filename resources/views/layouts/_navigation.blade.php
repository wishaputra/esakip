<ul class="sidebar-menu">
    <li class="header"><strong>MAIN NAVIGATION</strong></li>
    <li>
        <a href="{{ route('admin') }}">
            <i class="icon icon-sailing-boat-water purple-text s-18"></i> <span>Dashboard</span>
        </a>
    </li>

    
    @if (Auth::user()->role == 'Super Admin')
    <li>
        <a href="{{ route('posts.index') }}">
            <i class="icon s-18 icon-web pink-text "></i> <span>Page</span>
        </a>

    </li>
    <li>
        <a href="{{ route('blog.index') }}">
            <i class="icon s-18 icon-notebook2 amber-text"></i> <span>Blog</span>
        </a>

    </li>
    <li>
        <a href="{{ route('inbox.index') }}">
            <i class="icon s-18 icon-envelope green-text"></i> <span>Inbox</span>
            <span class="badge r-3 badge-success pull-right" id="badge-inbox">{{App\Models\Contact::where('status', 0)->count()}}</span>
        </a>

    </li>


    <li class="treeview {{ request()->segment(2) == 'business' ? 'active':'' }} ">
        <a href="#" target="">
            <i class="icon icon-shopping-bag text-blue s-18"></i> <span>Business</span>
            <i class="icon icon-angle-left s-18 pull-right"></i> </a>

        <ul class="treeview-menu ">

            <li>
                <a href="{{ route('business.category.index') }}">
                    <i class="icon icon-minus s-14 text-blue"></i> <span>Category</span>
                </a>

            </li>
            <li>
                <a href="{{ route('business.list.index') }}">
                    <i class="icon icon-minus s-14 text-blue"></i> <span>List</span>
                </a>

            </li>
        </ul>
    </li>

    <li>

        <a href="{{ route('setup.section.download.index') }}">
            <i class="icon s-18 icon-download text-blue"></i> <span>File Download</span>
        </a>

    </li>

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

<li class="treeview {{ request()->segment(2) == 'setup' ? 'active':'' }} ">
    <a href="#" target="">
        <i class="icon icon-gears text-blue s-18"></i> <span>Setup Aplikasi</span>
        <i class="icon icon-angle-left s-18 pull-right"></i> </a>

    <ul class="treeview-menu ">
                <li>
                    <a href="{{ route('setup.menu.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Menu</span></a>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="icon icon-minus s-14 text-blue"></i> <span>Cascading</span>
                        <i class="icon icon-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <!-- Sub-menu items -->
                        <li>
                        <a href="{{ route('setup.visi.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Visi & Misi</span>
                        </a>
                        <a href="{{ route('setup.tujuan.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Tujuan</span>
                        </a>
                        <a href="{{ route('setup.sasaran.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Sasaran</span>
                        </a>
                        <a href="{{ route('setup.urusan.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Urusan</span>
                        </a>
                        <a href="{{ route('setup.perangkat_daerah.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Perangkat Daerah</span>
                        </a>
                        <a href="{{ route('setup.tujuan_renstra.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Tujuan Renstra</span>
                        </a>
                        <a href="{{ route('setup.sasaran_renstra.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Sasaran Renstra</span>
                        </a>
                        <a href="{{ route('setup.program.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Program</span>
                        </a>
                        <a href="{{ route('setup.kegiatan.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Kegiatan</span>
                        </a>
                        <a href="{{ route('setup.sub_kegiatan.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Sub Kegiatan</span>
                        </a>
                    </ul>
                <li>
                <a href="{{ route('setup.front.index') }}">
                    <i class="icon icon-layers s-16 indigo-text"></i> <span>Front End</span>
                </a>

        </li>
        <li class="treeview">
            <a href="#">
                <i class="icon icon-documents3  s-16 text-blue"></i> <span>Section</span>
                <i class="icon icon-angle-left  pull-right"></i> </a>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ route('setup.section.slider.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Slider</span></a>
                </li>

                <!-- <li>
                    <a href="{{ route('organization-chart.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Struktur</span></a>
                </li>  

                <li>
                    <a href="{{ route('tree-view') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Tree</span></a>
                </li>   -->
                
                <li>
                    <a href="{{ route('setup.section.intro.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Intro</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.client.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Client</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.service.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Service</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.video.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Video</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.pricing.index') }}"><i class="icon icon-minus  s-14 text-blue"></i> <span>Pricing</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.testimoni.index') }}"><i class="icon icon-minus  s-14 text-blue"></i> <span>Testimoni</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.team.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>About Team</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.contact.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Contact</span></a>
                </li>
            </ul>

        </li>
        <li>
            <a href="{{ route('setup.footer.index') }}">
                <i class="icon  s-16 icon-chevron-circle-down red-text"></i> <span>Footer</span>
            </a>
        </li>
        <li>
            <a href="{{ route('setup.logo.index') }}">
                <i class="icon  s-16 icon-image red-text"></i> <span>Logo</span>
            </a>
        </li>
        <li>
            <a href="{{ route('setup.user.index') }}">
                <i class="icon  s-16 icon-user blue-text"></i> <span>Manajemen User</span>
            </a>
        </li>
    </ul>
</li>
@endrole

@if (Auth::user()->role == 'Menpan')
    <!-- <li>
        <a href="{{ route('posts.index') }}">
            <i class="icon s-18 icon-web pink-text "></i> <span>Page</span>
        </a>

    </li>
    <li>
        <a href="{{ route('blog.index') }}">
            <i class="icon s-18 icon-notebook2 amber-text"></i> <span>Blog</span>
        </a>

    </li>
    <li>
        <a href="{{ route('inbox.index') }}">
            <i class="icon s-18 icon-envelope green-text"></i> <span>Inbox</span>
            <span class="badge r-3 badge-success pull-right" id="badge-inbox">{{App\Models\Contact::where('status', 0)->count()}}</span>
        </a>

    </li>


    <li class="treeview {{ request()->segment(2) == 'business' ? 'active':'' }} ">
        <a href="#" target="">
            <i class="icon icon-shopping-bag text-blue s-18"></i> <span>Business</span>
            <i class="icon icon-angle-left s-18 pull-right"></i> </a>

        <ul class="treeview-menu ">

            <li>
                <a href="{{ route('business.category.index') }}">
                    <i class="icon icon-minus s-14 text-blue"></i> <span>Category</span>
                </a>

            </li>
            <li>
                <a href="{{ route('business.list.index') }}">
                    <i class="icon icon-minus s-14 text-blue"></i> <span>List</span>
                </a>

            </li>
        </ul>
    </li>

    <li>

        <a href="{{ route('setup.section.download.index') }}">
            <i class="icon s-18 icon-download text-blue"></i> <span>File Download</span>
        </a>

    </li>

    
<li class="treeview {{ request()->segment(2) == 'setup' ? 'active':'' }} ">
    <a href="#" target="">
        <i class="icon icon-gears text-blue s-18"></i> <span>Setup Aplikasi</span>
        <i class="icon icon-angle-left s-18 pull-right"></i> </a>

    <ul class="treeview-menu ">
                <li>
                    <a href="{{ route('setup.menu.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Menu</span></a>
                </li> -->

                <li class="treeview">
                    <a href="#">
                        <i class="icon icon-minus s-14 text-blue"></i> <span>Cascading</span>
                        <i class="icon icon-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <!-- Sub-menu items -->
                        <li>
                        <a href="{{ route('setup.visi_menpan.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Visi & Misi</span>
                        </a>
                        <a href="{{ route('setup.tujuan_menpan.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Tujuan</span>
                        </a>
                        <a href="{{ route('setup.sasaran_menpan.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Sasaran</span>
                        </a>
                        <a href="{{ route('setup.urusan_menpan.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Urusan</span>
                        </a>
                        <a href="{{ route('setup.perangkat_daerah_menpan.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Perangkat Daerah</span>
                        </a>
                        <a href="{{ route('setup.tujuan_renstra_menpan.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Tujuan Renstra</span>
                        </a>
                        <a href="{{ route('setup.sasaran_renstra_menpan.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Sasaran Renstra</span>
                        </a>
                        <a href="{{ route('setup.program.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Program</span>
                        </a>
                        <a href="{{ route('setup.kegiatan.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Kegiatan</span>
                        </a>
                        <a href="{{ route('setup.sub_kegiatan.index') }}">
                            <i class="icon icon-circle-o s-14 text-blue"></i> <span>Sub Kegiatan</span>
                        </a>
                    </ul>
                <li>
                <a href="{{ route('setup.front.index') }}">
                    <i class="icon icon-layers s-16 indigo-text"></i> <span>Front End</span>
                </a>

        </li>
        <li class="treeview">
            <a href="#">
                <i class="icon icon-documents3  s-16 text-blue"></i> <span>Section</span>
                <i class="icon icon-angle-left  pull-right"></i> </a>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ route('setup.section.slider.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Slider</span></a>
                </li>
                
                <li>
                    <a href="{{ route('setup.section.intro.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Intro</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.client.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Client</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.service.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Service</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.video.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Video</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.pricing.index') }}"><i class="icon icon-minus  s-14 text-blue"></i> <span>Pricing</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.testimoni.index') }}"><i class="icon icon-minus  s-14 text-blue"></i> <span>Testimoni</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.team.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>About Team</span></a>
                </li>
                <li>
                    <a href="{{ route('setup.section.contact.index') }}"><i class="icon icon-minus s-14 text-blue"></i> <span>Contact</span></a>
                </li>
            </ul>

        </li>
        <li>
            <a href="{{ route('setup.footer.index') }}">
                <i class="icon  s-16 icon-chevron-circle-down red-text"></i> <span>Footer</span>
            </a>
        </li>
        <li>
            <a href="{{ route('setup.logo.index') }}">
                <i class="icon  s-16 icon-image red-text"></i> <span>Logo</span>
            </a>
        </li>
        <li>
            <a href="{{ route('setup.user.index') }}">
                <i class="icon  s-16 icon-user blue-text"></i> <span>Manajemen User</span>
            </a>
        </li>
    </ul>
</li>
@endrole

@if (Auth::user()->role == 'Admin Perangkat Daerah')
<li class="treeview {{ request()->segment(2) == 'setup' ? 'active':'' }} ">
    <a href="#" target="">
        <i class="icon icon-gears text-blue s-18"></i> <span>Setup Aplikasi</span>
        <i class="icon icon-angle-left s-18 pull-right"></i> </a>

    <ul class="treeview-menu ">
            <li class="treeview">
                <a href="#">
                    <i class="icon icon-minus s-14 text-blue"></i> <span>Cascading</span>
                    <i class="icon icon-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <!-- Sub-menu items -->
                    <li>
                    {{-- <a href="{{ route('setup.tujuan_renstra.index') }}">
                        <i class="icon icon-circle-o s-14 text-blue"></i> <span>Tujuan Renstra</span>
                    </a> --}}
                    <a href="{{ route('setup.urusan_opd.index') }}">
                        <i class="icon icon-circle-o s-14 text-blue"></i> <span>Urusan</span>
                    </a>
                    <a href="{{ route('setup.program.index') }}">
                        <i class="icon icon-circle-o s-14 text-blue"></i> <span>Program</span>
                    </a>
                    <a href="{{ route('setup.kegiatan.index') }}">
                        <i class="icon icon-circle-o s-14 text-blue"></i> <span>Kegiatan</span>
                    </a>
                    <a href="{{ route('setup.sub_kegiatan.index') }}">
                        <i class="icon icon-circle-o s-14 text-blue"></i> <span>Sub Kegiatan</span>
                    </a>
                </ul>
            <li>
        </li>
    </ul>
</li>
</ul>
@endif