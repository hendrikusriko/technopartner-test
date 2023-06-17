@extends('admintemplate')

@section('content')
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="btn-group d-flex justify-content-between">
                              <div class="d-flex justify-content-start mt-2">
                                  <h5>Data kategori</h5>
                              </div>

                              <div class="d-flex justify-content-end mb-3">
                                  <div class="mb-n3">
                                  <a href="{{ route('category.create') }}">
                                      <button class="btn btn-primary">
                                          Tambah Data
                                      </button>
                                  </a>
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tipe</th>
                                            <th>Nama kategori</th>
                                            <th>Deskripsi</th>
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
                ajax: "{{ route('category.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'desc',
                        name: 'desc'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
        });
    </script>
@endpush
