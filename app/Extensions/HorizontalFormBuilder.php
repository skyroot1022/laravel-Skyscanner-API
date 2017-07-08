<?php namespace App\Extensions;

use AdamWathan\BootForms\Elements\OffsetFormGroup;

class HorizontalFormBuilder extends \AdamWathan\BootForms\HorizontalFormBuilder {
	protected $builder;
	private $columnSizes;

	public function __construct( FormBuilder $builder, $columnSizes = [ 'lg' => [ 4, 8 ] ] ) {
		$this->builder     = $builder;
		$this->columnSizes = $columnSizes;
	}

	public function setColumnSizes( $columnSizes ) {
		$this->columnSizes = $columnSizes;

		return $this;
	}

	public function open() {
		return $this->builder->open()->addClass( 'admin-form' );
	}

	public function button( $value, $name = null, $type = "btn-default" ) {
		$button = $this->builder->button( $value, $name )->addClass( 'btn' )->addClass( $type );

		return new OffsetFormGroup( $button, $this->columnSizes );
	}

	public function submit( $value = "Submit", $type = "btn-default" ) {
		$button = $this->builder->submit( $value )->addClass( 'btn' )->addClass( $type );

		return new OffsetFormGroup( $button, $this->columnSizes );
	}

	public function checkbox( $label, $name ) {
		$control    = $this->builder->checkbox( $name );
		$checkGroup = $this->checkGroup( '<span class="checkbox"></span>' . $label, $name, $control )->addClass( 'option-group field' );

		$group = new OffsetFormGroup( $checkGroup, $this->columnSizes );

		return $group->removeClass( 'form-group' )->addClass( 'section row mb10' );
	}

	public function toggle( $label, $name ) {
		$control    = $this->builder->checkbox( $name )->value(1)->id($name);
		$checkGroup = $this->toggleGroup( '<label for="'.$name.'" data-on="YES" data-off="NO"></label><span>' . $label . '</span>', $name, $control );

		$group = new OffsetFormGroup( $checkGroup, $this->columnSizes );

		return $group->removeClass( 'form-group' );
	}

	protected function toggleGroup( $label, $name, $control ) {
		$label = $this->builder->label( $label, $name )->addClass( 'block mt15 switch switch-round switch-primary' )->after( $control );

		$checkGroup = new CheckGroup( $label );

		if ( $this->builder->hasError( $name ) ) {
			$checkGroup->helpBlock( $this->builder->getError( $name ) );
			$checkGroup->addClass( 'has-error' );
		}

		return $checkGroup;
	}

	protected function checkGroup( $label, $name, $control ) {
		$label = $this->builder->label( $label, $name )->addClass( 'option option-primary' )->after( $control );

		$checkGroup = new CheckGroup( $label );

		if ( $this->builder->hasError( $name ) ) {
			$checkGroup->helpBlock( $this->builder->getError( $name ) );
			$checkGroup->addClass( 'has-error' );
		}

		return $checkGroup;
	}

	public function radio( $label, $name, $value = null ) {
		if ( is_null( $value ) ) {
			$value = $label;
		}

		$control    = $this->builder->radio( $name, $value );
		$checkGroup = $this->checkGroup( '<span class="radio"></span>' . $label, $name, $control )->addClass( 'option-group field' );

		$group = new OffsetFormGroup( $checkGroup, $this->columnSizes );

		return $group->removeClass( 'form-group' )->addClass( 'section row mb10' );
	}

	public function file( $label, $name, $value = null ) {
		$control = $this->builder->file( $name )->value( $value );
		$label   = $this->builder->label( $label, $name )
		                         ->addClass( $this->getLabelClass() )
		                         ->addClass( 'control-label' )
		                         ->forId( $name );

		$control->id( $name );

		$formGroup = new HorizontalFormGroup( $label, $control, $this->getControlSizes() );

		if ( $this->builder->hasError( $name ) ) {
			$formGroup->helpBlock( $this->builder->getError( $name ) );
			$formGroup->addClass( 'has-error' );
		}

		return $formGroup;
	}

	public function __call( $method, $parameters ) {
		return call_user_func_array( [ $this->builder, $method ], $parameters );
	}

	protected function formGroup( $label, $name, $control ) {
		$label = $this->builder->label( $label . ': ', $name )
		                       ->addClass( $this->getLabelClass() )
		                       ->addClass( 'field-label text-center' )
		                       ->forId( $name );

		$control->id( $name )->addClass( 'gui-input' );

		$formGroup = new HorizontalFormGroup( $label, $control, $this->getControlSizes() );

		if ( $this->builder->hasError( $name ) ) {
			$formGroup->helpBlock( $this->builder->getError( $name ) );
			$formGroup->addClass( 'has-error' );
		}

		$formGroup->addClass( 'section row mb10' )->removeClass( 'form-group' );

		return $this->wrap( $formGroup );
	}

	protected function getLabelClass() {
		$class = '';
		foreach ( $this->columnSizes as $breakpoint => $sizes ) {
			$class .= sprintf( 'col-%s-%s ', $breakpoint, $sizes[0] );
		}

		return trim( $class );
	}

	protected function getControlSizes() {
		$controlSizes = [ ];
		foreach ( $this->columnSizes as $breakpoint => $sizes ) {
			$controlSizes[ $breakpoint ] = $sizes[1];
		}

		return $controlSizes;
	}
}
