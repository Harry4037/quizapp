@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Subject Management
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
                        <h3 class="box-title">Subject List</h3>
                        <div class="pull-right">
                            <a href="{{route('admin.subject.add')}}" class="btn btn-block btn-primary">Add</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="list" class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Action</th>
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
        ajax: "{{route('admin.subject.list')}}",
        "columns": [
            {"data": null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {"data": "name", sortable: false},
            {"data": "action", sortable: false},
        ]
    });

    $(document).ready(function () {

        $(document).on("click", ".delete", function () {
            var record_id = this.id;
            deletePopup(
                    "Deleting Subject",
                    "Are you sure want to delete this subject?",
                    record_id,
                    "{{route('admin.subject.delete')}}"
                    );
        });
    });
</script>
@endsection
