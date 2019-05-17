<?php

namespace app\models;

use Yii;

/**
 * Description of Test
 * @author zhangb14
 */
class TestModel
{

    //put your code here
    static public function dbGetList($param = [])
    {
        $data = [];
        $sql = "SELECT username,ctime FROM test";
        $data['queryAll'] = Yii::$app->db->createCommand($sql)->queryAll();
        $data['queryColumn'] = Yii::$app->db->createCommand($sql)->queryColumn();

        $sql = "SELECT * FROM test LIMIT 1";
        $data['queryOne'] = Yii::$app->db->createCommand($sql)->queryOne();

        $sql = "SELECT COUNT(*) FROM test";
        $data['queryScalar'] = Yii::$app->db->createCommand($sql)->queryScalar();
        return $data;
    }

    static private function useDb()
    {
        try {
            $sql = "USE mycommunity_zhhy;";
            Yii::$app->db->createCommand($sql)->execute();
            return true;
        } catch (\Exception $ex) {
//            var_dump($ex->getMessage());
            return false;
        }
    }

    static public function dbGetDetail($name)
    {
        try {
            $result = self::useDb();
//            var_dump($result);
//        $params = array(':name ' => $name);
            $name = addslashes($name);
            $sql = "SELECT a.proj_id,a.`name`,b.id schedule_plan_detail_id,c.id building_id
FROM q_schedule_plan a,q_schedule_plan_detail b,t_building c
WHERE a.id = b.schedule_plan_id AND a.is_deleted = 0 AND b.is_deleted = 0
AND a.`name` = c.`name` AND a.proj_id = c.proj_id AND c.is_deleted = 0
AND b.`name` = '{$name}'";
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            return $data;
        } catch (\Exception $ex) {
//            var_dump($ex->getMessage());
            return false;
        }
    }

    static public function dbGetItem($name)
    {
        try {
            $result = self::useDb();
//            var_dump($result);
//        $params = array(':name ' => $name);
            $name = addslashes($name);
            $sql = "SELECT a.id,a.`name` FROM t_problem_class a
LEFT JOIN t_problem_class b ON a.id = b.parent_id
WHERE a.type = 32 
AND a.`name` = '{$name}'
AND a.is_deleted = 0
AND b.id IS NULL;";
            $data = Yii::$app->db->createCommand($sql)->queryAll();
            return $data;
        } catch (\Exception $ex) {
//            var_dump($ex->getMessage());
            return false;
        }
    }

    static public function isProcessAcceptDetailUpdated($buildingId, $time)
    {
        self::useDb();
        $condition = "pa.building_id = :building_id and pad.update_timestamp >= :time";
        $condition2 = "pa.location_id in (select DISTINCT id from q_location where (id = :location_id or parent_id = :location_id)) and pad.update_timestamp >= :time";
        $param[':building_id'] = $buildingId;
        $param[':location_id'] = $buildingId;
        $param[':time'] = $time;

        $sqlTemplate = "
                select 1
                from q_process_accept_detail pad
                  inner join q_process_accept as pa on pa.id = pad.process_accept_id
                where $condition limit 1
                UNION ALL 
                select 1
                from q_process_accept_detail pad
                  inner join q_process_accept as pa on pa.id = pad.process_accept_id
                where $condition2 limit 1
                ";

        return Yii::$app->db->createCommand($sqlTemplate, $param)->queryScalar();
    }

    static public function dbIsProcessAcceptDetailUpdated($buildingId, $time)
    {
        self::useDb();
        $param = [];
        $param[':building_id'] = $buildingId;
        $param[':time'] = $time;
        $sql = "select 1
                from q_process_accept_detail pad
                  inner join q_process_accept as pa on pa.id = pad.process_accept_id
                where pa.building_id = :building_id and pad.update_timestamp >= :time limit 1";
        $result = Yii::$app->db->createCommand($sql, $param)->queryScalar();
        if ($result) {
            return true;
        }
        $param = [];
        $param[':location_id'] = $buildingId;
        $sql = "select id from q_location where (id = :location_id or parent_id = :location_id)";
        $location_id_arr = Yii::$app->db->createCommand($sql, $param)->queryColumn();
        if (empty($location_id_arr)) {
            return false;
        }
        $param = [];
        $location_id_arr = array_unique($location_id_arr);
        $location_id_key = [];
        foreach ($location_id_arr as $key => $value) {
            $key = ':k' . $key;
            $location_id_key[] = $key;
            $param[$key] = $value;
        }
        $location_id_key_str = implode(',', $location_id_key);
        unset($location_id_arr, $location_id_key);
        $param[':time'] = $time;
        $sql = "select 1
                from q_process_accept_detail pad
                  inner join q_process_accept as pa on pa.id = pad.process_accept_id
                where pa.location_id in ({$location_id_key_str}) and pad.update_timestamp >= :time limit 1";
        $result = Yii::$app->db->createCommand($sql, $param)->queryScalar();
        if ($result) {
            return true;
        }
        return false;
    }

}
