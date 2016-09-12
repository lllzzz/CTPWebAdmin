<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    const TYPE_FORECAST = 0;
    const TYPE_IOC_CLOSE = 3;
    const TYPE_REAL_OPEN = 1;
    const TYPE_REAL_CLOSE = 2;

    public static $orderDesp = [
        self::TYPE_FORECAST => '预测',
        self::TYPE_IOC_CLOSE => '强平',
        self::TYPE_REAL_OPEN => '实时开',
        self::TYPE_REAL_CLOSE => '实时平',
    ];

    const LOG_TRADE = 1;
    const LOG_ORDER = 2;
    const LOG_TRADED = 3;
    const LOG_CANCELED = 4;

    public static $logDesp = [
        self::LOG_TRADE => '下单',
        self::LOG_ORDER => '反馈',
        self::LOG_TRADED => '成交',
        self::LOG_CANCELED => '撤销',
    ];

    public function list(Request $req)
    {
        $page = $req->input('p', 1);
        $size = 20;
        $start = $size * ($page - 1);

        $startT = $req->input('st', '');
        $endT = $req->input('et', '');
        $appKey = $req->input('ak', '');
        $iid = $req->input('iid', '');

        $sql = "SELECT * FROM `order` WHERE 1 = 1 ";
        $where = '';
        if ($startT) {
            $where .= "AND `srv_first_time` >= '{$startT}' ";
        }
        if ($endT) {
            $where .= "AND `srv_first_time` <= '{$endT}' ";
        }
        if ($appKey) {
            $where .= "AND `appKey` = " . intval($appKey) . " ";
        }
        if ($iid) {
            $where .= "AND `iid` LIKE '%{$iid}%' ";
        }
        $sql = $sql . $where . "ORDER BY `id` DESC LIMIT {$start}, {$size}";
        $list = $this->orderDB->select($sql);

        $sql = "SELECT COUNT(*) AS total FROM `order` WHERE 1 = 1 " . $where;
        $total = $this->orderDB->select($sql)[0]->total;

        $this->data['pre'] = $page == 1 ? 1 : $page - 1;
        $this->data['next'] = $page == $total ? $page : $page + 1;
        $this->data['startT'] = $startT;
        $this->data['endT'] = $endT;
        $this->data['appKey'] = $appKey;
        $this->data['iid'] = $iid;
        $this->data['list'] = $this->formatList($list);
        return view('order', $this->data);
    }

    private function formatList($list)
    {
        $newList = [];
        foreach ($list as $item) {
            $tmp = [];
            $tmp[] = $item->id;
            $tmp[] = $item->appKey;
            $tmp[] = $item->mid;
            $tmp[] = $item->iid;
            $tmp[] = $item->order_ids;
            $tmp[] = self::$orderDesp[$item->type];
            $tmp[] = $item->price;
            $tmp[] = $item->price_mean;
            $tmp[] = $item->total;
            $tmp[] = $item->total_success;
            $tmp[] = ($item->is_buy ? '买' : '卖') . ($item->is_open ? '开' : '平');
            $tmp[] = $item->srv_first_time;
            $tmp[] = $item->srv_end_time;
            // 首次响应
            $start = strtotime($item->local_start_time) * 1000000 + $item->local_start_usec;
            $first = strtotime($item->local_first_time) * 1000000 + $item->local_first_usec;
            $end = strtotime($item->local_end_time) * 1000000 + $item->local_end_usec;
            $tmp[] = ($first - $start) / 1000;
            // 总耗时
            $total = ($end - $first) / 1000;
            $times = [1000, 60, 60, 24];
            $timesDesp = ['ms', 's', 'm', 'h'];
            $totalTmp = [];
            foreach ($times as $i => $t) {
                $totalTmp[] = $total % $t . $timesDesp[$i];
                $total = floor($total / $t);
                if ($total == 0) break;
            }
            $totalTmp = array_reverse($totalTmp);
            $tmp[] = implode(' ', $totalTmp);
            $newList[] = $tmp;
        }
        return $newList;
    }

    public function log(Request $req)
    {
        $page = $req->input('p', 1);
        $size = 20;
        $start = $size * ($page - 1);

        $startT = $req->input('st', '');
        $endT = $req->input('et', '');
        $appKey = $req->input('ak', '');
        $iid = $req->input('iid', '');
        $oids = $req->input('oids', '');

        $sql = "SELECT * FROM `order_log` WHERE 1 = 1 ";
        $where = '';
        if ($startT) {
            $where .= "AND `local_time` >= '{$startT}' ";
        }
        if ($endT) {
            $where .= "AND `local_time` <= '{$endT}' ";
        }
        if ($appKey) {
            $where .= "AND `appKey` = " . intval($appKey) . " ";
        }
        if ($iid) {
            $where .= "AND `iid` LIKE '%{$iid}%' ";
        }
        if ($oids) {
            $where .= "AND `order_id` IN ({$oids}) ";
        }
        $sql = $sql . $where . "ORDER BY `id` ASC LIMIT {$start}, {$size}";
        $list = $this->orderDB->select($sql);

        $sql = "SELECT COUNT(*) AS total FROM `order_log` WHERE 1 = 1 " . $where;
        $total = $this->orderDB->select($sql)[0]->total;

        $this->data['pre'] = $page == 1 ? 1 : $page - 1;
        $this->data['next'] = $page == $total ? $page : $page + 1;
        $this->data['startT'] = $startT;
        $this->data['endT'] = $endT;
        $this->data['appKey'] = $appKey;
        $this->data['iid'] = $iid;
        $this->data['oids'] = $oids;
        $this->data['list'] = $this->formatLog($list);
        return view('log', $this->data);
    }

    private function formatLog($list)
    {
        $newList = [];
        foreach ($list as $item) {
            $tmp = [];
            $tmp[] = $item->id;
            $tmp[] = $item->appKey;
            $tmp[] = $item->iid;
            $tmp[] = $item->order_id;
            $tmp[] = $item->front_id . ":" . $item->session_id . ":" . $item->order_ref;
            $tmp[] = $item->price == -1 ? '-' : $item->price;
            $tmp[] = $item->total;
            $tmp[] = $item->is_buy == -1 ? '-' : (($item->is_buy ? '买' : '卖') . ($item->is_open ? '开' : '平'));
            $tmp[] = $item->srv_time == '0000-00-00 00:00:00' ? '-' : $item->srv_time;
            $tmp[] = $item->local_time . " " . $item->local_usec / 1000;
            $tmp[] = self::$logDesp[$item->type];
            $newList[] = $tmp;
        }
        return $newList;
    }
}
