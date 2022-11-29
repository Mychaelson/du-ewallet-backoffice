@extends('layouts.template.app') 
@section('content_body') 
<div class="d-flex flex-column-fluid mt-7">
  <!--begin::Container-->
  <div class="container-fluid">
    @if(session()->has('message'))
      <div class="alert alert-success">
          {{ session()->get('message') }}
      </div>
    @endif
    <div class="row">
      <div class="col-xl-2 col-md-4">
        @include('user.profileSidebar', ['active' => 'permission'])

        <br>
        <div class="card card-custom card-stretch" style="height:auto">
          <div class="card-body pt-4">
            <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
              <div class="navi-item mb-2">
                
                @foreach($group_perms as $key => $value)
                  <a href="javascript:void(0)" class="navi-link py-4 groupScroll" targetScroll="{{ str_replace(" ","_",$key) }}">
                    <span class="navi-text font-size-lg">{{ $key }}</span>
                  </a>
                @endforeach

              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="col-xl-10 col-md-8">
        <form class="form" method="post" action="{{ route('users.updatePermission', ['id' => $user->id]) }}" autocomplete="off"> {!! csrf_field() !!} <div class="card card-custom gutter-b">
            <div class="card-header">
              <div class="card-title">
                <span class="card-icon">
                  <i class="flaticon-users-1 text-primary"></i>
                </span>
                <h3 class="card-label"> {{ $page_title }}</h3>
              </div>
              <div class="card-toolbar">
                <button type="submit" class="btn btn-sm btn-warning font-weight-bold">
                  <i class="flaticon2-hourglass-1"></i>Update </button>
                <a href="{{ route('users') }}" class="btn btn-sm btn-danger font-weight-bold ml-2">
                  <i class="flaticon-close"></i> Back </a>
              </div>
            </div>
            <div class="card-body">

              @foreach($group_perms as $keyGroup => $valGroup)
                <table class="table" id="{{ str_replace(" ","_",$keyGroup) }}">
                  <thead>
                    <th>
                      <label class="checkbox"> <input type="checkbox" class="checkParent" key="{{$keyGroup}}"> <span> </span> </label>
                    </th>
                    <th colspan="2">{{ $keyGroup }}</th>
                  </thead>
                  <tbody>
                      @foreach($valGroup as $keyPerms => $valPerms)
                        <tr>
                            <td>
                                <label class="checkbox"> <input class="checkChild" type="checkbox" key="{{$keyGroup}}" value="{{$valPerms['id']}}" name="checkChild[]"> <span> </span> </label>
                            </td>
                            <td> {{ $valPerms['name'] }} </td>
                            <td> {{ $valPerms['about'] }} </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
                <br>
              @endforeach
        
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> 
@endsection 
@section('content_js') 

<script>
  $(document).find(".checkChild").change(function() {
    var key = $(this).attr('key');
    var groupChecked = $(document).find(".checkChild:checked[key='"+key+"']").length
    $(document).find(".checkParent[key='"+key+"']").prop('checked', groupChecked > 0)
  });

  $(document).find(".checkParent").change(function() {
    var key = $(this).attr('key');
    var value = $(this).is(":checked");
    $(document).find(".checkChild[key='"+key+"']").prop('checked', value)
  });

  var checked = '{{ json_encode($user_chain) }}';

  $.each(JSON.parse(checked), function (i, elem) {
    $(document).find(".checkChild[value='"+elem+"']").click()
  });

  $(document).find(".groupScroll").click(function() {
      $([document.documentElement, document.body]).animate({
          scrollTop: $("#"+$(this).attr('targetScroll')).offset().top - 80
      }, 1000);
  });
</script>
@endsection