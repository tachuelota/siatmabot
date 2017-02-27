@extends('front.template')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Tambah Sesi-Prodi</h3>
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="col-md-12 col-sm-12 col-xs-12">
      @if(count($errors)>0)
      <div class="x_panel">
        <h2><font size="5" color="red"><b>Maaf data gagal disimpan, berikut error yang terjadi : </b></font></h2>
        <ul>
          @foreach($errors->all() as $error)
            <li><font size="3">{{ $error }}</font></li>
          @endforeach
        </ul>
      </div>
      @endif

      <div class="x_panel">
        <!------------------------------------------FORM INPUT DATA-------------->
        <form name="formEditSesiProdi" action="{{ route('sesiProdi.update', $sesiProdi->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" name="_method" value="PATCH">
        <div class="x_title"> <!-------------------------------------------------------FORM ARTIKEL---------------------------->
          <h2>Form Sesi-Prodi <small>Detail-detail sesi-prodi</small></h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sesi
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="select2_single form-control" required="" name="sesi_id" tabindex="-1">
                @foreach( $semuaSesi as $sesi )
                  @if($sesi->id == $sesiProdi->sesi_id)
                    @if($sesi->deleted_at != NULL)
                      <option value="-1">Sesi Sudah Dihapus</option>
                    @else
                      <option value="{{ $sesi->id }}">{{ $sesi->hari }}-{{ $sesi->sesi }}</option>
                    @endif
                  @endif
                @endforeach
                @foreach( $semuaSesi as $sesi )
                  @if($sesi->id != $sesiProdi->sesi_id)
                    @if($sesi->deleted_at == NULL)
                      <option value="{{ $sesi->id }}">{{ $sesi->hari }}-{{ $sesi->sesi }}</option>
                    @endif
                  @endif
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Program Studi</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="select2_group form-control" required="" name="prodi_id" tabindex="-1">
                @foreach($semuaFakultas as $fakultas)
                  @if($fakultas->id == $fakultasId)
                    @if($fakultas->deleted_at != NULL)
                      <option value="-1">Fakultas sudah dihapus</option>
                    @else
                      <optgroup label="{{ $fakultas->nama }}">
                        @foreach($semuaProdi as $prodi)
                          @if($prodi->fakultas_id == $fakultas->id)
                            @if($prodi->id == $sesiProdi->prodi_id)
                              @if($prodi->deleted_at != NULL)
                                <option value="-1">Prodi sudah dihapus</option>
                              @else
                                <option value="{{ $prodi->id }}">{{ $prodi->nama }}</option>
                              @endif
                            @endif
                          @endif
                        @endforeach

                        @foreach($semuaProdi as $prodi)
                          @if($prodi->fakultas_id == $fakultas->id)
                            @if($prodi->id != $sesiProdi->prodi_id)
                              @if($prodi->deleted_at == NULL)
                                <option value="{{ $prodi->id }}">{{ $prodi->nama }}</option>
                              @endif
                            @endif
                          @endif
                        @endforeach
                      </optgroup>
                    @endif
                  @endif
                @endforeach

                @foreach($semuaFakultas as $fakultas)
                  @if($fakultas->id != $fakultasId)
                    @if($fakultas->deleted_at == NULL)
                      <optgroup label="{{ $fakultas->nama }}">
                        @foreach($semuaProdi as $prodi)
                          @if($prodi->fakultas_id == $fakultas->id)
                            @if($prodi->deleted_at == NULL)
                              <option value="{{ $prodi->id }}">{{ $prodi->nama }}</option>
                            @endif
                          @endif
                        @endforeach
                      </optgroup>
                    @endif
                  @endif
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Waktu
            </label>
            <div class="col-md-1 col-sm-6 col-xs-12">
              <select class="select2_singleJam form-control" required="" name="jam">
                <option value="{{ $jam }}">{{ $jam }}</option>
                @for($counter = 00;$counter<=23;$counter++)
                  @if($counter != $jam)
                    <option value="{{ $counter }}">{{ $counter }}</option>
                  @endif
                @endfor
              </select>
            </div>
            <div class="col-md-1 col-sm-6 col-xs-12">
              <select class="select2_singleMenit form-control" required="" name="menit">
                <option value="{{ $menit }}">{{ $menit }}</option>
                @for($counter = 00;$counter<=59;$counter++)
                  @if($counter != $menit)
                    <option value="{{ $counter }}">{{ $counter }}</option>
                  @endif
                @endfor
              </select>
            </div>
          </div>

        </div>

        <div class="x_title">
          <div class="clearfix"></div>
        </div>

          <div class="col-md-2 col-sm-12 col-xs-12 form-group">

          </div>
          <div class="col-md-2 col-sm-12 col-xs-12 form-group">

          </div>
          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <a class="btn btn-primary btn-lg" href="{{ Route('sesiProdi.index') }}">Batal</a>
          </div>
          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
              <button type="submit" class="btn btn-success btn-lg">Simpan</button>
          </div>
          <div class="col-md-2 col-sm-12 col-xs-12 form-group">

          </div>
        </form> <!--------------------------------------------------------------------------------PENUTUP FORM------------------>
        </div>




      </div> <!---------------------------------------------DIV CONTENT---------------------------->
    </div>

  </div>
</div>
<!-- /page content -->
@endsection

@section('custom_script')
<!-- Select2 -->
<script>
  $(document).ready(function() {
    $(".select2_single").select2({
      placeholder: "Pilih sesi",
      allowClear: true
    });
    $(".select2_singleJam").select2({
      placeholder: "Jam",
      allowClear: true
    });
    $(".select2_singleMenit").select2({
      placeholder: "Menit",
      allowClear: true
    });
    $(".select2_group").select2({
      placeholder: "Pilih program studi",
      allowClear: true
    });
  });
</script>
<!-- /Select2 -->
@endsection
