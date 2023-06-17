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
            <form action="{{ route('transaction.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                      <div class="col-md-12">
                      <div class="form-group">
                        <label for="exampleFormControlSelect1">Tipe</label>
                        <select class="form-control" id="type" name="type">
                          @if ($transaction->type == 'pemasukan')
                            <option disabled value="pemasukan">-- Pilih tipe kategori --</option>
                            <option selected value="pemasukan">pemasukan</option>
                            <option value="pengeluaran">pengeluaran</option>
                          @elseif($transaction->type == 'pengeluaran')
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
                        <label for="exampleFormControlSelect1">Kategori</label>
                        <select class="form-control" id="category" name="category_id">
                        <option selected disabled value="pemasukan">-- Pilih tipe kategori --</option>
                          @foreach($category as $id => $value)
                              <option value="{{ $id }}">
                                  {{ $value }}
                              </option>
                          @endforeach
                        </select>
                      </div>
                        @error('category_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Nominal</label>
                          <input type="number" name="nominal" class="form-control" value="{{ $transaction->nominal }}" required>
                        </div>
                        @error('nominal')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Deskripsi</label>
                          <textarea class="form-control" name="desc" rows="3" required>{{ $transaction->desc }}</textarea>
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

@section('scripts')
    <script type="text/javascript">
        $("#type").change(function(){
            $.ajax({
                url: "{{ route('category.getcatbytype') }}?type=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#category').html(data.html);
                }
            });
        });
    </script>
@endsection