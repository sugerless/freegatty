<?php


class Dao_Score_Model extends Dao_Base_Model
{
    protected $table='freegatty_grade_record';
    protected $primaryKey='id';
    protected $guarded=['id','created_at','updated_at'];

    
}