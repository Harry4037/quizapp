@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Category Management
        </h1>
        @include('layout.admin.breadcrumbs')
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Category Edit</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal form-label-left" action="{{ route('admin.category.edit', $category) }}" method="post" id="categoryForm" enctype="multipart/form-data">
                        @csrf
                        @include('admin.category._form')
                    </form>
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

        $("#categoryForm").validate({
            rules: {
                icon: {
                    accept: "image/*",
                },
                category_name: {
                    required: true
                }
            },
            messages: {
                icon: {
                    accept: "Not valid image type"
                }
            }
        });
        $(document).on('keydown', "#category_name", function (e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (((charCode == 8) || (charCode == 48) || (charCode == 57) || (charCode == 32) || (charCode == 46) || (charCode >= 35 && charCode <= 40) || (charCode >= 65 && charCode <= 90))) {
            return true;
        } else {
            return false;
        }
    });

    });
</script>
@endsection