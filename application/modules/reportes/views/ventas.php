<?php echo $this->load->view('global_views/header_dashboard'); ?>
    <script type="text/javascript"
            src='<?= base_url(); ?>assets/plugins/bootstrap-select-master/js/bootstrap-select.js'></script>
    <link rel="stylesheet" type="text/css"
          href="<?= base_url(); ?>assets/plugins/bootstrap-select-master/docs/docs/dist/css/bootstrap-select.css">

    <script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
    <script src="<?=base_url()?>assets/js/bootbox.js"></script>
    </head>
<?php echo $this->load->view('global_views/contenedor'); ?>
    <div class="page-header">
        <h1>
            <i class="fa fa-cogs grey"></i>
            Comedor
            <small>
                <i class="fa fa-angle-double-right"></i>
                Datos de la venta
            </small>
        </h1>
    </div>
    <div class="space-12"></div>

    <h4 class="pink">
        <i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer blue"></i>
        <a href="#modal-table" role="button" class="green" data-toggle="modal"> Table Inside a Modal Box </a>
    </h4>
    <div class="row">
        <div class="col-xs-12">
            <h3 class="header smaller lighter blue">jQuery dataTables</h3>

            <div class="clearfix">
                <div class="pull-right tableTools-container"></div>
            </div>
            <div class="table-header">
                Results for "Latest Registered Domains"
            </div>
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>id_unidad</th>
                        <th>detalle</th>
                        <th>abreviatura</th>
                        <th>usuario_insertar</th>
                        <th>fecha_insertar</th>
                        <th>usuario_modificar</th>
                        <th>fecha_modificar</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                </table>
        </div>
    </div>

    <div id="modal-table" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header no-padding">
                    <div class="table-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <span class="white">&times;</span>
                        </button>
                        Results for "Latest Registered Domains
                    </div>
                </div>

                <div class="modal-body no-padding">
                    <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top" id="modal-body">
                        <thead>
                        <tr>
                            <th>Domain</th>
                            <th>Price</th>
                            <th>Clicks</th>

                            <th>
                                <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                Update
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>
                                <a href="#">ace.com</a>
                            </td>
                            <td>$45</td>
                            <td>3,330</td>
                            <td>Feb 12</td>
                        </tr>

                        <tr>
                            <td>
                                <a href="#">base.com</a>
                            </td>
                            <td>$35</td>
                            <td>2,595</td>
                            <td>Feb 18</td>
                        </tr>

                        <tr>
                            <td>
                                <a href="#">max.com</a>
                            </td>
                            <td>$60</td>
                            <td>4,400</td>
                            <td>Mar 11</td>
                        </tr>

                        <tr>
                            <td>
                                <a href="#">best.com</a>
                            </td>
                            <td>$75</td>
                            <td>6,500</td>
                            <td>Apr 03</td>
                        </tr>

                        <tr>
                            <td>
                                <a href="#">pro.com</a>
                            </td>
                            <td>$55</td>
                            <td>4,250</td>
                            <td>Jan 21</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer no-margin-top">
                    <button class="btn btn-sm btn-danger pull-left" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        Close
                    </button>

                    <ul class="pagination pull-right no-margin">
                        <li class="prev disabled">
                            <a href="#">
                                <i class="ace-icon fa fa-angle-double-left"></i>
                            </a>
                        </li>

                        <li class="active">
                            <a href="#">1</a>
                        </li>

                        <li>
                            <a href="#">2</a>
                        </li>

                        <li>
                            <a href="#">3</a>
                        </li>

                        <li class="next">
                            <a href="#">
                                <i class="ace-icon fa fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <script type="text/javascript">

        var module = 'Modulo de Unidad';
        var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
        var f=new Date();
        var fecha = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " del " + f.getFullYear();
        jQuery(function($) {
            $('#modal-body').DataTable();
            function loadTable(src,tableName)
            {
                var oTable1 = $('#'+tableName).DataTable({
                    destroy : true,
                    bAutoWidth: false,
                    "processing": true,
                    "serverSide": true,


                    "ajax": {
                        "url": src
                    },
                    "columns": [
                        {"data": "id_unidad"},
                        {"data": "detalle"},
                        {"data": "abreviatura"},
                        {"data": "usuario_insertar"},
                        {"data": "fecha_insertar"},
                        {"data": "usuario_modificar"},
                        {"data": "fecha_modificar"},
                        {"data": ""}
                    ],
                    "columnDefs": [
                        {
                            "targets": [3,4,5,6],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "targets": -1,
                            "data": null,
                            "defaultContent": '<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">'+
                            '<span class="red">'+
                            '<i class="ace-icon fa fa-trash-o bigger-120"></i>'+
                            '</span>'+
                            '</a>'
                        }
                    ]
                });

                //initchildrows()
            }
            //initiate dataTables plugin
            var oTable1;
            oTable1 = $('#dynamic-table')
                .DataTable({
                    destroy : true,
                    bAutoWidth: false,
                    "ajax": {
                        "url": 'ventas/getAll'
                    },
                    //"processing": true,
                    "serverSide": true,
                    "columns": [
                        {"data": "id_unidad"},
                        {"data": "detalle"},
                        {"data": "abreviatura"},
                        {"data": "usuario_insertar"},
                        {"data": "fecha_insertar"},
                        {"data": "usuario_modificar"},
                        {"data": "fecha_modificar"},
                        {"data": ""}
                    ],
                    "columnDefs": [
                        {
                            "targets": [3,4,5,6],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "targets": -1,
                            "data": null,
                            "defaultContent": '<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">'+
                            '<span class="red">'+
                            '<i class="ace-icon fa fa-trash-o bigger-120"></i>'+
                            '</span>'+
                            '</a>'
                        }
                    ]
                });

            $('#dynamic-table').on( 'click', 'a', function () {
                var data = oTable1.row($(this).parents('tr')).data();
                if (confirm('Are you sure you want to delete SKU "' + data['id_unidad'] + '"?')) {
                    eliminar_unidad(data['id_unidad']);
                    $.getJSON('ventas/getAll', function (data) {
                        if (data) {
                            oTable1.ajax.reload(null,false);
                        }
                    });
                }
                event.stopPropagation();
                return false;
                //var data = oTable1.row($(this).parents('tr')).data();
                //
            });
            function eliminar_unidad(id) {
                $('#div_textbox').hide(500);
                bootbox.confirm("Estas seguro que deseas eliminar la Unidad?, Recuerda que no se podr&aacute; recuperar.", function (result) {
                    if (result) {
                        $.ajax({
                            url: 'ventas/eliminar_unidad',
                            type: 'POST',
                            dataType: 'json',
                            data: {id: id},
                            beforeSend: function () {

                            },
                            success: function (data) {



                                loadTable('ventas/getAll','dynamic-table')
                                }


                        });

                    }
                });
            }

            //TableTools settings
            TableTools.classes.container = "btn-group btn-overlap";
            TableTools.classes.print = {
                "body": "DTTT_Print",
                "info": "tableTools-alert gritter-item-wrapper gritter-info gritter-center white",
                "message": "tableTools-print-navbar"
            }

            //initiate TableTools extension
            var tableTools_obj = new $.fn.dataTable.TableTools( oTable1, {
                "sSwfPath": "../assets/js/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf", //in Ace demo ../assets will be replaced by correct assets path
                "sRowSelector": "td:not(:last-child)",
                "sRowSelect": "multi",
                "fnRowSelected": function(row) {
                    //check checkbox when row is selected
                    try { $(row).find('input[type=checkbox]').get(0).checked = true }
                    catch(e) {}
                },
                "fnRowDeselected": function(row) {
                    //uncheck checkbox
                    try { $(row).find('input[type=checkbox]').get(0).checked = false }
                    catch(e) {}
                },
                "sSelectedClass": "success",
                "aButtons": [
                    {
                        "sExtends": "copy",
                        "sToolTip": "Copiar a portapapeles",
                        "sButtonClass": "btn btn-white btn-primary btn-bold",
                        "sButtonText": "<i class='fa fa-copy bigger-110 pink'></i>",
                        "fnComplete": function() {
                            this.fnInfo( '<h3 class="no-margin-top smaller">Tabla Copiada</h3>\
									<p>Copiado '+(oTable1.fnSettings().fnRecordsTotal())+' fila(s) al portapapeles.</p>',
                                1500
                            );
                        }
                    },

                    {
                        "sExtends": "csv",
                        "sToolTip": "Exportar a CVS",
                        "sTitle": module+ " - "+fecha,
                        "sButtonClass": "btn btn-white btn-primary  btn-bold",
                        "sButtonText": "<i class='fa fa-file-excel-o bigger-110 green'></i>"
                    },

                    {
                        "sExtends": "pdf",
                        "sToolTip": "Exportar a PDF",
                        "sTitle": module+ " - "+fecha,
                        "sButtonClass": "btn btn-white btn-primary  btn-bold",
                        "sButtonText": "<i class='fa fa-file-pdf-o bigger-110 red'></i>"
                    },

                    {
                        "sExtends": "print",
                        "sToolTip": "Imprimir",
                        "sTitle": module+ " - "+fecha,
                        "sButtonClass": "btn btn-white btn-primary  btn-bold",
                        "sButtonText": "<i class='fa fa-print bigger-110 grey'></i>",

                        "sMessage": "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small>Vista de Impresión - Modulo Unidad</small></a></div></div>",

                        "sInfo": "<h3 class='no-margin-top'>Vista de Impresión</h3>\
									  <p>Porfavor use la función de su navegador para Imprimir las Tablas.\
									  <br />Presione <b>escape</b> Para finalizar.</p>",
                    }
                ]
            } );
            //we put a container before our table and append TableTools element to it
            $(tableTools_obj.fnContainer()).appendTo($('.tableTools-container'));
            setTimeout(function() {
                $(tableTools_obj.fnContainer()).find('a.DTTT_button').each(function() {
                    var div = $(this).find('> div');
                    if(div.length > 0) div.tooltip({container: 'body'});
                    else $(this).tooltip({container: 'body'});
                });
            }, 200);



            //ColVis extension
            var colvis = new $.fn.dataTable.ColVis( oTable1, {
                "buttonText": "<i class='fa fa-search'></i>",
                "aiExclude": [0,1,2],
                "showAll": "Mostrar Todo",
                "bShowAll": true,
                "bRestore": true,
                "sAlign": "right",
                "fnLabel": function(i, title, th) {
                    return $(th).text();//remove icons, etc
                }

            });

            //style it
            $(colvis.button()).addClass('btn-group').find('button').addClass('btn btn-white btn-info btn-bold')

            //and append it to our table tools btn-group, also add tooltip
            $(colvis.button())
                .prependTo('.tableTools-container .btn-group')
                .attr('title', 'Mostrar/Ocultar columnas').tooltip({container: 'body'});

            //and make the list, buttons and checkboxed Ace-like
            $(colvis.dom.collection)
                .addClass('dropdown-menu dropdown-light dropdown-caret dropdown-caret-right')
                .find('li').wrapInner('<a href="javascript:void(0)" />') //'A' tag is required for better styling
                .find('input[type=checkbox]').addClass('ace').next().addClass('lbl padding-8');
        })
    </script>



<?php $this->load->view('global_views/footer_dashboard'); ?>