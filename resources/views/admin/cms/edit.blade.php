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
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">CMS Edit</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal form-label-left" action="{{ route('admin.cms.edit', $cms) }}" method="post" id="cmsForm">
                        @csrf
                        @include('admin.cms._form')
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
<script src="{{ asset("/vendor/unisharp/laravel-ckeditor/ckeditor.js") }}"></script>
<script>
    @if($cms->id != 3)
CKEDITOR.replace('description', {
    removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor',
    removePlugins: 'image, link',
});
@endif

$(document).ready(function () {

    $("#cmsForm").validate({
        rules: {
            page_name: {
                required: true,
            },
            @if($cms->id != 3)
            description: {
                required: function (textarea) {
                    CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                    var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
                    return editorcontent.length === 0;
                }
            },
        @else
            description: {
                required: true
            },
        @endif
        },
    });

});
</script>
@endsection