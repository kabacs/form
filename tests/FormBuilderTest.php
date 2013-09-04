<?php

use AdamWathan\Form\FormBuilder;

class FormBuilderTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->form = new FormBuilder;
	}

	public function tearDown()
	{
		Mockery::close();
	}

	public function testFormBuilderCanBeCreated()
	{
		$formBuilder = new FormBuilder;
	}

	public function testFormOpen()
	{
		$expected = '<form method="POST">';
		$result = $this->form->open();
		$this->assertEquals($expected, $result);
	}

	public function testCanCloseForm()
	{
		$expected = '</form>';
		$result = $this->form->close();
		$this->assertEquals($expected, $result);
	}

	public function testTextBox()
	{
		$expected = '<input type="text" name="email">';
		$result = (string)$this->form->text('email');
		$this->assertEquals($expected, $result);

		$expected = '<input type="text" name="first_name">';
		$result = (string)$this->form->text('first_name');
		$this->assertEquals($expected, $result);
	}

	public function testPassword()
	{
		$expected = '<input type="password" name="password">';
		$result = (string)$this->form->password('password');
		$this->assertEquals($expected, $result);

		$expected = '<input type="password" name="password_confirmed">';
		$result = (string)$this->form->password('password_confirmed');
		$this->assertEquals($expected, $result);
	}

	public function testCheckbox()
	{
		$expected = '<input type="checkbox" name="terms" value="1">';
		$result = (string)$this->form->checkbox('terms');
		$this->assertEquals($expected, $result);

		$expected = '<input type="checkbox" name="terms" value="agree">';
		$result = (string)$this->form->checkbox('terms', 'agree');
		$this->assertEquals($expected, $result);
	}

	public function testRadio()
	{
		$expected = '<input type="radio" name="terms" value="terms">';
		$result = (string)$this->form->radio('terms');
		$this->assertEquals($expected, $result);

		$expected = '<input type="radio" name="terms" value="agree">';
		$result = (string)$this->form->radio('terms', 'agree');
		$this->assertEquals($expected, $result);
	}

	public function testSubmit()
	{
		$expected = '<input type="submit" value="Sign In">';
		$result = (string)$this->form->submit('Sign In');
		$this->assertEquals($expected, $result);

		$expected = '<input type="submit" value="Log In">';
		$result = (string)$this->form->submit('Log In');
		$this->assertEquals($expected, $result);
	}

	public function testSelect()
	{
		$expected = '<select name="color" id="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
		$result = (string)$this->form->select('color', array('red' => 'Red', 'blue' => 'Blue'));
		$this->assertEquals($expected, $result);

		$expected = '<select name="fruit" id="fruit"><option value="apple">Granny Smith</option><option value="berry">Blueberry</option></select>';
		$result = (string)$this->form->select('fruit', array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$this->assertEquals($expected, $result);
	}

	public function testTextArea()
	{
		$expected = '<textarea name="bio" rows="10" cols="50"></textarea>';
		$result = (string)$this->form->textarea('bio');
		$this->assertEquals($expected, $result);

		$expected = '<textarea name="description" rows="10" cols="50"></textarea>';
		$result = (string)$this->form->textarea('description');
		$this->assertEquals($expected, $result);
	}

	public function testLabel()
	{		
		$expected = '<label>Email</label>';
		$result = (string)$this->form->label('Email');
		$this->assertEquals($expected, $result);

		$expected = '<label>First Name</label>';
		$result = (string)$this->form->label('First Name');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInputInterface');
		$oldInput->shouldReceive('hasOld')->with('email')->andReturn(true);
		$oldInput->shouldReceive('getOld')->with('email')->andReturn('example@example.com');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="text" name="email" value="example@example.com">';
		$result = (string)$this->form->text('email');
		$this->assertEquals($expected, $result);
	}

	public function testRenderCheckboxWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInputInterface');
		$oldInput->shouldReceive('hasOld')->with('terms')->andReturn(true);
		$oldInput->shouldReceive('getOld')->with('terms')->andReturn('agree');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="checkbox" name="terms" value="agree" checked="checked">';
		$result = (string)$this->form->checkbox('terms', 'agree');
		$this->assertEquals($expected, $result);
	}

	public function testRenderRadioWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInputInterface');
		$oldInput->shouldReceive('hasOld')->with('color')->andReturn(true);
		$oldInput->shouldReceive('getOld')->with('color')->andReturn('green');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="radio" name="color" value="green" checked="checked">';
		$result = (string)$this->form->radio('color', 'green');
		$this->assertEquals($expected, $result);
	}

	public function testRenderSelectWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInputInterface');
		$oldInput->shouldReceive('hasOld')->with('color')->andReturn(true);
		$oldInput->shouldReceive('getOld')->with('color')->andReturn('blue');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<select name="color" id="color"><option value="red">Red</option><option value="blue" selected>Blue</option></select>';
		$result = (string)$this->form->select('color', array('red' => 'Red', 'blue' => 'Blue'));
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextAreaWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInputInterface');
		$oldInput->shouldReceive('hasOld')->with('bio')->andReturn(true);
		$oldInput->shouldReceive('getOld')->with('bio')->andReturn('This is my bio');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<textarea name="bio" rows="10" cols="50">This is my bio</textarea>';
		$result = (string)$this->form->textarea('bio');
		$this->assertEquals($expected, $result);
	}
}