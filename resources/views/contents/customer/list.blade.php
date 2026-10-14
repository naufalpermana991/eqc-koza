<style>
    #tb-data thead th {
        text-align: center;
        background-color: #b9161c !important;
        color: white !important;
    }
    #tb-data tbody td {
        text-align: center;
    }
</style>
<div class="row">
    <h3 class="mb-4"><?= $title ?></h3>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-success" onclick="tambahData()"><i data-feather="plus"></i> Add New</button>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="table-responsive" style="height: 510px;">
                            <table id="tb-data" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Location File</th>
                                        <th>File Name</th>
                                        <th>Leader Date Position</th>
                                        <th>Leader Name Position</th>
                                        <th>Leader Sign Position</th>
                                        <th>Spv Date Position</th>
                                        <th>Spv Name Position</th>
                                        <th>Spv Sign Position</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-table">
                                    <?php foreach ($data as $value): ?>
                                        <tr>
                                            <td><?= $value->customer_name ?></td>
                                            <td><?= $value->location_file ?></td>
                                            <td><?= $value->file_name ?></td>
                                            <td><?= $value->location_date_leader ?></td>
                                            <td><?= $value->location_name_leader ?></td>
                                            <td><?= $value->location_sign_leader ?></td>
                                            <td><?= $value->location_date_spv ?></td>
                                            <td><?= $value->location_name_spv ?></td>
                                            <td><?= $value->location_sign_spv ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" title="Edit" onclick="showData('<?= $value->id ?>')"><i class="fa fa-pencil"></i></button>
                                                <a href="/customer/delete_data?id=<?= $value->id ?>" onclick="return confirm('Are you sure?')"><button type="button" class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></button></a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_tambah" tabindex="-1" aria-labelledby="modal_tambah_label" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form class="forms-sample" id="form-tambah" action="/customer/create" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_tambah_label">Add New</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="customer_name">Customer Name</label>                
                            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Input Nama Customer" value="" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="location_file">Location File</label>                
                            <input type="text" class="form-control" id="location_file" name="location_file" value="" placeholder="Input Posisi Folder" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="file_name">File Name</label>                
                            <input type="text" class="form-control" id="file_name" name="file_name" value="" placeholder="Input Nama File" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="location_date_leader">Leader Date Position</label>                
                            <input type="text" class="form-control" id="location_date_leader" name="location_date_leader" value="" placeholder="example : P8" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="location_sign_leader">Leader Sign Position</label>                
                            <input type="text" class="form-control" id="location_sign_leader" name="location_sign_leader" value="" placeholder="example : P9" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="location_name_leader">Leader Name Position</label>                
                            <input type="text" class="form-control" id="location_name_leader" name="location_name_leader" value="" placeholder="example : P10" required />
                            <div class="col-md-12 mt-2">
                                <label for="location_date_spv">Spv Date Position</label>                
                                <input type="text" class="form-control" id="location_date_spv" name="location_date_spv" value="" placeholder="example : Q8" required />
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="location_sign_spv">Spv Sign Position</label>                
                                <input type="text" class="form-control" id="location_sign_spv" name="location_sign_spv" value="" placeholder="example : Q9" required />
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="location_name_spv">Spv Name Position</label>                
                                <input type="text" class="form-control" id="location_name_spv" name="location_name_spv" value="" placeholder="example : Q10" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveButton()"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="modal_edit_label" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form class="forms-sample" id="form-edit" action="/customer/update" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_edit_label">Add New</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="id_edit" name="id">
                            <label for="customer_name_edit">Customer Name</label>                
                            <input type="text" class="form-control" id="customer_name_edit" name="customer_name" placeholder="Input Nama Customer" value="" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="location_file_edit">Location File</label>                
                            <input type="text" class="form-control" id="location_file_edit" name="location_file" value="" placeholder="Input Posisi Folder" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="file_name_edit">File Name</label>                
                            <input type="text" class="form-control" id="file_name_edit" name="file_name" value="" placeholder="Input Nama File" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="location_date_leader_edit">Leader Date Position</label>                
                            <input type="text" class="form-control" id="location_date_leader_edit" name="location_date_leader" value="" placeholder="example : P8" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="location_sign_leader_edit">Leader Sign Position</label>                
                            <input type="text" class="form-control" id="location_sign_leader_edit" name="location_sign_leader" value="" placeholder="example : P9" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="location_name_leader_edit">Leader Name Position</label>                
                            <input type="text" class="form-control" id="location_name_leader_edit" name="location_name_leader" value="" placeholder="example : P10" required />
                            <div class="col-md-12 mt-2">
                                <label for="location_date_spv_edit">Spv Date Position</label>                
                                <input type="text" class="form-control" id="location_date_spv_edit" name="location_date_spv" value="" placeholder="example : Q8" required />
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="location_sign_spv_edit">Spv Sign Position</label>                
                                <input type="text" class="form-control" id="location_sign_spv_edit" name="location_sign_spv" value="" placeholder="example : Q9" required />
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="location_name_spv_edit">Spv Name Position</label>                
                                <input type="text" class="form-control" id="location_name_spv_edit" name="location_name_spv" value="" placeholder="example : Q10" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="updateButton()"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('custom-script')
<script>
    $(window).on('beforeunload', function (event) {
        setGlobalLoading(true);
    });

    $(document).ready(function() {
        $('#tb-data').DataTable( {
            "info": false,
            "sort": false
        });
    });

    function tambahData() {
        $('#customer_name').val('');
        $('#location_file').val('');
        $('#file_name').val('');
        $('#location_date_leader').val('');
        $('#location_sign_leader').val('');
        $('#location_name_leader').val('');
        $('#location_date_spv').val('');
        $('#location_sign_spv').val('');
        $('#location_name_spv').val('');
        $('#modal_tambah').modal('show');
    }

    function showFilter() {
        $('#modal_filter').modal('show');
    }

    function saveButton() {
        if(confirm('Are you sure?')){
            $('#modal_tambah').modal('hide');
            $('#form-tambah').submit();
        }
    }

    function updateButton() {
        if(confirm('Are you sure?')){
            $('#modal_edit').modal('hide');
            $('#form-edit').submit();
        }
    }

    function showData(id) {
        setGlobalLoading(true);
        $('#id_edit').val('');
        $('#customer_name_edit').val('');
        $('#location_file_edit').val('');
        $('#file_name_edit').val('');
        $('#location_date_leader_edit').val('');
        $('#location_sign_leader_edit').val('');
        $('#location_name_leader_edit').val('');
        $('#location_date_spv_edit').val('');
        $('#location_sign_spv_edit').val('');
        $('#location_name_spv_edit').val('');

        $.ajax({
            url: '/customer/get_data',
            type: 'GET',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(response) {
                if(response){
                    $('#id_edit').val(response.id);
                    $('#customer_name_edit').val(response.customer_name);
                    $('#location_file_edit').val(response.location_file);
                    $('#file_name_edit').val(response.file_name);
                    $('#location_date_leader_edit').val(response.location_date_leader);
                    $('#location_sign_leader_edit').val(response.location_sign_leader);
                    $('#location_name_leader_edit').val(response.location_name_leader);
                    $('#location_date_spv_edit').val(response.location_date_spv);
                    $('#location_sign_spv_edit').val(response.location_sign_spv);
                    $('#location_name_spv_edit').val(response.location_name_spv);
                    $('#modal_edit').modal('show');
                    setGlobalLoading(false);
                }else{
                    alert('data tidak ditemukan!');
                    setGlobalLoading(false);
                }
            }
        });
    }

    function showDetail(full_path) {
        window.open(full_path);
    }

    function showFile(full_path) {
        window.open('/customer/show?link='+full_path);
    }
</script>
@endsection