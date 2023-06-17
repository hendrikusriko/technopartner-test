@extends('admintemplate')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 margin-tb">
          <div class="card">
            <div class="card-header pb-0">
              <h5>Edit data kategori <span class="font-weight-bolder text-uppercase"></span></h5>
            </div>
 
            <div class="card-body">
            <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="exampleFormControlSelect1">Tipe</label>
                        <select class="form-control" name="type">
                        <option selected disabled value="pemasukan">-- Pilih tipe kategori --</option>
                          @if ($category->type == 'pemasukan')
                            <option disabled value="pemasukan">-- Pilih tipe kategori --</option>
                            <option selected value="pemasukan">pemasukan</option>
                            <option value="pengeluaran">pengeluaran</option>
                          @elseif($category->type == 'pengeluaran')
                            <option disabled value="pemasukan">-- Pilih tipe kategori --</option>
                            <option value="pemasukan">pemasukan</option>
                            <option selected value="pengeluaran">pengeluaran</option>
                          @endif
                        </select>
                      </div>
                        @error('type')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Nama kategori</label>
                          <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                        </div>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Deskripsi</label>
                          <textarea class="form-control" name="desc" rows="3" required>{{ $category->desc }}</textarea>
                        </div>
                        @error('desc')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                      </div>
                    </div>

                  <div class="mt-5 mb-n4">
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">
                        Submit
                      </button>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection