@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Notification Management
        </h1>
        @include('layout.admin.breadcrumbs')
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('errors.errors-and-messages')
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Notification</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <form class="form-horizontal form-label-left" action="{{ route('admin.notification.send') }}" method="post" id="sendNotificationForm">
                            @csrf
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Select option</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" id="user_type" name="user_type">
                                        <option value="">Choose option</option>
                                        <option value="1">All User's</option>
                                        <option value="2">Selected User's</option>
                                    </select>
                                </div>
                            </div>
                            <div style="display:none;" id="users_list_div">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Search User</label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" id="search_user" name="search_user" placeholder="Search...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Users</label>
                                    @if($users)
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="users_list" style="overflow-y: scroll;height: 200px;">
                                        <p style="padding: 5px;">
                                            @foreach($users as $key => $user)
                                        <div class="col-md-6 col-sm-6 col-xs-6" style="padding-bottom: 4px;">
                                            <input class="flat" type="checkbox" name="notify_user[]" value="{{ $user->id }}"> 
                                            @if(strlen($user->name) > 0)
                                            <label>{{ $user->mobile_number.' ('.ucwords($user->name).')' }}</label>
                                            @else
                                            <label>{{ $user->mobile_number }}</label>
                                            @endif
                                        </div>

                                        @endforeach
                                        </p>
                                        <span id="users_list_div_error"></span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control" name="title" placeholder="Title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Message</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea  class="form-control" name="message" id="message" placeholder="Message"></textarea>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                    <button type="submit" class="btn btn-success">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Notification List</h3>
                    </div>
                    <div class="box-body">
                        <table id="list" class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
            ajax: "{{route('admin.notification.list')}}",
            "columns": [
                {"data": null,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "title", sortable: false},
                {"data": "message", sortable: false},
                {"data": "created_at", sortable: false},
            ]
        });

        $(document).on("change", "#user_type", function () {
            var record_id = $("#user_type :selected").val();
            if (record_id == 2) {
                $("#users_list_div").css("display", "block");
            } else {
                $("#users_list_div").css("display", "none");
            }
        });

        $("#sendNotificationForm").validate({
            ignore: [],
            rules: {
                user_type: {
                    required: true
                },
                title: {
                    required: true,
                    maxlength: 50,
                },
                "notify_user[]": {
                    required: function () {
                        return $("#user_type").val() == 2
                    }
                },
                message: {
                    required: true,
                    maxlength: 100,
                },
            },

            errorPlacement: function (error, el) {
                if ($(el).attr('type') == 'checkbox') {
                    error.appendTo("#users_list_div_error");
                } else {
                    error.insertAfter(el);
                }
            },

            messages: {
                user_type: {
                    required: "Please select a user type."
                },
                title: {
                    required: "Please enter the title."
                },
                "notify_user[]": {
                    required: "Please select at least one user."
                },
                message: {
                    required: "Please enter the message."
                },
            },
            submitHandler: function (form) {

                let btn = $(form).find('button[type="submit"]');

                btn.text('Sending . . .').attr('disabled', 'disabled');

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        btn.text('Send').removeAttr('disabled');
                        t.draw();
                        if (response.status_code == 200) {
//                            $(".msg").html(response.message);
                            showSuccessMessage(response.message);
                            $(form).get(0).reset();
                        } else {
//                            $(".msg").html(response.message);
                            showErrorMessage(response.message);
                        }

                        setTimeout(function () {
                            $(".msg").fadeOut();
                            location.reload();
                        }, 2000);
                    },

                    error: function () {
                        btn.text('Send').removeAttr('disabled');
                    }
                });
            }
        });

        $(document).on('keyup', "#search_user", function () {
            var search_keyword = $(this).val();
            $.ajax({
                url: "{{route('admin.notification.search-user')}}",
                type: 'get',
                data: {
                    search_keyword: search_keyword
                },
                beforeSend: function () {
                    $(".overlay").show();
                },
                success: function (response) {
                    $(".overlay").hide();
                    $('#users_list').html(response);
                },
            });
        });

    });
</script>
@endsection