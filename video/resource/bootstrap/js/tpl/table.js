/**
 * Created by Administrator on 2017/3/22.
 */
var merchant_url = "index.php?op=merchant";

var table_merchant_setting ={
    "ajax": merchant_url + "&extend_op=get",
    "ordering":  false,
    "searching": false,
    "processing": true,
    "serverSide": false, //本地JSON文件要设为false，true会不能分页
    "oLanguage": {
        "sProcessing": "正在加载中......",
        "sLengthMenu": "每页显示 _MENU_ 条记录",
        "sZeroRecords": "正在加载中......",
        "sEmptyTable": "表中无数据存在！",
        "sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
        "sInfoEmpty": "显示0到0条记录",
        "sInfoFiltered": "数据表中共为 _MAX_ 条记录",
        "sSearch": "搜索：",
        "oPaginate": {
            "sFirst": "首页",
            "sPrevious": "上一页",
            "sNext": "下一页",
            "sLast": "末页"
        }
    }
    ,"columns": [
        { "data": "s_id" },        //json文件里的name值
        { "data": "merchant_name" },
        { "data": "type",render: function(data){return data==0?"文本":"多行文本"}},//值得转换  对数据进行函数操作要用render来渲染
        { "mData": "buy_ok_time",render: function(data){return new Date(parseInt(data) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');}},//时间转换
        { "data": null,"defaultContent": "<a class='btn btn-xs btn-info media_right_3' onclick='edit_merchant(this);'>编辑</a>", render: function(){$("[data-toggle='tooltip']").tooltip();}},       //操作栏
    ],
    "order": [[0, "desc" ]],
    "initComplete": function(settings, json){
    //初始化配置执行函数
        $(".yr_ct tr").each(function(){
            al_rec += parseInt($(this).find("td").eq(1).text());
        });
        $(".year_rec").text(al_rec + '元');
    }
}
var table_merchant = $("#data_table_merchant").DataTable(table_merchant_setting);                  //初始化表格

$("#search1").click(function() {  //搜索框
    if($("#search_text").val())
    {
        var sch_knd = $("#title").text();
        var sch_cnt = $("#search_text").val();
        $.get(merchant_url + "&extend_op=orderlist", { kind: sch_knd, cnt: sch_cnt }, function(data){
            table_merchant.ajax.url(merchant_url + "&extend_op=orderlist&" + 'kind=' + sch_knd + '&cnt=' + sch_cnt).load(function(data){
//再次加载时执行的函数
            });                //回调执行重新加载搜索到的内容的地址
        });
    } else {
        layer.alert("请输入你要搜索的信息");
    };
});

function display_add_merchant(){
    $(".add_merchant_div").css("display","block");
    $(".merchant_list").css("display","none");
}
function add_merchant(){
    display_add_merchant();
    $(".add_merchant_div .title").text("添加");
    $(".add_merchant_div .submit").attr("onclick","save_add_merchant();");
};
function save_add_merchant(){
    var data = getFormJson(".add_merchant_form");         //获取form表单数据   class名必须为form标签内的
    $.post(merchant_url + "&extend_op=add",data,function(data){
        if(data.err == "0"){
            table_merchant.ajax.reload();        //重新加载ajax
            layer.alert("添加成功！");
            hidden_add_merchant();
        }else{
            layer.alert(data.msg);
        }
    },"json")
}
function hidden_add_merchant(){
    $(".add_merchant_div").css("display","none");
    $(".merchant_list").css("display","block");
    $(".add_merchant_form")[0].reset();                //填写的表单内容清空
}

function edit_merchant(e){
    display_add_merchant();
    $(".add_merchant_div .title").text("编辑");
    $(".add_merchant_div .submit").attr("onclick","save_edit_merchant();");
    var data = table_merchant.row( $(e).parents('tr') ).data();        //获取本行内容   注意(e)传值
    fillFormJson(".add_merchant_form",data)
}
function save_edit_merchant(e){
    var data = getFormJson(".add_merchant_form");

    $.post(merchant_url + "&extend_op=update",data,function(data){
        if(data.err == "0"){
            layer.alert("编辑成功！");
            hidden_add_merchant();
            table_merchant.ajax.reload();
            hidden_add_merchant();
        }else{
            layer.alert(data.msg);
        }
    },"json")
}

function del_merchant(e){
    layer.alert('确定删除？',function(){
        var data = table_merchant.row( $(e).parents('tr') ).data();

        var id = data.id;
        $.get(merchant_url + "&extend_op=del&id=" + id,function(data){
            if(data.err == "0"){
                layer.alert("删除成功！");
                table_merchant.ajax.reload();
            }else{
                layer.alert(data.msg);
            }
        },"json")
    });
}
//获取表单json数据
function getFormJson(frm) {
    var o = {};
    var a = $(frm).serializeArray();        //序列化表单内容
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
}
//填写表单json数据，填充的那个框标签需是input
function fillFormJson(frm,data) {
    var input = $(frm).find('[name]');
    input.each(function(i,e) {
        $.each(data,function(k,v) {
            if (k == $(e).attr('name')) {
                $(e).val(v);
            };
        })
    })
}
