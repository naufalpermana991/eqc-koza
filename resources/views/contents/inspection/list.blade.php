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
                        <button type="button" class="btn btn-sm btn-success" onclick="tambahData()"><i data-feather="plus"></i> Create Inspection</button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="showFilter()"><i data-feather="filter"></i> Filter</button>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="table-responsive" style="height: 510px;">
                            <table id="tb-data" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Inspected Date</th>
                                        <th>Inspected By</th>
                                        <th>File Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-table">
                                    <?php foreach ($data as $value): ?>
                                        <tr>
                                            <td><?= $value->inspected_date ?></td>
                                            <td><?= $value->created_by ?></td>
                                            <td><?= $value->file_name ?>.xlsx</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" title="Show" onclick="showFile('<?= $value->inspected_file ?>')"><i class="fa fa-eye"></i></button>
                                                <button type="button" class="btn btn-sm btn-success" title="Download" onclick="showDetail('<?= $value->inspected_file ?>')"><i class="fa fa-file-excel-o"></i></button>
                                                <a href="/inspection/delete_data?id=<?= $value->id ?>" onclick="return confirm('Are you sure?')"><button type="button" class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></button></a>
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
            <form class="forms-sample" id="form-tambah" action="/inspection/create" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_detail_label">Create Inspection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="inspected_date">Inspected Date</label>                
                            <input type="date" class="form-control" id="inspected_date" name="inspected_date" value="<?= date('Y-m-d') ?>" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="inspected_time">Inspected Time</label>                
                            <input type="time" class="form-control" id="inspected_time" name="inspected_time" value="<?= date('H:i:s') ?>" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="file_name">File Name</label>                
                            <input type="text" class="form-control" id="file_name" name="file_name" value="" placeholder="Input Nama File" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="inspected_file">File Inspection</label>                
                            <input type="file" class="form-control" id="inspected_file" name="inspected_file" accept=".xlsx" value="" required />
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

<div class="modal fade" id="modal_filter" tabindex="-1" aria-labelledby="modal_filter_label" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_filter_label">Filter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="from_date">From Date</label>                
                        <input type="date" class="form-control" id="from_date" value="<?= date('Y-m-01') ?>" />
                    </div>
                    <div class="col-md-12 mt-2">
                        <label for="to_date">To Date</label>                
                        <input type="date" class="form-control" id="to_date" value="<?= date('Y-m-d') ?>"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="showData()"><i class="fa fa-search"></i> Search</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_detail" tabindex="-1" aria-labelledby="modal_detail_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_detail_label">File Inspection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- <iframe id="file_iframe" src="" width="100%" height="400px" type="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"></iframe> -->
                        <iframe id="file_iframe" src="data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,base64_encoded_content_here" width="100%" height="600"></iframe>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
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
        $('#inspected_date').val('<?= date('Y-m-d') ?>').change();
        $('#inspected_time').val('<?= date('H:i:s') ?>').change();
        $('#file_name').val('');
        $('#inspected_file').val('');
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

    function showData() {
        setGlobalLoading(true);
        $('#tb-data').DataTable().destroy();
        $('#tbody-table').html('');
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        $('#modal_filter').modal('hide');
        $.ajax({
            url: '/inspection/get_data_inspection',
            type: 'GET',
            dataType: 'json',
            data: {
                from_date: from_date,
                to_date: to_date
            },
            success: function(response) {
                if(response){
                    var html = '';
                    for (var i = 0; i < response.length; i++) {
                        html += `<tr>
                        <td>`+response[i].inspected_date+`</td>
                        <td>`+response[i].created_by+`</td>
                        <td>`+response[i].file_name+`.xlsx</td>
                        <td>
                        <button type="button" class="btn btn-sm btn-info" title="Show" onclick="showFile('`+response[i].inspected_file+`')"><i class="fa fa-eye"></i></button>
                        <button type="button" class="btn btn-sm btn-success" title="Download" onclick="showDetail('`+response[i].inspected_file+`')"><i class="fa fa-file-excel-o"></i></button>
                        <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="hapusData('`+response[i].id+`')"><i class="fa fa-trash"></i></button>
                        </td>
                        </tr>`;
                    }

                    $('#tbody-table').html(html);
                    $('#tb-data').dataTable( {
                        "info": false,
                        "sort": false
                    });
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
        window.open('/inspection/show?link='+full_path);
    }
</script>
@endsection