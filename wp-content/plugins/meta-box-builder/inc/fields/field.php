<?php

class MBB_Field
{
	public $basic = array( 'id', 'name', 'desc' );

	public $advanced = array();

	public function __construct()
	{
		echo $this->get_fields( $this->basic );

		if ( ! is_array( $this->advanced ) )
			return;

		echo 	'<a role="button" class="show-advanced" href="#">Show Advanced</a>
				<div class="field-advanced hidden">
					<a role="button" class="hide-advanced" href="#">Hide Advanced</a>';

		$attrs = Meta_Box_Attribute::get_attribute_content( 'key_value', 'attrs' );
		
		// Add a class section with full size
		$this->advanced['class'] = array( 'size' => 'wide' );

		// Add a custom attribute section
		$this->advanced['attrs'] = array(
			'type' 		=> 'custom',
			'content' 	=> $attrs
		);

		// Add conditional logic section
		$conditional_logic = Meta_Box_Attribute::get_attribute_content( 'conditional_logic' );

		$this->advanced['conditional_logic'] = array(
			'type' 		=> 'custom',
			'content' 	=> $conditional_logic
		);

		// Add columns section
		$this->advanced['columns'] = array( 
			'type' => 'number',
			'attrs' => array(
				'min' => 1,
				'max' => 12
			)
		);

		echo $this->get_fields( $this->advanced );

		echo	'</div>';
	}

	public function get_fields( $fields )
	{
		$output = '';

		foreach ( $fields as $index => $field )
		{
			// Clearfix
			if ( is_null( $index ) || is_null( $field ) )
			{
				$output .= '<div class="clear"></div>';
				continue;
			}

			if ( is_numeric( $index ) )
			{
				// Normal text field, normal size
				$output .= '<p class="description description-thin">';
					$output .= Meta_Box_Attribute::text( $field );
				$output .= '</p>';

				continue;
			}

			if ( is_string( $field ) )
			{
				$output .= '<p class="description description-thin">';
					$output .= Meta_Box_Attribute::$field( $index );
				$output .= '</p>';
			}

			if ( is_array( $field ) && ! empty( $field ) )
			{
				$size 	= isset( $field['size'] ) ? $field['size'] : 'thin';
				$label 	= isset( $field['label'] ) ? $field['label'] : null;
				$attrs 	= isset( $field['attrs'] ) ? $field['attrs'] : array();
				$type 	= isset( $field['type'] ) ? $field['type'] : 'text';
				
				$output .= "<p class='description description-$size'>";

				if ( $type === 'custom' )
					$output .= $field['content'];
				else
					$output .= Meta_Box_Attribute::$type( $index, $label, $attrs );
				$output .= '</p>';
			}
		}
		
		return $output;
	}
}