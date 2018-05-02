<?php
    class Dao_User_Model extends Dao_Base_Model{
        protected $table='freegatty_user';
        protected $primaryKey='id';
        protected $guarded=['id','created_at','updated_at'];
    }