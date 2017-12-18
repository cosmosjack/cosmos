/**
 * Created by Administrator on 2017/4/17.
 */
/* 编辑商品信息 start */
function goods_edit(e){

    var table_data = $('.dataTables-example').DataTable();
    var data = table_data.row($(e).parent().parent('tr')).data(); // 获取列表
    var store_id = data['store_id'];
    window.location.href = AgentUrl+'/index.php?act=store&op=show&store_id='+store_id;

}
/* 编辑商品信息 end */

$(document).ready(function(){
    /* 获取 商品的列表 start */
    $.ajax({
        url: AgentUrl+"/index.php?act=store&op=index", //&is_self=1  // 是否显示只显示自己直系管理的店铺 开关
        type:"GET",
        data:{},
        success:function(msg){
            //alert(JSON.stringify(msg));
            //return false;
            /* template.config("escape",false);
             var js_data = document.getElementById('js_data').innerHTML;
             var r = template(js_data,msg);
             $("#tpl_data").append(r);*/
            $('.dataTables-example').DataTable( {
                data: msg,
                //使用对象数组，一定要配置columns，告诉 DataTables 每列对应的属性
                //data 这里是固定不变的，name，position，salary，office 为你数据里对应的属性
                //"ajax": AgentUrl+"/index.php?act=agent_user&op=index",
                columns: [
                    { data: 'store_name' },//店铺名字
                    { data: 'relationship' }, //关系级别
                    { data: 'agent_name' },//代理人名字
                    //{ data: 'store_user' },//联系人
                   /* { data:null,"defaultContent":"<span id='"+ this.a_id+"' value='' class='show_span'><em class='show_em'></em></span>",render:function(e){
                        console.log(e);
                    }},*/
                    { data:null,render:function(e){
                        return "<span  value='' class='show_span'><em style='width:"+ e.point+";' class='show_em' ></em></span>";
                    }},
                    { data: 'store_user_phone' },//电话
                    { data: null,
                        "defaultContent":"<a  onclick='goods_edit(this)'><i class='fa fa-edit'></i>查看详情</a>",
                        render:function(){}
                    },//所属经理
                ]
            } );
            /* 这里是可以根据返回的数据来改变 css 或 js 传值 start */
            var table_data = $('.dataTables-example').DataTable();
            var store_table = $("#store_table_tbody");
            var data = table_data.row($("#store_table_tbody").children('tr').eq(5)).data();

            /* 这里是可以根据返回的数据来改变 css 或 js 传值 start */
        },
        error:function(){
            alert('访问失败');
        }
    });
    /* 获取 商品的列表 start */

    //$(".dataTables-example").dataTable();
    var oTable=$("#editable").dataTable();
    /* oTable.$("td").editable("../example_ajax.php",{"callback":function(sValue,y){
     var aPos=oTable.fnGetPosition(this);
     oTable.fnUpdate(sValue,aPos[0],aPos[1])
     },
     "submitdata":function(value,settings){
     return{
     "row_id":this.parentNode.getAttribute("id"),
     "column":oTable.fnGetPosition(this)[2]}
     },
     "width":"90%","height":"100%"
     })*/
});
function fnClickAddRow(){$("#editable").dataTable().fnAddData(["Custom row","New row","New row","New row","New row"])};

