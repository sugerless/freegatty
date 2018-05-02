<?php


class Dao_Schedule_Model extends Dao_Base_Model
{
    protected $table='freegatty_schedule';
    protected $primaryKey='id';
    protected $guarded=['id','created_at','updated_at'];
}