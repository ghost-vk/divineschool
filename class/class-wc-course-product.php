<?php
namespace LASH;

class WC_Course_Product {
	private $product_id;
	private $variation_id;
	
	/**
	 * LASH constructor.
	 * Constructs course product type if can get product object by $id
	 * @param $id {String|Integer}
	 * @return false if can't get product object by $id
	 */
	public function __construct($id) {
		if ( ! wc_get_product($id) ) {
			return false;
		}
		$this->product_id = $id;
	}
	
	
	/**
	 * Get start course date in nice format
	 * f.e "15/04 в 12:00"
	 * @return false|string
	 */
	public function get_nice_start_date_and_time() {
		$start_datetime_str = get_field('start_datetime', $this->product_id);
		$start_datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $start_datetime_str);
		$nice_start_datetime = $start_datetime->format('d/m в H:i');
		if ( $nice_start_datetime ) {
			return $nice_start_datetime;
		} else {
			return false;
		}
	}
	
	
	/**
     * Get start course date in nice format
     * f.e "15/04"
	 * @return false|string
	 */
	public function get_nice_start_date() {
		$start_datetime_str = get_field('start_datetime', $this->product_id);
		$start_datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $start_datetime_str);
		$nice_start_date = $start_datetime->format('d/m');
		if ( $nice_start_date ) {
			return $nice_start_date;
		} else {
			return false;
		}
    }
	
	
	/**
     * Set variation ID of product
	 * @param $variation_id
	 * @return false
	 */
	public function set_variation($variation_id) {
		if ( ! wc_get_product($variation_id) ) {
			return false;
		}
		$this->variation_id = $variation_id;
	}
	
	
	/**
     * Returns package index or empty string
     * f.e "package_1", "package_2" ..
	 * @returns {String}
	 */
	public function get_package_index() {
		if ( ! $this->variation_id ) {
			return '';
		}
		
		$variation = new \WC_Product_Variation($this->variation_id);
		$package_attr = $variation->attributes['pa_package'];
		if ( ! $package_attr ) {
			$package_attr = '';
		}
		
		return $package_attr;
	}
	
	
	/**
     * Returns course name or empty string
     * f.e "Только посмотреть", "Стандарт" ..
	 * @return string
	 */
	public function get_package_name() {
		if ( ! $this->variation_id ) {
			return '';
		}
		$package_attr = $this->get_package_index();
		$package_name = get_field($package_attr . '_name', $this->product_id);
		return $package_name;
	}
	
	
	/**
	 * Print list of course features
     * Features is stored in custom fields
	 */
	public function print_features( $is_email = false ) {
		if ( ! $this->variation_id ) {
			return;
		}
		$package_attr = $this->get_package_index();
		if ( have_rows($package_attr . '_description', $this->product_id) ) : ?>
            <?php
            $ul_style = ( $is_email === true ) ? 'style="margin:0; padding:0;"' : '';
            $li_style = ( $is_email === true ) ? 'style="margin:0 0 5px; list-style:disc inside; mso-special-format:bullet;"' : '';
            ?>
			<ul <?php echo $ul_style; ?>>
			<?php while ( have_rows($package_attr . '_description', $this->product_id) ) : the_row(); ?>
				<li <?php echo $li_style; ?>>
                    <?php the_sub_field('text'); ?>
                </li>
			<?php endwhile; ?>
			</ul>
		<?php
		endif;
	}
	
	
	
	
	
	/**
	 * Returns is user have access to course
     * @param $user_id {String|Integer}
     * @returns {Boolean}
	 */
	public function is_available($user_id) {
	    $available_orders = get_user_paid_orders();
	    foreach ($available_orders as $order) {
			if ( (int)$this->product_id === (int)$order['product_id'] ) {
			    return true;
			}
		}
	    return false;
	}
}