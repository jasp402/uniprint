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

<script type="text/javascript">


    //##################################################################



    //DIV FORM CREATE
    function div_agregar() {
        $('#div_textbox').show(300);
        $('#titulo_div').html('Registrar');
        $("#form")[0].reset();
        $('#div_btn_edit').hide();
        $('#div_btn_save').show();
    }
    //DIV FORM EDIT
    function div_editar(id){
        $('#div_textbox').show(300);
        $('#titulo_div').html('Editar');
        //$('#cod_alumno').val(id);
        //$('#cod_alumno').prop('readonly', true);
        $('#div_btn_save').hide();
        $('#div_btn_edit').show();

        $.ajax({
            url: 'proyectos/searchAllById',
            type: 'POST',
            dataType: 'json',
            data: {id: id},
            success: function(data) {
                console.log(data);
                var r = data.result[0];
                $.each(r, function(indice, valor) {
                    $("#"+indice).val(valor);
                });
            }
        });
    }
    //CREAR UNIDAD
    function Save() {
        var cod = $('#nombre').val().trim();
        if (cod == "") {
            alert("complete todos campo");
        } else {
            $.ajax({
                url: 'proyectos/save',
                type: 'POST',
                dataType: 'json',
                data: $('#form').serialize(),
                beforeSend: function () {
                    desactivar_inputs('form');
                    mensaje_gbl('Procesando...', 'info', 'clock-o', 'mensaje_crud_apoderado');
                },
                success: function (data) {
                    if (data) {
                        mensaje_gbl('Completado', 'success', 'check', 'mensaje_crud_apoderado');
                        message_box(data.success, data.times, data.closes);
                    } else {
                        activar_inputs('form');
                        mensaje_gbl('Error', 'danger', 'times', 'mensaje_crud_apoderado');
                    }
                }
            });
        }
    }
    //EDITAR UNIDAD
    function Edit() {
        $.ajax({
            url: 'proyectos/edit',
            type: 'POST',
            dataType: 'json',
            data: $('#form').serialize(),
            beforeSend: function () {
                desactivar_inputs('form');
                mensaje_gbl('Procesando...', 'info', 'clock-o', 'mensaje_crud_apoderado');
            },
            success: function (data) {
                if (data) {
                    mensaje_gbl('Completado', 'success', 'check', 'mensaje_crud_apoderado');
                    message_box(data.success, data.times, data.closes);
                } else {
                    activar_inputs('form');
                    mensaje_gbl('Error', 'danger', 'times', 'mensaje_crud_apoderado');
                }
            }
        });
    }
    //ELIMINAR UNIDAD
    function Delete(id) {
        $('#div_textbox').hide(500);
        bootbox.confirm("Estas seguro que deseas eliminar este registro?, Recuerda que no se podr&aacute; recuperar.", function (result) {
            if (result) {
                $.ajax({
                    url: 'proyectos/delete',
                    type: 'POST',
                    dataType: 'json',
                    data: {id: id},
                    success: function (data) {
                        message_box(data.success, data.times, data.closes);
                    }
                });
            }
        });
    }
</script>
</head>
<?php echo $this->load->view('global_views/contenedor'); ?>

<!-- CABECERA -->
<div class="page-header">
    <h1>
        <i class="fa fa-cube grey"></i>
        Productos
        <small>
            <i class="fa fa-angle-double-right"></i>
            Gestionar Proyectos
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="infobox infobox-green2">
            <div class="infobox-icon">
                <i class="ace-icon fa fa-bar-chart"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?= count($this->CRUD->__getAll($this->schema['table']));?></span>
                <div class="infobox-content">
                    <a href="#modal-table" role="button" data-toggle="modal" onclick="javascript:div_agregar()";>
                        <i class="ace-icon fa fa fa-external-link"></i>
                    Agregar Proyecto
                    </a>
                </div>
            </div>
        </div>

        <div class="space-6"></div>

        <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>
        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>codigo</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php if ($this->CRUD->__getAll($this->schema['table'])): ?>
                    <?php foreach ($this->CRUD->__getAll($this->schema['table']) as $keyAll): ?>
                        <tr>
                            <td><?= $keyAll->id_proyecto; ?></td>
                            <td><?= $keyAll->nombre; ?></td>
                            <td><?= $keyAll->descripcion; ?></td>
                            <td>
                                <div class="hidden-sm hidden-xs action-buttons">
                                    <a href="#modal-table" role="button" data-toggle="modal" class="green" onclick="div_editar('<?= $keyAll->id_proyecto?>');">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>

                                    <a class="red" href="#"
                                       onclick="Delete('<?= $keyAll->id_proyecto ?>');">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </a>
                                </div>

                                <div class="hidden-md hidden-lg">
                                    <div class="inline pos-rel">
                                        <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown"
                                                data-position="auto">
                                            <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                            <li>
                                                <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
												<span class="green">
													<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
												</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
												<span class="red">
													<i class="ace-icon fa fa-trash-o bigger-120"></i>
												</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                <?php endif ?>
                </tbody>
            </table>
        </div>

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
                    <span class="bigger-140" id="titulo_div"></span>
                </div>
            </div>

            <div class="modal-body no-padding">
                <!-- FORMULARIO DE CRUD -->
                <div class="row" id="div_textbox" style="display: none;">
                    <div id="mensaje_crud_apoderado"></div>
                    <div class="hr hr-18 dotted"></div>

                    <div class="col-sm-12">
                        <?php echo form_open('', "id='form' class='form-horizontal' "); ?>
                        <div class="col-sm-12">

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Nombre del Proyecto: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input type="hidden" id="id_proyecto" name="id_proyecto">
                                        <input class="form-control" type="textbox" name="nombre" id="nombre" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Descripción del Proyecto: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <textarea class="form-control" name="descripcion" id="descripcion" maxlength="500"></textarea>                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer no-margin-top">
                <button class="btn btn-sm btn-danger pull-left" data-dismiss="modal">
                    <i class="ace-icon fa fa-times"></i>
                    Close
                </button>
                <div style="display: none;" id="div_btn_edit">
                    <button class="btn btn-sm btn-warning" id="btn_edit" onclick="javascript:Edit();">
                        <i class="fa fa-pencil bigger-120"></i>
                        Editar
                    </button>
                </div>
                <div style="display: none;" id="div_btn_save">
                    <button class="btn btn-sm btn-primary" id="btn_save" onclick="javascript:Save();">
                        <i class="fa fa-save bigger-120"></i>
                        Registrar
                    </button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- PAGE CONTENT ENDS -->
<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='<?=base_url();?>assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
</script>
<script type="text/javascript">
    var module = 'Modulo de Unidad';
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f=new Date();
    var fecha = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " del " + f.getFullYear();
    jQuery(function($) {
        //initiate dataTables plugin
        var oTable1 =
            $('#dynamic-table')

                .dataTable({
                    bAutoWidth: false,
                    "aoColumns": [
                        { "bSortable": false },
                        null,null,
                        { "bSortable": false }
                    ],
                    "aaSorting": []
                } );

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
            "aiExclude": [3],
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



        /////////////////////////////////
        //table checkboxes
        $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

        //select/deselect all rows according to table header checkbox
        $('#dynamic-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
            var th_checked = this.checked;//checkbox inside "TH" table header

            $(this).closest('table').find('tbody > tr').each(function(){
                var row = this;
                if(th_checked) tableTools_obj.fnSelect(row);
                else tableTools_obj.fnDeselect(row);
            });
        });

        //select/deselect a row when the checkbox is checked/unchecked
        $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
            var row = $(this).closest('tr').get(0);
            if(!this.checked) tableTools_obj.fnSelect(row);
            else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
        });




        $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
            e.stopImmediatePropagation();
            e.stopPropagation();
            e.preventDefault();
        });


        //And for the first simple table, which doesn't have TableTools or dataTables
        //select/deselect all rows according to table header checkbox
        var active_class = 'active';
        $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
            var th_checked = this.checked;//checkbox inside "TH" table header

            $(this).closest('table').find('tbody > tr').each(function(){
                var row = this;
                if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
            });
        });

        //select/deselect a row when the checkbox is checked/unchecked
        $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
            var $row = $(this).closest('tr');
            if(this.checked) $row.addClass(active_class);
            else $row.removeClass(active_class);
        });



        /********************************/
        //add tooltip for small view action buttons in dropdown menu
        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

        //tooltip placement on right or left
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            //var w2 = $source.width();

            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            return 'left';
        }

    })
</script>
<?php $this->load->view('global_views/footer_dashboard'); ?>
