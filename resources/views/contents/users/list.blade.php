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
                                        <th>Username</th>
                                        <th>NIP</th>
                                        <th>Fullname</th>
                                        <th>Role</th>
                                        <th>Foto Profile</th>
                                        <th>File TTD</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-table">
                                    <?php foreach ($data as $value): ?>
                                        <tr>
                                            <td><?= $value->username ?></td>
                                            <td><?= $value->nip ?></td>
                                            <td><?= $value->fullname ?></td>
                                            <td><?= $value->role_name ?></td>
                                            <td><img src="<?= $value->foto_profile ?>" alt=""></td>
                                            <td><img src="<?= $value->file_ttd ?>" alt=""></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" title="Edit" onclick="showData('<?= $value->id ?>')"><i class="fa fa-pencil"></i></button>
                                                <a href="/user/delete_data?id=<?= $value->id ?>" onclick="return confirm('Are you sure?')"><button type="button" class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></button></a>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="forms-sample" id="form-tambah" action="/user/create" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_tambah_label">Add New</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <label for="add_username" style="font-size: 14px;">Username</label>
                            <input type="text" class="form-control" id="add_username" name="username" placeholder="input username untuk login" required="">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <label for="add_fullname" style="font-size: 14px;">Fullname</label>
                            <input type="text" class="form-control" id="add_fullname" name="fullname" placeholder="input fullname" required="">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <label for="add_nip" style="font-size: 14px;">NIP</label>
                            <input type="text" class="form-control" id="add_nip" name="nip" placeholder="input no induk pegawai" required="">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <label for="add_id_role" style="font-size: 14px;">Role</label>
                            <select name="id_role" class="form-select" id="add_id_role" required="">
                                <?php foreach ($role as $value): ?>
                                    <option value="<?= $value->id ?>"><?= $value->role_name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <label for="add_new_password" style="font-size: 14px;">New Password</label>
                            <input type="password" class="form-control mb-2" id="add_new_password" name="password" placeholder="Input password baru" required="">
                            <input type="checkbox" id="add-checkbox-new-password"> <label style="color: gray" for="add-checkbox-new-password">Show Password</label>
                        </div>
                        <div class="col-md-6">
                            <label for="add_confirm_password" style="font-size: 14px;">Confirm Password</label>
                            <input type="password" class="form-control mb-2" id="add_confirm_password" placeholder="Pastikan password sama" required="">
                            <input type="checkbox" id="add-checkbox-confirm-password"> <label style="color: gray" for="add-checkbox-confirm-password">Show Password</label>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <img id="add_view_foto" style="max-width:100px;max-height: 100px;" src="#" alt="">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <img id="add_view_foto_ttd" style="max-width:100px;max-height: 100px;" src="#" alt="">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <label for="add_foto_profile" style="font-size: 14px;">Foto Profile</label>
                            <input accept=".jpg,.png,.jpeg" type="file" class="form-control" id="add_foto_profile" name="foto_profile" onchange="document.getElementById('add_view_foto').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <label for="add_file_ttd" style="font-size: 14px;">TTD</label>
                            <input accept=".jpg,.png,.jpeg" type="file" class="form-control" id="add_file_ttd" onchange="document.getElementById('add_view_foto_ttd').src = window.URL.createObjectURL(this.files[0])" name="file_ttd">
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="forms-sample" id="form-edit" action="/user/update" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_edit_label">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="id_edit" name="id">
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <label for="edit_username" style="font-size: 14px;">Username</label>
                            <input type="text" class="form-control" id="edit_username" readonly="" placeholder="input username untuk login">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <label for="edit_fullname" style="font-size: 14px;">Fullname</label>
                            <input type="text" class="form-control" id="edit_fullname" name="fullname" placeholder="input fullname" required="">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <label for="edit_nip" style="font-size: 14px;">NIP</label>
                            <input type="text" class="form-control" id="edit_nip" name="nip" placeholder="input no induk pegawai" required="">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <label for="edit_id_role" style="font-size: 14px;">Role</label>
                            <select name="id_role" class="form-select" id="edit_id_role" required="">
                                <?php foreach ($role as $value): ?>
                                    <option value="<?= $value->id ?>"><?= $value->role_name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <img id="edit_view_foto" style="max-width:100px;max-height: 100px;" src="#" alt="">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <img id="edit_view_foto_ttd" style="max-width:100px;max-height: 100px;" src="#" alt="">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <label for="edit_foto_profile" style="font-size: 14px;">Foto Profile (Input foto jika ingin mengubah)</label>
                            <input accept=".jpg,.png,.jpeg" type="file" class="form-control" id="edit_foto_profile" name="foto_profile" onchange="document.getElementById('edit_view_foto').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 20px;">
                            <label for="edit_file_ttd" style="font-size: 14px;">TTD (Input foto jika ingin mengubah)</label>
                            <input accept=".jpg,.png,.jpeg" type="file" class="form-control" id="edit_file_ttd" onchange="document.getElementById('edit_view_foto_ttd').src = window.URL.createObjectURL(this.files[0])" name="file_ttd">
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

    $("#add-checkbox-new-password").change(function() {
        if(this.checked) {
            $('#add_new_password').attr('type','text');
        }else{
            $('#add_new_password').attr('type','password');
        }
    });

    $("#add-checkbox-confirm-password").change(function() {
        if(this.checked) {
            $('#add_confirm_password').attr('type','text');
        }else{
            $('#add_confirm_password').attr('type','password');
        }
    });

    function tambahData() {
        $('#add_username').val('');
        $('#add_fullname').val('');
        $('#add_nip').val('');
        $('#add_new_password').val('');
        $('#add_confirm_password').val('');
        $('#add_view_foto').attr('src','');
        $('#add_view_foto_ttd').attr('src','');
        $('#add_foto_profile').val('');
        $('#add_file_ttd').val('');
        $('#modal_tambah').modal('show');
    }

    function showFilter() {
        $('#modal_filter').modal('show');
    }

    function saveButton() {
        var new_password = $('#add_new_password').val();
        var confirm_password = $('#add_confirm_password').val();
        if(new_password == confirm_password){
            if(confirm('Are you sure?')){
                $('#modal_tambah').modal('hide');
                $('#form-tambah').submit();
            }
        }else{
            alert('Password dan confirm password tidak sama!');
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
        $('#edit_foto_profile').val('');
        $('#edit_file_ttd').val('');
        $('#id_edit').val('');
        $.ajax({
            url: '/user/get_data',
            type: 'GET',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(response) {
                if(response){
                    $('#id_edit').val(response.id);
                    $('#edit_username').val(response.username);
                    $('#edit_fullname').val(response.fullname);
                    $('#edit_nip').val(response.nip);
                    $('#edit_id_role').val(response.id_role).change();
                    $('#edit_view_foto').attr('src',response.foto_profile);
                    $('#edit_view_foto_ttd').attr('src',response.file_ttd);
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
        window.open('/user/show?link='+full_path);
    }
</script>
@endsection