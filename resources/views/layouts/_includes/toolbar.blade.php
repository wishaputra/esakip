<header class="white p-3 fixed nav-sticky" style="z-index: 999;width: 100%;top: 0px;border-bottom:1px solid #e1e8ee">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 pl-1">
                <a class="btn btn-outline-secondary btn-sm" title="Toggle Navigator" id="btnToggleNav"><i class="icon icon-more_vert pr-0"></i></a>
                <div class="btn-group">
                    <a onclick="javascript:history.go(-1)" class="btn btn-outline-secondary btn-sm"
                        title="Kembali Ke Halaman Sebelumnya" id="btnBack"><i class="icon icon-arrow_back pr-0"></i></a>
                    <a onclick="javascript:location.reload()" class="btn btn-outline-secondary btn-sm"
                        title="Segarkan Halaman" id="btnReload"><i class="icon icon-refresh2 pr-0"></i></a>
                </div>
                @if(in_array('r', $toolbar))
                <a class="btn btn-outline-secondary btn-sm" title="Tampilkan List Data"
                    href="{{ route($route.'index') }}" id="btnRead"><i class="icon icon-list pr-0"></i> Semua Data</a>
                @endif
                <div class="btn-group">
                    @if(in_array('c', $toolbar))
                    <a class="btn btn-outline-secondary btn-sm" title="Masukan Data Baru"
                        href="{{ route($route.'create') }}" id="btnCreate"><i class="icon icon-add pr-0"></i> Tambah</a>
                    @endif
                    @if(in_array('u', $toolbar))
                    <a class="btn btn-outline-secondary btn-sm" title="Edit Data" href="{{ route($route.'edit', $id) }}"
                        id="btnEdit"><i class="icon icon-edit pr-0"></i> Edit</a>
                    @endif
                    @if(in_array('d', $toolbar))
                    <a class="btn btn-outline-secondary btn-sm" title="Hapus Data" id="btnDelete" href="#"
                        onclick="javascript:confirm_del()"><i class="icon icon-trash-can pr-0"></i> Hapus</a>
                    @endif
                </div>
                @if(in_array('save', $toolbar))
                <a class="btn btn-outline-secondary btn-sm" title="Simpan Data" id="btnSave" href="#"
                    onclick="javascript:save()"><i class="icon icon-save pr-0"></i> Simpan <span
                        id="txtSave"></span></a>
                @endif
                <span id="btnExtra"></span>
            </div>
            <div class="col-md-7 pt-2">
                <h5 class="float-right" style="font-weight:300;line-height:1.2;color:#606676">
                    <strong>{{ $title }}</strong>
                    @if(in_array('r', $toolbar) && count($toolbar) == 1 || count($toolbar) == 0)
                    <small>(Read Only)</small>
                    @endif
                </h5>
            </div>
        </div>
    </div>
</header>
