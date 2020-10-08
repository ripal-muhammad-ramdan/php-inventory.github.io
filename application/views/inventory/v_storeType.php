<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- content table list mahasiswa -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-lg-4 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Store Info</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id="tabs2">
                        <ul>
                            <li><a href="#tabs2-1">Store Type</a></li>
                            <!-- <li><a href="#tabs2-2">Detail</a></li> -->
                        </ul>
                        <div id="tabs2-1">
                            <input type="hidden" id="jqgrid_rowid">
                            <table id="list3"></table>
                            <div id="pager3"></div>
                        </div>
                        <div id="tabs2-2">
                            <div id="tabsdt2"></div>
                        </div>
                    </div>

                </div>
                <!-- end card body -->
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script>
    $(function() {
        $("#tabs2").tabs();
    });
</script>

<!-- Store Type -->
<script type="text/javascript">
    $(document).ready(function() {

        var grid_selector = "#list3";
        var pager_selector = "#pager3";

        //resize to fit page size
        $(window).on('resize.jqGrid', function() {
            $(grid_selector).jqGrid('setGridWidth', $(".ui-tabs .ui-tabs-panel").width());
        });

        jQuery("#list3").jqGrid({
            url: '<?php echo base_url(); ?>storeType/getStoreType',
            datatype: "json",
            colModel: [{
                    label: 'store_type_id',
                    name: 'store_type_id',
                    key: true,
                    index: 'store_type_id',
                    width: 55,
                    editable: true,
                    hidden: false,
                    editoptions: {
                        readonly: "readonly"
                    }
                },
                {
                    label: 'name',
                    name: 'name',
                    index: 'name',
                    width: 100,
                    editable: true
                },
                {
                    label: 'created_date',
                    name: 'created_date',
                    index: 'created_date',
                    width: 80,
                    align: "left",
                    editable: false
                },
                {
                    label: 'updated_date',
                    name: 'updated_date',
                    index: 'updated_date',
                    width: 80,
                    align: "left",
                    editable: false
                },
                {
                    label: 'created_by',
                    name: 'created_by',
                    index: 'created_by',
                    width: 50,
                    sortable: true,
                    editable: false
                },
                {
                    label: 'updated_by',
                    name: 'updated_by',
                    index: 'updated_by',
                    width: 50,
                    sortable: true,
                    editable: false
                },
            ],
            rowNum: 10,
            rowList: [10, 20, 30],
            pager: '#pager3',
            sortname: 'store_type_id',
            viewrecords: true,
            shrinktofit: true,
            autowidth: true,
            sortorder: "asc",
            caption: "Data Store Type",
            jsonReader: {
                root: 'rows',
                store_info_id: 'store_type_id',
                repeatitems: false,
            },
            loadComplete: function() {

                $(window).on('resize.jqGrid', function() {
                    $(grid_selector).jqGrid('setGridWidth', $(".ui-tabs .ui-tabs-panel").width());
                });

                setTimeout(function() {
                    $("#list2").setSelection($("#list3").getDataIDs()[0], true);
                    // $("#grid-table").focus();
                }, 500);

            },
            editurl: '<?php echo base_url(); ?>storeType/crudStoreType',
            onSelectRow: function(rowid) {
                /*do something when selected*/
                $('#jqgrid_rowid').val(rowid);
            },
        });

        jQuery("#list3").jqGrid('navGrid', '#pager3', {
            edit: true,
            add: true,
            del: true
        }, {
            // options for the Edit Dialog
            closeAfterEdit: true,
            width: 500,
            errorTextFormat: function(data) {
                return 'Error: ' + data.responseText
            },
            recreateForm: true,
            afterShowForm: function(e) {
                $('#updated_date').datepicker({
                    dateFormat: "yy-mm-dd"
                })
            }
        }, {
            //new record form
            width: 500,
            errorTextFormat: function(data) {
                return 'Error: ' + data.responseText
            },
            closeAfterAdd: true,
            recreateForm: true,
            viewPagerButtons: false,
            afterShowForm: function(e) {
                $('#updated_date').datepicker({
                    dateFormat: "yy-mm-dd"
                })
            }
        }, {
            //delete record form
            serializeDelData: setDataDel,
            recreateForm: true
        });
    });

    function setDataDel() {
        var rowid = $('#jqgrid_rowid').val();
        var store_type_id = $('#list3').jqGrid('getCell', rowid, 'store_type_id');
        return data = {
            oper: 'del',
            store_type_id: store_type_id
        };

    }
</script>
<!-- Detail Store Info -->
<!-- <script type="text/javascript">
    $(document).ready(function() {
        $("#tabs ul li a").click(function(e) {
            if ($(this).attr("href") == "#tabs-2") {
                // get elemet grid tab (1)
                var grid = $('#list2');
                // get atribute dari selrow yang di select             
                var idpsn = grid.jqGrid('getGridParam', 'selrow');
                // get value field dari selrow yang di piliih , nama & id_p merupakan field
                // yang ada di jqgrid (merefer ke name nya)

                var store_info_id = grid.jqGrid('getCell', idpsn, 'store_info_id');
                var store_type_id = grid.jqGrid('getCell', idpsn, 'store_type_id');
                var name = grid.jqGrid('getCell', idpsn, 'name');
                var description = grid.jqGrid('getCell', idpsn, 'description');
                var created_date = grid.jqGrid('getCell', idpsn, 'created_date');
                var updated_date = grid.jqGrid('getCell', idpsn, 'updated_date');
                var created_by = grid.jqGrid('getCell', idpsn, 'created_by');
                var updated_by = grid.jqGrid('getCell', idpsn, 'updated_by');

                // load & get content detail untuk di put di tabs 2 
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url(); ?>detailTab",
                    // data yang di kirim (method post) ke detail sebagai filter
                    // query data d detail, data dsini bisa di sesuaikan dengan kebutuhan
                    // tidak harus 2 (id_pasien & nama pasien) 
                    data: {
                        store_info_id: store_info_id,
                        store_type_id: store_type_id,
                        name: name,
                        description: description,
                        created_date: created_date,
                        updated_date: updated_date,
                        created_by: created_by,
                        updated_by: updated_by
                    },
                    timeout: 10000,
                    success: function(data) {
                        $("#tabsdt").html(data);
                    }
                })
                return false;
            }
        });
    });
</script> -->
<!-- Detail Store Info -->
<!-- <script type="text/javascript">
    $(document).ready(function() {
        $("#tabs2 ul li a").click(function(e) {
            if ($(this).attr("href") == "#tabs2-2") {
                // get elemet grid tab (1)
                var grid = $('#list3');
                // get atribute dari selrow yang di select             
                var idpsn = grid.jqGrid('getGridParam', 'selrow');
                // get value field dari selrow yang di piliih , nama & id_p merupakan field
                // yang ada di jqgrid (merefer ke name nya)

                var store_type_id = grid.jqGrid('getCell', idpsn, 'store_type_id');
                var name = grid.jqGrid('getCell', idpsn, 'name');
                var created_date = grid.jqGrid('getCell', idpsn, 'created_date');
                var updated_date = grid.jqGrid('getCell', idpsn, 'updated_date');
                var created_by = grid.jqGrid('getCell', idpsn, 'created_by');
                var updated_by = grid.jqGrid('getCell', idpsn, 'updated_by');

                // load & get content detail untuk di put di tabs 2 
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url(); ?>detailTab/detailStoreType",
                    // data yang di kirim (method post) ke detail sebagai filter
                    // query data d detail, data dsini bisa di sesuaikan dengan kebutuhan
                    // tidak harus 2 (id_pasien & nama pasien) 
                    data: {
                        store_type_id: store_type_id,
                        name: name,
                        created_date: created_date,
                        updated_date: updated_date,
                        created_by: created_by,
                        updated_by: updated_by
                    },
                    timeout: 10000,
                    success: function(data) {
                        $("#tabsdt2").html(data);
                    }
                })
                return false;
            }
        });
    });
</script> -->