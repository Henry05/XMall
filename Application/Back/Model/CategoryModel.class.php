<?php
namespace Back\Model;

use Think\Model;


class CategoryModel extends Model
{

    public function getTreeList()
    {
        // 获取所有的分类 
        // 配置缓存
        S(['type'=>'Memcache', 'host'=>'127.0.0.1', 'port'=>'11211']);
        G('c_begin');
        // $key = 'back_category_tree';
        // // 判断缓存是否存在
        // if (! ($tree = S($key)) ) {
    
            // 从数据源获取
            $rows = $this->order('sort_number')->select();
            $tree = $this->tree($rows);
            
            // 存储缓存中
            // S($key, $tree);
        // }
        //echo G('c_begin', 'c_end'), 's', '<br>';
        // 返回数据
        return $tree;

    }
    // 递归 树
    public function tree($rows, $category_id=0, $deep=0) 
    {
        static $tree = [];
        foreach($rows as $row) {
            if ($row['parent_id'] == $category_id) {
                $row['deep'] = $deep;
                $tree[] = $row;
                $this->tree($rows, $row['category_id'], $deep+1);
            }
        }
        return $tree;
    }
}