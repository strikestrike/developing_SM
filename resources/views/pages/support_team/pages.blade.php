@extends('layouts.master')
@section('page_title', 'Manage Exams')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<style>
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 20px;
    border: 3px solid #f1f1f1;
}


ul {
    list-style-type: none;
}

.un_publish_result {
    background-color: white;
    color: #CBAB89;
    border: 1px solid #CBAB89;
    border-radius: 8px;
    width: 140px;
    height: 50px;
    padding: 0px 15px;
    font-size: 16px;
    margin-bottom: 2px;
    display: flex;
    flex-direction: row;
}

.un_publish_result:hover {
    background-color: #ED7F02;
    color: white
}

.send_result {
    margin-top: 2px;
    margin-bottom: 2px;
    border-radius: 7px;
    margin-left: 0px;
    font-size: 16px;
    background: white;
    color: #0092D3;
    border: 1px solid #0092D3;
    width: 130px;
    display: flex;
    flex-direction: row;
}

.send_result:hover {
    background-color: #0092D3;
    color: white;
}

.delete_btn {
    border-radius: 7px;
    font-size: 14px;
    background: #ff562f;
    color: white;
    width: 140px;
    display: flex;
    flex-direction: row;
    padding: 2px 20px
}

.forms_sitting_exam {
    margin: 1rem;
    padding: 0;
}

.one-sitting {
    border-top: 1px solid #00000042;
    border-bottom: 1px solid #00000042;
}

.one-sitting.odd {
    background: rgb(227 225 225 / 50%);
}

.active-state {
    display: none;
}

.mouse_hover {
    background-color: #F2F2F2;
}

.mouse_hover:hover {
    background-color: #F0F9FD;
}

.card {
    margin-top: 50px;
    overflow: hidden;
    border: none;
    box-shadow: none;
}

.cardpos {
    position: fixed;
    width: 100%;
    z-index: 10;
}

.tabpos {
    margin-top: 60px;
}

.cardpos>li {
    width: 200px;
}

.cardpos>li>a {
    text-align: center;
    padding: 5px 10px;
}

.ratio {
    text-align: left;
}

.ratio>tbody>tr>td {
    font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;
    font-size: 1rem;
    font-style: normal;
    font-weight: 400;
    line-height: 1.5;
    padding: 0.1rem 0.5rem !important;
}

#ajax-alert {
    display: none !important;
}

.exclaimation {
    background: url('global_assets/images/exclaimation.svg');
    background-repeat: no-repeat;
    background-position: right calc(.375em + .1875rem) center;
}

.exclaimation-sel {
    background: url('global_assets/images/exclaimation.svg');
    background-repeat: no-repeat;
    background-position: right 1.75rem center, center right 2.25rem;
}

input,
.select2-selection {
    background-color: #f1fcf1 !important;
    height: 35px;
    font-size: 15px;
}

#create-exam-btn {
    line-height: 1.35;
    font-size: 0.875rem;
    padding: 0.2rem 0.5rem;
    background-color: #2ea5de;
    border-color: #2ea5de;
    color: white;
}

#select2-exam_manage_academic-container {
    margin-top: 3px;
}

.table td {
    padding: 0 1.25rem !important;
}

#exam_class_select {
    font-family: 'Times New Roman', Times, serif;
    font-size: 2px
}

optgroup {
    font-size: 10px;
}
</style>

<body style="background-color:white; font-family:icofont">
    <div class="card">
        <div class="card-body" style="padding:1.25rem 0 0 0 !important">
            <ul class="nav nav-tabs nav-tabs-highlight cardpos" style=" transform:translateX(-22px);">
                @if ($types=="student" || $types=="teacher" || $types=="staff")
                <li><a href="#my_classes_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link"
                        data-toggle="tab"><i class="icofont-home"></i> My Classes</a></li>
                @else
                <li><a href="#my_classes_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link "
                        data-toggle="tab"><i class="icofont-home"></i> My
                        Classes</a></li>
                <li><a href="#all_exams_pane" style="font-family: 'Times New Roman', Times, serif;"
                        class="nav-link active" data-toggle="tab"><i class="icofont-gears"></i>
                        Manage Exams</a></li>
                <li><a href="#new_exam_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link"
                        data-toggle="tab"><i class="icon-plus2"></i> Create Exam</a></li>
                <li><a href="#grading_systems_pane" style="font-family: 'Times New Roman', Times, serif;"
                        class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Grading Systems</a></li>
                <li><a href="#subject_paper_ratios" style="font-family: 'Times New Roman', Times, serif;"
                        class="nav-link" data-toggle="tab"><i class="icofont-network"></i> Subject Paper Ratios</a></li>
                <li><a href="#student-residences" style="font-family: 'Times New Roman', Times, serif;" class="nav-link"
                        data-toggle="tab"><i class="icofont-trash"></i> Deleted Exams</a></li>
                @endif
            </ul>
            <div class="tab-content tabpos" style="margin-top: 0px;">
                <div class="tab-pane fade  " id="my_classes_pane"
                    style="text-align: left;padding:2px;background:white;">

                </div>
                <div class="tab-pane fade show active" id="all_exams_pane"
                    style="background-color:#F5F5F5;font-family:icofont">
                    <div class="row" style="margin-top:80px;background-color:white">
                        <div class="col-3">
                            <div class="row">
                                <div class="col-12" style="margin-bottom:30px">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="margin: auto;" width="60" height="60"
                                        fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                        <path
                                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z" />
                                    </svg>
                                    <p style="font-weight:bolder;font-size:26px">Form {{$formid}}</p>
                                    <P id='examname' style="font-size:20px;font-weight:bold">{{$exam[0]}}</P>
                                </div>
                                <div class="col-6">
                                    <div style="font-size:19px;font-weight:bold">Mean Points</div>
                                    <div style="color:green;font-size:21px;font-weight:bold;margin-bottom:5px">{{$mp}}
                                    </div>
                                    <div style="display: flex; justify-content:center">
                                        {{$mpdev}}
                                        @if($mpdev>0)
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            style="width:17px;height:26px;float:right" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0"
                                            viewBox="0 0 16 16" xml:space="preserve" class="">
                                            <g
                                                transform="matrix(0.8000000000000009,-9.797174393178837e-17,-9.797174393178837e-17,-0.8000000000000009,1.5999999999999925,14.400000000000006)">
                                                <path fill="#056b08" d="m9 16 4-7h-3V0H3l2 3h2v6H4z"
                                                    data-original="#444444" class=""></path>
                                            </g>
                                        </svg>
                                        @elseif($mpdev==0)

                                        @else <svg xmlns="http://www.w3.org/2000/svg"
                                            style="width:17px;height:26px;float:right;background-color:#ccc"
                                            version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0"
                                            viewBox="0 0 16 16" xml:space="preserve" class="">
                                            <g
                                                transform="matrix(0.8000000000000009,0,0,0.8000000000000009,1.5999999999999917,1.5999999999999917)">
                                                <path fill="#dd790b" d="m9 16 4-7h-3V0H3l2 3h2v6H4z"
                                                    data-original="#444444" class=""></path>
                                            </g>
                                        </svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div style="font-size:19px;font-weight:bold">Mean Marks</div>
                                    <div style="color:green;font-size:21px;font-weight:bold;margin-bottom:5px">
                                        {{$mk}}
                                    </div>
                                    <div style="display: flex; justify-content:center">{{$mkdev}}
                                        @if($mkdev>0)
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            style="width:17px;height:26px;float:right" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0"
                                            viewBox="0 0 16 16" xml:space="preserve" class="">
                                            <g
                                                transform="matrix(0.8000000000000009,-9.797174393178837e-17,-9.797174393178837e-17,-0.8000000000000009,1.5999999999999925,14.400000000000006)">
                                                <path fill="#056b08" d="m9 16 4-7h-3V0H3l2 3h2v6H4z"
                                                    data-original="#444444" class=""></path>
                                            </g>
                                        </svg>
                                        @elseif($mkdev==0)

                                        @else <svg xmlns="http://www.w3.org/2000/svg"
                                            style="width:17px;height:26px;float:right;background-color:#ccc"
                                            version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0"
                                            viewBox="0 0 16 16" xml:space="preserve" class="">
                                            <g
                                                transform="matrix(0.8000000000000009,0,0,0.8000000000000009,1.5999999999999917,1.5999999999999917)">
                                                <path fill="#dd790b" d="m9 16 4-7h-3V0H3l2 3h2v6H4z"
                                                    data-original="#444444" class=""></path>
                                            </g>
                                        </svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr>
                                    <div>
                                        <p style="font-size:19px;font-weight:bold">Mean Greade</p>
                                        <p style="font-size:22px;font-weight:bold">{{$grade}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" col-6">
                            <div class="row">
                                <icon style="float:left;margin-left:40%;margin-top:5px">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bar-chart-steps" viewBox="0 0 16 16">
                                        <path
                                            d="M.5 0a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-1 0V.5A.5.5 0 0 1 .5 0zM2 1.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1z" />
                                    </svg>
                                </icon>
                                <p style="float:left;margin-left:6px;font-size:20px;font-weight:bold">
                                    Performance of Form streams
                                </p>
                                <div class="col-12">
                                    <div style="height:200px;width:90%;margin:auto">
                                        <canvas id="performance" style="display: inline;"></canvas>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <Div class="row" style="padding-left: 50px;padding-right:50px;margin-top:20px">
                                        <div class="col-6">
                                            <label for="exam" style="float: left;">Change Exam:</label>
                                            <select class="form-control" id="exam">
                                                @foreach($exam as $val)
                                                <option value={{$val}}>{{$val}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col-6">
                                            <label for="stream" style="float:left">Change Stream:</label>
                                            <select class="form-control" id="stream">
                                                @foreach($stream as $val)
                                                <option value="option1">{{$val}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </Div>

                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row">
                                <div class="col-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" style="margin:auto"
                                        fill="currentColor" class="bi bi-layers" viewBox="0 0 16 16">
                                        <path
                                            d="M8.235 1.559a.5.5 0 0 0-.47 0l-7.5 4a.5.5 0 0 0 0 .882L3.188 8 .264 9.559a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882L12.813 8l2.922-1.559a.5.5 0 0 0 0-.882l-7.5-4zm3.515 7.008L14.438 10 8 13.433 1.562 10 4.25 8.567l3.515 1.874a.5.5 0 0 0 .47 0l3.515-1.874zM8 9.433 1.562 6 8 2.567 14.438 6 8 9.433z" />
                                    </svg>
                                    <p style="font-weight:bolder;font-size:26px">{{$numberofstu}} Students</p>
                                    <P style="font-size:20px;font-weight:bold">Students who sat for the exam</P>
                                </div>

                                <Div class="col-12" style="margin-top:30px">
                                    <div class="row" style="display:block">
                                        <div class="col-12" style="margin-top:15px">
                                            <button class="btn btn-secondary"
                                                style="width:170px;font-family:icofont;font-size:16px;background-color:#32446B;border-radius:5px"
                                                type="button" aria-haspopup="true" aria-expanded="false" id="merit">
                                                Merit List
                                            </button>
                                        </div>
                                        <div class="col-12" style="margin-top:15px">
                                            <button class="btn btn-secondary"
                                                style="width:170px;font-family:icofont;font-size:16px;background-color:#32446B;border-radius:5px"
                                                type="button" aria-haspopup="true" aria-expanded="false" id="most">
                                                Most improved List
                                            </button>
                                        </div>
                                        <div class="dropdown d-flex justify-content-center" style="margin-top:15px">
                                            <button class="btn btn-secondary dropdown-toggle"
                                                style="width:170px;font-family:icofont;font-size:16px;background-color:#32446B;border-radius:5px"
                                                type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                Report Forms
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                <button class="dropdown-item" id="west" type="button">
                                                    <icon><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-filetype-xls"
                                                            viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM6.472 15.29a1.176 1.176 0 0 1-.111-.449h.765a.578.578 0 0 0 .254.384c.07.049.154.087.25.114.095.028.202.041.319.041.164 0 .302-.023.413-.07a.559.559 0 0 0 .255-.193.507.507 0 0 0 .085-.29.387.387 0 0 0-.153-.326c-.101-.08-.255-.144-.462-.193l-.619-.143a1.72 1.72 0 0 1-.539-.214 1.001 1.001 0 0 1-.351-.367 1.068 1.068 0 0 1-.123-.524c0-.244.063-.457.19-.639.127-.181.303-.322.527-.422.225-.1.484-.149.777-.149.305 0 .564.05.78.152.216.102.383.239.5.41.12.17.186.359.2.566h-.75a.56.56 0 0 0-.12-.258.625.625 0 0 0-.247-.181.923.923 0 0 0-.369-.068c-.217 0-.388.05-.513.152a.472.472 0 0 0-.184.384c0 .121.048.22.143.3a.97.97 0 0 0 .405.175l.62.143c.217.05.406.12.566.211a1 1 0 0 1 .375.358c.09.148.135.335.135.56 0 .247-.063.466-.188.656a1.216 1.216 0 0 1-.539.439c-.234.105-.52.158-.858.158-.254 0-.476-.03-.665-.09a1.404 1.404 0 0 1-.478-.252 1.13 1.13 0 0 1-.29-.375Zm-2.945-3.358h-.893L1.81 13.37h-.036l-.832-1.438h-.93l1.227 1.983L0 15.931h.861l.853-1.415h.035l.85 1.415h.908L2.253 13.94l1.274-2.007Zm2.727 3.325H4.557v-3.325h-.79v4h2.487v-.675Z" />
                                                        </svg></icon>
                                                    <span style="margin-left:10px;">West</span>
                                                </button>
                                                <button class="dropdown-item" id="east" type="button">
                                                    <icon><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-filetype-xls"
                                                            viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM6.472 15.29a1.176 1.176 0 0 1-.111-.449h.765a.578.578 0 0 0 .254.384c.07.049.154.087.25.114.095.028.202.041.319.041.164 0 .302-.023.413-.07a.559.559 0 0 0 .255-.193.507.507 0 0 0 .085-.29.387.387 0 0 0-.153-.326c-.101-.08-.255-.144-.462-.193l-.619-.143a1.72 1.72 0 0 1-.539-.214 1.001 1.001 0 0 1-.351-.367 1.068 1.068 0 0 1-.123-.524c0-.244.063-.457.19-.639.127-.181.303-.322.527-.422.225-.1.484-.149.777-.149.305 0 .564.05.78.152.216.102.383.239.5.41.12.17.186.359.2.566h-.75a.56.56 0 0 0-.12-.258.625.625 0 0 0-.247-.181.923.923 0 0 0-.369-.068c-.217 0-.388.05-.513.152a.472.472 0 0 0-.184.384c0 .121.048.22.143.3a.97.97 0 0 0 .405.175l.62.143c.217.05.406.12.566.211a1 1 0 0 1 .375.358c.09.148.135.335.135.56 0 .247-.063.466-.188.656a1.216 1.216 0 0 1-.539.439c-.234.105-.52.158-.858.158-.254 0-.476-.03-.665-.09a1.404 1.404 0 0 1-.478-.252 1.13 1.13 0 0 1-.29-.375Zm-2.945-3.358h-.893L1.81 13.37h-.036l-.832-1.438h-.93l1.227 1.983L0 15.931h.861l.853-1.415h.035l.85 1.415h.908L2.253 13.94l1.274-2.007Zm2.727 3.325H4.557v-3.325h-.79v4h2.487v-.675Z" />
                                                        </svg></icon>
                                                    <span style="margin-left:10px;">East</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </Div>

                            </div>
                        </div>
                        <div class="col-12" style="margin-top:50px">
                            <div class="row">
                                <div class="col-3" style="padding-left: 50px;">
                                    <p style="text-align: left;font-size:22px;font-weight:bold">Subject Performance</p>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Points</th>
                                                <th>Change</th>
                                                <th>Mean Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($status==0)
                                            <tr>
                                                <td colspan="5">There is no data</td>
                                            </tr>
                                            @else
                                            <?php $i = 1; ?>
                                            @foreach($table1 as $val)
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$val[0]}}</td>
                                                <td>{{$val[1]}}</td>
                                                <td>
                                                    <p>{{$val[2]}} @if($val[2]>0)
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            style="width:17px;height:26px;float:right" version="1.1"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            xmlns:svgjs="http://svgjs.com/svgjs" width="512"
                                                            height="512" x="0" y="0" viewBox="0 0 16 16"
                                                            xml:space="preserve" class="">
                                                            <g
                                                                transform="matrix(0.8000000000000009,-9.797174393178837e-17,-9.797174393178837e-17,-0.8000000000000009,1.5999999999999925,14.400000000000006)">
                                                                <path fill="#056b08" d="m9 16 4-7h-3V0H3l2 3h2v6H4z"
                                                                    data-original="#444444" class=""></path>
                                                            </g>
                                                        </svg>
                                                        @elseif($val[2]==0)

                                                        @else <svg xmlns="http://www.w3.org/2000/svg"
                                                            style="width:17px;height:26px;float:right;background-color:#ccc"
                                                            version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            xmlns:svgjs="http://svgjs.com/svgjs" width="512"
                                                            height="512" x="0" y="0" viewBox="0 0 16 16"
                                                            xml:space="preserve" class="">
                                                            <g
                                                                transform="matrix(0.8000000000000009,0,0,0.8000000000000009,1.5999999999999917,1.5999999999999917)">
                                                                <path fill="#dd790b" d="m9 16 4-7h-3V0H3l2 3h2v6H4z"
                                                                    data-original="#444444" class=""></path>
                                                            </g>
                                                        </svg>
                                                        @endif
                                                    </p>
                                                </td>
                                                <td>{{$val[3]}}</td>
                                            </tr>
                                            <?php $i++; ?>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-3"></div>
                                <div class="col-6">
                                    <p style="text-align: left;font-size:22px;font-weight:bold">Performance over time
                                    </p>
                                    <canvas id="performanceovertime" style="height:200px !important;">

                                    </canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" style="margin-top:50px">
                            <div class="row">
                                <div class="col-3" style="padding-left: 50px;">
                                    <p style="text-align: left;font-size:22px;font-weight:bold">Grade breakdown</p>
                                    <select class="form-control" id="gradebreakdown">
                                        <option>Overall</option>
                                        @foreach($subjects as $val)
                                        <option>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <table class="table table-striped" style="margin-bottom: 90px;">
                                        <thead>
                                            <tr>
                                                <th style="width:180px;line-height:80%">Form</th>
                                                <th>A</th>
                                                <th>A-</th>
                                                <th>B+</th>
                                                <th>B</th>
                                                <th>B-</th>
                                                <th>C+</th>
                                                <th>C</th>
                                                <th>C-</th>
                                                <th>D+</th>
                                                <th>D</th>
                                                <th>D-</th>
                                                <th>E</th>
                                                <th>X</th>
                                                <th>Y</th>
                                                <th>Entries</th>
                                                <th>Mean Marks</th>
                                                <th>MM Dev</th>
                                                <th>Mean Points</th>
                                                <th>MP Dev</th>
                                                <th>Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($status==0)
                                            <tr>
                                                <td colspan="21">There is no data</td>
                                            </tr>
                                            @else
                                            <tr id="table2"></tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <button class="btn btn-secondary"
                                        style="display:block;float:right;width:170px;font-family:icofont;font-size:16px;background-color:#32446B;border-radius:5px"
                                        type="button" aria-haspopup="true" aria-expanded="false" id="printformat">
                                        View Print Format
                                    </button>
                                </div>
                            </div>

                        </div>


                        <div class="tab-pane fade" id="new_exam_pane" style="background:whitesmoke">
                        </div>
                        <div class="tab-pane fade" id="grading_systems_pane" style="padding:15px;background:white">
                        </div>
                        <div class="tab-pane fade" id="subject_paper_ratios"
                            style="padding:15px 30px 0 30px;background:white">
                        </div>
                        <div class="tab-pane fade text-left" id="student-residences"
                            style="padding:15px;background:white">
                        </div>
                    </div>
                </div>
            </div>
</body>

<script>
(() => {
    const graph1 = "<?php echo $grahp1; ?>";
    const status = "<?php echo $status; ?>";
    const graph1_updated = JSON.parse(graph1);
    const datafirst = {
        labels: graph1_updated[0],
        datasets: [{
            backgroundColor: '#90DE8F',
            borderColor: '#90DE8F',
            data: graph1_updated[1],
            fill: true,
        }]
    };
    new Chart(
        document.getElementById('performance'), {
            type: 'line',
            data: datafirst,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: false,
                        text: 'Chart.js Line Chart'
                    },
                    legend: {
                        display: false // This hides all text in the legend and also the labels.
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: false,
                            text: 'Month'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: false,
                            text: 'Value'
                        },
                        ticks: {
                            // forces step size to be 50 units
                            stepSize: 0.5
                        }
                    }
                }
            },
        }
    );

    if (status == 0) {

        const button1 = document.getElementById('merit');
        const button2 = document.getElementById('most');
        const button3 = document.getElementById('dropdownMenu2');
        const button4 = document.getElementById('printformat');

        button1.addEventListener('click', showAlert);
        button2.addEventListener('click', showAlert);
        button3.addEventListener('click', showAlert);
        button4.addEventListener('click', showAlert);


        function showAlert() {
            Swal.fire({
                text: 'Error! There is no data',
                showConfirmButton: false,
                timer: 2000,
            });
        }


        var classes = ['Form', 'West', 'East'];
        var terms = ['MID TERM-(2023)', 'END OF TERM1,2023-(2023 Term1)', 'TERM 2 -2023 CAT1(2023)',
            'Mid Term2-(2023 Term2)'
        ];
        var class1Results = [
            [0, 0, 0, 0],
            [0, 0, 0, 0],
            [0, 0, 0, 0],
            [0, 0, 0, 0]
        ];
        var class2Results = [
            [0, 0, 0, 0],
            [0, 0, 0, 0],
            [0, 0, 0, 0],
            [0, 0, 0, 0]
        ];
        var class3Results = [
            [0, 0, 0, 0],
            [0, 0, 0, 0],
            [0, 0, 0, 0],
            [0, 0, 0, 0]
        ];

        // Chart configuration
        var ctx = document.getElementById('performanceovertime').getContext('2d');
        var examChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: terms,
                datasets: [{
                        label: classes[0],
                        data: class1Results,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        fill: false
                    },
                    {
                        label: classes[1],
                        data: class2Results,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        fill: false
                    },
                    {
                        label: classes[2],
                        data: class3Results,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        fill: false
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    } else {
        var classes = ['Form', 'West', 'East'];
        var terms = ['MID TERM-(2023)', 'END OF TERM1,2023-(2023 Term1)', 'TERM 2 -2023 CAT1(2023)',
            'Mid Term2-(2023 Term2)'
        ];
        var class1Results = getarr(4, 4);
        var class2Results = getarr(4, 4);
        var class3Results = getarr(4, 4);

        // Chart configuration
        var ctx = document.getElementById('performanceovertime').getContext('2d');
        var examChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: terms,
                datasets: [{
                        label: classes[0],
                        data: class1Results,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        fill: false
                    },
                    {
                        label: classes[1],
                        data: class2Results,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        fill: false
                    },
                    {
                        label: classes[2],
                        data: class3Results,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        fill: false
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        const button1 = document.getElementById('merit');
        const button2 = document.getElementById('most');
        const button3 = document.getElementById('west');
        const button4 = document.getElementById('east');
        const button5 = document.getElementById('printformat');

        button1.addEventListener('click', () => {
            window.location.href = `{{ route('meritList') }}`;
        });
        button2.addEventListener('click', () => {
            window.location.href = `{{ route('meritList') }}`;
        });
        button3.addEventListener('click', () => {
            window.location.href = `{{ route('west') }}`;
        });
        button4.addEventListener('click', () => {
            window.location.href = `{{ route('west') }}`;
        });
        button5.addEventListener('click', () => {});


    }

    function ran() {
        var letters = ['A', 'B', 'C', 'D', 'E', "D-", "D+", "C-", "C+", "B-", "B+",
            "A-"
        ];
        var l = letters[Math.floor(Math.random() * letters.length)];
        return l;
    }

    function getarr(rows, columns) {
        var randomArray = [];

        for (var i = 0; i < rows; i++) {
            var row = [];

            for (var j = 0; j < columns; j++) {
                row.push(Math.floor(Math.random() * 10)); // Generate a random number between 0 and 9
            }

            randomArray.push(row);
        }

        return randomArray;
    }

    const selectexam = document.getElementById('exam');
    selectexam.addEventListener('change', () => {
        console.log(selectexam.value)
        document.getElementById('examname').innerHTML = selectexam.value;
    })

})()
</script>

<style>
.swal2-popup {
    font-family: "icofont";
}
</style>
@endsection