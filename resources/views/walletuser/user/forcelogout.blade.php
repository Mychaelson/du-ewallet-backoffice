@extends('layouts.template.app')

@section('content_body')
<div class="content d-flex flex-column flex-column-fluid" style="padding-top:0px;" id="kt_content">
<form action="{{route('user.banpost', ['id' => $user->id])}}" method="POST">
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ $page_title }}</h5>
            <!--end::Title-->
            <!--begin::Separator-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
            <!--end::Separator-->
        </div>
        <!--end::Details-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-primary pull-right HandlingError" style="margin-right: 10px">Save</button>
            <!--begin::Button--> 
            <a href="{{route('user.detail', ['id' => $user->id])}}" class="btn btn-default font-weight-bold">Back</a>
            <!--end::Button-->
        </div>
        <!--end::Toolbar-->
    </div>
</div>
<div id="d-flex flex-column-fluid">
    <div class="" style="margin-left: 15px; margin-right: 15px;">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-custom gutter-t">
                    <div class="card-header h-auto py-4">
                        <div class="card-title">General Info</div>
                    </div>
                    <div class="card-body py-4">
                        <div class="">
                            <table class="table">
                                <tr>
                                <th>ID</th>
                                <th><?= $user->id ?></th>
                                </tr>
                                <tr>
                                <th>Name</th>
                                <th><?= $user->name ?></th>
                                </tr>
                                <tr>
                                <th>Nickname</th>
                                <th><?= $user->nickname ?></th>
                                </tr>
                                <tr>
                                <th>Phone</th>
                                <th><span style="color:#337ab7;"><?= $user->phone ?></span></th>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
            <div class="card card-custom gutter-t">
            <div class="card-header h-auto py-4">
                        <div class="card-title">Document & Report</div>
                    </div>
                    <div class="card-body py-4">
                    <div class="form-group">
                            <label for="field-document">Document</label>
                            <input type="text" id="field-document" name="document" placeholder="Document" class="form-control" />
                    </div>
                    <div class="form-group">
                            <label for="field-reason">Reason</label>
                            <textarea id="field-reason" name="reason" placeholder="Reason" rows="5" class="form-control" style="resize:none"></textarea>
                    </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-t">
                <div class="card-header h-auto py-4">
                    <div class="card-title">List History Force Logout</div>
                </div>
                <div class="card-body py-4">
                <div class="s">
                <table class="datatablez table table-bordered">
                    <thead>
                    <th>Operator</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Reason</th>
                    </thead>

                    <tbody>
                    @if(isset($listLog))
                        <?php $i=0; ?>
                        <?php foreach($listLog as $ls) : ?>
                        <tr>
                            <td><?= isset($ls->name_user->name) ? $ls->name_user->name." - ".$ls->name_user->role_name : "" ?></td>
                            <td><?= isset($ls->type) ? $ls->type : "" ?></td>
                            <td><?= isset($ls->created) ? $ls->created : "" ?></td>
                            <td><?= isset($ls->content['reason']) ? $ls->content['reason'] : "" ?></td>
                        </tr>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                    @else
                    <tr>
                        <td colspan="4" style="text-align: center;">
                            NO DATA FOUND
                        </td>
                    </tr>
                    @endif
                    </tbody>
                </table>
                </div>
            </div>
            </div>
        </div>
        </div><!-- Row -->
    </div>
</div><!-- Main Wrapper -->
</form>
</div>

@endsection

@section('content_js')

@endsection
