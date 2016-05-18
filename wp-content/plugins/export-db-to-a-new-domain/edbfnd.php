<?php
/**
 * Plugin Name: Export DB to a new domain
 * Plugin URI: http://wordpress.org/plugins/export-db-to-a-new-domain/
 * Description: Edit and export your database in 1 step.
 * Version: 1.2
 * Author: shibi
 * Author URI: http://profiles.wordpress.org/shibi
 * License: GPLv3
 */
require_once('edbfnd-admin.php');

class edbfnd {
	private $wpdb;
	private $new_site;
	private $old_site;
	private $tables;
	
	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;
	}
	
	public function get_tables() {
		$tables = $this->wpdb->get_results( "SHOW FULL TABLES", ARRAY_N);
		$tables_status = $this->wpdb->get_results( "SHOW TABLE STATUS", ARRAY_A);
		$total = count($tables);
		for($i=0; $i<$total; $i++) {
			$t[$i] = $tables[$i];
			$t[$i][2] = $tables_status[$i]['Engine'];
			$t[$i][3] = $tables_status[$i]['Auto_increment'];
		}
		return $t;
	}
	
	public function get_cols($table) {
		$cols = $this->wpdb->get_results( "SHOW COLUMNS FROM {$table}");
		return $cols;
	}
	
	public function get_data($table) {
		$data = $this->wpdb->get_results( "SELECT * FROM  {$table}");
	}
	
	public function create_table($table) {
		$show = $this->wpdb->get_results("SHOW CREATE TABLE {$table}", ARRAY_N);
		$create = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $show[0][1]).";";
		return $create;
	}
	
	public function insert_data($table) {
		$data = $this->wpdb->get_results( "SELECT * FROM  {$table}");
		$values = '';
		$total = count($data);
		$x = 1;
		if($data) {
			foreach($data as $d) {
				$i = 1;
				$fields = "(";
				$values .= "(";
				foreach($d as $fk=>$fv) {
					$fields .= ($i == 1) ? "`{$fk}`" : ", `{$fk}`";
					$val = str_replace("'", "''", $fv); 
					$values .= ($i == 1) ? "'{$val}'" : ", '{$val}'"; 
					$i++;
				}
				$fields .= ")";
				$values .= ($x < $total) ? "),\n" : ")";
				$x++;
			}
			$sql = "INSERT INTO `{$table}` {$fields} VALUES\n{$values};";
		}else{
			$sql = "";
		}
		
		return $sql;
	}
	
	public function print_all_sql() {
		$this->old_site = get_bloginfo('url');
		$this->new_site = isset($_POST['new_site']) ? $_POST['new_site'] : '';
		if(substr($this->new_site, -1) == "/") {
			$this->new_site = substr_replace($this->new_site, '', -1);
		}
		$this->tables = $this->get_tables();
		$tables = $this->tables;
		$sql = "";
		foreach($tables as $t) {
			$sql .= $this->create_table($t[0])."\n";
			$sql .= $this->insert_data($t[0])."\n";
		}
		
		if($this->new_site !== '') {
			$sql = str_replace($this->old_site, $this->new_site, $sql);
		}
		
		return $sql;
	}
	
	public function search_in_db($val) {
		$this->tables = $this->get_tables();
		$tables = $this->tables;
		$wpdb = $this->wpdb;
		
		$output = '';
		$output .= '<table class="search-result-table">';
		$output .= '<thead>';
		$output .= '<tr>';
		$output .= '<th>'.__('Table Name').'</th>';
		$output .= '<th>'.__('Results').'</th>';
		$output .= '<th>'.__('Browse').'</th>';
		$output .= '</tr>';
		$output .= '</thead>';
		$output .= '<tbody>';
		
		foreach($tables as $t) {
			$cols = $this->get_cols($t[0]);
			//print_r($cols);
			$x = 1;
			$search_col = '';
			foreach($cols as $c) {
				$search_col .= ($x == 1) ? "{$c->Field} LIKE '%s'" : " OR {$c->Field} LIKE '%s'";
				$search_val[] = "%".$val."%";
				$x++;
			}
			$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $t[0] WHERE $search_col", $search_val));
			$count_results = count($result);
			$output .= '<tr>';
			$output .= '<td>'.$t[0].'</td>';
			$output .= '<td>'.$count_results.'</td>';
			$output .= '<td>'.(($count_results) ? '<a href="" class="browse-db-table" data-table="'.$t[0].'" data-value="'.$val.'">'.__('Browse').'</a>' : '').'</td>';
			$output .= '</tr>';
		}
		$output .= '</tbody>';
		$output .= '</table>';
		return $output;
	}
	
	public function search_in_db_table($table, $val) {
		$wpdb = $this->wpdb;

		$output = '';
		$output .= '<table class="search-result-table">';
		$output .= '<thead>';
		$output .= '<tr>';
		
		$cols = $this->get_cols($table);
		$x = 1;
		$search_col = '';
		foreach($cols as $c) {
			$search_col .= ($x == 1) ? "{$c->Field} LIKE '%s'" : " OR {$c->Field} LIKE '%s'";
			$search_val[] = "%".$val."%";
			$x++;
			
			$output .= '<th>'.$c->Field.'</th>';
		}
		
		$output .= '</tr>';
		$output .= '</thead>';
		$output .= '<tbody>';
		
		$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE $search_col", $search_val));
		if($result) {
			foreach($result as $r) {
				$output .= '<tr>';
				foreach($r as $v) {
					$output .= '<td>'.$v.'</td>';
				}
				$output .= '</tr>';
			}
		}
		$output .= '</tbody>';
		$output .= '</table>';
		
		if(!$result) {
			$output = '<div class="search-result-table">'.__('No Results').'</div>';
		}
		return $output;
	}
}

if(is_admin()) {
	function edbfnd_run() {
		if(isset($_POST['new_site'])) {
			if(check_admin_referer( 'export_db_for_new_domain' )) {
				$output = new edbfnd();
				$filename = DB_NAME.'.sql';
				header("Content-type: application/octet-stream");
				header('Content-Disposition: attachment; filename='.$filename);
				echo $output->print_all_sql();
				exit;
			}
		}
		
		if(isset($_POST['search_in_db'])) {
			if(check_ajax_referer('edbfnd_search_in_db', 'search_in_db_nonce')) {
				$output = new edbfnd();
				echo $output->search_in_db($_POST['search_in_db']);
				die();
			}
		}
		
		if(isset($_POST['search_in_db_table'])) {
			if(check_ajax_referer('edbfnd_search_in_db_table', 'search_in_db_table_nonce')) {
				$output = new edbfnd();
				echo $output->search_in_db_table($_POST['search_in_db_table'], $_POST['search_in_db_table_for']);
				die();
			}
		}
		
	}
	add_action( 'admin_init', 'edbfnd_run' );

	new edbfnd_admin();
}
?>