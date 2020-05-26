@extends('layouts.app-admin')

@section('body')

<div class="row">
    <div class="col-md-12">

        <ol class="breadcrumb">
            <li><a href="/categories">คลัง</a></li>
            <li class="active">{{ $categories1 }}</li>
        </ol>

        <div class="panel panel-default">
            <div class="panel-heading">

                 <h3 style="text-align:center;">{{ $categories1 }}</h3>
                {{-- <h3 style="text-align:center;">list</h3> --}}
            </div>
            <!-- /panel-heading -->
            <div class="panel-body">
                <div class="remove-messages"></div>

                <div class="div-action pull" style="padding-bottom:5px;" align="right">
                    {{-- <button class="btn btn-success button1" data-toggle="modal" id="#addCategoriesModalBtn"
                        data-target="addCategoriesModal"> <i class="glyphicon glyphicon-plus-sign"></i>
                        เพิ่มประเภทครุภัณฑ์ </button> --}}
                    <button class="btn btn-success button1" data-toggle="modal" data-target="#addCategorieslistModal"><i
                            class="glyphicon glyphicon-plus-sign"></i> เพิ่มรายการครุภัณฑ์</button>
                </div> <!-- /div-action -->

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
                                <th>รายการ</th>
                                <th>ราคา/หน่วย</th>
                                <th>วิธีการได้มา</th>
                                <th>ปีงบประมาณ</th>
                                <th style="width:15%;">ตัวเลือก</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorieslist as $categorieslist)
                            <tr>
                                <td><a href="/equipment/{{ $categorieslist->id }}"><label style="Font-weight:normal;font-size:15px;">{{ $categorieslist->list_title }}</label></a></td>
                                <td>{{ $categorieslist->list_price_per_unit }}</td>
                                <td>{{ $categorieslist->list_get }}</td>
                                <td>{{ $categorieslist->list_fiscalyear }}</td>

                                <td>
                                    <button type="button" class="btn btn-warning" data-id="{{ $categorieslist->id }}"
                                        data-title="{{ $categorieslist->list_title }}"
                                        data-price="{{ $categorieslist->list_price_per_unit }}"
                                        data-get="{{ $categorieslist->list_get }}"
                                        data-fiscalyear="{{ $categorieslist->list_fiscalyear }}"
                                        data-categories="{{ $categorieslist->categories_id }}" data-toggle="modal"
                                        data-status="{{ $categorieslist->list_status }}" data-toggle="modal"
                                        data-target="#editCategorieslistModal"> <i class="glyphicon glyphicon-edit"></i>
                                        แก้ไข</button>
                                    <button type="button" class="btn btn-danger" data-catid="{{ $categorieslist->id }}"
                                        data-toggle="modal" data-target="#removeCategorieslistModal"> <i
                                            class="glyphicon glyphicon-trash"></i> ลบ</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /table -->

                </div> <!-- /panel-body -->
            </div> <!-- /panel -->
        </div> <!-- /col-md-12 -->
    </div> <!-- /row -->

    <!-- add categorieslist -->
    <div class="modal fade" aria-labelledby="myModalLabel" id="addCategorieslistModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form class="form-horizontal" id="submitCategorieslistForm" action="{{ route('categorieslist.store') }}"
                    method="post">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> เพิ่มรายการของ</h4>
                    </div>
                    <div class="modal-body">

                        <div id="add-categories-messages"></div>
                        <input type="hidden" name="categories_id" id="categories_id" value="1">
                        <input type="hidden" name="list_status" id="list_status" value="1">

                        <div class="form-group">
                            <label for="list_title" class="col-sm-4 control-label">ชื่อรายการ </label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="list_title" placeholder="ชื่อรายการ"
                                    name="list_title" autocomplete="off">
                            </div>
                        </div> <!-- /form-group-->

                        <div class="form-group">
                            <label for="list_price_per_unit" class="col-sm-4 control-label">ราคา/หน่วย </label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="list_price_per_unit"
                                    placeholder="ราคาต่อหน่วย" name="list_price_per_unit" autocomplete="off">
                            </div>
                        </div> <!-- /form-group-->

                        <div class="form-group">
                            <label for="list_get" class="col-sm-4 control-label">วิธีการได้มา </label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="list_get" placeholder="เช่น สอบราคา"
                                    name="list_get" autocomplete="off">
                            </div>
                        </div> <!-- /form-group-->

                        <div class="form-group">
                            <label for="list_fiscalyear" class="col-sm-3 control-label">ปีงบประมาณ </label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-8">
                                <select class="form-control" id="list_fiscalyear" name="list_fiscalyear">
                                    <option value="">~~เลือก~~</option>
                                    @for ($i = 2400; $i < 2600; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div> <!-- /form-group-->

                    </div> <!-- /modal-body -->
                    <input type="hidden" value="" name="categoriesCode" />
                    <div class="modal-footer">
                        <button type="button" id="clostAddCate" class="btn btn-default" data-dismiss="modal"> <i
                                class="glyphicon glyphicon-remove-sign"></i> ปิด</button>

                        <button type="submit" class="btn btn-primary" data-loading-text="Loading..." autocomplete="off">
                            <i class="glyphicon glyphicon-ok-sign"></i>
                            บันทึก</button>
                    </div> <!-- /modal-footer -->
                </form> <!-- /.form -->
            </div> <!-- /modal-content -->
        </div> <!-- /modal-dailog -->
    </div>
    <!-- /add categorieslist -->

    <!-- edit categorieslist brand -->
    <div class="modal fade" id="editCategorieslistModal" aria-labelledby="myModalLabel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form class="form-horizontal" action="{{ route('categorieslist.update',$categorieslist->id) }}"
                    method="POST">
                    @csrf
                    {{ method_field('patch') }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-edit"></i>แก้ไขประเภทครุภัณฑ์</h4>
                    </div>
                    <div class="modal-body">

                        <div class="edit-categories-result">
                            <input type="hidden" name="list_status" id="list_status" value="">

                            <div class="form-group">
                                <label for="list_title" class="col-sm-4 control-label">ชื่อรายการ</label>
                                <label class="col-sm-1 control-label">: </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="list_title" placeholder="ชื่อรายการ"
                                        name="list_title" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="list_price_per_unit" class="col-sm-4 control-label">ราคา/หน่วย </label>
                                <label class="col-sm-1 control-label">: </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="list_price_per_unit"
                                        placeholder="ราคาต่อหน่วย" name="list_price_per_unit" autocomplete="off">
                                </div>
                            </div> <!-- /form-group-->

                            <div class="form-group">
                                <label for="list_get" class="col-sm-4 control-label">วิธีการได้มา </label>
                                <label class="col-sm-1 control-label">: </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="list_get" placeholder="เช่น สอบราคา"
                                        name="list_get" autocomplete="off">
                                </div>
                            </div> <!-- /form-group-->

                            <div class="form-group">
                                <label for="list_fiscalyear" class="col-sm-3 control-label">ปีงบประมาณ </label>
                                <label class="col-sm-1 control-label">: </label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="list_fiscalyear" name="list_fiscalyear">
                                         @for ($i = 2400; $i < 2600; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div> <!-- /form-group-->

                            <div class="form-group">
                                <label for="categories_id" class="col-sm-3 control-label">ประเภทครุภัฑณ์ </label>
                                <label class="col-sm-1 control-label">: </label>
                                <div class="col-sm-8">
                                <select class="form-control" name="categories_id" id="categories_id">
                                    @foreach ($categories as $categories)
                                        <option value="{{ $categories->id }}">{{ $categories->categories_code }} : {{ $categories->categories_name }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>

                        </div>
                        <!-- /edit brand result -->

                    </div> <!-- /modal-body -->

                    <div class="modal-footer editCategoriesFooter">
                        <button type="button" id="clostEditModal" class="btn btn-default" data-dismiss="modal"> <i
                                class="glyphicon glyphicon-remove-sign"></i> ปิด</button>

                        <button type="submit" class="btn btn-success" id="editCategoriesBtn"
                            data-loading-text="Loading..." autocomplete="off"> <i
                                class="glyphicon glyphicon-ok-sign"></i> บันทึก</button>
                    </div>
                    <!-- /modal-footer -->
                </form>
                <!-- /.form -->
            </div>
            </div>
            <!-- /modal-content -->
        </div>
        <!-- /modal-dailog -->
    </div>
    <!-- /categorieslist brand -->

    <!-- categories brand -->
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" role="dialog" id="removeCategorieslistModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> ลบประเภทครุภัณฑ์</h4>
            </div>
            <form action="{{ route('categorieslist.destroy',$categorieslist->id) }}" method="POST">
                @csrf
                {{method_field('delete')}}
            <div class="modal-body">
                <p>คุณแน่ใจว่าจะลบ ?</p>
            </div>
            <div class="modal-footer removeCategoriesFooter">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                        class="glyphicon glyphicon-remove-sign"></i> ปิด</button>
                <button type="submit" class="btn btn-primary" id="removeCategoriesBtn" data-loading-text="Loading...">
                    <i class="glyphicon glyphicon-ok-sign"></i> ยืนยัน</button>
            </div>
        </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand -->

    <script>
        $('#editCategorieslistModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var title = button.data('title')
            var price = button.data('price')
            var get = button.data('get')
            var fiscalyear = button.data('fiscalyear')
            var status = button.data('status')
            var categories = button.data('categories')
            var modal = $(this)

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #list_title').val(title);
            modal.find('.modal-body #list_price_per_unit').val(price);
            modal.find('.modal-body #list_get').val(get);
            modal.find('.modal-body #list_fiscalyear').val(fiscalyear);
            modal.find('.modal-body #categories_id').val(categories);
            modal.find('.modal-body #list_status').val(status);

        })
        $('#removeCategorieslistModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })

    </script>

    @endsection
