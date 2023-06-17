@extends('admintemplate')

@section('content')
    <div class="row">
        <div class="col-md-12 margin-tb">
          <div class="card">
            <div class="card-header pb-0">
              <h5>Tambah data kategori <span class="font-weight-bolder text-uppercase"></span></h5>
            </div>
 
            <div class="card-body">
              <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                      <div class="col-md-12">
                      <div class="form-group">
                        <label for="exampleFormControlSelect1">Tipe</label>
                        <select class="form-control" name="type">
                        <option selected disabled value="pemasukan">-- Pilih tipe kategori --</option>
                          <option value="pemasukan">pemasukan</option>
                          <option value="pengeluaran">pengeluaran</option>
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
                          <input type="text" name="name" class="form-control" required>
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
                          <textarea class="form-control" name="desc" rows="3" required></textarea>
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