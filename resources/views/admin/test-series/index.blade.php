@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Test Series Management
        </h1>
        @include('layout.admin.breadcrumbs')
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('errors.errors-and-messages')
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Test Series List</h3>
                        <div class="pull-right">
                            <a href="{{route('admin.test-series.add')}}" class="btn btn-block btn-primary">Add</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="list" class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th style="width: 4%;">Sr. No.</th>
                                    <th style="width: 8%;">User_name</th>
                                    <th style="width: 8%;">Exam</th>
                                    <th style="width: 7%;">Subject</th>
                                    <th style="width: 26%;">Name</th>
                                    <th style="width: 8%;">Total_ques</th>
                                    <th style="width: 10%;">Series_time</th>
                                    <th style="width: 11%;">Status</th>
                                    <th style="width: 18%;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('script')
<script>

    var t = $('#list').DataTable({
        lengthMenu: [[10, 25, 50], [10, 25, 50]],
        searching: true,
        processing: true,
        serverSide: true,
        stateSave: true,
        language: {
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-refresh fa-spin"></i>'
        },
        ajax: "{{route('admin.test-series.list')}}",
        "columns": [
            {"data": null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {"data": "user_name", sortable: false},
            {"data": "exam", sortable: false},
            {"data": "subject", sortable: false},
            {"data": "name", sortable: false},
            {"data": "total_ques", sortable: false},
            {"data": "series_time", sortable: false},
            {"data": "status", sortable: false},
            {"data": "action", sortable: false},
        ]
    });

    $(document).ready(function () {

        $(document).on("click", ".accept_ques", function () {

            var record_id = this.id;
            var th = $(this);
            var status = th.attr('data-status');
            var update_status = (status == '1') ? 1 : 2;
            $.ajax({
                url: "{{route('admin.test-series.accept-ques')}}",
                type: 'post',
                data: {status: update_status, record_id: record_id},
                dataType: 'json',
                beforeSend: function () {
                    $(".overlay").show();
                },
                success: function (res) {

                    if (res.status)
                    {
                        th.attr('data-status', res.data.status);
                        showSuccessMessage(res.data.message);
                        $(".overlay").hide();
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        showErrorMessage(res.message);
                        $(".overlay").hide();
                    }
                }
            });

        });

        $(document).on("click", ".reject_ques", function () {

            var record_id = this.id;
            var th = $(this);
            var status = th.attr('data-status');
            var update_status = (status == '1') ? 2 : 3;
            $.ajax({
                url: "{{route('admin.test-series.reject-ques')}}",
                type: 'post',
                data: {status: update_status, record_id: record_id},
                dataType: 'json',
                beforeSend: function () {
                    $(".overlay").show();
                },
                success: function (res) {

                    if (res.status)
                    {
                        th.attr('data-status', res.data.status);
                        showSuccessMessage(res.data.message);
                        $(".overlay").hide();
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        showErrorMessage(res.message);
                        $(".overlay").hide();
                    }
                }
            });

        });

        $(document).on("click", ".delete", function () {
            var record_id = this.id;
            deletePopup(
                    "Deleting Test Series",
                    "Are you sure want to delete this Test Series?",
                    record_id,
                    "{{route('admin.test-series.delete')}}"
                    );
        });

    });
</script>
@endsection
