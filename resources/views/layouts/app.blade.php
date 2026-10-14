<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="KST Developer Team">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('assets/images/') }}/logo-icon.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendors/core/core.css') }}">
    <!-- endinject -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->

    <!-- Layout styles -->  
    <link rel="stylesheet" href="{{ URL::asset('assets/css/demo1/style.css') }}">
    <!-- End layout styles -->

    <!-- Datatables -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
    <!-- / End datatables -->

    <!-- Online libraries -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- / End online libraries -->

    <link rel="stylesheet" href="{{ URL::asset('assets/jqx12/jqwidgets/styles/jqx.base.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/jqx12/jqwidgets/styles/jqx.classic.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/jqx12/jqwidgets/styles/jqx.light.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- core:js -->
    <script src="{{ URL::asset('assets/vendors/core/core.js') }}"></script>
    <!-- endinject -->

    <!-- Datatables -->
    <script src="{{ URL::asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
    <!-- / End datatables -->
    <script src="{{ URL::asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/amcharts/core.js') }}"></script>
    <script src="{{ URL::asset('assets/amcharts/charts.js') }}"></script>
    <script src="{{ URL::asset('assets/amcharts/animated.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/autocomplete/dist/jquery.autocomplete.min.js') }}"></script>

    <style type="text/css">
        .autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
        .autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
        .autocomplete-selected { background: #F0F0F0; }
        .autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
        .autocomplete-group { padding: 2px 5px; }
        .autocomplete-group strong { display: block; border-bottom: 1px solid #000; }
    </style>
    <style type="text/css">
        body {
            font-family: "Overpass", sans-serif;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .card .card-title {
            color: #000;
            margin-bottom: 1.2rem;
            text-transform: uppercase;
            font-size: .875rem;
            font-weight: 600;
        }

        .btn i, .fc .fc-button i, .swal2-modal .swal2-actions button i, .wizard > .actions a i, .wizard > .actions a:hover i, .wizard > .actions .disabled a i {
            font-size: 1rem;
        }

        .fa {
            display: inline-block;
            font: normal normal normal 14px/1 FontAwesome;
            font-size: inherit;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .btn a,
        .btn a i,
        .fa { color: white !important; }
        input,
        textarea,
        button,
        th,
        td {
            /*text-transform: uppercase !important;*/
        }

        .btn-primary {
            background: #0C5E9C !important;
        }

        .btn-primary:hover {
            background: #3991d3 !important;
        }

        .btn {
            color: white !important;
            line-height: 1 !important;
        }

        table .btn {
            margin-right: 10px;
        }

        .fa-sidebar {
            font-size: 18px !important;
            margin-right: -10px !important;
        }

        .imagePreview {
            width: 100%;
            height: 300px;
            margin-top: 10px;
            margin-right: 50px;
            /*background: url('');*/
            background-position: center center;
            background-size: cover;
            box-shadow: 0px 1px 2px 0px black;
            -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
            -moz-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
            display: inline-block;
        }

        .img-garuda {
            width: 30px;
            margin-right: 5px;
        }

        .imagePreview.circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }

        .imagePreview input.upload {
            position: absolute;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
            width: 100%;
            height: 260px;
        }

        .imagePreview.circle input.upload {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }

        table.table tbody tr td {
            padding: 4px 10px !important;
        }

        legend {
            margin-bottom: 5px;
            font-size: 14px !important;
            font-weight: bold !important;
        }

        img.img-list {
            width: 100px !important;
            height: 100px !important;
            border-radius: 10px !important;
            object-fit: cover !important;
        }

        .navbar,
        .sidebar-header {
            background: #0C5E9C !important;
        }

        .navbar {
            z-index: 1 !important;
        }

        .modal {
            z-index: 99999 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            margin-top: -10px !important;
        }

        span[id^="jqxWidget"] {
            color: transparent !important;
        }

        .jqx-grid-cell-alt {
            background: #fcfcfc !important;
        }

        .card-title {
            font-size: 16px !important;
        }

        /*#jqxgrid {
            height: 400px !important;
            }*/

            .jqx-grid a.btn {
                padding: 3px 10px !important;
                font-size: 14px !important;
            }

            .jqx-grid-column-header span {
                font-size: 14px !important;
                text-transform: uppercase !important;
            }

            .jqx-grid-cell-selected {
                /*background-color: red !important;*/
            }

            .jqx-listitem-state-selected-light,
            .jqx-menu-item-selected-light,
            .jqx-tree-item-selected-light,
            .jqx-calendar-cell-selected-light,
            .jqx-grid-cell-selected-light,
            .jqx-menu-item-top-selected-light,
            .jqx-grid-selectionarea-light,
            .jqx-input-button-header-light,
            .jqx-input-button-innerHeader-light {
                /*background-color: red !important;*/
                /*background: red !important;*/
            }

            .jqx-grid-cell-selected-light {
                /*background-color: red !important;*/
                /*background: red !important;*/
            }

            .btn {
                padding: 5px 15px;
                font-size: 14px !important;
                text-transform: capitalize !important;
            }

            label {
                text-transform: capitalize !important;
            }

            ._tableObjectStyle>thead>tr>th {
                color: black !important;
                font-size: 14px !important;
            }

            .btn-jqxgrid {
                padding: 10px !important;
                margin-left: 5px;
                margin-top: 0px !important;
            }

            .btn-search {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                height: 35px;
            }

            .no-border {
                background: transparent !important;
                border: none !important;
                padding: 0 !important;
            }

            .form-group select {
                color: black !important;
                /*margin-top: -7px !important;*/
            }

            .form-group input {
                /*margin-top: -7px !important;*/
            }

            .form-group label {
                margin-bottom: 6px !important;
            }

            .table .input-group {
                margin-bottom: -5px !important;
                margin-top: 3px !important;
            }

            .form-group {
                margin-bottom: 0px !important;
            }

            .input-group-text {
                height: 30px !important;
                padding: 5px 15px !important;
            }

            .btn-search {
                height: 30px !important;
                padding: 5px 15px !important;
            }

            /*input.form-control,
            select.form-control {
                font-size: 14px !important;
                padding: 2px 5px !important;
                height: 30px !important;
                margin-bottom: 5px !important;
            }*/

            .nav-tabs .nav-link.active,
            .nav-tabs .nav-item.show .nav-link {
                color: #0C5E9C !important;
                font-weight: bold;
            }

            .ui-datepicker select.ui-datepicker-month,
            .ui-datepicker select.ui-datepicker-year {
                float: left !important;
                color: black !important;
                width: 50% !important;
            }

            .marker {
                background-size: cover;
                width: 15px;
                height: 22px;
                cursor: pointer;
            }

            .markerWm {
                background-size: cover;
                width: 25px;
                height: 25px;
                cursor: pointer;
            }

            .mapboxgl-popup {
                max-width: 200px;
            }

            .mapboxgl-popup-content {
                text-align: left;
            }

            .map {
                position: absolute;
                bottom: 0;
                top: 0;
                left: 0;
                right: 0;
                width: 100%;
            }

            .modal table.table-kampret tbody tr td {
                padding: 5px !important;
            }

            table.table-kampret tbody tr td {
                padding: 0 !important;
            }

            table.table-kampret .form-group input,
            table.table-kampret .form-group select {
                margin-top: 0 !important;
                border: none !important;
            }

            table.table-kampret .input-group {
                margin-bottom: 0 !important;
                margin-top: 0 !important;
            }

            table.table-kampret .input-group input {
                background-color: white !important;
                border: none !important;
            }

            table.table-kampret .form-control[readonly] {
                background-color: white !important;
            }

            .jqx-grid-cell-left-align {
                /*margin-top: 0px !important;*/
            }

            .ui-widget.ui-widget-content {
                z-index: 999 !important;
            }

            .jqx-widget-light .jqx-grid-column-header-light {
                background-color: #0C5E9C !important;
                color: white !important;
            }

            .card .card-body {
                padding: 1.5rem 1rem !important;
            }

        }
    </style>

    <title>{{ $title ?? 'ProjectBase' }}</title>
</head>
<body>

    <div class="main-wrapper">

        <!-- Sidebar -->
        @include('components.sidebar')
        <!-- End Sidebar -->

        <div class="page-wrapper">

            <!-- Navbar -->
            @include('components.navbar')
            <!-- / End Navbar -->

            <!-- Livewire:content -->
            <div class="page-content">
                @include('components.alerts')

                @include($content)
            </div>
            <!-- End livewire:content -->

        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="modal-ganti-password" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Password</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 20px;">
                            <label for="gp_new_password" style="font-size: 14px;">New Password</label>
                            <input type="password" class="form-control" id="gp_new_password" placeholder="Input password baru">
                            <input type="checkbox" id="checkbox-new-password"> <label style="color: gray" for="checkbox-new-password">Show Password</label>
                        </div>
                        <div class="col-md-12">
                            <label for="gp_confirm_password" style="font-size: 14px;">Confirm Password</label>
                            <input type="password" class="form-control" id="gp_confirm_password" placeholder="Pastikan password sama dengan di atas">
                            <input type="checkbox" id="checkbox-confirm-password"> <label style="color: gray" for="checkbox-confirm-password">Show Password</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button onclick="gantiPasswordUser()" type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="modal-edit-profile" tabindex="-1">
        <div class="modal-dialog">
            <form id="form-ep-user" action="/user/update_profile" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">User Profile</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 20px;">
                                <img id="ep_pp" style="max-width:100px;max-height: 100px;" src="#" alt="">
                            </div>
                            <div class="col-md-12" style="margin-bottom: 20px;">
                                <label for="ep_foto_profile" style="font-size: 14px;">Change Foto (Input foto jika ingin mengubah)</label>
                                <input accept=".jpg,.png,.jpeg" type="file" class="form-control" id="ep_foto_profile" name="foto_profile" onchange="document.getElementById('ep_pp').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                            <div class="col-md-12" style="margin-bottom: 20px;">
                                <label for="ep_fullname" style="font-size: 14px;">Fullname</label>
                                <input type="text" class="form-control" id="ep_fullname" name="fullname">
                            </div>
                            <div class="col-md-12" style="margin-bottom: 20px;">
                                <label for="ep_nip" style="font-size: 14px;">NIP</label>
                                <input type="text" class="form-control" id="ep_nip" disabled="">
                            </div>
                            <div class="col-md-12" style="margin-bottom: 20px;">
                                <label for="ep_jabatan" style="font-size: 14px;">Jabatan</label>
                                <input type="text" class="form-control" id="ep_jabatan" disabled="">
                            </div>
                            <div class="col-md-12" style="margin-bottom: 20px;">
                                <img id="ep_foto_ttd" style="max-width:100px;max-height: 100px;" src="#" alt="">
                            </div>
                            <div class="col-md-12" style="margin-bottom: 20px;">
                                <label for="ep_file_ttd" style="font-size: 14px;">Change TTD (Input foto jika ingin mengubah)</label>
                                <input accept=".jpg,.png,.jpeg" type="file" class="form-control" id="ep_file_ttd" onchange="document.getElementById('ep_foto_ttd').src = window.URL.createObjectURL(this.files[0])" name="file_ttd">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                        <button onclick="ubahProfile()" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Edit Profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- inject:js -->
    <script src="{{ URL::asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/template.js') }}"></script>
    <!-- endinject -->

    <!-- Custom js for this page -->
    <script src="{{ URL::asset('assets/js/dashboard-light.js') }}"></script>
    <!-- End custom js for this page -->

    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxcore.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxdata.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxbuttons.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxdatatable.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxscrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxmenu.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxcheckbox.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxcombobox.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxlistbox.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxdropdownlist.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxgrid.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxgrid.pager.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxgrid.selection.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxgrid.grouping.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxgrid.aggregates.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxdata.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxgrid.edit.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxgrid.filter.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxgrid.sort.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxgrid.columnsresize.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxinput.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxnumberinput.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxdatetimeinput.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxcalendar.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/globalization/globalize.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/jqwidgets/jqxtreegrid.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/jqx12/scripts/demos.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/block/ui.js') }}"></script>

    <!-- Custom Scripts -->
    <script type="text/javascript">
        $(function(){
            setTimeout(function(){
                $('#flashMessage').hide(300);
            }, 1000);
        });

        // BINDING EDIT
        $(document).on('click', '.btn-edit-data', function () {
            var href = $(this).data('href');
            window.location.href = href;
        });

        // BINDING DETAIL
        $(document).on('click', '.btn-detail-data', function () {
            var href = $(this).data('href');
            window.location.href = href;
        });

        // BINDING DELETE MODAL
        $(document).on('click', '.btn-delete-data', function () {
            var href = $(this).data('href');
            if(confirm('apakah anda yakin?')){
                window.location.href = href;
            }
        });

        // BINDING PRINT
        $(document).on('click', '.btn-print-data', function () {
            var href = $(this).data('href');
            window.open(href);
        });

        function setGlobalLoading(open = null) {
            if (open) {
                $(`.page-content`).block({
                    message: '<h1><i style="color: black !important;" class="fa fa-spinner fa-spin"></i></h1>',
                    css: {
                        backgroundColor: 'transparent',
                        borderColor: 'transparent',
                        color: 'black'
                    }
                });
            } else {
                $(`.page-content`).unblock();
            }
        }

        function showGantiPassword() {
            $('#gp_new_password').val('');
            $('#gp_confirm_password').val('');
            $('#modal-ganti-password').modal('show');
        }

        function showProfile(argument) {
            setGlobalLoading(true);
            $.ajax({
                url: '/user/get_profile',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response){
                        var link_pp = 'assets/images/user.png';
                        if(response.foto_profile != '' && response.foto_profile != null){
                            link_pp = response.foto_profile;
                        }

                        var link_ttd = 'assets/images/noimage.jpg';
                        if(response.file_ttd != '' && response.file_ttd != null){
                            link_ttd = response.file_ttd;
                        }
                        $('#ep_jabatan').val(response.role_name);
                        $('#ep_fullname').val(response.fullname);
                        $('#ep_nip').val(response.nip);
                        $('#ep_pp').attr('src',link_pp);
                        $('#ep_foto_ttd').attr('src',link_ttd);
                        $('#modal-edit-profile').modal('show');
                        setGlobalLoading(false);
                    }else{
                        window.location = '/auth/login';
                        setGlobalLoading(false);
                    }
                }
            });
        }

        function ubahProfile() {
            if(confirm('Are you sure?')){
                setGlobalLoading(true);
                $('#modal-edit-profile').modal('hide');
                $('#form-ep-user').submit();
            }
        }

        function gantiPasswordUser() {
            var new_password = $('#gp_new_password').val();
            var confirm_password = $('#gp_confirm_password').val();
            if(new_password == '' || confirm_password == ''){
                alert('Input password dan confirm password dahulu!');
            }else{
                if(new_password == confirm_password){
                    if(confirm('Apakah anda yakin?')){
                        setGlobalLoading(true);
                        $('#modal-ganti-password').modal('hide');
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '/user/change_password',
                            type: 'POST',
                            data: {
                                new_password: new_password
                            },
                            success:function(res) {
                                alert('Ubah Password Berhasil!');
                                setGlobalLoading(false);
                            }
                        })
                    }
                }else{
                    alert('Password dan confirm password tidak sama!');
                }
            }
        }

        $("#checkbox-new-password").change(function() {
            if(this.checked) {
                $('#gp_new_password').attr('type','text');
            }else{
                $('#gp_new_password').attr('type','password');
            }
        });

        $("#checkbox-confirm-password").change(function() {
            if(this.checked) {
                $('#gp_confirm_password').attr('type','text');
            }else{
                $('#gp_confirm_password').attr('type','password');
            }
        });

        function decimalGenerator(value) {
            let callback = '';
            $.each(value.split(''), function(_, v) {
                if (parseInt(v) >= 0 && parseInt(v) < 10) callback += v;
                if (v == ',') callback += v;
            });
            let split = callback.split(',');
            let strResponse = '';
            let comma = 1;
            if (split[0] != undefined) {
                let str = split[0].toString();
                for (let i = str.length; i > 0; i--) {
                    if (comma == 4) {
                        strResponse += '.';
                        comma = 2; // SET TO 2 'CAUSE REASON THAT I CAN'T FUCKING EXPLAIN, SO DON'T ASK!
                    } else {
                        ++comma;
                    }
                    strResponse += str.substring((i - 1), i);
                }
            }
            strResponse = strResponse.split("").reverse().join("");
            if (split[1] != undefined) {
                let cleanSplit = split[1];
                cleanSplit = cleanSplit.substring(0, 2);
                strResponse += ',' + cleanSplit;
            }
            return strResponse;
        }

        function currency_format(nilai) {
            var result = nilai.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            if(nilai < 0){
                result = '-'+result;
            }
            return result;
        }

        function removeDecimal(value) {
            return parseInt(value.replace(/,/g, ''));
        }

        function shuffleColors(type = 'blue') {
            let color_list = [];
            if (type == 'blue') {
                color_list = [
                am4core.color('#63a8b8'),
                am4core.color('#01b5b4'),
                am4core.color('#b1dede'),
                am4core.color('#a49bca'),
                am4core.color('#1a84c8'),
                am4core.color('#355798')

                ];
            } else {
                color_list = [
                am4core.color('#b94795'),
                am4core.color('#f16c9b'),
                am4core.color('#ef4f5b'),
                am4core.color('#fdd294'),
                am4core.color('#ee9a42'),
                am4core.color('#d08164')
                ];
            }
            let currentIndex = color_list.length,
            randomIndex;

            // While there remain elements to shuffle.
            while (currentIndex != 0) {

                // Pick a remaining element.
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex--;

                // And swap it with the current element.
                [color_list[currentIndex], color_list[randomIndex]] = [
                color_list[randomIndex], color_list[currentIndex]
                ];
            }

            return color_list;
        }
    </script>
    @yield('custom-script')
</body>
</html>
