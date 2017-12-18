<?php
/**
 * 活动
 *
 * 
 *
 *
 * by cosmos-jack    开发
 */
defined('InCosmos') or exit('Access Invalid!');
class dragonModel{
	/**
	 * 活动列表
	 *
	 * @param array $condition 查询条件
	 * @param obj $page 分页对象
	 * @return array 二维数组
	 */
	public function getList($condition,$page=''){
		$param	= array();
		$param['table']	= 'activity';
		$param['where']	= $this->getCondition($condition);
		$param['order']	= $condition['order'] ? $condition['order'] : 'activity_id';
		return Db::select($param,$page);
	}
	
	//添加赏
	public function addsang($input)
	{
		return Db::insert('dragon_sang',$input);	
	}
	//添加赏日志
	public function addsanglog($input)
	{
		return Db::insert('pd_log',$input);	
	}
	
	
	//添加点赞
	public function adddianzan($input)
	{
		return Db::insert('dragon_dianzan',$input);	
	}
	
	//删除点赞
	public function deldianzan($id)
	{
		//return Db::delete('dragon_dianzan',"hdid =".$id);	
		return Db::delete('dragon_dianzan','did in('.$id.')');
	}
	
	
	//添加我的活动
	public function addHoudong($input)
	{
		return Db::insert('dragon_houdong',$input);	
	}
	//修改我的活动
	public function UpdateHoudong($input,$id)
	{
		return Db::update('dragon_houdong',$input," hdid='$id' ");	
	}
	/**
	 * 删除活动
	 *
	 * @param string $id
	 * @return bool
	 */
	public function delHoudong($id){
		$inputarr=array();
		$inputarr['hd_close']=1;
		return Db::update('dragon_houdong',$inputarr,"hdid in(".$id.")");
	}
	
	
	/**
	 * 活动订单列表
	 *
	 * @param array $condition 查询条件
	 * @param obj $page 分页对象
	 * @return array 二维数组
	 */
	public function get_orderListdragon($condition,$page=''){
		$param	= array();
		$param['table']	= 'dragon_huodong_order';
		$param['where']	= $this->getConditiondragon($condition);
		$param['order']	= $condition['order'] ? $condition['order'] : 'orid';
		return Db::select($param,$page);
	}
	/**
	 * 活动列表
	 *
	 * @param array $condition 查询条件
	 * @param obj $page 分页对象
	 * @return array 二维数组
	 */
	public function getListdragon($condition,$page=''){
		$param	= array();
		$param['table']	= 'dragon_houdong';
		//print_r($condition);
		$param['where']	= $this->getConditiondragon($condition);
		$param['order']	= $condition['order'] ? $condition['order'] : 'hdid';
		return Db::select($param,$page);
	}
	private function getConditiondragon($condition){
		
		//print_r($condition['hd_close']);
		$conditionStr	= '';
		if($condition['hdname']!="")
		{
			$conditionStr=" and hdname like '%".$condition['hdname']."%'";	
		}
		/*if($condition['hdbegintime']!="")
		{
			$conditionStr=$conditionStr." and hdbegintime >=".$condition['hdbegintime'] ;	
		}
		if($condition['hdendtime']!="")
		{
			$conditionStr=$conditionStr." and hdendtime <=".$condition['hdendtime'];	
		}*/
		if($condition['hdbegintime']!="")
		{
			$conditionStr=$conditionStr." and hdaddtime between ".$condition['hdbegintime'].' and '. $condition['hdendtime'];	
		}
		if($condition['hd_close']!="")
		{
			$conditionStr=$conditionStr." and hd_close=0";	
			//echo($conditionStr);
		}
		
		if($condition['orid']!="")
		{
			$conditionStr=$conditionStr." and orid =".$condition['orstate'];	
		}
		
		if($condition['orstate']!="")
		{
			$conditionStr=$conditionStr." and orstate =".$condition['orstate'];	
		}
		
		if(!empty($condition['ortime']))
		{
			$conditionStr=$conditionStr." and ortime between ".$condition['ortime']['startdate']." and ".$condition['ortime']['enddate'] ;	
		}
		
		if($condition['ormembername']!="")
		{
			$conditionStr=$conditionStr." and ormembername like '%".$condition['ormembername']."%'";	
		}
		
		if($condition['article_hot']!='')
		{
			$conditionStr .= " and hdhot=".$condition['article_hot'];	
		}
		if($condition['article_tui']!='')
		{
			$conditionStr .= " and hdtuijian=".$condition['article_tui'];	
		}
		if($condition['shouye']!='')
		{
			$conditionStr .= " and shouye=".$condition['shouye'];	
		}
		return $conditionStr;
	}
	
	//活动下单
	public function addHoudongorder($input)
	{
		return Db::insert('dragon_huodong_order',$input);	
	}
	
	//活动下单
	public function pdlog($input)
	{
		return Db::insert('pd_log',$input);	
	}
	
	//修改我的活动订单
	public function UpdateHoudongOrder($input,$id)
	{
		return Db::update('dragon_huodong_order',$input," orid='$id' ");	
	}
	
	/**
	 * 添加活动
	 *
	 * @param array $input
	 * @return bool
	 */
	public function add($input){
		return Db::insert('activity',$input);
	}
	/**
	 * 更新活动
	 *
	 * @param array $input
	 * @param int $id
	 * @return bool
	 */
	public function update($input,$id){
		return Db::update('activity',$input," activity_id='$id' ");
	}
	/**
	 * 删除活动
	 *
	 * @param string $id
	 * @return bool
	 */
	public function del($id){
		return Db::delete('activity','activity_id in('.$id.')');
	}
	/**
	 * 根据id查询一条活动
	 *
	 * @param int $id 活动id
	 * @return array 一维数组
	 */
	public function getOneById($id){
		return Db::getRow(array('table'=>'activity','field'=>'activity_id','value'=>$id));
	}
	/**
	 * 根据条件
	 *
	 * @param array $condition 查询条件
	 * @param obj $page 分页对象
	 * @return array 二维数组
	 */
	public function getJoinList($condition,$page=''){
		$param	= array();
		$param['table']	= 'activity,activity_detail';
		$param['join_type']	= empty($condition['join_type'])?'right join':$condition['join_type'];
		$param['join_on']	= array('activity.activity_id=activity_detail.activity_id');
		$param['where']	= $this->getCondition($condition);
		$param['order']	= $condition['order'];
		return Db::select($param,$page);
	}
	/**
	 * 构造查询条件
	 *
	 * @param array $condition 条件数组
	 * @return string
	 */
	private function getCondition($condition){
		$conditionStr	= '';
		if($condition['activity_id'] != ''){
			$conditionStr	.= " and activity.activity_id='{$condition['activity_id']}' ";
		}
		if($condition['activity_type'] != ''){
			$conditionStr	.= " and activity.activity_type='{$condition['activity_type']}' ";
		}
		if($condition['activity_state'] != ''){
			$conditionStr	.= " and activity.activity_state = '{$condition['activity_state']}' ";
		}
		//活动删除in
		if(isset($condition['activity_id_in'])){
			if ($condition['activity_id_in'] == ''){
				$conditionStr	.= " and activity_id in('')";
			}else{
				$conditionStr	.= " and activity_id in({$condition['activity_id_in']}) ";
			}
		}
		if($condition['activity_title'] != ''){
			$conditionStr	.= " and activity.activity_title like '%{$condition['activity_title']}%' ";
		}
		//当前时间大于结束时间（过期）
		if ($condition['activity_enddate_greater'] != ''){
			$conditionStr	.= " and activity.activity_end_date < '{$condition['activity_enddate_greater']}'";
		}
		//可删除的活动记录
		if ($condition['activity_enddate_greater_or'] != ''){
			$conditionStr	.= " or activity.activity_end_date < '{$condition['activity_enddate_greater_or']}'";
		}
		//某时间段内正在进行的活动
		if($condition['activity_daterange'] != ''){
			$conditionStr .= " and (activity.activity_end_date >= '{$condition['activity_daterange']['startdate']}' and activity.activity_start_date <= '{$condition['activity_daterange']['enddate']}')";
		}
		if($condition['opening']){//在有效期内、活动状态为开启
			$conditionStr	.= " and (activity.activity_start_date <=".time()." and activity.activity_end_date >= ".time()." and activity.activity_state =1)";
		}
		return $conditionStr;
	}
}