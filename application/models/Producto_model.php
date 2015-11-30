<?php
class Producto_model  extends grocery_CRUD_Model{
  
	function db_update($post_array, $primary_key_value)
	{
		if ($this->field_exists('UsuarioModifica'))
		{
			$post_array['UsuarioModifica'] = $_SESSION["usuario"];
		}
	
		return parent::db_update($post_array, $primary_key_value);
	}  
  
	function db_insert($post_array)
	{
		if ($this->field_exists('UsuarioModifica'))
		{
			$post_array['UsuarioModifica'] = $_SESSION["usuario"];
		}
		return parent::db_insert($post_array);
	}
  
}

