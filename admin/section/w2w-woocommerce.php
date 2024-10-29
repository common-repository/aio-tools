<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
use AIOTools\W2W_Utils;
/* BEGIN Section: Woocommerce */
if(W2W_Utils::is_plugin_active( 'woocommerce/woocommerce.php' )){
	CSF::createSection(
		$prefix,
		[
			'title'  => __( 'WooCommerce', 'w2w' ),
			'id'     => 'w2w-woocommerce',
			'icon'   => 'fas fa-cart-plus',
			'fields' => [
				[
					'type'    => 'subheading',
					'content' => __( 'Tùy chỉnh Trang sản phẩm', 'w2w' ),
				],
				[
					'type'    => 'submessage',
					'style'   => 'info',
					'content' => __( 'Dễ dàng tùy chỉnh các tính năng cơ bản trên trang sản phẩm', 'w2w' ),
				],
				[
					'id'      => 'opt-cfp',
					'type'    => 'switcher',
					'title'   => __( 'Gọi để biết giá', 'w2w' ),
					'desc'	  => __( 'Kích hoạt hiện thị khi đơn giá bằng 0 hoặc bỏ trống. Dùng cho cả sản phẩm đơn hoặc biến thể', 'w2w' ),
					'default' => false,
					// 'dependency' => ['opt-enable-wc', '==', 'true', '', 'visible' ],
				],
				[
					'id'      => 'txt-cfp-text',
					'type'    => 'text',
					'title'   => __( 'Tùy chọn khác', 'w2w' ),
					'desc'	  => __( 'Nhập nội dung khác. Ex: Giá liên hệ...', 'w2w' ),
					'default' => __( 'Liên hệ' , 'w2w' ),
					// 'dependency' => ['opt-enable-wc', '==', 'true', '', 'visible' ],
				],
				[
					'id'      => 'opt-wc-show-price',
					'type'    => 'switcher',
					'title'   => __( 'Hiển thị giá', 'w2w' ),
					'desc'	  => __( 'Thay đổi giá hiển thị cho sản phẩm có biến thể', 'w2w' ),
					'default' => false,
					// 'dependency' => ['opt-enable-wc', '==', 'true', '', 'visible' ],
				],
				[
					'id'     => 'fs-quote',
					'type'   => 'fieldset',
					'title'  => __( 'Yêu cầu báo giá', 'w2w'),
					'fields' => [
						[
							'id'      => 'opt-enable-quote',
							'type'    => 'switcher',
							'title'   => '',
							'default' => false,
							'desc'	  => __( 'Bật Yêu cầu báo giá.', 'w2w' ),
						],
						[
							'id'          => 'opt-cf7',
							'type'        => 'select',
							'title'       => __( '', 'w2w' ),
							'placeholder' => __( 'Chọn form liên hệ', 'w2w' ),
							'desc' => sprintf(__( 'Nếu form chưa được tạo hãy truy cập %1$svào đây%2$s để tạo form.', 'w2w' ),'<a href="/wp-admin/admin.php?page=wpcf7">','</a>'),
							'options'     => 'posts',
							'query_args'  => [
								'post_type' => 'wpcf7_contact_form',
							],
						],
					],
				],
				/* Tùy chỉnh trang Thanh toán */
				/*[
					'type'    => 'subheading',
					'content' => __( 'Tùy chỉnh Trang thanh toán', 'w2w' ),
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ],
				],
				[
					'id'      => 'opt-enable-wc',
					'type'    => 'switcher',
					'title'   => __( 'Kích hoạt', 'w2w' ),
					'default' => false,
					'desc'	  => __( 'Bật để kích hoạt tính năng tùy chỉnh thanh toán.', 'w2w' ),
				],
				
				[
					'id'      => 'opt-first-name',
					'type'    => 'switcher',
					'title'   => __( 'First Name', 'w2w' ),
					'default' => false,
					'dependency' => ['opt-enable-wc', '==', 'true', '', 'visible' ],
				],
				[
					'id'      => 'opt-last-name',
					'type'    => 'switcher',
					'title'   => __( 'Last Name', 'w2w' ),
					'default' => false,
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ],
				],
				[
					'id'      => 'opt-company',
					'type'    => 'switcher',
					'title'   => __( 'Công ty', 'w2w' ),
					'default' => false,
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ]
				],
				[
					'id'      => 'opt-address-1',
					'type'    => 'switcher',
					'title'   => __( 'Dòng địa chỉ 1', 'w2w' ),
					'default' => false,
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ]
				],
				[
					'id'      => 'opt-address-2',
					'type'    => 'switcher',
					'title'   => __( 'Dòng địa chỉ 2', 'w2w' ),
					'default' => false,
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ]
				],
				[
					'id'      => 'opt-city',
					'type'    => 'switcher',
					'title'   => __( 'Thành phố', 'w2w' ),
					'default' => false,
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ]
				],
				[
					'id'      => 'opt-postcode',
					'type'    => 'switcher',
					'title'   => __( 'Mã bưu điện', 'w2w' ),
					'default' => false,
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ]
				],
				[
					'id'      => 'opt-country',
					'type'    => 'switcher',
					'title'   => __( 'Quốc gia', 'w2w' ),
					'default' => false,
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ]
				],
				[
					'id'      => 'opt-state',
					'type'    => 'switcher',
					'title'   => __( 'Tỉnh', 'w2w' ),
					'default' => false,
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ]
				],
				[
					'id'      => 'opt-phone',
					'type'    => 'switcher',
					'title'   => __( 'Điện thoại', 'w2w' ),
					'default' => false,
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ]
				],
				[
					'id'      => 'opt-email',
					'type'    => 'switcher',
					'title'   => __( 'Email', 'w2w' ),
					'default' => false,
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ]
				],
				[
					'type'    => 'subheading',
					'content' => __( 'Tùy chỉnh thanh toán dành cho Việt Nam', 'w2w' ),
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ],
				],
				[
					'type'    => 'submessage',
					'style'   => 'warning',
					'content' => __( 'Tùy chỉnh thông tin thanh toán phù hợp tại Việt Nam với tỉnh/thành phố, quận huyện, xã/phường/thị trấn,...', 'w2w' ),
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ]
				],
				[
					'id'      => 'opt-enable-vn-checkout',
					'type'    => 'switcher',
					'title'   => __( 'Kích hoạt', 'w2w' ),
					'default' => false,
					'desc'	  => __( 'Bật để kích hoạt tính năng tùy chỉnh thanh toán.', 'w2w' ),
					'dependency' => [ 'opt-enable-wc', '==', 'true', '', 'visible' ]
				],*/
			],
		]
	);
}
/* END Section: Woocommerce */