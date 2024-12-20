@extends('layouts.master')
@section('page_title', 'Manage Classes')
@section('content')
<style>
.card {
    margin-top: 50px;
    overflow: hidden;
}

.container {
    position: relative;
    overflow: hidden;
}

.diagonal-div {
    position: absolute;
    position: absolute;
    width: 107px;
    height: 180px;
    background-color: purple;
    transform-origin: top left;
    transform: skew(-45deg);
}

.diagonal-div_white {
    position: absolute;
    position: absolute;
    top: -3px;
    /* Pull the diagonal div up by 70px */
    left: 10px;
    /* Pull the diagonal div left by 70px */
    width: 46px;
    height: 80px;
    background-color: white;
    transform-origin: top left;
    transform: skew(-45deg);

}

.cardpos {
    position: fixed;
    width: 100%;
    z-index: 10;
}

.tabpos {
    margin-top: 70px;
}

.active-state {
    display: none;
}

label {
    padding-left: 5px;
}

table,
th,
td {
    border: 1px solid;
}

.cardpos>li {
    width: 180px;
}

.cardpos>li>a {
    text-align: center;
    padding: 5px 10px;
}

#printDatatable_wrapper {
    width: 100%;
}

.card-body {
    padding: 1.25rem 0 0 0 !important;
}

.edit {
    background-image: url('global_assets/images/edit.svg');
    background-repeat: no-repeat;
    width: 16px;
    height: 16px;
}

.edit:hover {
    background-color: unset;
}
</style>
<div class="card" style="background-color: whitesmoke;font-family:Georgia, 'Times New Roman', Times, serif">

    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-highlight cardpos" style="transform:translateX(-2px);">
            @if ($types=="student" || $types == "staff" || $types=="teacher")
            <li><a href="#all-classes" class="nav-link active" data-toggle="tab">View Teachers</a></li>
            @else
            <li><a href="#all-classes" class="nav-link active" data-toggle="tab"><i class="icofont-settings"></i> Manage
                    Teachers</a></li>
            <li><a href="#new-user" class="nav-link" data-toggle="tab">+ Add New Teacher</a></li>
            <li><a href="#all-group" class="nav-link" data-toggle="tab"><i class="icofont-users"></i> Teachers'
                    Groups</a></li>
            @endif

        </ul>

        <div class="tab-content tabpos">
            <div class="tab-pane fade show active" id="all-classes">
                <div class="basic">
                    <div class="py-1 pb-0 d-flex flex-row align-items-center" style="background-color: white">
                        <div class="w-100 pl-2" style="text-align: left">
                            <h4 style="font-weight: 700;font-size:1.2857rem; margin: 5px;">Teachers</h4>
                        </div>
                        <div class="w-100"></div>
                        <div class="input-group flex-shrink-1" style="height: 30px;">
                            <input class="form-control border-end-0 border rounded-pill text-right"
                                style="border-top-left-radius: 5px;border-bottom-left-radius:5px;" type="text"
                                placeholder="search" id="example-search-input">
                            <span class="input-group-append">
                                <button
                                    class="btn btn-outline-secondary bg-white border-start-0 border rounded-pill ms-n3"
                                    style="border-top-right-radius: 5px;border-bottom-right-radius:5px;" type="button">
                                    <i class="icofont-search"></i>
                                </button>
                                <button class="btn btn-outline-secondary border-start-0 border rounded-pill ms-n3 mx-2"
                                    style="background-color: #132A4E;color:white;border-radius:5px;"
                                    onclick="showPrint()" type="button">
                                    <i class="icofont-printer"></i> View Print Format
                                </button>
                            </span>
                        </div>
                    </div>
                    <span class="active-state teacher_count">{{ count($all_teachers) }}</span>
                    <div class="row">
                        <?php $num = 0; ?>
                        @isset($teacher_id->id)
                        @foreach ($all_teachers as $key => $teacher)
                        {{-- {{ str_replace(' ', '', $teacher->user->name) }} --}}
                        <div class="col-md-3" id="item{{ $num++ }}"
                            aria-label="{{ str_replace(' ', '', $teacher->user->name) }}">
                            <div class="card my-2">
                                <div class="d-flex flex-row justify-content-start m-1">
                                    @if($teacher->user->user_type_id==4)
                                    <span class='bg-success px-1'>Admin</span>
                                    @else
                                    <br />
                                    @endif
                                </div>
                                <div class="d-flex flex-column align-items-center welcome-pane">
                                    {{-- <div class="rounded-circle" id="circle{{ $teacher->user->id }}"
                                    @if ($teacher->user->state>0)
                                    style="width:120px;height:120px;padding:0;line-height:120px;border:1px solid
                                    green;padding:22px;background-color:#768EB0"
                                    @else
                                    style="width:120px;height:120px;padding:0;line-height:120px;border:1px solid
                                    grey;padding:22px;background-color:#768EB0"
                                    @endif
                                    >
                                </div> --}}
                                <img style="border-radius:100%;"
                                    src="/{{ $teacher->user->photo_by }}/{{  $teacher->user->photo }}" width="150"
                                    height="150" />
                                <div class="person" style="transform: translateY(-20px)">
                                    <div class="d-flex flex-row">
                                        @if ($types=="student" || $types == "staff" || $types=="teacher")
                                        <div class="rounded-circle mr-1"
                                            style="border-radius: 50%;padding:10px;background-color:green">
                                            <a href="{{ route('teacher_detail', $teacher->id) }}"
                                                class="dropdown-item p-0" data-toggle="tooltip" data-placement="bottom"
                                                title="Teacher Classes"><i class="icon-graph"
                                                    style="margin:0;background-color:green;color:white"></i></a>
                                        </div>
                                        @else
                                        @if(Qs::userIsTeamSA())
                                        <div class="rounded-circle mr-1"
                                            style="border-radius: 50%;padding:10px;background-color:green;">
                                            <a href="{{ route('teachers.edit', $teacher->id) }}"
                                                class="dropdown-item p-0 edit" data-toggle="tooltip"
                                                data-placement="bottom" title="Edit"></a>
                                        </div>
                                        @if ($teacher->id!=$teacher_id->id)
                                        <div class="rounded-circle mr-1" @if ($teacher->user->user_type_id==4)
                                            style="border-radius: 50%;padding:10px;background-color:#E25822;"
                                            @else
                                            style="border-radius: 50%;padding:10px;background-color:#2892D4;"
                                            @endif >
                                            @if ($teacher->user->user_type_id==4)
                                            <a id="{{ $teacher->user->id }}" class="dropdown-item p-0"
                                                name={{ $teacher->user->name }}
                                                onclick="confirmCreate(this.id, this.name, '{{$teacher->user->user_type_id}}', 3)"
                                                class="dropdown-item" data-toggle="tooltip" data-placement="bottom"
                                                title="Remove Admin"><i class="icon-user-minus"
                                                    style="margin:0;background-color:#E25822"></i></a>
                                            @else
                                            <a id="{{ $teacher->user->id }}" class="dropdown-item p-0"
                                                name={{ $teacher->user->name }}
                                                onclick="confirmCreate(this.id, this.name, '{{$teacher->user->user_type_id}}', 3)"
                                                class="dropdown-item" data-toggle="tooltip" data-placement="bottom"
                                                title="Add Admin"><i class="icon-user-plus"
                                                    style="margin:0;background-color:#2892D4"></i></a>
                                            @endif
                                        </div>
                                        @endif
                                        <div class="rounded-circle mr-1"
                                            style="border-radius: 50%;padding:10px;background-color:#FFA500">
                                            <a href="{{ route('teacher_detail', $teacher->id) }}"
                                                class="dropdown-item p-0" data-toggle="tooltip" data-placement="bottom"
                                                title="Teacher Classes"><i class="icon-graph"
                                                    style="margin:0;background-color:#FFA500"></i></a>
                                        </div>
                                        @endif
                                        @if(Qs::userIsSuperAdmin())
                                        <div class="rounded-circle mr-1"
                                            style="border-radius: 50%;padding:10px;background-color:red">
                                            <a id="{{ $teacher->id }}" onclick="confirmDelete(this.id)" href="#"
                                                class="dropdown-item p-0" data-toggle="tooltip" data-placement="bottom"
                                                title="Delete"><i class="icon-trash" style="margin:0;"></i></a>
                                            <form method="post" id="item-delete-{{ $teacher->id }}"
                                                action="{{ route('teachers.destroy', $teacher->id) }}" class="hidden">
                                                @csrf @method('delete')</form>
                                        </div>
                                        @endif
                                        @endif

                                    </div>
                                </div>
                                <div class="text-center" style="transform: translateY(-10px)">
                                    <h3 style="font-weight: 400">{{$teacher->user->name}}</h3>
                                    <h6>{{$teacher->user->email}}</h6>
                                    <h6 style="color: #2ea5de">
                                        @if($teacher->user->phone)
                                        {{$teacher->user->phone}}
                                        @else
                                        <br>
                                        0 @endif
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    @foreach ($all_teachers as $key => $teacher)
                    {{-- {{ str_replace(' ', '', $teacher->user->name) }} --}}
                    <div class="col-md-3" id="item{{ $num++ }}"
                        aria-label="{{ str_replace(' ', '', $teacher->user->name) }}" style="margin:10px">
                        <div class="card my-2 container ">

                            <div class="d-flex flex-row justify-content-start m-1">
                                @if($teacher->user->user_type_id==4)
                                <span class='bg-success px-1'>Admin</span>
                                @else
                                <br />
                                @endif
                            </div>
                            <div class="d-flex flex-column align-items-center welcome-pane">
                                <img class="mt-3 rounded-circle"
                                    src="/{{ $teacher->user->photo_by }}/{{  $teacher->user->photo }}" width="150"
                                    height="160" style="position:relative" />
                                <div class="person" style="position:absolute;top:169px;width:60%">
                                    <div class="d-flex flex-row">
                                        @if ($types=="student" || $types == "staff" || $types=="teacher")
                                        <a style="background-color:#ffb233;padding:20px;border-radius:45px"
                                            href="{{ route('teacher_detail', $teacher->id) }}" class="dropdown-item"
                                            data-toggle="tooltip" data-placement="bottom" title="Teacher Classes"><i
                                                class="icon-graph" style="color:white;"></i></a>
                                        @else
                                        @if(Qs::userIsTeamSA())
                                        <a href="{{ route('teachers.edit', $teacher->id) }}" class="dropdown-item"
                                            data-toggle="tooltip" data-placement="bottom" title="Edit"
                                            style="background-color:#5fcc5c;padding:20px;border-radius:45px"><i
                                                class="icon-pencil" style="color:white;"></i></a>
                                        <a style="background-color:#4bc3ff;padding:20px;border-radius:45px"
                                            id=" {{ $teacher->user->id }}" name={{ $teacher->user->name }}
                                            onclick="confirmCreate(this.id, this.name, '{{$teacher->user->user_type_id}}', 3)"
                                            class="dropdown-item" data-toggle="tooltip" data-placement="bottom"
                                            title="Add Admin"><i class="icon-user-plus" style="color:white;"></i></a>

                                        <a style="background-color:#ffb233;padding:20px;border-radius:45px"
                                            href="{{ route('teacher_detail', $teacher->id) }}" class="dropdown-item"
                                            data-toggle="tooltip" data-placement="bottom" title="Teacher Classes"><i
                                                class="icon-graph" style="color:white;"></i></a>
                                        @endif
                                        @if(Qs::userIsSuperAdmin())
                                        <a style="background-color:#ff6970;padding:20px;border-radius:45px"
                                            id="{{ $teacher->id }}" onclick="confirmDelete(this.id)" href="#"
                                            class="dropdown-item" data-toggle="tooltip" data-placement="bottom"
                                            title="Delete"><i class="icon-trash" style="color:white;"></i></a>
                                        <form method="post" id="item-delete-{{ $teacher->id }}"
                                            action="{{ route('teachers.destroy', $teacher->id) }}" class="hidden">@csrf
                                            @method('delete')</form>
                                        @endif
                                        @endif

                                    </div>
                                </div>
                                <div class="my-3 text-center">
                                    <h5>{{$teacher->user->name}}</h5>
                                    <h6>{{$teacher->user->email}}</h6>
                                    <h6 class="text-success">
                                        @if($teacher->user->phone)
                                        {{$teacher->user->phone}}
                                        @else
                                        <br>
                                        @endif
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endisset
                </div>
            </div>
            <div class="print active-state">
                <div class="p-3 d-flex flex-column" style="background-color: white">
                    <h4 class="d-flex flex-row">Show</h4>
                    <div class="d-flex flex-row justify-content-between">
                        <div><input type="checkbox" name="phone" onclick="phoneCheck()" id="phone" checked><label
                                for="phone">
                                Phone Numbers</label></div>
                        <div><input type="checkbox" name="username" onclick="emailCheck()" id="username" checked><label
                                for="username"> Username</label></div>
                        <div><input type="checkbox" name="national" onclick="nationCheck()" id="national" checked><label
                                for="national"> National Id No</label></div>
                        <div><input type="checkbox" name="gener" onclick="genderCheck()" id="gender" checked><label
                                for="gender"> Gender</label></div>
                        <div><input type="checkbox" name="tsc" onclick="tscCheck()" id="tsc"><label for="tsc"> TSC
                                No</label></div>
                        <div><input type="checkbox" name="group" onclick="groupCheck()" id="group"><label for="group">
                                Groups</label></div>
                        <div></div>
                    </div>
                </div>
                <br>
                <div class="d-flex flex-row">
                    <div class="w-100" style="text-align:left">
                        <button class="btn btn-seconday" onclick="showManageTeacher()">Close Print format</button>
                    </div>
                    <div class="flex-shrink-1">
                        <button class="btn btn-primary" onclick="fnPrintReport(event)"><i class="icofont-printer"></i>
                            Print </button>

                    </div>
                    <div class="flex-shrink-1 ml-2">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Dropdown
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" id="btnExport" onclick="fnExcelReport();">Download Excel</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="printView">
                    <div class="d-flex align-items-center justify-content-between flex-row mt-2 p-4"
                        style="background-color: white">
                        <div>
                            <img class="mt-3" src="/school_number/{{ $user->school_logo }}" width="100" height="100" />
                        </div>
                        <div class="text-center">
                            <h3> {{ $user->school_name }}</h3>
                            <h6>Teacher List</h6>
                        </div>
                        <div class="text-center">
                            <p>{{ $user->school_postal }}</p>
                            <p>{{ $user->school_phone }}</p>
                            <p>{{ $user->school_email }}</p>
                        </div>

                    </div>
                    <div class="d-flex align-items-center justify-content-between flex-row p-4"
                        style="background-color: white">
                        <table class="table table-striped" id="printDatatable">
                            {{-- datatable-button-html5-columns --}}
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="email">Personal Email</th>
                                    <th class="phone">Phone</th>
                                    <th class="gender">Gender</th>
                                    <th class="nation">National ID No.</th>
                                    <th class="tsc  active-state">TSC No.</th>
                                    <th class="group active-state">Groups</th>
                                    <th class="active-state">Role</th>
                                    <th class="active-state"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 0; ?>
                                @isset($teacher_id->id)

                                @foreach ($all_teachers as $key => $teacher)
                                <tr style="line-height:8px;">
                                    <td>{{++$num}}</td>
                                    <td>{{$teacher->user->name}}</td>
                                    <td class="email">{{$teacher->user->email}}</td>
                                    <td class="phone">{{$teacher->user->phone}}</td>
                                    <td class="gender">{{$teacher->user->gender}}</td>
                                    <td class="nation">{{$teacher->user->national_id_no}}</td>
                                    <td class="tsc active-state">{{$teacher->user->tsc_no}}</td>
                                    <td class="group active-state">
                                        @if ($teacher->group_id!="")
                                        <?php $teachers = explode(",", $teacher->group_id) ?>
                                        @foreach ($all_group as $value)
                                        @foreach ($teachers as $item)
                                        @if ($item==$value->id)
                                        <div class="row">
                                            <span class="px-2 py-1 my-1"
                                                style="border-radius: 2px;background:#E4E6EF">{{ $value->name }}</span>
                                        </div>
                                        @endif
                                        @endforeach
                                        @endforeach
                                        @endif
                                    </td>
                                    <td class="active-state">{{$teacher->user->user_type->name}}</td>
                                    <td class="text-center active-state">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    Action &nbsp;<i class="icon-menu9"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-left">
                                                    @if(Qs::userIsTeamSA())
                                                    <a href="{{ route('teachers.edit', $teacher->id) }}"
                                                        class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                                    @endif
                                                    @if(Qs::userIsSuperAdmin())
                                                    <a id="{{ $teacher->id }}" onclick="confirmDelete(this.id)" href="#"
                                                        class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                                                    <form method="post" id="item-delete-{{ $teacher->id }}"
                                                        action="{{ route('teachers.destroy', $staff->id) }}"
                                                        class="hidden">
                                                        @csrf @method('delete')</form>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @endisset

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <table class="table datatable-button-html5-columns">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Personal Email</th>
                            <th>Gender</th>
                            <th>TSC No.</th>
                            <th>National ID No.</th>
                            <th>Groups</th>
                            <th>Role</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_teachers as $key => $teacher)
                                <tr>
                                    <td>{{$key + 1}}</td>
            <td>{{$teacher->user->name}}</td>
            <td>{{$teacher->user->phone}}</td>
            <td>{{$teacher->user->email}}</td>
            <td>{{$teacher->user->gender}}</td>
            <td>{{$teacher->user->tsc_no}}</td>
            <td>{{$teacher->user->national_id_no}}</td>
            <td>@if($teacher->group_id != 0){{$teacher->group->name}}@endif</td>
            <td>{{$teacher->user->user_type->name}}</td>
            <td class="text-center">
                <div class="list-icons">
                    <div class="dropdown">
                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                            Action &nbsp;<i class="icon-menu9"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-left">
                            @if(Qs::userIsTeamSA())
                            <a href="{{ route('teachers.edit', $teacher->id) }}" class="dropdown-item"><i
                                    class="icon-pencil"></i> Edit</a>
                            @endif
                            @if(Qs::userIsSuperAdmin())
                            <a id="{{ $teacher->id }}" onclick="confirmDelete(this.id)" href="#"
                                class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                            <form method="post" id="item-delete-{{ $teacher->id }}"
                                action="{{ route('teachers.destroy', $teacher->id) }}" class="hidden">@csrf
                                @method('delete')</form>
                            @endif

                        </div>
                    </div>
                </div>
            </td>
            </tr>
            @endforeach

            </tbody>
            </table> --}}
        </div>

        <div class="tab-pane fade" style="text-align: left;" id="new-user">
            <div class="card p-2">
                <h3>Options</h5>
                    <div class="row">
                        <div class="form-check m-2">
                            <label class="form-check-label">
                                <input type="radio" id="select_by_key" class="form-check-input" name="optradio"
                                    checked>Key
                                in
                                teacher detail
                            </label>
                        </div>
                        <div class="form-check m-2">
                            <label class="form-check-label">
                                <input type="radio" id="select_by_file" class="form-check-input" name="optradio">Upload
                                teachers from a spreadsheet
                            </label>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="select_key" method="post" action="{{ route('teachers.store') }}">
                            @csrf
                            {{-- <h6>Teacher Data</h6> --}}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="full_name">Full Name</label>
                                        <input value="{{ old('full_name') }}"
                                            oninvalid="this.setCustomValidity('This field is required.\n Name cannot be empty')"
                                            required type="text" name="full_name" id="full_name" placeholder="Full Name"
                                            class="form-control">
                                    </div>
                                </div>

                                {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input value="{{ old('email') }}" required type="text" name="email"
                                id="email" placeholder="Email" class="form-control">
                            </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input value="{{ old('phone_number') }}" class="form-control" placeholder="07## ### ###"
                                name="phone_number" id="phone_number" type="text" required>
                        </div>
                    </div>
            </div>
            <div class="row">

                {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input value="{{ old('phone_number') }}" class="form-control"
                placeholder="07## ### ###" name="phone_number" id="phone_number" type="text" required>
            </div>
        </div> --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="tsc_no">TSC No.</label>
                <input value="{{ old('tsc_no') }}" required type="text" name="tsc_no" id="tsc_no" placeholder="####"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <label for="gender">Gender</label>
            <select class="select form-control" id="gender" name="gender" data-fouc data-placeholder="Select Gender..">
                <option value="">Unspecified</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>

    </div>
    <div class="row">
        {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tsc_no">TSC No.</label>
                                            <input value="{{ old('tsc_no') }}" required type="text" name="tsc_no"
        id="tsc_no" placeholder="####" class="form-control">
    </div>
</div> --}}


<div class="col-md-6">
    <div class="form-group">
        <label for="national_id_no">National ID No.</label>
        <input value="{{ old('national_id_no') }}" required type="text" name="national_id_no" id="national_id_no"
            placeholder="####" class="form-control">
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="group">Group</label>
        <select class="select form-control" id="group" name="group[]" multiple data-fouc data-placeholder="Choose..">
            @foreach ($group as $key => $g)
            <option value="{{$g->id}}">{{$g->name}}</option>
            @endforeach
        </select>
    </div>
</div>
</div>
{{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="national_id_no">National ID No.</label>
                                            <input value="{{ old('national_id_no') }}" required type="text"
name="national_id_no" id="national_id_no" placeholder="####" class="form-control">
</div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="group">Group</label>
        <select class="select form-control" id="group" name="group" data-fouc data-placeholder="Choose..">
            @foreach ($group as $key => $g)
            <option value="{{$g->id}}">{{$g->name}}</option>
            @endforeach
        </select>
    </div>
</div>
</div> --}}
<div class="text-right">
    <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
</div>
</form>
<form class="select_file active-state" action="{{ route('teacher_upload') }}" method="post">
    @csrf
    <div class="row">
        <a href="./download/Upload Teachers - Template.xlsx" download>Download <i class="icofont-download"></i></a>
        &nbsp;&nbsp;and fill the template then upload it below. (Please leave the column headers intact)
    </div>
    <div class="row">
        <input type="file" name="file_upload" id="file_upload" onchange="uploadFile_onChange(this, 1);">
    </div>
    <table class="my-2 table active-state" id="display_excel_data">
        {{-- <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>National Id No</th>
                                            <th>Group</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody> --}}
    </table>
    <div class="text-right my-2">
        <button type="submit" class="btn btn-success">Upload <i class="icon-paperplane ml-2"></i></button>
    </div>
</form>
</div>
</div>
</div>


<div class="tab-pane fade" id="all-group">
    <table class="table datatable-button-html5-columns">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-primary">Name</th>
                <th class="d-flex justify-content-center text-danger">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php $len = count($all_group);
            $i = 0; ?>
            @foreach ($all_group as $key => $group)
            <?php $i++ ?>
            <tr>
                <td>{{$key + 1}}</td>
                <td>
                    <div class="d-flex align-items-center justify-content-start">
                        <p style="margin: 0;">{{$group->name}}</p>
                        <button class="btn btn-primary" title="Edit this user"
                            onclick="editingGroupName('{{$group->name}}', this);">
                            <img src="/global_assets/images/icon/edit.png" width="20" height="20" /> &nbsp; Edit
                        </button>
                    </div>
                </td>
                <td class="text-center">
                    <div class="list-icons">
                        <div class="dropdown">
                            <button class="list-icons-item btn btn-danger"
                                onclick="deleteGroup('{{$group->id}}', this);" style="cursor: pointer; ">
                                <img src="/global_assets/images/icon/delete.png" width="20" height="20" /> &nbsp; Delete
                            </button>
                        </div>
                    </div>
                </td>
                <td style="display: none; ">{{$group->id}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button type="button" class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#myModal">Add
        Group</button>
</div>
</div>
</div>
</div>

<!-- create new group modal starts -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="noticeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #5dd1bb; color: black;">
                <h5>Creat New Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('new_group')}}">
                <div class="modal-body">
                    <div class="form-group d-flex flex-column align-items-center">
                        <label for="group_name">Group Name </label>
                        <input type="text" name="group_name" id="group_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-theme">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- create new group modal ends -->
@include('partials.js.class_index')
@include('partials.js.group_index')
@endsection