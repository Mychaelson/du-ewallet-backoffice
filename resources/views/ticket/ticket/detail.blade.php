@extends('layouts.template.app')

@section('content_body')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Detail Ticket</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ $ticket->subject }}</h5>
                </div>
                <!--end::Details-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <!--begin::Button-->
                    <a href="{{ route('ticket-list') }}" class="btn btn-primary font-weight-bold">Back</a>
                    <!--end::Button-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid py-4">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-lg-4">
                        <!--begin::Card-->
                        <div class="card card-stretch card-stretch-half gutter-b">
                            <!--begin::Header-->
                            <div class="card-header h-auto py-4">
                                <div class="card-title">
                                    <h3 class="card-label">Issued By</h3>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-4">
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Name:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket?->user_name ?? $ticket?->user_username }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Phone:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket?->user_phone }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Status:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            @switch($ticket?->user_status)
                                                @case(0)
                                                    <span class="label label-danger label-inline font-weight-bolder mr-2">Not Active</span>
                                                @break

                                                @case(1)
                                                    <span class="label label-success label-inline font-weight-bolder mr-2">Active</span>
                                                @break

                                                @default
                                                    <span class="label label-dark label-inline font-weight-bolder mr-2">Unknown</span>
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Type:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            @switch($ticket?->user_type)
                                                @case(0)
                                                    <span class="label label-danger label-inline font-weight-bolder mr-2">Basic</span>
                                                @break

                                                @case(1)
                                                    <span class="label label-success label-inline font-weight-bolder mr-2">Premium</span>
                                                @break

                                                @default
                                                    <span class="label label-dark label-inline font-weight-bolder mr-2">Unknown</span>
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->

                        <!--begin::Card-->
                        <div class="card card-custom card-stretch-half">
                            <!--begin::Header-->
                            <div class="card-header h-auto py-4">
                                <div class="card-title">
                                    <h3 class="card-label">Ticket Information</h3>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-4">
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Subject:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket->subject }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Created At:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket->created_at }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Status:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext">
                                            @switch($ticket->status)
                                                @case(1)
                                                    <span class="label label-danger label-inline font-weight-bolder mr-2">Rejected</span>
                                                @break

                                                @case(2)
                                                    <span class="label label-success label-inline font-weight-bolder mr-2">Active</span>
                                                @break

                                                @case(3)
                                                    <span class="label label-warning label-inline font-weight-bolder mr-2">On Progress</span>
                                                @break

                                                @case(4)
                                                    <span class="label label-info label-inline font-weight-bolder mr-2">Closed</span>
                                                @break

                                                @default
                                                    <span class="label label-dark label-inline font-weight-bolder mr-2">Unknown</span>
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Priority:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext">
                                            @switch($ticket->priority)
                                                @case(1)
                                                    <span class="label label-success label-inline font-weight-bolder mr-2">Low</span>
                                                @break

                                                @case(2)
                                                    <span class="label label-warning label-inline font-weight-bolder mr-2">Medium</span>
                                                @break

                                                @case(3)
                                                    <span class="label label-danger label-inline font-weight-bolder mr-2">High</span>
                                                @break

                                                @default
                                                    <span class="label label-dark label-inline font-weight-bolder mr-2">Unknown</span>
                                            @endswitch
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Scope:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            @switch($ticket->scope)
                                                @case(1)
                                                    Finance
                                                @break

                                                @case(2)
                                                    Legal
                                                @break

                                                @case(3)
                                                    Business
                                                @break

                                                @case(4)
                                                    IT
                                                @break

                                                @default
                                                    Unknown
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Category:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket->category_parent ? $ticket->category_name . ' / ' : null }}{{ $ticket->subcategory_name }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Response Time:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket->tts }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Rejected By:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket->rejected_by ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Rejected At:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket->rejected_by ? $ticket->updated_at : '-' }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Assigned To:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket->assigned_to ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Assigned At:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket->assigned_to ? $ticket->updated_at : '-' }}</span>
                                    </div>
                                </div>
                                {{-- <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Resolved By:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket->solved ?? '-' }}</span>
                                    </div>
                                </div> --}}
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Resolved At:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket->solved ? $ticket->solved : '-' }}</span>
                                    </div>
                                </div>
                                {{-- <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Closed By:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket->status }}</span>
                                    </div>
                                </div> --}}
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Closed At:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $ticket->status == 4 ? $ticket->updated_at : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <div class="col-lg-8">
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch" id="kt_page_stretched_card">
                            <!--begin::Header-->
                            <div class="card-header h-auto py-4">
                                <div class="card-title">
                                    <h3 class="card-label">Comment</h3>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-4">
                                <div class="card-scroll">
                                    @foreach ($ticket->comments as $comment)
                                        <!--begin::Item-->
                                        <div class="mb-10">
                                            <!--begin::Section-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Symbol-->
                                                <div @class([
                                                    'symbol',
                                                    'symbol-45',
                                                    'mr-5',
                                                    'symbol-light-success' => $comment->comment_user != null,
                                                    'symbol-light-danger' => $comment->comment_admin != null,
                                                ])>
                                                    <span class="symbol-label">
                                                        <div class="h-50 align-self-center">
                                                            <i @class([
                                                                'flaticon2-user',
                                                                'text-success' => $comment->comment_user != null,
                                                                'text-danger' => $comment->comment_admin != null,
                                                            ])></i>
                                                        </div>
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Text-->
                                                <div class="d-flex flex-column flex-grow-1">
                                                    @if ($comment->comment_user)
                                                        <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ $comment->user_phone ?? 'Deleted User' }}</a>
                                                    @else
                                                        <a href="#"
                                                            class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">{{ $comment->admin_fullname ?? 'Deleted Administrator' }}</a>
                                                    @endif
                                                    <span class="text-muted font-weight-bold">{{ $comment->comment_created_at }}</span>
                                                </div>
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Section-->
                                            <!--begin::Desc-->
                                            <p class="text-dark-50 m-0 pt-5 font-weight-normal">{{ $comment->comment_body }}</p>
                                            <!--end::Desc-->
                                        </div>
                                        <!--end::Item-->
                                    @endforeach
                                </div>
                            </div>
                            <!--end::Body-->
                            <div class="card-footer">
                                <form action="{{ route('ticket-add-comment') }}" method="post">
                                    <div class="form-group mb-5">
                                        <label for="comment_body">
                                            Write Comment <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" id="comment_body" name="comment_body" rows="3" required></textarea>
                                    </div>
                                    @csrf
                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
