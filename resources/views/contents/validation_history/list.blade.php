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
    <div class="col-md-12 text-center">
        <h3 class="mb-4"><?= $title ?></h3>
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
                    <div class="col-md-12 mt-2">
                        <div class="table-responsive" style="height: 510px;">
                            <table id="tb-data" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>Leader Checking</th>
                                        <th>Supervisor Checking</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-table">
                                    <?php foreach ($data as $value): ?>
                                        <tr>
                                            <td><?= $value['file_name'] ?></td>
                                            <td><?= ($value['leader'] == false)? "-" : 'Leader <i style="color:green !important;" class="fa fa-check"></i>' ?></td>
                                            <td><?= ($value['spv'] == false)? "-" : 'Supervisor <i style="color:green !important;" class="fa fa-check"></i>' ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" title="Show" onclick="showFile('<?= $value['path'] ?>')"><i class="fa fa-eye"></i> Show</button>
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
                        <input type="date" class="form-control" id="to_date" value="<?= date('Y-m-t') ?>"/>
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

    function refreshPage() {
        var id_customer = $("#id_customer").val();
        window.location.replace("/val_history?id="+id_customer);
    }

    function showDetail(full_path) {
        window.open(full_path);
    }

    function showFile(full_path) {
        window.open('/val_history/show?link='+full_path);
    }
</script>
@endsection