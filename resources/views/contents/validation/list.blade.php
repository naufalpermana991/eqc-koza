<style>
    #tb-data thead th {
        text-align: center;
        background-color: #b9161c !important;
        color: white !important;
    }
    #tb-data tbody td {
        text-align: center;
    }

    .checkbox-size{
        /* Memastikan ukuran checkbox yang lebih besar */
        transform: scale(1.5); /* Skala 1.5x dari ukuran asli */
        -webkit-transform: scale(1.5); /* Untuk WebKit-browsers */
        -moz-transform: scale(1.5); /* Untuk Firefox */
        -ms-transform: scale(1.5); /* Untuk Internet Explorer */
        -o-transform: scale(1.5); /* Untuk Opera */
        margin-top: 5px;
    }
</style>
<div class="row">
    <div class="col-md-12 text-center">
        <h3><?= $title ?></h3>
        <p class="mb-4">Review and approve checking inspection file</p>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="id_customer">Customer Name</label>
                        <select name="id_customer" id="id_customer" class="form-select">
                            <?php foreach ($data_customer as $value): ?>
                                <option <?= ($id_customer == $value->id)? 'selected':'' ?>  value="<?= $value->id ?>"><?= $value->customer_name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-sm btn-primary" type="button" style="margin-top: 20px;" onclick="refreshPage()"><i data-feather="search"></i></button>
                    </div>
                    <div class="col-md-12 mt-4">
                        <button type="button" style="width: 150px;height: 30px;" class="btn btn-success" id="validasi_submit"><i class="fa fa-check"></i> Check All</button>
                        <div class="table-responsive" style="height: 510px;">
                            <table id="tb-data" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="checkbox-size" id="check-all"></th>
                                        <th>File Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-table">
                                    <?php foreach ($data as $value): ?>
                                        <tr>
                                            <td><input type="checkbox" class="checked-item checkbox-size" value="<?= $value['path'] ?>?<?= $value['id_customer'] ?>"></td>
                                            <td><?= $value['file_name'] ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" title="Show" onclick="showFile('<?= $value['path'] ?>')"><i class="fa fa-eye"></i> Show</button>
                                                <a href="/validation/checked_file?path=<?= $value['path'] ?>&id=<?= $value['id_customer'] ?>" onclick="return confirm('Are you sure?')"><button type="button" class="btn btn-sm btn-primary" title="Hapus"><i class="fa fa-check"></i> Check</button></a>
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
<form class="forms-sample" action="/validation/checked_file_batch" id="form-batch" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="path_all" id="path_all">
</form>

@section('custom-script')
<script>
    $(window).on('beforeunload', function (event) {
        setGlobalLoading(true);
    });

    // Check All
    $('#check-all').on('change', function() {
        $('.checked-item').prop('checked', $(this).prop('checked'));
    });

    // Update "Check All" berdasarkan status checkbox individual
    $('.checked-item').on('change', function() {
        var allChecked = $('.checked-item').length === $('.checked-item:checked').length;
        $('#check-all').prop('checked', allChecked);
    });

    $('.checked-item').on('change', function() {
        var totalCheckboxes = $('.checked-item').length;
        var checkedCheckboxes = $('.checked-item:checked').length;

        if (checkedCheckboxes === 0) {
            $('#check-all').prop('indeterminate', false).prop('checked', false);
        } else if (checkedCheckboxes === totalCheckboxes) {
            $('#check-all').prop('indeterminate', false).prop('checked', true);
        } else {
            $('#check-all').prop('indeterminate', true);
        }
    });

    $(document).ready(function() {
        $('#tb-data').DataTable( {
            "info": false,
            "paging": false,
            "searching": false,
            "sort": false
        });
    });

    function refreshPage() {
        var id_customer = $("#id_customer").val();
        window.location.replace("/validation?id="+id_customer);
    }

    function downloadFile(full_path) {
        window.open('/validation/download?link='+full_path);
    }

    function showFile(full_path) {
        window.open('/validation/show?link='+full_path);
    }

    $('#validasi_submit').on('click', function() {
        var path_all = [];
        // Mendapatkan nilai dari checkbox yang dicentang
        var checkedValues = $('.checked-item:checked').map(function() {
            path_all.push($(this).val());
        }).get();

        if(path_all.length > 0){
            if(confirm('Are you sure?')){
                setGlobalLoading(true);
                $('#path_all').val(JSON.stringify(path_all));
                $('#form-batch').submit();
            }
        }else{
            alert('Pilih file terlebih dahulu');
        }
    });
</script>
@endsection