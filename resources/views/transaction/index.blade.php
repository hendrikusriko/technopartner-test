@extends('admintemplate')

@section('content')
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-3">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Saldo bulan ini</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $saldo }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="btn-group d-flex justify-content-between">
                              <div class="d-flex justify-content-start mt-2">
                                  <h5>Data transaksi Bulan Ini</h5>
                              </div>

                              <div class="d-flex justify-content-end mb-3">
                                  <div class="mb-n3">
                                  <a href="{{ route('transaction.create') }}">
                                      <button class="btn btn-primary">
                                          Tambah Data
                                      </button>
                                  </a>
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="card-body">
                                    <label> Filter berdasarkan tanggal :</label> 
                                    <div class="row mb-4"> 
                                        <div class="col-lg-5">
                                            <label>Dari tanggal</label> 
                                            <div class="controls">
                                                <input name="start_date" id="start_date" type="date" class="form-control" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-5">
                                            <label>Sampai tanggal</label> 
                                            <div class="controls">
                                                <input name="end_date" id="end_date" type="date" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                        <br>
                                        <center>
                                            <button type="text" id="submitsearch" class="btn btn-primary mt-2">Submit</button>
                                        </center>
                                        </div>
                                    </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tipe</th>
                                            <th>Category</th>
                                            <th>Nominal</th>
                                            <th>Deskripsi</th>
                                            <th>Dibuat pada</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>


    <script type="text/javascript">
        $(function() {
            var table = $('#dataTable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('transaction.datatables') }}",
                    data: function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'category.name',
                        name: 'category.name'
                    },
                    {
                        data: 'nominal',
                        name: 'nominal'
                    },
                    {
                        data: 'desc',
                        name: 'desc'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#submitsearch').click(function(){
                $('#dataTable').DataTable().draw(true);
            });
        });
        
    </script>
@endpush
