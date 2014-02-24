<?php
// Nhung ham chua duoc su dung ==> chua dc test
// Search google thay hay thi copy vao
// Neu co su dung thi copy vao Ishali/Facebook

class Ishali_Apitam
{
    public static function checkPageAdmin($id_page, $page_list)
    {
        foreach ($page_list as $key => $name)
        {
            if ($key == $id_page)
            {
                return true;
            }
        }
        return false;
    }
    
    public static function getCreatePageUrl()
    {
        return 'http://www.facebook.com/pages/create.php?ref_type=sitefooter';
    }
}