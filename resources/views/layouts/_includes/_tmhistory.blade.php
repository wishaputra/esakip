@foreach ($tmhistory_log as  $key => $i)
<div class="card-header">
    @if ($i->proses_pencairan == null)
    <h5>Peneliti Kelengkapan Dokumen {{$tmpengajuan->jenislaporan->nama }}, Koreksi {{$i->history_user.' ('.($key+1).')' }}  </h5>
    @else
    <h5>Proses Pencairan</h5>
    @endif
    
</div>
<div class="card-body b-b">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-xs-12">
            
            <div class="form-group s-12">
                <label for="">Nama</label>
                <input type="text"  value="{{ $i->nama }}"  readonly autocomplete="off" class="form-control  s-12 " 
                placeholder="">
                <p class="text-danger">{{ $errors->first('nama') }}</p>
            </div>
            @if ($i->proses_pencairan != null)
            <div class="form-group s-12">
                <label for="">Status Proses Pencairan</label>
                <input type="text"  value="{{ $sts_pp[$i->pertimbangan] }}"  readonly autocomplete="off" class="form-control  s-12 " 
                placeholder="">
        
            </div>
            @endif
            @if ($i->getDatetimelog)
                
            
            <div class="form-group s-12">
                <label for="">Tanggal</label>
                <input type="text"  value="{{ $i->getDatetimelog->send_at }}"  readonly autocomplete="off" class="form-control  s-12 " 
                placeholder="">
                <p class="text-danger">{{ $errors->first('nama') }}</p>
            </div>
            @endif
          
            
        </div>
        <div class="col-lg-6 col-md-6 col-xs-12">
            <div class="form-group s-12">
                <label for="">Catatan</label>
                <textarea name="catatan"  cols="30" rows="5" class="form-control" readonly>{{ $i->catatan }}</textarea>
                <p class="text-danger">{{ $errors->first('catatan') }}</p>
            </div>
        </div>
       
    </div>
    
    
  

</div>

@endforeach