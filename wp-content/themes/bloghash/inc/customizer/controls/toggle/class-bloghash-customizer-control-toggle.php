<?php
/**
 * Bloghash Customizer custom toggle control class.
 *
 * @package     Bloghash
 * @author      Peregrine Themes
 * @since       1.0.0
 */

/**
 * Do not allow direct script access.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Bloghash_Customizer_Control_Toggle' ) ) :
	/**
	 * Bloghash Customizer custom toggle control class.
	 */
	class Bloghash_Customizer_Control_Toggle extends Bloghash_Customizer_Control {

		/**
		 * The control type.
		 *
		 * @var string
		 */
		public $type = 'bloghash-toggle';

		/**
		 * An Underscore (JS) template for this control's content (but not its container).
		 *
		 * Class variables for this control class are available in the `data` JS object;
		 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
		 *
		 * @see WP_Customize_Control::print_template()
		 */
		protected function content_template() {
			?>
			<div class="bloghash-toggle-wrapper bloghash-control-wrapper">

				<# if ( data.label ) { #>
					<div class="customize-control-title">
						<span>{{{ data.label }}}</span>

						<# if ( data.description ) { #>
							<i class="bloghash-info-icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle">
									<circle cx="12" cy="12" r="10"></circle>
									<path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
									<line x1="12" y1="17" x2="12" y2="17"></line>
								</svg>
								<span class="bloghash-tooltip">{{{ data.description }}}</span>
							</i>
						<# } #>

					</div>
				<# } #>

				<div id="input_{{ data.id }}" class="bloghash-toggle">

					<input  type="checkbox" id="{{ data.id }}" name="{{ data.id }}" <# if ( data.value ) { #> checked="checked" <# } #>>

					<label for="{{ data.id }}">
						<span class="bloghash-toggle-switch"></span>
					</label>
				</div><!-- END .bloghash-toggle -->

			</div><!-- END .bloghash-toggle-wrapper -->
			<?php
		}

	}
endif;
