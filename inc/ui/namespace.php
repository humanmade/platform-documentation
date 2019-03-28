<?php

namespace HM\Platform\Documentation\UI;

use HM\Platform\Documentation;
use HM\Platform\Documentation\Page;

const LOGO = <<<END
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 547.56 320.92001" height="14.06" width="24">
	<defs>
		<clipPath id="a"><path d="M0 2406.94V0h4106.71v2406.94z"/></clipPath>
	</defs>
	<g clip-path="url(#a)" transform="matrix(.13333 0 0 -.13333 0 320.92)">
		<path className="hm-logo-path" d="M399.133 272.191c-77.379 0-133.321 68.457-133.321 208.329 0 236.82 193.567 438.269 399.286 553.95-13.536-146.482-33.903-304.072-48.305-400.892-26.637-179.039-89.684-361.387-217.66-361.387zM4043.11 673.539c-45.31-25.68-93.5-41.5-143.94-41.5-114.67 0-180.79 57.723-208.23 151.09-55.66 189.371-3.75 532.581 15.39 757.111 25.88 303.7 38.23 422.92 43.17 486.45 11.58 148.25-46.35 313.24-214.98 312.08-156.74-1.09-361.16-189.03-451.47-378.17 22.01 242.25-47.85 447.62-232.36 446.33-184.51-1.26-373.5-275.42-431.17-393.38 11.68 110.21 18.04 156.43 23.08 215.99 5.02 59.56 3.01 102.64-59.26 108.73-37.75 3.7-111.42-9.32-153.98-16.55-54.51-9.27-72.19-48.17-82.25-132.52-7.24-60.9-26.28-302.26-45.11-534.81-42.76-3.43-112.77-16.97-154.67-22.81-78.71-10.97-129-19.66-205.93-33.34 25.97 271.86 64.04 562.01 77.18 668.41 7.95 64.36 1.8 104.76-64.88 112.68-37.89 4.49-152.66-11.97-188.36-17.83-58.73-9.63-81.1-59.68-88.54-98.7-30.08-157.71-58.72-442.92-77.96-731.99-125.97-30.83-250.6-66.36-374.78-107.33 12.36 224.59 20.49 475.12 12.76 598.7-11.14 178.23-113.093 295.23-269.84 295.23-166.992 0-359.718-89.76-480.652-191.95-79.078-66.81-123.558-144.16-123.558-205.37 0-62.49 31.296-119.08 113.953-119.08 63.957 87.44 231.336 240.85 324.804 240.85 84.102 0 105.563-73 105.563-147.41 0-61.2-12.348-343.84-24.32-582.72C362.012 1168.4 0 895.09 0 467.52 0 190.73 168.969 9.07 411.109 9.07c316.782 0 482.852 286.942 534.715 600.59 26.563 160.711 46.969 369.231 60.886 549.67 1.43.48 2.88.98 4.33 1.46 123.1 40.88 247.46 78.78 372.92 112.55-18.97-362.481-28.78-690.981 68.3-929.121 82.01-201.18 256-346.25 528.7-344.2 187.5 1.403 362.25 76.7 440.51 147.559 26.09 23.621 36.89 56.293 36.03 78.594-1.77 46.09-30.99 83.668-69.7 109.019-77.52-44.089-163.44-81.25-285.35-85.921-121.93-4.668-287.58 61.832-355.64 284.582-58.73 192.128-41.64 570.618-25.61 813.798 118.2 23.4 237.29 46.97 357.14 59.93l3.75 5.72c-1.5-17.65-2.96-34.72-4.39-51.04-23.57-270.02-54.71-688.94-53.42-772.26 1-63.488 33.15-89.078 80.76-88.738 47.62.316 132.68 16.859 162.29 26.988 24.28 8.32 43.67 19.379 56.91 40.082 11.94 18.707 18.26 46.727 20.51 83.477 6.08 99.281 22.42 343.441 37.85 498.311 15.45 154.88 30.76 289.72 58.69 409.19 56.25 240.57 171.74 501.21 276.9 501.94 67.46.46 69.65-126.57 50.56-301.32-19.1-174.76-70.62-814.071-69.43-891.442 1.06-67.457 20.98-103.047 78.99-102.636 47.61.32 137.55 7.089 173.06 21.238 22.35 8.89 38.93 17.148 50.37 37.129 10.06 17.582 16.14 44.222 18.62 88.34 5.68 101.471 42.56 511.011 74.8 640.461 61.51 246.86 190.2 411.94 261.62 412.43 71.43.49 49.2-175.27 30.51-375.85-36.11-387.21-72.97-791.209 23.96-988.791 57.33-116.879 160.53-226.571 405.28-226.571 91.7 0 197.22 36.883 253.65 92.391 25.53 25.121 37.54 69.051 36.47 92.152-2.17 47.731-24.22 88.481-63.54 114.758" fill="#fff"/>
	</g>
</svg>
END;

function bootstrap() {
	add_action( 'admin_menu', __NAMESPACE__ . '\\register_menu' );
}

function register_menu() {
	$hook = add_menu_page(
		'Human Made Platform',
		'Platform',
		'edit_posts',
		'hm-platform',
		__NAMESPACE__ . '\\render_page',
		'data:image/svg+xml;base64,' . base64_encode( LOGO ),
		2
	);

	add_action( sprintf( 'load-%s', $hook ), __NAMESPACE__ . '\\load_page' );
}

function load_page() {
	wp_enqueue_style( __NAMESPACE__, plugins_url( '/assets/style.css', Documentation\DIRECTORY . '/wp-is-dumb' ) );
}

function render_page() {
	$documentation = Documentation\get_documentation();
	$current_group = $_GET['group'] ?? 'guides';
	$id = $_GET['id'] ?? '';
	$current_page = $documentation[ $current_group ]->get_page( $id );
	?>

	<div class="hm-platform-ui wrap">
		<header>
			HM Platform
		</header>

		<div class="hm-platform-ui__main">
			<nav>
				<ul>
					<?php foreach ( $documentation as $group => $gobj ) : ?>
						<li
							class="<?php echo $group === $current_group ? 'current' : '' ?>"
						>
							<a
								href="<?php echo add_query_arg( [ 'group' => $group, 'id' => '' ] ) ?>"
							>
								<?php echo esc_html( $gobj->get_title() ) ?>
							</a>

							<ul>
								<?php
								foreach ( $gobj->get_pages() as $id => $page ) :
									if ( $id === '' ) {
										continue;
									}
									?>
									<li>
										<a href="<?php echo add_query_arg( compact( 'group', 'id' ) ) ?>">
											<?php echo esc_html( $page->get_meta( 'title' ) ) ?>
										</a>
									</li>
									<?php render_page_subpages( $page, $group ) ?>
								<?php endforeach ?>
							</ul>
						</li>
					<?php endforeach ?>
				</ul>
			</nav>

			<article>
				<?php echo render_content( $current_page ) ?>
			</article>

			<aside>
				<input
					placeholder="Future search field…"
					type="search"
				/>
			</aside>
		</div>
	</div>

	<?php
}

/**
 * Output the menu for a page's subp ages.
 *
 * This recurses all subpages.
 *
 * @param Page $page
 * @param string $group
 */
function render_page_subpages( Page $page, string $group ) {
	if ( ! $page->get_subpages() ) {
		return;
	}
	?>
	<ul>
		<?php
		foreach ( $page->get_subpages() as $subpage_id => $subpage ) :
			$permalink = add_query_arg( [
				'group' => $group,
				'id' => $subpage_id,
			] );
			?>
		<li>
			<a href="<?php echo esc_url( $permalink ) ?>">
				<?php echo esc_html( $subpage->get_meta( 'title' ) ) ?>
			</a>
			<?php render_page_subpages( $subpage, $group ) ?>
		</li>
		<?php endforeach ?>
	</ul>
	<?php
}

function render_content( ?Page $page ) {
	if ( empty( $page ) ) {
		return '404: Unable to find page.';
	}

	return Documentation\render_page( $page );
}
