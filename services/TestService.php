<?php

namespace app\services;

use app\models\TestModel;

/**
 * Description of TestService
 * @author zhangb14
 */
class TestService
{

    //put your code here
    static public function getList()
    {
        return TestModel::dbGetList();
    }

    static private function writeLog($data, $filename = '')
    {
        empty($filename) && $filename = date('Y-m-d');
        file_put_contents('E:\\Project\\yii2\\' . $filename . '.log', $data . "\r\n", FILE_APPEND);
    }

    /**
     * 36位GUID
     * @return string
     */
    static public function uuid()
    {
        list($usec, $sec) = explode(" ", microtime(false));
        $usec = (string) ($usec * 10000000);
        $timestamp = bcadd(bcadd(bcmul($sec, "10000000"), (string) $usec), "621355968000000000");
        $ticks = bcdiv($timestamp, 10000);
        $maxUint = 4294967295;
        $high = bcdiv($ticks, $maxUint) + 0;
        $low = bcmod($ticks, $maxUint) - $high;
        $highBit = (pack("N*", $high));
        $lowBit = (pack("N*", $low));
        $guid = str_pad(dechex(ord($highBit[2])), 2, "0", STR_PAD_LEFT) . str_pad(dechex(ord($highBit[3])), 2, "0", STR_PAD_LEFT) . str_pad(dechex(ord($lowBit[0])), 2, "0", STR_PAD_LEFT) . str_pad(dechex(ord($lowBit[1])), 2, "0", STR_PAD_LEFT) . "-" . str_pad(dechex(ord($lowBit[2])), 2, "0", STR_PAD_LEFT) . str_pad(dechex(ord($lowBit[3])), 2, "0", STR_PAD_LEFT) . "-";
        $chars = "abcdef0123456789";
        for ($i = 0; $i < 4; $i++) {
            $guid .= $chars[mt_rand(0, 15)];
        }
        $guid .= "-";
        for ($i = 0; $i < 4; $i++) {
            $guid .= $chars[mt_rand(0, 15)];
        }
        $guid .= "-";
        for ($i = 0; $i < 12; $i++) {
            $guid .= $chars[mt_rand(0, 15)];
        }

        return $guid;
    }

    static public function doScheduleLogic()
    {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        self::writeLog('开始时间：' . date('Y-m-d H:i:s') . '######################################################');
        $data = array('临水临电' => '临水临电', '三通一平完成' => '场地平整', '地勘' => '地勘', '围护工程完成时间' => '围护工程', '降水' => '降水', '土方开挖、回填完成时间' => '土方开挖、回填', '桩基础检测完成时间' => '桩基础检测', '基础完成/地下结构出正负零完成时间' => '基础完成/地下结构出正负零', '相关地库结构封顶时间' => '相关地库结构封顶时间', '砼主体结构封顶完成时间' => '砼主体结构封顶', '二结构施工' => '二结构施工', '地下车库顶、外墙防水工程完成时间' => '地下车库顶、外墙防水工程', '屋面工程完成时间' => '屋面工程', '卫生间及其他防水完成时间' => '卫生间及其他防水', '装配式部件、部品成品验收完成时间' => '装配式部件、部品成品验收', '烟道' => '烟道', '内墙抹灰完成时间' => '内墙抹灰', '内墙、顶棚腻子完成时间' => '内墙、顶棚腻子', '地热施工完成时间' => '地热施工', '楼地面（细石砼、水泥砂浆）完成时间' => '楼地面（细石砼、水泥砂浆）', '铝合金、塑钢窗安装完成时间' => '铝合金、塑钢窗安装', '楼梯阳台栏杆安装完成时间' => '楼梯阳台栏杆安装', '空调栏杆、百叶安装完成时间' => '空调栏杆、百叶安装', '进户门安装完成时间' => '进户门安装', '人防门安装完成时间' => '人防门安装', '防火门安装完成时间' => '防火门安装', '单元门安装完成时间' => '单元门安装', '钢构雨棚天棚完成时间' => '钢构雨棚天棚', '室内精装完成时间' => '室内精装', '公共部位精装完成时间' => '公共部位精装', '外墙抹灰完成时间' => '外墙抹灰', '外墙保温（内、外保温）完成时间' => '外墙保温（内、外保温）', '外墙涂料/块料饰面完成时间' => '外墙涂料/块料饰面', '室内给排水工程（预埋、安装）完成时间' => '室内给排水工程（预埋、安装）', '水泵房设备安装完成时间' => '水泵房设备安装', '强电工程（预埋、安装）完成时间' => '强电工程（预埋、安装）', '开关站/开闭所变配电房设备安装完成时间' => '开关站/开闭所变配电房设备安装', '消防工程（预埋、安装）完成时间' => '消防工程（预埋、安装）', '消防泵房消控室设备安装完成时间' => '消防泵房消控室设备安装', '燃气（管线及燃气表安装）完成时间' => '燃气（管线及燃气表安装）', '供暖管网、换热站设备安装完成时间' => '供暖管网、换热站设备安装', '通风管道及设备完成时间' => '通风管道及设备', '电梯工程（预埋、安装）完成时间' => '电梯工程（预埋、安装）', '智能化工程（预埋、安装）完成时间' => '智能化工程（预埋、安装）', '太阳能设备安装完成时间' => '太阳能设备安装', '各系统单独调试完成时间' => '各系统单独调试', '雨水管网完成时间' => '雨水管网', '污水管网完成时间' => '污水管网', '电力管网完成时间' => '电力管网', '燃气管网完成时间' => '燃气管网', '生活给水管网完成时间' => '生活给水管网', '消防给水管网完成时间' => '消防给水管网', '供暖管网完成时间' => '供暖管网', '广电、电信、网络管网' => '广电、电信、网络管网', '智能化完成时间' => '智能化', '土方挖填、造坡完成时间' => '土方挖填、造坡', '小品（假山、亭、池、小径）等、照明完成时间' => '小品（假山、亭、池、小径）等、照明', '园路、广场、台阶等的硬质铺装完成时间' => '园路、广场、台阶等的硬质铺装', '绿化种植完成时间' => '绿化种植', '道路基层完成时间' => '道路基层', '道路面层完成时间' => '道路面层', '小区围墙、岗亭完成时间' => '小区围墙、岗亭', '标识标牌完成时间' => '标识标牌', '出入口、车库道闸完成时间' => '出入口、车库道闸', 'a、专项验收' => 'a、专项验收', '消防验收完成时间' => '消防验收', '规划验收完成时间' => '规划验收', '其他重要专项验收（档案、人防、环保、绿化、防雷、节能、供暖、电梯、机房、装配式等）级水电气接入完成时间' => '其他重要专项验收（档案、人防、环保、绿化、防雷、节能、供暖、电梯、机房、装配式等）级水电气接入', 'b、综合验收' => 'b、综合验收', '预验收（一户一验）完成时间' => '预验收（一户一验）', '竣工验收完成时间' => '竣工验收', '项目备案完成时间' => '项目备案');
//        $data = array('临水临电' => '临水临电', '三通一平完成' => '场地平整');
        $created_on = date('Y-m-d H:i:s');
        $created_by = '22b11db4-e907-4f1f-8835-b9daab6e1f23';
        $modified_on = $created_on;
        $modified_by = $created_by;
        foreach ($data as $detail_name => $item_name) {
            $detail_data = TestModel::dbGetDetail($detail_name);
            if (!$detail_data) {
                self::writeLog("进度节点名称：{$detail_name}，工序移交项名称：{$item_name}，对应的楼栋数据不存在");
                continue;
            }
            $item = TestModel::dbGetItem($item_name);
            if (!$item) {
                self::writeLog("进度节点名称：{$detail_name}，工序移交项名称：{$item_name}，工序移交项不存在");
                continue;
            }
            $item_id = $item[0]['id'];
            $details = array_chunk($detail_data, 50);
            foreach ($details as $detail) {
                $value_sql = [];
                foreach ($detail as $value) {
                    $id = self::uuid();
                    $value_sql[] = "('{$id}','{$value['schedule_plan_detail_id']}','{$value['proj_id']}','{$value['building_id']}','{$item_id}',NOW(),'{$created_by}',NOW(),'{$modified_by}')";
                }
                $id_str = "'" . implode("','", array_column($detail, 'schedule_plan_detail_id')) . "'";
                $sql = "UPDATE q_schedule_plan_detail SET complete_by = 'process_check',modified_on=NOW(),modified_by='{$modified_by}' WHERE id IN ({$id_str}) AND is_deleted=0;";
                self::writeLog($sql, 'insert.sql');
                unset($id_str, $sql);
                $sql = "INSERT INTO q_schedule_plan_detail_place(id,schedule_plan_detail_id,proj_id,building_id,item_id,created_on,created_by,modified_on,modified_by)VALUES";
                $sql .= implode(',', $value_sql) . ';';
                self::writeLog($sql, 'insert.sql');
                unset($detail, $sql);
            }
            unset($detail_data, $details, $item);
        }
        self::writeLog('结束时间：' . date('Y-m-d H:i:s') . '######################################################');
    }

    static public function isProcessAcceptDetailUpdated($buildingId, $time)
    {
        $stime = microtime(true);
        $result = TestModel::dbIsProcessAcceptDetailUpdated($buildingId, $time);
        var_dump($result);
        $etime = microtime(true);
        var_dump($etime - $stime);
        $result = TestModel::isProcessAcceptDetailUpdated($buildingId, $time);
        var_dump($result);
        $etime2 = microtime(true);
        var_dump($etime2 - $etime);
    }

}
