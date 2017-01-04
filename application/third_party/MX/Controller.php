<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2011 Wiredesignz
 * @version 	5.4
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @property CI_DB_active_record $db              This is the platform-independent base Active Record implementation class.
 * @property CI_DB_forge $dbforge                 Database Utility Class
 * @property CI_Benchmark $benchmark              This class enables you to mark points and calculate the time difference between them.<br />  Memory consumption can also be displayed.
 * @property CI_Calendar $calendar                This class enables the creation of calendars
 * @property CI_Cart $cart                        Shopping Cart Class
 * @property CI_Config $config                    This class contains functions that enable config files to be managed
 * @property CI_Controller $controller            This class object is the super class that every library in.<br />CodeIgniter will be assigned to.
 * @property CI_Email $email                      Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encrypt $encrypt                  Provides two-way keyed encoding using XOR Hashing and Encrypt
 * @property CI_Exceptions $exceptions            Exceptions Class
 * @property CI_Form_validation $form_validation  Form Validation Class
 * @property CI_Ftp $ftp                          FTP Class
 * @property CI_Hooks $hooks                      //dead
 * @property CI_Image_lib $image_lib              Image Manipulation class
 * @property CI_Input $input                      Pre-processes global input data for security
 * @property CI_Lang $lang                        Language Class
 * @property CI_Loader $load                      Loads views and files
 * @property CI_Log $log                          Logging Class
 * @property CI_Model $model                      CodeIgniter Model Class
 * @property CI_Output $output                    Responsible for sending final output to browser
 * @property CI_Pagination $pagination            Pagination Class
 * @property CI_Parser $parser                    Parses pseudo-variables contained in the specified template view,<br />replacing them with the data in the second param
 * @property CI_Profiler $profiler                This class enables you to display benchmark, query, and other data<br />in order to help with debugging and optimization.
 * @property CI_Router $router                    Parses URIs and determines routing
 * @property CI_Session $session                  Session Class
 * @property CI_Sha1 $sha1                        Provides 160 bit hashing using The Secure Hash Algorithm
 * @property CI_Table $table                      HTML table generation<br />Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback $trackback              Trackback Sending/Receiving Class
 * @property CI_Typography $typography            Typography Class
 * @property CI_Unit_test $unit_test              Simple testing class
 * @property CI_Upload $upload                    File Uploading Class
 * @property CI_URI $uri                          Parses URIs and determines routing
 * @property CI_User_agent $user_agent            Identifies the platform, browser, robot, or mobile devise of the browsing agent
 * @property CI_Xmlrpc $xmlrpc                    XML-RPC request handler class
 * @property CI_Xmlrpcs $xmlrpcs                  XML-RPC server class
 * @property CI_Zip $zip                          Zip Compression Class
 * @property CI_Javascript $javascript            Javascript Class
 * @property CI_Jquery $jquery                    Jquery Class
 * @property CI_Utf8 $utf8                        Provides support for UTF-8 environments
 * @property CI_Security $security                Security Class, xss, csrf, etc...
 * @property CI_Driver_Library $driver            CodeIgniter Driver Library Class
 * @property CI_Cache $cache                      CodeIgniter Caching Class
 * @method   static CI_Controller get_instance()  CodeIgniter CI_Controller instance class
 * @property Crud_model $CRUD                     Load models of CRUD for All
 * @property global_model $setting_Global         Load models of global_model and functions generic
 *
 **/
class MX_Controller 
{
	public $autoload = array();

    /**

     * -------------------------------------------------------------------------------
     * **Model constants and DataBase property**
     * -------------------------------------------------------------------------------
     * @var string $schema->module                Nombre del 'menTitulo' - Titulo del modulo al que pertenece el menu Ej: 'MODULO 1'
     * @var string $schema->view                  Pagina que debe cargar el << $this->load->view($view) >>
     * @var string $schema->tabla                 Nombre de la Tabla principal que gestiona el <models> de este <controllers>
     * @var string $schema->table_detail          [Optional] Nombre de tabla complementaria generalmente <<tabla_detalle>>
     * @var string $schema->primary_key           Nombre del campo << Primary_Key >> de la tabla principal del <models>
     * @var string $schema->secundary_key         [Optional] Nombre del campo secundario generalmente <<cod_key>>
     * @var array  $schema->options               Carga array con multiples opciones
     * @var array  $schema->where                 Carga array con Opciones de busquedas para *Query* con *Where*
     * -------------------------------------------------------------------------------
     * **Load external Models**
     * -------------------------------------------------------------------------------
     * @var object $setting_Global
     * @var string $setting_Users
     * @var object $CRUD
     * @var array $schema
     * @var string $CodUser
     *
     **/

    //----------------
    private $CodUser;
    public $setting_Global;
    public $setting_Users;
    public $CRUD;
    public $auditoria = array();
    public $schema = array(
        'module'  => '',
        'view'    => '',
        'entity'  => '',
        'table'   => '',
        'detail'  => '',
        'pri_key' => '',
        'sec_key' => '',
        'options' => array(),
        'where'   => array()
    );



	public function __construct(){

        $this->CRUD                     = $this->load->model('global_views/crud_model');
        $this->setting_Global           = $this->load->model('global_views/global_model');
        $this->setting_Users            = $this->session;
        $this->auditoria['log_date']    = $this->setting_Global->fecha();
        $this->auditoria['log_user']    = $this->setting_Users->userdata('nombre_usuario');

        $class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	
		
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->_init($this);	
		
		/* autoload module items */
		$this->load->_autoloader($this->autoload);

	}

	public function __get($class) {
		return CI::$APP->$class;
	}


    /**
     * __index
     *
     * Usa los parametros de cada controlador para cargar el <<load->view>>
     * y las preferencias de cada pagina.
     *
     * @param $module
     * @param $url
     * @param $items
     * @return void
     */
    public function __index($module, $url, $items)
    {
        $this->CodUser = $this->encrypt->decode($this->setting_Users->userdata('codigo_usuario'));
        if (tiene_logeo()) {
            $query = $this->setting_Global->getCMenu_ByIdUser($this->CodUser);
            if ($query) {
                $menuValue = array();
                foreach ($query as $key) {
                    $menuValue[] = $key->MenTitulo;
                }
                if (in_array($module, $menuValue)) {
                    $this->load->view($url, $items);
                } else {
                    $this->load->view('global_views/acceso_restringido');
                }
            } else {
                $this->load->view('global_views/404');
            }
        } else {
            redirect(base_url());
        }
    }

}