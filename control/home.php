<?php
class home
{
    public function __construct()
    {
        include_once "model/Db.php"; 
        include_once "load.php";
        include_once "./inc.php";
        $this->db = new Db();
        $this->load = new load();
    }
    public function index()
    {
        $xem["catalog"] = $this->db->query("SELECT * from catalog where parent_id = 1");
        $xem["product"] = $this->db->query("SELECT * from product");
        $this->load->view("header");
        $this->load->view("bar", $xem);
        $this->load->view("main", $xem);
        $this->load->view("footer");
    }
    public function timkiem()
    {
        $this->load->view("header");
        $xem["catalog"] = $this->db->query("SELECT * from catalog where parent_id = 1");
        $this->load->view("bar", $xem);

        if (isset($_POST['tim'])) {
            if(is_string($_POST['tim'])){
                $n =trim($_POST['tim']);
                $xem["product"] = $this->db->query("SELECT * FROM product WHERE name like'%$n%'");
                $this->load->view("main", $xem);
            }
        }
        $this->load->view("footer");
    }
    public function dangnhap()
    {
        unset($_SESSION['name']);

        $xem["user"] = $this->db->query("select * from  user");

        $this->load->view("header");
        $this->load->view("login", $xem);
        $this->load->view("footer");
    }
    public function dangky()
    {
        $xem["user"] = $this->db->query("select * from  user");
        $this->load->view("header");
        $this->load->view("dangky", $xem);
        $this->load->view("footer");
    }
    public function viewuser()
    {
        $xem["user"] = $this->db->query("select * from  user");
        
        $xem["user1"] = $this->db->query("select * from  user where id = ".$_SESSION["idnguoidung"]);
        // $xem["transaction"] = $this->db->query("select * from  transaction ");
        $xem["transaction"] = $this->db->query("select * from  transaction where user_id = ".$_SESSION["idnguoidung"]);

        $this->load->view("header");
        $this->load->view("user");
        $this->load->view("lichsu",$xem);
        $this->load->view("footer");
    }
    public function viewdoiMKUser()
    {
        $xem["user"] = $this->db->query("select * from  user where id = ".$_GET["id"]);
        $this->load->view("header");
        $this->load->view("user");
        $this->load->view("doimkuser",$xem);
        $this->load->view("footer");
    }
    public function doimkuser()
    {
        $n =  $_GET["id"];
        $dieukien = "id = '$n' ";
        $xem["user"] = $this->db->query("select * from  user where id = ".$n);
        $check = true ;

        $passold = md5(postIndex("pass"));
        $passnew = md5(postIndex("newpass"));
        $passnew1 = md5(postIndex("newpass1"));

        // echo $passold;
        // echo "<br>";
        // echo md5(1234);
        // echo "<br>";
        // if($passold == md5(1234)){
        //     echo "dung";
        // }
        // exit;

        if($passold != $xem["user"][0]["password"]){
            $check = false;
            $_SESSION["loidoimk"] = "Sai M???t Kh???u C??? !";
        }
        if($passnew != $passnew1){
            $check = false;
            $_SESSION["loidoimk"] = "M???t Kh???u M???i Kh??ng Tr??ng Kh???p !";
        }
        if($check == true){
            $data = array(
                'password' => $passnew
            );
            $this->db->sua("user",$data,$dieukien);
            $_SESSION["loidoimk"] = "L??u Th??nh C??ng";
        }
        header('location:?url1=viewdoiMKUser&&id='.$n);
    }
    public   function   uuu(){
        $xem["user"] = $this->db->query("select * from  user");
        foreach($xem["user"] as $k => $v){
            if($v["name"] == $_SESSION["name"]){
                $_SESSION["idnguoidung"]  = $v['id'];
            }
        }
        header('location:?url=viewuser');   
    }
    public function user()
    {
        $xem["user"] = $this->db->query("select * from  user");
        
        if (isset($_SESSION["check"])) {
            $created = date('Y/m/d H:i:s ', time());

            $data  = array(
                'name' => $_SESSION["name"],
                'email' => $_SESSION["user_mail"],
                'password' => $_SESSION["user_pass"],
                'phone' => $_SESSION["user_phone"],
                'address' => $_SESSION["user_ar"],
                'created' => $created
            );
            $this->db->them("user", $data);
            unset($_SESSION["check"]);
        }
        header('location:?url1=uuu');
    }

    public function chitiet()
    {
        $xem["product"] = $this->db->query("select * from  product");
        $this->load->view("header");
        if (isset($_SESSION['id_danhmuc'])) {
            unset($_SESSION['id_danhmuc']);
        }

        if (isset($_GET['id'])) {
            foreach ($xem['product'] as $k => $v) {
                if ($_GET['id'] == $v['id']) {
                    $_SESSION['id_danhmuc'] = $v['catalog_id'];
                }
            }
        }
        if (isset($_SESSION['id_danhmuc'])) {
            $xem["catalog"] = $this->db->query("select * from  catalog where id = " . $_SESSION['id_danhmuc'] . "");
            $this->load->view("bar", $xem);
        }


        $this->load->view("chitiet", $xem);
        $this->load->view("footer");
    }
    public function dm()
    { 
        $xem["product1"] = $this->db->query("select * from  product");
        $this->load->view("header");
        if (isset($_GET['id'])) {
            $xem["catalog"] = $this->db->query("select * from  catalog where parent_id = " . $_GET['id']);
            if(count($xem["catalog"])==0){
                $xem["catalog"] = $this->db->query("select * from  catalog where id = " . $_GET['id']);
            }
            foreach($xem["catalog"] as $k=>$v){
                foreach($xem["product1"] as $ka=>$va){
                    if($va['catalog_id'] == $v['id']){
                        $xem['product'][] = $va;
                    }
                }
            }
            $this->load->view("bar", $xem);
        }
        if(isset($xem['product']))
            $this->load->view("main", $xem);

        $this->load->view("footer");
    }
    public function doi()
    {   
        $xem["user"] = $this->db->query("select * from user");
        foreach($xem["user"] as $k => $v){
            if($v["name"] == $_GET["name"]){
                $xem["user"] = $this->db->query("select * from user where id = ".$v["id"]);
            }
        }
        $this->load->view("header");
        $this->load->view("user");
        $this->load->view("doi",$xem);
        $this->load->view("footer");
    }
    public function suaUser()
    {
        $n =  $_GET["id"];
        $dieukien = "id = '$n' ";

        $xem["user"] = $this->db->query("select * from user");
        $xem["user1"] = $this->db->query("select * from user where id = ".$n);

        $check = true;
        unset($_SESSION["loiuser"]);

        $name = postIndex("name");
        $email = postIndex("email");
        $address = postIndex("address");
        $phone = postIndex("phone");
        $created = date('Y/m/d H:i:s ', time());

        //kiem tra dung dinh dang luu
        if($name != $xem["user1"][0]["name"])
        {
            foreach($xem["user"] as $k=>$v){
                if($name == $v["name"]){
                    $_SESSION["loiuser"] = "Tr??ng T??n Ng?????i D??ng";
                    $check = false;
                }
            }
        }
        if($email != $xem["user1"][0]["email"]){
            foreach($xem["user"] as $k=>$v){
                if($email == $v["email"]){
                    $_SESSION["loiuser"] = "Tr??ng Email Ng?????i D??ng";
                    $check = false;
                }
            }
        }
        if(!checksdt($phone)){
            $_SESSION["loiuser"] = "S??? ??i???n tho???i ph???i l?? s??? v?? ????? 10 s???";
            $check = false;
        }
        if(!checkEmail($email)){
            $_SESSION["loiuser"] = "Sai c?? ph??p nh???p l???i email";
            $check = false;
        }

        if($name == $xem["user1"][0]["name"] && $email == $xem["user1"][0]["email"] && $phone ==$xem["user1"][0]["phone"] && $address == $xem["user1"][0]["address"]){
            $_SESSION["loiuser"] = "Ch???n C?? G?? Thay ?????i C???";
            $check = false;
        }
        
        if($check == true){
            

            $data = array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'created' => $created
            );
            
            $this->db->sua("user",$data,$dieukien);
            $_SESSION["loiuser"] = "L??u Th??nh C??ng";
            $_SESSION["name"] = $name;
        }
        header('location:?url1=doi&&name='.$_SESSION["name"]);
    }
    public function gio()
    {
        $this->load->view("header");
        $this->load->view("giohang");
        $this->load->view("footer");
    }
    public function loi()
    {
        echo "<h1>???? x???y ra l???i</h1>";
        echo "<h2>Xin ki???m tra l???i ???????ng d???n</h2>";
    }
    public function dangxuat()
    {
        session_destroy();
        header('location:?url1=index');
    }
}
