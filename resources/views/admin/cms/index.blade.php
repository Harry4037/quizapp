@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CMS Management
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
                        <h3 class="box-title">CMS List</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="list" class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Page Name</th>
                                    <!--<th>Description</th>-->
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
    $(document).ready(function () {

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
            ajax: "{{route('admin.cms.list')}}",
            "columns": [
                {"data": null,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "page_name", sortable: false},
//                {"data": "description", sortable: false},
                {"data": "action", sortable: false},
            ]
        });

    });
</script>
@endsection
