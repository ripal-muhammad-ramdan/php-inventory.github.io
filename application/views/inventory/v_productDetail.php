<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- content table list mahasiswa -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-lg-4 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Products</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div id="tabs2">
                        <ul>
                            <li><a href="#tabs2-1">Products Tarif Detail</a></li>
                            <li><a href="#tabs2-2">Detail</a></li>
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
            url: '<?php echo base_url(); ?>productDetail/getProductTarif',
            datatype: "json",
            colModel: [{
                    label: 'product_tariff_dt_id',
                    name: 'product_tariff_dt_id',
                    key: true,
                    index: 'product_tariff_dt_id',
                    width: 55,
                    editable: true,
                    hidden: false,
                    editoptions: {
                        readonly: "readonly"
                    }
                },
                {
                    label: 'products name',
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
                        dataUrl: "<?php echo base_url(); ?>productDetail/html_select_product",
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
                    label: 'name product',
                    name: 'name_prod',
                    index: 'name_prod',
                    width: 100,
                    editable: false
                },
                {
                    label: 'Rate',
                    name: 'rate',
                    index: 'rate',
                    width: 100,
                    editable: true,
                    editrules: {
                        edithidden: true
                    },
                },
                {
                    label: 'Valid From',
                    name: 'valid_from',
                    index: 'valid_from',
                    width: 100,
                    editable: true,
                    editrules: {
                        edithidden: true
                    },
                },
                {
                    label: 'Valid Until',
                    name: 'valid_until',
                    index: 'valid_until',
                    width: 100,
                    editable: true,
                    editrules: {
                        edithidden: true
                    },
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
                        edithidden: true
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
            ],
            rowNum: 10,
            rowList: [10, 20, 30],
            pager: '#pager3',
            sortname: 'product_tariff_dt_id',
            viewrecords: true,
            shrinktofit: true,
            autowidth: true,
            sortorder: "asc",
            caption: "Data product Tarif Detail",
            jsonReader: {
                root: 'rows',
                product_tariff_dt_id: 'product_tariff_dt_id',
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
            editurl: '<?php echo base_url(); ?>productDetail/crudProductTarifDetail',
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
                $('#valid_from').datepicker({
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
                $('#valid_from').datepicker({
                    dateFormat: "yy-mm-dd"
                })
            }
        },{
            //delete record form
            serializeDelData: setDataDel,
            recreateForm: true
        });
    });

    function setDataDel() {
        var rowid = $('#jqgrid_rowid').val();
        var product_tariff_dt_id = $('#list3').jqGrid('getCell', rowid, 'product_tariff_dt_id');
        return data = {
            oper: 'del',
            product_tariff_dt_id: product_tariff_dt_id
        };

    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#tabs2 ul li a").click(function(e) {
            if ($(this).attr("href") == "#tabs2-2") {
                // get elemet grid tab (1)
                var grid = $('#list3');
                // get atribute dari selrow yang di select             
                var idpsn = grid.jqGrid('getGridParam', 'selrow');
                // get value field dari selrow yang di piliih , nama & id_p merupakan field
                // yang ada di jqgrid (merefer ke name nya)

                var product_tariff_dt_id = grid.jqGrid('getCell', idpsn, 'product_tariff_dt_id');
                var products_id = grid.jqGrid('getCell', idpsn, 'products_id');
                var rate = grid.jqGrid('getCell', idpsn, 'rate');
                var valid_from = grid.jqGrid('getCell', idpsn, 'valid_from');
                var valid_until = grid.jqGrid('getCell', idpsn, 'valid_until');
                var created_date = grid.jqGrid('getCell', idpsn, 'created_date');
                var updated_date = grid.jqGrid('getCell', idpsn, 'updated_date');
                var created_by = grid.jqGrid('getCell', idpsn, 'created_by');
                var updated_by = grid.jqGrid('getCell', idpsn, 'updated_by');

                // load & get content detail untuk di put di tabs 2 
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url(); ?>detailTab/detailProductDetail",
                    // data yang di kirim (method post) ke detail sebagai filter
                    // query data d detail, data dsini bisa di sesuaikan dengan kebutuhan
                    // tidak harus 2 (id_pasien & nama pasien) 
                    data: {
                        product_tariff_dt_id: product_tariff_dt_id,
                        products_id: products_id,
                        rate: rate,
                        valid_from: valid_from,
                        valid_until: valid_until,
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
</script>