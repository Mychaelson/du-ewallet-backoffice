@extends('layouts.template.app')

@section('content_css')
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>

    </style>
@endsection
@section('content_body')
    <div class="container mt-4">
        <div class="card m-4">
            <div class="card-header">
                <div class="float-right flex">
                    <form action="{{ route('report.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-2">
                                <button class="btn btn-outline-primary"><i class="fa fa-arrow-left"></i></button>
                            </div>
                            <div class="col-2">
                                <span class="btn btn-outline-primary"><i class="fa fa-folder-open"></i>
                                    <input type="file" id="file-upload" name="image"
                                        style="position:absolute;top:0;left:0;width:40px;height:34px;opacity:0;cursor:pointer;"></span>
                            </div>
                            <div class="col-5">
                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#content">
                                    Add Content
                                </a>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-primary">Save</button>
                            </div>
                        </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row m-2">
                    <div class="col-md-6">
                        <img src="{{ asset('img/dupay_logo.png') }}" class="w-50" style="background-color: black">
                    </div>
                    <div class="col-md-6 text-right">
                        <h5><strong>PT Yamisok Platform Indonesia</strong></h5>
                        <h6>www.yamisok.com</h6>
                    </div>
                </div>
                <div class="form-floating p-5" style="height: 950px">
                    <center>
                        <h1>BERITA ACARA</h1>
                    </center>
                    <input type="text" id="" name="subject" class="w-100"
                       required style="height: 40px; text-align: center;border: none; outline: 0; font-size:26px;"
                        placeholder="REPORT SUBJECT">
                    <input type="text" id="" name="number" class="w-100 mb-4"
                    required style="height: 40px; text-align: center;border: none; outline: 0; font-size:26px;"
                        placeholder="REPORT NUMBER">
                    <input type="hidden" name="content" id="get-content">
                    </form>
                    <div id="result-content" class="mt-4">

                    </div>
                    <div style="position: absolute; top:80%; width:93%">
                        <hr>
                        <h5 style="color: gray">Attachments</h5>
                        <h5 style="color: gray" id="file-upload-filename"></h5>
                    </div>
                </div>
            </div>

            <div class="card-footer text-muted ">

            </div>
        </div>
    </div>

    <!---Moda content-->
    <div class="modal fade" id="content" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CONTENT EDITOR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating h-auto">
                        <textarea name="content" id="editor" rows="30">

                        </textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" id="close"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn-save-content" class="btn btn-outline-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!--------------->
@endsection
@section('content_js')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
      var input = document.getElementById( 'file-upload' );
        var infoArea = document.getElementById( 'file-upload-filename' );

        input.addEventListener( 'change', showFileName );

        function showFileName( event ) {
        var input = event.srcElement;
        var fileName = input.files[0].name;
        infoArea.textContent = 'File name: ' + fileName;
        }

        $('#editor').summernote({
            placeholder: 'Hello Bootstrap 4',
            tabsize: 2,
            height: 400
        });

        $(document).ready(function() {
            $("#btn-save-content").click(function() {
                var res = $('#editor').val();
                $("#result-content").html(res);
                $("#get-content").val(res);
                $("#close").click();
            });
        });
    </script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>

@endsection
