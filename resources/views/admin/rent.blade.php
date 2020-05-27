@extends('layouts.app-admin')

@section('body')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">

                <h3 style="text-align:center;">รายการยืม</h3>
            </div>
            <div class="panel-body">


                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
                @endif

                @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div><br />
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="myTable" align="center">
                        <thead class="thead-dark">
                            <tr>
                                <th>รหัสครุภัณฑ์</th>
                                <th>ลักษณะ/ยี่ห้อ</th>
                                <th>ชื่อผู้ยืม</th>
                                <th>สถานะการยืม</th>
                                <th style="width:20%;">ตัวเลือก</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rent as $rent)
                            <tr>
                                <td>{{ $rent->equipment->equipment_code }}</td>
                                <td>{{ $rent->equipment->equipment_name }}</td>
                                <td>{{ $rent->user->name }}</td>
                                <td>
                                    @if ($rent->rent_status == 0)
                                    <span
                                        style='font-size:11px;font-weight: normal; background:#660000;padding: .2em .6em .3em;display: inline;border-radius: .25em;color: #ffffff;'>แจ้งยืม
                                        (รออนุมัติ)</span>
                                    @endif
                                    @if ($rent->rent_status == 1)
                                    <span
                                        style='font-size:11px;font-weight: normal; background:#120eeb;padding: .2em .6em .3em;display: inline;border-radius: .25em;color: #ffffff;'>อนุมัติแล้ว</label>
                                        @endif
                                        @if ($rent->rent_status == 2)
                                        <span
                                            style='font-size:11px;font-weight: normal; background:#d940ff;padding: .2em .6em .3em;display: inline;border-radius: .25em;color: #ffffff;'>ไม่อนุมัติ</label>
                                            @endif
                                            @if ($rent->rent_status == 3)
                                            <span
                                                style='font-size:11px;font-weight: normal; background:#06d628;padding: .2em .6em .3em;display: inline;border-radius: .25em;color: #ffffff;'>กำลังยืม</label>
                                                @endif
                                                @if ($rent->rent_status == 4)
                                                <span
                                                    style='font-size:11px;font-weight: normal; background:#ff0000;padding: .2em .6em .3em;display: inline;border-radius: .25em;color: #ffffff;'>ส่งคืนแล้ว</label>
                                                    @endif
                                                    @if ($rent->rent_status == 5)
                                                    <span
                                                        style='font-size:11px;font-weight: normal; background:#ff6ff0;padding: .2em .6em .3em;display: inline;border-radius: .25em;color: #ffffff;'>ยกเลิกการยืม</label>
                                                        @endif
                                </td>
                                <td>

                                        <button type="button" class="btn btn-warning" data-id1="{{ $rent->id }}"
                                            data-equipment="{{ $rent->equipment->equipment_code }}"
                                            data-equipment_id="{{ $rent->equipment->id }}"
                                            data-user_id="{{ $rent->user->id }}"
                                            data-user="{{ $rent->user->name }}" data-status="{{ $rent->rent_status }}"
                                            data-date="{{ $rent->rent_date }}"
                                            data-returnfix="{{ $rent->rent_return_date_fix }}"
                                            data-etc="{{ $rent->rent_etc }}" data-return="{{ $rent->rent_return_date }}"
                                            data-toggle="modal" data-target="#editRentModal">
                                            <i class="glyphicon glyphicon-edit"></i> แก้ไข
                                        </button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#removeRentModal" data-id="{{ $rent->id }}"> <i
                                                class="glyphicon glyphicon-trash"></i> ลบ</button>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div> <!-- /panel-body -->
        </div> <!-- /panel -->
    </div> <!-- /col-md-12 -->
</div> <!-- /row -->

<!-- edit categories brand -->
<div class="modal fade" id="editRentModal" aria-labelledby="myModalLabel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form class="form-horizontal" action="{{ route('rent.update',$rent->id) }}" method="POST">
                @csrf
                {{ method_field('patch') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-edit"></i>จัดการรายการยืม</h4>
                </div>>
                <div class="modal-body">

                    <div id="edit-categories-messages"></div>

                    <div class="modal-loading div-hide"
                        style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        <span class="sr-only">Loading...</span>
                    </div>

                    <div class="edit-categories-result">

                        <input type="hidden" name="user_id" id="user_id" value="{{ $rent->user->id }}">
                        <input type="hidden" name="equipment_id" id="equipment_id" value="{{ $rent->equipment->id }}">

                        <div class="form-group">
                            <label for="equipment" class="col-sm-3 control-label">รหัสครุภัณฑ์</label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="equipment"
                                    placeholder="รหัสครุภัณฑ์" name="equipment" autocomplete="off" readonly value="{{ $rent->equipment->equipment_code }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user" class="col-sm-3 control-label"> ชื่อผู้ยืม</label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="user" placeholder="ชื่อผู้ยืม"
                                    name="user" autocomplete="off" readonly value="{{ $rent->user->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div style="display: flex;justify-content: center;align-items: center;">
                                ---------------------------------------------------
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="rent_status" class="col-sm-3 control-label">สถานะการยืม</label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <select class="form-control" id="rent_status" name="rent_status">
                                    @if ($rent->rent_status == 0)
                                        <option value="{{ $rent->rent_status }}">แจ้งยืม (รออนุมัติ)</option>
                                    @endif
                                    @if ($rent->rent_status == 1)
                                        <option value="{{ $rent->rent_status }}">อนุมัติแล้ว</option>
                                    @endif
                                    @if ($rent->rent_status == 2)
                                        <option value="{{ $rent->rent_status }}">ไม่อนุมัติ</option>
                                    @endif
                                    @if ($rent->rent_status == 3)
                                        <option value="{{ $rent->rent_status }}">กำลังยืม</option>
                                    @endif
                                    @if ($rent->rent_status == 5)
                                        <option value="{{ $rent->rent_status }}">ส่งคืนแล้ว</option>
                                    @endif
                                    @if ($rent->rent_status == 4)
                                        <option value="{{ $rent->rent_status }}">ยกเลิกการยืม</option>
                                    @endif
                                    {{-- <option value="{{ $rent->rent_status }}">{{ $rent->rent_status }}</option> --}}
                                    <option value="0">แจ้งยืม (รออนุมัติ)</option>
                                    <option value="1">อนุมัติแล้ว</option>
                                    <option value="2">ไม่อนุมัติ</option>
                                    <option value="3">กำลังยืม</option>
                                    <option value="4">ส่งคืนแล้ว</option>
                                    <option value="5">ยกเลิกการยืม</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rent_etc" class="col-sm-3 control-label"> หมายเหตุ</label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="rent_etc" placeholder="รายละเอียดเพิ่มเติม.."
                                    name="rent_etc" autocomplete="off" value="{{ $rent->rent_etc }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rent_date" class="col-sm-3 control-label"> วันที่ยืม</label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <input type="date" class="form-control" id="rent_date" placeholder="วันที่ยืม"
                                    name="rent_date" autocomplete="off" value="{{ $rent->rent_date }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rent_return_date_fix" class="col-sm-3 control-label"> วันที่กำหนดคืน</label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <input type="date" class="form-control" id="rent_return_date_fix" placeholder="วันที่กำหนดคืน"
                                    name="rent_return_date_fix" autocomplete="off" value="{{ $rent->rent_return_date_fix }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rent_return_date" class="col-sm-3 control-label"> วันที่ผู้ยืมคืน</label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <input type="date" class="form-control" id="rent_return_date" placeholder="วันที่ผู้ยืมคืน"
                                    name="rent_return_date" autocomplete="off" value="{{ $rent->rent_return_date }}">
                            </div>
                        </div>

                    </div>
                    <!-- /edit brand result -->

                </div> <!-- /modal-body -->

                <div class="modal-footer editCategoriesFooter">
                    <button type="button" id="clostEditModal" class="btn btn-default" data-dismiss="modal"> <i
                            class="glyphicon glyphicon-remove-sign"></i> ปิด</button>

                    <button type="submit" class="btn btn-success" id="editCategoriesBtn" data-loading-text="Loading..."
                        autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> บันทึก</button>
                </div>
                <!-- /modal-footer -->
            </form>
            <!-- /.form -->
        </div>
        <!-- /modal-content -->
    </div>
    <!-- /modal-dailog -->
</div>
<!-- /categories brand -->


</div>

<!-- Modal deleteRent -->
<div class='modal fade' id='removeRentModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
    aria-hidden='true'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                <h5 class='modal-title' id='myModalLabel'>ลบข่าว</h5>
            </div>
            <form action='{{ route('rent.destroy',$rent->id) }}' method='post'>
                @csrf
                {{method_field('delete')}}
                <div class='modal-body'>
                    คุณแน่ใจที่จะลบ ?
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>ยกเลิก</button>
                    <button type='submit' class='btn btn-danger'>ลบ</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal deleteRent -->

<script>
    $('#editRentModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var equipment = button.data('equipment')
        var equipment_id = button.data('equipment_id')
        var user_id = button.data('user_id')
        var user = button.data('user')
        var status = button.data('status')
        var etc = button.data('etc')
        var date = button.data('date')
        var returnfix = button.data('returnfix')
        var return = button.data('return')
        var modal = $(this)

        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #user').val(user);
        modal.find('.modal-body #user_id').val(user_id);
        modal.find('.modal-body #equipment').val(equipment);
        modal.find('.modal-body #equipment_id').val(equipment_id);
        modal.find('.modal-body #rent_status').val(status);
        modal.find('.modal-body #rent_etc').val(etc);
        modal.find('.modal-body #rent_date').val(date);
        modal.find('.modal-body #rent_return_date_fix').val(returnfix);
        modal.find('.modal-body #rent_return_date').val(return);

    })
    $('#removeRentModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
    })

</script>

@endsection
