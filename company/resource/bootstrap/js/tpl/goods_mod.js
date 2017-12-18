/**
 * Created by Administrator on 2017/3/22.
 */
$(function(){
    var goods_id=getUrlParam("goods_id");
    if(goods_id !=null && goods_id.toString().length>0)
    {
        goods_id = goods_id;
    }
    $.ajax({
        url:AgentUrl+"/index.php?act=goods&op=mod",
        type:"GET",
        data:{"goods_id":goods_id},
        success:function(msg){
            //alert(JSON.stringify(msg));
            //类型选择
            $("select[name='type']").find("option[value='"+msg['type']+"']").attr('selected',true);
            // 展示图片
            var img_src = UploadUrl+"/agent/"+msg['image'];
            $("#preview").attr("src",img_src);
            // 商品详情
            //$("#editor").text(msg['body']);
           /* var editor = new baidu.editor.ui.Editor({
                textarea:'introduction'
            });
            editor.render("editor");
            editor.setContent("<p>dddddddddddddd</p>");*/
            var ue = UE.getEditor('editor');
            //ue.render('editor');
            ue.ready(function(){
                ue.setContent(msg['content'],false);
            });

            /* 整理数据 start */
            $("input[name='good_name']").val(msg['goods_name']);
            $("input[name='goods_id']").val(msg['id']);
            $("input[name='price']").val(msg['price']);
            $("input[name='num']").val(msg['num']);
            $("input[name='unit']").val(msg['unit']);
            $("input[name='search-text']").val(msg['store_name']);
            $("input[name='store_id']").val(msg['store_id']);
            $("input[name='image_name']").val(msg['image']);
             /* 整理数据 end */

        },
        error:function(){
            alert('请求失败');
        }
    });
    /* 自动搜索 商家 start */
    // alert('ddd');
//取得div层
    var $search = $('#search_logistics');
//取得输入框JQuery对象
    var $searchInput = $search.find('#search-text');
//关闭浏览器提供给输入框的自动完成
    $searchInput.attr('autocomplete','off');
//创建自动完成的下拉列表，用于显示服务器返回的数据,插入在搜索按钮的后面，等显示的时候再调整位置
    var $autocomplete = $('<div class="autocomplete"></div>')
        .hide()
        .insertAfter('#submit');
//清空下拉列表的内容并且隐藏下拉列表区
    var clear = function(){
        $autocomplete.empty().hide();
    };
//注册事件，当输入框失去焦点的时候清空下拉列表并隐藏
    $searchInput.blur(function(){
        setTimeout(clear,500);
    });
//下拉列表中高亮的项目的索引，当显示下拉列表项的时候，移动鼠标或者键盘的上下键就会移动高亮的项目，想百度搜索那样
    var selectedItem = null;
//timeout的ID
    var timeoutid = null;
//设置下拉项的高亮背景
    var setSelectedItem = function(item){
//更新索引变量
        selectedItem = item ;
//按上下键是循环显示的，小于0就置成最大的值，大于最大值就置成0
        if(selectedItem < 0){
            selectedItem = $autocomplete.find('li').length - 1;
        }
        else if(selectedItem > $autocomplete.find('li').length-1 ) {
            selectedItem = 0;
        }
//首先移除其他列表项的高亮背景，然后再高亮当前索引的背景
        $autocomplete.find('li').removeClass('highlight')
            .eq(selectedItem).addClass('highlight');
    };
    var ajax_request = function(){
//ajax服务端通信
        $.ajax({
            'url':AgentUrl+'/index.php?act=goods&op=get_storeinfo', //服务器的地址
            //'url':'http://33hao.net/shop/index.php?act=supplier_agent&op=get_storeinfo',
            'data':{'search-text':$searchInput.val()}, //参数
            'dataType':'jsonp', //返回数据类型
            'type':'GET', //请求类型
            jsonpCallback:"jsonpReturn",
            'success':function(data){
                //alert('ddd');

                if(data.value) {
//遍历data，添加到自动完成区
                    var log_data = data;
                    $.each(data.value, function(index,term) {
                        //alert(index);
                        // alert(term);
                        var i = index;
//创建li标签,添加到下拉列表中
                        $('<li></li>').text(term).appendTo($autocomplete)
                            .addClass('clickable').attr('log_key',log_data['key'][i])
                            .hover(function(){
//下拉列表每一项的事件，鼠标移进去的操作
                                $(this).siblings().removeClass('highlight');
                                $(this).addClass('highlight');
                                selectedItem = index;
                            },function(){
//下拉列表每一项的事件，鼠标离开的操作
                                $(this).removeClass('highlight');
//当鼠标离开时索引置-1，当作标记
                                selectedItem = -1;
                            })
                            .click(function(){
//鼠标单击下拉列表的这一项的话，就将这一项的值添加到输入框中
                                $searchInput.val(term);
                                $searchInput.attr('log_key',log_data['key'][i]);
                                $('#store_id').val(log_data['key'][i]);

//清空并隐藏下拉列表
                                $autocomplete.empty().hide();
                            });
                    });//事件注册完毕
//设置下拉列表的位置，然后显示下拉列表
                    var ypos = $searchInput.position().top;
                    var xpos = $searchInput.position().left;
                    $autocomplete.css('width',$searchInput.css('width'));
                    $autocomplete.css({'position':'relative','left':xpos + "px",'top':0 +"px"});
                    setSelectedItem(0);
//显示下拉列表
                    $autocomplete.show();
                }
            }
        });
    };
//对输入框进行事件注册
    $searchInput
        .keyup(function(event) {
//字母数字，退格，空格
            if(event.keyCode > 40 || event.keyCode == 8 || event.keyCode ==32) {
//首先删除下拉列表中的信息
                $autocomplete.empty().hide();
                clearTimeout(timeoutid);
                timeoutid = setTimeout(ajax_request,100);
            }
            else if(event.keyCode == 38){
//上
//selectedItem = -1 代表鼠标离开
                if(selectedItem == -1){
                    setSelectedItem($autocomplete.find('li').length-1);
                }
                else {
//索引减1
                    setSelectedItem(selectedItem - 1);
                }
                event.preventDefault();
            }
            else if(event.keyCode == 40) {
//下
//selectedItem = -1 代表鼠标离开
                if(selectedItem == -1){
                    setSelectedItem(0);
                }
                else {
//索引加1
                    setSelectedItem(selectedItem + 1);
                }
                event.preventDefault();
            }
        })
        .keypress(function(event){
//enter键
            if(event.keyCode == 13) {
//列表为空或者鼠标离开导致当前没有索引值
                if($autocomplete.find('li').length == 0 || selectedItem == -1) {
                    return;
                }
                $searchInput.val($autocomplete.find('li').eq(selectedItem).text()).attr('log_key',$autocomplete.find('li').eq(selectedItem).attr('log_key'));
                $('#store_id').val($autocomplete.find('li').eq(selectedItem).attr('log_key'));
                $autocomplete.empty().hide();
                event.preventDefault();
            }
        })
        .keydown(function(event){
//esc键
            if(event.keyCode == 27 ) {
                $autocomplete.empty().hide();
                event.preventDefault();
            }
        });
//注册窗口大小改变的事件，重新调整下拉列表的位置
    $(window).resize(function() {
        var ypos = $searchInput.position().top;
        var xpos = $searchInput.position().left;
        $autocomplete.css('width',$searchInput.css('width'));
        $autocomplete.css({'position':'relative','left':xpos + "px",'top':ypos +"px"});
    });
    /* 自动搜索 商家 end */
})
