<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- content table list mahasiswa -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-lg-4 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Stock Products</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id="tabs2">
                        <ul>
                            <li><a href="#tabs2-1">Stock Products</a></li>
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

        var date = new Date();
        var current_date = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
        $('#created_date').val('test');
        // alert(current_date);
        var grid_selector = "#list3";
        var pager_selector = "#pager3";

        //resize to fit page size
        $(window).on('resize.jqGrid', function() {
            $(grid_selector).jqGrid('setGridWidth', $(".ui-tabs .ui-tabs-panel").width());
        });

        jQuery("#list3").jqGrid({
            url: '<?php echo base_url(); ?>stockProduct/getStockProduct',
            datatype: "json",
            colModel: [{
                    label: 'Stok Product ID',
                    name: 'stock_products_id',
                    key: true,
                    index: 'stock_products_id',
                    width: 55,
                    editable: true,
                    hidden: false,
                    editoptions: {
                        readonly: "readonly"
                    }
                },
                {
                    label: 'store_info',
                    name: 'store_info_id',
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
                        dataUrl: "<?php echo base_url(); ?>stockProduct/html_select_storeInfo",
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
                    label: 'products',
                    name: 'products_id',
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
                        dataUrl: "<?php echo base_url(); ?>stockProduct/html_select_product",
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
                    label: 'name Store Info',
                    name: 'name',
                    index: 'name',
                    width: 100,
                    editable: false
                },
                {
                    label: 'name product',
                    name: 'name_prod',
                    index: 'name_prod',
                    width: 100,
                    editable: false
                },
                {
                    label: 'name product type',
                    name: 'name',
                    index: 'name',
                    width: 100,
                    editable: false,
                    editrules: {
                        edithidden: false,
                    },
                    align: "left"
                },
                {
                    label: 'created_date',
                    name: 'created_date',
                    index: 'created_date',
                    width: 80,
                    align: "left",
                    editable: false,
                    hidden: true,
                    editrules: {
                        edithidden: true,
                    },
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

                {
                    label: 'Stock',
                    name: 'stok',
                    index: 'stok',
                    width: 100,
                    editable: true,
                    editrules: {
                        edithidden: true
                    },
                },
            ],
            rowNum: 10,
            rowList: [10, 20, 30],
            pager: '#pager3',
            sortname: 'stock_products_id',
            viewrecords: true,
            shrinktofit: true,
            autowidth: true,
            sortorder: "asc",
            caption: "Data product",
            jsonReader: {
                root: 'rows',
                stock_products_id: 'stock_products_id',
                repeatitems: false,
            },
            loadComplete: function() {

                $(window).on('resize.jqGrid', function() {
                    $(grid_selector).jqGrid('setGridWidth', $(".ui-tabs .ui-tabs-panel").width());
                });

                setTimeout(function() {
                    $("#list3").setSelection($("#list3").getDataIDs()[0], true);
                    // $("#grid-table").focus();
                }, 500);

            },
            editurl: '<?php echo base_url(); ?>stockProduct/crudStockProduct',
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
        var stock_products_id = $('#list3').jqGrid('getCell', rowid, 'stock_products_id');
        return data = {
            oper: 'del',
            stock_products_id: stock_products_id
        };

    }
</script>