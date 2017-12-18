/**
 * Created by Administrator on 2017/3/20.
 */
/* 表单提交 start */
function ajax_form(form_id,act,op,url){
        /*
        form_id  表单ID
        act 控制器
        op 方法
        url 成功后返回地址 './goods_list.html'
         */
    // 整理数据
    var form = new FormData(document.getElementById(form_id));
//             var req = new XMLHttpRequest();
//             req.open("post", "${pageContext.request.contextPath}/public/testupload", false);
//             req.send(form);
    $.ajax({
        url:AgentUrl+"/index.php?act="+act+"&op="+op,
        type:"post",
        data:form,
        processData:false,
        contentType:false,
        success:function(msg){
            //alert(JSON.stringify(msg));
            // window.clearInterval(timer);
            // console.log("over..");
            //alert(url);
            if(msg['state'] == 200){
                window.location.href = url;
            }else{
                console.log(msg);
                alert(msg.msg);
            }
        },
        error:function(e){
            alert("错误！！");
            window.clearInterval(timer);
        }
    });
}
/* 表单提交 end */

/* 图片预览 start */
function setImagePreview(input_img,preview,localImage) {
    /*
    <input id='input_img' />
    <div id='localImage>
        <img id='preview' />
    </div>
     */
    var docObj=document.getElementById(input_img); //input 框

    var imgObjPreview=document.getElementById(preview); //img 展示框
    if(docObj.files && docObj.files[0])
    {
//火狐下，直接设img属性
        imgObjPreview.style.display = 'block';
        imgObjPreview.style.width = '200px';//1rem
        imgObjPreview.style.height = '200px';//1.3rem
//imgObjPreview.src = docObj.files[0].getAsDataURL();

//火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式
        imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);
    }
    else
    {
//IE下，使用滤镜
        docObj.select();
        var imgSrc = document.selection.createRange().text;
        var localImagId = document.getElementById(localImage); //展示图片的div
//必须设置初始大小
        localImagId.style.width = "200px";//1rem
        localImagId.style.height = "200px";//1.3rem
//图片异常的捕捉，防止用户修改后缀来伪造图片
        try{
            localImagId.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
            localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
        }
        catch(e)
        {
            alert("您上传的图片格式不正确，请重新选择!");
            return false;
        }
        imgObjPreview.style.display = 'none';
        document.selection.empty();
    }
    /* 改变后增加 图片个数 start */
   /* var now_img_num = $(".flea_img").length;
    //alert(now_img_num);
    if(now_img_num <= 3){
        // var addItem = $('#Address').clone(true).attr('id', 'NewAddress');
        $(".flea_img").last().after("<div class='flea_img' style='float: left;width: 30%;margin-right: 3%;'><label><input type='file' multiple='multiple' style='display: none;' name='file"+now_img_num+"' id='input_img"+now_img_num+"' value='' onchange='javascript:setImagePreview(\"input_img"+now_img_num+"\",\"preview"+now_img_num+"\",\"localImag"+now_img_num+"\");'> <a style='text-align: center;'> <h3><div id='localImag"+now_img_num+"'><img id='preview"+now_img_num+"' src='../../js/flea/images/add_person.png'  style='margin:0 auto .1rem;display: block; width: 1rem; height: 1.3rem;'></div></h3> <h4>添加图片</h4> <div style='clear:both;'></div> </a> </label> </div>");
    }*/
    /* 改变后增加 图片个数 end */
    return true;
}
/* 图片预览 end */

/* 获取 URL 参数 start */
/* 调用例子
 var flea_id=getUrlParam("flea_id");
 if(flea_id !=null && flea_id.toString().length>0)
 {
 flea_id = flea_id;
 }
 */
function getUrlParam(name){
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;

}
/* 获取 URL 参数 end */