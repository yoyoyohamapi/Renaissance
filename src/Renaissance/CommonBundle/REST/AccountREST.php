<?php
namespace Renaissance\CommonBundle\REST;
use Renaissance\CommonBundle\REST\REST_Base;

class AccountREST extends BaseREST{
	public function getAccountReports($account_id){
		$this->api = 'accounts/'.$account_id.'/reports';
		$reports = $this->execute();
		return $reports;
	}
	public function getAccounts(){
		$this->api = 'accounts/';
		$accounts = $this->execute();
		return $accounts;
	}
	public function getAccount($account_id){
		$this->api = 'accounts/'.$account_id;
		$account = $this->execute();
		return $account;
	}
	//获取账户直接子账户
	public function getSubAccount($account_id){
		$this->api = 'accounts/'.$account_id.'/sub_accounts';
		$sub_accounts = $this->execute();
		return $sub_accounts;
	}
	//获取账户所有子账户
	public function getAllSubAccount($account_id){
		$this->api = 'accounts/'.$account_id.'/sub_accounts?recursive=true';
		$sub_accounts = $this->execute();
		return $sub_accounts;
	}
	//获取账户中的所以课程
	public function getActiveCoursesInAccount($account_id){
		$this->api = 'accounts/'.$account_id.'/courses';
		$courses = $this->execute();
		return $courses;
	}
	//创建子账户
	public function createSubAccount($account_id, $sub_account_name){
		$this->api = 'accounts/'.$account_id.'/sub_accounts';
		$name = $sub_account_name;
		$this->data_field = array(
			"account"=>$account,
		);
		$this->execute('POST');
	}
}