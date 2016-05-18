<?php
class edbfnd_admin {
	
	private $tables;
	
	public function __construct() {
		add_action( 'admin_init', array( $this, 'edbfnd_admin_init' ) );
		add_action( 'admin_menu', array( $this, 'add_edbfnd_page' ) );
		$edbfnd = new edbfnd();
		$this->tables = $edbfnd->get_tables();
	}
	
	public function edbfnd_admin_init() {
		wp_register_script( 'edbfnd-js', plugins_url( 'js/script.js', __FILE__ ) );
		wp_register_style( 'edbfnd-css', plugins_url( 'css/style.css', __FILE__ ) );
	}
	
	public function add_edbfnd_page() {
	
		$page_hook_suffix = add_submenu_page( 
			'tools.php',
			'Export DB to a new domain',
			'Export DB to a new domain',
			'manage_options',
			'edbfnd',
			array($this, 'edbfnd_admin')
		);

		add_action('admin_print_scripts-' . $page_hook_suffix, array($this, 'edbfnd_js'));
		add_action('admin_print_styles-' . $page_hook_suffix, array($this, 'edbfnd_css'));
	}
	
	public function edbfnd_js() {
	    wp_enqueue_script( 'edbfnd-js' );
	}
	
	public function edbfnd_css() {
	    wp_enqueue_style( 'edbfnd-css' );
	}
	
	public function edbfnd_admin() {
		$search_in_db_nonce = wp_create_nonce( 'edbfnd_search_in_db' );
		$search_in_db_table_nonce = wp_create_nonce( 'edbfnd_search_in_db_table' );
		?>
		<div class="wrap edbfnd">
			<h2>Export DB to a new domain</h2>
			<div class="postbox">
				<h3>Export the database</h3>
				<p>Insert the New Domain that you want to import your database</p>
				<p>If the New Domain field stay empty its will backup your current database</p>
				<form action="" method="post" id="edbfnd-form">
					<?php wp_nonce_field( 'export_db_for_new_domain' ); ?>
					<div class="inp-box">
						<label>Old Domain</label>
						<input type="text" value="<?php bloginfo('url'); ?>" disabled="disabled" />
					</div>
					<div class="inp-box">
						<label for="new_site">New Domain</label>
						<input type="text" name="new_site" />
					</div>
					<div class="clear"></div>
					<input type="submit" class="button button-primary" value="<?php _e('Download Export File'); ?>" />
				</form>
			</div>
			<div class="clear"></div>
			<div class="postbox">
				<h3>Search in the database</h3>
				<p>This tool let you to search in your in entire database</p>
				<form action="" method="post" id="edbfnd-search-in-db-form" data-nonce="<?php echo $search_in_db_nonce; ?>">
					<div class="inp-box">
						<label>Search for</label>
						<input type="text" name="search_in_db" />
					</div>
					<div class="clear"></div>
					<input type="submit" class="button button-primary" value="<?php _e('Search'); ?>" />
				</form>
				<div class="search-results"></div>
			</div>
			<div class="clear"></div>
			<div class="postbox">
				<h3>Search in the database table</h3>
				<p>This tool let you to search in your in a database table</p>
				<form action="" method="post" id="edbfnd-search-in-db-table-form" data-nonce="<?php echo $search_in_db_table_nonce; ?>">
					<div class="inp-box">
						<label>Table</label>
						<select type="text" name="search_in_db_table">
							<?php foreach($this->tables as $t) { ?>
							<option value="<?php echo $t[0]; ?>"><?php echo $t[0]; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="inp-box">
						<label>Search for</label>
						<input type="text" name="search_in_db_table_for" />
					</div>
					<div class="clear"></div>
					<input type="submit" class="button button-primary" value="<?php _e('Search'); ?>" />
				</form>
				<div class="search-results"></div>
			</div>
		</div>
		<?php
	}
}
?>