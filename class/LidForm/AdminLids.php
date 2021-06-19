<?php
namespace Ghost\LidForm;
require_once __DIR__ . '/LidFormData.php';

class AdminLids {
	/**
	 * Method display lids in admin panel
	 */
	public function ShowLids() {
		if ( ! is_admin() ) { // Only for admin panel
			return;
		}
		add_action( 'admin_menu', array($this, 'RegisterPage') );
	}
	
	public function RegisterPage() {
		add_menu_page(
			'Лиды', 'Лиды', 'manage_options', 'lids', array($this, 'ShowContent'), 'dashicons-money', 6
		);
	}
	
	/**
	 * Method render content in lids page
	 */
	public function ShowContent() {
		require_once __DIR__ . '/LidFormData.php';
		$dal = new LidFormData();
		$lids = $dal->GetLids();
		$lids = ( ! empty($lids) ) ? array_reverse($lids, true) : [];
		?>
		<div class="wrap">
			<h1 class="test-center">Лиды</h1>
			<table class="wp-list-table widefat fixed striped table-view-list users" style="margin-top: 15px">
				<thead>
				<tr>
					<td class="manage-column column-cb check-column">
					</td>
					<th scope="col" class="manage-column column-username column-primary sortable desc">
						ФИО
					</th>
					<th scope="col" class="manage-column column-name">
						Номер телефона
					</th>
					<th scope="col" class="manage-column column-email sortable desc">
						Email
					</th>
					<th scope="col" class="manage-column column-role">
						Инстаграм
					</th>
					<th scope="col" class="manage-column column-posts num">
					</th>
				</tr>
				</thead>
				<tbody>
				<?php
				if ( ! empty($lids) ) :
					foreach ($lids as $key => $lid) :
						?>
						<tr>
							<th scope="row" class="check-column">
							</th>
							<th scope="col" class="manage-column column-username column-primary sortable desc">
								<?php echo $lid->name; ?>
							</th>
							<th scope="col" class="manage-column column-name">
								<?php echo $lid->phone; ?>
							</th>
							<th scope="col" class="manage-column column-email sortable desc">
								<?php echo $lid->email; ?>
							</th>
							<th scope="col" class="manage-column column-role">
								<?php echo $lid->instagram; ?>
							</th>
							<th scope="col" class="manage-column column-posts num">
								<?php echo $key + 1; ?>
							</th>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<h3>Нет лидов</h3>
				<?php endif; ?>
			</table>
		</div>
		<?php
	}
}