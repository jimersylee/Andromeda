<?php

class Util{
    /**
     * 解析用户的url的中的query参数
     * @param $query
     * @return array
     */
    public static function convertUrlQuery($query){
        $queryParts = explode('&', $query);

        $params = array();
        foreach ($queryParts as $param)
        {
            $item = explode('=', $param);
            if(isset($item[1])){
                $params[$item[0]] = $item[1];
            }
        }
        return $params;
    }

    /**
     * 由参数数组转换为query的url
     * @param $array_query
     * @return string
     */
    public static function getUrlQuery($array_query){
        $tmp = array();
        foreach($array_query as $k=>$param)
        {
            $tmp[] = $k.'='.$param;
        }
        $params = implode('&',$tmp);
        return $params;
    }
}
