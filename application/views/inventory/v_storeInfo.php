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

                    <!-- Content here ! -->
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Store Info</a></li>
                            <!-- <li><a href="#tabs-2">Detail</a></li> -->
                        </ul>
                        <div id="tabs-1">
                            <input type="hidden" id="jqgrid_rowid">
                            <table id="list2"></table>
                            <div id="pager2"></div>

                        </div>
                        <div id="tabs-2">
                            <div id="tabsdt"></div>
                        </div>
                    </div>
                    <br>

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
        $("#tabs").tabs();
    });

    // $(function() {
    //     $("#tabs2").tabs();
    // });
</script>
<!-- Store Info -->
<script type="text/javascript">
    $(document).ready(function() {

        var grid_selector = "#list2";
        var pager_selector = "#pager2";

        //resize to fit page size
        $(window).on('resize.jqGrid', function() {
            $(grid_selector).jqGrid('setGridWidth', $(".ui-tabs .ui-tabs-panel").width());
        });

        jQuery("#list2").jqGrid({
            url: '<?php echo base_url(); ?>storeInfo/dataStoreInfo',
            datatype: "json",
            colModel: [{
                    label: 'store_info_id',
                    name: 'store_info_id',
                    key: true,
                    index: 'store_info_id',
                    width: 55,
                    editable: true,
                    hidden: false,
                    editoptions: {
                        readonly: "readonly"
                    }
                },
                {
                    label: 'store type',
                    name: 'store_type_id',
                    width: 50,
                    align: "left",
                    editable: true,
                    hidden: true,
                    editrules: {
                        edithidden: true,
                        required: true
                    },
                    edittype: 'select',
                    editoptions: {
                        dataUrl: "<?php echo base_url(); ?>storeType/html_select_StoreType",
                        dataInit: function(elem) {
                            $(elem).width(150); // set the width which you need
                        },
                        buildSelect: function(data) {
                            try {
                                var response = $.parseJSON(data);
                                if (response.success == false) {
                                    alert(response.message);
                                    return "";
                                }
                            } catch (err) {
                                return data;
                            }
                        }
                    }
                },
                {
                    label: 'name store',
                    name: 'name',
                    index: 'name',
                    width: 100,
                    editable: true
                },
                {
                    label: 'description',
                    name: 'description',
                    index: 'description',
                    width: 80,
                    align: "left",
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
                    hidden: true,
                    editrules: {
                        edithidden: true
                    },
                    editable: false
                },
                {
                    label: 'created_by',
                    name: 'created_by',
                    index: 'created_by',
                    width: 50,
                    sortable: true,
                    hidden: true,
                    editrules: {
                        edithidden: true
                    },
                    editable: false
                },
                {
                    label: 'updated_by',
                    name: 'updated_by',
                    index: 'updated_by',
                    width: 50,
                    sortable: true,
                    hidden: true,
                    editrules: {
                        edithidden: true
                    },
                    editable: false
                },
            ],
            rowNum: 10,
            rowList: [10, 20, 30],
            pager: '#pager2',
            sortname: 'store_info_id',
            viewrecords: true,
            shrinktofit: true,
            autowidth: true,
            sortorder: "asc",
            caption: "Data Store Info",
            jsonReader: {
                root: 'rows',
                store_info_id: 'store_info_id',
                repeatitems: false,
            },
            loadComplete: function() {

                $(window).on('resize.jqGrid', function() {
                    $(grid_selector).jqGrid('setGridWidth', $(".ui-tabs .ui-tabs-panel").width());
                });

                setTimeout(function() {
                    $("#list2").setSelection($("#list2").getDataIDs()[0], true);
                    // $("#grid-table").focus();
                }, 500);

            },
            editurl: '<?php echo base_url(); ?>storeInfo/crudStoreInfo',
            onSelectRow: function(rowid) {
                /*do something when selected*/
                $('#jqgrid_rowid').val(rowid);
            },
        });

        jQuery("#list2").jqGrid('navGrid', '#pager2', {
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
        var store_info_id = $('#list2').jqGrid('getCell', rowid, 'store_info_id');
        return data = {
            oper: 'del',
            store_info_id: store_info_id
        };

    }
</script>