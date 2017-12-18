/**
 * Created by Administrator on 2017/3/8.
 */
/* 编辑商品信息 start */
function goods_edit(e){

    var table_data = $('.dataTables-example').DataTable();
    var data = table_data.row($(e).parent().parent('tr')).data(); // 获取列表
    var goods_id = data['id'];

    window.location.href = 'goods_mod.html?goods_id='+goods_id;

}
/* 编辑商品信息 end */

$(document).ready(function(){
    /* 获取 商品的列表 start */
    $.ajax({
        url: AgentUrl+"/index.php?act=agent_user&op=index",
        type:"GET",
        data:{},
        success:function(msg){
            //alert(JSON.stringify(msg));
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
                    { data: 'id' },
                    { data: 'name' }, //姓名
                    { data: 'role_name' },//角色
                    { data: 'pid_name' },//所属经理
                    { data: 'pid_name' },//所属经理
                    { data: null,
                        "defaultContent":"<a  onclick='goods_edit(this)'><i class='fa fa-edit'></i>编辑</a>&nbsp;<a href='#'><i class='fa fa-trash-o'></i>删除</a>",
                        render:function(){}
                    },//所属经理
                ]
            } );
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

