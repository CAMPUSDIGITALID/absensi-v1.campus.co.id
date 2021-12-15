@extends('template/main')

@section('title', 'Edit Indikator')

@section('content')

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-money"></i> Edit Indikator</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Penggajian</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.salary-indicator.index') }}">Indikator</a></li>
            <li class="breadcrumb-item">Edit Indikator</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="tile">
                <form method="post" action="{{ route('admin.salary-indicator.update') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $salary_indicator->id }}">
                    <div class="tile-body">
                        <div class="alert alert-warning">
                            Jika menggunakan bilangan desimal pada <b>batas bawah</b> dan <b>batas atas</b>, pastikan menggunakan titik (.), bukan koma (,).
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" id="category">
                                    <option value="" selected>--Pilih--</option>
                                    @foreach(\App\Models\Group::find($salary_indicator->group_id)->categories as $category)
                                    <option value="{{ $category->id }}" {{ $salary_indicator->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }} ({{ $category->position ? $category->position->name : '-' }})</option>
                                    @endforeach
                                </select>
                                @if($errors->has('category_id'))
                                <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('category_id')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Batas Bawah <span class="text-danger">*</span></label>
                                <input type="text" name="lower_range" class="form-control {{ $errors->has('lower_range') ? 'is-invalid' : '' }}" value="{{ $salary_indicator->lower_range }}">
                                @if($errors->has('lower_range'))
                                <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('lower_range')) }}</div>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Batas Atas</label>
                                <input type="text" name="upper_range" class="form-control {{ $errors->has('upper_range') ? 'is-invalid' : '' }}" value="{{ $salary_indicator->upper_range }}">
                                <div class="text-muted">Kosongi saja jika batas atas tidak terhingga.</div>
                                @if($errors->has('upper_range'))
                                <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('upper_range')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text {{ $errors->has('amount') ? 'border-danger' : '' }}">Rp.</span>
                                    </div>
                                    <input type="text" name="amount" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" value="{{ $salary_indicator->amount }}">
                                </div>
                                @if($errors->has('amount'))
                                <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('amount')) }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer"><button class="btn btn-primary icon-btn" type="submit"><i class="fa fa-save mr-2"></i>Simpan</button></div>
                </form>
            </div>
        </div>
    </div>
</main>

@endsection

@section('js')

<script>
    // Change Group
    $(document).on("change", "#group", function() {
        var group = $(this).val();
        $.ajax({
            type: "get",
            url: "{{ route('api.salary-category.index') }}",
            data: {group: group},
            success: function(result){
                var html = '<option value="" selected>--Pilih--</option>';
                $(result).each(function(key,value){
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });
                $("#category").html(html).removeAttr("disabled");
            }
        });
    });
</script>

@endsection