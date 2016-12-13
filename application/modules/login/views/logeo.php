<div class="main-container">
  <div class="main-content">
    <div class="row">
      <div class="col-sm-10 col-sm-offset-1">
        <div class="login-container">
          <div class="space-12"></div>
          <div class="space-12"></div>
          <div class="center">
            <h1>
              <img src="assets\img\Logo_uniprint.png" width="40%">
              <span class="grey" id="id-text2">System v2.0</span>
            </h1>
            <!-- <h4 class="blue" id="id-company-text">&copy; Company Name</h4> -->
          </div>

          <div class="space-6"></div>

          <div class="position-relative">
            <div id="login-box" class="login-box visible widget-box no-border">
              <div class="widget-body spin_back body_principal">
                <div class="widget-main">
                  <h4 class="header blue lighter bigger center">
                    <i class="ace-icon fa fa-pencil-square-o green"></i>
                    Ingresa tus credenciales
                  </h4>

                  <div class="space-6"></div>

                  <?php echo form_open(""," id='form_login' ");?>
                    <fieldset>
                      <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                          <input type="text" class="form-control" id="correo_log" placeholder="Correo" name="usuario" />
                          <i class="ace-icon fa fa-user"></i>
                        </span>
                      </label>

                      <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                          <input type="password" class="form-control" placeholder="Contraseña" name="password" />
                          <i class="ace-icon fa fa-lock"></i>
                        </span>
                      </label>
                      
                      <div class="space"></div>

                      <div class="clearfix">
                        <div class="pull-left alert alert-danger btn-sm" id="alert_login_danger" style="display: block;">
                          <strong>
                            <i class="ace-icon fa fa-times"></i>
                            Usuario incorrecto!
                          </strong>
                        </div>
                        <div class="pull-left alert alert-success btn-sm" id="alert_login_success">
                          <strong>
                            <i class="ace-icon fa fa-check"></i>
                            CORRECTO!
                          </strong>
                        </div>
                        <div class="pull-left alert alert-warning btn-sm" id="alert_login_warning">
                          <strong>
                            <i class="ace-icon fa fa-exclamation-triangle"></i>
                            Verifique el correo...
                          </strong>
                        </div>
                        <div class="pull-left alert alert-danger btn-sm" id="alert_login_acceso">
                          <strong>
                            <i class="ace-icon fa fa-times"></i>
                            USUARIO RESTRINGIDO!
                          </strong>
                        </div>
                        <button type="button" class="width-35 pull-right btn btn-sm btn-primary" onclick="javascript:iniciar_sesion();">
                          <i class="ace-icon fa fa-sign-in"></i>
                          <span class="bigger-110">Ingresar</span>
                        </button>
                      </div>

                      <div class="space-4"></div>
                    </fieldset>
                  <?php echo form_close();?>
                </div><!-- /.widget-main -->
                <div class="toolbar clearfix">
                  <div>
                    <a href="#" onclick="return mostrar_body_recuperar();" class="forgot-password-link">
                      <i class="ace-icon fa fa-arrow-left"></i>
                      Olvidaste tu clave?
                    </a>
                  </div>
                </div>
              </div><!-- /.widget-body -->
              <div class="widget-body spin_back body_recuperar" id="body_recuperar" style="display:none;">
                <div class="widget-main">
                  <h4 class="header blue lighter bigger center">
                    <i class="ace-icon fa fa-send green"></i>
                    Recupera tu clave
                  </h4>

                  <div class="space-6"></div>

                    <fieldset>

                      <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                          <input type="textbox" class="form-control" placeholder="Correo" id="correo_recuperar" />
                          <i class="ace-icon fa fa-envelope-o"></i>
                        </span>
                      </label>
                      <div class="clearfix">
                        <button type="button" class="width-35 pull-right btn btn-sm btn-primary" onclick="javascript:recuperar_clave();">
                            <i class="ace-icon fa fa-sign-in"></i>
                            <span class="bigger-110">Recuperar</span>
                        </button>
                      </div>
                      <br/>
                      <div class="clearfix">
                          <div id="mensaje_recuperar"></div>
                      </div>
                      <div class="space"></div>

                      <div class="space-4"></div>
                    </fieldset>
                </div><!-- /.widget-main -->
                <div class="toolbar clearfix">
                  <div>
                    <a href="#" onclick="return mostrar_body_principal();" class="forgot-password-link">
                      <i class="ace-icon fa fa-arrow-left"></i>
                      Regresar
                    </a>
                  </div>
                </div>
              </div><!-- /.widget-body -->
              <div id="icon_spin_load"><i class="ace-icon fa fa-spinner fa-spin blue bigger-300"></i></div>
            </div><!-- /.login-box -->
          </div><!-- /.position-relative -->
        </div>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.main-content -->
</div><!-- /.main-container -->