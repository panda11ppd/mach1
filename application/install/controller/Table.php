<?php
namespace app\install\controller;
use think\Controller;
use think\Request;
use think\Db;
/*
 * mysql表结构处理类
 * 创建数据表，增加，编辑，删除表中字段
 *
 */
class Table extends Controller{
    /*
     * 创建数据库表，并且主键是id
     * table 要查询的表名
     */
    function createTable($table,$name){
        $sql="CREATE TABLE IF NOT EXISTS `$table` (`$name` INT NOT NULL primary key)ENGINE = InnoDB;";
        Db::execute($sql);
        $this->checkTable($table);
    }
    /*
     * 检测表是否存在，也可以获取表中所有字段的信息
     * table 要查询的表名
     * return 表里所有字段的信息
     */
    protected function checkTable($table){
        $sql="select * from $table";
        $info=Db::query($sql);
        return $info;
    }
 
    /*
     * 检测字段是否存在，也可以获取字段信息(只能是一个字段)
     * table 表名
     * field 字段名
     */
    protected function checkField($table,$field){
        $sql="desc `$table` `$field`";
        $info=Db::query($sql);
        return $info;
    }
 
    /*
     * 添加字段
     * table 表名
     * info  字段信息数组 array
     * return 字段信息 array
     */
    protected function addField($table,$info){
        $sql="alter table `$table` add ";
        $sql.=$this->filterFieldInfo();
        Db::execute($sql);
        $this->checkField($table,$info['name']);
    }
	/*
     * 添加字段SQL脚本
     * table 表名
     * info  字段信息数组 array
     * return 字段信息 array
     */
    protected function addbat($table,$bats){
        $sql="alter table `$table` add column $bats";        
        Db::execute($sql);        
    }
    /*
     * 修改字段
     * 不能修改字段名称，只能修改
     */
    protected function editField($table,$info){
        $sql="alter table `$table` modify ";
        $sql.=$this->filterFieldInfo($info);
        Db::execute($sql);
        $this->checkField($table,$info['name']);
    }
    protected function editbat($table,$info){
        $sql="alter table `$table` modify $info";        
        Db::execute($sql);
       
    }
    /*
     * 字段信息数组处理，供添加更新字段时候使用
     * info[name]   字段名称
     * info[type]   字段类型
     * info[length]  字段长度
     * info[isNull]  是否为空
     * info['default']   字段默认值
     * info['comment']   字段备注
     */
    private function filterFieldInfo($info){
        if(!is_array($info))
            return
        $newInfo=array();
        $newInfo['name']=$info['name'];
        $newInfo['type']=$info['type'];
        switch($info['type']){
            case 'varchar':
            case 'char':
                $newInfo['length']=empty($info['length'])?100:$info['length'];
                $newInfo['isNull']=$info['isNull']==1?'NULL':'NOT NULL';
                $newInfo['default']=empty($info['default'])?'':'DEFAULT '.$info['default'];
                $newInfo['comment']=empty($info['comment'])?'':'COMMENT '.$info['comment'];
            case 'int':
                $newInfo['length']=empty($info['length'])?7:$info['length'];
                $newInfo['isNull']=$info['isNull']==1?'NULL':'NOT NULL';
                $newInfo['default']=empty($info['default'])?'':'DEFAULT '.$info['default'];
                $newInfo['comment']=empty($info['comment'])?'':'COMMENT '.$info['comment'];
            case 'text':
                $newInfo['length']='';
                $newInfo['isNull']=$info['isNull']==1?'NULL':'NOT NULL';
                $newInfo['default']='';
                $newInfo['comment']=empty($info['comment'])?'':'COMMENT '.$info['comment'];
        }
        $sql=$newInfo['name'].' '.$newInfo['type'];
        $sql.=(!empty($newInfo['length']))?($newInfo['length'])." ":' ';
        $sql.=$newInfo['isNull'].'';
        $sql.=$newInfo['default'];
        $sql.=$newInfo['comment'];
        return $sql;
    }
 
    /*
     * 删除字段
     * 如果返回了字段信息则说明删除失败，返回false，则为删除成功
     */
    protected function dropField($table,$field){
        $sql="alter table `$table` drop column $field";
        Db::execute($sql);
        $this->checkField($table,$filed);
    }
 
    /*
     * 获取指定表中指定字段的信息(多字段)
     */
    protected function getFieldInfo($table,$field){
        $info=array();
        if(is_string($field)){
            $this->checkField($table,$field);
        }else{
            foreach($field as $v){
                $info[$v]=$this->checkField($table,$v);
            }
        }
        return $info;
    }
}