
<?php

#####################################
//此Controller處理所有有關首頁(index)的事情
#####################################
session_start();  
class indexController extends Controller{
    function index()  //以下變數將作為首頁頁面使用
    {
        if(isset($_SESSION['user']))
        {
            $word='登出';
            $user=$_SESSION['user'];
            $user_photo="<img src='https://job-qwerrtty.c9users.io/project_test2/models/show_image.php?Account="
            .$_SESSION['user']."'style='width:40px;height:40px;float:right;'></img>";
        }
        else 
        {
        	 $word='登入';
        	 $user="遊客";
        }
        $index=$this->model("index");  
        $result=$index->index();     //印出前五項共乘資訊
        
        $data=array("word"=>$word,"user"=>$user,"result"=>$result,
        "photo"=>"models/show_image.php","nickname"=>$index->user_nickname($_SESSION['user']),
        "user_photo"=>$user_photo);
        $this->view("carpool_index.php",$data);
    }
    function allcarpool()  //此function處理「更多共乘資訊」的頁面
    {
        $allcarpool=$this->model("index");
        $result=$allcarpool->allcarpool();
        $data=array(
            "result"=>$result,
            "photo_part1"=>"<img src='https://job-qwerrtty.c9users.io/project_test2/models/show_image.php?Account=",
            "photo_part2"=>"'style='width:50px;height:50px;float:right;'></img>"
            );
        $this->view("carpool_allcarpool.php",$data);
    }
    function search()  //此function處理「搜尋」的頁面
    {
        $search=$this->model("index");
        $result=$search->search();
        $data=array(
            "result"=>$result,
            "photo_part1"=>"<img src='https://job-qwerrtty.c9users.io/project_test2/models/show_image.php?Account=",
            "photo_part2"=>"'style='width:50px;height:50px;float:right;'></img>"
            );
        $this->view("carpool_serch.php",$data);
    }
    function membercarpool()  //此function處理「會員的共乘」的頁面
    {
        if(!isset($_SESSION['user']))
        {
            header("location:../login");
            exit();
        }
        $member=$this->model("index");
        $data=array("result"=>$member->member($_SESSION['user']),"photo"=>"https://job-qwerrtty.c9users.io/project_test2/models/show_image.php");
        $this->view("carpool_member_carpool.php",$data);
    }
    function upload_photo_view()  //此function 處理「上傳大頭貼」的頁面
    {
        if(!isset($_SESSION['user']))
        {
            header("location:../login");
            exit();
        }
        $this->view("upload_photo.php");
    }
    function upload_photo()  //處理上傳大頭照並導回首頁
    {
        $member=$this->model("index");
        $member->upload_photo();
        header("location:../index");
    }
    function modify_data()    //修改會員資料的頁面
    {
        if(!isset($_SESSION['user']))
            header("location:../login");
        $this->view("carpool_modifydata.php");
    }
    function modify_data_update()  //修改會員資料
    {
        if($_POST['Password']=='')
        {
            echo "no"; 
            exit();
        }
     
        $modify=$this->model("index");
        
        $modify->modify_data($_SESSION['user']);
        echo "yes";
        exit();
    }
    function unsetsesson()  //刪除session
    {
        if(isset($_SESSION['user']))
        {
            unset($_SESSION['user']);
            echo ("true");
        }
        else
            echo ("false");
    }
    
}
?>