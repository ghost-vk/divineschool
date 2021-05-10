<?php global $package_names; ?>
<!--   MODULES COMPARING   -->
<div class="packagesComparing">
	<div class="container-1">
		<h2 class="my-5 text-primary" id="packages">
			Сравнение<br />пакетов
		</h2>
		<div class="table-responsive">
			<table class="table text-center">
				<thead>
				<tr>
					<th style="width: 55%;"></th>
					<?php foreach ($package_names as $name) : ?>
						<th style="width: 15%; padding: .2rem"><span class="fw-light packagesComparing__name"><?= $name; ?></span></th>
					<?php endforeach; ?>
				</tr>
				</thead>
				<tbody>
				<?php if ( have_rows('comparing_table_repeater') ) : ?>
					<?php while ( have_rows('comparing_table_repeater') ) : the_row(); ?>
						<tr>
							<th scope="row" class="text-start px-0"><span class="fw-light"><?php the_sub_field('measure'); ?></span></th>
							<?php for ( $i = 1; $i < 4; $i += 1) : ?>
								<?php if ( get_sub_field("is_package_$i") === true ) : ?>
									<td><i class="fas fa-check text-secondary"></i></td>
								<?php else : ?>
									<td></td>
								<?php endif; ?>
							<?php endfor; ?>
						</tr>
					<?php endwhile; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>