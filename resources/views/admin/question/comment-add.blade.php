@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Comment Management
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
                        <h3 class="box-title">Comment Add</h3>
                     
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                   
                        <form class="form-horizontal form-label-left" action="{{ route('admin.question.comment-add',$question) }}" method="post" id="quizForm" enctype="multipart/form-data">
                            @csrf   
							
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Message <span class="error">*</span></label>
                                    <div class="col-md-4 col-sm-6 col-xs-6">
                                        <input placeholder="message" type="test" class="form-control" name="message" id="message"  Required>
                                    </div>
                                </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-5">
                                        <a class="btn btn-default" href="{{ route('admin.question.index') }}">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
							
                            <!-- /.box-footer -->
                         </form>  
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
