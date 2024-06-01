<?php
session_start();
    include "../ass/model/pdo.php";
    include "model/sanpham.php";
    include "model/danhmuc.php";
    include "model/user.php";
    include "global.php";
    
    $spnew=loadall_sanpham_home();
    $dsdm=loadall_danhmuc();
    $dstop10=loadall_sanpham_top10();
    include "view/header.php";

    if(isset($_GET['act'])&&($_GET['act']!="")){
        $act=$_GET['act'];
        switch($act){
            case 'shop':
                if(isset($_POST['kyw'])&&($_POST['kyw']!="")){
                    $kyw=$_POST['kyw'];
                }else{
                    $kyw="";
                }

                if(isset($_GET['iddm'])&&($_GET['iddm']>0)){
                    $iddm=$_GET['iddm'];     
                }else{
                    $iddm=0;
                }
                
                $dssp = loadall_sanpham($kyw,$iddm);
                $tendm=load_ten_dm($iddm);
                include "view/sanpham.php";
                break;
            case 'sanphamct':
                    if(isset($_GET['idsp'])&&($_GET['idsp']>0)){
                        $id=$_GET['idsp'];  
                        $onesp =loadone_sanpham($id);
                        extract($onesp);
                        $sp_cung_loai = load_sanpham_cungloai($id,$iddm);
                        include "view/sanphamct.php";
                    }else{
                        include "view/home.php";
                    }
                    break;
            case 'contact':
                include "view/contact.php";
                break;
            case 'discount':
                include "view/discount.php";
                break;
            case 'giohang':
                include "view/cart.php";
                break;
            case 'login':
                if(isset($_POST['signup'])&&($_POST['signup'])){
                    $username=$_POST['name'];
                    $email=$_POST['email'];
                    $password=$_POST['password'];
                    insert_user($username,$email,$password);
                    $thongbao = "Đã đăng kí thành công!";
                }
                if(isset($_POST['signin'])&&($_POST['signin'])){
                    $email=$_POST['email'];
                    $pass=$_POST['password'];
                    $check_user = check_user($email,$pass);
                    if(is_array($check_user)){
                        $_SESSION['email'] = $check_user;
                        // $thongbao = "Bạn đã đăng nhập thành công!";
                        header('Location: login.php');
                    }else{
                        $thongbao = "Tài khoản không tồn tại! Vui lòng kiểm tra lại mật khẩu hoặc tài khoản.";
                    }
                }
                include "view/login.php";
                break;
            default: 
                include "view/home.php";
                break;
            }
    }

    include "view/footer.php";
?>
   