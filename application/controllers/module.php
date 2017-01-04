<?php
class module extends MY_Controller
{
    private $_tbl_relationship = array();
    private $_tbl_prefix       = 'tbl_';
    private $_tbl_name;
    private $_tbl_key;
    private $_tbl_relation_name;
    private $_tbl_relation_key;
    private $_relation;
    private $_module;
    private $_relation_context;

    public function __construct()
    {
        parent::__construct();

        $this->input->is_cli_request() or exit("Execute via command line: php index.php migrate");
        include APPPATH . 'config/database.php';
        $this->load->library('cli');
        $this->load->helper('file');
    }

    //php index.php module
    public function index()
    {
        $this->cli->write('Hello! Welcome to Razul Cli');
        $this->cli->write('To create new module run :');
        $this->cli->write('');
        $this->cli->write('------------------------------');
        $this->cli->write('> php index.php module create');
        $this->cli->write('------------------------------');
    }

    //php index.php module cli_test
    public function cli_test()
    {
        $this->cli->write('Hello World!');
        $this->cli->prompt();
        $color = $this->cli->prompt('What is your favorite color?');
        $color = $this->cli->prompt('What is your favorite color?', 'white');
        $ready = $this->cli->prompt('Are you ready?', array('y', 'n'));
        $this->cli->write('Loading...');
        $this->cli->wait(5, true);
    }

    public function test()
    {
        echo "Choose TABLE :" . PHP_EOL;
        echo PHP_EOL;
        $arrayName = array('a' => "adas", 'b' => 'sdfasfsf');
        $this->load->dbutil();
        echo '<pre>';
        var_dump($this->dbutil->list_databases());
        var_dump($this->db->list_fields('tbl_user'));
        var_dump($this->db->query('SHOW TABLES')->result_array());
    }

    public function get_all_table()
    {
        $db     = $this->db->database;
        $tables = $this->db->query('SHOW TABLES')->result();

        $data      = array();
        $tbl_index = 'Tables_in_' . $db;
        foreach ($tables as $table) {
            $data[] = $table->{$tbl_index};
        }
        return $data;
    }

    public function mkdir($path = "uploads")
    {
        if (is_array($path)) {
            foreach ($path as $item) {
                if (!is_dir($item)) {
                    mkdir($item, 0755, true);
                    echo PHP_EOL;
                    echo 'CREATED FOLDER : ' . $item;
                } else {
                    echo PHP_EOL;
                    echo 'EXIST FOLDER : ' . $item;
                }
            }
        } else {
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
                echo PHP_EOL;
                echo 'CREATED FOLDER : ' . $item;
            } else {
                echo PHP_EOL;
                echo 'EXIST FOLDER : ' . $path;
            }
        }

    }

    public function read_file($file_name = 'index.php', $path = null)
    {
        $file = "";
        if ($path) {
            $file .= $path . DIRECTORY_SEPARATOR;
        }
        $file .= $file_name;
        $string = read_file($file);
        return $string;
    }

    public function write_file($file_name = 'test.html', $data = null)
    {
        if (is_array($file_name)) {
            foreach ($file_name as $file):
                if (!file_exists($file)):
                    if (!write_file($file, $data)):
                        echo PHP_EOL;
                        echo 'ERROR FILE : ' . $file;
                    else:
                        echo PHP_EOL;
                        echo 'CREATED FILE : ' . $file;
                    endif;
                else:
                    echo PHP_EOL;
                    echo 'EXIST FILE : ' . $file;
                endif;
            endforeach;
        } else {
            //if(!file_exists($file_name)):
            if (!write_file($file_name, $data)):
                echo PHP_EOL;
                echo 'ERROR FILE : ' . $file_name;
            else:
                echo PHP_EOL;
                echo 'UPDATED FILE : ' . $file_name;
            endif;
            //else:
            //echo PHP_EOL;
            //echo 'EXIST FILE : '.$file_name;
            //endif;
        }
    }

    public function has_relation()
    {
        echo PHP_EOL;
        echo 'Choose TABLE RELATION :';
        echo PHP_EOL;
        echo '--------------------------------';
        echo PHP_EOL;
        echo '1. belongs_to()';
        echo PHP_EOL;
        echo '2. many_to_many()';
        echo PHP_EOL;
        echo '3. none';
        echo PHP_EOL;
        echo '--------------------------------';
        echo PHP_EOL;
        $retation = $color = $this->cli->prompt('', array(1, 2, 3));
        echo PHP_EOL;
        echo PHP_EOL;
        echo "RELATION TABLE LIST :" . PHP_EOL;
        echo '--------------------------------';
        echo PHP_EOL;
        $tables = $this->get_all_table();
        if ($retation != 3) {
            $tbl_relation_no = array();
            foreach ($tables as $key => $table) {
                if ($this->_tbl_name != $table) {
                    echo $key + 1 . '. ';
                    echo $table;
                    echo PHP_EOL;
                }
                $tbl_relation_no[] = $key + 1;
            }
            unset($tbl_relation_no[$this->_tbl_key - 1]);
            echo '--------------------------------';
            echo PHP_EOL;

            echo PHP_EOL;
            echo "ENTER TABLE No. :";
            echo PHP_EOL;
            echo '--------------------------------';
            echo PHP_EOL;

            $tbl_relation      = $this->cli->prompt("", $tbl_relation_no);
            $tbl_relation_name = $this->get_all_table()[$tbl_relation - 1];
            echo PHP_EOL;

            if ($retation == 1) {
                echo '"' . $this->_tbl_name . '" is "belongs_to()" "' . $tbl_relation_name . '"';
                echo PHP_EOL;
                echo '--------------------------------';
                echo PHP_EOL;
                $tbl_relation_prefix_free = str_replace($this->_tbl_prefix, "", $tbl_relation_name);
                $tbl_relation_prefix_arr  = explode('_', $tbl_relation_prefix_free);
                $tbl_relation_model       = $tbl_relation_prefix_arr[0];
                $tbl_relation_name        = $tbl_relation_prefix_arr[0];
                if (count($tbl_relation_prefix_arr) > 1) {
                    $tbl_relation_name            = $tbl_relation_prefix_arr[1];
                    $tbl_relation_prefix_free_str = '';
                    foreach ($tbl_relation_prefix_arr as $prefix_relation_key => $tbl_relation_prefix_free_item) {
                        if ($prefix_relation_key != 0) {
                            $tbl_relation_prefix_free_str .= $tbl_relation_prefix_free_item . '_';
                        }

                    }
                    $tbl_relation_model = rtrim($tbl_relation_prefix_free_str, '_');
                }
                if ($this->_module == $tbl_relation_prefix_arr[0]) {
                    $tbl_relation_model = $tbl_relation_prefix_arr[0] . '_' . $tbl_relation_model . '_model';
                } else {
                    $tbl_relation_model = $tbl_relation_prefix_arr[0] . '/' . $tbl_relation_model . '_model';
                }
                $this->_tbl_relationship['belongs_to'] = array(
                    'name'  => lcfirst($tbl_relation_name),
                    'model' => $tbl_relation_model,
                );
            } else {
                if ($retation == 2) {
                    echo '"' . $this->_tbl_name . '" has "many_to_many()" relation with "' . $tbl_relation_name . '"';
                }

                echo PHP_EOL;
                echo '--------------------------------';
                echo PHP_EOL;
                $tbl_relation_prefix_free = str_replace($this->_tbl_prefix, "", $tbl_relation_name);
                $tbl_relation_prefix_arr  = explode('_', $tbl_relation_prefix_free);
                $tbl_relation_model       = $tbl_relation_prefix_arr[0];
                $tbl_relation_name        = $tbl_relation_prefix_arr[0];
                if (count($tbl_relation_prefix_arr) > 1) {
                    $tbl_relation_name            = $tbl_relation_prefix_arr[1];
                    $tbl_relation_prefix_free_str = '';
                    foreach ($tbl_relation_prefix_arr as $prefix_relation_key => $tbl_relation_prefix_free_item) {
                        if ($prefix_relation_key != 0) {
                            $tbl_relation_prefix_free_str .= $tbl_relation_prefix_free_item . '_';
                        }

                    }
                    $tbl_relation_model = rtrim($tbl_relation_prefix_free_str, '_');
                }
                if ($this->_module == $tbl_relation_prefix_arr[0]) {
                    $tbl_relation_model = $tbl_relation_prefix_arr[0] . '_' . $tbl_relation_model . '_model';
                } else {
                    $tbl_relation_model = $tbl_relation_prefix_arr[0] . '/' . $tbl_relation_model . '_model';
                }
                $this->_tbl_relationship['has_many'] = array(
                    'name'  => lcfirst($tbl_relation_name),
                    'model' => $tbl_relation_model,
                );
            }
            echo PHP_EOL;
            $add_retaion = $this->cli->prompt('Is there any other relation : ', array('y', 'n'));
            echo PHP_EOL;
            echo '--------------------------------';
            echo PHP_EOL;
            if ($add_retaion == 'y') {
                $this->has_relation();
            }
        }
    }

    public function create()
    {
        echo PHP_EOL;
        echo "TABLE LIST :" . PHP_EOL;
        echo '--------------------------------';
        echo PHP_EOL;

        $tbl_no = array();
        foreach ($this->get_all_table() as $key => $table) {
            echo $key + 1 . '. ';
            echo $table;
            echo PHP_EOL;
            $tbl_no[] = $key + 1;
        }

        echo '--------------------------------';
        echo PHP_EOL;

        echo PHP_EOL;
        echo "ENTER TABLE No. :";
        echo PHP_EOL;
        echo '--------------------------------';
        echo PHP_EOL;

        $this->_tbl_key  = $this->cli->prompt("", $tbl_no);
        $this->_tbl_name = $this->get_all_table()[$this->_tbl_key - 1];
        echo PHP_EOL;
        echo '"' . $this->_tbl_name . '" SELECTED';

        echo PHP_EOL;
        echo '--------------------------------';
        echo PHP_EOL;

        echo PHP_EOL;
        echo 'ENTER TABLE PREFIX : [Default: "tbl_"]';
        echo PHP_EOL;
        echo '--------------------------------';
        echo PHP_EOL;
        $this->_tbl_prefix = $color = $this->cli->prompt('', 'tbl_');

        echo '"' . $this->_tbl_prefix . '" SELECTED';
        echo PHP_EOL;
        echo '--------------------------------';
        echo PHP_EOL;

        $prefix_free         = str_replace($this->_tbl_prefix, "", $this->_tbl_name);
        $tbl_prefix_free_arr = explode('_', $prefix_free);
        $this->_module       = $tbl_prefix_free       = $tbl_prefix_free_arr[0];
        $tbl_prefix_free_str = '';
        if (count($tbl_prefix_free_arr) > 1) {
            $tbl_prefix_free_str = '';
            foreach ($tbl_prefix_free_arr as $prefix_key => $tbl_prefix_free_item) {
                if ($prefix_key != 0) {
                    $tbl_prefix_free_str .= $tbl_prefix_free_item . '_';
                }

            }
            $tbl_prefix_free = rtrim($tbl_prefix_free_str, '_');
        }

        $path       = APPPATH . 'modules' . DIRECTORY_SEPARATOR . ucfirst($tbl_prefix_free_arr[0]);
        $module     = ucfirst($tbl_prefix_free);
        $controller = ucfirst($module . '.php');
        $model      = ucfirst($module . '_model.php');

        $view_index   = 'index.php';
        $view_details = 'details.php';
        $view_success = 'success.php';
        $view_add     = 'add.php';
        $view_update  = 'update.php';

        echo PHP_EOL;
        echo "Path     : " . $path . PHP_EOL;
        echo "Module   : " . $module . PHP_EOL;
        echo "Controle : " . $controller . PHP_EOL;
        echo "Model    : " . $model . PHP_EOL;
        echo "View     : " . $view_index . PHP_EOL;
        echo "         : " . $view_details . PHP_EOL;
        echo "         : " . $view_success . PHP_EOL;
        echo "         : " . $view_add . PHP_EOL;
        echo "         : " . $view_update . PHP_EOL;

        echo PHP_EOL;
        echo '--------------------------------';
        echo PHP_EOL;

        echo PHP_EOL;
        $ready = $this->cli->prompt('ENTER "y" if everything is ok : ', array('y', 'n'));

        echo PHP_EOL;
        echo '--------------------------------';
        echo PHP_EOL;

        if ($ready != 'y') {
            echo PHP_EOL;
            $this->cli->write('Loading...');
            echo 'Thank you';

            echo PHP_EOL;
            echo '--------------------------------';
            echo PHP_EOL;
        } else {

            $this->has_relation();

            echo PHP_EOL;
            $this->cli->write('Loading...');
            echo PHP_EOL;
            $this->cli->wait(5, true);
            echo PHP_EOL;

            $folders = array(
                $path,
                $path . DIRECTORY_SEPARATOR . 'Config',
                $path . DIRECTORY_SEPARATOR . 'Controllers',
                $path . DIRECTORY_SEPARATOR . 'Models',
                $path . DIRECTORY_SEPARATOR . 'Views',
            );
            $this->mkdir($folders);
            echo PHP_EOL;

            $files = array(
                $path . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $controller,
                $path . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . $model,

                $path . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $module . '_' . $view_index,
                $path . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $module . '_' . $view_add,
                $path . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $module . '_' . $view_success,
                $path . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $module . '_' . $view_update,
                $path . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $module . '_' . $view_details,
            );
            $this->write_file($files);
            echo PHP_EOL;

            $this->write_file($files[0], $this->content('controller', lcfirst($module)));
            $this->write_file($files[1], $this->content('model', lcfirst($module), $this->_tbl_name));

            $this->write_file($files[2], $this->content('view_index', lcfirst($module)));
            $this->write_file($files[3], $this->content('view_add', lcfirst($module)));
            $this->write_file($files[4], $this->content('view_success', lcfirst($module)));
            $this->write_file($files[5], $this->content('view_update', lcfirst($module)));
            $this->write_file($files[6], $this->content('view_details', lcfirst($module)));

            echo PHP_EOL;
            echo '--------------------------------';
            echo PHP_EOL;

            echo PHP_EOL;
            echo 'Module successfully generated !!';
            echo PHP_EOL;
            echo '--------------------------------';
            echo PHP_EOL;
        }

    }

    public function belongs_to_content($module_name)
    {
        $context = '
    //relation
    public $belongs_to = array(
      "contact" => array(
        "model" => "User_contact_model",
        "primary_key" => "id"
      ), //->with("contact")
    );';
        return $context;
    }

    public function relationship()
    {
        $relations = $this->_tbl_relationship;
        $context   = '
    //relation';
        if (!empty($relations)) {
            $belongs_to_content = '
    public $belongs_to = array(';
            $has_many_content = '
    public $has_many = array(';

            foreach ($relations as $key => $relation) {
                if (is_string($key) && $key == 'belongs_to') {

                    $belongs_to_content .= '
    "' . $relation["name"] . '" => array(
        "model" => "' . $relation["model"] . '",
        "primary_key" => "id"
      ), //->with("' . $relation["name"] . '")';
                } else if (is_string($key) && $key == 'has_many') {
                    $has_many_content .= '
    "' . $relation['name'] . '" => array(
        "model" => "' . $relation["model"] . '",
        "primary_key" => "id"
      ), //->with("' . $relation["name"] . '")';
                }
            }
            $belongs_to_content .= '
    );';
            $has_many_content .= '
    );';
            $context = '
    ' . $belongs_to_content . '
    ' . $has_many_content . '';
        }
        return $context;
    }

    public function content($action, $module_name, $tbl_name = null, $relations = array())
    {

        if ($action == 'controller'):
            $controller = $this->read_file('controller.php', $path = APPPATH . 'cli_content/controller');
            return str_replace('{module_name}', $module_name, $controller);
        endif;

        if ($action == 'model'):
            if ($tbl_name == '') {
                $tbl_name = $module_name;
            }

            $model = $this->read_file('model.php', $path = APPPATH . 'cli_content/model');
            $str   = str_replace('{module_name}', $module_name, $model);
            $str   = str_replace('{tbl_name}', $tbl_name, $str);
            $str   = str_replace('//relation', $this->relationship(), $str);
            return $str;
        endif;

        if ($action == 'view_index'):
            $model = $this->read_file('index.php', $path = APPPATH . 'cli_content/view');
            return str_replace('{module_name}', $module_name, $model);
        endif;

        if ($action == 'view_add'):
            $model = $this->read_file('add.php', $path = APPPATH . 'cli_content/view');
            return str_replace('{module_name}', $module_name, $model);
        endif;

        if ($action == 'view_success'):
            $model = $this->read_file('success.php', $path = APPPATH . 'cli_content/view');
            return str_replace('{module_name}', $module_name, $model);
        endif;

        if ($action == 'view_update'):
            $model = $this->read_file('update.php', $path = APPPATH . 'cli_content/view');
            return str_replace('{module_name}', $module_name, $model);
        endif;

        if ($action == 'view_details'):
            $model = $this->read_file('details.php', $path = APPPATH . 'cli_content/view');
            return str_replace('{module_name}', $module_name, $model);
        endif;
    }
}
