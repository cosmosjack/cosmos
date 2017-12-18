/**
 * Created by Administrator on 2017/3/8.
 */
function mod_user(e){
    var table_data = $('.dataTables-example').DataTable();
    var data = table_data.row($(e).parent().parent('tr')).data();
    var user_id = data['id'];
    window.location.href = AgentUrl+"/index.php?act=agent_user&op=mod_user&user_id="+user_id;

}

$(document).ready(function(){
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
                "ajax": AgentUrl+"/index.php?act=agent_user&op=index",
                columns: [
                    { data: 'id' },
                    { data: 'name' }, //姓名
                    { data: 'role_name' },//角色
                    { data: 'pid_name' },//所属经理
                    { data: 'area_name' },//区域
                    { data: 'email' },//邮箱
                    { data: 'phone' },//电话
                    //{ data: 'qq' },//QQ
                    //{ data: 'login_time_last' },//上次登录时间
                    { data: 'active' },//活跃度
                    { data: 'point' },//提成点
                    {data:"null","defaultContent":"<a onclick='mod_user(this)'><i class='fa fa-edit'></i>修改</a>",
                        render:function(){}
                    }
                ]
            } );
        },
        error:function(){
            alert('访问失败');
        }
    });


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
