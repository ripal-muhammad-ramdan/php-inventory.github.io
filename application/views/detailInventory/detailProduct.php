<div id="cntdetail">
    <input type="hidden" id="jqgrid_rowid">
    <table id="list3dt"></table>
    <div id="pager3dt"></div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        var grid_selector = "#list3dt";
        var pager_selector = "#pager3dt";

        // resize to fit page size
        $(window).on('resize.jqGrid', function() {
            $(grid_selector).jqGrid('setGridWidth', $(".ui-tabs .ui-tabs-panel").width());
        });

        // 
        jQuery("#list3dt").jqGrid({
            url: '<?php echo base_url(); ?>product/detailProduct',
            postData: {
                products_id: '<?= $products_id; ?>'
            },
            datatype: "json",
            mtype: "POST",
            colModel: [{
                    label: 'products_id',
                    name: 'products_id',
                    width: 50,
                    align: "left",
                    editable: true,
                    hidden: false,
                    editoptions: {
                        readonly: "readonly"
                    }
                },
                {
                    label: 'name Produc',
                    name: 'name_prod',
                    index: 'name_prod',
                    width: 100,
                    editable: true
                },
                {
                    label: 'Description',
                    name: 'description',
                    index: 'description',
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
            pager: '#pager3dt',
            sortname: 'products_id',
            viewrecords: true,
            shrinktofit: true,
            autowidth: true,
            sortorder: "asc",
            caption: "Detail Product",
            jsonReader: {
                root: 'rows',
                products_id: 'products_id',
                repeatitems: false,
            },
            loadComplete: function() {

                $(window).on('resize.jqGrid', function() {
                    $(grid_selector).jqGrid('setGridWidth', $(".ui-tabs .ui-tabs-panel").width());
                });

                setTimeout(function() {
                    $("#list3dt").setSelection($("#list3dt").getDataIDs()[0], true);
                    // $("#grid-table").focus();
                }, 500);

            },
            editurl: '<?php echo base_url(); ?>product/crudProduct',
            onSelectRow: function(rowid) {
                /*do something when selected*/
                $('#jqgrid_rowid').val(rowid);
            },
        })

        jQuery("#list3dt").jqGrid('navGrid', '#pager3dt', {
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
                $('#birth_date').datepicker({
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
                $('#birth_date').datepicker({
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
        var products_id = $('#list3').jqGrid('getCell', rowid, 'products_id');
        return data = {
            oper: 'del',
            products_id: products_id
        };

    }
</script>